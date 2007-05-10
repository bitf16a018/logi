<?php
/*************************************************** 
 *
 * This file is under the LogiCreate Public License
 *
 * A copy of the license is in your LC distribution
 * called license.txt.  If you are missing this
 * file you can obtain the latest version from
 * http://logicreate.com/license.html
 *
 * LogiCreate is copyright by Tap Internet, Inc.
 * http://www.tapinternet.com/
 ***************************************************/



include_once(LIB_PATH."LC_html.php");

class usage extends HercAuth {

	var $presentor = "plainPresentation";
	var $PAGE_SIZE = 30;

	function run (&$db,&$u,&$arg,&$t) {

                                $db->query("select moduleName from lcRegistry where showInMenu=1");
				$c = " checked";
                                while($db->next_record()) {
                                        extract($db->Record);
                                        $opt .= "<input type=\"checkbox\" name=\"opt[$moduleName]\" value=\"y\"$c>$moduleName  ";
					$c = "";
                                }
                                $t["options"] = $opt;

                $t["month"] = date("m");
                $t["day"] = 1;
                $t["year"] = date("Y");
                $t["hour"] = "00";
                $t["min"] = "00";
                $t["emonth"] = date("m");
                $t["eday"] = date("d");
                $t["eyear"] = date("Y");
                $t["ehour"] = "23";
                $t["emin"] = "59";

		$arg->templateName = "usage";
	}



	function userRun(&$db, &$u, &$arg, &$t) {
		$username = $arg->postvars["username"];
                        extract($arg->postvars["time"]);
                        $year = sprintf("%4d",$year);
                        $eyear = sprintf("%4d",$eyear);
                        $month = sprintf("%02d",$month);
                        $emonth = sprintf("%02d",$emonth);
                        $day = sprintf("%02d",$day);
                        $eday = sprintf("%02d",$eday);
                        $hour = sprintf("%02d",$hour);
                        $ehour = sprintf("%02d",$ehour);
                        $min = sprintf("%02d",$min);
                        $emin = sprintf("%02d",$emin);

                        $starttime = "$year$month$day$hour$min"."00";
                        $endtime = "$eyear$emonth$eday$ehour$emin"."59";

                        $stime = strtotime("$month/$day/$year $hour:$min:00");
                        $etime = strtotime("$emonth/$eday/$eyear $ehour:$emin:59");

                        $diff = $etime-$stime;


  // determine scale from time difference

                        if (($diff/3600)<13) {
                                // 12 hour scale
                                $interval = 1800;  // 15 minute scale
                                $datestring = "h:i";
                        }
                        if (($diff/60) < 60) {
                                // 1 hour scale
                                $interval = 120;
                                $datestring = "h:i";
                        }
                        if (($diff/86400)<8) {
                                // 7 day scale
                                $interval = 43200; // every 12 hours
                                $datestring = "h:i";
                        }
                         if (($diff/86400)<2) {
                                // 1 day scale
                                $interval =  3600;
                                $datestring = "hA";
                         }
                           if (($diff/86400) > 1) {
                                $interval=3600 * 3;
                                $datestring = "hA";
                         }
                           if (($diff/86400) > 2) {
                                $interval=3600 * 3;
                                $datestring = "hA";
                         }
                           if (($diff/86400) > 3) {
                                $interval=3600 * 6;
                                $datestring = "hA";
                         }

                         if (($diff/86400) > 7) {
                                $interval=43200;
                                $datestring = "m/d";
                         }
                         if (($diff/86400) > 14) {
                                $interval=86400 * 2;
                                $datestring = "m/d";
                         }
                         if (($diff/86400) > 25) {
                                $interval=86400 * 2;
                                $datestring = "m/d";
                         }
                         if (($diff/86400) > 75) {
                                $interval=86400 * 30;
                                $datestring = "m/d";
                         }


                         $timeloop = $stime;
                         while($timeloop<=$etime) {
                               // unset($count);
                                $tstart = $timeloop;
                                $tend = $timeloop + $interval -1;
                                $tstart = date("YmdHis",$tstart);
                                $tend = date("YmdHis",$tend);
                                while(list($a,$b) = each($arg->postvars["opt"])) {
                                        if ($b=="y") {
                                                $sql = " select count(pkey) as cnt from lcLogging where accesstime>='$tstart' and accesstime<='$tend' and moduleName='$a' ";
                                                $db->queryOne($sql);

                                                $intcount = intval($intcount);
                                                $count[$a][$intcount] = $db->Record["cnt"];
                                                $usagecount[$a] += intval($db->Record["cnt"]);
                                        }
                                 }
                                 reset($arg->postvars["opt"]);

                                 $timeloop = $timeloop + $interval;
                                 $j++;
                                 ++$intcount;
                         }

                         $usage = $count;
                         unset($count);


/*		don't use this until param0 can be worked into the database
//html file counting ???
                       $sql = " select count(param0) , param0 from lcLogging where accesstime>='$starttime' and accesstime<='$endtime' and param0<>'' and moduleName='html' group by moduleName";
                        $db->query($sql);
                         unset($count);
                         while($db->next_record()) {
                           $count[$db->Record[1]] = $db->Record[0];
                         }
                         @arsort($count);
                         while(list($k,$v) = @each($count)) {
                               $h.= "<tr><td>$k</td><td>$v</td></tr>";
                         }

*/
// count sessions
                        $sql = " select count(distinct(sesskey)) from lcLogging where accesstime>='$starttime' and accesstime<='$endtime' ";
                        $db->queryOne($sql);
                        $sessions = $db->Record[0];

// get session max/min/avg
// ARGH - we should really have a timestamp in there as well!
                        $sql = " select distinct(sesskey) from lcLogging where accesstime>='$starttime' and accesstime<='$endtime' ";
                        $db->query($sql);

                        while($db->next_record()) {
                                $sess[] = $db->Record[0];
                        }
                        $mindiff = 99999999;
                        while(list($k,$v) = @each($sess)) {
                                $sesskey = $v;
                                $db->queryOne("select min(accesstime) from lcLogging where sesskey='$v' and accesstime>='$starttime' and accesstime<='$endtime' ");
                                $lmin = $db->Record[0];
                                $minstamp = mktime(substr($lmin,8,2), substr($lmin,10,2), substr($lmin,12,2), substr($lmin,4,2), substr($lmin,6,2), substr($lmin,0,4) );
                                $db->queryOne("select max(accesstime) from lcLogging where sesskey='$v' and accesstime>='$starttime' and accesstime<='$endtime' ");
                                $max = $db->Record[0];
                                $maxstamp = mktime(substr($max,8,2), substr($max,10,2), substr($max,12,2), substr($max,4,2), substr($max,6,2), substr($max,0,4) );

                                $diff = $maxstamp - $minstamp;
                                if ($diff>$maxdiff) { $maxdiff = $diff; }
                                if (($diff<=$mindiff) && ($diff>0)) { $mindiff = $diff; }
                                $alldiffs = $alldiffs + $diff;
                                if ($diff>0)  { ++$alldiffscount; } 
                        }
if ($alldiffscount>0) { 
                        $avgdiff = ($alldiffs/$alldiffscount);
} else { $avgdiff=0; }
                        $t["avgdiff"] = intval($avgdiff);
                        $t["maxdiff"] = $maxdiff;
                        $t["mindiff"] = $mindiff;
// count pageviews
                        $sql = " select count(pkey) from lcLogging where accesstime>='$starttime' and accesstime<='$endtime' ";
                        $db->queryOne($sql);
                        $pageviews = $db->Record[0];


// take $usagecount and break it up
                        while(list($k,$v) = each($usagecount)) {
                                $t['uc'] .= "<tr><td>$k</td><td>$v</td></tr>\n";
                        }


			$u->sessionvars['chartParams']["stime"] = $stime;
			$u->sessionvars['chartParams']["etime"] = $etime;
			$u->sessionvars['chartParams']["interval"] = $interval;
			$u->sessionvars['chartParams']["datestring"] = $datestring;
			$u->sessionvars['chartParams']["usage"] = $usage;
			$u->saveSession();

                $t["pageviews"] = $pageviews;
                $t["sessions"] = $sessions;
                $t["report"] = $x;
                $t["htmlreport"] = $h;

                $t["month"] = $month;
                $t["day"] = $day;
                $t["year"] = $year;
                $t["hour"] = $hour;
                $t["min"] = $min;
                $t["emonth"] = $emonth;
                $t["eday"] = $eday;
                $t["eyear"] = $eyear;
                $t["ehour"] = $ehour;
                $t["emin"] = $emin;


                                $db->query("select moduleName from lcRegistry where showInMenu=1");
                                while($db->next_record()) {
                                        extract($db->Record);
                                        $c = "";
                                        if ($arg->postvars["opt"][$moduleName]=="y") { $c=" checked"; }
                                        $opt .= "<input type=\"checkbox\" name=\"opt[$moduleName]\" value=\"y\"$c>$moduleName  ";
                                }
                                $t["options"] = $opt;

		$arg->templateName = "usage";
	}





	/**
	 * trying to put functionality of chart.php into this file
	 * since the chart.php is heavily biased to making usage charts (x.txt)
	 * it should be better in hya
	 */
	function drawChartrun (&$db,&$u,&$arg,&$t) {
        ob_end_clean();

include (_SERVICE_PATH."graph/jpgraph.php");	//not completely correct, but at least it gets set at install
include (_SERVICE_PATH."graph/jpgraph_line.php");
include (_SERVICE_PATH."graph/jpgraph_log.php");

$colors = array(0=>"red",1=>"blue",2=>"green",3=>"yellow",4=>"gray",5=>"purple",6=>"orange",7=>"teal",8=>"aqua",9=>"tan",10=>"yellowgreen");

		// use get string instead of x file
		// get string doesn't work, let's try session data
		@extract($u->sessionvars['chartParams']);
//print_r($u);exit();
		//destroy session to reduce risk of caching
		$u->sessionvars['chartParams'] = '';
		$u->saveSession();

/*                $datestring = $arg->getvars[datestring];
                $interval = $arg->getvars[interval];
                $stime = $arg->getvars[stime];
                $etime = $arg->getvars[etime];
                $usage = unserialize($arg->getvars[usage]);
*/



// Create the graph. These two calls are always required
$graph = new Graph(620,240,"activeChart");
$graph->img->SetMargin(40,170,30,50);
$graph->SetScale("textlog");
//$graph->SetShadow();
$l = $graph->legend;


//print_r($d);
//exit();



while(list($mod,$index) = @each($usage)) {
  while(list($k,$v) = each($index)) {
        $total[$mod] += $v;
        $totaltotal += $v;
  }
}
@reset($usage);

$j=0;
while(list($mod,$index) = @each($usage)) {
unset($d2);

        $d2 = new LinePlot($index);
        $pct = sprintf("%0.2f",($total[$mod]/$totaltotal)*100);
        $d2->SetLegend($pct."%". " - ".$mod);
                   $c = $colors[$j];
        $d2->SetColor($c,true);
        $d2->SetWeight(1);
        $d4[] = $d2;
        $graph->Add($d2);
        ++$j;
}



// x axis interval jump
$tickjump = 2;

$start = $stime;
$end = $etime;
while ($start<=$end) {
        $datax[] = date($datestring,$start);
        $start = $start + ( $interval * $tickjump);
}

//exit();



// Create the accumulated graph
//$aplot = new AccLinePlot($d4);

//$graph->Add($aplot);


$graph->xaxis->SetTextTickInterval($tickjump);
$graph->title->Set(date("m/d/Y H:i:s A",$stime)." through ".date("m/d/Y H:i:s A",$etime));
$graph->xaxis->title->Set("date/time");
$graph->yaxis->title->Set("pageviews");

$graph->title->SetFont(FF_FONT1,FS_BOLD);
$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);

$graph->xaxis->SetTickLabels($datax);
//$graph->xaxis->SetTextTickInterval(1);

// Display the graph
$graph->Stroke();


exit();

        }


}
?>
