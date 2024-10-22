<?php 
class RegisterForm {
    public function render(array $formData, array $errors): void {
        // Display the message directly passed to the form (optional)
        ?>
        <div class="w-full max-w-xs mx-auto flex flex-col items-center">
            <form class="space-y-2" action="/dwp/register?action=register" method="post">
                <div>
                    <label for="firstName">First name:</label>
                    <input type="text" name="firstName" id="firstNameInput" 
                           value="<?= htmlspecialchars($formData['firstName'] ?? '') ?>" 
                           maxlength="50" 
                           class="w-full p-2 border border-gray-300 rounded <?= isset($errors['firstName']) ? 'border-red-500' : '' ?>">
                    <?php if (isset($errors['firstName'])): ?>
                        <p class="text-red-500 text-xs"><?= $errors['firstName'] ?></p>
                    <?php endif; ?>
                </div>
                <div>
                    <label for="lastName">Last name:</label>
                    <input type="text" name="lastName" id="lastNameInput" 
                           value="<?= htmlspecialchars($formData['lastName'] ?? '') ?>" 
                           maxlength="50" 
                           class="w-full p-2 border border-gray-300 rounded <?= isset($errors['lastName']) ? 'border-red-500' : '' ?>">
                    <?php if (isset($errors['lastName'])): ?>
                        <p class="text-red-500 text-xs"><?= $errors['lastName'] ?></p>
                    <?php endif; ?>
                </div>
                <div>
                    <label for="dob">Date of birth:</label>
                    <input type="date" name="dob" id="dobInput"
                           value="<?= htmlspecialchars($formData['dob'] ?? '') ?>" 
                           class="w-full p-2 border border-gray-300 rounded <?= isset($errors['dob']) ? 'border-red-500' : '' ?>">
                    <?php if (isset($errors['dob'])): ?>
                        <p class="text-red-500 text-xs"><?= $errors['dob'] ?></p>
                    <?php endif; ?>
                </div>
                <div>
                    <label for="email">Email:</label>
                    <input type="text" name="email" id="emailInput" 
                           value="<?= htmlspecialchars($formData['email'] ?? '') ?>" 
                           maxlength="50" 
                           class="w-full p-2 border border-gray-300 rounded <?= isset($errors['email']) ? 'border-red-500' : '' ?>">
                    <?php if (isset($errors['email'])): ?>
                        <p class="text-red-500 text-xs"><?= $errors['email'] ?></p>
                    <?php endif; ?>
                </div>
                <div>
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="passwordInput" 
                           value="" 
                           maxlength="50" 
                           class="w-full p-2 border border-gray-300 rounded <?= isset($errors['password']) ? 'border-red-500' : '' ?>">
                    <?php if (isset($errors['password'])): ?>
                        <p class="text-red-500 text-xs"><?= $errors['password'] ?></p>
                    <?php endif; ?>
                </div>
                <div>
                    <label for="confirmPassword">Confirm password:</label>
                    <input type="password" name="confirmPassword" id="confirmPasswordInput" 
                           value="" 
                           maxlength="50" 
                           class="w-full p-2 border border-gray-300 rounded <?= isset($errors['password']) ? 'border-red-500' : '' ?>">
                    <?php if (isset($errors['password'])): ?>
                        <p class="text-red-500 text-xs"><?= $errors['password'] ?></p>
                    <?php endif; ?>
                </div>

                <div class="flex flex-col items-center w-full">
                    <input class="text-white font-bold py-2 px-4 rounded text-center w-full mt-4 cursor-pointer" 
                           style="background: #FADF24;" type="submit" name="registerButton" value="Sign up" />
                    <p class="mt-2 -mb-4 text-gray-500"> Already have an account? <a class="underline text-blue-700" href="<?php echo $_SESSION['baseRoute'] ?>login">Log in</></p>
                </div>
            </form>
        </div>
        <?php
    }
}
?>
