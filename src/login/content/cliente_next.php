<?include("../conn.php");if (!$_SESSION["admin"]) { header("location: ..\..\site\content\index.php"); exit; }include("../header.php");include("../sidebar.php");if ($_POST["finish_all"]) {	for ($IntFor = 1; $IntFor <= $_POST["cont_numero"]; $IntFor++) {		if ($_POST["cont".$IntFor."_tipo"] == "tel") {			mysql_query("INSERT INTO cliente_contato (idcliente, content, operadora, tipo) VALUES ('".addslashes($_GET["next"])."', '".addslashes($_POST["cont".$IntFor])."', '', 'tel')");		}				elseif ($_POST["cont".$IntFor."_tipo"] == "cel") {			mysql_query("INSERT INTO cliente_contato (idcliente, content, operadora, tipo) VALUES ('".addslashes($_GET["next"])."', '".addslashes($_POST["cont".$IntFor."_op"])."', '".addslashes($_POST["cont".$IntFor])."', 'cel')");		}				elseif($_POST["cont".$IntFor."_tipo"] == "mail") {			mysql_query("INSERT INTO cliente_contato (idcliente, content, operadora, tipo) VALUES ('".addslashes($_GET["next"])."', '".addslashes($_POST["cont".$IntFor])."', '', 'mail')");		}	}	echo "		<script type='text/javascript'>			window.location.href = 'index.php';		</script>	";}?><!-- mascara --><script type="text/javascript" src="../../plugins/js/maskedinput/jquery.maskedinput-1.1.4.pack.js"/></script><script type="text/javascript">// FUN��ES REFERENTES AO TELEFONEvar n_contatos = 0;function contato(meuid) //altera o conte�do de contato, ou para celular, ou para email ou para telefone fixo{  	if (document.getElementById(meuid+"_tipo").value == "tel")	{	  	  document.getElementById(meuid+"_content").innerHTML = "\	  <input type='text' style='width: 95px;' name='"+meuid+"' id='"+meuid+"'>";	  $("#"+meuid).mask("(99) 9999-9999");	}	else if (document.getElementById(meuid+"_tipo").value == "cel")	{	  document.getElementById(meuid+"_content").innerHTML = "\	  <input type='text' style='width: 95px; float: left;' name='"+meuid+"' id='"+meuid+"'>\	  <select style='width: 60px; float: right; margin: 0 0 0 10px;' name='"+meuid+"_op' id='"+meuid+"_op'>\		  <option value='claro'>Claro</option>\		  <option value='nextel'>Nextel</option>\		  <option value='oi'>Oi</option>\		  <option value='tim'>Tim</option>\		  <option value='vivo'>Vivo</option>\		  <option value='outra'>Outra...</option>\	  </select>";	  $("#"+meuid).mask("(99) 9999-9999");	}	else if (document.getElementById(meuid+"_tipo").value == "mail")	{	  document.getElementById(meuid+"_content").innerHTML = "<input type='text' id='mail_"+meuid+"' name='"+meuid+"' maxlength='75'>";	}}function addcontato(){	n_contatos++; var show;	if (n_contatos != 1) { show = " "+n_contatos; }	else { show = ""; }		//Evitando que os dados digitados se percam para cada vez que um contato for adicionado	var salva_valores; salva_valores = new Array();	var o_nome;	for (IntFor = 0; IntFor < (n_contatos - 1); IntFor++)	{	  o_nome = IntFor + 1;	  salva_valores[IntFor] = new Array();	  salva_valores[IntFor][0] = document.getElementById("cont"+o_nome+"_tipo").value;	  if (salva_valores[IntFor][0] == "mail") 	{ salva_valores[IntFor][1] = document.getElementById("mail_cont"+o_nome).value; }	  else										{ salva_valores[IntFor][1] = document.getElementById("cont"+o_nome).value; }	  if (salva_valores[IntFor][0] == "cel") {		salva_valores[IntFor][2] = document.getElementById("cont"+o_nome+"_op").value;	  }	}		document.getElementById("js_contato").innerHTML += "\	  <span class='fake_label'>	Contato"+show+": \		<select name='cont"+n_contatos+"_tipo' id='cont"+n_contatos+"_tipo' onClick=\"contato('cont"+n_contatos+"');\" style='margin: 0 0 0 10px;'>\		  <option value='tel'>Tel</option>\		  <option value='cel'>Cel</option>\		  <option value='mail'>Email</option>\		</select>\	  <span id='cont"+n_contatos+"_content' style='display: block; float: right;'></span>\	  </span>\	  <br />\	";		//Criando um novo campo e devolvendo as mascaras que foram tiradas dos outros campos com o += a cima	for (IntFor = 0; IntFor < n_contatos; IntFor++)	{	  $("#cont"+IntFor).mask("(99) 9999-9999");	} //Ele mascara todos menos o atual, o atual � mascarado pela fun��o 'contato'	contato("cont"+n_contatos);		//Devolvendo os valores	var o_nome; o_nome = 0;	for (IntFor = 0; IntFor < salva_valores.length; IntFor++)	{	  o_nome = IntFor + 1;	  document.getElementById("cont"+o_nome+"_tipo").value = salva_valores[IntFor][0];	  if (salva_valores[IntFor][0] == "mail") 	{ document.getElementById("mail_cont"+o_nome).value = salva_valores[IntFor][1]; }	  else 										{ document.getElementById("cont"+o_nome).value = salva_valores[IntFor][1]; }	  if (salva_valores[IntFor][0] == "cel") {		document.getElementById("cont"+o_nome+"_op").value = salva_valores[IntFor][2];	  }	}	document.getElementById("cont_numero").value = n_contatos;}</script><form method="POST" action="" style="margin: 40px; width: 350px;">	<span id="js_contato">		<!-- Aqui dentro existe a manipula��o de telefones feita apenas por JavaScript e JQuery -->	</span>	<input type="hidden" name="cont_numero" id="cont_numero" /><br />	<div class="fake_button" onClick="addcontato()"> + contato</div><br />	<br />	<input type="submit" value="Concluir" name="finish_all" style="font-size: 18px; padding: 3px 10px; cursor: pointer;" /></form><script type="text/javascript">	addcontato();</script><? include("../footer.php"); ?>