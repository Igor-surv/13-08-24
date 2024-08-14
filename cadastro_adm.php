<?php 
require_once 'config.php';
session_start();

if (!isset($_SESSION["email"])) {
	header("Location: login.php");
	exit;
}

$userEmail = $_SESSION['email'];

$autorizado = "inovagest376@gmail.com";
$query = "SELECT * FROM admin WHERE email = '$autorizado'";
$result = mysqli_query($conn, $query);

// Verificar se o email foi encontrado
if (mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  if ($row['email'] == $userEmail) {
      $permitirExecutar = true;
  } else {
      $permitirExecutar = false;
  }
} else {
  $permitirExecutar = false;
}

mysqli_close($conn);

?>
<!-- HTML Code -->
<!DOCTYPE html>
<html>
<head>
  <title>Adicionar novo admin</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="cadastroAdm.css">
</head>
<body>

  <div class="container">
    <h1>Adicionar novo administrador:</h1>

    <form method="post" action="cadastroAdm.php">

      <label class="form-label" for="nome">Nome do administrados:</label>
      <input type="text" id="nome" name="nome" required>

        <br><br>

    <label for="cpf">CPF (apenas numeros):</label>
    <input type="text" id="cpf" name="cpf" pattern="[0-9]+" required>

        <br><br>

    <label class="form-label" for="email">Email:</label>
    <input type="email" id="email" name="email" required>

        <br><br>

    <label for="telefone">Telefone:</label>
    <input type="tel" id="telefone" name="telefone" required>

        <br><br>

    <label for="senha">Senha:</label>
    <input type="password" id="senha" name="senha" required>

        <br><br>

  <?php if ($permitirExecutar) { ?>
    <input type="submit" id="submit" value="Adicionar administrador">
  <?php } else { ?>
        <p>Você não tem permissão para executar essa ação.</p>
    <?php } ?>
    </form>
  </div>

</body>
</html>