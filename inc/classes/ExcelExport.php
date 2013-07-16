<?php
class ExcelExport {
	private $file;
	private $row;
	
	public function ExcelExport() {
		$this->file = $this->__BOF();
		$row = 0;
	}
	
	private function __BOF() {
		return pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
	}
	
	private function __EOF() {
		return pack("ss", 0x0A, 0x00);
	}
	
	private function __writeNum($row, $col, $value) {
		$this->file .= pack("sssss", 0x203, 14, $row, $col, 0x0);
		$this->file .= pack("d", $value);
	}
	
	private function __writeString($row, $col, $value ) {
		$L = strlen($value);
		$this->file .= pack("ssssss", 0x204, 8 + $L, $row, $col, 0x0, $L);
		$this->file .= $value;
	}
	
	public function writeCell($value,$row,$col) {
		if (is_numeric($value)) {
			$this->__writeNum($row,$col,$value);
		} elseif (is_string($value)) {
			$this->__writeString($row,$col,$value);
		}
	}
	
	public function addRow($data,$row=null) {
		if (!isset($row)) {
			$row = $this->row;
			$this->row++;
		}
		for ($i = 0; $i<count($data); $i++) {
			$cell = $data[$i];
			$this->writeCell($cell,$row,$i);
		}
	}
	
	public function download($filename) {
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");;
		header("Content-Disposition: attachment;filename=$filename ");
		header("Content-Transfer-Encoding: binary ");
		$this->write();
	}
	
	public function write() {
		echo $file = $this->file.$this->__EOF();
	}
}