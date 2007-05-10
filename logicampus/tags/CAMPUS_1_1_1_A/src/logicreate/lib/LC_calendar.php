<?php

	/*
	 * mini day objects are arrays.
	 * $day = $calendar->dayArray[int];
	 * $day[0] = date, $day[1] = day of week
	 *
	 * function DaysInMonth taken from php mailing list
	 * posted by John Coggeshall
	 */

class calendar {

	var $MAX_DAYS;
	var $dayPointer =  0;
	var $weekPointer = 0;
	var $currentDay;
	var $dayArray = array();
	var $skipEnds =false;
	var $topColor = "#003ab8";
	var $weekendColor = "#9CCeCd"; // DDDDDD";
	var $weekdayColor = "#FFFFFF";
	var $width = 360;
	var $printMonthYear = true;
	var $ERR_MSG;

	//**********************
	// constructors & inits
	//**********************

	function calendar($month,$year) {


	    $tmp = date("d | w",mktime(0,0,0,$month,1,$year));

	    $firstDay = explode(" | ",$tmp);


	    $this->MAX_DAYS = $this->DaysInMonth($month,$year);

		// fill in week with blanks until first of month
	    for($x=0; $x < $firstDay[1]; $x++) {
		$this->dayArray[]  = array("",-1);
	    }

		// fill in rest of days
	    $y = $firstDay[1];
	    for($x=1; $x <= $this->MAX_DAYS; $x++) {
		$this->dayArray[] = array($x,$y);
		if( $y == 6 ) {$y = 0;} else { $y++;}
	    }

	    for($x=$y;$x <= 6; $x++) {
		$this->dayArray[] = array("",-1);
		
	    }

	    
	}

	   


	//*********
	// methods
	//*********

	function nextDay() {

	   if( $this->dayPointer > count($this->dayArray) ) {
		$this->ERR_MSG = "no more days";
		$this->currentDay = array("",-1);
		return false;
	   }

	   $curDay = $this->dayArray[$this->dayPointer];

	   if( $this->skipEnds ) {
		if( $curDay[1] == 6 ) { $this->dayPointer +=2 ;}
		if( $curDay[1] == 0 ) { $this->dayPointer ++; }
		$curDay = $this->dayArray[$this->dayPointer];
	   }
	   $this->dayPointer++;
	   $this->currentDay = $curDay;
	   return true;

	}

	function hasMoreDays() {
	    return ($this->dayPointer < count($this->dayArray));
	}

	function  DaysInMonth($month,$year)
	  {
	    return
	    31-((($month-(($month<8)?1:0))%2)+(($month==2)?((!($year%((!($year%100))?400
	    :4)))?1:2):0));
	  }



	function constructTable($m,$y,$dayInfo="",$link="") {
		$db = DB::getHandle();
	    $HTML = "<table border=\"1\" cellspacing=\"0\" width=\"$this->width\">\n";
	    $wlist = array("Sun", "Mon", "Tue", "Wed", "Thur", "Fri", "Sat");

		if ($this->printMonthYear) { 
			$HTML.= "<tr><td colspan=\"7\"><center><h3>".date("F",mktime(0,0,0,$m,1,$y))." $y</h3></center></td></tr>";
		}
            $i=0;
		$HTML .= "<tr>";
            while ($i < 7) {
	        $HTML .= "<td bgcolor=\"$this->topColor\"><DIV align=\"right\"><FONT SIZE=\"1\" color=\"FFFFFF\"><B>$wlist[$i]</B></FONT></DIV></td>\n";
                $i++;
            }
            $HTML .= "</tr>";
	    while($this->hasMoreDays()) {
		$HTML .=" <tr>";
	    	for ($z=0;$z < 7; $z++) {

		$this->nextDay();
		$day = $this->currentDay;

		if (($day[1] == 6) || ($day[1] == 0)) {
		    $bgcolor = $this->weekendColor;
		}
                else {
		    $bgcolor = $this->weekdayColor;
		}

		$HTML .= "    <td valign=\"top\" bgcolor=\"$bgcolor\" width=\"80\">";
		$HTML .= "<FONT SIZE=\"1\">";
		if ($link) { 
			if (($dayInfo[$day[0]]) || ($this->linkDates)) { 
				$HTML .= "<a href=\"$link/m=$m/d=$day[0]/y=$y\">".$day[0]."</a>";
			} else { 
				$HTML .= $day[0];
			}
		} else {
			$HTML .= $day[0];
		}

		if ($dayInfo[$day[0]] != "") {
			$HTML .= "".$dayInfo[$day[0]]."<BR><BR></FONT></td>\n";
		} else {
			$HTML .= "&nbsp;<BR><BR></FONT></td>\n";
		}

		}

	        $HTML .=" </tr>\n\n";
	    }
	    $HTML .="</table>\n";
		$this->html = $HTML;
	}



}
?>
