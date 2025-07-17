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

<body id="bodyinfo">
	<div class="background">
		<span onmouseenter="eggfunc()" id="egg"></span>
		<span onmouseenter="eggfunc()" id="egg"></span>
		<span onmouseenter="eggfunc()" id="egg"></span>
		<span onmouseenter="eggfunc()" id="egg"></span>
		<span onmouseenter="eggfunc()" id="egg"></span>
		<span onmouseenter="eggfunc()" id="egg"></span>
		<span onmouseenter="eggfunc()" id="egg"></span>
		<span onmouseenter="eggfunc()" id="egg"></span>
		<span onmouseenter="eggfunc()" id="egg"></span>
		<span onmouseenter="eggfunc()" id="egg"></span>
	<header>
		<div class="uppage">
			<h1 class="titu">Informações</h1>
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
		$con = mysqli_connect('localhost', 'root', '', 'projeto');
		if (!$con) {
			error_log("Connection failed: " . mysqli_connect_error());
			die("Connection failed: " . mysqli_connect_error());
		}

		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

			// Handle delete request before output
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_resenha'])) {
	$delete_resenha = $_POST['delete_resenha'];
	
	// Fetch current resenhas
	$stmt_fetch = $con->prepare("SELECT resenha FROM obras WHERE id = ?");
	$stmt_fetch->bind_param("i", $id);
	$stmt_fetch->execute();
	$result_fetch = $stmt_fetch->get_result();
	
	$current_resenha = '';
	if ($row = $result_fetch->fetch_assoc()) {
		$current_resenha = $row['resenha'];
	}

	// Remove the resenha line
	$resenhas_array = explode("\n", $current_resenha);
	$resenhas_array = array_filter($resenhas_array, function($res) use ($delete_resenha) {
		return trim($res) !== trim($delete_resenha);
	});
	$updated_resenhas = implode("\n", $resenhas_array);

	// Update the database
	$stmt_update = $con->prepare("UPDATE obras SET resenha = ? WHERE id = ?");
	$stmt_update->bind_param("si", $updated_resenhas, $id);
	$stmt_update->execute();

	// Redirect to avoid resubmission
	header("Location: data.php?id=" . $id . "&deleted=1");
	exit();
}


		// Handle form submission before any output
		if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['resenha']) && !empty($_POST['resenha'])) {
			$resenha = $_POST['resenha'];
			// Fetch current resenha
			$stmt_fetch = $con->prepare("SELECT resenha FROM obras WHERE id = ?");
			$stmt_fetch->bind_param("i", $id);
			$stmt_fetch->execute();
			$result_fetch = $stmt_fetch->get_result();
			$current_resenha = '';
			if ($row = $result_fetch->fetch_assoc()) {
				$current_resenha = $row['resenha'];
			}
			// Append new resenha
			$new_resenha = $current_resenha . "\n" . $resenha;
			$stmt_update = $con->prepare("UPDATE obras SET resenha = ? WHERE id = ?");
			$stmt_update->bind_param("si", $new_resenha, $id);
			$stmt_update->execute();
			// Redirect to avoid resubmission
			header("Location: data.php?id=" . $id . "&success=1");
			exit();
		}

		$stmt = $con->prepare("SELECT * FROM obras WHERE id = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$sql = $stmt->get_result();

		if (mysqli_num_rows($sql) > 0) {
			while ($obra = mysqli_fetch_assoc($sql)) {
				echo "<div id=\"datalist\">";
				echo"<a id='aretdata' href='obras.php'>Retornar</a><br>";
				echo "<h4 id=\"titulo\">" . htmlspecialchars($obra['titulo']) . "</h4><br>";
				echo "<h4 id=\"titulo\">" ."Categoria : ". htmlspecialchars($obra['tipo']) . "🖥️</h4><br>";
				echo "<h4 id=\"titulo\">" ."Nota: ". htmlspecialchars($obra['nota']) . "⭐</h4><br>";
				echo "<section class='box2 fw'>";
				echo "<img id=\"imglistfull\" src='" . htmlspecialchars($obra['img']) . "' alt='Image not found'/><br>";
				echo"</section>";
				echo "<p id=\"titulo\">" ."<h4>Sinopse:</h4><br> ". htmlspecialchars($obra['sinopse']) . "</p><br>";
				if ($obra['saved'] == 1) {
    			echo "<p style='color: green;'>✅ Já está nos favoritos</p>";
				}else {
    			echo "<form method='post' action='favedit.php?id=" . $obra['id'] . "'>
        	<input type='hidden' name='tituloadd' value='1' />
        	<button style='background-color: #ffd700; border: none; padding: 8px 12px; border-radius: 5px; cursor: pointer;'>
            Favoritar⭐
        	</button>
    		</form><br>";
				}
				echo"<h4>Resenhas:</h4>"; 
				echo"<br>";
				if($obra['resenha']==null){
					echo"<h3>Nenhuma Resenha Disponivel</h3>";
				}
				echo"<br>";
				echo"<div id='divformedit'>
						<form method='post' action='data.php?id=" . $id . "'>
						<label id='labeledit' for='resenha'>Escreva sua Resenha</label>
						<input id='inputedit' name='resenha' type='text' placeholder='insira sua resenha' required/>
						<button id='buttonedit'>Publicar</button>
						</form>
						</div>
						<br>";
					// Exibe todas as resenhas separadas por nova linha
						$resenhas = explode("\n", $obra['resenha']);
						foreach ($resenhas as $res) {
							if (trim($res) !== '') {
								echo "<div style='display: flex; align-items: center;'>";
								echo "<h4 id=\"titulo\" style='flex:1;'>" . nl2br(htmlspecialchars($res)) . "</h4>";
								// Add a delete button for each resenha
								echo "<form method='post' action='data.php?id=" . $id . "' style='margin-left:10px;'>";
								echo "<input type='hidden' name='delete_resenha' value='" . htmlspecialchars($res, ENT_QUOTES) . "'/>";
								echo "<button type='submit' style='background: none; border: none; color: red; cursor: pointer;'>🗑️</button>";
								echo "</form>";
								echo "</div><hr>";
							}
						}
						if (isset($_GET['success']) && $_GET['success'] == 1) {
							echo "<h3>Resenha publicada com sucesso</h3>";
						}
				echo "</div>";
			}
		} else {
			echo "<h3>Erro ao encontrar as obras</h3>";
		}
		?>
	</div>
	</div>
</body>

</html>