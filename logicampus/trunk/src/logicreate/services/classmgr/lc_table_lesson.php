<?php


class LinkedItemsModel extends LC_DefaultTableModel {

	var $sql = '';
	var $results = array();
	var $page = 1;
	var $resultsPerPage = 100;
	var $maxResults;
	var $columnNames = array();


	/**
	 * Get sql results 
	 */
	function LinkedItemsModel($sql,$db) {
		$db->query($sql);
		while ($db->next_record()) {
			$this->results[] = $db->Record;
		}
	}

	/*
	function setColumnNames($array) {
		$this->columnNames = $array;
	}
	*/


	//sub-class
	/**
	 * Returns the number of rows in the model.
	 */
	function getRowCount() {
		return (count($this->results));
	}


	/**
	 * Returns the number of cols in the model.
	 */
	function getColumnCount() {
		return 3;
	}


	/**
	 * Returns the name of a column.
	 */
	 /*
	function getColumnName($columnIndex) {

		return $this->columnNames[$columnIndex];
	}
	*/


	/**
	 * return the value at an x,y coord
	 */
	function getValueAt($x,$y) {
		$record = $this->results[$x];
		if ($y == 0 ) { return $record; }
		if ($y == 2 ) { return $record; }
		return $record[$y];
	}
}



class LC_TableCheckboxRenderer extends LC_TableCellRenderer {

	var $selectedVal;
	var $selectedKey;
	var $idName;

	function getRenderedValue() {
		$selected = ($this->selectedVal == $this->value[$this->selectedKey]) ? ' CHECKED ':'';
		return '<input name="item['.$this->row.']" value="'.$this->value[$this->idName].'" '.$selected.' type="checkbox">';
	}
}



class LC_TableLessonCheckboxRenderer extends LC_TableCellRenderer {

	var $selectedVal;
	var $selectedKey;
	var $idName;
	var $itemsToLessons = array();

	function getRenderedValue() {
		$itemKey = $this->value[$this->idName];
		$selected = ( in_array($this->selectedVal, $this->itemsToLessons[$itemKey]))  ? ' CHECKED ':'';
		return '<input name="item['.$this->row.']" value="'.$this->value[$this->idName].'" '.$selected.' type="checkbox">';
	}
}



class LC_TableLessonRenderer extends LC_TableCellRenderer {

	var $lessonTitles = array();
	var $idName;
	var $isOneToMany = true;

	function getRenderedValue() {
		if ($this->isOneToMany) 
			return implode('<br/> ',$this->lessonTitles[$this->value[$this->idName]]);
		else 
			return $this->value['title'];
	}
}


?>
