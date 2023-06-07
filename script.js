$(document).ready(function() {
    // Handle button click
    $('.button1').on('click', function() {
        showLoadingPopup();
    });

    // Handle button click
    $('.button2').on('click', function() {
        showLoadingPopup();
    });
    
    // Function to show the loading popup
    function showLoadingPopup() {
        var loadingScreen = $('#loading-screen');
        loadingScreen.css('display', 'flex');
    }
});

// Function to delete a row
function deleteRow(table, id) {
    if (confirm("Are you sure you want to delete this row?")) {
        $.ajax({
            url: 'delete_row.php',
            type: 'POST',
            data: {
                table: table,
                id: id
            },
            success: function(response) {
                alert(response);
                location.reload(); // Refresh the page after deletion
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }
}

// Function to edit a row
function editRow(table, id) {
    // Find the table row corresponding to the ID
    var row = document.getElementById(table + '-' + id);

    // Find the cells in the row (excluding the last "Actions" cell)
    var cells = row.querySelectorAll('td:not(:last-child)');

    // Iterate over the cells and make them editable
    cells.forEach(function(cell) {
        var value = cell.textContent;
        cell.innerHTML = '<input type="text" value="' + value + '">';
    });

    // Change the button from "Edit" to "Save"
    var button = row.querySelector('.edit-button');
    button.innerHTML = 'Save';
    button.setAttribute('onclick', "saveRow('" + table + "', '" + id + "')");
}

function saveRow(table, id) {
    // Find the table row corresponding to the ID
    var row = document.getElementById(table + '-' + id);

    // Find the cells in the row (excluding the last "Actions" cell)
    var cells = row.querySelectorAll('td:not(:last-child)');

    // Create an object to hold the updated values
    var updatedData = {};

    // Iterate over the cells and retrieve the updated values
    cells.forEach(function(cell) {
        var column = cell.getAttribute('data-column');
        var value = cell.querySelector('input').value;
        updatedData[column] = value;
        cell.textContent = value; // Update the cell with the new value
    });

    // Change the button back to "Edit"
    var button = row.querySelector('.edit-button');
    button.innerHTML = 'Edit';
    button.setAttribute('onclick', "editRow('" + table + "', '" + id + "')");

    // Send the updated data to the server
    $.ajax({
        url: 'update_row.php',
        type: 'POST',
        data: {
            table: table,
            id: id,
            updatedData: updatedData
        },
        success: function(response) {
            alert(response);
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
}