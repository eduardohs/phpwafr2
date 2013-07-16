<?php
class OrderBy {

	private $orders;
	private $compl;
	private $defaultOrder;
	private $defaultDirection;

	const ASC = "ASC";
	const DESC = "DESC";

	public function OrderBy() {
		$this->orders = array();
		$this->compl = array();
		$this->defaultDirection = OrderBy::ASC;
	}

	public function add($id, $expr, $complemento="") {
		$this->orders[$id] = $expr;
		$this->compl[$id] = $complemento;
	}

	public function setDefaultOrder($ord) {
		$this->defaultOrder = $ord;
	}

	public function setDefaultDirection($dir = OrderBy::ASC) {
		$this->defaultDirection = $dir;
	}

	public function getCurrentOrder() {
		return Session::get("sisCurrentOrder");
	}

	public function handleOrder() {
		$same_page = Session::handleCurrentPage();

		$iSort = Param::get("Sorting");
		$iSorted = Param::get("Sorted");
		$form_sorting = "";
		global $form_sorting;
		if ((!$iSort) && (!$same_page)) {
			$form_sorting = "";
			$iSort = $this->defaultOrder;
			Session::set("sisCurrentOrder", $iSort);
			$iSorted = "";
			if ($this->defaultDirection == OrderBy::DESC)
				$iSorted = $iSort;
		}
		if ($iSort) {
			Session::set("sisCurrentOrder", $iSort);
			if ($iSort == $iSorted) {
				$form_sorting = "";
				$sDirection = " DESC";
				$sSortParams = "Sorting=" . $iSort . "&Sorted=" . $iSort . "&";
			} else {
				$form_sorting = $iSort;
				$sDirection = " ASC";
				$sSortParams = "Sorting=" . $iSort . "&Sorted=" . "&";
			}
			Session::set("sOrder", " " . $this->orders[$iSort] . " " . $sDirection . " " . $this->compl[$iSort]);
		}
	}
	
	public function getOrderBy() {
		return Session::get("sOrder");
	}

}
