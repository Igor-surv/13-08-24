<?php
include_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $nome = $_POST['nome'];
  $codigo = $_POST['codigo'];
  $tipo = $_POST['tipo'];
  $disponiveis = $_POST['disponiveis'];
  $indisponiveis = $_POST['indisponiveis'];
  $quantidade = $_POST['quantidade'];

  // Preparar a consulta
  $stmt = $conn->prepare("INSERT INTO itens (nome, codigo, tipo, disponiveis, indisponiveis, quantidade) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssssss", $nome, $codigo, $tipo, $disponiveis, $indisponiveis, $quantidade);

  // Executar a consulta
  if ($stmt->execute()) {
    echo "Item adicionado com sucesso!";
  } else {
    echo "Erro ao adicionar pedido: " . $stmt->error;
  }

  // Fechar a statement
  $stmt->close();
}

// Redirecionar para a página anterior
header('Location: estoque.php');
exit;
?>