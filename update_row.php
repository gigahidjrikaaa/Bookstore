<?php
require_once('connection.php');

if (isset($_POST['table']) && isset($_POST['id']) && isset($_POST['updatedData'])) {
    $table = $_POST['table'];
    $id = $_POST['id'];
    $updatedData = $_POST['updatedData'];

    try {
        // Build the UPDATE query
        $columns = array_keys($updatedData);
        $placeholders = implode(' = ?, ', $columns) . ' = ?';

        // Append the ID to the values array
        $values = array_values($updatedData);
        $values[] = $id;

        $sql = "UPDATE $table SET $placeholders WHERE {$table}_id = ?";
        $stmt = $pdo->prepare($sql);

        // Bind the parameter values
        $stmt->execute($values);

        echo "Row updated successfully.\n" . "ID: " . $id . " Updated.";
    } catch (PDOException $e) {
        echo "Error updating row: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>
