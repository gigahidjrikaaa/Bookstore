<?php
    require_once('connection.php');

    if (isset($_POST['table']) && isset($_POST['values'])) {
        $table = $_POST['table'];
        $values = $_POST['values'];

        try {
            $sql = "INSERT INTO $table VALUES ($values)";
            $pdo->exec($sql);

            echo "Row inserted successfully.";
        } catch (PDOException $e) {
            echo "Error inserting row: " . $e->getMessage();
        }
    } else {
        echo "Invalid request.";
    }
?>
