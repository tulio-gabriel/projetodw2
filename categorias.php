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
	<div id="background-image-wrapper">
		<img src="imagemSql/pexels-caio-46274-removebg-preview.png" alt="" id="background-image3">
		<img src="imagemSql/pexels-stasknop-1228497-removebg-preview.png" alt="" id="background-image4">
	</div>
	<div class="container" id="obrasContainer">
		<div class="info">
			<h1>Lista de Categorias</h1>
			<br>
			<form action="obrasCategoria.php" method="post">
				<button id="btncategoria" name="categoria" value="filmes">Filmes 📽️</button>
				<button id="btncategoria" name="categoria" value="jogos">Jogos 🎮</button>
				<button id="btncategoria" name="categoria" value="livros">Livros 📕</button>
				<button id="btncategoria" name="categoria" value="musica">Música 🎵</button>
				<br>
			</form>
		</div>
	</div>
</body>

</html>
