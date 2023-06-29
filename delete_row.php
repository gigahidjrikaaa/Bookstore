<?php
    require_once('connection.php');

    if (isset($_POST['table']) && isset($_POST['id'])) {
        $table = $_POST['table'];
        $id = $_POST['id'];

        try {
            // Start the transaction
            $pdo->beginTransaction();
            
            $sql = "DELETE FROM $table WHERE $table"."_id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            // Commit the transaction
            $pdo->commit();

            echo "Row deleted successfully.\n" . "ID: " . $id . " Deleted\n" . "COMMITED TRANSACTION";
        } catch (PDOException $e) {
            // Rollback the transaction in case of an error
            $pdo->rollback();

            echo "Error deleting row: " . $e->getMessage();
            echo "\n\nID: " . $id . " Not Deleted\n" . "ROLLBACK TRANSACTION";
        }
    } else {
        echo "Invalid request.";
    }
?>
