<?php

/**
 * Shows the table as HTML
 * @static
 */
class LC_TableRenderer {

	var $html;	//holds the renered html
	var $table;		//the table to render, must be of type LC_Table

	function LC_TableRenderer($t) {
		$this->table = $t;
	}

	/**
	 * Shows the table as HTML
	 *
	 * do not show a table if there are zero (0) rows, return false
	 * @static
	 */
	function toHTML() {
		if ($this->table->getRowCount() < 1) { return false; }

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
		$this->html .= '<table cellpadding="0" cellspacing="1" class="datatable" width="100%" style="clear:both;">';
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
		$colModel = $this->table->getHeaderModel();

		for ($y=0; $y < $numCols; ++$y ) {
			$hCol = $colModel->getColumnAt($y);
			if ( strlen($hCol->justify) > 0 ) {
				$justify = $hCol->justify.'_justify';
			} else {
				$justify = '';
			}

			$colName = $colModel->getColumnName($y);
			$this->html .= '<th abbr="'.$colName.'" scope="col" title="'.$colName.'"';

			if ( strlen($justify) > 0) {
				$this->html .= ' class="'.$justify.'"';
			}

			$this->html .= '>';
			$this->html .= $colName;
			$this->html .= '</th>';
		}
		$this->html .= '</tr>';
		$this->html .= '</thead>';
		$this->html .= "\n\n";
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

			//paint the columns
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

				if ( strlen($tCol->style) > 0 ) {
					$style = $tCol->style;
				} else {
					$style = '';
				}


				$renderer = $this->table->getCellRenderer($x,$y);
				$this->table->prepareRenderer($renderer,$x,$y);

				$css = $renderer->getCellCSS();
				if ( count ($css) > 0 ) {
					foreach ($css as $i=>$j) {
						$style .= "$i:$j;";
					}
				}
				$this->html .= '<td';
				if ($width > -1) {
					$this->html .= ' width="'.$width.'"';
				}

				if ( strlen($justify) > 0) {
					$this->html .= ' class="'.$justify.'"';
				}

				if ( strlen($style) > 0) {
					$this->html .= ' style="'.$style.'"';
				}

				$this->html .='>';


				$this->html .= $renderer->getRenderedValue();
				$this->html .= '</td>';
			}

			$this->html .= '</tr>';
		}

		$this->html .= '</tbody>';

	}

}



class LC_TableRendererPaged extends LC_TableRenderer {


	/**
	 * Add back and forth navigation
	 */
	function startTable() {
		$maxRows = $this->table->getMaxRows();
		$pages = ceil($maxRows / $this->table->rowsPerPage);
		$this->html .= '<div class="datatable_nav" style="padding-top:7px;" align="right">';
		$this->html .= '<a href="'.$this->table->getPrevUrl().'">&laquo;Prev</a> | ';
		for ($x=1; $x<=$pages; ++$x) {
			$this->html .= ' <a href="'.$this->table->getPageUrl($x).'">'.$x.'</a>';
		}
		$this->html .= ' | <a href="'.$this->table->getNextUrl().'">Next&raquo;</a>';
		$this->html .= ' Current Page: '.$this->table->currentPage;
		$this->html .= '</div>';
		parent::startTable();
	}


	/**
	 * Add back and forth navigation
	 */
	function endTable() {
		parent::endTable();
		$maxRows = $this->table->getMaxRows();
		$pages = ceil($maxRows / $this->table->rowsPerPage);
		$this->html .= '<div class="datatable_nav" style="padding-bottom:7px;" align="right">';
		$this->html .= '<a href="'.$this->table->getPrevUrl().'">&laquo;Prev</a> | ';
		for ($x=1; $x<=$pages; ++$x) {
			$this->html .= ' <a href="'.$this->table->getPageUrl($x).'">'.$x.'</a>';
		}
		$this->html .= ' | <a href="'.$this->table->getNextUrl().'">Next&raquo;</a>';
		$this->html .= ' Current Page: '.$this->table->currentPage;
		$this->html .= '</div>';
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


	function getCellCSS() {
		return array();
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



class LC_TableYesNoRenderer extends LC_TableCellRenderer {

	function getRenderedValue() {
		if ($this->value == 1) {
			return 'Yes';
		}
		return 'No';
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
		//is it a date string?
		if ( (string)intval($this->value) != (string)$this->value) {
			return date($this->dateFormat, strtotime($this->value));
		} else {
			return date($this->dateFormat, $this->value);
		}
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



class LC_TableRadioRenderer extends LC_TableCellRenderer {

	var $selectedVal;
	var $selectedKey;
	var $idName;
	var $fieldName = 'item';

	function getRenderedValue() {
		//is the value an array ?
		if ( is_array($this->value) ) {
			$idValue = $this->value[$this->idName];
			$selected = ($this->selectedVal == $this->value[$this->selectedKey]) ? ' CHECKED ':'';
		}
		//is it a PBDO object wrapper?
		else if ( is_object($this->value) && is_object($this->value->_dao) ) {
			$idValue = $this->value->_dao->getPrimaryKey();
			$selected = ($this->selectedVal == $this->value->_dao->{$this->selectedKey}) ? ' CHECKED ':'';
		}
		//is it a regular object?
		else if ( is_object($this->value) ) {
			$idValue = $this->value->{$this->idName};
			$selected = ($this->selectedVal == $this->value->{$this->selectedKey}) ? ' CHECKED ':'';
		}
		return '<input id="'.$this->fieldName.'" name="'.$this->fieldName.'" value="'.$idValue.'" '.$selected.' type="radio">';
	}
}



class LC_TableCheckboxRenderer extends LC_TableCellRenderer {

	var $selectedVal;
	var $selectedKey;
	var $idName;
	var $fieldName = 'item';

	function getRenderedValue() {
		//is the value an array ?
		if ( is_array($this->value) ) {
			$idValue = $this->value[$this->idName];
			$selected = ($this->selectedVal == $this->value[$this->selectedKey]) ? ' CHECKED ':'';
		}
		//is it a PBDO object wrapper?
		else if ( is_object($this->value) && is_object($this->value->_dao) ) {
			$idValue = $this->value->_dao->getPrimaryKey();
			$selected = ($this->selectedVal == $this->value->_dao->{$this->selectedKey}) ? ' CHECKED ':'';
		}
		//is it a regular object?
		else if ( is_object($this->value) ) {
			$idValue = $this->value->{$this->idName};
			$selected = ($this->selectedVal == $this->value->{$this->selectedKey}) ? ' CHECKED ':'';
		}
//		$selected = ($this->selectedVal == $this->value[$this->selectedKey]) ? ' CHECKED ':'';
		return '<input id="'.$this->fieldName.'['.$this->row.']" name="'.$this->fieldName.'['.$this->row.']" value="'.$idValue.'" '.$selected.' type="checkbox">';
	}
}
?>
