		<!DOCTYPE html>
		<html lang="en">
		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>Document</title>
			<link rel="stylesheet" href="../style/style.css">
		</head>
		<body id="bodyus">
			<div class="containerobras" id="obrasContainer">
			<?php
				$con = mysqli_connect('localhost', 'root', '', 'projeto');
				if (!$con) {
					error_log("Connection failed: " . mysqli_connect_error());
					die("Connection failed: " . mysqli_connect_error());
				}

				echo"<form method='post' action='insert.php'>
					<label id='labeledit' for='tabela'>Tabela</label>
					<input id='inputedit' name='tabela' type='text' placeholder='insira a tabela' required/>
					<label id='labeledit' for='coluna'>Coluna</label>
					<input id='inputedit' name='coluna' type='text' placeholder='insira a coluna' required/>
					<label id='labeledit' for='valor'>Valor</label>
					<input id='inputedit' name='valor' type='text' placeholder='insira o valor' required/>
					<button id='buttonedit'>Inserir</button>	
				</form>
				";
			if(isset($_POST['tabela']) && isset($_POST['coluna']) && isset($_POST['valor'])){
				$tabela = $_POST['tabela'];
				$coluna = $_POST['coluna'];
				$valor = $_POST['valor'];
				

				// Validate table and column names to prevent SQL injection
				if (!preg_match('/^[a-zA-Z0-9_]+$/', $tabela) || !preg_match('/^[a-zA-Z0-9_]+$/', $coluna)) {
					die("Nome de tabela ou coluna inválido.");
				}

				// Use prepared statements to prevent SQL injection
				$stmt = mysqli_prepare($con, "INSERT INTO `$tabela` (`$coluna`) VALUES (?)");
				if ($stmt) {
					mysqli_stmt_bind_param($stmt, "s", $valor);
					$success = mysqli_stmt_execute($stmt);
					if($success){
						echo"Registro inserido com sucesso";
					}else{
						die("Falha ao inserir registro: " . mysqli_stmt_error($stmt));
					}
					mysqli_stmt_close($stmt);
				} else {
					die("Erro na preparação da query: " . mysqli_error($con));
				}
			}
	?>	
	</div>
		</body>
		</html>
		