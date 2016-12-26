<?
include("../conn.php");
//verificando se quem fez o login foi o administrador
$data_admin = mysql_query("SELECT * FROM admin WHERE login='".$_POST["login"]."' AND senha='".MD5($_POST["senha"])."'");
if (mysql_num_rows($data_admin) == 1) {
	$_SESSION["logado"] = true;
	$_SESSION["admin"] = true;
	header("location: ../../login/content");
}

else {
	//verificando se o login é de cliente
	$data_cliente = mysql_query("SELECT * FROM cliente WHERE login='".$_POST["login"]."' AND senha='".MD5($_POST["senha"])."'");
	if (mysql_num_rows($data_cliente) == 1) {
		$cliente = mysql_fetch_array($data_cliente);
		$_SESSION["logado"] = true;
		$_SESSION["id"] = $cliente["idcliente"];
		header("location: ../../login/content");
	}
	
	else {
		echo "
			<script type='text/javascript'>
				alert('Login ou senha incorretos.');
				window.location.href = '../content/index.php';
			</script>
		";
	}
}
?>