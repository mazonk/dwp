<?php 
class RegisterForm {
    public function render($formData, $message) {
        // Display the message directly passed to the form (optional)
        if ($message) {
            echo "<p class='text-red-500'>" . $message . "</p>";
        }
    ?>
    <div class="w-full max-w-xs mx-auto flex flex-col items-center">
        <form class="space-y-4" action="/dwp/register?action=register" method="post">
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
                <input type="date" name="dob" id="dobInput" value="" class="w-full p-2 border border-gray-300 rounded">
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
            <?php
            // Check and display the message from the session
            if (isset($_SESSION['message'])): ?>
                <div class="mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <?php 
                    echo $_SESSION['message']; 
                    unset($_SESSION['message']); // Clear the message after displaying it
                    ?>
                </div>
            <?php endif; ?>
            <div class="flex justify-between space-x-4">
                <input class="text-white font-bold py-2 px-4 rounded-full w-1/2 mt-6 cursor-pointer" 
                style="background: #FADF24;" type="submit" name="registerButton" value="Register" />
                <input class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full w-1/2 mt-6" 
                type="button" name="loginInsteadButton" value="Login instead"
                onclick="window.location.href = '/dwp/login'" />
            </div>
        </form>
    </div>
    <?php
    }
}
?>
