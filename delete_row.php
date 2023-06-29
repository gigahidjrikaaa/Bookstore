<?php
    require_once('connection.php');

    if (isset($_POST['table']) && isset($_POST['id'])) {
        $table = $_POST['table'];
        $id = $_POST['id'];

        try {
            $sql = "DELETE FROM $table WHERE $table"."_id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            echo "Row deleted successfully.\n" . " ID: " . $id . " Deleted";
        } catch (PDOException $e) {
            echo "Error deleting row: " . $e->getMessage();
        }
    } else {
        echo "Invalid request.";
    }
?>
