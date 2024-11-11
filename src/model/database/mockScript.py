import mysql.connector
from faker import Faker
import random
from datetime import datetime, timedelta

faker = Faker()

# Set up db connection
db_connection = mysql.connector.connect(
    host="localhost", 
    user="andriska",
    password="123456",
    database="Cinema"
)

cursor = db_connection.cursor()

# Disable foreign key checks (so tables can be truncated)
cursor.execute("SET FOREIGN_KEY_CHECKS = 0")

cursor.execute("TRUNCATE TABLE Showing")
cursor.execute("TRUNCATE TABLE VenueShowing")

# Re-enable foreign key checks
cursor.execute("SET FOREIGN_KEY_CHECKS = 1")

# Number of days to generate showings for (3 weeks of showings)
num_days = 21  # 21 days range
today = datetime.today()

# Fetch valid room IDs from the Room table
cursor.execute("SELECT roomId FROM Room")
valid_room_ids = [room[0] for room in cursor.fetchall()]

# Fetch valid movie IDs from the Movie table
cursor.execute("SELECT movieId FROM Movie")
valid_movie_ids = [movie[0] for movie in cursor.fetchall()]

# Generate showings for each movie for each of the next 21 days
for day_offset in range(num_days):
    # Generate the random date for this day
    showing_date = today + timedelta(days=day_offset)

    for movie_id in valid_movie_ids:
        num_showings = 5  # Exactly 5 showings per movie each day

        for showing_num in range(num_showings):
            # Generate a random showing time between 10:00 AM and 8:00 PM
            # Generate a random hour between 10 and 20, then a random minute
            showing_hour = random.randint(10, 20)  # Hour between 10 AM and 8 PM
            showing_minute = random.choice([0, 15, 30, 45])  # Minutes can be 0, 15, 30, or 45
            showing_time = f"{showing_hour:02d}:{showing_minute:02d}:00"

            # Randomly pick a valid room ID from the list of valid room IDs
            room_id = random.choice(valid_room_ids)

            # SQL query to insert mock data into 'showing'
            query = """
            INSERT INTO Showing (showingDate, showingTime, movieId, roomId)
            VALUES (%s, %s, %s, %s)
            """
            
            # Execute the query with generated values
            cursor.execute(query, (showing_date.date(), showing_time, movie_id, room_id))

            # Fetch the last inserted showingId (assuming it's auto-incremented)
            showing_id = cursor.lastrowid

            # Randomly pick a venueId between 1 and 3
            venue_id = random.randint(1, 3)

            # Insert into the VenueShowing junction table
            venue_showing_query = """
            INSERT INTO VenueShowing (venueId, showingId)
            VALUES (%s, %s)
            """
            cursor.execute(venue_showing_query, (venue_id, showing_id))

# Commit the changes to the database
db_connection.commit()

# Close db con
cursor.close()
db_connection.close()

print(f"Showings for each movie have been inserted for {num_days} days, with 5 showings per movie each day, and associated records in VenueShowing.")