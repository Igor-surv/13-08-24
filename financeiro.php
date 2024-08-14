<?php
require_once 'config.php';

// Consulta para obter os fornecedores
$sql = "SELECT * FROM fornecedores ORDER BY id ASC";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_execute($stmt);
if (mysqli_stmt_errno($stmt)) {
    die("Erro ao executar a consulta: ". mysqli_stmt_error($stmt));
}
$resultFornecedores = mysqli_stmt_get_result($stmt);

// Consulta para obter os recibos
$sql = "SELECT * FROM recibo ORDER BY data DESC LIMIT 5";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_execute($stmt);
if (mysqli_stmt_errno($stmt)) {
    die("Erro ao executar a consulta: ". mysqli_stmt_error($stmt));
}
$resultRecibos = mysqli_stmt_get_result($stmt);

// Consulta para obter o total dos fornecedores
$sql = "SELECT SUM(preco) AS total_fornecedores FROM fornecedores";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_execute($stmt);
$resultTotalFornecedores = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_array($resultTotalFornecedores);
$totalFornecedores = $row['total_fornecedores'];

$sql = "SELECT SUM(preco) AS fornecer FROM fornecedores";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_execute($stmt);
$resulttotalfornecedores = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_array($resulttotalfornecedores);
$totalFornecer = $row['fornecer'];


?>

<!DOCTYPE html>
<html>
<head>
    <title>Financeiro</title>
    <link rel="stylesheet" type="text/css" href="financeiro.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Gastos', '%'],
          ['Fornecedor',     11],
          ['Estoque negativado',      2],
          ['Outros',    7]
        ]);

        var options = {
          title: '',
          pieHole: 0.5,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>
</head>
<body>
    
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

<div class="container">
    <h1>Financeiro</h1>

    <div class="resumo">
  <h2>Resumo financeiro</h2>
  <p>Receita total:  </p>
  <p>Despesas totais: </p>
  <p>Despesa dos fornecedores: <?php echo number_format($totalFornecedores, 2, ',', '.'); ?></p>
  <p>Valor do estoque completo: </p>
</div>

    </div>
    <div class="block">
    <div class="grafico">
    <div id="piechart_3d" style="width: 43vw; height: 500px;"></div>
    </div></div>

    <div class="recibos">
  <h2>Recibos recentes</h2>
  <table> 
    <thead>
      <tr>
        <th>Emitente</th>
        <th>Cliente</th>
        <th>Pedido</th>
        <th>Itens</th>
        <th>Valor</th>
        <th>Data</th>
      </tr>
    </thead>

    <tbody>
      <?php
          while($row = mysqli_fetch_array($resultRecibos)){
            $data = date('d/m/Y', strtotime($row['data']));
            echo "<tr>";
            echo "<td>".$row['emitente']."</td>";
            echo "<td>".$row['pedido']."</td>";
            echo "<td>".$row['codigo']."</td>";
            echo "<td>".$row['nome']."</td>";
            echo "<td>".$row['valor']."</td>";
            echo "<td>".$data."</td>";
            } ?>;
      </tbody>
    </table>
  </div>

  <div class="fornecer">
  <table class="fornecedor"> 
    <h2>Fornecedores</h2>
    <button class="add"> <a href="addFornecedor.php"> Adicionar fornecedor </a></button>
      <thead>
        <tr>
          <th>Nome</th>
          <th>CPF/CNPJ</th>
          <th>Endereço</th>
          <th>Valor gasto</th>
          <th>Contato</th>
          <th>Ações</th>
        </tr>
      </thead>

      <tbody id="fornecedor-lista"> 
        <?php
          while($row = mysqli_fetch_array($resultFornecedores)){
            echo "<tr>";
            echo "<td>".$row['nome']."</td>";
            echo "<td>".$row['cpf-cnpj']."</td>";
            echo "<td>".$row['endereco']."</td>";
            echo "<td>".$row['preco']."</td>";
            echo "<td>".$row['contato']."</td>";
            echo "<td>
              <a class='btn btn-sm btn-danger' href='editFornecedor.php?nome=".$row['nome']."' title='Editar'>
                <img src='https://cdn-icons-png.flaticon.com/512/1828/1828911.png' width='18px' height='18px'>
              </a>
              </td>";
            } ?>;
        </tbody>
    </table>
          </div>
</div>

<footer>
  <p>Site criado por <a href="#">InovaGest</a></p>
</footer>
</body>
</html>