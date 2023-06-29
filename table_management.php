<?php
require_once('connection.php');
function printTable($rows, $table) {
    echo "<table>";
    // Print table headers
    echo "<tr>";
    foreach ($rows[0] as $column => $value) {
        // if column name is not number, print it
        if (!is_numeric($column)) {
            echo "<th>$column</th>";
        }
    }
    echo "<th>Actions</th>"; // Additional column for actions
    echo "</tr>";
    // Print table rows
    foreach ($rows as $row) {
        // Add a unique identifier to each row
        $rowId = $row[$table . '_id'];
        echo "<tr id='$table-$rowId'>";
        foreach ($row as $column => $value) {
            // if column name is not number, print it
            if (!is_numeric($column)) {
                echo "<td>$value</td>";
            }
        }
        // Add edit and delete buttons with appropriate onclick events
        echo "<td>";
        echo "<button class='edit-button' onclick=\"editRow('$table', '$rowId')\">Edit</button>";
        echo "<button onclick=\"deleteRow('$table', '$rowId')\">Delete</button>";
        echo "</td>";
        echo "</tr>";
    }
    // Add the extra row for inserting a new record
    echo "<tr>";
    foreach ($rows[0] as $column => $value) {
        if (!is_numeric($column)) {
            echo "<td><input type='text' name='$column' class='insert-input'></td>";
        }
    }
    echo "<td><button class='insert-button' onclick=\"insertRow('$table')\">Insert</button></td>";
    echo "</tr>";
    echo "</table>";
}


// function printTable($rows, $tablename){
//     echo "<table>";
//     echo "<tr>";
//     // print the table headers
//     foreach($rows[0] as $key => $value){
//         // if column name is not number, print it
//         if (!is_numeric($key))
//             echo "<th>$key</th>";
//     }
//     // add an extra column for delete button
//     echo "<th>DELETE</th>";
//     // add an extra column for update button
//     echo "<th>EDIT</th>";
//     echo "</tr>";
//     // print the rows
//     foreach($rows as $row){
//         echo "<tr>";
//         foreach($row as $key => $value){
//             // if column name is not number, print it
//             if (!is_numeric($key))
//                 echo "<td>$value</td>";
//         }
//         // add a delete button
//         echo '<td><button class="button2" data-row-id="' . $row[0] . '">Delete</button></td>';
//         // add an edit button
//         echo '<td><button class="button3" data-row-id="' . $row[0] . '">Edit</button></td>';
//         echo "</tr>";
//     }
//     // Add a row for inserting new row
//     echo "<tr>";
//     echo '<form id="insert-form" action="insert_row.php" method="POST">';
//     foreach($rows[0] as $key => $value){
//         // if column name is not number, print it
//         if (!is_numeric($key))
//         {
//             // Get the submitted value if it exists
//             $submittedValue = isset($_POST[$key]) ? $_POST[$key] : '';

//             //if column name is last_update, don't give user the option to insert
//             if ($key == 'last_update')
//                 echo '<td></td>';
//             else
//                 echo '<td><input type="text" name="' . $key . '" value="' . $submittedValue . '"></td>';
//         }
//     }
//     // add an insert button
//     echo '<td><button type="submit" class="button2" id="insert-btn">Insert</button></td>';
//     echo '</form>';
//     echo "</tr>";
//     echo "</table>";
// }

// function deleteRow($tablename, $column, $rowId){
//     global $pdo;
//     try{
//         $sql = "DELETE FROM $tablename WHERE $column = $rowId";
//         $result = $pdo->query($sql);
//         if ($result) {
//             echo "Row deleted successfully.";
//         } else {
//             echo "Error: " . $sql . "<br>" . $pdo->errorInfo()[2];
//         }
//     }
//     catch(PDOException $e){
//         echo $e->getMessage();
//     }
// }

?>