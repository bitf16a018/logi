<?php

/**
 * Custom renderer for Learning Objects
 */
class Lob_Table_Renderer extends LC_TableRendererPaged {


	var $style="clear:right; border:0px; background-color:white;";
//	var $cssClass = 'datatable';

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
		parent::startTable();
//		$this->html .='<table border="0" width="100%" class="datatable" style="background-color:white;border:0px">';
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

			//create links for tag cloud
			// and quick links to use this object in your class
			$browseHtml  = '<span style="font-size:8pt;color:green;">Browse more:&nbsp;';
			$browseHtml .= ' <a href="#">'.
				$this->table->tableModel->getValueNamed($x,'subject')
				.'</a> &bull;';
			$browseHtml .= ' <a href="#">'.
				$this->table->tableModel->getValueNamed($x,'subdisc')
				.'</a>';
//			$browseHtml .= ' <a href="#">Content pages</a></span>';
			if (is_array($u->classesTaught) ) {
				$linkHtml = '<span style="font-size:8pt;background-color:white;color:green;">Link this object to your class:&nbsp;';
				$lobId = $this->table->tableModel->getValueNamed($x,'lobRepoEntryId');
				foreach ($u->classesTaught as $classObj) {
					if (in_array($classObj->id_classes,$this->classLinkIds[$lobId])) { 
						$linkHtml .= ' <span style="color:black;">'.$classObj->courseFamily. ' '.$classObj->courseNumber.'</span> &bull;';
					} else {
						$linkHtml .= ' <a href="'.appurl('lobrepo/myobj/event=class/l='.$lobId.'/c='.$classObj->id_classes).'">';
						$linkHtml .= $classObj->courseFamily. ' '.$classObj->courseNumber.'</a> &bull;';
					}
				}
				$linkHtml .= '</span>';
			}



			//name and description first
			// with the links
			$this->html .= '<td width="50%" valign="top" class="left_justify" style="font-size:140%;background-color:none;"><b>';
			$this->html .= $this->table->tableModel->getValueAt($x,0);
			$this->html .= '</b>';
			$desc = $this->table->tableModel->getValueNamed($x,'description');
			if ( strlen($desc) ) {
				$this->html .= '<br/>'.$desc;
			}

			$this->html .= "<br/><br/>\n".$linkHtml."\n";
			$this->html .= "<br/>\n".$browseHtml."\n";
			$this->html .= '</td>';

			//then subject, sub-discipline
			$this->html .= '<td width="20%" valign="top" class="left_justify" style="font-size:140%;background-color:none;">';
			$this->html .= $this->table->tableModel->getValueAt($x,1);
			$this->html .= '</td>';

			//then type and mime
			$this->html .= '<td valign="top" class="center_justify" style="background-color:none;">';
			$this->html .= '<img width="48" height="48" src="'.IMAGES_URL.'mimetypes/'.LC_Lob_Util::getMimeIcon($this->table->tableModel->getValueNamed($x,'mimetype')).'" title="Mime: '.$this->table->tableModel->getValueNamed($x,'mimetype').'" alt="Mime: '.$this->table->tableModel->getValueNamed($x,'mimetype').'" /><br/>';
			$this->html .= '<b>';
			$this->html .= $this->table->tableModel->getValueAt($x,2);
			$this->html .= '</b></td>';

			//then author / owner
			$this->html .= '<td width="20%" valign="top" class="left_justify" style="font-size:140%;background-color:none;">';
			$this->html .= $this->table->tableModel->getValueAt($x,3);
			$this->html .= '</td>';

			$this->html .= '</tr>';

			$this->html .= '<tr style="background-color:white;"><td colspan="4"><hr/>';
			$this->html .= "</td></tr>\n";

		}
	
		$this->html .= "</tbody>\n";
	}
}
?>
