<?php
    require_once('connection.php');
    require_once('table_management.php');

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
        $column = 'addresses_id';
    }
    else if ($tablename == 'authors')
    {
        $column = 'authors_id';
    }
    else if ($tablename == 'books')
    {
        $column = 'books_id';
    }
    else if ($tablename == 'customers')
    {
        $column = 'customers_id';
    }
    else if ($tablename == 'genres')
    {
        $column = 'genres_id';
    }
    else if ($tablename == 'payments')
    {
        $column = 'payments_id';
    }
    else if ($tablename == 'inventory')
    {
        $column = 'inventory_id';
    }
    else if ($tablename == 'purchases')
    {
        $column = 'purchases_id';
    }
    else if ($tablename == 'staff')
    {
        $column = 'staffs_id';
    }
    else if ($tablename == 'stores')
    {
        $column = 'stores_id';
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
?>

<!-- HTML -->
<!DOCTYPE html>
<html>
<head>
    <title>Bookstore</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script>
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