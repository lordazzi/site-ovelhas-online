<?php
//INICIANDO A SESSÃO EM TODOS OS ARQUIVOS QUE IMPORTAM ESSE
session_start();

//IMPORTANDO O ARQUIVO DE FUNÇÕES GENÉRICAS E CONFIGURAÇÕES
include("../../plugins/php/functions.php");
include("../../plugins/php/config.php");

//CONECTANDO COM O BANCO DE DADOS
mysql_connect(CONN_SERVER, CONN_USER, CONN_PASS);
mysql_select_db(CONN_DB);

//PEGANDO O ENDEREÇO DE IP E ANOTANDO PARA SABER QUE O SITE FOI VISITADO
$ipuser = getip();    
$data = mysql_query("SELECT * FROM visitas WHERE ipadress='".$ipuser."' AND data='".date("Y-m-d")."'");
@$conta = mysql_num_rows($data);

if ($conta == 0)
{
  mysql_query("INSERT INTO visitas (data, ipadress, idmembros) VALUES ('".date("Y-m-d")."', '".$ipuser."', 0)");
}

?>