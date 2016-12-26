<?
include("../conn.php");
if (!$_SESSION["admin"]) { header("location: ..\..\site\content\index.php"); exit; }
include("../header.php");
include("../sidebar.php");

if ($_POST["proximo"]) {
	$erro = "";
	
	//LOGIN
	if ($_POST["login"] != "") {
		if (onlyletters($_POST["login"], "1234567890_-")) {
			$login = addslashes($_POST["login"]);
		}
		
		else {
			$erro .= "H· caracteres inv·lidos no campo do login. \\n";
		}
	}
	
	else {
		$erro .= "O campo do login n„o pode ser nulo. \\n";
	}
	
	//SENHA
	if ($_POST["senha1"] != "") {
		if (strlen($_POST["senha1"]) > 5) {
			if ($_POST["senha1"] == $_POST["senha2"]) {
				$senha = MD5($_POST["senha1"]);
			}
			
			else {
				$erro .= "As senhas n„o coincidem. \\n";
			}
		}
		
		else {
			$erro .= "A senha deve conter pelo pelo menos 5 digitos. \\n";
		}
	}
	
	else {
		$erro .= "O campo da senha n„o pode ser nulo. \\n";
	}
	
	//NOME DA EMPRESA
	if ($_POST["nome_juridico"] != "") {
		if (onlyletters($_POST["nome_juridico"], "!@#$%®&*()_+1234567890-=[]¥~`^;:.,'Á·ÈÌÛ˙‚ÍÙ˚‡ÚÏ„ı¸".'"')) {
			$nome_juridico = addslashes($_POST["nome_juridico"]);
			$nome_juridico = ajeita($nome_juridico);
		}
		
		else {
			$erro .= "VocÍ colocou caracteres inv·lidos no nome da empresa. \\n";
		}
	}
	
	else {
		$erro .= "O campo do nome da empresa n„o pode ser nulo. \\n";
	}
	
	//LOGO
	if ($_FILES["logo"]) {
		$ext = explode(".", $_FILES["logo"]["name"]);
		$ext = strtolower($ext[1]);
		if ($ext == "jpg" OR $ext == "jpeg" OR $ext == "png" OR $ext == "bmp" OR $ext == "gif") {
		}
		
		else {
			$erro .= "O arquivo est· em um formato n„o suportado. \\n";
		}
	}
	
	else {
		$erro .= "VocÍ precisa escolher um arquivo de imagem para servir de logotipo.\\n";
	}
	
	//NOME FISICO
	if ($_POST["nome_fisico"] != "") {
		if (onlyletters($_POST["nome_fisico"], "·ÈÌÛ˙„ı‚ÍÙÁ")) {
			$nome_fisico = addslashes($_POST["nome_fisico"]);
			$nome_fisico = ajeita($nome_fisico);
		}
		
		else {
			$erro .= "O nome do respons·vel pela empresa n„o pode ser nulo. \\n";
		}
	}
	
	else {
		$erro .= "O nome do respons·vel pela empresa n„o pode ser nulo. \\n";
	}
	
	//ESTADO
	if ($_POST["estado"] == "AC" OR $_POST["estado"] == "AL" OR $_POST["estado"] == "AM" OR $_POST["estado"] == "AP" OR $_POST["estado"] == "BA" OR $_POST["estado"] == "CE" OR $_POST["estado"] == "DF" OR $_POST["estado"] == "ES" OR $_POST["estado"] == "GO" OR $_POST["estado"] == "MA" OR $_POST["estado"] == "MG" OR $_POST["estado"] == "MS" OR $_POST["estado"] == "MT" OR $_POST["estado"] == "PA" OR $_POST["estado"] == "PB" OR $_POST["estado"] == "PE" OR $_POST["estado"] == "PI" OR $_POST["estado"] == "PR" OR $_POST["estado"] == "RJ" OR $_POST["estado"] == "RN" OR $_POST["estado"] == "RO" OR $_POST["estado"] == "RR" OR $_POST["estado"] == "RS" OR $_POST["estado"] == "SC" OR $_POST["estado"] == "SE" OR $_POST["estado"] == "SP" OR $_POST["estado"] == "TO") {
		$estado = addslashes($_POST["estado"]);
	}
	
	else {
		$erro .= "O estado que vocÍ escolhe È inv·lido. \\n";
	}
	
	//CIDADE
	if ($_POST["cidade"] != "") {
		if (onlyletters($_POST["cidade"], "·ÈÌÛ˙„ı‚ÙÍÁ1234567890-")) {
			$cidade = addslashes($_POST["cidade"]);
			$cidade = ajeita($cidade);
		}
		
		else {
			$erro .= "H· caracteres inv·lidos no campo da cidade. \\n";
		}
	}
	
	else {
		$erro .= "O campo da cidade n„o pode ser nulo. \\n";
	}
	
	//BAIRRO
	if ($_POST["bairro"] != "") {
		if (onlyletters($_POST["bairro"], "·ÈÌÛ˙„ı‚ÙÍÁ1234567890-")) {
			$bairro = addslashes($_POST["bairro"]);
			$bairro = ajeita($bairro);
		}
		
		else {
			$erro .= "H· caracteres inv·lidos no campo do nome do bairro. \\n";
		}
	}
	
	else {
		$erro .= "O campo do nome do bairro n„o pode ser nulo. \\n";
	}
	
	//LOGRA
	if ($_POST["logra"] != "") {
		if (onlyletters($_POST["logra"], "·ÈÌÛ˙„ı‚ÙÍÁ1234567890-")) {
			$logra = addslashes($_POST["logra"]);
			$logra = ajeita($logra);
		}
		
		else {
			$erro .= "H· caracteres inv·lidos no campo do nome do logradouro. \\n";
		}
	}
	
	else {
		$erro .= "O nome do logradouro n„o pode ser nulo. \\n";
	}
	
	//NUMERO
	if ($_POST["numero"] != "") {
		if (onlynumbers($_POST["numero"], "acbdeABCDE")) {
			$numero = addslashes($_POST["numero"]);
		}
		
		else {
			$erro .= "H· letras inv·lidas no campo do n˙mero. \\n";
		}
	}
	
	else {
		$erro .= "O campo do n˙mero n„o pode ser nulo. \\n";
	}
	
	//COMP (O campo pode ser nulo)
	if ($_POST["comp"] != "") {
		if (onlyletters($_POST["comp"], "·ÈÌÛ˙„ı‚ÙÍÁ1234567890:-.,;")) {
			$comp = addslashes($_POST["comp"]);
		}
		
		else {
			$erro .= "H· caracteres inv·lidos no campo do complemento. \\n";
		}
	}
	
	//DESCRIPTION (O campo pode ser nulo)
	if ($_POST["description"] != "") {
		if (onlyletters($_POST["description"], "1234567890!@#$%®&*()'[]{}·ÈÌÛ˙„ı‚ÙÍÁ,.;:¥~`^-=_+|/™∫π≤≥£¢¨".'"')) {
			$description = addslashes($_POST["description"]);
			$description = nl2br($description);
		}
		
		else {
			$erro .= "H· caracteres inv·lidos na descriÁ„o do cliente. \\n";
		}
	}
	
	if ($erro == "") {
		$novo_nome = addslashes($_POST["login"]).date("ymdhis").".".$ext;
		if (mysql_query("INSERT INTO cliente (login, senha, firstlogin, nome_juridico, logo, nome_fisico, estado, cidade, bairro, logradouro, numero, complemento, description) VALUES ('$login', '$senha', '0', '$nome_juridico', '$novo_nome', '$nome_fisico', '$estado', '$cidade', '$bairro', '$logra', '$numero', '$comp', '$description')")) {
			$myid = mysql_insert_id();
			move_uploaded_file($_FILES["logo"]["tmp_name"], "../../arquivo/cliente_logo/tmp_".$novo_nome);
			redimensiona("../../arquivo/cliente_logo/tmp_".$novo_nome, "../../arquivo/cliente_logo/".$novo_nome, 230, 75, 100);
			del("../../arquivo/cliente_logo/tmp_".$novo_nome);
			echo "
				<script type='text/javascript'>
					window.location.href = 'cliente_next.php?next=$myid';
				</script>
			";
		}
		
		else {
			echo "
				<script type='text/javascript'>
					alert('Ocorreu um erro durante a gravaÁ„o dos dados.');
				</script>
			";
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
?>
<form method="POST" action="" enctype="multipart/form-data" style="margin: 40px;">
	<label for="login">Login: <input name="login" type="text" maxlength="32" value="<? echo $_POST["login"]; ?>" /></label><br />
	<label for="senha1">Senha: <input name="senha1" type="password" maxlength="32" value="<? echo $_POST["senha1"]; ?>" /></label><br />
	<label for="senha2">Confimar senha: <input name="senha2" type="password" maxlength="32" value="<? echo $_POST["senha2"]; ?>" /></label><br />
	<br />
	<label for="nome_juridico">Nome da empresa<input name="nome_juridico" type="text" maxlength="64" value="<? echo $_POST["nome_juridico"]; ?>" /></label><br />
	<label for="logo">Logotipo da empresa <input name="logo" type="file" size="1" /></label><br />
	<label for="nome_fisico">Nome do respons·vel <input name="nome_fisico" type="text" maxlength="64" value="<? echo $_POST["nome_fisico"]; ?>" /></label><br />
	<br />
	<label for="estado">Estado
		<select name="estado" id="js_estado">
			<option value="AC">Acre</option>
			<option value="AL">Alagoas</option>
			<option value="AM">Amazonas</option>
			<option value="AP">Amap·</option>
			<option value="BA">Bahia</option>
			<option value="CE">Cear·</option>
			<option value="DF">Distrito Federal</option>
			<option value="ES">Espirito Santo</option>
			<option value="GO">Goi·s</option>
			<option value="MA">Maranh„o</option>
			<option value="MG">Minas Gerais</option>
			<option value="MS">Mato Grosso do Sul</option>
			<option value="MT">Mato Grosso</option>
			<option value="PA">Par·</option>
			<option value="PB">ParaÌba</option>
			<option value="PE">Pernambuco</option>
			<option value="PI">PiauÌ</option>
			<option value="PR">Paran·</option>
			<option value="RJ">Rio de Janeiro</option>
			<option value="RN">Rio Grande do Norte</option>
			<option value="RO">RondÙnia</option>
			<option value="RR">Roraima</option>
			<option value="RS">Rio Grande do Sul</option>
			<option value="SC">Santa Catarina</option>
			<option value="SE">Sergipe</option>
			<option value="SP" selected="selected">S„o Paulo</option>
			<option value="TO">Tocantins</option>
		</select>
	</label><br />
	<? 
	if ($_POST["estado"]) {
		echo "
			<script type='text/javascript'>
				document.getElementById('js_estado').value = '".$_POST["estado"]."';
			</script>
		";
	}
	?>
	<label for="cidade">Cidade <input name="cidade" type="text" maxlength="64" value="<? echo $_POST["cidade"]; ?>" /></label><br />
	<label for="bairro">Bairro <input name="bairro" type="text" maxlength="64" value="<? echo $_POST["bairro"]; ?>" /></label><br />
	<label for="logra">Logradouro <input name="logra" type="text" maxlength="64" value="<? echo $_POST["logra"]; ?>" /></label><br />
	<label for="numero">N˙mero <input name="numero" type="text" maxlength="16" value="<? echo $_POST["numero"]; ?>" /></label><br />
	<label for="comp">Complemento <input name="comp" type="text" maxlength="64" value="<? echo $_POST["comp"]; ?>" /></label><br />
	<br />
	<label for="description">DescriÁ„o do negÛcio do cliente<br />
		<textarea name="description"><? echo $_POST["description"]; ?></textarea>
	</label><br />
	<input type="submit" name="proximo" value="PrÛximo" style="font-size: 15px; font-weight: bold; height: 25px; margin: -25px 0 0; width: 100px;" />
</form>
<? include("../footer.php"); ?>