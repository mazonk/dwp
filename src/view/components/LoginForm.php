class LoginForm {
    public function render(array $formData = [], array $errors = []): void {
        ?>
        <div class="w-full max-w-xs mx-auto flex flex-col ">
        <form method="POST" action="<?php echo $_SESSION['baseRoute']; ?>login?action=login&redirect=<?php echo urlencode($_GET['redirect'] ?? 'home'); ?>">
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

                <div class="flex flex-col items-center w-full">
                <?php if (isset($errors['general'])): ?>
                        <p class='text-red-500 mt-2'><?= $errors['general'] ?></p>
                    <?php endif; ?>
                    <input class="text-white font-bold py-2 px-4 rounded text-center w-full mt-4 cursor-pointer" 
                        style="background: #FADF24;" type="submit" name="loginButton" value="Login" />
                    <p class="mt-2 -mb-4 text-gray-500"> Don't have an account yet? <a class="underline text-blue-700" href="<?php echo $_SESSION['baseRoute'] ?>register">Sign up</p>
                </div>
            </form>
        </div>
        <?php
    }
}
?>