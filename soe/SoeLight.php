<?php

/**
 * Componente para simular autenticação SOE
 *
 * @author marcelo-rezende
 */
class SoeLight {

	private $sistema;
	private $matricula;
	private $acoes = array();
	private $objetos = array();
	private $arquivo;
	private $autenticado = false;
	private $separador;

	public function SoeLight($sistema, $matricula, $path = "./", $separador="_") {
		$this->sistema = $sistema;
		$this->matricula = $matricula;
		$this->arquivo = $path . "SOE_" . $this->matricula . ".TXT";
		$this->separador = $separador;
		$this->carrega();
	}

	private function carrega() {
		$fp = @fopen($this->arquivo, "r");
		if ($fp) {
			$this->autenticado = true;
			while (!feof($fp)) {
				$linha = split($this->separador, fgets($fp));
				if ($this->sistema == $linha[0]) {
					if (!in_array($linha[1], $this->objetos)) {
						$this->objetos[] = $linha[1];
					}
					if (!in_array($linha[1] . $this->separador . $linha[2], $this->acoes)) {
						$this->acoes[] = $linha[1] . $this->separador . $linha[2];
					}
				}
			}
		} else {
			$this->autenticado = false;
		}
		fclose($fp);
		
	}

	public function getObjetos() {
		return implode(",", $this->objetos);
	}

	public function getAcoes() {
		return implode(",", $this->acoes);
	}
	
	public function autenticado() {
		return $this->autenticado;
	}

}
?>