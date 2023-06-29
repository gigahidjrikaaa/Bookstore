<?php
require_once('connection.php');

if (isset($_POST['table']) && isset($_POST['id']) && isset($_POST['updatedData'])) {
    $table = $_POST['table'];
    $id = $_POST['id'];
    $updatedData = $_POST['updatedData'];

    try {
         // Start the transaction
         $pdo->beginTransaction();

        // Build the UPDATE query
        $columns = array_keys($updatedData);
        $placeholders = implode(' = ?, ', $columns) . ' = ?';

        // if values are null, set them to default
        foreach ($updatedData as $column => $value) {
            if ($value == null)
            {
                $updatedData[$column] = '0';
            }
            // Sanitize the data input to prevent SQL injection
            $updatedData[$column] = htmlspecialchars($updatedData[$column]);
        }

        // Append the ID to the values array
        $values = array_values($updatedData);
        $values[] = $id;

        $sql = "UPDATE $table SET $placeholders WHERE {$table}_id = ?";
        $stmt = $pdo->prepare($sql);

        // Bind the parameter values
        $stmt->execute($values);

        // Commit the transaction
        $pdo->commit();

        echo "Row updated successfully.\n" . "ID: " . $id . " Updated.\n" . "COMMITED TRANSACTION";
    } catch (PDOException $e) {
        
        // Rollback the transaction in case of an error
        $pdo->rollback();

        echo "Error updating row: " . $e->getMessage();
        echo "\n\nID: " . $id . " Not Updated\n" . "ROLLBACK TRANSACTION";

    }
} else {
    echo "Invalid request.";
}
?>
