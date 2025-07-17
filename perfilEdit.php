<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
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
			<h1 class="titu">Edite seu Perfil</h1>
			<br>
				<h1 class="titu">Perfil</h1>
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
	<div class="containerobras" id="perfileditcontainer">
		<div class="info">
		</div>
		<?php
				$con = mysqli_connect('localhost', 'root', '', 'projeto');
				if (!$con) {
					error_log("Connection failed: " . mysqli_connect_error());
					die("Connection failed: " . mysqli_connect_error());
				}
				$user_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
				$user = "SELECT * FROM usuarios WHERE id='$user_id'";
				$sql = mysqli_query($con, $user);

				echo "<div id='divformedit'>
					<form method='post' action='perfilEdit.php'>
					<label id='labeledit' for='bio'>Biografia</label>
					<input id='inputedit' name='bio' id='bio' type='text' placeholder='Digite sua biografia' required/>
					<button id='buttonedit'>Atualizar</button>
					</form>
					</div>
					<br>
					<div id='divformedit'>
					<form method='post' action='perfilEdit.php' enctype='multipart/form-data'>
					<label id='labeledit' for='perfilimg'>Imagem de perfil</label>
					<input id='inputedit' name='perfilimg' id='perfilimg' type='file'  placeholder='insira sua imagem de perfil' required value='insira sua imagem'/>
					<button id='buttonedit' type='submit' name='submit_img'>Atualizar</button>
					</form>
					</div>
					<br>
					<div id='divformedit'>
					<form method='post' action='perfilEdit.php'>
					<label id='labeledit' for='obrafav'>Obra favorita</label>
					<input id='inputedit' name='obrafav' id='obrafav' type='text'  placeholder='Digite sua obra favorita' required />
					<button id='buttonedit'>Atualizar</button>
				</form>
				<br>
				</div>
				";

				echo"<div id='divreturn'><a id='areturn' href='perfil.php'>Retornar</a></div>";

				if(isset($_POST['bio'])){
					$bio = mysqli_real_escape_string($con, $_POST['bio']);
					$updt = "UPDATE usuarios SET bio='$bio' WHERE id='$user_id'";
					mysqli_query($con, $updt);
				}
				
				if (isset($_POST['submit_img']) && isset($_FILES['perfilimg']) && $_FILES['perfilimg']['error'] === UPLOAD_ERR_OK) {
	$fileTmpPath = $_FILES['perfilimg']['tmp_name'];
	$fileName = $_FILES['perfilimg']['name'];
	$fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

	// Set a destination path (e.g., img/ folder)
	$newFileName = uniqid('perfil_', true) . '.' . $fileExtension;
	$uploadFileDir = 'img/';
	$dest_path = $uploadFileDir . $newFileName;

	// Move the file
	if (move_uploaded_file($fileTmpPath, $dest_path)) {
		// Escape the path before saving in DB
		$perfilimg = mysqli_real_escape_string($con, $dest_path);

		// Update path in DB
		$updt = "UPDATE usuarios SET perfilimg='$perfilimg' WHERE id='$user_id'";
		mysqli_query($con, $updt);

		echo "Imagem de perfil atualizada com sucesso.";
	} else {
		echo "Erro ao mover o arquivo para o diretório de destino.";
	}
}

				if(isset($_POST['obrafav'])){
					$obrafav = mysqli_real_escape_string($con, $_POST['obrafav']);
					$updt = "UPDATE usuarios SET obrafav='$obrafav' WHERE id='$user_id'";
					mysqli_query($con, $updt);
				}
				
		?>
	</div>
</body>

</html>
<?php
} else {
	header("Location: index.php");
	exit();
}