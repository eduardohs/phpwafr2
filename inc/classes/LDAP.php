<?php
/**
 * Componente para consulta de usuários no servidor LDAP
 * @author marcelo-rezende
 */
class LDAP {
	
	private $server;
	private $dn;
	private $row;
	private $filter;
	
	public function LDAP($server="ldap1.procergs.reders", $dn="ou=procergs,o=estado,c=br") {
		$this->server = $server;
		$this->dn = $dn;
	}
	
	public function setSearchForNome($str) {
		$this->filter = "(&(sn=*".$str."*)(objectClass=diretoPerson)(!(departmentNumber=INSTITUCIONAL)))";
	}
	
	public function setSearchForMatricula($mat) {
		$this->filter = "(&(uidnumber=".$mat.")(objectClass=diretoPerson)(!(departmentNumber=INSTITUCIONAL)))";
	}
	
	public function setSearchForEmail($str) {
		$this->filter = "(&(mail=".$str.")(objectClass=diretoPerson)(!(departmentNumber=INSTITUCIONAL)))";
	}
	
	public function setSearchForSetor($str) {
		$this->filter = "(&(departmentNumber=".$str.")(objectClass=diretoPerson)(!(departmentNumber=INSTITUCIONAL)))";
	}
	
	public function setSearchForUser($str) {
		$this->filter = "(&(uid=".$str.")(objectClass=diretoPerson)(!(departmentNumber=INSTITUCIONAL)))";
	}
	
	public function getResult() {
		$ds = ldap_connect($this->server);
		if ($ds) {
			$r = ldap_bind($ds);
			$sr = ldap_search($ds, $this->dn, $this->filter);
			$info = ldap_get_entries($ds, $sr);

			for ($i = 0; $i < $info["count"]; $i++) {
				$this->row[$i]["nome"] = $info[$i]["cn"][0];
				$this->row[$i]["email"] = $info[$i]["mail"][0];
				$this->row[$i]["user"] = $info[$i]["uid"][0];
				$this->row[$i]["matricula"] = $info[$i]["uidnumber"][0];
				$this->row[$i]["setor"] = $info[$i]["departmentnumber"][0];
			}
			ldap_close($ds);
		}
		return $this->row;
	}
}
