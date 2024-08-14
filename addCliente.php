<?php
require_once 'config.php';

// Get form data
$nome = $_POST['nome'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$endereco = $_POST['endereco'];
$cpf = $_POST['cpf'];

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO clientes (nome, email, telefone, endereco, cpf) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $nome, $email, $telefone, $endereco, $cpf);

// Execute
$stmt->execute();

// Check if data was inserted successfully
if ($stmt->affected_rows > 0) {
    echo "Item adicionado com sucesso!";
} else {
    echo "Erro ao adicionar pedido: " . $conn->error;
}

// Close statement
$stmt->close();

// Redirecionar para a página anterior
header('Location: clientes.php');
exit;
?>