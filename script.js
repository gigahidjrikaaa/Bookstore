$(document).ready(function() {
    // Handle button click
    $('.button1').on('click', function() {
        showLoadingPopup();
    });

    // Handle button click
    $('.button2').on('click', function() {
        showLoadingPopup();
    });

    // Handle button click
    $('.button3').on('click', function() {
        showLoadingPopup();
    });


    
    // Function to show the loading popup
    function showLoadingPopup() {
        var loadingScreen = $('#loading-screen');
        loadingScreen.css('display', 'flex');
    }

    $('.insert-button').on('click', function() {
        insertRow('<?= $tablename ?>');
    });
    

    // Handle + button click
    $('#add-row-button').on('click', function() {
        addInputRow();
    });

});

function insertRow() {
    var table = $('#tableName').text(); // Get the table name from the HTML
    var newRow = {};
    var inputs = $('.insert-row input');

    inputs.each(function() {
        newRow[$(this).attr('name')] = $(this).val();
    });

    // Convert newRow to a JSON string
    var jsonData = JSON.stringify(newRow);

    // Send the new row data to the server for insertion
    $.ajax({
        url: 'insert_row.php',
        method: 'POST',
        data: {
            table: table,
            data: jsonData
        },
        success: function(response) {
            // Handle the server response
            alert(response); // Display success message or handle errors
            // Reload the table to display the updated data
            location.reload();
        },
        error: function(xhr, status, error) {
            // Handle error cases
            alert('Error: ' + error); // Display error message
        }
    });
}



function getCookie(name) {
    var cookieName = name + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var cookieArray = decodedCookie.split(';');

    for (var i = 0; i < cookieArray.length; i++) {
        var cookie = cookieArray[i];
        while (cookie.charAt(0) === ' ') {
            cookie = cookie.substring(1);
        }
        if (cookie.indexOf(cookieName) === 0) {
            return cookie.substring(cookieName.length, cookie.length);
        }
    }
    return null;
}

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
        var column = cell.getAttribute('data-column');
        var value = cell.textContent;
        cell.innerHTML = '<input type="text" value="' + value + '">';
        // if the column is "last_update", don't make it editable
        if (column == 'last_update') {
            cell.innerHTML = value;
        }
    });

    // Change the button from "Edit" to "Save"
    var button = row.querySelector('.edit-button');
    button.innerHTML = 'Save';
    button.setAttribute('onclick', "saveRow('" + table + "', '" + id + "')");
    // change the value of last_update to the current date and time
    var date = new Date();
    var dateString = date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate();
    var timeString = date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds();
    var dateTimeString = dateString + ' ' + timeString;
    var lastUpdateCell = row.querySelector('td[data-column="last_update"]');
    lastUpdateCell.innerHTML = dateTimeString;
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
        var input = cell.querySelector('input');
        var value = input ? input.value : cell.textContent;
        updatedData[column] = value;
        cell.textContent = value; // Update the cell with the new value
    });

    // Change the button back to "Edit"
    var button = row.querySelector('.edit-button');
    button.innerHTML = 'Edit';
    button.setAttribute('onclick', "editRow('" + table + "', '" + id + "')");
    // show the loading popup
    var loadingScreen = $('#loading-screen');
    loadingScreen.css('display', 'flex');

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
            // Hide the loading popup
            loadingScreen.css('display', 'none');
            // wait 1 second before displaying the response
            setTimeout(function() {
                alert(response);
            },500);
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
}