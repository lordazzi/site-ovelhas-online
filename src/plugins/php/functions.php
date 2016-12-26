<?php

################################################################################
################################################################################
###                                                                          ### 
###                    ARQUIVO PHP FUNCTION OVELHAS v 7.1		             ###
###                                                                          ### 
################################################################################
################################################################################

##############################
#
#   fun��o unacenta
#   Retira todos os acentos de uma palavra
#   $palavra = palavra a ter os acentos retirados
#
##############################

function unacenta($palavra) {
	str_replace("�", "A", $palavra);
	str_replace("�", "A", $palavra);
	str_replace("�", "A", $palavra);
	str_replace("�", "A", $palavra);
	str_replace("�", "A", $palavra);
	str_replace("�", "a", $palavra);
	str_replace("�", "a", $palavra);
	str_replace("�", "a", $palavra);
	str_replace("�", "a", $palavra);
	str_replace("�", "a", $palavra);
	str_replace("@", "a", $palavra);
	str_replace("�", "E", $palavra);
	str_replace("�", "E", $palavra);
	str_replace("�", "E", $palavra);
	str_replace("�", "E", $palavra);
	str_replace("�", "e", $palavra);
	str_replace("�", "e", $palavra);
	str_replace("�", "e", $palavra);
	str_replace("�", "e", $palavra);
	str_replace("�", "I", $palavra);
	str_replace("�", "I", $palavra);
	str_replace("�", "I", $palavra);
	str_replace("�", "I", $palavra);
	str_replace("�", "i", $palavra);
	str_replace("�", "i", $palavra);
	str_replace("�", "i", $palavra);
	str_replace("�", "i", $palavra);
	str_replace("�", "O", $palavra);
	str_replace("�", "O", $palavra);
	str_replace("�", "O", $palavra);
	str_replace("�", "O", $palavra);
	str_replace("�", "O", $palavra);
	str_replace("�", "o", $palavra);
	str_replace("�", "o", $palavra);
	str_replace("�", "o", $palavra);
	str_replace("�", "o", $palavra);
	str_replace("�", "o", $palavra);
	str_replace("�", "U", $palavra);
	str_replace("�", "U", $palavra);
	str_replace("�", "U", $palavra);
	str_replace("�", "U", $palavra);
	str_replace("�", "u", $palavra);
	str_replace("�", "u", $palavra);
	str_replace("�", "u", $palavra);
	str_replace("�", "u", $palavra);
	str_replace("�", "C", $palavra);
	str_replace("�", "c", $palavra);
	str_replace("�", "N", $palavra);
	str_replace("�", "n", $palavra);
	return $palavra;
}

##############################
#
#   fun��o domoney
#   Converte n�meros decimais ou inteiros para o formato 0.00 (duas casas depois da v�rgula)
#   $date = variavel a ser alterada
#
##############################

function domoney($valor) {
	$valor = str_replace("R", "", $valor);
	$valor = str_replace("U", "", $valor);
	$valor = str_replace("S", "", $valor);
	$valor = str_replace("$", "", $valor);
	$valor = str_replace(" ", "", $valor);
	$valor = str_replace(",", ".", $valor);
	if (onlynumbers($valor, ".")) {//s� pode ter n�meros e ponto se n�o retorna o mesmo valor
		$ponto = strpos($valor, ".");
		if ($ponto === 0 OR $ponto) { //se ponto existe ou � exatamente igual a zero (por que nesse caso 0 n�o � false, mas o primeiro valor da casa de uma string)
			$decimal = substr($valor, $ponto, 3);
			$valor = substr($valor, 0, $ponto);
			if ($ponto === 0) {
				$valor = "0".$valor;
			}
			
			if (strlen($decimal) == 2) {
				$decimal .= "0";
			}
			
			elseif (strlen($decimal) == 1) {
				$decimal .= "00";
			}
			
			return $valor.$decimal;
		}
		
		else {
			return $valor.".00";
		}
	}
	
	else {
		return $valor; //se o valor inserido tiver alguma coisa al�m de n�meros e o ponto, ent�o a fun��o retorna o pr�prio valor em si.
	}
}

##############################
#
#   fun��o bd2human
#   Converte a data de Banco de dados para humano
#   $date = variavel com a data a ser analisada [formato 0000-00-00]
#
##############################

function bd2human($date) {
	$date = explode("-", $date);
	$date = $date[2]."/".$date[1]."/".$date[0];
	return $date;
}

##############################
#
#   fun��o human2bd
#   Converte a data de humano para Banco de dados
#   $date = variavel com a data a ser analisada [formato 00/00/0000]
#
##############################

function human2bd($date) {
	$date = explode("/", $date);
	$date = $date[2]."-".$date[1]."-".$date[0];
	return $date;
}

##############################
#
#   fun��o ajeita
#   Essa fun��o ajeita os nomes enviados para o banco de dados que forem escritos todos em maiusculas ou minusculas para o formato de primeira letra maiuscula e o resto minuscula, com exce��o de preposi��es
#
#   $nome = o nome a ser ajeitado
#
##############################

function ajeita($nome) {
	//deixa tudo em minuscula
	$nome = lower_acento($nome);
	$nome = strtolower($nome);
	
	//divide os nomes em arrays
	$nome = explode(" ", $nome);
	
	//deixando a primeira letra maiuscula das palavras que tenham mais de 3 letras
	$RunFor = count($nome); //n�mero de vezes que o for ir� rodar
	$final_nome = "";
	for ($IntFor = 0; $IntFor < $RunFor; $IntFor++) {
		if ($nome[$IntFor] == "de" OR $nome[$IntFor] == "la" OR $nome[$IntFor] == "el" OR $nome[$IntFor] == "dos" OR $nome[$IntFor] == "da" OR $nome[$IntFor] == "das" OR $nome[$IntFor] == "do" OR $nome[$IntFor] == "com" OR $nome[$IntFor] == "e" OR $nome[$IntFor] == "na" OR $nome[$IntFor] == "no" OR $nome[$IntFor] == "nas" OR $nome[$IntFor] == "nos" OR $nome[$IntFor] == "�s" OR $nome[$IntFor] == "a" OR $nome[$IntFor] == "e" OR $nome[$IntFor] == "o" OR $nome[$IntFor] == "ou" OR $nome[$IntFor] == "pra" OR $nome[$IntFor] == "para" OR $nome[$IntFor] == "pras" OR $nome[$IntFor] == "pra" OR $nome[$IntFor] == "y") {
		}
		
		else {
			$nome[$IntFor] = ucfirst($nome[$IntFor]);
			if ($nome[$IntFor] == "Sao") { //corrigindo a mania feia de n�o colocar o tio no 'S�o' dos nomes das cidades
				$nome[$IntFor] = "S�o";
			}
			
			elseif ($nome[$IntFor] == "Joao") { 
				$nome[$IntFor] = "Jo�o";
			}
		}
	}
	$nome = implode(" ", $nome);
	return $nome;
}

##############################
#
#   fun��o dateexists
#   Verifica se a data realmente existe
#   $date = variavel com a data a ser analisada [formato 0000-00-00]
#
##############################

function dateexists($date)
{
  $date = explode("-", $date); //[0] ano; [1] mes; [2] dia;
  $datevalid = true;
  
  if ($date[1] == 0 OR $date[2] == 0) { $datevalid = false; }
  elseif ($date[1] == 1 AND $date[2] > 31)  { $datevalid = false; }
  elseif ($date[1] == 2) //calculo do bissexto
  {
    $bissexto = $date[0] % 4;
    if ($bissexto == 0) 
	{
	  if ($date[2] > 29) { $datevalid = false; } //� bissexto
	}
	
	else
	{
	  if ($date[2] > 28) { $datevalid = false; }
	}
  }
  
  elseif ($date[1] == 3 AND $date[2] > 31)  { $datevalid = false; }
  elseif ($date[1] == 4 AND $date[2] > 30)  { $datevalid = false; }
  elseif ($date[1] == 5 AND $date[2] > 31)  { $datevalid = false; }
  elseif ($date[1] == 6 AND $date[2] > 30)  { $datevalid = false; }
  elseif ($date[1] == 7 AND $date[2] > 31)  { $datevalid = false; }
  elseif ($date[1] == 8 AND $date[2] > 31)  { $datevalid = false; }
  elseif ($date[1] == 9 AND $date[2] > 30)  { $datevalid = false; }
  elseif ($date[1] == 10 AND $date[2] > 31) { $datevalid = false; }
  elseif ($date[1] == 11 AND $date[2] > 30) { $datevalid = false; }
  elseif ($date[1] == 12 AND $date[2] > 31) { $datevalid = false; }
  return $datevalid;
}

##############################
#
#   fun��o mail_valid
#   verifica se o email colocado � valido, retorna em true ou false (Email v�lido: verdadeiro? Email v�lido: falso?)
#
#   $email = o email a ser analisado
#
##############################

function mail_valid($mail) {
	$valido = true;
	
	if (strpos($mail, "@") == -1) {// tem arroba?
		$valido = false;
	}
	
	if (strpos($mail, ".com") == -1) {//tem .com
		$valido = false;
	}
	
	if (!strtolower($mail)) { //somente letras
		$valido = false;
	}
	
	if (!onlyletters($mail, "0123456789_-@.")) { //somente letras e n�mero
		$valido = false;
	}
	
	return $valido;
}

##############################
#
#   fun��o onlynumbers
#   verifica se uma string tem somente n�meros, retorna em true ou false (apenas n�mero: verdadeiro? apenas letras: falso?)
#
#   $string = variavel a ser analisada
#	$addvalues = valores adicionais a serem aceitos
#
##############################

function onlynumbers($string, $addvalues = "") {
  $valid = true;
  for ($IntFor = 0; $IntFor < strlen($string); $IntFor++)
  {
    $char = lower_acento($string[$IntFor]);
    $rightchar = false;

        if ($char == "0") { $rightchar = true; }	elseif ($char == "1") { $rightchar = true; }
    elseif ($char == "2") { $rightchar = true; }	elseif ($char == "3") { $rightchar = true; }
    elseif ($char == "4") { $rightchar = true; }	elseif ($char == "5") { $rightchar = true; }
    elseif ($char == "6") { $rightchar = true; }	elseif ($char == "7") { $rightchar = true; }
    elseif ($char == "8") { $rightchar = true; }	elseif ($char == "9") { $rightchar = true; }
	
	if (strlen($addvalues) != "") //se n�o tiver nada na variavel de valores adicionais
	{
	  for ($IntFor2 = 0; $IntFor2 < strlen($addvalues); $IntFor2++)
	  {
	    $lowed = strtolower($addvalues[$IntFor2]);
		$lowed = lower_acento($lowed);
	    if ($char == $lowed) { $rightchar = true; }
	  }
	}
	
	if ($rightchar == false) { $valid = false; } //se ele n�o achou nenhuma das caracteres acima, o barato � invalido (caracteres especiais, letras etc.)
  }
 
  return $valid;
}

##############################
#
#   fun��o onlyletters
#   verifica se uma string tem somente letras ou espa�o, retorna em true ou false (apenas letras: verdadeiro? apenas letras: falso?)
#
#   $string = variavel a ser analisada
#	$addvalues = valores adicionais a serem aceitos
#
##############################

function onlyletters($string, $addvalues = "") {
  $valid = true;
  for ($IntFor = 0; $IntFor < strlen($string); $IntFor++)
  {
    $char = lower_acento($string[$IntFor]);
    $rightchar = false;

        if ($char == "a") { $rightchar = true; }	elseif ($char == "b") { $rightchar = true; }
    elseif ($char == "c") { $rightchar = true; }	elseif ($char == "d") { $rightchar = true; }
    elseif ($char == "e") { $rightchar = true; }	elseif ($char == "f") { $rightchar = true; }
    elseif ($char == "g") { $rightchar = true; }	elseif ($char == "h") { $rightchar = true; }
    elseif ($char == "i") { $rightchar = true; }	elseif ($char == "j") { $rightchar = true; }
    elseif ($char == "k") { $rightchar = true; }	elseif ($char == "l") { $rightchar = true; }
    elseif ($char == "m") { $rightchar = true; }	elseif ($char == "n") { $rightchar = true; }
    elseif ($char == "o") { $rightchar = true; }	elseif ($char == "p") { $rightchar = true; }
    elseif ($char == "q") { $rightchar = true; }	elseif ($char == "r") { $rightchar = true; }
    elseif ($char == "s") { $rightchar = true; }	elseif ($char == "t") { $rightchar = true; }
    elseif ($char == "u") { $rightchar = true; }	elseif ($char == "v") { $rightchar = true; }
    elseif ($char == "w") { $rightchar = true; }	elseif ($char == "x") { $rightchar = true; }
    elseif ($char == "y") { $rightchar = true; }	elseif ($char == "z") { $rightchar = true; }
	elseif ($char == " ") { $rightchar = true; }
	
	if (strlen($addvalues) != "") //se n�o tiver nada na variavel de valores adicionais
	{
	  for ($IntFor2 = 0; $IntFor2 < strlen($addvalues); $IntFor2++)
	  {
		$lowed = lower_acento($addvalues[$IntFor2]);
	    if ($char == $lowed) { $rightchar = true; }
	  }
	}
	
	if ($rightchar == false) { $valid = false; } //se ele n�o achou nenhuma das caracteres acima, o email � invalido (caracteres especiais, letras com acento etc.)
  }
 
  return $valid;
}

##############################
#
#   fun��o lower_acento
#   deixa todas as letras do termo em minusculas, incluindo acentos.
#
#   $term = a palavra a ter os acentos tornados em minusculas
#
##############################

function lower_acento($term) {
	$palavra = strtr(strtolower($term),"������������������������������","������������������������������");
    return $palavra;
}

##############################
#
#   fun��o upper_acento
#   deixa todas as letras do termo em maiusculas, incluindo acentos.
#
#   $term = a palavra a ter os acentos tornados em maiusculas
#
##############################

function upper_acento($term) {
	$palavra = strtr(strtoupper($term),"������������������������������","������������������������������");
	return $palavra;
}


#######################
#
#   fun��o getip
#   pega o endere�o de IP do usu�rio
#
#######################

function getip()
{
  //$ipuser =  $_SERVER['HTTP_CLIENT_IP'];
  if (!empty($_SERVER['HTTP_CLIENT_IP']))
  {
    $ipuser = $_SERVER['HTTP_CLIENT_IP'];
  }

  elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
  {
   $ipuser = $_SERVER['HTTP_X_FORWARDED_FOR'];
 }

  else
  {
    $ipuser = $_SERVER['REMOTE_ADDR'];
  }
  return $ipuser;
}

######################################################################
#
#   Nome: delete
#   Descri��o: deleta todos os arquivos de uma pasta
#   $dir > diret�rio atual da imagem
#
######################################################################

function killdir($dir)
{
  $path = $dir;
  $dir = opendir($dir);
  while ($files = readdir($dir))
  {
    unlink($path."/".$files);
  }
}

######################################################################
#
#   Nome: ifnotpassed (Se n�o passou)
#   Descri��o: Escreve o valor inserido se a data n�o tiver passado
#   $time > analisa se esse dia j� passou, formato 0000-00-00
#   $string > se o dia N�o tiver passado, retorna esse valor
#
######################################################################

function ifnotpassed($time, $string="")
{
	if (strpos($time, "/")) {
		$time = human2bd($time);
	}
    $d = substr($time, 8, 2);
    $m = substr($time, 5, 2);
    $y = substr($time, 0, 4);

    if ((date("d") <= $d AND date("m") == $m AND date("Y") == $y) OR (date("m") < $m AND date("Y") == $y) OR (date("Y") < $y))
    {
		if ($string != "") {
			return $string; //retorna o valor pedido pelo programador
		}

		else {
			return true;
		}
    }
	
	else {
		return false;
	}
}

######################################################################
#
#   Nome: nextday (Pr�ximo dia)
#   Descri��o: Descobre que dia ser� amanh�
#   $data > o dia
#   $dias > quantos dias a frente desse dia voc� quer saber qual �
#
######################################################################

function nextday($data, $dias=1)
{
	$novadata = explode("/",$data);
	$dia = $novadata[0];
	$mes = $novadata[1];
	$ano = $novadata[2];

	if ($dias==0)
	{return date('d/m/Y',mktime(0,0,0,$mes,$dia,$ano));}
	else
	{return date('d/m/Y',mktime(0,0,0,$mes,$dia+$dias,$ano));}
}

######################################################################
#
#   Nome: numbtomonth (N�mero para m�s)
#   Descri��o: converte um n�mero de 1 � 12 no nome de um m�s
#   $M > N�mero do m�s
#
######################################################################

function numbtomonth($M)
{
  if      ($M == 1)  { $M = "janeiro"; }
  else if ($M == 2)  { $M = "fevereiro"; }
  else if ($M == 3)  { $M = "mar�o"; }
  else if ($M == 4)  { $M = "abril"; }
  else if ($M == 5)  { $M = "maio"; }
  else if ($M == 6)  { $M = "junho"; }
  else if ($M == 7)  { $M = "julho"; }
  else if ($M == 8)  { $M = "agosto"; }
  else if ($M == 9)  { $M = "setembro"; }
  else if ($M == 10) { $M = "outubro"; }
  else if ($M == 11) { $M = "novembro"; }
  else if ($M == 12) { $M = "dezembro"; }
  return $M;
}

######################################################################
#
#   Nome: redimenciona
#   Descri��o: Redimenciona imagens
#   $origem > Local onde o arquivo est�
#	$destino > Para onde ele deve ir
#	$maxlargura > largura m�xima que ele pode tomar
#	$maxaltura > altura m�xima que ele pode tomar
#	$qualidade > qualidade da imagem
#
######################################################################
function redimensiona($origem, $destino, $maxlargura=640, $maxaltura=460, $qualidade=80){
	if(!strstr($origem,"http") && !file_exists($origem)){
		echo("Arquivo de origem da imagem inexistente");
		return false;
	}
	$ext = strtolower(end(explode('.', $origem)));
	
	if($ext == "jpg" || $ext == "jpeg"){
		$img_origem = imagecreatefromjpeg($origem);
	}
	
	elseif ($ext == "gif") {
		$img_origem = imagecreatefromgif($origem);
	}
	
	elseif ($ext == "png") {
		$img_origem = imagecreatefrompng($origem);
	}
	
	if(!$img_origem){
		echo("Erro ao carregar a imagem, talvez formato nao suportado");
		return false;
	}
	$alt_origem = imagesy($img_origem);
	$lar_origem = imagesx($img_origem);
	$escala = min($maxaltura/$alt_origem, $maxlargura/$lar_origem);
	if($escala < 1) {
		$alt_destino = floor($escala*$alt_origem);
		$lar_destino = floor($escala*$lar_origem);
		// Cria imagem de destino
		$img_destino = imagecreatetruecolor($lar_destino,$alt_destino);
		// Redimensiona
		imagecopyresampled($img_destino, $img_origem, 0, 0, 0, 0, $lar_destino, $alt_destino, $lar_origem, $alt_origem);
		imagedestroy($img_origem);
	}
	
	else {
		$img_destino = $img_origem;
	}
	
	$ext = strtolower(end(explode('.', $destino)));
	if($ext == "jpg" || $ext == "jpeg") {
		imagejpeg($img_destino, $destino, $qualidade);
		return true;
	}
	
	elseif ($ext == "gif") {
		imagepng($img_destino, $destino);
		return true;
	}
	
	elseif ($ext == "png") {
		imagepng($img_destino, $destino);
		return true;
	}
	
	else {
		echo("Formato de destino n�o suportado");
		return false;
	}
}
?>