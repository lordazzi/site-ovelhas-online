<?php
include("../conn.php");

header('Content-Type: text/html; charset=ISO-8859-1');

define('TOKEN', 'D063506DF1364C0DAA92171B4844F533');

class PagSeguroNpi {
	
	private $timeout = 20; // Timeout em segundos
	
	public function notificationPost() {
		$postdata = 'Comando=validar&Token='.TOKEN;
		foreach ($_POST as $key => $value) {
			$valued    = $this->clearStr($value);
			$postdata .= "&$key=$valued";
		}
		return $this->verify($postdata);
	}
	
	private function clearStr($str) {
		if (!get_magic_quotes_gpc()) {
			$str = addslashes($str);
		}
		return $str;
	}
	
	private function verify($data) {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, "https://pagseguro.uol.com.br/pagseguro-ws/checkout/NPI.jhtml");
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$result = trim(curl_exec($curl));
		curl_close($curl);
		return $result;
	}

}

if (count($_POST) > 0) {
	// POST recebido, indica que é a requisição do NPI.
	$npi = new PagSeguroNpi();
	$result = $npi->notificationPost();
	
	$transacaoID = isset($_POST['TransacaoID']) ? $_POST['TransacaoID'] : '';
	
	if ($result == "VERIFICADO") {
		//Verificando se já existe algum registro relacionado a esse item
		$data = mysql_query("SELECT * FROM paga_pagseguro WHERE Referencia=".addslashes($_POST["Referencia"]));
		if (mysql_num_rows($data)) {
			$DataTransacao = explode(" ", $_POST["DataTransacao"]);
			$DataTransacao[0] = human2bd($DataTransacao[0]);
			$DataTransacao = $DataTransacao[0]." ".$DataTransacao[1];
			mysql_query("UPDATE paga_pagseguro SET Extras='".addslashes($_POST["Extras"])."', TipoFrete='".addslashes($_POST["TipoFrete"])."', ValorFrete='".addslashes($_POST["ValorFrete"])."', Anotacao='".addslashes($_POST["Anotacao"])."', DataTransacao='".addslashes($DataTransacao)."', TipoPagamento='".addslashes($_POST["TipoPagamento"])."', StatusTransacao='".addslashes($_POST["StatusTransacao"])."', NumItens='".addslashes($_POST["NumItens"])."', Parcelas='".addslashes($_POST["Parcelas"])."' WHERE Referencia='".addslashes($_POST["Referencia"])."' AND idpaga=".addslashes($_POST["TransacaoID"]));
		}
		
		else {
			$DataTransacao = explode(" ", $_POST["DataTransacao"]);
			$DataTransacao[0] = human2bd($DataTransacao[0]);
			$DataTransacao = $DataTransacao[0]." ".$DataTransacao[1];
			mysql_query("INSERT INTO paga_pagseguro (idpaga, VendedorEmail, Referencia, Extras, TipoFrete, ValorFrete, Anotacao, DataTransacao, TipoPagamento, StatusTransacao, CliNome, CliEmail, CliEndereco, CliNumero, CliComplemento, CliBairro, CliCidade, CliEstado, CliCEP, CliTelefone, NumItens, Parcelas) VALUES ('".addslashes($_POST["TransacaoID"])."', '".addlashes($_POST["VendedorEmail"])."', '".addslashes($_POST["Referencia"])."', '".addslashes($_POST["Extras"])."', '".addslashes($_POST["TipoFrete"])."', '".addslashes($_POST["ValorFrete"])."', '".addslashes($_POST["Anotacao"])."', '".addslashes($DataTransacao)."', '".addslashes($_POST["TipoPagamento"])."', '".addslashes($_POST["StatusTransacao"])."', '".addslashes($_POST["CliNome"])."', '".addslashes($_POST["CliEmail"])."', '".addslashes($_POST["CliEndereco"])."', '".addslashes($_POST["CliNumero"])."', '".addslashes($_POST["CliComplemento"])."', '".addslashes($_POST["CliBairro"])."', '".addslashes($_POST["CliCidade"])."', '".addslashes($_POST["CliEstado"])."', '".addslashes($_POST["CliCEP"])."', '".addslashes($_POST["CliTelefone"])."', '".addslashes($_POST["NumItens"])."', '".addslashes($_POST["Parcelas"])."')");
			
			//eu não sei como esse campo irá chegar do pagseguro....
			$myid = mysql_insert_id();
			if ($_POST["ProdID"]) {
				mysql_query("UPDATE paga_pagseguro SET ProdID='".$_POST["ProdID"]."', ProdDescricao='".$_POST["ProdDescricao"]."', ProdValor='".$_POST["ProdValor"]."', ProdQuantidade='".$_POST["ProdQuantidade"]."', ProdFrete='".$_POST["ProdFrete"]."' WHERE idpagseguro=$myid");
			}
			
			elseif ($_POST["ProdID_0"]) {
				mysql_query("UPDATE paga_pagseguro SET ProdID_0='".$_POST["ProdID"]."', ProdDescricao_0='".$_POST["ProdDescricao"]."', ProdValor_0='".$_POST["ProdValor"]."', ProdQuantidade_0='".$_POST["ProdQuantidade"]."', ProdFrete_0='".$_POST["ProdFrete"]."' WHERE idpagseguro=$myid");
			}
			
			elseif ($_POST["ProdID_1"]) {
				mysql_query("UPDATE paga_pagseguro SET ProdID_1='".$_POST["ProdID"]."', ProdDescricao_1='".$_POST["ProdDescricao"]."', ProdValor_1='".$_POST["ProdValor"]."', ProdQuantidade_1='".$_POST["ProdQuantidade"]."', ProdFrete_1='".$_POST["ProdFrete"]."' WHERE idpagseguro=$myid");
			}
			
			elseif($_POST["ProdID_x"]) {
				mysql_query("UPDATE paga_pagseguro SET ProdID_x='".$_POST["ProdID"]."', ProdDescricao_x='".$_POST["ProdDescricao"]."', ProdValor_x='".$_POST["ProdValor"]."', ProdQuantidade_x='".$_POST["ProdQuantidade"]."', ProdFrete_x='".$_POST["ProdFrete"]."' WHERE idpagseguro=$myid");
			}
		}
	}
	
	else if ($result == "FALSO") {
		mysql_query("INSERT INTO logs (nome, email, telefone, tipo, content) VALUES ('Interno', '', '', 4, 'Há alguém tentando fraudar o sistema de pagamento do Ovelhas com o Pagseguro! (".date("d/m/Y h:i:s").")')");
	}
	
	else {
		mysql_query("INSERT INTO logs (nome, email, telefone, tipo, content) VALUES ('Interno', '', '', 4, 'Há um erro na validação das informações do PagSeguro. (".date("d/m/Y h:i:s").")')");
	}
	
}

else {
	// POST não recebido, indica que a requisição é o retorno do Checkout PagSeguro.
	// No término do checkout o usuário é redirecionado para este bloco.
	?>
    <h3>Obrigado por efetuar a compra.</h3>
    <?php
}

?>