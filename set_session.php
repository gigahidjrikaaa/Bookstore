<?php
    session_start();

    if (isset($_POST['table'])) {
        $_SESSION['table'] = $_POST['table'];
        echo "Session set successfully.";
    } else {
        echo "Invalid request.";
    }
?>
