<? if (!$_SESSION["logado"]) { exit; } ?>
			<div id="sidebar">
				<?
					if ($_SESSION["admin"]) {
						$data = mysql_query("SELECT * FROM logs");
						echo "
							<div onClick=' window.location.href = \"logs.php\"; '>Logs (".mysql_num_rows($data).")</div>
							<div onClick=' window.location.href = \"clientes.php\"; '>Clientes</div>
							<div onClick=' window.location.href = \"financeiro.php\"; '>Financeiro</div>
							<div onClick=' window.location.href = \"visitantes.php\"; '>Visitantes</div>
						";
					}
					
					elseif (!$_SESSION["admin"]) {
						echo "
							<div onClick=' window.location.href = \"editar.php\"; '>Editar informações</div>
						";
					}
				?>
			</div>
			<div id="content">