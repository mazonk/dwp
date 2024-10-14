<?php 
require_once 'session_config.php';

echo "Welcome " . $_SESSION['userId'];
echo "<br>";
echo "SessionId: " . $_SESSION['session_userId'];
echo "<br>";
echo "Last Regeneration: " . $_SESSION['lastRegeneration'];
echo "<br>";
echo 'This is the landing page';

?>
<html>
    <body>
        <h1>Hello World!! WE ROCK</h1>

        <h2>Testing some stuff here:</h2>

        <form action="/dwp/logout" method="post">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">Logout</button>
        </form>
    </body>
</html>