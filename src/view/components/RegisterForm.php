<html>
    <body>
        <head>
            <script src="https://cdn.tailwindcss.com"></script>
        </head>
        <div class="w-full max-w-xs mx-auto flex flex-col items-center">
            <form class="space-y-4"
            action="/dwp/register?action=register" method="post">
                <div>
                    <label for="firstName">First name:</label>
                    <input type="text" name="firstName" id="firstNameInput" value="" maxlength="50" class="w-full p-2 border border-gray-300 rounded">
                </div>
                <div>
                    <label for="lastName">Last name:</label>
                    <input type="text" name="lastName" id="lastNameInput" value="" maxlength="50" class="w-full p-2 border border-gray-300 rounded">
                </div>
                <div>
                    <label for="dob">Date of birth:</label>
                    <input type="date" name="dob" id="dobInput" value="" maxlength="50" class="w-full p-2 border border-gray-300 rounded">
                </div>
                <div>
                    <label for="email">Email:</label>
                    <input type="text" name="email" id="emailInput" value="" maxlength="50" class="w-full p-2 border border-gray-300 rounded">
                </div>
                <div>
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="passwordInput" value="" maxlength="50" class="w-full p-2 border border-gray-300 rounded">
                </div>
                <div>
                    <label for="confirmPassword">Confirm password:</label>
                    <input type="password" name="confirmPassword" id="confirmPasswordInput" value="" maxlength="50" class="w-full p-2 border border-gray-300 rounded">
                </div>
                <div class="flex justify-between space-x-4">
                    <input class="text-white font-bold py-2 px-4 rounded-full w-1/2 mt-6 cursor-pointer" 
                    style="background: #FADF24;" type="submit" name="loginButton" value="Register" />
                    <input class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full w-1/2 mt-6" 
                    type="button" name="registerButton" value="Login instead"
                    onclick="window.location.href = '/dwp/register'" />
                </div>
            </form>
            <?php
                // Display the message if set
                if (!empty($message)) {
                    echo "<p class='text-red-500'>" . $message . "</p>";
                }
            ?>
        </div>
    </body>
</html>