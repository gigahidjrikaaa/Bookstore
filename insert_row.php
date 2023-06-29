<?php
require_once('connection.php');

if (isset($_POST['table']) && isset($_POST['data'])) {
    $table = $_POST['table'];
    $data = json_decode($_POST['data'], true); // Decode JSON into an associative array

    echo "Table: $table\n";
    echo "Data: ";
    print_r($data); // Print the decoded data for debugging
    echo "\n";

    try {
        // Prepare the column names and placeholders
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        // if values are null, set them to default 
        foreach ($data as $column => $value) {
            if ($value == null)
            {
                $data[$column] = '0';
            }
        }

        // Add the last_update column and value
        $columns .= ', last_update';
        $placeholders .= ', CURRENT_TIMESTAMP';

        // For debugging
        // echo "Columns: $columns<br>";
        // echo "Placeholders: $placeholders<br>";

        // Build the INSERT query
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $pdo->prepare($sql);

        // Bind the parameter values
        foreach ($data as $column => $value) {
            $stmt->bindValue(':' . $column, $value);
        }

        // Execute the query
        $stmt->execute();

        echo "Row inserted successfully.\n" . "ID: " . $pdo->lastInsertId() . " Inserted."; 
    } catch (PDOException $e) {
        echo "Error inserting row: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>
