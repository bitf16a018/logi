<?php

/**
 * Shows the table as HTML
 * @static
 */
class LC_TableRenderer {

	var $html;	//holds the renered html
	var $t;		//the table to render, must be of type LC_Table

	function LC_TableRenderer($t) {
		$this->table = $t;
	}

	/**
	 * Shows the table as HTML
	 * @static
	 */
	function toHTML() {
		$this->html = '';

		$this->startTable();

		$this->paintHeaders();

		$this->paintRows();

		$this->endTable();

		return $this->html;
	}

	/**
	 * opens the table
	 */
	function startTable() {
		$this->html .= '<table cellpadding="0" cellspacing="1" class="datatable" width="100%">';
		$this->html .= "\n";
	}


	/**
	 * closes the table
	 */
	function endTable() {
		$this->html .= '</table>';
		$this->html .= "\n";
	}


	/**
	 * print column headers
	 */
	function paintHeaders() {
		$this->html .= '<thead>';
		$this->html .= '<tr class="left_justify">';
		$numCols = $this->table->getColumnCount();
		$colModel = $this->table->getColumnModel();

		for ($y=0; $y < $numCols; ++$y ) {
			$colName = $colModel->getColumnName($y);
			$this->html .= '<th  abbr="'.$colName.'" scope="col" title="'.$colName.'">';
			$this->html .= $colName;
			$this->html .= '</th>';
		}
		$this->html .= '</tr>';
		$this->html .= '</thead>';
	}


	/**
	 * print column sub headers
	 * basically the same as above, but it doesn't take
	 * a parameter and there's no thead
	 */
	function paintSubHeaders($sub) {
		$this->html .= '<tr class="left_justify">';
		$colModel =& $sub->getColumnModel();
		$numCols = $colModel->getColumnCount();
		$regularNumCols = $this->table->getColumnCount();
		//there's probably a colspan in sub headers
		$colspan =  $regularNumCols - $numCols + 1;

		for ($y=0; $y < $numCols; ++$y ) {
			$colName = $colModel->getColumnName($y);
			$this->html .= '<th colspan="'.$colspan.'">';
			$this->html .= $colName;
			$this->html .= '</th>';
		}
		$this->html .= '</tr>';
	}


	/**
	 * print row data 
	 */
	function paintRows() {

		$numCols = $this->table->getColumnCount();
		$numRows = $this->table->getRowCount();
		$colModel = $this->table->getColumnModel();

		$this->html .= '<tbody>';

		for ($x = 0; $x < $numRows; ++$x) {
			//repeat headers
			if ($this->table->repeatHeaders > 0 ) {
				if ( ($x % $this->table->repeatHeaders == 0 )
					and $x > 0 ) {
						$this->paintHeaders();
				}
			}

			//sub headers
			if ($this->table->enableSubHeaders == true) {
				$sub = $this->table->getSubHeaders($x);
				if ($sub != null) {
					$this->paintSubHeaders($sub);
				}
			}

			//paint the columsn
			$class = ($x % 2 == 0) ? 'even':'odd';
			$this->html .= '<tr class="center_justify '.$class.'">';

			for ($y = 0; $y < $numCols; ++$y ) {
				$tCol = $colModel->getColumnAt($y);
				if ($tCol->maxWidth > -1 ) {
					$width = $tCol->maxWidth;
				} else {
					$width = -1;
				}
				if ( strlen($tCol->justify) > 0 ) {
					$justify = $tCol->justify.'_justify';
				} else {
					$justify = '';
				}


				$colName = $colModel->getColumnName($y);
				$renderer = $this->table->getCellRenderer($x,$y);
				$this->table->prepareRenderer($renderer,$x,$y);


				$this->html .= '<td';
				if ($width > -1) {
					$this->html .= ' width="'.$width.'"';
				}

				if ( strlen($justify) > 0) {
					$this->html .= ' class="'.$justify.'"';
				}


				$this->html .='>';


				$this->html .= $renderer->getRenderedValue();
				$this->html .= '</td>';
			}

			$this->html .= '</tr>';
		}

		$this->html .= '</thead>';

	}

}


class LC_TableCellRenderer {

	var $value;
	var $row;
	var $col;


	function setValue($o) {
		$this->value = $o;
	}


	function getRenderedValue() {
		return $this->value;
	}
}


class LC_TableDefaultCellRenderer extends LC_TableCellRenderer {


	function getRenderedValue() {
		//print_r($this->value);
	
		if ( is_numeric($this->value) ) {
			return sprintf('%d',$this->value);
		} else if (is_string($this->value) ) {
			return sprintf('%s',$this->value);
		} else if ( method_exists('toString',$this->value) ) {
			return $this->value->toString();
		} else {
			return $this->value;
		}
	}
}


class LC_TableMoneyRenderer extends LC_TableCellRenderer {

	var $moneyType = 'USD';

	function getRenderedValue() {
		switch ($this->moneyType) {
			case 'USD':
			return sprintf('USD $; %.2f',intval($this->value));

			case 'JPY':
			return sprintf('JPY &yen; %.2f',intval($this->value));
		}

		return sprintf('$ %.2f',intval($this->value));
	}
}


class LC_TableFormatRenderer extends LC_TableCellRenderer {

	var $format = '%s';

	function getRenderedValue() {
		return sprintf($this->format,$this->value);
	}
}


class LC_TableDateRenderer extends LC_TableCellRenderer {

	var $dateFormat = 'n / j / Y';

	function LC_TableDateRenderer($format='') {
		if ( strlen($format) > 0 ) {
			$this->dateFormat = $format;
		}
	}

	function getRenderedValue() {
		return date($this->dateFormat, $this->value);
	}
}


class LC_TableUrlRenderer extends LC_TableCellRenderer {

	var $url;
	var $linkText = '';
	var $argName  = '';

	function LC_TableUrlRenderer($url,$linkText,$argName = null) {
		$this->url = $url;
		if ( $argName != null ) {
			$this->argName = $argName;
		}
		$this->linkText = $linkText;
	}


	function getRenderedValue() {
		$arglist= ''; 
		if ( strlen($this->argName) > 0 ) {
			$arglist = $this->argName.'='.urlencode($this->value).'/';
		}
		return '<a href="'.$this->url.$arglist.'">'.$this->linkText.'</a>';
	}
}


?>
