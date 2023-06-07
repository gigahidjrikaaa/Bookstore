<?php
// Database connection parameters
$host = '20.121.18.251';
$dbname = 'bookstore';
$username = 'postgres';
$password = '123';

try {
    // Connect to PostgreSQL
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Display error message
    echo 'Connection failed: ' . $e->getMessage();
}

function printTable($rows, $tablename){
    echo "<table>";
    echo "<tr>";
    // print the table headers
    foreach($rows[0] as $key => $value){
        // if column name is not number, print it
        if (!is_numeric($key))
            echo "<th>$key</th>";
    }
    // add an extra column for delete button
    echo "<th>DELETE</th>";
    // add an extra column for update button
    echo "<th>EDIT</th>";
    echo "</tr>";
    // print the rows
    foreach($rows as $row){
        echo "<tr>";
        foreach($row as $key => $value){
            // if column name is not number, print it
            if (!is_numeric($key))
                echo "<td>$value</td>";
        }
        // add a delete button
        echo '<td><button class="button2" data-row-id="' . $row[0] . '">Delete</button></td>';
        echo "</tr>";
        // add an edit button
        echo '<td><button class="button2" data-row-id="' . $row[0] . '">Edit</button></td>';
        echo "</tr>";
    }
    // Add a row for inserting new row
    echo "<tr>";
    echo '<form id="insert-form" action="insert_row.php" method="POST">';
    foreach($rows[0] as $key => $value){
        // if column name is not number, print it
        if (!is_numeric($key))
        {
            // Get the submitted value if it exists
            $submittedValue = isset($_POST[$key]) ? $_POST[$key] : '';

            //if column name is last_update, don't give user the option to insert
            if ($key == 'last_update')
                echo '<td></td>';
            else
                echo '<td><input type="text" name="' . $key . '" value="' . $submittedValue . '"></td>';
        }
    }
    // add an insert button
    echo '<td><button type="submit" class="button2" id="insert-btn">Insert</button></td>';
    echo '</form>';
    echo "</tr>";
    echo "</table>";
}

function deleteRow($tablename, $column, $rowId){
    global $pdo;
    try{
        $sql = "DELETE FROM $tablename WHERE $column = $rowId";
        $result = $pdo->query($sql);
        if ($result) {
            echo "Row deleted successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $pdo->errorInfo()[2];
        }
    }
    catch(PDOException $e){
        echo $e->getMessage();
    }
}

?>