<?
include("../conn.php");
if (!$_SESSION["admin"]) { header("location: ..\..\site\content\index.php"); exit; }
include("../header.php");
include("../sidebar.php");
?>

<? include("../footer.php"); ?>