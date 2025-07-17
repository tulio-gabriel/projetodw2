<?php
	session_start();
	if($_SESSION['login'] != true){
		 $_SESSION['alert'] = "Faça Login Para Acessar Outras Paginas";
		header("Location: index.php");
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>login</title>
	<link rel="stylesheet" href="style/style.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link
		href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
		rel="stylesheet">
	<script src="js/script.js"></script>
</head>

<body id="bodyus">
	<header>
		<div class="uppage">
			<h1 class="titu">Listagem de Obras</h1>
			<br>
			<a href="index.php" id="log">Login</a>
			<br>
			<a href="obras.php" id="obras">Obras</a>
			<br>
			<a href="categorias.php" id="categ">Categorias</a>
			<br>
			<a href="salvo.php" id="salv">Favoritos</a>
			<br>
				<a href="perfil.php" id="perfil">Meu Perfil</a>
			<br>
			<?php
				if (isset($_SESSION['login']) && $_SESSION['login'] == true && isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
					echo '<a href="dbCommands/admincommands.html" id="perfil">Seção Admin</a><br>';
				}
			?>
		</div>
	</header>
	<div class="containerobras" id="obrasContainer">
		<div class="info">
		</div>
		<?php
				$con = mysqli_connect('localhost', 'root', '','projeto');
				if (!$con) {
					error_log("Connection failed: " . mysqli_connect_error());
					die("Connection failed: " . mysqli_connect_error());
				}

				$obras = "SELECT * FROM obras";
				$sql = mysqli_query($con, $obras);

				
		if (!$sql) {
    		die("Query failed: " . mysqli_error($con)); // This will show the SQL error message
			}

					$tituloadd=isset($_POST['tituloadd']);
		if (isset($_POST['tituloadd'])) {
    $tituloadd = $_POST['tituloadd'];
      $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $stmt = $con->prepare("UPDATE obras SET saved = 1 WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
    echo "Obra salva com sucesso!"; 
    header("Location: salvo.php");
    exit();
}else {
        echo "Erro ao salvar obra: " . $stmt->error;
    }
}
		?>
	</div>
</body>

</html>
