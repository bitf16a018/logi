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
		$this->html .='<table border="0" width="100%" class="datatable" style="background-color:white;border:0px">';
	}


	function paintRows() {
		$u = lcUser::getCurrentUser();
		$this->html .= "<tbody>\n";


		$numCols = $this->table->getColumnCount();
		$numRows = $this->table->getRowCount();
		$colModel = $this->table->getColumnModel();

		$this->html .= '<tbody>';

		for ($x = 0; $x < $numRows; ++$x) {


			//paint the columns
			$class = ($x % 2 == 0) ? 'even':'odd';
			$this->html .= '<tr class="center_justify '.$class.'" style="background-color:white;">';

			/*
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

				/*
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
				 * /


				$this->html .= '<td class="left_justify" style="font-size:140%;background-color:none;"><b>';
				$this->html .= $renderer->getRenderedValue();
				$this->html .= '</b></td>';
			}
			*/

//			$renderer = $this->table->getCellRenderer($x,$y);
//			$this->table->prepareRenderer($renderer,$x,$y);


			//name and description first
			$this->html .= '<td width="50%" valign="top" class="left_justify" style="font-size:140%;background-color:none;"><b>';
			$this->html .= $this->table->tableModel->getValueAt($x,0);
			$this->html .= '</b>';
			$desc = $this->table->tableModel->getValueNamed($x,'description');
			if ( strlen($desc) ) {
				$this->html .= '<br/>'.$this->table->tableModel->getValueNamed($x,'description');
			}
			$this->html .= '</td>';

			//then type and mime
			$this->html .= '<td valign="top" class="left_justify" style="font-size:140%;background-color:none;"><b>';
			$this->html .= $this->table->tableModel->getValueAt($x,1);
			$this->html .= '</b>&nbsp;('.$this->table->tableModel->getValueNamed($x,'mimetype').')</td>';

			//then subject, sub-discipline
			$this->html .= '<td valign="top" class="left_justify" style="font-size:140%;background-color:none;">';
			$this->html .= $this->table->tableModel->getValueAt($x,2);
			$this->html .= '</td>';

			//then author / owner
			$this->html .= '<td valign="top" class="left_justify" style="font-size:140%;background-color:none;">';
			$this->html .= $this->table->tableModel->getValueAt($x,3);
			$this->html .= '</td>';


			//then edit action
			$this->html .= '<td valign="top" class="left_justify" style="font-size:140%;background-color:none;"><b>';
			$this->html .= $this->table->tableModel->getValueAt($x,4);
			$this->html .= '</b></td>';
			$this->html .= '</tr>';

			//then the extra rows for tags, categories, and links to your classroom

			if (is_array($u->classesTaught) ) {
				$this->html .= '<tr style="background-color:white;color:green;"><td colspan="6">Link this object to your class:&nbsp;&nbsp;';
				foreach ($u->classesTaught as $classObj) {
					$this->html .= ' <a href="'.appurl('lobrepo/myobj/event=class/l='.$this->table->tableModel->getValueNamed($x,'lobId').'/c='.$classObj->id_classes).'">';
					$this->html .= $classObj->courseFamily. ' '.$classObj->courseNumber.'</a>&bull;';
//					$this->html .= ' <a href="#">ARTS 2022</a>';
				}
				$this->html .= '</td></tr>';
//				$this->html .= '</tr>';
			}
			$this->html .= '<tr style="background-color:white;color:green;"><td colspan="6">Browse more objects like this one:&nbsp;&nbsp;';
			$this->html .= ' <a href="#">ENGL</a>&bull;';
			$this->html .= ' <a href="#">PDF</a>&bull;';
			$this->html .= ' <a href="#">Content pages</a>';
			$this->html .= '</td></tr>';
			$this->html .= '<tr style="background-color:white;"><td colspan="6"><hr/>';
			$this->html .= '</td></tr>';
		}
	
		$this->html .= "</tbody>\n";
	}


	/*
	function paintHeaders() {
		//don't use headers
	}
	 */
}
?>
