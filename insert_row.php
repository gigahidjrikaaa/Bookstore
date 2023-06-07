<?php
require_once('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['rowId']) && isset($_POST['updateData'])) {
        $rowId = $_POST['rowId'];
        $updateData = $_POST['updateData'];
        $tablename = $_COOKIE['table'];

        // Prepare the update query
        $setStatements = [];
        $values = [];
        foreach ($updateData as $column => $value) {
            $setStatements[] = "$column = :$column";
            $values[":$column"] = $value;
        }
        $setString = implode(', ', $setStatements);

        

        try {
            // Update the row in the database
            $sql = "UPDATE $tablename SET $setString WHERE id = :rowId";
            $statement = $pdo->prepare($sql);
            $values[':rowId'] = $rowId;
            $statement->execute($values);

            $rowCount = $statement->rowCount();
            if ($rowCount > 0) {
                echo 'Row updated successfully.';
            } else {
                echo 'No rows were updated.';
            }
        } catch (PDOException $e) {
            echo 'Error updating row: ' . $e->getMessage();
        }
    } else {
        echo 'Invalid request.';
    }
} else {
    echo 'Invalid request method.';
}
