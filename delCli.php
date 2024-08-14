<?php
if (!empty($_GET['id'])) {
    include_once('config.php');

    $id = $_GET['id'];

    // Prepare the select statement
    $stmtSelect = mysqli_prepare($conn, "SELECT * FROM clientes WHERE id = ?");
    mysqli_stmt_bind_param($stmtSelect, "i", $id);
    mysqli_stmt_execute($stmtSelect);
    $result = mysqli_stmt_get_result($stmtSelect);

    if (mysqli_num_rows($result) > 0) {
        // Prepare the delete statement
        $stmtDelete = mysqli_prepare($conn, "DELETE FROM clientes WHERE id = ?");
        mysqli_stmt_bind_param($stmtDelete, "i", $id);
        mysqli_stmt_execute($stmtDelete);
    }

    // Close the statements
    mysqli_stmt_close($stmtSelect);
    if (isset($stmtDelete)) {
        mysqli_stmt_close($stmtDelete);
    }
}

header('Location: clientes.php');
exit;
?>