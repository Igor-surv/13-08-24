<?php
include 'config.php';
session_start();

if (!isset($_SESSION["email"])) {
	header("Location: login.php");
	exit;
}

$userEmail = $_SESSION['email'];

$sql = "SELECT nome FROM admin WHERE email = '$userEmail'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
	$user = $row["nome"];
} else {
	$user = "Não encontrado";
}

// Contagem de produtos indisponíveis
$stmt = $conn->prepare("SELECT COUNT(*) AS indisponiveis FROM itens");
$stmt->execute();
$result = $stmt->get_result();
$indisponiveis = $result->fetch_assoc()['indisponiveis'];

// Contagem de produtos disponíveis
$stmt = $conn->prepare("SELECT COUNT(*) AS disponiveis FROM itens");
$stmt->execute();
$result = $stmt->get_result();
$disponiveis = $result->fetch_assoc()['disponiveis'];

// Produtos com baixo estoque
$stmt = $conn->prepare("SELECT nome FROM itens WHERE disponiveis > 0 ORDER BY quantidade ASC LIMIT 5");
$stmt->execute();
$result = $stmt->get_result();
$produtos_baixo_estoque = array();
while ($row = $result->fetch_assoc()) {
    $produtos_baixo_estoque[] = $row['nome'];
}

// Produtos com estoque zerado
$stmt = $conn->prepare("SELECT nome FROM itens WHERE disponiveis = 0 LIMIT 5");
$stmt->execute();
$result = $stmt->get_result();
$produtos_estoque_zerado = array();
while ($row = $result->fetch_assoc()) {
    $produtos_estoque_zerado[] = $row['nome'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="home.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Produtos em geral', ''],

          ['Disponiveis', <?php echo $disponiveis ?>],
          ['Indisponiveis', <?php echo $indisponiveis ?>],
        ]);

        var options = {
          title: 'Produtos em estoque',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>

    <title>Home</title>

</head>
<body>
    <aside>
      <div class="menu">
            <ul>
              <li><a href="home.php">Inicio</a></li>
              <li><a href="pedidos_pendentes.php">Pedidos</a></li>
              <li><a href="estoque.php">Estoque</a></li>
              <li><a href="financeiro.php">Financeiro</a></li>
              <li><a href="relatorio.php">Relatorios</a></li>
              <li><a href="clientes.php">Clientes</a></li>
              <li><a href="admin.php">Administradores</a></li>
            </ul>
      </div>
    </aside>
    
    <div class="bloco">
        <h1>Inicio</h1>
        <h2>Bem vindo, <?php echo $user ?>! </h2>
    </div>

    <div class="container">
        <div class="grafico1">
            <div id="piechart_3d" style="width: 650px; height: 400px;"></div>
        </div>

        <div class="grafico2">
            <table>
                <tr>
                    <th>Produtos com baixo estoque</th>
                    <th id="2">Produtos com estoque zerado</th>
                </tr>
                <tr>
                    <td>
                        <ul>
                            <?php foreach ($produtos_baixo_estoque as $produto) { ?>
                                <li><?php echo $produto; ?></li>
                            <?php } ?>
                        </ul>
                    </td>
                    <td>
                        <ul>
                            <?php foreach ($produtos_estoque_zerado as $produto) { ?>
                                <li><?php echo $produto; ?></li>
                            <?php } ?>
                        </ul>
                    </td>
                </tr>
            </table>
        </div>
    </div>

</body>
</html>