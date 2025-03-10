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

$id = $_GET['id'];
$sql = "SELECT * FROM clientes WHERE id = '$id'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Erro ao executar a consulta: " . mysqli_error($conn));
}

$item = mysqli_fetch_array($result);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="editeEstoque.css">
    <title>Editar Estoque</title>
</head>
<body>
    <div class="container">
        <h2>Editar item</h2>
        <form action="enviar_ediCli.php" method="post">

            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?php echo $item['nome']; ?>">
            <br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $item['email']; ?>">
            <br><br>

            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone" pattern="[0-9]+" value="<?php echo $item['telefone']; ?>">
            <br><br>

            <label for="endereco">Endereço:</label>
            <input type="text" id="endereco" name="endereco" value="<?php echo $item['endereco']; ?>">
            <br><br>

            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" pattern="[0-9]+" value="<?php echo $item['cpf']; ?>">
            <br><br>

            <input type="hidden" name="id" value="<?php echo $id; ?>">

            <?php if ($permitirExecutar) { ?>
            <input type="submit" id="submit" value="Salvar Alterações">
            <?php } else { ?>
            <p>Você não tem permissão para executar essa ação.</p>
            <?php } ?>
        </form>
    </div>
</body>
</html>