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
                echo "<td data-column='$column'>$value</td>";
            }
        }
        // Add edit and delete buttons with appropriate onclick events
        echo "<td>";
        echo "<button class='edit-button' onclick=\"editRow('$table', '$rowId')\">Edit</button>";
        echo "<button class='button2' onclick=\"deleteRow('$table', '$rowId')\">Delete</button>";
        echo "</td>";
        echo "</tr>";
    }
    // Add the extra row for inserting a new record
    echo "<tr class='insert-row'>";
    foreach ($rows[0] as $column => $value) {
        if (!is_numeric($column)) {
            if ($column == $table . '_id') { // Exclude the primary key column
                // empty cell
                echo "<td></td>";
            }
            else if ($column == 'last_update') {
                date_default_timezone_set('UTC');
                // Generate the current date and time in UTC
                $currentDateTime = date('Y-m-d H:i:s');
                echo "<td>$currentDateTime</td>";
            }
            else{
                echo "<td><input type='text' name='$column' class='insert-input'></td>";
            }
        }
    }
    echo "<td><button class='button3' onclick=\"insertRow('<?= $table ?>')\">Insert</button></td>";

    echo "</tr>";
    echo "</table>";
}

?>