<?php
    require_once('connection.php');

    session_start();

    // if table name is not set, set it to books
    if (!isset($_POST['table']))
    {
        $_POST['table'] = 'books';
    }
    // Get table name from radio button
    $tablename = $_POST['table'];
    // Change column name based on table name
    if ($tablename == 'addresses')
    {
        $column = 'address_id';
    }
    else if ($tablename == 'authors')
    {
        $column = 'author_id';
    }
    else if ($tablename == 'books')
    {
        $column = 'book_id';
    }
    else if ($tablename == 'customers')
    {
        $column = 'customer_id';
    }
    else if ($tablename == 'genres')
    {
        $column = 'genre_id';
    }
    else if ($tablename == 'payments')
    {
        $column = 'payment_id';
    }
    else if ($tablename == 'inventory')
    {
        $column = 'inventory_id';
    }
    else if ($tablename == 'purchases')
    {
        $column = 'purchase_id';
    }
    else if ($tablename == 'staff')
    {
        $column = 'staff_id';
    }
    else if ($tablename == 'stores')
    {
        $column = 'store_id';
    }

    // set cookie to table name
    setcookie('table', $tablename, time() + (86400 * 30), "/");

    try{
        $sql = "SELECT * FROM $tablename ORDER BY $column ASC";
        $result = $pdo->query($sql);
        $rows = $result->fetchAll();
    }
    catch(PDOException $e){
        echo $e->getMessage();
    }

    // Close connection
    unset($pdo);

    // Display result in JSON format
    // echo json_encode($rows);
?>

<!-- HTML -->
<!DOCTYPE html>
<html>
<head>
    <title>Bookstore</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    // JavaScript to hide the loading screen when the page is fully loaded
    window.addEventListener('load', function () {
        var loadingScreen = document.getElementById('loading-screen');
        loadingScreen.style.display = 'none';
    });
    $(document).ready(function() {
        // Handle delete button click
        $(document).on('click', '[id^="delete-btn-"]', function() {
            var rowId = $(this).data('row-id');
            
            // Send AJAX request to delete the row
            $.ajax({
                url: 'delete_row.php',
                method: 'POST',
                data: { rowId: rowId },
                success: function(response) {
                    // Handle the response from the server
                    alert(response);
                    // Reload the table or perform any other necessary actions
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });

        // Handle form submission
        $('#insert-form').submit(function(event) {
            // Prevent default form submission
            event.preventDefault();

            // Serialize the form data
            var formData = $(this).serialize();

            // Send an AJAX request to the insert_row.php file
            $.ajax({
                type: 'POST',
                url: 'insert_row.php',
                data: formData,
                success: function(response) {
                    // Display the response message
                    alert(response);

                    // Reload the table or perform any other necessary updates
                    location.reload();
                },
                error: function(xhr, status, error) {
                    // Display an error message if the request fails
                    alert('An error occurred: ' + error);
                }
            });
        });

        // Edit button click event
        $(document).on('click', '.edit-btn', function() {
            var rowId = $(this).data('row-id');
            var row = $(this).closest('tr');

            // Convert row data to inputs
            row.find('td:not(:last-child):not(:nth-last-child(2)').each(function() {
                var value = $(this).text();
                $(this).html('<input type="text" class="edit-input" value="' + value + '">');
            });

            // Change button to Save
            $(this).text('Save').removeClass('edit-btn').addClass('save-btn');
        });

        // Save button click event
        $(document).on('click', '.save-btn', function() {
            var rowId = $(this).data('row-id');
            var row = $(this).closest('tr');
            var updateData = {};

            // Get input values and updateData object
            row.find('.edit-input').each(function() {
                var columnName = $(this).closest('td').prev('td').text();
                var value = $(this).val();
                updateData[columnName] = value;
                $(this).parent().text(value); // Replace input with updated text
            });

            // Send AJAX request to update the row
            $.ajax({
                url: 'update_row.php',
                type: 'POST',
                data: {
                    rowId: rowId,
                    updateData: updateData
                },
                success: function(response) {
                    // Handle success response
                    console.log(response);
                    // Change button back to Edit
                    row.find('.save-btn').text('Edit').removeClass('save-btn').addClass('edit-btn');
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.error(error);
                    // Change button back to Edit
                    row.find('.save-btn').text('Edit').removeClass('save-btn').addClass('edit-btn');
                }
            });
        });


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
    </script>
</head>
<body>
    

    <div class="header">
        <h1>Great Reading Bookstore</h1>
    </div>

    <div class="table_choice">
        <!-- Radio buttons -->
        <form action="index.php" method="post" class="radio-container">
            <input type="radio" id="books" name="table" value="books">
            <label for="books">Books</label><br>
            <input type="radio" id="authors" name="table" value="authors">
            <label for="authors">Authors</label><br>
            <input type="radio" id="customers" name="table" value="customers">
            <label for="customers">Customers</label><br>
            <input type="radio" id="addresses" name="table" value="addresses">
            <label for="addresses">Addresses</label><br>
            <input type="radio" id="staff" name="table" value="staff">
            <label for="staff">Staff</label><br>
            <input type="radio" id="genres" name="table" value="genres">
            <label for="genres">Genres</label><br>
            <input type="radio" id="inventory" name="table" value="inventory">
            <label for="orders">inventory</label><br>
            <input type="radio" id="payments" name="table" value="payments">
            <label for="order_items">Payments</label><br>
            <input type="radio" id="purchases" name="table" value="purchases">
            <label for="purchases">Purchases</label><br>
            <input type="radio" id="stores" name="table" value="stores">
            <label for="stores">Stores</label><br>
            <input type="submit" value="Change" class="button1" id="changeButton">
        </form>
    </div>
    <div class="options">

    </div>
    <div class="table">    
        <?php
            // Display table name
            echo "<h2 id='tableName'>$tablename</h2>";
            // Display result in HTML table
            printTable($rows, $tablename);
        ?>
    </div>

    <!-- The loading screen overlay -->
    <div id="loading-screen">
        <div id="loading-spinner"></div>
        <span id="loading-text">Loading...</span>
    </div>
</body>

<?php
    // check the radio button for the table name
    if ($tablename == 'addresses')
    {
        echo "<script>document.getElementById('addresses').checked = true;</script>";
    }
    else if ($tablename == 'authors')
    {
        echo "<script>document.getElementById('authors').checked = true;</script>";
    }
    else if ($tablename == 'books')
    {
        echo "<script>document.getElementById('books').checked = true;</script>";
    }
    else if ($tablename == 'customers')
    {
        echo "<script>document.getElementById('customers').checked = true;</script>";
    }
    else if ($tablename == 'genres')
    {
        echo "<script>document.getElementById('genres').checked = true;</script>";
    }
    else if ($tablename == 'payments')
    {
        echo "<script>document.getElementById('payments').checked = true;</script>";
    }
    else if ($tablename == 'inventory')
    {
        echo "<script>document.getElementById('inventory').checked = true;</script>";
    }
    else if ($tablename == 'purchases')
    {
        echo "<script>document.getElementById('purchases').checked = true;</script>";
    }
    else if ($tablename == 'staff')
    {
        echo "<script>document.getElementById('staff').checked = true;</script>";
    }
    else if ($tablename == 'stores')
    {
        echo "<script>document.getElementById('stores').checked = true;</script>";
    }
?>