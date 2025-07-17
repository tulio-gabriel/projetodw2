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
	<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Knewave&family=Shojumaru&family=Trade+Winds&display=swap" rel="stylesheet">
	<script src="js/script.js"></script>

<body id="bodylog">
	<?php
		session_start();
		$login = false;
	?>
	<header>
		<div class="uppage2"  id="uppagelog">
			<h1 Id="titulonome">TRAKKSY</h1>
			<h1 class="titu"  id="titulog">Central de Cadastros e Login</h1>
			<br>
			<a href="index.php" id="log">Login</a>
			<br>
			<a href="obras.php?login=<?php echo $login ? 'true' : 'false'; ?>" id="obras">Obras</a>
			<br>
			<a href="obras.php?categorias=<?php echo $login ? 'true' : 'false'; ?>" id="categ">Categorias</a>
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
	<div class="container">
	<?php
if (!empty($_SESSION['alert'])) {
    echo $_SESSION['alert'];
    unset($_SESSION['alert']); // clear it after showing
}
?>


		<div class="info">
			<h1>Sistema de Login</h1>
		</div>
		<form id="formlog" action="index.php" method="post">
			<label for="nome">Nome</label>
			<input type="text" name="nome" id="nome" required placeholder="Insira seu nome">
			<label for="senha">Senha</label>
			<input type="password" name="senha" id="senha" required placeholder="Insira sua senha">
			<button type="submit">Logar</button>
		</form>
		<br>
		<?php
			function debug_to_console($data)
			{
				echo "<script>console.log(" . json_encode($data) . ");</script>";
			}

			$nome = isset($_POST['nome']) ? $_POST['nome'] : null;
			$senha = isset($_POST['senha']) ? $_POST['senha'] : null;

			if ($nome !== null && $senha !== null) {
				$con = mysqli_connect('localhost', 'root', '', 'projeto');
				if (!$con) {
					debug_to_console("Connection failed: " . mysqli_connect_error());
					die("Connection failed: " . mysqli_connect_error());
				}

				// Use prepared statements to prevent SQL injection
				$stmt = $con->prepare("SELECT * FROM usuarios WHERE nome=? AND senha=?");
				$stmt->bind_param("ss", $nome, $senha);
				$stmt->execute();
				$sql = $stmt->get_result();

				if (mysqli_num_rows($sql) > 0) {
					$_SESSION['login'] = true;
					echo "<h3>logado com sucesso</h3>";
					$login = true;
					$userData = mysqli_fetch_assoc($sql);
					$_SESSION['user_id'] = $userData['id'];
					$_SESSION['bio'] = $userData['bio'];
					$_SESSION['perfilimg'] = $userData['perfilimg'];
					$_SESSION['obrafav'] = $userData['obrafav'];
					$_SESSION['nome'] = $nome;
					$_SESSION['admin'] = $userData['admin'];
					header("Location: obras.php");
					exit;
				} else {
					echo "<h3>usuario ou senha incorretos</h3>";
				}
				$stmt->close();
				$con->close();
			}
			if(isset($_SESSION['login'])){
			if($_SESSION['login'] == true){
				echo "<style>#formlog { display: none; }</style>";
				echo"<form method='post' action='index.php'>
					<input type='hidden' name='deslogar' value='deslog'>
					<button>Deslogar</button>
				</form>";
			}
		}
			if(isset($_POST['deslogar'])){
				$_SESSION['login'] = false;
				unset($_SESSION['user_id']);
				echo "<h3>deslogado com sucesso</h3>";
				header("Location: index.php");
			}
		?>
		<p id="cadp">Não tem uma conta?</p>
					<a href="cad.php" id="cad">Cadastre-se!</a>
	</div>
	<footer>
		&copy; <?php echo date("Y"); ?> Trakksy. Todos os direitos reservados.
	</footer>
</body>

</html>