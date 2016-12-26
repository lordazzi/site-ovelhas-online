<?
include("../conn.php");
if (!$_SESSION["admin"]) { header("location: ..\..\site\content\index.php"); exit; }
include("../header.php");
include("../sidebar.php");
?>

<div class="super_botao" onClick="window.location.href = 'cliente_criar.php'; ">Inserir um novo cliente</div>

<?

$data = mysql_query("SELECT * FROM cliente");
while(@$cliente = mysql_fetch_array($data)) {
	echo "
		<div class='cliente' onClick=' window.location.href = \"cliente_servicos.php?id=".$cliente["idcliente"]."\" '>
			<IMG src='../../arquivo/cliente_logo/".$cliente["logo"]."' /><br />
			".$cliente["nome_juridico"]."
		</div>
	";
}
include("../footer.php");
?>