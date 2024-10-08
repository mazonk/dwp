<?php echo 'This is the landing page';
?>
<html>
    <body>
        <h1>Hello World!! WE ROCK</h1>
        <?php
        require("src/data_layer/dbcon/dbcon.php");
        $query = $db->prepare("SELECT * FROM Actor");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $row) {
            echo "Test actor is called: " . $row['firstName'] . " " . $row['lastName'] . " and plays: " . $row['character'] . "." . "<br>";
        }
        ?>
    </body>
</html>