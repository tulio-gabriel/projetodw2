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

<body id="bodycad">
	<header>
		<div class="uppage2"  id="uppagelog">
			<h1 Id="titulonome">TRAKKSY</h1>
			<h1 class="titu" id="titulog">Central de Cadastros e Login</h1>
			<br>
			<a href="index.php" id="log">Login</a>
			<br>
			<a href="obras.php" id="cad2">Cadastro</a>
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
			<a href="data.php" id="datalink">Data</a>
			<br>
		</div>
	</header>
	<div class="container">
		<div class="info">
			<h1>Sistema de Cadastro</h1>
		</div>
		<form action="cad.php" method="post">
			<label for="nome">Nome</label>
			<input type="text" name="nome" id="nome" required placeholder="Insira seu nome">
			<label for="senha">Senha</label>
			<input type="password" name="senha" id="senha" required placeholder="Insira sua senha">
			<button type="submit">Cadastrar</button>
		</form>
		<?php
			$nome = isset($_POST['nome']) ? $_POST['nome'] : null;
			$senha = isset($_POST['senha']) ? $_POST['senha'] : null;
			if (!empty($nome) && !empty($senha)) {

				function debug_to_console($data)
				{
					if ($_SERVER['REQUEST_METHOD'] === 'POST') {
						$output = $data;
					}
					if (is_array($output))
						$output = implode(',', $output);

					echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
				}

				$con = mysqli_connect('localhost', 'root', '','projeto');
				if (!$con) {
					debug_to_console("Connection failed: " . mysqli_connect_error());
					die("Connection failed: " . mysqli_connect_error());
				}


				$stmt = $con->prepare("INSERT INTO usuarios (nome, senha) VALUES (?, ?)");
				$stmt->bind_param("ss", $nome, $senha);

				if ($stmt->execute()) {
					echo "<h3>usuário cadastrado com sucesso</h3>";
					header("Location: index.php");
				} else {
					echo "<h3>houve um erro ao cadastrar</h3>";
				}

				$stmt->close();
			}
			?>
	</div>
	<footer>
		&copy; <?php echo date("Y"); ?> Trakksy. Todos os direitos reservados.
	</footer>
</body>

</html>