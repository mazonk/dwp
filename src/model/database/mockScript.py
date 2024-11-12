from dotenv import load_dotenv
import os
import mysql.connector
from faker import Faker
import random
from datetime import datetime, timedelta

# Load environment variables from .env file
load_dotenv('dbcon/.env')

db_user = os.getenv("DB_USER")
db_password = os.getenv("DB_PASS")
db_host = os.getenv("DB_HOST")
db_name = os.getenv("DB_NAME")

print(f"User: {db_user}, Password: {db_password}, Host: {db_host}, Database: {db_name}")

# Helper function to establish a DB connection
def get_db_connection():
    return mysql.connector.connect(
        host=db_host,
        user=db_user,
        password=db_password,
        database=db_name
    )

# Helper function to disable/enable foreign key checks
def toggle_foreign_key_checks(cursor, disable=True):
    if disable:
        cursor.execute("SET FOREIGN_KEY_CHECKS = 0")
    else:
        cursor.execute("SET FOREIGN_KEY_CHECKS = 1")

def generate_rooms():
    """Generate 6 rooms for each of 3 venues"""
    with get_db_connection() as db_connection:
        with db_connection.cursor() as cursor:
            # Truncate table
            toggle_foreign_key_checks(cursor, disable=True)
            cursor.execute("TRUNCATE TABLE Room")

            # Generate rooms for each venue
            for venue_id in range(1, 4):  # venueId 1, 2, and 3
                for room_number in range(1, 7):  # 6 rooms per venue
                    room_name = f"{venue_id}{room_number}"

                    query = "INSERT INTO Room (roomNumber, venueId) VALUES (%s, %s)"
                    cursor.execute(query, (room_name, venue_id))
                    
            toggle_foreign_key_checks(cursor, disable=False)

            db_connection.commit()

    print("Rooms for each venue have been inserted.")

def generate_seats():
    """Generate seats for each room based on room type (big or small) for each venue."""
    with get_db_connection() as db_connection:
        with db_connection.cursor() as cursor:
            # Truncate table
            toggle_foreign_key_checks(cursor, disable=True)
            cursor.execute("TRUNCATE TABLE Seat")
            toggle_foreign_key_checks(cursor, disable=False)

            # Define room layouts (big and small)
            big_room_layout = [
                (14, 3),  # 3 rows with 14 seats
                (10, 1),  # 1 row with 10 seats
                (8, 6)    # 6 rows with 8 seats
            ]
            
            small_room_layout = [
                (10, 2),  # 2 rows with 10 seats
                (8, 5)    # 5 rows with 8 seats
            ]
            
            # Room assignments for each venue (1-6 for venue1, 7-12 for venue2, etc.)
            venue_rooms = {
                1: list(range(1, 7)),  # Rooms 1-6 for venue 1
                2: list(range(7, 13)),  # Rooms 7-12 for venue 2
                3: list(range(13, 19))  # Rooms 13-18 for venue 3
            }

            for venue_id, rooms in venue_rooms.items():
                for idx, room_number in enumerate(rooms):
                    # Determine whether the room is big or small (first 3 rooms big, next 3 small)
                    if idx < 3:  # First 3 rooms are big
                        rows = big_room_layout
                    else:  # Last 3 rooms are small
                        rows = small_room_layout
                    
                    # Generate seats for each room
                    seat_id = 1  # Seat ID starts from 1 for each room
                    for row_seat_count, row_count in rows:
                        for _ in range(row_count):  # Generate seats for each row
                            for seat_nr in range(1, row_seat_count + 1):
                                # Insert seat data into the Seat table
                                query = """
                                INSERT INTO Seat (row, seatNr, roomId)
                                VALUES (%s, %s, %s)
                                """
                                cursor.execute(query, (seat_id, seat_nr, room_number))
                            seat_id += 1  # Increment seat ID for the next row

            db_connection.commit()

    print("Seats for each room have been inserted.")

# Method to generate showings
def generate_showings():
    """Generate 21 days of showings, 5 per movie, and associate with venues"""
    faker = Faker()
    today = datetime.today()
    num_days = 21

    with get_db_connection() as db_connection:
        with db_connection.cursor() as cursor:
            # Truncate tables
            toggle_foreign_key_checks(cursor, disable=True)
            cursor.execute("TRUNCATE TABLE Showing")
            cursor.execute("TRUNCATE TABLE VenueShowing")
            toggle_foreign_key_checks(cursor, disable=False)

            # Fetch valid room and movie IDs
            cursor.execute("SELECT roomId FROM Room")
            valid_room_ids = [room[0] for room in cursor.fetchall()]

            cursor.execute("SELECT movieId FROM Movie")
            valid_movie_ids = [movie[0] for movie in cursor.fetchall()]

            # Generate showings for each movie for the next 21 days
            for day_offset in range(num_days):
                showing_date = today + timedelta(days=day_offset)

                for movie_id in valid_movie_ids:
                    for _ in range(5):  # Exactly 5 showings per movie each day
                        showing_hour = random.randint(10, 20)  # Hour between 10 AM and 8 PM
                        showing_minute = random.choice([0, 15, 30, 45])  # Random minutes
                        showing_time = f"{showing_hour:02d}:{showing_minute:02d}:00"

                        room_id = random.choice(valid_room_ids)

                        # Insert into 'Showing'
                        query = """
                        INSERT INTO Showing (showingDate, showingTime, movieId, roomId)
                        VALUES (%s, %s, %s, %s)
                        """
                        cursor.execute(query, (showing_date.date(), showing_time, movie_id, room_id))

                        showing_id = cursor.lastrowid  # Get the last inserted showingId

                        # Insert into the VenueShowing junction table
                        venue_id = random.randint(1, 3)  # Random venueId between 1 and 3
                        venue_showing_query = """
                        INSERT INTO VenueShowing (venueId, showingId)
                        VALUES (%s, %s)
                        """
                        cursor.execute(venue_showing_query, (venue_id, showing_id))

            db_connection.commit()

    print(f"Showings for each movie have been inserted for {num_days} days, with 5 showings per movie each day, and associated records in VenueShowing.")

def generate_bookings():
    """Generate 500 bookings"""
    with get_db_connection() as db_connection:
        with db_connection.cursor() as cursor:
            # Truncate table
            toggle_foreign_key_checks(cursor, disable=True)
            cursor.execute("TRUNCATE TABLE Booking")
            toggle_foreign_key_checks(cursor, disable=False)

            # Fetch valid userIds
            cursor.execute("SELECT userId FROM User")
            valid_user_ids = [user[0] for user in cursor.fetchall()]

            # Possible statuses
            statuses = ["confirmed", "pending", "cancelled"]
            weights = [0.95, 0.02, 0.03]  # Corresponding weights for confirmed, pending, cancelled status appearance

            # Generate 400 bookings
            for _ in range(400):
                user_id = random.choice(valid_user_ids)  # Pick a random user
                status = random.choices(statuses, weights=weights, k=1)[0]

                # Insert booking
                query = """
                INSERT INTO Booking (userId, status) 
                VALUES (%s, %s)
                """
                cursor.execute(query, (user_id, status))

            db_connection.commit()

    print("400 bookings have been generated.")

# Method to generate tickets
import random
from collections import defaultdict

def generate_tickets():
    """Generate mock data for tickets."""
    with get_db_connection() as db_connection:
        with db_connection.cursor() as cursor:

            # Truncate the Ticket table
            toggle_foreign_key_checks(cursor, disable=True)
            cursor.execute("TRUNCATE TABLE Ticket")
            toggle_foreign_key_checks(cursor, disable=False)

            # Fetch valid showingId and bookingId values
            cursor.execute("SELECT showingId, roomId FROM Showing")
            showing_rooms = cursor.fetchall()  # [(showingId, roomId), ...]

            cursor.execute("SELECT bookingId FROM Booking")
            valid_booking_ids = [booking[0] for booking in cursor.fetchall()]

            # Fetch all seatIds and group them by roomId
            cursor.execute("SELECT seatId, roomId FROM Seat")
            seats_by_room = defaultdict(list)
            for seat_id, room_id in cursor.fetchall():
                seats_by_room[room_id].append(seat_id)

            ticket_count = 0

            # Ensure each showingId appears between 15-30 times
            for showing_id, room_id in showing_rooms:
                num_tickets_for_showing = random.randint(20, 50)
                for _ in range(num_tickets_for_showing):
                    booking_id = random.choice(valid_booking_ids)
                    seat_id = random.choice(seats_by_room[room_id])
                    ticket_type_id = random.randint(1, 3)

                    query = """
                    INSERT INTO Ticket (seatId, ticketTypeId, showingId, bookingId)
                    VALUES (%s, %s, %s, %s)
                    """
                    cursor.execute(query, (seat_id, ticket_type_id, showing_id, booking_id))
                    ticket_count += 1

            # Additional random tickets for each booking, ensuring 1-6 tickets per booking
            for booking_id in valid_booking_ids:
                num_tickets = random.randint(1, 6)
                showing_id = random.choice([sr[0] for sr in showing_rooms])

                # Select seats for the room associated with the showing
                room_id_for_showing = next(room_id for show, room_id in showing_rooms if show == showing_id)
                valid_seat_ids_for_showing = seats_by_room[room_id_for_showing]

                for _ in range(num_tickets):
                    seat_id = random.choice(valid_seat_ids_for_showing)
                    ticket_type_id = random.randint(1, 3)

                    query = """
                    INSERT INTO Ticket (seatId, ticketTypeId, showingId, bookingId)
                    VALUES (%s, %s, %s, %s)
                    """
                    cursor.execute(query, (seat_id, ticket_type_id, showing_id, booking_id))
                    ticket_count += 1

            db_connection.commit()

    print(f"{ticket_count} tickets have been inserted.")


# Call the function when the file is run
if __name__ == "__main__":
    generate_rooms()
    generate_seats()
    generate_showings()
    generate_bookings()
    generate_tickets()