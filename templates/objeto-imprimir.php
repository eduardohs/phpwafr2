<?php
include_once("../inc/common.php");
require("../inc/fpdf/fpdf.php");

// Controle de acesso /////////////////////////////////////////////////////////////////////////////////////////////////
Security::verifyUser("feedback_consultar");

// Especialização da classe para impressão ////////////////////////////////////////////////////////////////////////////
class PDF extends FPDF {

	// colunas
	var $largura = array(20,60,60,30);
	var $colunas = array("ID", "Nome de usuário", "Nome completo", "Nível de acesso");

	function Header() {
		$this->image("../img/phpwafr.jpg", 185, 9, 12);

		$this->SetFont('Arial', 'B', 14);
		$this->Cell(50, 6, SYS_TITLE, 0, 0);

		$this->SetFont('Arial', 'I', 8);
		$this->Cell(0, 6, "", 0, 1, "R");

		$this->SetFont('Arial', 'B', 14);
		$this->Cell(0, 6, utf8_decode("Lista de Usuários"), "B");

		// colunas do relatório
		$this->SetFont('Arial', 'B', 9);
		$this->Ln(10);
		//for($i=0; $i<count($this->colunas); $i++) $this->Cell($this->largura[$i], 7, $this->colunas[$i], "B", 0, 'L');
		$this->cell($this->largura[0], 7, $this->colunas[0], "B", 0, "R");
		$this->cell($this->largura[1], 7, utf8_decode($this->colunas[1]), "B", 0, "L");
		$this->cell($this->largura[2], 7, $this->colunas[2], "B", 0, "L");
		$this->cell($this->largura[3], 7, utf8_decode($this->colunas[3]), "B", 0, "R");
		$this->Ln();
	}

	function Footer() {
		$this->SetY(-15);
		$this->SetFont('Arial', 'I', 8);
		$this->Cell(10, 10, "", "T");
		$this->Cell(30,10,  date("d/m/Y - H:i"), "T", 0, 'L');
		$this->Cell(0, 10,$this->PageNo(), "T", 0, 'R');
	}

	function Lista() {
		$sql = "SELECT * FROM usuario ORDER BY nome_real ASC";
		$rows = DBH::getRows($sql);
		$this->SetFont('Arial', '', 9);
		foreach($rows as $row) {
			$this->Cell($this->largura[0], 6, $row["usuario_id"], 0, 0, "R");
			$this->Cell($this->largura[1], 6, $row["nome_usuario"]);
			$this->Cell($this->largura[2], 6, utf8_decode($row["nome_real"]));
			$this->Cell($this->largura[3], 6, $row["nivel_acesso"], 0, 0, "R");
			$this->Ln();
		}
	}
}

//$pdf=new PDF("P","mm","A4");
$pdf = new PDF();
$pdf->setAuthor("Marcelo Rezende");
$pdf->setTitle("Lista de Usuários");
$pdf->AddPage();
$pdf->Lista();
$pdf->Output();
?>