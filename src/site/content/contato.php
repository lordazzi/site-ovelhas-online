<?
include("../conn.php");
//importa as bibliotecas necessarias para enviar email
include("../../plugins/php/PHPMailer_v5.1/class.phpmailer.php");
//importa as bibliotecas necessarias para integração com o pagseguro
include("../../plugins/php/PagSeguroLibrary/PagSeguroLibrary.php");

if ($_POST["envia_log"]) {
	$erro = "";
	
	//Validando o nome
	if ($_POST["nome"] != "") {
		if (strpos($_POST["nome"], " ")) {
			if (onlyletters($_POST["nome"], "áéíóúâêôãõç")) {
				$nome = addslashes($_POST["nome"]);
				$nome = ajeita($nome);
			}
			
			else {
				$erro .= "Você deve colocar um sobrenome!\\n";
			}
		}
		
		else {
			$erro .= "Você deve colocar um sobrenome.\\n";
		}
	}
	
	else {
		$erro .= "O campo do nome não pode ser nulo.\\n";
	}
	
	
	//Validando o email
	if ($_POST["mail"] != "") {
		if (mail_valid($_POST["mail"])) {
			$mail = strtolower($_POT["mail"]);
			$mail = addslashes($mail);
		}
		
		else {
			$erro .= "O email digitado é inválido.\\n";
		}
	}
	
	else {
		$erro .= "O campo do email não pode ser nulo!\\n";
	}
	
	//Validando telefone
	if ($_POST["fone"] != "") {
		//[0][1][2][3][4][5][6][7][8][9][0][1][2][3]
		// (  9  9  )     9  9  9  9  .  9  9  9  9
		if (strlen($_POST["fone"]) == 14) {
			if ($_POST["fone"][0] == "(" AND $_POST["fone"][3] == ")" AND $_POST["fone"][4] == " " AND $_POST["fone"][9] == ".") {
				$fone = str_replace("(", "", $_POST["fone"]);
				$fone = str_replace(")", "", $fone);
				$fone = str_replace(" ", "", $fone);
				$fone = str_replace(".", "", $fone);
				if (onlynumbers($fone)) {
					$fone = addslashes($_POST["fone"]);
				}
				
				else {
					$erro .= "O telefone digitado é invalido.\\n";
				}
			}
			
			else {
				$erro .= "O telefone digitado é invalido.\\n";
			}
		}
		
		else {
			$erro .= "O telefone digitado é invalido.\\n";
		}
	}
	
	else {
		$erro .= "O campo do telefone não pode ser nulo.\\n";
	}
	
	if ($_POST["tipo"] == 0 OR $_POST["tipo"] == 1 OR $_POST["tipo"] == 2 OR $_POST["tipo"] == 3 OR $_POST["tipo"] == 4 OR $_POST["tipo"] == 5 OR $_POST["tipo"] == 6) {
		$tipo = $_POST["tipo"];
		if ($_POST["tipo"] == 3) {
			if ($_POST["doacao"] != "") {
				$doacao = str_replace("R", "", $_POST["doacao"]);
				$doacao = str_replace("$", "", $doacao);
				$doacao = str_replace("S", "", $doacao);
				$doacao = str_replace("U", "", $doacao);
				$doacao = str_replace(",", ".", $doacao);
				if (onlynumbers(str_replace(".", "", $doacao))) {
					$doacao = $doacao;
				}
				
				else {
					$erro .= "O campo do valor da doação contém valores inválidos!\\n";
				}
			}
			
			else {
				$erro .= "O campo do valor da doação não pode ser nulo!\\n";
			}
		}
	}
	
	else {
		$erro .= "Você selecionou uma opção que não existe.\\n";
	}
	
	if ($_POST["content"] != "") {
		if (onlyletters($_POST["content"], "áéíóúçâêôûîüäëãõñ-_1234567890,.;:[]}{()!?º°¹²³£¢¬'@#$%¨&*+=".'"')) {
			$content = addslashes($_POST["content"]);
			$content = str_replace("<", "&lt;", $content);
			$content = str_replace(">", "&gt;", $content);
			$content = nl2br($content);
		}
		
		else {
			$erro .= "Há caracteres inválidos no campo da mensagem.\\n";
		}
	}
	
	else {
		$erro .= "Você está tentando enviar uma mensagem nula, isso não é possivel.\\n";
	}
	
	if ($erro == "") {
		mysql_query("INSERT INTO logs (nome, email, telefone, tipo, content, quando) VALUES ('$nome', '$email', '$fone', $tipo, '$content', '".date("Y-m-d h:i:s")."')");
		$iddoacao = mysql_insert_id();
		$iddoacao = "DOA.".$iddoacao; //todas as doações começam com 10
	
	/*	/ENVIANDO O EMAIL
		$phpmail = new PHPMailer();
		$phpmail->IsHTML(true);
		$phpmail->IsSMTP(); //Informa que será utilizado o SMTP para envio do e-mail
		$phpmail->SMTPAuth = true; //Informa que a conexão com o SMTP será autênticado
		$phpmail->Mailer = "smtp";
		
		//Configuração de HOST do SMTP
		$phpmail->Host = "ssl://smtp.gmail.com"; // specify main and backup server
		$phpmail->Port = 465; // set the port to use
		//$phpmail->Host = "smtp.mail.yahoo.com"; //Verifique qual o SMTP do seu domínio
		$phpmail->Username = "razzis91@gmail.com"; //Usuário para autênticação do SMTP
		$phpmail->Password = "jesus25120000"; //Senha para autênticação do SMTP*/
		if ($tipo == 0) { $motivo = "Mensagem normal"; }
		elseif ($tipo == 1) { $motivo = "Elogio"; }
		elseif ($tipo == 2) { $motivo = "Trabalho"; }
		elseif ($tipo == 3) { $motivo = "Doar"; }
		elseif ($tipo == 4) { $motivo = "Reportar erro"; }
		elseif ($tipo == 5) { $motivo = "Reclamação"; }
		elseif ($tipo == 6) { $motivo = "Outros"; }
	/*	$phpmail->Subject  = "OVELHAS ONLINE ($motivo)"; //Titulo do e-mail que será enviado

		//Preenchimento do campo FROM do e-mail
		$phpmail->From = $phpmail->Username;
		$phpmail->FromName = "OVELHAS ONLINE";

		//E-mail para a qual o e-mail será enviado
		$phpmail->AddAddress("ricardoazzi91@hotmail.com");

		//Conteúdo do e-mail
		$phpmail->Body = */ $body = "
		<b>Nome:</b> ".$nome."<br />
		<b>Email:</b> ".$mail."<br />
		<b>Telefone:</b> ".$fone."<br />";
		if ($tipo == 3) { $body .= "<b>Valor:</b> ".$doacao."<br />"; }
		$body .= "<br />
		<b>Mensagem:</b><br />
		".$content;
	/*	$phpmail->AltBody = $phpmail->Body;

		//Dispara o e-mail: PÁ! PÁ! PÁ! ulululu
		$enviado = $phpmail->Send();*/
		mail("ricardoazzi91@hotmail.com", "OVELHAS ONLINE ($motivo)", $body);
				
		//PARTE EXECUTADA CASO O USUÁRIO INDIQUE DESEJO DE FAZER UMA DOAÇÃO
		if ($tipo == 3) {
			//Inserindo uma paga como forma de doação
			mysql_query("INSERT INTO cliente_servico_paga (idcliente_servico, titulo, abre, valor, multa_abre, multa_valor, fecha, pago, donation) VALUES (0, 'Doação de $nome', '".date("Y-m-d")."', '$doacao', '".date("Y-m-d")."', '0.00', '".date("Y-m-d")."', 0, 1)");
			$idtrans = mysql_insert_id();
			$idtrans = "10".$idtrans; //10 identifica que se trata de uma doação
			$pagseguro = new PaymentRequest(); //Criando o objeto
			$pagseguro->setCurrency('BRL'); //a moeda
			$pagseguro->setReference($iddoacao); //id da compra em string?
			
			//extraindo o telefone e o DDD
			$tel_ddd = substr($tel, 0, 2);
			$tel_content = substr($tel, 2);
			
			$pagseguro->setSender($nome, $mail, $tel_ddd, $tel_content); //Nome do comprador, email do comprador, DDD do comprador, telefone do comprador
			
			/* * Informa o Tipo de Frete:
			* 1 => Encomenda normal (PAC)
			* 2 => SEDEX
			* 3 => Tipo de frete não especificado
			* */
			$pagseguro->setShippingType(3);
			$pagseguro->setShippingAddress(
				"", /*cep*/  
				"", //endereço
				"", //número
				"", //complemento
				"", //bairro
				"", //cidade
				"", //estado
				'BRA' //país
			);
			
			/* *
			 * Agora vamos adicionar os produtos.
			 * O objetivo do peso do produto é o cálculo do frete.
			 * Esse valor terá que ser inteiro. Então 0,300 será 300.
			 * Você pode adicionar quantos produtos desejar em uma compra.
			 * ID da compra
			 * Produto
			 * Quantidade
			 * Valor
			 * Peso
			 */
			$valor = $doacao; 
			$pagseguro->addItem($idtrans, 'Doação para os desenvolvedores de Ovelhas Online', 1, $valor, 0);
			
			//Enviando a solicitação de compra
			$credenciais = new AccountCredentials('ricardoazzi91@hotmail.com', 'D063506DF1364C0DAA92171B4844F533');
			$url = $pagseguro->register($credenciais);
			header("Location: $url");
		}
		
		echo "
			<script type='text/javascript'>
				alert('Sua mensagem foi enviada com sucesso!');
			</script>
		";
	}
	
	else {
		echo "
			<script type='text/javascript'>
				alert('".$erro."');
			</script>
		";
	}
}

include("../header.php");
?>
<!-- JavaScript da mascara -->
<script type="text/javascript" src="../../plugins/js/maskedinput/jquery.maskedinput-1.1.4.pack.js"/></script> <!-- mascara -->
<script type="text/javascript">
	function loadmasks() {
		$("#fone").mask("(99) 9999.9999");
	}
	
	function open_donate() {
		document.getElementById("js_donate").innerHTML = "<label for='doacao'>Valor: <input type='text' name='doacao' maxlength='16' value='<? echo $_POST["doacao"]; ?>' /></label><br />";
	}
	
	function close_donate() {
		document.getElementById("js_donate").innerHTML = "";
	}
	
	function change() {
		if (document.getElementById("js_getmyvalue").value == 0) {
			document.getElementById("js_changeme").innerHTML = "Escreva a mensagem:";
			close_donate();
		}
		
		else if (document.getElementById("js_getmyvalue").value == 1) {
			document.getElementById("js_changeme").innerHTML = "Escreva o seu elogio ;D";
			close_donate();
		}
		
		else if (document.getElementById("js_getmyvalue").value == 2) {
			document.getElementById("js_changeme").innerHTML = "Descreva o que deseja:";
			close_donate();
		}
		
		else if (document.getElementById("js_getmyvalue").value == 3) {
			document.getElementById("js_changeme").innerHTML = "Eba!";
			open_donate();
		}
		
		else if (document.getElementById("js_getmyvalue").value == 4) {
			document.getElementById("js_changeme").innerHTML = "Encontrou um erro em nossos websites?";
			close_donate();
		}
		
		else if (document.getElementById("js_getmyvalue").value == 5) {
			document.getElementById("js_changeme").innerHTML = "Ixi! O que acontece?";
			close_donate();
		}
		
		else if (document.getElementById("js_getmyvalue").value == 6) {
			document.getElementById("js_changeme").innerHTML = "Escreva o que deseja:";
			close_donate();
		}
	}
	
</script>

<IMG src="../../plugins/gif/background.png" style="width: 1035px; height: 450px; position: absolute; left: 0px; top: -10px;" />

<div id="contato">
	<form method="POST" action="">
		<label for="nome">Nome: <input type="text" name="nome" maxlength="32" value="<? echo $_POST["nome"]; ?>" /></label><br />
		<label form="mail">Email: <input type="text" name="mail" maxlength="64" value="<? echo $_POST["mail"]; ?>" /></label><br />
		<label form="fone">Telefone: <input type="text" name="fone" id="fone" maxlength="32" value="<? echo $_POST["fone"]; ?>" /></label><br />
		<label for="tipo">Tipo:
			<select name="tipo" id="js_getmyvalue" onChange="change();">
				<option value="0">Mensagem normal</option>
				<option value="1">Elogio</option>
				<option value="2">Trabalho</option>
				<option value="3">Doar</option>
				<option value="4">Reportar erro</option>
				<option value="5">Reclamação</option>
				<option value="6">Outro</option>
			</select>
		</label><br />
		<span id="js_donate"></span>
		<?
			if ($_POST["envia_log"]) {
				echo "
					<script type='text/javascript'>
						document.getElementById('js_getmyvalue').value = '".$_POST["tipo"]."';
						change();
					</script>
				";
			}
		?>
		<label for="content"><span id="js_changeme">Escreva a mensagem:</span><br />
			<textarea name="content"><? echo $_POST["content"]; ?></textarea>
		</label><br />
		<input type="submit" name="envia_log" value="Enviar" />
	</form>
</div>

<script type="text/javascript">
	loadmasks();
</script>

<IMG src="../../plugins/gif/lixo_moscas.gif" style="position: absolute; left: 60px; top: 300px; height: 100px;" />
<IMG src="../../plugins/gif/mesa.png" style="position: absolute; left: 575px; top: 120px; height: 320px; z-index: 1;" />
<IMG src="../../plugins/gif/cafe.gif" style="position: absolute; left: 735px; top: 210px; height: 50px; z-index: 2;" />
<IMG src="../../plugins/gif/balero.png" style="position: absolute; left: 670px; top: 150px; height: 50px; z-index: 1;" />
<IMG src="../../plugins/gif/balero.png" style="position: absolute; left: 670px; top: 250px; height: 50px; z-index: 1;" />
<IMG src="../../plugins/gif/ovelha_chefe.gif" style="height: 150px; position: absolute; top: 180px; left: 775px;" />

<?
include("../footer.php");
?>