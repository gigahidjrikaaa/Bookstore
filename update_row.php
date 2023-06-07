<?php
// update_row.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the table, id, and updated data from the request
    $table = $_POST['table'];
    $id = $_POST['id'];
    $updatedData = $_POST['updatedData'];

    // Perform the database update
    require_once('connection.php'); // Include the database connection

    try {
        // Construct the SQL query based on the updated data
        $updates = array();
        foreach ($updatedData as $column => $value) {
            $updates[] = "$column = '$value'";
        }
        $updatesString = implode(', ', $updates);

        $sql = "UPDATE $table SET $updatesString WHERE $table"."_id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        echo "Row updated successfully.";
    } catch (PDOException $e) {
        echo "Error updating row: " . $e->getMessage();
    }

    // Close the database connection
    unset($pdo);
} else {
    echo "Invalid request.";
}
?>
