<?php
class Upload {

	private $file;
	private $fileName;
	private $filter = "ALL";
	private $size = 3000000;
	private $directory;
	private $error = "";
	private $width;
	private $height;

	public function setFile($file) {
		$this->file = $file;
		if ($file["name"] == "") {
			return 0;
		} else {
			$this->fileName = date("U") . Format::removeAccent($file["name"]);
			return 1;
		}
	}

	public function getFileName() {
		return $this->fileName;
	}

	public function setFilter($filter) {
		$this->filter = $filter;
	}

	public function setSize($size) {
		$this->size = $size;
	}

	public function setDirectory($directory) {
		$this->directory = $directory;
	}

	public function setWidth($theWidth) {
		$this->width = $theWidth;
	}

	public function setHeight($height) {
		$this->height = $height;
	}

	public function validate() {
		if ($this->filter == "IMAGE") {
			if (!eregi("^image\/(pjpeg|jpg|png|gif|bmp)$", $this->file["type"])) {
				$this->error .= 'Arquivo em formato inválido! A imagem deve ser jpg, jpeg, bmp, gif ou png. Envie outro arquivo.\n\n';
			}
			$sizes = getimagesize($this->file['tmp_name']);
			if (($this->width != "") && ($sizes[0] > $this->width)) {
				$this->error .= 'Largura da imagem não deve ultrapassar ' . $this->width . ' pixels\n';
			}
			if (($this->height != "") && ($sizes[1] > $this->height)) {
				$this->error .= 'Altura da imagem não deve ultrapassar ' . $this->height . ' pixels\n';
			}
		}
		if ($this->filter == "DOC") {
			if (!eregi("^application\/(msword|pdf)$", $this->file["type"])) {
				$this->error .= 'Arquivo em formato inválido! O arquivo deve ser doc ou pdf. Envie outro arquivo.\n\n';
			}
		}
		if ($this->filter == "VIDEO") {
			if (!eregi("^video\/(mpeg|quicktime|midi|x-ms-wmv|avi|msvideo|x-msvideo)$", $this->file["type"])) {
				$this->error .= 'Arquivo em formato inválido! O arquivo deve ser em formato de vídeo.\n\n';
			}
		}
		if ($this->filter == "AUDIO") {
			if (!eregi("^audio\/(mpeg|x-wav|wav|x-realaudio|x-pn-realaudio)$", $this->file["type"])) {
				$this->error .= 'Arquivo em formato inválido! O arquivo deve ser em formato de vídeo.\n\n';
			}
		}
		if ($this->file['size'] > $this->size) {
			$this->error .= "Tamanho máximo permitido é $this->size.\n\n";
		}
		return $this->error;
	}

	public function send() {
		if (sizeof($this->error) > 0) {
			move_uploaded_file($this->file['tmp_name'], $this->directory . $this->fileName);
			return true;
		} else {
			return false;
		}
	}

	public function delete($file) {
		$arq = $this->directory . $file;
		$result = unlink($arq);
		return $result;
	}

}
