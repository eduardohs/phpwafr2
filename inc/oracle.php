<?php
/**************************************************
 * DEPRECATED - Use a classe DBH (Database Helper)
 */
/* * *******************************************
 * 
 * Classes para acesso a camada de dados.
 *
 * Classe......: db
 * Métodos.....: db("tipodb") construtor, *experimental, usar sem parâmetros
 *               open(banco, host, user, password)
 * 	             lock(tabela, modo)
 *               unlock()
 *               error()
 *               close()
 *               execute(sql)
 *               begin()
 *               commit()
 *               rollback()
 *               getConnectId()
 *
 * Classe......: query
 * Métodos.....: query(db, sql, numero_pagina, page_length) -> construtor
 *               getrow()
 *               field(campo)
 *               fieldname([numerodocampo] ou [nomedocampo])
 *               firstrow()
 *               free()
 *               numrows()
 *               totalpages()
 *               numfields()
 * 				  
 * ************************ */
define("DB_TYPE", "oracle");
class db {

	private $connect_id, $type;

	//----- construtor, parâmetro default é "oracle 9.x.x"
	public function db($database_type="oci9") {

		$this->type = "oci9";

		//----- Forca a inicializacao das variaveis de ambiente
		putenv("oracle_base=/u01/app/oracle");
		putenv("oracle_home=/u01/app/oracle/product/9.2.0");
		putenv("ora_nls33=/u01/app/oracle/product/9.2.0/ocommon/nls/admin/data");
	}

	//----- abertura do banco de dados
	public function open($database=DB_DATABASE, $host=DB_HOST, $user=DB_USER, $password=DB_PASSWORD) {
		$db = " (description = (address = (protocol = tcp)(host = " . $host . ")(port = 1524))     (connect_data = (sid = " . $database . "))   )";
		$this->connect_id = OCILogon($user, $password, $db);
		return $this->connect_id;
	}

	//----- begin transaction
	public function begin() {
		
	}

	//----- executa uma expressão SQL e retorna o numero de linhas afetadas
	public function execute($strSQL) {
		$stmt = OCIParse($this->connect_id, $strSQL);
		OCIExecute($stmt, OCI_DEFAULT);
		return OCIRowCount($stmt);
	}

	//----- commit transaction
	public function commit() {
		OCICommit($this->connect_id);
	}

	//----- rollback transaction
	public function rollback() {
		OCIRollback($this->connect_id);
	}

	//----- efetua lock na tabela
	public function lock($table, $mode="write") {
		
	}

	//----- efetua unlock nas tabelas em lock
	public function unlock() {
		
	}

	//----- retorna mensagem de erro
	public function error($string_erro="") {
		$err = OCIError();
		return $err;
	}

	//----- encerra conexão e todos recorsets abertos
	public function close() {
		OCILogoff($this->connect_id);
	}

	//----- recupera valor da sequence
	public function getSequence($nomeSeq) {
		$qry = OCIParse($this->connect_id, "SELECT " . $nomeSeq . ".nextval AS SEQ FROM DUAL");
		OCIExecute($qry, OCI_DEFAULT);
		OCIFetchInto($qry, $valor, OCI_RETURN_NULLS + OCI_ASSOC + OCI_RETURN_LOBS);
		return $valor['SEQ'];
	}

}

/* * ******************************************************************************
 * Classe......: query
 * Métodos.....: query(&$db, $query="", $pagina_inicial=0, $tamanho_pagina=0)
 *               totalpages()
 * 	             getrow()
 *               field($field)
 *               fieldname($fieldnum)
 *               firstrow()
 *               free()
 *               numrows()
  /****************************************************************************** */

class query {

	private $result, $row, $numrows, $totalpages = 0;

	//----- construtor, retorna recordset (traz todos os dados apontando para o 1o registro)
	public function query(&$db, $query="", $pagina_inicial=0, $tamanho_pagina=0) {

		//-- Consulta o banco para verificar quantos registros a query tem
		$this->result = OCIParse($db->connect_id, $query);
		OCIExecute($this->result, OCI_DEFAULT);

		//-- Busca o nro de linhas
		$this->numrows = OCIFetchStatement($this->result, $results);

		//-- Calcula o total de paginas
		if (($pagina_inicial + $tamanho_pagina) > 0) {
			$this->totalpages = ceil($this->numrows() / $tamanho_pagina);
		}

		//-- Se houver limite de paginas, faz paginacao
		if ($tamanho_pagina > 0) {

			$query = "
               SELECT A.*
               FROM
                    (SELECT B.*, ROWNUM ROW_B
                     FROM (" . $query . ") B
	                ) A
  	           WHERE A.ROW_B >= " . (($pagina_inicial * $tamanho_pagina) - ($tamanho_pagina - 1)) . "
	             AND A.ROW_B <= " . ($pagina_inicial * $tamanho_pagina);
		}

		/* Repete a consulta, pois OCIFetchStatement tem um bug #9520 que faz */
		/* com que OCIColumnName e similares parem de funcionar               */
		$this->result = OCIParse($db->connect_id, $query);
		OCIExecute($this->result, OCI_DEFAULT);
	}

	//----- retorna array com os campos e avança o registro (percorre recordset)
	public function getrow() {
		//-- Inicializa a "tupla" de dados, pois o OCIFetchInto nao "limpa" o row a cada chamada
		$this->row = array();

		if ($this->result) {
			OCIFetchInto($this->result, $this->row, OCI_RETURN_NULLS + OCI_ASSOC + OCI_RETURN_LOBS);
		} else {
			//$this->row=false;
			$this->row = 0;
		}

		return $this->row;
	}

	//----- retorna o valor do campo
	public function field($field) {
		//-- Converte para maiuscula, pois o Oracle suporta apenas esse formato de nome de campo ...
		$field = strtoupper($field);

		//-- Busca o campo
		$result = $this->row[$field];
		return $result;
	}

	//----- retorna o nome do campo
	public function fieldname($fieldnum) {
		return OCIColumnName($this->result, $fieldnum);
	}

	//----- retorna primeira linha do recordset
	public function firstrow() {
		
	}

	//----- fecha o recordset
	public function free() {
		return OCIFreeStatement($this->result);
	}

	//----- retorna a quantidade de registros
	public function numrows() {
		return $this->numrows;
	}

	//----- retorna o total de paginas
	public function totalpages() {
		return $this->totalpages;
	}

}

?>