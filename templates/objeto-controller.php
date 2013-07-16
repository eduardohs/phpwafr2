<?php
include_once("../inc/common.php"); 

// Inicialização dos dados de saída /////////////////////////////////////////////////////////////////////////////////////
$result["ok"] = "0";

// Captura a ação a ser executada ///////////////////////////////////////////////////////////////////////////////////////
$action = Param::get("action");

// Salvar ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($action == "salvar") {
	if (!Security::isValidUser("feedback_consultar")) {
		Messages::sendError("Você não tem permissão para esta operação");
		Http::redirect("../templates/objeto-lista.php");
	}

	// Prepara dados de retorno
	$result["ok"] = "0"; // começa com não OK

	// Validação
	$error = new Error();

	if (Param::get("f_nome_usuario") == "")
		$error->add('Nome de usuário deve ser informado.');
	if (Param::get("f_nome_real") == "")
		$error->add('Nome deve ser informado.');
	if (Param::getInt("f_id") == 0) {
		if (Param::get("f_password") == "")
			$error->add('Senha deve ser informada.');
		if (strlen(Param::get("f_password")) < 6)
			$error->add('Senha deve ter 6 ou mais caracteres.');
	}
	if (DBVal::isDuplicated("usuario", "nome_usuario", "usuario_id", Param::get("f_nome_usuario"), Param::get("f_id")))
		$error->add('Nome de usuário já existe.');
	if (!Validation::date(Param::get("f_data_cadastro")))
		$error->add('Data inválida');


	// Tratamento dos campos
	$data_cadastro = Dates::format(Param::get("f_data_cadastro"));
	$descricao = Param::get("f_descricao");

	// Atualização dos dados
	if ($error->hasError()) {
		$result["erro"] = $error->toString();
	} else {
		$rows = array (
			"data_cadastro" => $data_cadastro,
			"nome_usuario" => Param::get("f_nome_usuario"),
			"nivel_acesso" => Param::getInt("f_nivel_acesso"),
			"nome_real" => Param::get("f_nome_real"),
			"departamento_id" => Param::getInt("f_departamento_id"),
			"email" => Param::get("f_email"),
			"descricao" => $descricao,
			"ativo" => Param::getInt("f_ativo")
		);
		$db = new DBH();
		if (Param::getInt("f_id") > 0) {
			$db->update("usuario", $rows, "usuario_id=".Param::getInt("f_id"));
			$result["modo"] = "a";
		} else {
			$rows["senha"] = sha1(Param::get("f_password"));
			$db->insert("usuario", $rows);
			$result["modo"] = "i";
			$result["id"] = $db->lastInsertId();
		}
		$db = null;

		$result["sucesso"] = "Dados atualizados com sucesso!";
		$result["ok"] = "1";
		Messages::sendSuccess($result["sucesso"]);
	}
	echo json_encode($result);
}

// Excluir //////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($action == "excluir") {
	if (!Security::isValidUser("feedback_consultar")) {
		Messages::sendError("Você não tem permissão para esta operação");
		Http::redirect("../templates/objeto-lista.php");
	}

	$itens = Param::getStringFromArray("sel");

	// validação
	$error = new Error();

	if (DbVal::checkFK("sistema_usuario", "usuario_id", $itens))
		$error->add("Existem registros associados em Sistemas do Usuário.");
	if (DbVal::checkFK("historico", "usuario_id", $itens))
		$error->add("Existem registros associados em Histórico.");
	if (strlen($itens) == 0)
		$error->add("Nenhum registro selecionado.");

	// Transação
	if ($error->hasError()) {
		Messages::sendError($error->toString());
		Http::redirect("../templates/objeto-lista.php");
	} else {
		try {
			$db = new DBH();
			$db->delete("usuario", "usuario_id IN ($itens)");
			$db = null;
			Messages::sendSuccess("Registros excluídos com sucesso!");
		} catch (Exception $e) {
			Messages::sendError("Erro durante a exclusão");
		}
	}

	// Retorna
	Http::redirect("../templates/objeto-lista.php");
}

// Processar //////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($action == "processar") {
	if (!Security::isValidUser("feedback_consultar")) {
		Messages::sendError("Você não tem permissão para esta operação");
		Http::redirect("../templates/objeto-lista.php");
	}

	$itens = Param::getArray("sel");

	// validação
	$error = new Error();
	if (sizeof($itens) == 0)
		$error->add("Nenhum registro selecionado.");

	// Transação
	if ($error->hasError()) {
		Messages::sendError($error->toString());
		Http::redirect("../templates/objeto-lista.php");
	} else {
		try {
			foreach ($itens as $item) {
				// faz algo
			}
			Messages::sendSuccess("Registros " . implode(", ", $itens) . " processados com sucesso!");
		} catch (Exception $e) {
			Messages::sendError("Erro durante o processamento");
		}
	}

	// Retorna
	Http::redirect("../templates/objeto-lista.php");
}

// Exemplo 1 - Carga simples //////////////////////////////////////////////////////////////////////////////////////////////
if ($action == "ex1") {
	$nome = Param::get("f_nome");
	$valor = "Olá " . $nome . ", bem-vindo ao AJAX!";
	if ($nome == "") {
		$valor = "";
	}
	$result["valor"] = $valor;
	echo json_encode($result);
}

// Exemplo 2 - Carga do banco de dados /////////////////////////////////////////////////////////////////////////////////////
if ($action == "ex2") {
	$deps = DBH::getRows("SELECT * FROM departamento ORDER BY nome_departamento");
	$table = new Table("lista", 1);
	$table->addColumnHeader("Nome do departamento", false, "100%", "L");
	foreach ($deps as $dep)
		$table->addData($dep["nome_departamento"]);
	$valor = $table->getHTML();
	echo $valor;
}

// Exemplo 3 - Inclusão de dados //////////////////////////////////////////////////////////////////////////////////////////
if ($action == "ex3") {
	$nomedep = Param::get("f_nome_departamento");
	if ($nomedep != "") {
		$db = new DBH();
		$rows = array (
			"nome_departamento" => $nomedep
		);
		$db->insert("departamento", $rows);
		$lastId = $db->lastInsertId();
		$db = null;

		$result["valor"] = "Departamento incluído com sucesso! ID = $lastId";
		$result["ok"] = "1";
	} else {
		$result["erro"] = "Nome do departamento deve ser informado.";
	}
	echo json_encode($result);
}

// Exemplo 4 - Listabox encadeado /////////////////////////////////////////////////////////////////////////////////////////
if ($action == "ex4") {
	$chave = Param::get("chave");
	$valor = "<option value=''>- Selecione -</option>" .
			"<option value='{$chave}10'>Item {$chave} 10</option>" .
			"<option value='{$chave}11'>Item {$chave} 11</option>" .
			"<option value='{$chave}12'>Item {$chave} 12</option>" .
			"<option value='{$chave}13'>Item {$chave} 13</option>";
	$result["mensagem"] = "Listbox alterado via ajax!";
	if ($chave == "")
		$valor = "";
	$result["valor"] = $valor;
	echo json_encode($result);
}
if ($action == "ex5") {
	$chave = Param::get("chave");
	$valor = "<option value=''>- Selecione -</option>" .
			"<option value='{$chave}10'>Item {$chave} 10</option>" .
			"<option value='{$chave}11'>Item {$chave} 11</option>" .
			"<option value='{$chave}12'>Item {$chave} 12</option>" .
			"<option value='{$chave}13'>Item {$chave} 13</option>";
	$result["mensagem"] = "Listbox 2 alterado via ajax!";
	if ($chave == "")
		$valor = "";
	$result["valor"] = $valor;
	echo json_encode($result);
}

// Exemplo 5 - Autocomplete /////////////////////////////////////////////////////////////////////////////////////////////
if ($action == "ex6") {
	$q = Param::get("term");
	$rows = DBH::getRows("SELECT usuario_id as id, nome_real as label FROM usuario WHERE upper(nome_real) LIKE '%" . strtoupper($q) . "%' ORDER BY nome_real");
	echo json_encode($rows);
}

// Remoção de relacionamento N:N ////////////////////////////////////////////////////////////////////////////////////////
if ($action == "remover") {
	if (!Security::isValidUser("feedback_consultar")) {
		Messages::sendError("Você não tem permissão para esta operação");
		Http::redirect("../templates/objeto-associacao.php?id=" . $fk_id);
	}

	// Recupera a chave do relacionamento
	$fk_id = Param::getInt("fk_id");

	// Captura e prepara a lista de registros
	$list_exclusao = Param::getStringFromArray("sel");

	// Validação
	$error = new Error();
	if (strlen($list_exclusao) == 0)
		$error->add("Nenhum registro selecionado");

	// Transação
	if ($error->hasError()) {
		Messages::sendError($error->toString());
	} else {
		$db = new DBH();
		$db->delete("sistema_usuario", "usuario_id=$fk_id AND sistema_id IN ($list_exclusao)");
		$db = null;
		Messages::sendSuccess("Registros removidos com sucesso!");
	}
	Http::redirect("../templates/objeto-associacao.php?id=" . $fk_id);
}

// Validação de campo /////////////////////////////////////////////////////////////////////////////////////////////////////
if ($action == "validanomeusuario") {
	$result = "true";
	if (DBVal::isDuplicated("usuario", "nome_usuario", "usuario_id", Param::get("f_nome_usuario"), Param::getInt("f_id")))
		$result = "false";
	echo $result;
}

// Salvar relacionamento 1:N //////////////////////////////////////////////////////////////////////////////////////////////
if ($action == "salvar1n") {
	if (!Security::isValidUser("feedback_consultar")) {
		Messages::sendError("Você não tem permissão para esta operação");
		Http::redirect("../templates/objeto-lista.php");
	}

	// Prepara dados de retorno
	$result["ok"] = "0"; // começa com não OK
	//
	// Validação
	$error = new Error();
	if (Param::get("f_descricao") == "")
		$error->add('Descrição deve ser informada.');
	if (Param::get("f_data_cadastro") == "")
		$error->add('Data deve ser informada.');
	if (!Validation::date(Param::get("f_data_cadastro")))
		$error->add('Data inválida');

	// Tratamento dos campos
	$data_cadastro = Dates::format(Param::get("f_data_cadastro"));
	$descricao = Param::get("f_descricao");

	// Atualização dos dados
	if ($error->hasError()) {
		$result["erro"] = $error->toString();
	} else {
		$rows = array (
			"data_cadastro" => $data_cadastro,
			"descricao" => $descricao,
			"usuario_id" => Param::getInt("f_fk_id")
		);
		$db = new DBH();
		if (Param::getInt("f_id") > 0) {
			$db->update("historico", $rows, "historico_id=".Param::getInt("f_id"));
			$result["modo"] = "a";
		} else {
			$db->insert("historico", $rows);
			$result["modo"] = "i";
			$result["id"] = $db->lastInsertId();
		}
		$db = null;
		$result["sucesso"] = "Dados atualizados com sucesso!";
		$result["ok"] = "1";
		Messages::sendSuccess($result["sucesso"]);
	}
	echo json_encode($result);
}

// Excluir 1:N //////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($action == "excluir1n") {
	if (!Security::isValidUser("feedback_consultar")) {
		Messages::sendError("Você não tem permissão para esta operação");
		Http::redirect("../templates/objeto-lista-1n.php?id=" . Param::getInt("fk_id"));
	}

	$itens = Param::getStringFromArray("sel");

	// validação
	$error = new Error();
	if (strlen($itens) == 0)
		$error->add("Nenhum registro selecionado.");

	// Transação
	if ($error->hasError()) {
		Messages::sendError($error->toString());
		Http::redirect("../templates/objeto-lista-1n.php?id=" . Param::getInt("fk_id"));
	} else {
		try {
			$db = new DBH();
			$db->delete("historico", "historico_id IN ($itens)");
			$db = null;
			Messages::sendSuccess("Registros excluídos com sucesso!");
		} catch (Exception $e) {
			Messages::sendError("Erro durante a exclusão");
		}
	}

	// Retorna
	Http::redirect("../templates/objeto-lista-1n.php?id=" . Param::getInt("fk_id"));
}

// Carga dinâmica em lista //////////////////////////////////////////////////////////////////////////////////////////////////
if ($action == "carregatree") {
	$id_usuario = Param::getInt("id");
	$sis = DBH::getrows("SELECT sistema.nome_sistema FROM sistema, sistema_usuario WHERE sistema.sistema_id=sistema_usuario.sistema_id AND sistema_usuario.usuario_id=" . $id_usuario . " ORDER BY sistema.nome_sistema");
	if (sizeof($sis) > 0) {
		$table = new Table("listaSistemas_" . $id_usuario, 1);
		$table->addColumnHeader("Nome do sistema", false, "100%", "L");
		foreach ($sis as $row)
			$table->addData($row["nome_sistema"]);
		echo $table->getHTML();
	} else {
		echo "Nenhum sistema associado";
	}
}

// Consumo de webservice //////////////////////////////////////////////////////////////////////////////////////////////////
if ($action == "ws") {
	$wsdl = "http://www.site.com.br?wsdl";
	$client = new SoapClient($wsdl);
	try {
		$valor = $client->login(array("username" => "xxx", "password" => "xxxxx"));
		$result["valor"] = $valor;
		$result["ok"] = 1;
	} catch (Exception $e) {
		$result["ok"] = 0;
		$result["valor"] = "Timeout";
	}
	echo json_encode($result);
}

// Alterar tema //////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($action == "alterar_tema") {
	$tema = Param::get("tema");
	$db = new DBH();
	$db->update("usuario", array ("tema"=>$tema), "nome_usuario='".Session::get("sis_username")."'");
	$db = null;
	Session::set("sis_tema", $tema);
	Http::redirect("../common/index.php");
}
