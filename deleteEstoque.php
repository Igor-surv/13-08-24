<?php
require_once('config.php');

session_start();

if (!isset($_SESSION["email"])) {
	header("Location: login.php");
	exit;
}

$userEmail = $_SESSION['email'];

$autorizado = "inovagest376@gmail.com";
$query = "SELECT * FROM admin WHERE email = '$autorizado'";
$result = mysqli_query($conn, $query);

if (!empty($_GET['nome'])) {
    $nome = $_GET['nome'];

    if ($userEmail === $autorizado) {
    $stmt = $conn->prepare("SELECT * FROM itens WHERE nome = ?");
    $stmt->bind_param("s", $nome);

    // Executar a consulta
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Preparar a consulta de exclusão
        $stmtDelete = $conn->prepare("DELETE FROM itens WHERE nome = ?");
        $stmtDelete->bind_param("s", $nome);

        // Executar a consulta de exclusão
        $stmtDelete->execute();
    }
} else {
    ?>
    <script>
        $(document).ready(function(){
            $('#modalErro').modal('show');
        });
    </script>
    <?php
}
}
?>
<link rel="stylesheet" type="text/css" href="pendentes.css">
<div class="modal">
    <h2>Erro de autorização</h2>
    <span>Você não tem permissão para excluir pedidos.</span>
    <p>Administrador logado: <?php echo $userEmail ?></p>
    <button type="button"><a href="estoque.php">Voltar</a></button>
</div>
    