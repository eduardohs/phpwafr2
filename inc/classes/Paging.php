<?php
class Paging {

	public static function getPage() {
		$pg = $_GET['pg'];
		if ($pg == "")
			$pg = 1;
		return $pg;
	}

	public static function writeLinks($numPages) {
		$out = "<div id=\"div-navigation\">";
		$inimostra = 1;
		$maxmostra = 4;
		if ($numPages > $maxmostra + 1) {
			$inimostra = Paging::getPage();
			$maxmostra = $maxmostra + $inimostra;
			if ($maxmostra > $numPages) {
				$inimostra = Paging::getPage() - 4;
				$maxmostra = $numPages;
			}
		} else
			$maxmostra = $numPages;
		if (Paging::getPage() != 1) {
			$out .= "<a class=\"link rounded\" href=\"" . $_SERVER['PHP_SELF'] . "?pg=1\" >Início</a>";
			$out .= "<a class=\"link rounded\" href=\"" . $_SERVER['PHP_SELF'] . "?pg=" . (Paging::getPage() - 1) . "\" >Anterior</a>";
		}
		for ($x = $inimostra; $x <= $maxmostra; $x++) {
			$destaque = "";
			if (Paging::getPage() == $x)
				$destaque = "destaque-page";
			$out .= "<a class=\"link rounded $destaque\" href=\"" . $_SERVER['PHP_SELF'] . "?pg=" . $x . "\" >" . $x . "</a>";
		}
		if (Paging::getPage() != $numPages) {
			$out .= "<a class=\"link rounded\" href=\"" . $_SERVER['PHP_SELF'] . "?pg=" . (Paging::getPage() + 1) . "\">Próxima</a>";
			$out .= "<a class=\"link rounded\" href=\"" . $_SERVER['PHP_SELF'] . "?pg=" . $numPages . "\">Última</a>";
		}
		$out .= "</div>\n";
		echo $out;
	}

	/***
	 * DEPRECATED
	 */
	public static function writeStatus($totalPages, $nroRegistros=0) {
		$reg = "";
		if ($nroRegistros > 0) {
			$reg = " (" . $nroRegistros . " registros)";
		}
		echo "<div id='div-table-status'>Página " . Paging::getPage() . " de " . $totalPages . $reg . "</div>";
	}

	public static function writeStatusIfEmpty() {
		echo "<div id='div-table-status'>Nenhum registro encontrado</div>";
	}

	public static function writeQtdeReg($numReg) {
		if ($numReg > 0) {
			echo "<div id='div-table-status'>" . $numReg . " registro(s)</div>";
		} else {
			echo "<div id='div-table-status'>Nenhum registro encontrado</div>";
		}
	}

}
