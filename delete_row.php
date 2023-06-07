<?php
require_once "connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the row ID from the AJAX request
    $rowId = $_POST['rowId'];

    // Get table name from cookie
    $tablename = $_COOKIE['table'];

    // assign column name based on table name
    if ($tablename == 'addresses') {
        $column = 'address_id';
    } else if ($tablename == 'authors') {
        $column = 'author_id';
    } else if ($tablename == 'books') {
        $column = 'book_id';
    } else if ($tablename == 'customers') {
        $column = 'customer_id';
    } else if ($tablename == 'genres') {
        $column = 'genre_id';
    } else if ($tablename == 'payments') {
        $column = 'payment_id';
    } else if ($tablename == 'inventory') {
        $column = 'inventory_id';
    } else if ($tablename == 'purchases') {
        $column = 'purchase_id';
    } else if ($tablename == 'staff') {
        $column = 'staff_id';
    } else if ($tablename == 'stores') {
        $column = 'store_id';
    }

    // Prepare and execute the SQL query to delete the row from the database
    $sql = "DELETE FROM $tablename WHERE $column = :rowId";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':rowId', $rowId);
        $stmt->execute();

        // Check the affected rows to determine if the deletion was successful
        $rowCount = $stmt->rowCount();
        if ($rowCount > 0) {
            echo "Row deleted successfully.";
        } else {
            echo "No rows deleted.";
        }
    } catch (PDOException $e) {
        echo "Error deleting row: " . $e->getMessage();
    }
}
?>