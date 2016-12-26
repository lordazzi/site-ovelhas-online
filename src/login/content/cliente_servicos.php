<?
include("../conn.php");
if (!$_SESSION["admin"]) { header("location: ..\..\site\content\index.php"); exit; }
if (!$_GET["id"]) { exit; }
include("../header.php");
include("../sidebar.php");

if ($_POST["novo_servico"]) {
	$erro = "";
	
	//SERVIÇO
	if ($_POST["servico"] != "") {
		if (onlynumbers($_POST["servico"])) {
			$servico = addslashes($_POST["servico"]);
		}
		
		else {
			$erro .= "Há algo errado com o serviço selecionado. \\n";
		}
	}
	
	else {
		$erro .= "O campo do serviço oferecido não pode ser nulo. \\n";
	}
	
	if ($_POST["description"] != "") {
		if (onlyletters($_POST["description"], "'1234567890-=´[~],.;:`^{}!@#$%¨&*()_+?/áéíóúãõâêôüç".'"')) {
			$description = addslashes($_POST["description"]);
		}
		
		else {
			$erro .= "Há caracteres inválidos no campo da descrição do serviço. \\n";
		}
	}
	
	if ($erro == "") {
		if (mysql_query("INSERT INTO cliente_servico (idcliente, idservico, description) VALUES ('".addslashes($_GET["id"])."', '$servico', '$description')")) {
			echo "
				<script type='text/javascript'>
					alert('O serviço foi incluido com sucesso.');
				</script>
			";
		}
		
		else {
			echo "
				<script type='text/javascript'>
					alert('Houve um erro ao tentar incluir o serviço.');
				</script>
		"	;
		}
	}
	
	else {
		echo "
			<script type='text/javascript'>
				alert('".$erro."');
			</script>
		";
	}
}

$data = mysql_query("SELECT * FROM cliente WHERE idcliente=".addslashes($_GET["id"])." ORDER BY nome_juridico");
$cliente = mysql_fetch_array($data);

echo "
	<div style='float: left'>
		<b>Logo:</b> <IMG src='../../arquivo/cliente_logo/".$cliente["logo"]."' /><br />
		<b>Nome:</b> ".$cliente["nome_juridico"]."<br />
		<b>Responsável:</b> ".$cliente["nome_fisico"]."<br />
	</div>

	<form method='POST' action='' class='cliente_pagas'>
		<b>Adicionar um novo serviço ao cliente:</b><br />
		
		<select name='servico'>";
		
		$data = mysql_query("SELECT * FROM servico");
		while ($option = mysql_fetch_array($data)) {
			echo "<option value='".$option["idservico"]."'>".$option["titulo"]."</option>";
		}
		
	echo 
		"</select><br />
		Descreva o serviço:<br />
		<textarea name='description'></textarea>
		<input type='submit' name='novo_servico' value='Cadastrar serviço' />
	</form>
";

	echo "<div class='cliente_pagas'>";
		$data1 = mysql_query("SELECT * FROM cliente_servico WHERE idcliente=".addslashes($_GET["id"]));
		while ($serv = mysql_fetch_array($data1)) {
			$data2 = mysql_query("SELECT * FROM servico WHERE idservico=".$serv["idservico"]);
			$serv_tipo = mysql_fetch_array($data2);
			echo "<div>".$serv_tipo["titulo"]."</div>";
		}
	echo "</div>";

include("../footer.php");
?>