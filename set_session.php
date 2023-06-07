<?php
if (isset($_GET['edit_row_id'])) {
    $editRowId = $_GET['edit_row_id'];

    // Set the session variable with the provided row ID
    $_SESSION['edit_row_id'] = $editRowId;
}
?>
