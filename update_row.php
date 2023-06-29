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
        foreach ($updatedData as $column => $value) {;
            // if column name is last_update, set it to the current timestamp in the format YYYY-MM-DD HH:MM:SS
            if ($column == 'last_update') {
                $value = "CURRENT_TIMESTAMP";
            //! for some reason, last_update is null. This is a temporary fix. 
            } else if ($column == 'null') {
                $column = 'last_update';
                $value = "CURRENT_TIMESTAMP";
            }
            else {
                $value = $value !== null ? "'" . trim($value) . "'" : "null";
            }
            $updates[] = "$column = $value";
        }
        $updatesString = implode(', ', $updates);
        // if there is a null value, set it to null
        $updatesString = str_replace("''", "null", $updatesString);

        $sql = "UPDATE $table SET $updatesString WHERE $table"."_id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        echo "Row updated successfully.";
        // Reload the page
        header("Refresh:0");
    } catch (PDOException $e) {
        echo "Error updating row: " . $e->getMessage();
    }

    // Close the database connection
    unset($pdo);
} else {
    echo "Invalid request.";
}
?>
