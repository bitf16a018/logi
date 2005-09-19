<?php

include_once(LIB_PATH."lc_table.php");
include_once(LIB_PATH."lc_table_renderer.php");



/**
 * 
 *
 */
class LC_Table_Calendar extends LC_Table {

	/**
	 * Always 7 days in a week
	 */
	function getColumnCount() {
		return 7;
	}
}



/**
 * 
 *
 */
class LC_TableModel_ClassCalendar extends LC_TableModel {

	var $classIds = array();
	var $m = 0;
	var $d = 0;
	var $y = 0;
	var $events = array();
	var $today = 0;


	/**
	 * Gathers class events for a given time period.
	 * Defaults to current year and current month
	 */
	function LC_TableModel_ClassCalendar($classIds, $y=0, $m=0, $d=0) {
		if (! is_array($classIds) ) {
			$this->classIds[] = $classIds;
		} else {
			$this->classIds = $classIds;
		}
		$this->y = $y;
		$this->m = $m;
		$this->d = $d;
		$this->today = date('m d Y G i s');

		list ($m, $d, $y, $g, $i, $s) = explode(' ', $this->today);
		if ($this->y == 0) {
			$this->y = $y;
		}
		if ($this->m == 0) {
			$this->m = $m;
		}

		$this->loadClassEvents();
	}


	/**
	 * Always 7 days in a week
	 */
	function getColumnCount() {
		return 7;
	}


	/**
	 * Return how many rows in this calendar view
	 */
	function getRowCount() {
		return 5;
	}


	function getValueAt($i, $y) {
		return $i* $y;
	}


	function loadClassEvents() {
		$classIds = implode($this->classIds, ' or id_classes=');
		$start = 0;
		$end = time()+86400;

		$sql ='
		SELECT * 
		FROM lcEvents 
		WHERE 
		(id_classes = '.$classIds.')
		AND
		(
			(repeatType > 0  AND enddate = 0)
			OR
			(enddate >='.$start.' AND enddate<='.$end.')
			OR
			(startdate >='.$start.' AND startdate<='.$end.')
			OR
			(startdate <= '.$start.' AND enddate >= '.$end.')
		)	'.$sql_type.'	
		ORDER BY calendarType ASC';

		$db = DB::getHandle();
		$db->query($sql);
		while( $db->nextRecord() ) {
			$this->events[$db->record['pkey']] = $db->record;
		}
	}
}



/**
 * Renders a table as a calendar
 */
class LC_TableRenderer_Calendar extends LC_TableRenderer {

	var $startDay = 'monday';

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

			$colName = $this->getNameOfDay($y);
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


	function getNameOfDay($y) {

		switch($y) {
			case 0:
				return 'Sunday';
			case 1:
				return 'Monday';
			case 2:
				return 'Tuesday';
			case 3:
				return 'Wednesday';
			case 4:
				return 'Thursday';
			case 5:
				return 'Friday';
			case 6:
				return 'Saturday';
		}
	}
}
?>
