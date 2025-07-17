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
	<ul class="background">
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
	<header>
		<div class="uppage3">
			<h1 class="titu">Meu Perfil</h1>
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
		<?php
				$con = mysqli_connect('localhost', 'root', '', 'projeto');
				if (!$con) {
					error_log("Connection failed: " . mysqli_connect_error());
					die("Connection failed: " . mysqli_connect_error());
				}
				// Example: Get a session value set in index.php
				if (isset($_SESSION['nome']) && isset($_SESSION['user_id'])){
					$user_id=$_SESSION['user_id'];
					$user = "SELECT * FROM usuarios WHERE id='$user_id'";
					$sql = mysqli_query($con, $user);
					if ($sql && $row = mysqli_fetch_assoc($sql)) {
						$nome = $row['nome'];
						$bio = $row['bio'];
						$perfilimg = $row['perfilimg'];
						$obrafav = $row['obrafav'];
						echo "<div id=\"perfillist\">";
						echo "<h2>" . htmlspecialchars($nome) . "</h2><br>";
							echo "<img id=\"imgperfil\" src=\"" . htmlspecialchars($perfilimg, ENT_QUOTES, 'UTF-8') . "\" alt=\"Perfil\" /><br><br>";
						echo "<h3> Biografia 📖:ㅤ" . htmlspecialchars($bio) . "</h3><br>";
						echo "<h3> Obra favorita ⭐:ㅤ" . htmlspecialchars($obrafav) . "</h3><br>";
						echo "<a href=\"perfilEdit.php?user_id={$user_id}\">Editar perfil</a>";
						echo "<div>"; 
					} else {
						
					}
				} else {
					echo "<p>No session value found from index.php.</p>";
					// echo $_SESSION['nome'] $_SESSION['user_id'] $_SESSION['bio'] $_SESSION['perfilimg'] $_SESSION['obrafav'];
				}
				?>
				</ul>
	</div>
</body>

</html>
