<?php



class LC_Table {

	var $columnModel;
	var $tableModel;
	var $tableHeader;
	var $defaultCellRenderer;
	var $headerRepeat = -1;
	var $subHeaders = array();
	var $enableSubHeaders = false;

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

		$this->tableHeader = new LC_TableHeader($this->columnModel);
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
		$r->setValue($this->tableModel->getValueAt($x,$y));
		$r->row = $x;
		$r->col = $y;
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

}



class LC_TableColumn {

	var $cellRenderer = null;
	var $name;
	var $maxWidth=-1;
	var $minWidth=-1;
	var $modelIndex;
	var $justify;


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
	 * add a column to the end
	 */
	function addColumn($c) { }


	/**
	 * return the column at index $i
	 */
	function getColumnAt($i) { }


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

	function LC_TableHeader($columnModel) {

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


}



?>
