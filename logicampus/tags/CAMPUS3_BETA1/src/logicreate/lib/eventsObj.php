<?
// MGK 10/25/2002
// changes to flow
// all events will be shared with no one until approved by an administrator
// admins will get emails


//include_once(LIB_PATH."calendar.php");
//include_once(LIB_PATH."LC_html.php");

		
		
		



class edate extends PersistantObject {

//	var $date = null;		//EventDate object
//	var $description = null;	//text

	function _load($id) {
		
		if (is_array($id))
		{
			$x = PersistantObject::createFromArray('edate', $id);
			$x->groups = explode("|",substr($x->groups,1,-1));
			
		} else
		{
			$x = PersistantObject::_load("edate","lcEvents",$id);
			$x->groups = explode("|",substr($x->groups,1,-1));
		}
		
	return $x;
	}
	
	function load($id) {
		$x = PersistantObject::_load("edate","lcEvents",$id);
		$x->groups = explode("|",substr($x->groups,1,-1));
		return $x;
	}

	function delete($id) {
		PersistantObject::_delete("lcEvents",$id);
	}


	function update() {
		if (is_array($this->groups) ) {
			$this->groups = '|'.join('|',$this->groups).'|';
		}
		if (is_array($this->notgroups) ) {
			$this->notgroups = '|'.join('|',$this->notgroups).'|';
		}
		if (is_array($this->repeatData)) {
			$this->repeatData = $this->repeatData['when']."|".$this->repeatData['day'];
		}
		return $this->_save("lcEvents");
	}

	var $pkey;
	var $calendarID;
	var $location;
	var $title;
	var $username;
	var $groups;
	var $notgroups;
	var $description;
	var $repeatUntil;		// not worked out yet... ??
	var $repeatExclude;
	var $repeatData;
	var $repeatCount;
	var $repeatType;

	
	/**
	 *  + allday flag
	 *	semester dropdate
	 *	class assignment (class_id, duedate, item_id)
	 *	class lessons	(class_id, activedate, showwhenactive)
	 *	class general event (class_id, date, item_id)
	 *	semester (start/end) (semester_id)
	 *
	 */
	
	function autoLoad(&$object)
	{
		
		foreach($object as $k=>$v)
		{	$this->{$k} = $v;
		}
		
		// making sure there's an object and some variables, i should extend it to look for key bits of data
		// such as enddate startdate .. things that MUST be in
		if (is_object($object))
		{	return true;
		}
		
	}
	
	
	/**
	 *	Becuase we're using persistant object, that damn thing RELIES on class variables
	 *	so i can not impliment my own.. sigh! so i'm stuck using static
	 *
	 *	$param 	$__set						boolean		
	 *	@return								boolean
	 */
	function hasErrors($__set = '')
	{
		static $haserrors;
		
		// if sent.. lets set our static var
		if (is_boolean($__set))			
			$haserrors = $__set;
			
	return (boolean)$haserrors;
	}
	
/*
repeat types
1 = repeat every X days
2 = repeat every X week(s) on specified days
     Sun Mon Tue etc
3 = Repeat every X week(s) on same days *
4 = Repeat every X month(s) on same date
5 = Repeat every X month(s) on same weekdays *
6 = Repeat every X years on same date
7 = Repeat every (first|sec|third|fourth|last)  (tue/wed/thur) every X months
*/

/*
 methods needed

 getEvents($start, $end)
 need to return a list of event Objects which fall within that range
 need to check that start or end date is between the range,
 or check anything with no end date (infinite repeating)
*/


	function edate($date='') {
//		$this->date = strtotime($date);
	}

	function renderEvent() {

	}


// repeating types
// setNoRepeat 			0
// setRepeatXDays		1
// set RepeatXWeeks		2
// setRepeatXMonths		4
// setRepeatXYears		6
// setRepeatXDayMonth	7

	function setNoRepeat() {
		$this->repeatType = 0;
		$this->repeatData = '';
		$this->repeatCount = 0;
	}

	function setRepeatXDays($interval=1) {
		if ($interval == 0) { $interval = 1; }
		$this->repeatType = 1;
		$this->repeatData = '';
		$this->repeatCount = $interval;
	}

	function setRepeatXWeeks($interval=1, $dayBits=0) {
		if ($interval == 0) { $interval = 1; }
		$this->repeatType = 2;
		$this->repeatData = $dayBits;
		$this->repeatCount = $interval;
	}

	function setRepeatXMonths($interval=1) {
		if ($interval == 0) { $interval = 1; }
		$this->repeatType = 4;
		$this->repeatData = '';
		$this->repeatCount = $interval;
	}
	function setRepeatXYears($interval=1) {
		if ($interval == 0) { $interval = 1; }
		$this->repeatType = 6;
		$this->repeatData = '';
		$this->repeatCount = $interval;
	}
	function setRepeatXDayMonth($monthInterval=1, $dayBits=0, $dayInterval='') {
// dayBits= 1,2,4,8,16,32,64
// dayInterval = 1,2,3,4,5 (first, second, third, fourth, last)
// monthInterval (1, 2, 3, etc)
		if ($monthInterval == 0) { $monthInterval = 1; }
		$this->repeatType = 7;
		$this->repeatData = "$dayInterval|$dayBits";
		$this->repeatCount = $monthInterval;
	}

	// @@@@ what is this? 
	function eventIntoToHTML() {
		ob_start();
		include(SERVICE_PATH."/evt/templates/eventTemplate.html");
		$x = ob_get_contents();
		ob_end_clean();
		return $x;
	}


	function getEvents($start, $end, $type='', $id_classes=0, $use_groups=false) 
	{	
		/**
		 * 	I am overriding the default behavior and globalizing the lcUser obj to get groups
		 *	Becuase i want them to apply to everything, normally
		 *	I would just pass these in.
		 *	
		 	Ok i'm reverting this change becuase I don't like it but i'll keep it incase
		 	You plan on applying it globally for something
		 
		global $lcUser;
		$use_groups = $lcUser->groups;
		
		 *
		 */
		 
		$edateObj = new edate();
		
		if (strtotime($start)>0) 
		{	$start = strtotime($start); $end = strtotime($end);
		}
		
		$sql_group = '';
		
		// @@@@ I need to be aware of the non-standard use of PUB and PUBLIC in groups
		/**
		 *	Note: Be aware that use_groups applies only to id_classes=0 
		 *		  (the general events, other events are applied to classes
		 */
		if ($use_groups)
		{	if (is_array($use_groups) && count($use_groups) > 0)
			{	
				$use_groups = array_unique($use_groups);	// removing the DUPLICATES!!!
				
				foreach($use_groups as $group)
				{	if (strlen(trim($group)) > 0)
					{	$sql_group .= 'groups like \'%|'.$group.'|%\' or ';
					}
				}
				
				$sql_group = ' AND ('.trim(substr($sql_group, 0, (strlen($sql_group)-3))).')';
			}
		} else
		{	// no groups. incase you want to do something if no groups were passed in, here's your chance big shot!
		}
		
		$sql_type = '';
		if ($type)
		{	$sql_type = 'AND calendarType=\''.$type.'\'';
		}
		
		$db = DB::getHandle();
		// static data - not repeating data
		// and repeating data, combined into one list
		// $data = $this->getSampleData(CONTENT_PATH."/samplecal.txt");
		// while(list($k,$v) = each($data)) {
		// checks in the SQL to do
		// is ''repeatType" == 0?  If so, do date comparisons
		// if repeatType>0 then do partial date comparisons
		// id_classes = 0 means anything SITEWIDE
		/**
		 * the four or clauses
		 * repeating with no end
		 * some event ends inside the viewing window of time
		 * some event starts inside the viewing window of time
		 * some event starts before and ends after the viewing window of time (spans window)
		 */
		$sql ='
		SELECT * 
		FROM lcEvents 
		WHERE ('.((is_array($id_classes)) ? ((count($id_classes) > 0) ? 'id_classes='.implode($id_classes, ' or id_classes=').' or ' : '') : (((string)$id_classes == '*') ? '' : 'id_classes='.$id_classes.' or ')).'('.(((string)$id_classes == '*') ? 'id_classes > 0' : 'id_classes=0').$sql_group.')) 
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
		ORDER BY calendarType ASC
		';
		
		$db->query($sql);
		$db->RESULT_TYPE = MYSQL_ASSOC;

		while($db->nextRecord()) {
			extract($db->record);
			$exclude = explode("|",$repeatExclude);
			$eventPkey =$pkey;
			
			/**	Building up the exclude array, as more dates get reviewed more
			 *	excludes become available and we need to account for them all
			 */
			while(list($q,$w) = each($exclude)) {
				
				if (strlen(trim($w)) == 0)
				{	continue;
				}
				
				$newExclude[] = date("n/d/Y",strtotime($w));
			}
			
			$exclude = $newExclude; // we must do this because $exclude gets clobered above
			
			$eventStart = strtotime($startdate);
			$eventEnd = strtotime($enddate);
			if ($eventStart<1) { $eventStart = $startdate; }
			if ($eventEnd<1) { $eventEnd= $enddate; }
// __FIXME__ zero to midnight - timezone issue?
//			$eventStart = $eventStart - ($eventStart %86400);
//			$repeatUntil = strtotime($repeatUntil);

//echo "<pre>"; print_r($edateObj->events); echo "<HR><HR><HR>";
			switch($repeatType) {

// do not repeat
// single event
				case "0":
					$loopVar = strtotime(date("m/d/Y 00:00:00",$eventStart));
					$edateObj->events[$loopVar][$eventPkey] = edate::_load($db->record);
					$loopEnd = strtotime(date("m/d/Y 00:00:00",$eventEnd));
					$edateObj->events[$loopEnd][$eventPkey] = edate::_load($db->record);
				break;

// repeat every X days
				case "1":
				$loopStart = strtotime(date("m/d/Y 00:00:00", $eventStart));
				$loopVar = $loopStart;
				$loopEnd = $end;
				
				// trying to cut down on cycles (start from beigning of suggested start time
				if ($eventStart<=$start) {
					$loopStart = $start;
					$loopVar = $loopStart;
				}				
				
				while($loopVar<=$loopEnd) 
				{
					
					// Envoking repeat until property checking
					if ($repeatUntil != -1 && $repeatUntil < $loopVar)
					{	break;
					}
					
					if (is_array($exclude) == false || (is_array($exclude) && in_array(date("n/d/Y",$loopVar), $exclude) == false))  
					{	$edateObj->events[$loopVar][$eventPkey] = edate::_load($db->record);
					}

					$loopVar = strtotime('+'.$repeatCount.' days', $loopVar);  // repeat every X days
				}
				
				break;

// repeat every week on X days
// days = 0= sunday, 1 = monday, 2=tuesday, etc
// bitwise checking
				case "2":
				
				// $end = Last day of viewable days/time
				
				/**	Setting default repeat data (needed when you don't pick anything 
				 *	(sun mon tues...) defaults to start days weekdayname
				 */
				if ($repeatData == '')
				{	$repeatData = $j = pow(2,date("w",$eventStart));
				}
							
					
				/** Setting start date to start checking the repeating sequence
				 */
				$loopStart = strtotime(date("m/d/Y 00:00:00", $eventStart));
				$loopVar = $loopStart;
				$loopEnd = $end;
				
				/** Setting start to be the very begining of our VIEWABLE realestate 
				 *	for some reason the start day is in the past
				 *
				 *	If i comment the below block out, it works fine, however, it's invalid calculations
				 */
				if ($eventStart<=$start) {
					$loopStart = $start;
					$loopVar = $loopStart;
					
				}
				
				// echo $loopVar;
				/**	We will loop from start of viewable time to end of viewable time (dates/days)
				 */
				
				while($loopVar<=$loopEnd) {
			
					// Envoking repeat until property checking
					if ($repeatUntil != -1 && $repeatUntil <= $loopVar)
					{	//echo date('y-m-d h:i a', $repeatUntil). '|'. date('y-m-d h:i a', $loopVar).'<br>';
						break;
					}
					
					$curWeek = date("W",$loopVar);
					
					// I think these are to match up (day wise)
					$j = pow(2,date("w",$loopVar));
					
					if ($j & $repeatData)  
					{	
						if (is_array($exclude) == false) 
						{	$edateObj->events[$loopVar][$eventPkey] =edate::_load($db->record);
						} else 
						{
							reset($exclude);
							if (in_array(date("n/d/Y",$loopVar), $exclude) == false)  
							{	$edateObj->events[$loopVar][$eventPkey] =edate::_load($db->record);;
							} 
							
						}
						
					}
					
					$loopVar = strtotime('+ 1 days', $loopVar);
					//$loopVar = $loopVar + (86400);  // increment by one day @@@ NOT reliable..
					$newWeek = date("W",$loopVar);
					if (intval($curWeek) !=intval($newWeek) ) { // we've incremented a week
											// so let's see if we are to do X weeks
											// or just one week
						if ($repeatCount>1) {
							$count = $repeatCount-1;
							$loopVar = strtotime("+$count weeks",$loopVar);
						}
					}
					
				}
				break;

// 4 = Repeat every X month(s) on same date
// 5/25/2003 = 6/25/2003
// given start and end, determine if another 'original date'
// occurs within the range
//
// examples
// repeatinfo = eventStart = 4/25/2003, repeating every 2 months
// range 5/20/2003 through 9/30/2003
// event occurs on 6/25/2003, 8/25/2003
// returns the pkey of the event
//
// repeatinfo = eventStart = 4/25/2003, repeating every 2 months
// range 6/26/2003 through 8/15/2003
// event does not repeat in that time range
//

				case "4":
//				break;
				$loopStart = strtotime(date("m/d/Y 00:00:00", $start));
				$loopVar = $loopStart;
				$loopEnd = $end;
				if  ( ($repeatUntil < $end) && ($repeatUntil>0) ) {
					$loopEnd = $repeatUntil;
				}

				$origDate = intval(date("d",$eventStart));

				while($loopVar<=$loopEnd) {
//					if ($loopVar<$eventStart) { continue; }
					$thisMonth = intval(date("m",$loopVar));
					$thisYear = date("Y",$loopVar);
					$thisDate = $origDate;
					$nextYear = $thisYear;
					$nextMonth = $thisMonth;
					$nexttime = strtotime("$nextMonth/$thisDate/$nextYear");
					if ( ($nexttime>=$loopVar) && ($nexttime<=$loopEnd)) {
						if (!in_array(date("m/d/Y",$loopVar), $exclude))  {
							$edateObj->events[$loopVar][$eventPkey] = edate::_load($db->record);
						}
					}
					$nextMonth = $thisMonth+$repeatData;
					if ($nextMonth>12) {
						$years = ($nextMonth-12) %12;
						$nextMonth = $nextMonth-12;
						$nextYear = $thisYear + 1;
						$nextYear += intval($years);
					}
					$loopVar = strtotime("$nextMonth/$thisDate/$nextYear");
				}
				break;

// like case 4, but increments years, not months
				case "6":
//				break;
				$loopVar = $start;
				$loopEnd = $end;
				if  ( ($repeatUntil < $end) && ($repeatUntil>0) ) {
					$loopEnd = $repeatUntil;
				}

				$origDate = intval(date("d",$eventStart));

				while($loopVar<=$loopEnd) {
					$thisMonth = intval(date("m",$loopVar));
					$thisYear = date("Y",$loopVar);
					$thisDate = $origDate;
					$nextYear = $thisYear;
					$nextMonth = $thisMonth;
					$nexttime = strtotime("$nextMonth/$thisDate/$nextYear");
					if ( ($nexttime>=$loopVar) && ($nexttime<=$loopEnd)) {
						if (!in_array(date("m/d/Y",$loopVar), $exclude))  {
							$edateObj->events[$loopVar][$eventPkey] = edate::_load($db->record);
						}
					}
					$nextYear = $thisYear+$repeatData;
					$loopVar = strtotime("$nextMonth/$thisDate/$nextYear");
				}
				break;


// option 7
// example
// 'second thursday of every other month'
// or
// 'last Friday of every month'
//
// $repeatData is a string of when|day (first|thurs or last|friday, etc)
// day will be bitwise (1, 2, 4, 8, 16, 32, 64)
// $repeatCount is the number of months (every X months - 1, 2, 3, etc)
//

				case "7":
//				break;
				$j = $repeatData;
				list($when, $day)  = split("\|",$j);
				$loopVar = $eventStart;
				$loopEnd = $end;
// not ready yet?
				if  ( ($repeatUntil < $end) && ($repeatUntil>0) ) {
					$loopEnd = $repeatUntil;

				}
				if ($eventStart<=$start) {
					$loopStart = $start;
					$loopVar = $loopStart;
				}

$whenText = array(1=>"first",2=>"second",3=>"third",4=>"fourth",5=>"last");
$dayText = array(1=>'Sunday', 2=>'Monday', 4=>'Tuesday', 8=>'Wednesday', 16=>'Thursday', 32=>'Friday', 64=>'Saturday');

// set up intial loopVar more explicitly
// maybe later? forgot why...


				while($loopVar<=$loopEnd) {
					$j = pow(2,date("w",$loopVar));
					if ( $j  & $day)  {
						if (!is_array($exclude)) {
							$edateObj->events[$loopVar][$eventPkey] = edate::_load($db->record);
						}
						if (!in_array(date("n/d/Y",$loopVar), $exclude))  {
							$edateObj->events[$loopVar][$eventPkey] = edate::_load($db->record);
						}
//print_r($this->events[$loopVar]); echo "<HR>";
					}

					// get month
					$thismonth = date("n",$loopVar);
					$thisyear = date("Y",$loopVar);
					$firstofmonth = strtotime("$thismonth/1/$thisyear");
					$whichday = $day;
					// $when represents what occurance - first, second, third, fourth or last (1,2,3,4,5)

					$newVar = $loopVar;
					if ($when<>5) {
						$newVar= strtotime($whenText[$when]." ".$dayText[$day],$firstofmonth);
					} else {
						$newVar = strtotime($whenText[$when]." ".$dayText[$day],strtotime("+1 	month",$firstofmonth));
					}
					if ($newVar<=$loopVar) {
						$newVar = strtotime("+1 month",$newVar);
						$thismonth = date("n",$newVar);
						$thisyear = date("Y",$newVar);
						$firstofmonth = strtotime("$thismonth/1/$thisyear");
						$whichday = $day;
						$newVar = $loopVar;
						if ($when<>5) {
							$newVar= strtotime($whenText[$when]." ".$dayText[$day],$firstofmonth);
						} else {
							$newVar = strtotime($whenText[$when]." ".$dayText[$day],strtotime("+1 	month",$firstofmonth));
						}
					}
					$loopVar = $newVar;

				}
				break;
			}
		}
		while(list($k,$v) = @each($edateObj->events)) {
			$new[$k] = $v;
		}
		return $new;
	}
}


class cali {

	var $calenderID;
	var $events;
	var $showTimes = true;
	var $showTitle = true;
	var $showDescription = true;			// show event description?
	var $titleLength = 10;					// event title  max length in view
	var $showEventCount = false;			// show the # of events in  day?
	var $showDate = true;					// show the individual days in a month view
	var $calWidth = 300;					// width of calendar
	var $monthHeaderFormat = "F Y";		// passed to date() function in month header
	var $monthHeader1 = 'row1';				// CSS header #1
	var $monthHeader2 = 'row2';				// CSS header #2 ???
	var $monthReviewURL = 'evt/main/';		// re-view the current URL with new date params
	var $eventKeyURL = 'act/view/';			// url for each distinct event listed in a day - will take event pkey at very end
	var $eventDayURL = 'evt/main/event=viewDay';				// url to use for the 'day of month' number
	var $eventCountURL = 'evt/main/event=viewDay';			// url to use for the '# of events' in a day
	var $eventSeparator = "<BR>\n";			// separator between events
	var $monthDateSeparator = "<BR>\n";		// separator to use after 'date' (1, 6, 28, etc) in month
	var $monthWeekCSS =array('row1','row2');		// css to cycle through each week
	var $dayArray = array("Sun","Mon","Tues","Wed","Thur","Fri","Sat");
	var $monthLinkToZero = false;		// create a link to a day when 0 events are in day?
	var $monthTodayCSS='';			// css to use when rendering 'today' in a month or year view
	var $monthDisplayZeroEvents = false;		// show 0 in day events if no events
	var $START_HOUR = '00:00:00';
	var $END_HOUR = '23:45:00';
	var $monthTableClass2 = 'monthtitletable';
	
	var $noNextPrev = false;
	var $linkMonthName = false;
	
	var $fl_no_link_numerical_day_event = false;
	
	/**
	 *	@param	$id_classes  int [EXCEPTION: you may pass in * which means, ANY class, but NOT classes==0]
	 */
	function cali($start, $end, $type='', $id_classes=0, $a_groups=array()) 
	{
		$this->calendarID 	= $id;
		$this->start 		= $start;
		$this->end 			= $end;
		
		// Are we applying groups to the events?
		if (is_array($a_groups) && count($a_groups) > 0)
		{	$use_groups = $a_groups;
		} else
		{	$use_groups = array(); // blank it
		}
		
		$this->events 			= edate::getEvents($start,$end,$type, $id_classes, $use_groups);
		$this->monthReviewURL 	= appurl($this->monthReviewURL);
		$this->eventDayURL 		= appurl($this->eventDayURL);
		$this->eventCountURL 	= appurl($this->eventCountURL);
	
	}

	
	function getMonthWeekCSS(&$event) {
		$thisWeekCSS = $this->monthWeekCSS[$cssWeekLoop];
		$cssWeekLoop++;
		if ($cssWeekLoop>count($this->monthWeekCSS)) {
			$cssWeekLoop=1;
		}
		return " class='$thisWeekCSS'";
	}
	
	function getMonthDayCSS($timestamp) 
	{
		if (count($this->events[$timestamp]) >0) 
		{	
			$hasEvent = false;
			// lets iterate through events to see if they start/end on a given date
			// i'm going to modify this to check to see if the start/enddate is within this date
			foreach($this->events[$timestamp] as $k=>$individual_event)
			{
				if (trim($individual_event->calendarType) != '')
				{
					if (class_exists($individual_event->calendarType))	// making sure class exists before initializing
					{
						$tmp = new $individual_event->calendarType;
						if ($tmp->autoLoad($individual_event) && $tmp->cansee($timestamp) == true)
						{	
							$hasEvent = true;
						}
						
					} 
					
					if ($hasEvent)
					{	break;
					}
					
				} else
				{
					
					$hasEvent = true;
					
					/*
					@ I'm not doing this becuase we the extra event stuff (repeatable stuff) won't match the following clause
					@ so for now i'm disabling this, hoping no adverse effects happen.
					if (($individual_event->startdate >= $timestamp && $individual_event->startdate < ($timestamp+86400))
						|| ($individual_event->enddate >= $timestamp && $individual_event->enddate < ($timestamp+86400)))
					{
						$hasEvent = true;
					}
					*/
				}

			}
			
			if ($hasEvent)
			{	return ' class="calHasEvent"'; 
			} else
			{	return ' class="monthCall"';
			}
			
		} else 
		{	
			return ' class="monthCall"';
		}
		
	}

	
	function renderDayFull() {
		
		$allday_events = array();

		$events = array();
		while(list($ekey,$e) = @each($this->events)) {
			$events = array_merge($events,$e);
		}

		list($m,$d,$y) = split(" ",date("m d Y",$this->start));
		$startTime = strtotime("$m/$d/$y ".$this->START_HOUR);
		$endTime = strtotime("$m/$d/$y ".$this->END_HOUR);
		$interval = 1800;	// 30 minute intervals to show
		$interval = 300;
		$miniinterval = 900; // 15 minute intervals..
		$miniinterval = 300; // 5 minute intervals..
		while(list($k,$v) = @each($events)) {
			$e[$v->startdate][$v->pkey] = $v;
		}

		$events = $e;
		unset($e);
		$loopTime = $startTime;

		while($loopTime < $endTime ) {
			$row .= date("h:i A",$loopTime). " -   ";
			$tempcount =0;
			$loopcount = intval($interval/$miniinterval);
			$inside = '';

			// @@ this area scares me.. 
			while($tempcount < $loopcount) {
				$rowString = date("h:i A",$loopTime);
				if (is_array($events)) {
					reset($events);

					while(list($tkey,$tval) = each($events)) {
						while(list($key,$val) = each($tval)) {

							$thisString = date("h:i A",$val->startdate);
							// is it just an ordinary calendar type? (world viewable) or specialized ? '' = world
							if (trim($val->calendarType) != '') {
								$classname = $val->calendarType;
								// customized
								if (class_exists($classname)){	// making sure class exists before initializing
									$tmp = new $val->calendarType;
									//__FIXME__ why don't any of these work?
									if ($tmp->autoLoad($val) && $tmp->cansee($loopTime, true))
									{
										if ($tmp->f_allday) {
											$allday_events[] = $tmp->get_brief_display($loopTime);
											
										} else {
											$inside .= $tmp->get_brief_display($loopTime).'<br>';
										}
										
										// prevention from reiterating overandoverandover
										unset($events[$tkey][$key]);
									}
								}
							} else {
								// basic shiz
								if ($rowString == $thisString) {
									$tstring ='';
									
									$realTime = date("h:i A",$val->startdate);
									$tstring = $val->title."<BR>".$val->description;
									if ($realTime != $thisString) {
										$tstring .= " ($realTime)";
									}
									if ($tstring) {
									
										if (($val->enddate - $val->startdate) >= 82800 || $val->f_allday)
										{	// this is an all day 
											// altho it's going outside my plan of using f_allday which the objects use.. i dunno
											// i may impliment the flag of allday for the normal events (non classes) until now
											// if someone sets there event to start at 12am-11pm (23 or more hours diff) it's pushed into an all day event
											// i've added the f_allday flag to the if statement.. so it's future proof once i impliment
											// it into the event editor
											$allday_events[] = '<b>'.$val->title."</b><BR>".$val->description;
										} else 
										{
											$inside .= $tstring."<HR>";
										}
										
									}
								}
							
							}
						}
					}
				}
				++$tempcount;
				$loopTime += $miniinterval;
			}
				$prevTime = $loopTime - ($miniinterval * $loopcount);
				
				if ($inside) {
					$trow[$prevTime] .= '<b>'. date("g:i A", $prevTime).'</b><ul>'.$inside. '</ul>';
				}
					
				$inside='';

		}

		/** old way.. with the times listed 8 830 9 930...
		
		if (count($allday_events) > 0)
		{	$st_allday = '<tr><td class="todayseventstitle" colspan="2"><B>TODAY\'S ITEMS<b></td></tr>';
			$st_allday .= '<tr><td class="todaysevents" colspan="2">'.implode($allday_events, '<br>'). '</td></tr>';
		}
		
		while(list($k,$v) = each($trow)) {
			$h .= "<tr><td valign=\"top\" width=\"10%\"><nobr>".date("h:i A", $k)."</nobr></td><td valign=\"top\">$v</td></tr>";
		}
		
		*/
		if (count($allday_events) > 0)
		{	//$st_allday = '<tr><td removedclass="todayseventstitle"><B>TODAY\'S ITEMS<b></td></tr>';
			$st_allday = '';
			$st_allday .= '<tr><td removedclass="todaysevents"><B>TODAY\'S EVENTS<b><br><ul>'.implode($allday_events, '<br>'). '</ul></td></tr>';
			$st_allday .= '<tr><td>&nbsp;</td></tr>';
		}
		
		while(list($k,$v) = each($trow)) {
			$h .= "<tr><td valign=\"top\">$v&nbsp;</td></tr>";
		}
		
		return "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">$st_allday $h</table>";
	}

	function renderDay($timestamp,$style=1) {
// style 1 = small
// style 2 = large
		$this->display_style_for_this_friggin_day = true;
		$events = $this->events[$timestamp];

		$month = date("n",$timestamp);
		$day = date("j",$timestamp);
		$year = date("Y",$timestamp);

		$c = count($events);
		if (is_array($events)) {
		foreach($events as $null=>$event)
		{	// doublechecking classbased events
			if (trim($event->calendarType) != '')
			{
				// customized

				$classname = $event->calendarType;
				if (class_exists($classname))	// making sure class exists before initializing
				{
					$tmp = new $event->calendarType;
					if ($tmp->autoLoad($event) && $tmp->cansee($timestamp) == false)
					{
						$c--;
					}
				}
			}
		}
		}

		if ($style==1) {
			
			if ($this->showEventCount) {
				
				if (($this->eventCountURL)  && ( $c>0 || $this->monthLinkToZero) ) 
				{
					/**
					 *	The reason I have display_style_for.... in an else block
					 *	is beuase i'm assuming everything is alright above.. if we're here
					 *	
					 */

					if ($c)
					{	$temp .= "<a href='{$this->eventCountURL}/m=$month/d=$day/y=$year'>$c events</a>".$this->eventSeparator;
					} else
					{	$this->display_style_for_this_friggin_day = false;
					}

				} else {
					if ($c==0 && $this->monthDisplayZeroEvents) {
						$temp .= $c.$this->eventSeparator;
					}
				}
			}

			@reset($events);
			while(list($k,$v) = @each($events)) {
				$output = '';
				if ($this->showTimes) {
					$output .= date("h:i A",$v->startdate);
				}
				if ($this->showTimes && $this->showTitle) {
					$output .= " - ";
				}
				if ($this->showTitle) {
					// include the OBJECT (if $v->calendarType is not = to '' then we have an object event)
					$output .= substr($v->title,0,$this->titleLength).$this->eventSeparator;
				}
				if ($this->eventKeyURL) {
					$temp .= "<a href='{$this->eventKeyURL}{$v->pkey}/m=$month/d=$day/y=$year'>$output</a>";
				} else {
					$temp .= $output;
				}
			}
		}


		if ($this->showDate) 
		{
			if ($this->eventDayURL) 
			{
				if ((int)$c == 0)
				{	$temp = date("j",$timestamp).$this->monthDateSeparator. $temp;
				} else 
				{	
					if ($this->fl_no_link_numerical_day_event == true)
					{	$temp = date("j",$timestamp).$this->monthDateSeparator. '<div align="right">'.$temp. '&nbsp;</div>';
					} else
					{	$temp = "<a href='{$this->eventDayURL}/m=$month/d=$day/y=$year'>".date("j",$timestamp)."</a>".$this->monthDateSeparator. '<div align="right">'.$temp. '&nbsp;</div>';
					}
					
				}

			}

			if ($c == false)
			{	$this->display_style_for_this_friggin_day = false;
			}

		}

	return $temp;
	}

	
	function renderMonthHeader($month, $year)
	{
		$prevYear = $year;
		$prevMonth = $month;
		$nextYear = $year;
		$nextMonth = $month;
		++$nextMonth;
		if ($nextMonth==13) {
			$nextMonth = 1;
			++$nextYear;
		}
		--$prevMonth;
		if ($prevMonth==0) {
			$prevMonth = 12;
			--$prevYear;
		}

		$temp = "<tr class='{$this->monthHeader1}'>";
		
		if ($this->noNextPrev == false)
		{	$temp .= "<td id=\"prevnext\" width=\"8%\"><a href='{$this->monthReviewURL}/m=$month/y=".($year-1)."'><img src=\"".IMAGES_URL."prevprev.gif\" border=\"0\"></a></td>";
			$temp .= "<td id=\"prevnext\" width=\"8%\"><a href='{$this->monthReviewURL}/m=$prevMonth/y=$prevYear'><img src=\"".IMAGES_URL."prev.gif\" border=\"0\"></a></td>";
		}
		
		if ($this->linkMonthName)
		{	$temp .= "<td id=\"month\" align=\"center\"><a href=\"".$this->monthReviewURL."/m=$month/y=$nextYear\">".date($this->monthHeaderFormat, strtotime("$month/1/$year"))."</a></td>";
		} else
		{	$temp .= "<td id=\"month\" align=\"center\">".date($this->monthHeaderFormat, strtotime("$month/1/$year"))."</td>";
		}
		
		if ($this->noNextPrev == false)
		{	$temp .= "<td id=\"prevnext\" width=\"8%\" align=\"center\"><a href='{$this->monthReviewURL}/m=$nextMonth/y=$nextYear'><img src=\"".IMAGES_URL."next.gif\" border=\"0\"></a></td>";
			$temp .= "<td id=\"prevnext\" width=\"8%\" align=\"center\"><a href='{$this->monthReviewURL}/m=$month/y=".($year+1)."'><img src=\"".IMAGES_URL."nextnext.gif\" border=\"0\"></a></td>";
		}
		
		$temp .= "</tr>\n";
		
		return "<table border=\"0\" cellpadding=\"2\" cellspacing=\"1\" width='{$this->calWidth}' class='{$this->monthTableClass2}'>$temp</table>";
		
 }


 	/**
 	 *	Render a weekly view
 	 *	
 	 *	@param $week_number			numeric			Numerical representation of the week in question within the year (1-52)
 	 *	@param $year				numeric			The year this week falls into
 	 *	@return 					string			html representation of the week view
 	 */
	function renderWeekView($week_number=0, $year=0)
	{
		/**
		 *	@notes: 
		 */
		 
		// setting defaults up
		if ($week_number == false)
		{	$week_number = date('W', $this->start);	// current week number
		}
		if ($year == false)
		{	$year = date('Y', $this->start); 		// current year
		}
		
		$rendered_html  = $this->renderDaysOfWeek();
		$rendered_html .= '<tr>';
		
		$start_day_position = date('w', $this->start);
		for ($i=$start_day_position; $i <= 6; ++$i)
		{
			$epoch_cycled_date = strtotime("+".(date('w', $this->start)+$i)." days",$this->start);

			$style_day = $this->getMonthDayCSS($epoch_cycled_date);

			$ret_rendered_day = $this->renderDay($epoch_cycled_date);
			if ($ret_rendered_day) 
			{	$tmp_render = $ret_rendered_day;
			} else 
			{	$tmp_render = "&nbsp;";
			}

			// this is set within renderDay()
			if ($this->display_style_for_this_friggin_day == false)
			{	
				if ($tmp_render)
				{	
					if ($i == 0 || $i == 6)
					{	// this is a weekend and we can change the class here
						$rendered_html .= "\t\t<td valign='top' width=\"14%\" class=\"weekendDay\">";
						
					} else
					{	$rendered_html .= "\t\t<td valign='top' width=\"14%\" class=\"monthCall\">";
					}
					
				} else
				{	$rendered_html .= "\t\t<td valign='top' width=\"14%\" class=\"noDay\">";
				}
				
			} else
			{
				$rendered_html .= "\t\t<td width=\"14%\" valign='top'$style_day>";
			}
			
			$rendered_html .= $tmp_render;
			$rendered_html .= "<br></td>\n";
				
		}
		
		$rendered_html .= '</tr>';
		
	return $rendered_html;
	}
	
	
	function renderMonth($month='', $year='') {
		
		if ($month=='') { $month=date("n"); }
		if ($year=='') { $year=date("Y"); }
		$daysInMonth = date("t",strtotime("$month/1/$year"));
		$firstDayOfMonth = date("w",strtotime("$month/1/$year"));
		$inMonth = false;
		$monthLoop = true;
		$dayInMonth = 1;
		$firstday = false;
		while($monthLoop) 
		{
			$dayTime = strtotime("$month/$dayInMonth/$year");
			$weekStyle = $this->getMonthWeekCSS($dayTime);
			$render .= "\n\t<tr $weekStyle>\n";
			//for($weekday=0; ($weekday<7 && $monthLoop) ; ++$weekday) 
			for($weekday=0; $weekday<7; ++$weekday) 
			{
				$tmp_render = ''; // wipe clean
				$dayStyle = '';
				$dayTime = strtotime("$month/$dayInMonth/$year");
				
				if ($inMonth == false) 
				{	
					if ($firstDayOfMonth==$weekday) 
					{	if ($firstday == false)
						{	$inMonth = true;
						}
							
						$firstday = true;
					}
				}
				
				if ($inMonth) 
				{	
					$dayStyle = $this->getMonthDayCSS($dayTime);
					$tmp_render = $this->renderDay($dayTime);

					if (!$tmp_render) 
					{	
						$tmp_render .= "&nbsp;";
					}
					++$dayInMonth;
				}
				//this is different for clients, I think this is the better way
				if ($dayInMonth>31) {
					$dayInMonth=32;
				}
				
				if ($this->display_style_for_this_friggin_day == false)
				{	
					if ($tmp_render)
					{	
						if ($weekday == 0 || $weekday == 6)
						{	// this is a weekend and we can change the class here
							$render .= "\t\t<td valign='top' width=\"14%\"  class=\"weekendDay\">";
							
						} else
						{	$render .= "\t\t<td valign='top' width=\"14%\"  class=\"monthCall\">";
						}
						
					} else
					{	$render .= "\t\t<td valign='top' width=\"14%\"  class=\"noDay\">";
					}
					
				} else
				{	
					if ($dayStyle == '')
					{	$dayStyle = ' class="noDay"';
					}
					$render .= "\t\t<td width=\"14%\" valign='top'$dayStyle>";
				}
				
				$render .= $tmp_render;
				$render .= "</td>\n";
				
				if ($dayInMonth > $daysInMonth) 
				{	$monthLoop = false;
					$inMonth=false;
				}
				
			}
			
			$render .= "</tr>";
			
		}
	
		$final = $this->renderMonthHeader($month, $year);
		$final .="<table width='{$this->calWidth}' class='{$this->monthTableClass}'>";
		$final .= $this->renderDaysOfWeek().$render."</table>";
		
	return $final;
	}

	
	function renderYear($year='') {
		if ($year=='') { $year=date("Y"); }
	}

	function renderWeek($weekNum='', $year='') {
		if ($year=='') { $year=date("Y"); }
	}

	function renderDaysOfWeek() {
			$temp .= "<tr class='{$this->monthHeader2}'>";
		$days = $this->dayArray;
		foreach($days as $k=>$v) {
			$temp .="<td height=\"21\">$v</td>";
		}
		$temp .= "</tr>";
		return $temp;	
	}
	

		# Generates day options
		# Example: $t[dayOpts] = $calendar->dayOptions();
		function dayOptions() {
			for ($i=1; $i<=31; $i++)
			{
				$day[] = $i;
			}
			return makeOptions($day, $this->d);
		}


		# Generates select options for months
		# Example:  $t[options] = $calendar->monthOptions();
		function monthOptions() {
			$origMonth = date("m",$this->start);
			for ($i=0; $i<=11; $i++)
			{
				$ut = strtotime("+$i month", $this->start);
				$m = date("F", $ut);
				$temp = date("m",$ut);
				$month[$temp] = $m;
			}
			return makeOptions($month, $origMonth);
		}

	# Generates select options for current year, next five years by default.
	function yearOptions() {
		$origYear= date("Y",$this->start);

		for ($i=0; $i<=4; $i++)
		{
			$ut = strtotime("+$i year", $this->start);
			$y = date("Y", $ut);
			$year[$y] = $y;
		}
		return makeOptions($year, $origYear);
	}


}



class eventItem
{

	var $calendarType = '';	// is set by child classname (in constructor)
	var $username;					// set in constructor
	
	var $id_item = 0;
	var $id_item_sub = 0;	// not used much, (ie, seminars, possible 4 seminars and each seminar has 4 times)
	var $id_classes = 0;
		
	var $description;
	var $location;
	var $title;
	
	var $groups;
	var $notgroups;
	
	var $repeatUntil;		// not worked out yet... ??
	var $repeatExclude;
	var $repeatData;
	var $repeatCount		= 0;
	var $repeatType 		= 0;
	
	var $enddate;
	var $startdate; 
	
	var $f_showwhenactive	= true;
	var $f_allday 			= false;	// just means it's not set to a TIME of day persay it's shown ABOVE THE times
	
	// abstract, make your own wanker!
	function get_brief_display()
	{}
	
	
	// tries to grab the information directly from the database 
	// this will be used on the OUTSIDE, rather than within eventsObj
	// becuase all the information has been had. outside modules/ect 
	// will not
	function dbLoad()
	{
		// required filled in variables
		if ($this->id_item && $this->id_classes)
		{
			$sql = '
			SELECT * 
			FROM lcEvents
			WHERE id_classes='.$this->id_classes.'
			AND id_item='.$this->id_item.'			
			'. (($this->id_item_sub > 0) ? ' AND id_item_sub='.$this->id_item_sub : ''). '
			AND calendarType=\''.get_class($this).'\'
			LIMIT 1
			';
		} else if ($this->pkey) {
			$sql = '
			SELECT *
			FROM lcEvents
			WHERE pkey='.$this->pkey.'
			LIMIT 1
			';
		}
		if ( strlen($sql) < 1 ) {
			return false;
		}
		$db = DB::getHandle();
		$db->RESULT_TYPE = MYSQL_ASSOC;
		$db->queryOne($sql);
		
		if (is_array($db->record))
		{
			foreach($db->record as $variable => $variable_value)
			{	$this->{$variable} = $variable_value;
				$i++;
			}
			if ($i)
			{	return true;
			}
		} 
	}


	function autoLoad(&$object)
	{	
		if (is_object($object))
		{
			foreach($object as $k=>$v)
			{	$this->{$k} = $v;
			}
		
		return true;
		}
		
	}
	
	
	// in charge of deciding how things should be seen
	function cansee($minutes_of_the_day_string)
	{
		
		// Does this item only show up once it's been activated?
		if ($this->f_showwhenactive)
		{	
			// Is itabstractEvent time to active this item? (let be seen?)
			if ($this->startdate <= time())
			{	
				if ($this->f_allday)
				{ 	return true;
				}
				return true;
			}
			
		}

		
		if ($this->f_allday) {
			return true;
		}
		
		
		//echo $minutes_of_the_day_string;
		
		//return true;
		//echo $id.'<br>';
	
	}
	
	
	/**
	 *	Issue a self::dbLoad() before hitting this method
	 *		Must have a valid (with pkey) loaded into object 
	 *		before delete will execute
	 *
	 *	@return					boolean
	 */
	function delete()
	{	
		$e = new edate();
		if ($this->pkey > 0)
		{	
			$e->delete($this->pkey);	// issuing the delete
			$p = edate::_load($this->pkey); 	// a logical way of determining a deletion was successful.. trying to reload it! duH!
			
			if ((int)$p->pkey > 0)
			{	return false;	// did not delete the calendar item
			}
			
		return true;
		}	
		
	}

	
	function save()
	{	
		if ($this->_process())	// making sure the object has enough information to save
		{	
			$e = new edate();
			if ($e->autoLoad($this))
			{	
				return $e->update(); // ugh.. i'd rather have it say "save"
			}
			// add the event
			return true; // this isn't 100% and I need to add better error checking before returning true
		}
		 
	}
	
	// constructor
	function eventItem()
	{	
		$this->calendarType = get_class($this);
		
		$this->startdate = time();
		$this->enddate = $this->startdate; // keeping it exact
		
		global $lcUser;
		$this->username = $lcUser->username;	

	}


	function setPrimaryKey($pkey) {
		if (intval($pkey) > 0) {
			$this->pkey = $pkey;
		}
	}


	function set_owner($username)
	{	$this->username = $username;
	}


	function set_description($description)
	{	$this->description = trim($description);
	}
	
	
	function set_location($location)
	{	$this->location = trim($location);
	}
	
	
	function set_title($title)
	{	$this->title = trim($title);
	}
	
	
	function set_id_class($id_class)
	{	$this->id_classes = $id_class;
	}
	
	function set_id_item($id_item)
	{	$this->id_item = $id_item;
	}
	
	function set_id_item_sub($id_item_sub)
	{	$this->id_item_sub = $id_item_sub;
	}
	
	
	function set_allday($flag=0)
	{	$this->f_allday = (boolean)$flag;
	}


	function set_date_start($date)
	{	$this->startdate = $this->_return_timestamp($date);
	}

	
	function set_date_end($date)
	{	$this->enddate = $this->_return_timestamp($date);
	}
					
	
	function _return_timestamp($date=0)
	{
		if ((int)$date == 0)
		{	
			$return_epoch = time();
		
		} elseif (is_numeric($date) && strlen($date) > 7)
		{	
			$return_epoch = $date;
			
		} else
		{	
			$return_epoch = strtotime($date);
		}
	
	return $return_epoch;
	}
	
	
}


// my plugins
/**
 *	Add in an error message catching system
 */
class classroomAssignments extends eventItem
{
	
	// constructor
	function classroomAssignments()
	{	
		parent::eventItem();
		
		// I am enforcing these contrains then in _process i will keep enforcing for this type of class
		$this->f_showwhenactive = true;
		$this->f_allday = true;
		
	}
	
	
	function get_brief_display($epochtime=0)
	{	
		$requested_date = mktime(0,0,0, date('m', $epochtime), date('d', $epochtime), date('y', $epochtime));
		$myenddate =  	mktime(0,0,0, date('m',$this->enddate), date('d',$this->enddate), date('y',$this->enddate));
		$mystartdate =  mktime(0,0,0, date('m',$this->startdate), date('d',$this->startdate), date('y',$this->startdate));
		
		ob_start();
			eval("?>".$this->title);
			$s .= ob_get_contents();
		ob_end_clean();
		/**
		 *	I do this because I made a mistake of entering php into the database
		 *	when i first made this. 
		 */
		$s = strip_tags($s);
		
		/**
		 *	This feature is used (so far) only in mastercalendar
		 *	so that you can tell which class the assignments
		 *	are from.
		 *	just define the constnat EVENT_SHOWEXTRACLASSINFO to 
		 *	be true before running a calendar detailed view (day)
		 */		
		if (defined('EVENT_SHOWEXTRACLASSINFO') && EVENT_SHOWEXTRACLASSINFO == true) 
		{
			$sql = '
			SELECT A.courseFamilyNumber, C.semesterId
			FROM classes as A
			INNER JOIN courses as B ON A.id_courses=B.id_courses
			INNER JOIN semesters as C ON A.id_semesters=C.id_semesters
			WHERE A.id_classes='.$this->id_classes;

			$db = DB::getHandle();
			$db->queryOne($sql);

			$s = '('.$db->record['semesterId'].') '.$db->record['courseFamilyNumber'].' '.$s;
		} else
		{	
			if ($requested_date == $mystartdate)
			{	$s = '(Assigned) '.$s;
			} else
			{	$s = '(Due) '.$s;
			}
			
		}

		$s = '<a href="'.appurl('classroom/assignments/id_classes='.$this->id_classes.'/event=view/id='.$this->id_item).'">'.$s.'</a>';

	return '<B>Assignment</B>: '. $s; //$this->title;
	}


	function _process()
	{	
		$this->title = str_replace("'", "''", stripslashes($this->title));
		
		$this->groups= array('students', 'faculty', 'admin'); // accomidate
		$this->notgroups = array('pub');
		
		// I'm adding constraints (must have an identification, and only beshown on activation(datestart))
		if ($this->id_item > 0 && $this->f_showwhenactive == true && $this->f_allday == true)
		{	return true;
		}
		
		
	}
	
	
	/**
	 *	@note 	One thing about assignments and if they have no due date
	 *			some where put into the calendar, so I should accomidate
	 *			this but maybe I can purge them out and make sure they 
	 *			aren't entered in.
	 *
	 *	@param	$timestamp						epoch(timedate)
	 *	@param	$request_label_for_day_view		boolean			We are in day view, so we want to specifically watch for times()
	 *	@param	$showitanyway					boolean			Abide by startdate constraint, but that's it (used in master calendar currently to display an assignment)
	 */	
	function cansee($timestamp, $request_label_for_dayview=false, $showitanyway=false)
	{
		if ( $this->startdate <= time() ) {
			$begintoday = mktime(0,0,0, date('m', $this->startdate), date('d', $this->startdate), date('y', $this->startdate));

			$requested_todayview = mktime(0,0,0, date('m', $timestamp), date('d', $timestamp), date('y', $timestamp));
			$endtoday = mktime(0,0,0-1, date('m', $timestamp), date('d', $timestamp)+1, date('y', $timestamp));
			$myenddate =  mktime(0,0,0, date('m',$this->enddate), date('d',$this->enddate), date('y',$this->enddate));
 
			if ($begintoday == $requested_todayview) {
				return true;
			}

			// I need to know where i am today?
			if ($myenddate == $requested_todayview) {
				return true;
			}

			/**
			 *	I need to display the output of this assignment
			 *	when i'm in mastercalendar when this portion of
			 *	the block is hit (ie: startdate has passed)
			 *	How do I detect if i'm in the master calendar?
			 */	
			 if ($showitanyway) {
				return true;
			 }
			 
		} else {
			//echo 'INvalid StartDate';
		}
		return false;
	}
	
	
}





/**
 *	Add in an error message catching system
 */
class orientationsscheduling extends eventItem
{
	
	// constructor
	function orientationsscheduling()
	{	
		parent::eventItem();
		
		// I am enforcing these contrains then in _process i will keep enforcing for this type of class
		$this->f_showwhenactive = false;
		$this->f_allday = false;
		
	}
	
	
	function get_brief_display($epochtime=0)
	{	
		$requested_date = mktime(0,0,0, date('m', $epochtime), date('d', $epochtime), date('y', $epochtime));
		$myenddate =  	mktime(0,0,0, date('m',$this->enddate), date('d',$this->enddate), date('y',$this->enddate));
		$mystartdate =  mktime(0,0,0, date('m',$this->startdate), date('d',$this->startdate), date('y',$this->startdate));
		/*
		ob_start();
			eval("?>".$this->title);
			$s .= ob_get_contents();
		ob_end_clean();
		*/
	return '<B>Orientation</B>: '.$this->title;
	}
	
	
	function _process()
	{	
		$this->groups= array('students', 'semmgr', 'faculty', 'admin', 'public'); // accomidate
		$this->notgroups = array('pub');
		
		// I'm adding constraints (must have an identification, and only beshown on activation(datestart))
		if ($this->id_item > 0 && $this->f_showwhenactive == false && $this->f_allday == false)
		{	return true;
		}
		
	}
	
	
	function cansee($timestamp, $request_label_for_dayview=false)
	{	
		if ($request_label_for_dayview)
		{
			if ($this->startdate == $timestamp)
				return true;
		} else 
		{
			// month views will hit this
			$begintoday = mktime(0,0,0, date('m', $this->startdate), date('d', $this->startdate), date('y', $this->startdate));
			//echo $begintoday.'|'.$timestamp.'<br>';
			if ($timestamp == $begintoday)
			{	return true;
			}
		}
		
		return false;
	}
	
	
}



/**
 *	Add in an error message catching system
 
 
 				// this is our subitem key
				// northwest = 1
				// northeast = 2
				// south = 3
				// southeast = 4
 
 
 */
class seminarscheduling extends eventItem
{
	
	// constructor
	function seminarscheduling()
	{	
		parent::eventItem();
		
		// I am enforcing these contrains then in _process i will keep enforcing for this type of class
		$this->f_showwhenactive = false;
		$this->f_allday = false;
		
	}
	
	
	function get_brief_display($epochtime=0)
	{	
		$requested_date = mktime(0,0,0, date('m', $epochtime), date('d', $epochtime), date('y', $epochtime));
		$myenddate =  	mktime(0,0,0, date('m',$this->enddate), date('d',$this->enddate), date('y',$this->enddate));
		$mystartdate =  mktime(0,0,0, date('m',$this->startdate), date('d',$this->startdate), date('y',$this->startdate));
		/*
		ob_start();
			eval("?>".$this->title);
			$s .= ob_get_contents();
		ob_end_clean();
		*/
	return '<B>Seminar</B>: '. $this->title;
	}
	
	
	function _process()
	{	// If i knew who was looking at this, i could adjust this title better
		/*
		// this needs to move out to display!
		$this->title = '<a href="<?=appurl(\'classroom/seminar/event=view/id_orientation_classes='.$this->id_item.'\');?>">'.$this->title.'</a>';
		$this->title = str_replace("'", "''", $this->title);
		*/
		$this->groups= array('students', 'semmgr', 'faculty', 'admin', 'public'); // accomidate
		$this->notgroups = array('pub');
		
		// I'm adding constraints (must have an identification, and only beshown on activation(datestart))
		if ($this->id_item > 0 && $this->f_showwhenactive == false && $this->f_allday == false)
		{	return true;
		}
		
	}
	
	
	function cansee($timestamp, $request_label_for_dayview=false, $showitanyway=false)
	{	
		if ($request_label_for_dayview)
		{
			if ($this->startdate == $timestamp)
				return true;
		} else 
		{
			// month views will hit this
			$begintoday = mktime(0,0,0, date('m', $this->startdate), date('d', $this->startdate), date('y', $this->startdate));
			//echo $begintoday.'|'.$timestamp.'<br>';
			if ($timestamp == $begintoday)
			{	return true;
			}
			if ($showitanyway)
			{	return true;
			}
		}
		
		return false;
	}
	
	
}



// my plugins
/**
 *	Add in an error message catching system
 */
class examscheduling extends eventItem
{
	
	// constructor
	function examscheduling()
	{	
		parent::eventItem();
		
		// I am enforcing these contrains then in _process i will keep enforcing for this type of class
		
	}
	
	
	function get_brief_display($epochtime=0)
	{	
		$requested_date = mktime(0,0,0, date('m', $epochtime), date('d', $epochtime), date('y', $epochtime));
		$myenddate =  	mktime(0,0,0, date('m',$this->enddate), date('d',$this->enddate), date('y',$this->enddate));
		$mystartdate =  mktime(0,0,0, date('m',$this->startdate), date('d',$this->startdate), date('y',$this->startdate));
		
	return '<B>Exam</B>: '.$this->title. '<br>'.$this->description.'<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i>Ends: '.date('g:i A', $this->enddate). '</i>';
	}
	
	
	function _process()
	{	
		/**
		$this->title = '<a href="<?=appurl(\'classroom/assignments/event=view/id='.$this->id_item.'\');?>">'.$this->title.'</a>';
		$this->title = str_replace("'", "''", $this->title);
		**/
		$this->groups= array('students', 'faculty', 'admin'); // accomidate
		$this->notgroups = array('pub');
		
		// I'm adding constraints (must have an identification, and only beshown on activation(datestart))
		if ($this->id_item > 0)
		{	return true;
		}
		
	}
	
	
	function cansee($timestamp, $request_label_for_dayview=false, $showitanyway=false) {
		//echo 'Testing exam date viewable? [';
		//debug($this);
		//echo date('y-M-d h:i:s', $timestamp);
		if ($request_label_for_dayview) {
			if ($this->startdate == $timestamp || $this->enddate == $timestamp) {
				return true;
			}
		} else {

			// month views will hit this
			$begintoday = mktime(0,0,0, date('m', $this->startdate), date('d', $this->startdate), date('y', $this->startdate));
			//echo date('y-M-d h:i:s', $begintoday);
			//echo $begintoday.'|'.$timestamp.'<br>';
			if ($timestamp == $begintoday) {
				return true;
			}

			$beginsecond = mktime(0,0,0, date('m', $this->enddate), date('d', $this->enddate), date('y', $this->enddate));
			//echo date('y-M-d h:i:s', $begintoday);
			//echo $begintoday.'|'.$timestamp.'<br>';
			if ($timestamp == $beginsecond) {
				return true;
			}

		}

		if ($showitanyway){
			return true;
		}
	return false;
	}
	
	
}


class assessmentscheduling extends eventItem
{
	
	// constructor
	function assessmentscheduling()
	{	
		parent::eventItem();
		
		// I am enforcing these contrains then in _process i will keep enforcing for this type of class
		$this->f_showwhenactive = true;
		$this->f_allday = true;
		
	}
	
	
	function get_brief_display($epochtime=0)
	{
		$requested_date = mktime(0,0,0, date('m', $epochtime), date('d', $epochtime), date('y', $epochtime));
		$myenddate =  	mktime(0,0,0, date('m',$this->enddate), date('d',$this->enddate), date('y',$this->enddate));
		$mystartdate =  mktime(0,0,0, date('m',$this->startdate), date('d',$this->startdate), date('y',$this->startdate));
//		debug($mystartdate,1);
		
		if ($requested_date == $mystartdate) {
			$s = '(Available) ';
		} else {
			$s = '(Unavailable) ';
		}

		if (defined('EVENT_SHOWEXTRACLASSINFO') && EVENT_SHOWEXTRACLASSINFO == true) 
		{
			// check dates on the semester to see if i can display this!
			$sql = '
			SELECT A.courseFamilyNumber, C.semesterId
			FROM classes as A
			INNER JOIN courses as B ON A.id_courses=B.id_courses
			INNER JOIN semesters as C ON A.id_semesters=C.id_semesters
			WHERE A.id_classes='.$this->id_classes;

			$db = DB::getHandle();
			$db->queryOne($sql);

			//$s = '('.$db->record['semesterId'].') '.$db->record['courseFamilyNumber'].' '.$s;
			// I've decided to leave off the (avail./unavail) stuff when this block is hit
			// as this block currently is only hit when you're in the master calendar
			$s = '('.$db->record['semesterId'].') '.$db->record['courseFamilyNumber'].' ';
		}
		
		if ($requested_date == $mystartdate) {
			return '<B>Assessment</B>: <a href="'.appurl('classroom/assessments/').'">'.$s. $this->title.'</a>';
		} else {
			return '<B>Assessment</B>: '.$s. $this->title;
		}
	}
	
	
	function _process()
	{
		$this->groups= array('students', 'faculty', 'admin'); // accomidate
		$this->notgroups = array('pub');
		
		// I'm adding constraints (must have an identification, and only beshown on activation(datestart))
		if ($this->id_item > 0 && $this->f_showwhenactive == true && $this->f_allday == true)
		{	return true;
		}

	}


	/**
	 *	$request_label_for_dayview is exactly waht it means, a request to view the detailed DAY view
	 */
	function cansee($timestamp, $request_label_for_dayview=false)
	{
		$today_day = mktime(0,0,0, date('m'), date('d'), date('y'));
		$req_day = mktime(0,0,0, date('m',$timestamp), date('d',$timestamp), date('y',$timestamp));
		// you can only see this when the start day has been passed.
		$start_day = mktime(0,0,0, date('m', $this->startdate), date('d', $this->startdate), date('y', $this->startdate));
		$end_day = mktime(0,0,0, date('m', $this->enddate), date('d', $this->enddate), date('y', $this->enddate));

		//show it in the calendar no matter when this assessment starts,
		// if it's the opening or ending day, then show it
		if ($req_day == $end_day || $req_day == $start_day) {
			return true;
		}

		// not sure what the rest of this logic is for !!

		if ($request_label_for_dayview)
		{	
			// when to show the label
			// only when the start day has beeen passed or = to right now! can we show this label// OR mark it on the calendar
			if ($start_day <= time() || $end_day <= time() )
			{	
				// because it's an all day thing
				// we dont have to worry about hours
				if ($req_day == $end_day || $req_day == $start_day)
				{
					return true;
				}
			}
		} else {
			if ($start_day < time())
			return true;
		}
	}
}


class dlstaffscheduling extends eventItem
{
	
	// constructor
	function seminarscheduling()
	{	
		parent::eventItem();
		
		// I am enforcing these contrains then in _process i will keep enforcing for this type of class
		$this->f_showwhenactive = false;
		$this->f_allday = false;
		
	}
	
	
	function get_brief_display($epochtime=0)
	{	
		$db = DB::getHandle();
		$sql = '
		SELECT firstname, lastname FROM profile WHERE username=\''.$this->username.'\'
		';
		$db->queryOne($sql);
		
		return '- '. date('g:i A', $this->enddate).' <br><B>'.$db->record['firstname']. ' '. $db->record['lastname']. ' (DL Staff)</B>: '. $this->title. '<br><i>'.$this->description. '</i>';
		
	}
	
	
	function _process()
	{	
		$this->groups= array('dlstaff', 'admin'); // accomidate
		$this->notgroups = array('pub');
		
		// I'm adding constraints (must have an identification, and only beshown on activation(datestart))
		if ($this->id_item > 0 && $this->f_showwhenactive == false)
		{	return true;
		}
		
	}
	
	
	function cansee($timestamp, $request_label_for_dayview=false)
	{	
		if ($request_label_for_dayview)
		{
			if ($this->startdate == $timestamp)
				return true;
		} else 
		{
			// month views will hit this
			$begintoday = mktime(0,0,0, date('m', $this->startdate), date('d', $this->startdate), date('y', $this->startdate));
			//echo $begintoday.'|'.$timestamp.'<br>';
			if ($timestamp == $begintoday)
			{	return true;
			}
		}
		
		return false;
	}
	
	
}
?>
