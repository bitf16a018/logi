<?


/**
 * Create a list from an array
 *
 * This function creates a list - intended for HTML display - from an array
 * This is NOT a dropdown box!
 *
 * @param array $array Array of elements to string together
 * @param string $break HTML element to separate with
 * @return string Returns formatted string
 */
function htmlList($array="",$break="<BR>\n") {
	if (!is_array($array)) { return ""; }
	while(list($key,$val) = each($array)) {
		$html .= "$val$break";
	}
	return $html;
}


/**
 * Create an HTML table from an array
 *
 * This function creates an HTML table based on the elements in an array
 * The ability to have variable columns, width, colors, padding, spacing and border
 * is provided
 *
 * @param array $array Array elements to be shown in table (left to right, top to bottom) 
 * @param int $cols Number of columns in table
 * @param string $w Table width (can include % if it's to be percent-based)
 * @param array $colorArray BGColor for each row - cycles.  Should use stylesheets instead
 * @param int $cp Table cellpadding
 * @param int $cs Table cellspacing
 * @param int $brd Table border 
 * @param str $cellalign Table cell alignment

 * @return string Returns HTML table 
 */


function htmlTable($array,$cols,$w="",$colorArray="",$cp="",$cs="",$brd="", $cellalign="left", $cellvalign="top") {
	if ($cp) { $cp = " cellpadding=\"$cp\" "; }
	if ($cs) { $cp = " cellspacing=\"$cs\" "; }
	if ($brd) { $cp = " border=\"$brd\" "; }

	if (is_array($array)) {
	if ($w) { $width=" width=\"$w\""; }
        if (!ereg("%",$w)) {
                $cellWidth = " width='".intval($w/$cols)."'";
        } else {
                $tempW = ereg_replace("%","",$w);
                $cellWidth = " width='".intval($tempW/$cols)."%" ."'";
        }
	$html .= "<table$width$cp$cs$brd>";
	while (list($key,$val) = each($array)) {
		if ($counter==0) {
			$html .= "<tr>";
		}
		if ($colorArray) {
			$bgcolor = " bgcolor=\"".$colorArray[intval($colorIndex)]."\" ";
			++$colorIndex;
			if ($colorIndex>=count($colorArray)) { $colorIndex=0; }
		}
		$html .= "<td $cellWidth valign=\"$cellvalign\" $bgcolor align=\"$cellalign\">$val</td>\n";
		++$counter;
		if ($counter==$cols) {
			$counter=0;
			$html .= "</tr>";
		}
	}
	if($counter!=0) { $html .= "</tr>"; }
	$html .= "</table>\n";
	return $html;
	}
}



	/**
	 * makes HTML options from an array
	 * 
	 * This will return HTML formatted OPTION tags, but without the SELECT elements
	 * around it.  
	 * The $sel argument can be an array OR a simple string.
	 * If the $sel string matches the key being processed during the looping, 
	 * that element of the OPTION tag will be flagged as 'selected'
	 * If $sel is an array, we'll check the entire array for a match (obviously slower, but handy)
	 * 
	 * @param array $ar Array to be processed into OPTION tags
	 * @param mixed $sel Can be array or single string value - matched against keys of $ar
	 * @return string HTML OPTION tags
	 */
	function makeOptions ($ar,$sel="__0",$useValue=false) {
		while ( list ($k,$v) = @each($ar) ) {
			$optionval = $k;
			if ($useValue) { $optionval = $v; }
			$HTML .= "	<option value=\"$optionval\"";
			if ($optionval == $sel) { $HTML .= " SELECTED "; }
			if (is_array($sel) && @in_array($optionval,$sel) ) { $HTML .= " SELECTED "; }
			$HTML .= ">$v</option>\n";
		}
		return $HTML;
	}


	/**
	 * builds consistant look for hercules admin pages
	 */
	function hercBox ($title) { ?>
<br>
<table border="0" cellpadding="0" cellspacing="0" width="650">
	<tr>
		<td class="selectedTab">
      			<?=$title;?>
		</td>
		<td class="selectedTab" align="right">
		</td>
	</tr>

	<tr>
		<td width="650">
		<table border="1" width="100%">
			<tr>
				<td class="white" width="100%">
	<? } 


	/**
	 * closes the table
	 */
	function endHercBox () {   ?>
				</table>

				</td>
			</tr>
		</table>
		</td></tr>
</table>
	<? }


	/**
	 * makes HTML options for month, day, year from a date
	 * 
	 * @param string $date Date string (m/d/y for example) - can also be a straight unix timestamp
	 * @param string $name Name of select fields to be used in select ($name[day], $name[month],$name[year])
	 * @param int $startyear Year to start year loop (defaults to current year)
	 * @param int $endyear Year to end year loop (defaults to current
	 * @param int $bits bitwise flags to send back m/d/y (111 binary = 7, to return md only, bit=6, to send back year only, bits=1, etc)
	 * @return string HTML formatted select boxes for month/day/year
	 */

function dateDropDown($date="",$name="date",$startyear=0,$endyear=0,$bits=7) {
define (_MONTH,4);
define (_DAY,2);
define (_YEAR,1);
if ($startyear==0) { 
	$startyear = date("Y");
}
if ($endyear==0) { 
	$endyear = date("Y") + 5;
}
if ($endyear<$startyear) { $s = $startyear; $startyear = $endyear; $endyear = $s; }
if ( $date != ""  &&  $date !="0000-00-00 00:00:00") {
	if ( $date === intval($date)) { 
		list($y, $m, $d) = explode("-", date("Y-m-d",$date));
	} else { 
		list($y, $m, $d) = explode("-", date("Y-m-d",strtotime($date)) );
	}
} else {
	list($m, $d, $y) = explode("-", date("m-d-Y") );
}
$m = intval($m);
$d = intval($d);
$y = intval($y);
if ($m == 0) { 
$m = date("m");
$d = date("d");
$y = date("Y");
}
$months = array (1=>'January',
                 'February',
                 'March',
                 'April',
                 'May',
                 'June',
                 'July',
                 'August',
                 'September',
                 'October',
                 'November',
                 'December');
    for ($x=1; $x < 32; ++$x) {
        $days[$x] = $x;
    }
    
    for ($x=$startyear; $x<= $endyear; ++$x) {
        $years[$x] = $x;
    }

    for ($x=1; $x < 13; ++$x) {
        $hours[$x] = $x;
    }

        $mins[] = "00";
    for ($x=15; $x < 60; $x+=15) {
        $mins[$x] = $x;
    }

if ($bits & _MONTH) {  
	$ret .= "<select name='".$name."[month]'>".makeOptions($months,$m)."</select>\n";
}

if ($bits & _DAY) {  
	$ret .= "<select name='".$name."[day]'>".makeOptions($days,$d)."</select>\n";
}
if ($bits & _YEAR) {  
	$ret .= "<select name='".$name."[year]'>".makeOptions($years,$y)."</select>\n";
}
    return $ret;
}


/*
 * datediff
 * take two date/times  and return an array with day/hour/min/sec difference
 * can take strings or unix timestamps
 *
 * @param $date1 string Date/time string like '10/31/2001 1:34 PM'
 * @param $date2 string Date/time string like '10/31/2001 1:34 PM'
 *
 * @return array Array of days, hours, minutes, seconds difference between the two times (array keys are 'd','h','m','s'
 */

function datediff($date1, $date2) {
if (!is_numeric($date1)) { $date1 = strtotime($date1); }
if (!is_numeric($date2)) { $date2 = strtotime($date2); }
$s = $date2 - $date1;
$d = intval($s/86400);
$s -= $d*86400;
$h = intval($s/3600);
$s -= $h*3600;
$m = intval($s/60);
$s -= $m*60;
return array("d"=>$d,"h"=>$h,"m"=>$m,"s"=>$s);
}


/*
 * popup
 *
 * returns a self-contained <a href> tag with appropriate onClick function to 
 * open a popup window.  Height/width and extra parameters are supported.
 *
 * @param $url string	URL to link to
 * @param $height int	Height of popup box to create
 * @param $width int	Width of popup box to create
 * @param $text string	Text to display in the <a href> tag - defaults to URL text if not specified
 * @param $extras string	List of extra window parameters for popup.  Defaults to no toolbar, no location menu, no status bar, no menubar, resizable and automatic scrollbars
 *
 * @return string	HTML for popup link
 */
function popup($url,$height,$width,$text='',$extras='toolbar=no,location=no,resizable=yes,directories=no,status=no,menubar=no,scrollbars=yes') { 
if ($extras) { $extras.=","; }
if (!isset($text)) { $text = $url; }
$j = "<a href=\"#\" onClick =\" window.open('$url','popup','".$extras."width=$width,height=$height');return false;\">$text</a>";
return $j;
}



?>
