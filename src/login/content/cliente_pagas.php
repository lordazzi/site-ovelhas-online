<?
include("../conn.php");
if (!$_SESSION["admin"]) { header("location: ..\..\site\content\index.php"); exit; }
include("../header.php");
include("../sidebar.php");

$data = mysql_query("SELECT * FROM cliente_servico WHERE idcliente_servico=".addslashes($_GET["id"]));
$cliente_servico = mysql_fetch_array($data);

include("../footer.php"); ?>