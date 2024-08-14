<?php 
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

<?php if ($permitirExecutar) { ?>

botao

<?php } else { ?>
      <p>Você não tem permissão para executar essa ação.</p>
  <?php } ?>