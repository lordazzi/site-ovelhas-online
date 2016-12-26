<?
include("../conn.php");
if (!$_SESSION["logado"]) { header("location: ..\..\site\content\index.php"); exit; }
include("../header.php");
include("../sidebar.php");
?>

<? include("../footer.php"); ?>