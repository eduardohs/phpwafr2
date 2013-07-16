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
define("DB_TYPE", "mysql");
mysql_set_charset('utf8');

class db {

	private $connect_id;
	private $type;

	//----- construtor, parâmetro default é "mysql"
	public function db($database_type="mysql") {
		$this->type = "mysql";
	}

	//----- executa uma expressão SQL
	public function execute($strSQL) {
		@mysql_query($strSQL, $this->connect_id);
		return @mysql_insert_id($this->connect_id);
	}

	//----- begin transaction
	public function begin() {
		@mysql_query("BEGIN", $this->connect_id);
	}

	//----- commit transaction
	public function commit() {
		@mysql_query("COMMIT", $this->connect_id);
	}

	//----- rollback transaction
	public function rollback() {
		@mysql_query("ROLLBACK", $this->connect_id);
	}

	//----- abertura do banco de dados
	//----- configure a conexão conforme suas necessidades
	public function open($database=DB_DATABASE, $host=DB_HOST, $user=DB_USER, $password=DB_PASSWORD) {
		if (DB_PERSISTENT) {
			$this->connect_id = @mysql_pconnect($host, $user, $password);
		} else {
			$this->connect_id = @mysql_connect($host, $user, $password);
		}
		if ($this->connect_id) {
			$result = @mysql_select_db($database);
			if (!$result) {
				@mysql_close($this->connect_id);
				$this->connect_id = $result;
			}
		}
		mysql_query("SET NAMES 'utf8'");
		mysql_query('SET character_set_connection=utf8');
		mysql_query('SET character_set_client=utf8');
		mysql_query('SET character_set_results=utf8');
		return $this->connect_id;
	}

	//----- efetua lock na tabela
	public function lock($table, $mode="write") {
		$query = new query($this, "lock tables $table $mode");
		$result = $query->result;
		return $result;
	}

	//----- efetua unlock nas tabelas em lock
	public function unlock() {
		$query = new query($this, "unlock tables");
		$result = $query->result;
		return $result;
	}

	//----- retorna mensagem de erro
	public function error($string_erro="") {
		//----- caso ocorra erro, envia mensagem
		return @mysql_errno($this->connect_id);
	}

	//----- encerra conexão e todos recorsets abertos
	public function close() {
		if ($this->query_id && is_array($this->query_id)) {
			while (list($key, $val) = each($this->query_id)) {
				@mysql_free_result($val);
			}
		}
		if (DB_PERSISTENT) {
			$result = @mysql_close($this->connect_id);
			return $result;
		}
	}

	//----- gera pool de recordsets. método privado, não utilizar !!!
	public function addquery($query_id) {
		$this->query_id[] = $query_id;
	}

	public function getConnectId() {
		return $this->connect_id;
	}

}

class query {

	private $result;
	private $row;
	private $numrows;
	private $total_pages = 0;

	//----- construtor, retorna recordset
	public function query(&$db, $query="", $initial_page=0, $page_length=0) {
		if ($query) {
			if ($this->result) {
				$this->free();
			}

			$this->result = @mysql_query($query, $db->getConnectId());
			$this->numrows = @mysql_num_rows($this->result);

			if (($initial_page + $page_length) > 0) {
				$this->total_pages = ceil($this->numrows() / $page_length);
				$query .= " limit " . ($initial_page - 1) * $page_length . ", $page_length";
			}
			$this->result = @mysql_query($query, $db->getConnectId());
			$db->addquery($this->result);
		}
	}

	public function totalpages() {
		return $this->total_pages;
	}

	//----- retorna array com os campos e avança o registro
	public function getrow() {
		if ($this->result) {
			$this->row = @mysql_fetch_array($this->result);
		} else {
			$this->row = 0;
		}
		return $this->row;
	}

	//----- retorna o valor do campo
	public function field($field) {
		$result = stripslashes($this->row[$field]);
		return $result;
	}

	//----- retorna o nome do campo
	public function fieldname($fieldnum) {
		return @mysql_field_name($this->result, $fieldnum);
	}

	//----- retorna primeira linha do recordset
	public function firstrow() {
		$result = @mysql_data_seek($this->result, 0);
		if ($result) {
			$result = $this->getrow();
		}
		return $this->row;
	}

	//----- fecha o recordset
	public function free() {
		return @mysql_free_result($this->result);
	}

	//----- retorna a quantidade de registros
	public function numrows() {
		return $this->numrows;
	}

	//------ retorna a quantidade de campos
	public function numfields() {
		return @mysql_num_fields($this->result);
	}

}
?>