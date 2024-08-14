<?php
require_once 'config.php';

// Get the updated values from the form
$id = $_POST['id'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$endereco = $_POST['endereco'];
$cpf = $_POST['cpf'];

// Prepare the update statement
$stmt = mysqli_prepare($conn, "UPDATE itens SET nome = ?, email = ?, telefone = ?, endereco = ?, cpf = ? WHERE id = ?");

// Bind the parameters
mysqli_stmt_bind_param($stmt, "sssssi", $nome, $email, $telefone, $endereco, $cpf, $id);

// Execute the prepared statement
mysqli_stmt_execute($stmt);

// Check for errors
if (mysqli_stmt_errno($stmt)) {
    die("Erro ao executar a consulta: " . mysqli_stmt_error($stmt));
}

// Close the statement and connection
mysqli_stmt_close($stmt);
mysqli_close($conn);

// Redirect back to the stock page
header('Location: clientes.php');
exit;
?>