<?php



class LC_Table {

	var $columnModel;
	var $tableModel;
	var $tableHeader;
	var $defaultCellRenderer;
	var $headerRepeat = -1;
	var $subHeaders = array();
	var $enableSubHeaders = false;
	var $repeatHeaders = -1;

	function LC_Table($dataModel, $columnModel = null) {

		if ( is_null($dataModel) ) {
			trigger_error("Cannot make a table with null data.");
			return false;
		}
		$this->tableModel = $dataModel;


		if ( is_null($columnModel) ) {
			$this->columnModel = new LC_TableDefaultColumnModel();
			$colCount = $dataModel->getColumnCount();
			for ($y=0; $y < $colCount; ++$y){
				$column = new LC_TableColumn();
				$column->setName( $dataModel->getColumnName($y) );
				$this->columnModel->addColumn($column);
			}
		} else {
			$this->columnModel = $columnModel;
		}

		$this->tableHeader = new LC_DefaultTableHeader($this->columnModel);
	}


	/**
	 * Asks the data model for a row count
	 * wrapper function
	 */
	function getRowCount() { 
		return $this->tableModel->getRowCount();
	}


	/**
	 * Asks the column model for a column count
	 * wrapper function
	 */
	function getColumnCount() { 
		return $this->columnModel->getColumnCount();
	}


	/**
	 * Asks the data model for a column name
	 * wrapper function
	 */
	function getColumnName($columnIndex) { 
		return $this->tableModel->getColumnName($columnIndex);
	}


	/**
	 * Return a default cell renderer, unless overriden
	 * at the column level
	 */
	function getCellRenderer($x,$y) {
		if ( ! is_object($this->defaultCellRenderer) ) {
			$this->defaultCellRenderer = new LC_TableDefaultCellRenderer();
		}
		$col = $this->columnModel->getColumnAt($y);
		if ($col->cellRenderer != null ) {
			return $col->cellRenderer;
		}
		return $this->defaultCellRenderer;
	}


	/**
	 * Set value of renderer from table model
	 */
	function prepareRenderer(&$r,$x,$y) {
		$r->row = $x;
		$r->col = $y;
		$r->setValue($this->tableModel->getValueAt($x,$y));
	}


	/**
	 * return a ref to this column model
	 */
	function &getColumnModel() {
		return $this->columnModel;
	}


	/**
	 * return a ref to this header model
	 */
	function &getHeaderModel() {
		return $this->tableHeader;
	}


	/**
	 * get relevant sub headers for this row
	 */
	function getSubHeaders($row) {
		if (! $this->enableSubHeaders) { return null ;}
		for ($x=0; $x < count($this->subHeaders); ++$x) {
			if ($this->subHeaders[$x]->row == $row) {
				return $this->subHeaders[$x];
			}
		}
		return null;
	}


	/**
	 * add a header model to the sub headers array
	 */
	function addSubHeader($header) {
		$this->subHeaders[] = $header;
		$this->enableSubHeaders = true;
	}


	/**
	 * set a column name in the tableHeader
	 */
	function setColumnNameAt($i,$n) {
		$this->tableHeader->setColumnName($i,$n);
	}
}



class LC_TablePaged extends LC_Table {

	var $rowsPerPage = 10;
	var $currentPage = 1;
	var $url;


	function getPrevUrl() {
		return '#';
	}


	function getNextUrl() {
		return '#';
	}


	function getPageUrl($i) {
		return '#';
	}


	function getMaxRows() {
		return 1;
	}
}



class LC_TableModel {

	/**
	 * Returns the most specific superclass for all the cell values in the column.
	 */
	function getColumnType($columnIndex) { }

	/**
	 * Returns the number of columns in the model.
	 */
	function getColumnCount() { }

	/**
	 * Returns a default name for the column using spreadsheet conventions: A, B, C, 
	 */
	function getColumnName($columnIndex) { }

	/**
	 * Returns the number of rows in the model.
	 */
	function getRowCount() { }

	/**
	 * Returns the value for the cell at columnIndex and rowIndex.
	 */
	function getValueAt($rowIndex, $columnIndex) { }

	/**
	 * Returns true if the cell at rowIndex and columnIndex is editable.
	 */
	function isCellEditable($rowIndex, $columnIndex) { }

	/**
	 * Sets the value in the cell at columnIndex and rowIndex to aValue.
	 */
	function setValueAt($val, $rowIndex, $columnIndex) { }
}



class LC_DefaultTableModel extends LC_TableModel {


	/**
	 * Returns the number of columns in the model.
	 */
	function getColumnCount() {
		return $this->columnModel->getColumnCount();
	}
}



class LC_TableModelPaged extends LC_DefaultTableModel {
	var $rowsPerPage = 10;
	var $currentPage = 1;
}



/**
 * Requires getPrevUrl and getNextUrl functions
 * @abstract
 */
class LC_Table_SqlModel extends LC_TableModelPaged {

	var $query = '';
	var $rs = array();
	var $colMap = array();		// 0-based lookup for column names
	var $titleMap = array();	// 0-based lookup for column headings
	var $ignore = array();

	/**
	 * make a 5 x 10 grid of nonsense
	 */
	function LC_Table_SqlModel($query,$db = '') {
		$this->query = $query;

		$db->query($query);
		while($db->nextRecord()) {
			$this->rs[] = $db->record;
		}

		$this->setRsNames( array_keys($this->rs[0]) );
	}


	/**
	 * Add a column to ignore
	 */
	function ignoreColumn($name) {
		$this->ignore[] = $name;
		$cleanMap = array();
		for($x=0; $x < count($this->colMap); ++$x) {
			if ( !in_array( $this->colMap[$x], $this->ignore) ) {
				$cleanMap[] = $this->colMap[$x];
			} 
		}
		$this->colMap = $cleanMap;
	}


	//sub-class
	/**
	 * Returns the number of rows in the model.
	 */
	function getRowCount() {
		return (count($this->rs));
	}


	function getMaxRows() {
		return (count($this->rs));
	}


	/**
	 * Returns the number of cols in the model.
	 */
	function getColumnCount() {
		return (count($this->rs[0]) - count($this->ignore));
	}


	/**
	 * Returns the name of a column.
	 */
	function getColumnName($columnIndex) {
		if ( strlen($this->titleMap[$columnIndex]) > 0 ) {
			return $this->titleMap[$columnIndex];
		} else {
			//we don't have a map, try to make a nice name
			$words = str_replace('_', ' ',$this->colMap[$columnIndex]);
			return ucwords($words);
		}
	}


	/**
	 * return the value at an x,y coord
	 *
	 * if the given column doesn't exist, return the entire record
	 */
	function getValueAt($x,$y) {
		$r = $this->rs[$x];
		$colName = $this->colMap[$y];
		if (strlen($colName) < 1) {
			return $r;
		} else {
			return $r[$colName];
		}
	}


	/**
	 * Sets the mapping of column indexes to column titles.
	 */
	function setColumnTitles($map) {
		$this->titleMap = $map;
	}


	/**
	 * Sets the mapping of column indexes to result set names.
	 */
	function setRsNames($map) {
		$this->colMap = $map;
	}
}



class LC_TableColumn {

	var $cellRenderer = null;
	var $name;
	var $maxWidth=-1;
	var $minWidth=-1;
	var $modelIndex;
	var $justify;
	var $style = '';


	function setName($n) {
		$this->name = $n;
	}

	function setIndex($i) {
		$this->modelIndex = $i;
	}

	function setCellRenderer(&$r) {
		$this->cellRenderer = $r;
	}
}



class LC_TableColumnModel {

	/**
	 * Returns the number of columns in the model.
	 */
	function getColumnCount() { }

	/**
	 * Returns a default name for the column using spreadsheet conventions: A, B, C, 
	 */
	function getColumnName($columnIndex) { }


	/**
	 * Returns a default name for the column using spreadsheet conventions: A, B, C, 
	 */
	function setColumnName($columnIndex,$columnName) { }


	/**
	 * add a column to the end
	 */
	function addColumn($c) { }


	/**
	 * return the column at index $i
	 */
	function getColumnAt($i) { }


	/**
	 * removes the column at index $i
	 */
	function removeColumnAt($i) { }


	/**
	 * return the last column
	 */
	function getLastColumn() { }


	/**
	 * return the first column
	 */
	function getFirstColumn() { }

}



class LC_TableDefaultColumnModel extends LC_TableColumnModel {

	var $tableColumns = array();

	/**
	 * Returns the number of columns in the model.
	 */
	function getColumnCount() { 
		return count($this->tableColumns);
	}

	/**
	 * Returns a default name for the column using spreadsheet conventions: A, B, C, 
	 */
	function getColumnName($columnIndex) { 
		return $this->tableColumns[$columnIndex]->name;	
	}


	/**
	 * Returns a default name for the column using spreadsheet conventions: A, B, C, 
	 */
	function setColumnName($columnIndex,$columnName) { 
		$this->tableColumns[$columnIndex]->name = $columnName;	
	}


	/**
	 * add a column to the end
	 * @return	int	 new index
	 */
	function addColumn($c) { 
		$idx = count($this->tableColumns);
		$c->setIndex($idx);
		$this->tableColumns[$idx] = $c;
		return $idx;
	}


	/**
	 * return the column at index $i
	 */
	function &getColumnAt($i) { 
		return $this->tableColumns[$i];
	}


	/**
	 * return the column at index $i
	 */
	function removeColumnAt($i) { 
		unset( $this->tableColumns[$i] );
	}


	/**
	 * return the last column
	 */
	function &getLastColumn() { 
		return $this->tableColumns[ count($this->tableColumns)-1 ];
	}


	/**
	 * return the first column
	 */
	function &getFirstColumn() { 
		return $this->tableColumns[0];
	}
}


/**
 * Manages column models for headers
 */
class LC_TableHeader {

	var $columnModel;
	var $row = -1;

	function LC_TableHeader($columnModel) { }


	/**
	 * return a ref to this column model
	 */
	function &getColumnModel() { }


	/**
	 * return the column at index $i
	 */
	function &getColumnAt($i) { }


	/**
	 * Asks the data model for a column name
	 * wrapper function
	 */
	function getColumnName($columnIndex) { }


	/**
	 * Sets the name of the column at an index
	 */
	function setColumnName($i,$n) { }
}



/**
 * Manages column models for headers
 */
class LC_DefaultTableHeader  extends LC_TableHeader {

	var $columnModel;
	var $row = -1;

	function LC_DefaultTableHeader($columnModel) {
		$this->columnModel = $columnModel;
	}


	/**
	 * return a ref to this column model
	 */
	function &getColumnModel() {
		return $this->columnModel;
	}


	/**
	 * return the column at index $i
	 */
	function &getColumnAt($i) { 
		return $this->columnModel->tableColumns[$i];
	}


	/**
	 * Asks the data model for a column name
	 * wrapper function
	 */
	function getColumnName($columnIndex) { 
		return $this->columnModel->getColumnName($columnIndex);
	}


	/**
	 * Sets the name of the column at an index
	 */
	function setColumnName($i,$n) { 
		$this->columnModel->setColumnName($i,$n);
	}

}



?>
