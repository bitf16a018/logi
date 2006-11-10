<?php

include_once(LIB_PATH."lc_table.php");
include_once(LIB_PATH."lc_table_renderer.php");



/**
 * 
 *
 */
class LC_Table_ClassCalendar extends LC_Table {

	var $todayDate;

	var $eventWindow = 'month';


	function getMonthCalendar($classIds, $y, $m, $d) {
		$dataModel = new LC_TableModel_ClassCalendar($classIds,$y,$m,$d);
		$cal = new LC_Table_ClassCalendar($dataModel);

		$columnModel = &$cal->getColumnModel();
		for ($x=0; $x < 7; ++$x) {
			$col = &$columnModel->getColumnAt($x);
			$col->cellRenderer = new LC_TableCellRenderer_CalendarDate();
			$col->cellRenderer->class = 'cal_weekday' ;
		}

		return $cal;
	}


	/**
	 * return a calendar setup to view one day
	 * The Column Model will only have 2 cols, one for type and one for description
	 * of event.
	 */
	function getDayCalendar($classIds, $y, $m, $d) {
		$dataModel = new LC_TableModel_ClassCalendar($classIds,$y,$m,$d,'day');
		$cal = new LC_Table_ClassCalendar($dataModel);
		$cal->eventWindow = 'day';

		$cal->columnModel = new LC_TableDefaultColumnModel();
		$column = new LC_TableColumn();
		$column->setName('Time');
		$column->maxWidth ='20%';
		$column->cellRenderer = new LC_TableCellRenderer_CalendarTime();
		$cal->columnModel->addColumn($column);
		$column = new LC_TableColumn();
		$column->setName('Description');
		$column->maxWidth = '80%';
		$column->cellRenderer = new LC_TableCellRenderer_CalendarEventList($cal->tableModel->targetDate);
		$column->justify = 'left';
		$cal->columnModel->addColumn($column);

		$cal->tableHeader = new LC_DefaultTableHeader($cal->columnModel);

		return $cal;
	}


	/**
	 * return a calendar setup to view one week
	 * The Column Model will only have 2 cols, one for type and one for description
	 * of event.
	 */
	function getWeekCalendar($classIds, $y, $m, $d) {
		$dataModel = new LC_TableModel_ClassCalendar($classIds,$y,$m,$d,'week');
		$cal = new LC_Table_ClassCalendar($dataModel);
		$cal->eventWindow = 'week';

		//$cal->firstDayOfMonth = $dataModel->firstDayOfMonth;

		$columnModel = &$cal->getColumnModel();
		for ($x=0; $x < 7; ++$x) {
			$col = &$columnModel->getColumnAt($x);
			$col->cellRenderer = new LC_TableCellRenderer_CalendarDate();
		}

		return $cal;
	}


	/**
	 * Return the number of days in this month
	 */
	function getDaysInMonth() {
		return $this->tableModel->daysInMonth;
	}


	/**
	 * Return a link to dayView, monthView, or weekView.
	 *
	 * Take special care when jumping over month boundaries.
	 */
	function getNextLink() {
		$delta = 0;
		switch($this->eventWindow) {
			case 'week':
				$delta = 7;
				//if the desired day is not a sunday, only jump forward number of days
				// to get you to a sunday.
				if ( $this->tableModel->targetDate->dayOfWeek > 0 ) {
					$delta = (7-$this->tableModel->firstOfMonth->dayOfWeek);
				}
				//if adding a whole week jumps you forwards a month, just go to the 
				// first of the month 
				if ( $this->getD() + $delta > $this->getDaysInMonth() ) {
					$delta = $this->getDaysInMonth() - $this->getD() +1;
				}
				/* might not need this, might be handled by above block

				//if we're already on the last day of the month
				// jump to the first of next month (one more day)
				if ( $this->getD() == $this->getDaysInMonth() ) {
					$delta = 1;
				}
				*/

				$delta = $delta * 86400;
				$event='viewWeek';
				list ($m, $d, $y) = explode(' ', date ('m d Y', $this->tableModel->targetDate->timeStamp+$delta) );
				break;
			default:
				$m = $this->getM()+1;
				$d = 1;
				if ($m > 12) {
					$m = 1;
					$y = $this->getY()+1;
				} else {
					$y = $this->getY();
				}
				$event='';
		}
		return appurl('classroom/classCalendar/event='.$event.'/d='.$d.'/m='.$m.'/y='.$y);
	}


	/**
	 * return a link to dayView, monthView, or weekView
	 */
	function getPrevLink() {
		$delta = 0;
		switch($this->eventWindow) {
			case 'week':
				$delta = 7;
				//if the desired day is not a sunday, try to bump backwards to a sunday
				if ( $this->tableModel->targetDate->dayOfWeek > 0 ) {
					$delta += $this->tableModel->targetDate->dayOfWeek;
				}
				//if subtracting a whole week bumps you back a month, just go to the 
				// first of the month, unless this calendar date is in the first week already.
				if ( $this->getD() - $delta < 1  && ($this->getD() + $this->tableModel->startOfWeek->dayOfWeek > 7)) {
					$delta = $this->getD()-1;
				}
				//if we're already on the first of the month (outcome from the last if block)
				// or we are on a day that is in the first week of the month
				// bump back a week to the sunday of the previous month
				if ( $this->getD() == 1 || ($this->getD() + $this->tableModel->startOfWeek->dayOfWeek < 7)) {
					$delta =  ($this->tableModel->firstOfMonth->dayOfWeek);
				}
				//debug($delta);
				$delta = $delta * 86400;
				$event='viewWeek';
				list ($m, $d, $y) = explode(' ', date ('m d Y', $this->tableModel->targetDate->timeStamp - $delta) );
				break;
			case 'day':
				//$delta = 86400;
				$m = $this->getM();
				$d = $this->getD()-1;
				if ($m < 1) {
					$y = $this->getY()-1;
					$m = 12;
				} else {
					$y = $this->getY();
				}

			default:
				//$delta = $this->getDaysInMonth()*86400;
				$m = $this->getM()-1;
				$d = 1;
				if ($m < 1) {
					$y = $this->getY()-1;
					$m = 12;
				} else {
					$y = $this->getY();
				}
				$event='';
		}
		return appurl('classroom/classCalendar/event='.$event.'/d='.$d.'/m='.$m.'/y='.$y);
	}


	/**
	 * get the desired Date
	 */
	function getD() {
		return $this->tableModel->d;
	}


	/**
	 * get the desired Date
	 */
	function getY() {
		return $this->tableModel->y;
	}


	/**
	 * get the desired Date
	 */
	function getM() {
		return $this->tableModel->m;
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
	var $windowStartTS = 0;
	var $windowEndTS = 0;
	var $rowCount = 5;
	var $eventWindow = 'month';

	var $targetDate;
	var $firstOfMonth;
	var $lastOfMonth;

	var $startOfWeek;
	var $endOfWeek;

	var $windowStart;
	var $windowEnd;



	/**
	 * Gathers class events for a given time period.
	 * Defaults to current year and current month if no end dates are given
	 * Event window can be one of: day, week, month, year
	 */
	function LC_TableModel_ClassCalendar($classIds, $y=0, $m=0, $d=0, $eventWindow = 'month') {
		if (! is_array($classIds) ) {
			$this->classIds[] = $classIds;
		} else {
			$this->classIds = $classIds;
		}
		$this->y = $y;
		$this->m = $m;
		$this->d = $d;
		if ($this->d == 0 ) { 
			$this->d = 1;
		}


		$this->today = date('m d Y G i s');

		list ($m, $d, $y, $g, $i, $s) = explode(' ', $this->today);
		if ($this->y == 0) {
			$this->y = $y;
		}
		if ($this->m == 0) {
			$this->m = $m;
		}

		$this->init($this->y,$this->m,$this->d);


		$this->eventWindow = $eventWindow;

		if ( $eventWindow == 'month' ) {
			$this->windowStartTS = mktime(0,0,0,$this->m,1,$this->y);
			$this->windowEndTS = mktime(0,0,0,$this->m+1,1,$this->y) -1;
		}

		if ( $eventWindow == 'week' ) {
			$this->windowStartTS = mktime(0,0,0,$this->m,$this->startOfWeek->date,$this->y);
			$this->windowEndTS = mktime(0,0,0,$this->m,$this->endOfWeek->date,$this->y) -1;
		}

		if ( $eventWindow == 'day' ) {
			$this->windowStartTS = mktime(0,0,0,$this->m,$this->d,$this->y);
			$this->windowEndTS = mktime(23,59,59,$this->m,$this->d,$this->y);
		}

		//FIXME
		if ( $eventWindow == 'year' ) {
		}

		$this->loadClassEvents($this->windowStartTS, $this->windowEndTS);
	}


	function init($y, $m, $d) {
		list ($ty, $tm, $td) = explode(' ', date('Y m d', time()) );
		$this->todayDate = new LC_Calendar_DateInfo( mktime(0,0,0, $tm, $td, $ty) );
		$this->targetDate = new LC_Calendar_DateInfo( mktime(0,0,0, $m, $d, $y) );
		$this->firstOfMonth = new LC_Calendar_DateInfo( 
			mktime(0,0,0, $this->targetDate->month, 1, $this->targetDate->year)
		);
		$this->daysInMonth= date('t',$this->targetDate->timeStamp);

		$weekStart = $d - $this->targetDate->dayOfWeek+1;
		$weekEnd = $d + (7-$this->targetDate->dayOfWeek);
		if ($weekStart < 1 ) { $weekStart = 1; }

		$this->startOfWeek = new LC_Calendar_DateInfo(mktime(0,0,0,$m, $weekStart, $y));
		$this->endOfWeek = new LC_Calendar_DateInfo(mktime(0,0,0,$m, $weekEnd, $y));
		//debug($this->targetDate,1);
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
		//find the remainder of days that don't fit into 4 weeks, minus
		// the number of days in the first week
		
		if ($this->eventWindow == 'week' || $this->eventWindow == 'day') {
			return 1;
		}

		//debug($this->firstOfMonth,1);
		$daysInFirstWeek =  (7 - $this->firstOfMonth->dayOfWeek);
		if ( ($this->daysInMonth - 28 - $daysInFirstWeek) > 0) { 
			return 6;
		} else {
			if ($daysInFirstWeek > 0 ) {
				return 5;
			} else {
				return 4;
			}
		}
		return $this->rowCount;
	}


	function getValueAt($x, $y) {
		$date = $this->coordsToDate($x,$y,$this->firstOfMonth->dayOfWeek);
		//don't add extra day to the first of month ($date-1)
		//debug( date ('m d Y h i s A',$this->firstOfMonth->timeStamp));
		//mktime seems like overkill here, but simple second math is going to break
		// over Daylight Savings.
		$dateStamp = mktime(0,0,0,$this->firstOfMonth->month, $date, $this->firstOfMonth->year);
		//debug( $date);
		//debug (($date-1) * 86400);
		//debug( date ('m d Y h i s A',$dateStamp));
		return $this->countEventsOnDay($dateStamp);
	}


	function coordsToDate($x,$y,$offset) {
		return ($x*7) + $y - $offset + 1 + $this->weekViewOffset;
	}


	function countEventsOnDay($dateStamp) {
		$evts = $this->getEventsOnDay($dateStamp);
		return count($evts);
	}


	/**
	 * Return an array of events that happen on this day.
	 * Requires that the date stamp is the start of the day.
	 */
	function getEventsOnDay($dateStamp) {
		$ret = array();
//		debug($this->events);
		//echo "asked for  events on ". date('m d Y', $dateStamp)." $dateStamp<br/>";
		foreach($this->events as $blank=>$evt) {
			list($m,$d,$y) = explode(' ', date('m d Y',$evt['startdate']));
			$evtStart = mktime(0,0,0,$m,$d,$y);
			list($m,$d,$y) = explode(' ', date('m d Y',$evt['enddate']));
			$evtEnd = mktime(0,0,0,$m,$d,$y);

			if ($evtStart == $dateStamp || $evtEnd == $dateStamp) {
				//echo "Found an event on day ".date("F d Y", $dateStamp)."<br/>";
//				//echo "event is <pre>";
//				print_r($evt); echo "</pre><br/>";
				$ret[] = $evt;
			}
		}
		if (count($ret)) {
			//echo "Found ".count($ret)." events on day ".date("F d Y", $dateStamp)."<br/>";
		}
		return $ret;
	}


	/**
	 * Return an array of events that happen within a certain hour.
	 * Assume all events in this model are loaded for the same day.
	 */
	function getEventsAtHour($dateStamp) {
		$ret = array();
//		echo "Hour is : ".date('G:i:s',$dateStamp);
//		echo "<br/><br/>";
		foreach($this->events as $blank=>$evt) {
			list($m,$d,$y,$g) = explode(' ', date('m d Y G',$evt['startdate']));
			$evtStart = mktime($g,0,0,$m,$d,$y);
			list($m,$d,$y,$g) = explode(' ', date('m d Y G',$evt['enddate']));
			$evtEnd = mktime($g,0,0,$m,$d,$y);

			if ($evtStart == $dateStamp || $evtEnd == $dateStamp) {
				$ret[] = $evt;
//			} else {
//				echo "event is not at this hour ".$evt['title']." ". date('m d Y G:i:s', $evt['startdate'])."<br/>";
//				echo "event is not at this hour ".$evt['title']." ". date('m d Y G:i:s', $evt['enddate'])."<hr/>";
			}
		}
		return $ret;
	}


	function loadClassEvents($start,$end) {
		$classIds = implode($this->classIds, ' or id_classes=');

		$sql_type = '';
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
			(startdate <= '.$start.' AND enddate >= '.$end.' AND repeatType >0)
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
	var $renderCompact = false;
	var $monthFormatCompact = 'F Y';
	var $monthFormatFull = 'F Y';
	var $dayFormatCompact = 'D';
	var $dayFormatFull = 'l';
	var $weekViewOffset = 0;


	/**
	 * Print next and previous month links
	 */
	function controlsToHTML() {
		$prevLink = $this->table->getPrevLink();
		$nextLink = $this->table->getNextLink();
		$this->html = '';

		$this->html .= '<div class="calendar_controls" style="text-align:center;">';
		$this->html .= '<div style="margin-top:0.5em;float:right;">
			<a href="'.$this->table->getNextLink().'"><img border="0" src="'.IMAGES_URL.'next.gif"/></a>
			</div>';
		$this->html .= '<div style="margin-top:0.5em;float:left;">
			<a href="'.$this->table->getPrevLink().'"><img border="0" src="'.IMAGES_URL.'prev.gif"/></a>
			</div>';
			$this->html .= '<div>'.$this->getMonthName($this->table->tableModel->targetDate->timeStamp).'</div>';
		$this->html .= '</div>';
		/*
		$this->paintHeaders();

		$this->paintRows();

		$this->endTable();
		*/

		return $this->html;
	}


	function setCompact($c=true) {
		$this->renderCompact = $c;
	}


	function getMonthName($stamp) {
		if ($this->renderCompact) {
			return date($this->monthFormatCompact, $stamp);
		} else {
			return date($this->monthFormatFull, $stamp);
		}
	}


	/**
	 * return the month name and year in string format
	 */
	function displayDate() {
		return date('F Y', $this->table->tableModel->targetDate->timeStamp);
	}


	/**
	 * return the month name, day name, date, and year in string format
	 */
	function displayDateFull() {
		return date('l F jS, Y', $this->table->tableModel->targetDate->timeStamp);
	}


	/**
	 * print column headers
	 */
	function paintHeaders() {
		$this->html .= '<thead>';
		$this->html .= '<tr class="center_justify">';
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
			$this->html .= '<th width="14%" abbr="'.$colName.'" scope="col" title="'.$colName.'"';

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
	 * Print the days of the week along with any
	 * events that occur on a given day.
	 */
	function paintRows() {

		$numCols = $this->table->getColumnCount();
		$numRows = $this->table->getRowCount();
		$colModel = $this->table->getColumnModel();

		$this->html .= '<tbody>';
		//week view offset is the difference between the start of the month
		// and the window start
		// only use it if we're looking at a week that is not the first week in a month;
		if ($this->table->eventWindow == 'week' && $this->table->tableModel->startOfWeek->date > 1) {
			$this->weekViewOffset = (int)($this->table->tableModel->startOfWeek->date + $this->table->tableModel->firstOfMonth->dayOfWeek -2 );
			if ($this->weekViewOffset < 0 ) { $this->weekViewOffset = 0; }
			$this->table->tableModel->weekViewOffset = $this->weekViewOffset;
		}

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
				//logic to print dates only in the squares that make sense
				// not every month begins on a sunday and ends on a saturday
				$date = ($x*7) + $y - $this->table->tableModel->firstOfMonth->dayOfWeek +1;
				$date += $this->weekViewOffset;

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
				//weekday / weekend style
				if ($y > 0 && $y < 6) {
					$cellClass = 'cal_weekday';
					$cellClass .= ($x % 2 == 0) ? '_even':'_odd';
				} else {
					$cellClass = '';
				}

				$renderer = $this->table->getCellRenderer($x,$y);
				//prevent dates that span months from having highlighted
				// cells from the getCellCSS function by not preparing
				// the cell renderers with the number of dates on a given day.
				// Otherwise we will end up with highlighted days that 
				// are not part of this month (Ex. test starts on 31st, ends on 1st)
				//is this the first week?
				if ($x == 0 && $this->weekViewOffset < 1) {
					if ($y < $this->table->tableModel->firstOfMonth->dayOfWeek ) {
						//clear the value because in php5 all objects
						// are passed by reference, so the renderer value
						// will hold last week's value.
						$renderer->value = '';
					} else {
						$this->table->prepareRenderer($renderer,$x,$y);
					}
				} else {
					if ($date > $this->table->tableModel->daysInMonth) {
						//clear the value because in php5 all objects
						// are passed by reference, so the renderer value
						// will hold last week's value.
						$renderer->value = '';
					} else {
						$this->table->prepareRenderer($renderer,$x,$y);
					}
				}

				$css = $renderer->getCellCSS();
				if ( count ($css) > 0 ) {
					foreach ($css as $i=>$j) {
						$style .= "$i:$j;";
					}
				}

				if ($renderer->value > 0 ) {
					$cellClass = 'cal_event_day';
				}

				$this->html .= '<td';
				if ($width > -1) {
					$this->html .= ' width="'.$width.'"';
				}

				if ( strlen($justify) > 0 || strlen($cellClass) > 0) {
					$this->html .= ' class="'.$cellClass.' '.$justify.'"';
				}

				if ( strlen($style) > 0) {
					$this->html .= ' style="'.$style.'"';
				}
				$this->html .= '>';

/*
debug($y);
debug($this->table->firstDayOfWeek);
debug($date);
*/
				if ($date > 0 && $date <= $this->table->getDaysInMonth() ) {
					$this->html .='<a href="'.modurl('classCalendar/event=viewDay/m='.$this->table->tableModel->m.'/d='.$date.'/y='.$this->table->tableModel->y).'"><div style="width:100%;border:0px;padding:0px;margin:0px;">';
				}

				//is this the first week?
//				debug($this->table->tableModel->firstOfMonth,1 );
				if ($x == 0 && $this->weekViewOffset < 1) {
					if ($y < $this->table->tableModel->firstOfMonth->dayOfWeek ) {
						$this->html .= '';
						$value = '';
					} else {
						$this->html .= $date;
						//separate the date from the cell value
						$this->html .= '<br/>';
						$value = $renderer->getRenderedValue();
					}
				} else {
					if ($date > $this->table->tableModel->daysInMonth) {
						$this->html .= '';
						$value = '';
					} else {
						$this->html .= $date;
						//separate the date from the cell value
						$this->html .= '<br/>';
						$value = $renderer->getRenderedValue();
					}
				}

				if ( strlen($value) < 1) {
					$this->html .= '<br/>';
				}
				$this->html .= $value;
				$this->html .= '</div></a></td>';
			}

			$this->html .= '</tr>';
		}

		$this->html .= '</tbody>';

	}


	function getNameOfDay($y) {

		if ($this->renderCompact) {
			switch($y) {
				case 0:
					return 'Sun';
				case 1:
					return 'Mon';
				case 2:
					return 'Tue';
				case 3:
					return 'Wed';
				case 4:
					return 'Thu';
				case 5:
					return 'Fri';
				case 6:
					return 'Sat';
			}
		} else {
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
}



class LC_TableRenderer_DayCalendar extends LC_TableRenderer_Calendar {


	/**
	 * print column headers
	 */
	function paintHeaders() {
		$this->html .= '<thead>';
		$this->html .= '<tr class="center_justify">';
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
			$this->html .= '<th width="14%" abbr="'.$colName.'" scope="col" title="'.$colName.'"';

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
	 * Paint one row for each hour of the day.
	 */
	function paintRows() {

		$numCols = $this->table->getColumnCount();
		$numRows = $this->table->getRowCount();
		$colModel = $this->table->getColumnModel();

		$this->html .= '<tbody>';

		for ($x = 0; $x < 23; ++$x) {
			//paint the columns
			$class = ($x % 2 == 0) ? 'even':'odd';
			$this->html .= '<tr class="center_justify '.$class.'">';

			//first time through, just do time
			// then do events.
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
				$renderer->row = $x;
				$renderer->col = $y;
				if ($y==0 ) {
					$renderer->value = $x;
				} else {
					$renderer->value = $this->table->tableModel->getEventsAtHour( mktime($x+1, 0, 0, $this->table->tableModel->m, $this->table->tableModel->d, $this->table->tableModel->y ) );
				}

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
				$this->html .= '>';

				$value = $renderer->getRenderedValue();
				$this->html .= $value;
				$this->html .= '</td>';
			}

			$this->html .= '</tr>';
		}

		$this->html .= '</tbody>';
	}
}


class LC_TableCellRenderer_CalendarEventList extends LC_TableCellRenderer {

	var $targetDate;		//object that holds date information


	function LC_TableCellRenderer_CalendarEventList($target) {
		$this->targetDate = $target;
	}


	function getRenderedValue() {
		$now = time();
		$ret = '<ul>';
		foreach($this->value as $k=>$v) {
			$type = $this->getEventType($v);
			$ret .= '<li>'.$type.' ';

			//show a link if item is currently active
			if ( $v['startdate'] < $now && $v['enddate'] > $now ) {
				$v['title'] = $this->getEventLink($v);
			}


			$ret .=	$v['title'];
			if ( strlen($v['description']) ) {
				if ( strlen($v['description']) > 85 ) {
					$ret .= '<br/>'.substr($v['description'], 0, 83). '...';
				}
			}
			if ($v['enddate'] - $v['startdate'] < (60*60) ) {
				$ret .= '<br/>Event ends in one hour or less.';
			}
			$ret .='</li>';
		}
		$ret .= '</ul>';
		return $ret;
	}


	/**
	 * This should be part of a better events object
	 */
	function getEventType($evt) {
		//events should have their time and date separated at the DB level
		list($m,$d,$y) = explode(' ', date('m d Y',$evt['startdate']));
		$evtStart = mktime(0,0,0,$m,$d,$y);
		list($m,$d,$y) = explode(' ', date('m d Y',$evt['enddate']));
		$evtEnd = mktime(0,0,0,$m,$d,$y);

//		debug($evt);
		$evtType = strtolower($evt['calendarType']);
		switch( $evtType ) {
			case 'classroomassignments':
				$type = 'Assignment:';
				if ($evtStart == $this->targetDate->timeStamp) {
					$type = 'Assignment (Assigned):';
				} else if ($evtEnd == $this->targetDate->timeStamp) {
					$type = 'Assignment (Due):';
				}
				break;
			case 'assessmentscheduling':
				$type = 'Assessment:';
				if ($evtStart == $this->targetDate->timeStamp) {
					$type = 'Assessment (Assigned):';
				} else if ($evtEnd == $this->targetDate->timeStamp) {
					$type = 'Assessment (Due):';
				}
				break;
			default:
				$type = '';
				break;
		}
		return $type;
	}	


	/**
	 * This should be part of a better events object
	 */
	function getEventLink($evt) {
		switch( $evt['calendarType'] ) {
			case 'classroomAssignments':
				$link = '<a href="'.appurl('classroom/assignments/event=view/id='.$evt['id_item']).'">'.$evt['title'].'</a>';
				break;
			case 'assessmentscheduling':
				$link = '<a href="'.appurl('classroom/assessments/').'">'.$evt['title'].'</a>';
				break;
			default:
				$link = $evt['title'];
				break;
		}
		return $link;
	}	

}


class LC_TableCellRenderer_CalendarTime extends LC_TableCellRenderer {

	function getRenderedValue() {
		if ($this->value == 0 ) {
			return '12:00 AM';
		}
		if ($this->value == 24 ) {
			return '12:00 AM';
		}
		if ($this->value < 12 ) {
			return $this->value  . ':00 AM';
		}
		if ($this->value > 12 ) {
			return $this->value -11 . ':00 PM';
		}
		return $this->value . ':00 PM';
	}
}



class LC_TableCellRenderer_CalendarDate extends LC_TableCellRenderer {


	/**
	 * Return an array of key value pairs for this cell
	 */
	function getCellCSS() {
		return array();
		//mark days with events as a different color
		if ($this->value > 0 ) { 
			return array('class'=>'cal_event_day');
		}
		if ($this->col > 0 && $this->col < 6) {
			if ($this->row % 2) {
				return array('class'=>'cal_weekday_odd');
			} else {
				return array('class'=>'cal_weekday_even');
			}
		} else {
			return array();
		}
		//return array('background-color'=>'green');
	}


	/**
	 * Return 'X events' plus a link to the calendar day view
	 */
	function getRenderedValue() {
		if ($this->value > 0 ) {
			return $this->value.' events</div>';
		} else { 
			return '';
		}
	}
}



/**
 * Hold different views of a single day in memory
 */
class LC_Calendar_DateInfo {

	var $dayOfWeek = 0;
	var $date = 0;
	var $year = 0;
	var $month = 0;
	var $weekOfMonth = 0;
	var $timeStamp;


	function LC_Calendar_DateInfo($ts) { 

		$this->timeStamp = $ts;
		list($this->dayOfWeek,
			$this->year,
			$this->date,
			$this->month)  = explode(' ' , date('w Y d m',$ts));
	}

}
?>
