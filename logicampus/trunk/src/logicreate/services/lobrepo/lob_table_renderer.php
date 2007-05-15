<?php

/**
 * Custom renderer for Learning Objects
 */
class Lob_Table_Renderer extends LC_TableRenderer {


	/**
	 * Shows the table as HTML
	 *
	 * Override and paint an extra row per data item
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


	function startTable() {
		$this->html .='<table border="5" width="100%">';
	}


	function paintRows() {
		$this->html .= "<tbody>\n";


		$numCols = $this->table->getColumnCount();
		$numRows = $this->table->getRowCount();
		$colModel = $this->table->getColumnModel();

		$this->html .= '<tbody>';

		for ($x = 0; $x < $numRows; ++$x) {


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
			$this->html .= '<tr><td colspan="6">';
			$this->html .= ' <a href="#">Link 1</a>&bull;';
			$this->html .= ' <a href="#">Link 2</a>&bull;';
			$this->html .= ' <a href="#">Link 3</a>';
			$this->html .= '</td></tr>';

		}
	
		$this->html .= "</tbody>\n";
	}


	function paintHeaders() {
		//don't use headers
	}
}
?>
