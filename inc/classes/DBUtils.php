<?php
/**************************************************
 * DEPRECATED - Use a classe DBH (Database Helper)
 */
class DBUtils { 

	public static function getValue($sql) {
		$connTemp = new db();
		$connTemp->open();
		$rs = new query($connTemp, $sql);
		if ($rs->numrows() == 0) {
			$value = "";
		} else {
			$rs->getrow();
			$fieldname = $rs->fieldname(0);
			$value = $rs->field($fieldname);
		}
		$rs->free();
		$connTemp->close();
		return $value;
	}

	public static function executeSQL($sql) {
		$connTemp = new db();
		$connTemp->open();
		$id = $connTemp->execute($sql);
		$connTemp->close();
		return $id;
	}

	public static function getRows($sql, $pg = 1, $qtde = 1000) {
		$result = array();
		$connTemp = new db();
		$connTemp->open();
		$rs = new query($connTemp, $sql, $pg, $qtde);
		$i = 0;
		while ($rs->getrow()) {
			for ($j = 0; $j < $rs->numfields(); $j++) {
				$result[$i][$rs->fieldname($j)] = $rs->field($rs->fieldname($j));
			}
			$i++;
		}
		$connTemp->close();
		return $result;
	}

	public static function query($sql, $pg = 1, $qtde = 100) {
		$result = array();
		$connTemp = new db();
		$connTemp->open();
		$rs = new query($connTemp, $sql, $pg, $qtde);
		$i = 0;
		$result["total_pages"] = $rs->totalpages();
		$result["num_rows"] = $rs->numrows();
		while ($rs->getrow()) {
			for ($j = 0; $j < $rs->numfields(); $j++) {
				$result["list"][$i][$rs->fieldname($j)] = $rs->field($rs->fieldname($j));
			}
			$i++;
		}
		$connTemp->close();
		return $result;
	}

	public static function getRow($sql) {
		$rows = DBUtils::getRows($sql, 1, 1);
		return $rows[0];
	}

	public static function delete($tabela, $chave, $ids) {
		try {
			DBUtils::executeSQL("DELETE FROM $tabela WHERE $chave IN ($ids)");
		} catch (Exception $e) {
			throw new Exception;
		}
	}
}
