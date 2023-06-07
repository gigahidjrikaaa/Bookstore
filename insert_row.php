<?php
    require_once('connection.php');

    $table = $_POST['table'];
    $values = $_POST['values'];
    
    echo $table;
    echo $values;

    if (isset($_POST['table']) && isset($_POST['values'])) {
        $table = $_POST['table'];
        $values = $_POST['values'];

        // Debugging: Print the received values
        echo "Table: $table<br>";
        echo "Values: ";
        print_r($values);
        echo "<br>";

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
