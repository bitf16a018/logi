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

include ("graph/jpgraph.php");
include ("graph/jpgraph_line.php");


class chart extends HercAuth {
	var $presentor = "adminPresentation";

	function run (&$db,&$u,&$arg,&$t) {

                $db->query("select * from lcRegistry where mid = '".$arg->getvars[1]."'");
		$db->next_record();
		$modName = $db->Record[moduleName];

					//mysql TIMESTAMP YYYYMMDDHHIISS
		$db->query("select count(DISTINCT sesskey) from lcLogging where moduleName = '".$modName."' and (accesstime > (DATE_SUB(NOW(),INTERVAL 7 DAY) ) )");
		$db->next_record();
			$t[sess][] = $db->Record[0];


		$db->query("select count(DISTINCT sesskey) from lcLogging where moduleName = '".$modName."' and (accesstime < (DATE_SUB(NOW(),INTERVAL 7 DAY) )) and (accesstime > (DATE_SUB(NOW(),INTERVAL 14 DAY) ) )");
		$db->next_record();
			$t[sess][] = $db->Record[0];

		$db->query("select count(DISTINCT sesskey) from lcLogging where moduleName = '".$modName."' and (accesstime < (DATE_SUB(NOW(),INTERVAL 14 DAY) ) ) and (accesstime > (DATE_SUB(NOW(),INTERVAL 21 DAY) ) )");
		$db->next_record();
			$t[sess][] = $db->Record[0];

		$db->query("select count(DISTINCT sesskey) from lcLogging where moduleName = '".$modName."' and (accesstime < (DATE_SUB(NOW(),INTERVAL 21 DAY) )) and (accesstime > (DATE_SUB(NOW(),INTERVAL 28 DAY) ) )");
		$db->next_record();
			$t[sess][] = $db->Record[0];



		$db->query("select count(pkey) from lcLogging where moduleName = '".$modName."' and (accesstime > (DATE_SUB(NOW(),INTERVAL 7 DAY) ) )");
		$db->next_record();
			$t[hits][] = $db->Record[0];


		$db->query("select count(pkey) from lcLogging where moduleName = '".$modName."' and (accesstime < (DATE_SUB(NOW(),INTERVAL 7 DAY) )) and (accesstime > (DATE_SUB(NOW(),INTERVAL 14 DAY) ) )");
		$db->next_record();
			$t[hits][] = $db->Record[0];


		$db->query("select count(pkey) from lcLogging where moduleName = '".$modName."' and (accesstime < (DATE_SUB(NOW(),INTERVAL 14 DAY) )) and (accesstime > (DATE_SUB(NOW(),INTERVAL 21 DAY) ) )");
		$db->next_record();
			$t[hits][] = $db->Record[0];

		$db->query("select count(pkey) from lcLogging where moduleName = '".$modName."' and (accesstime < (DATE_SUB(NOW(),INTERVAL 21 DAY) )) and (accesstime > (DATE_SUB(NOW(),INTERVAL 28 DAY) ) )");
		$db->next_record();
			$t[hits][] = $db->Record[0];

//$this->presentor = "debug";
//return;
$new_datay = 		$t[sess];
$inprogress_datay = 	$t[hits];
$datax = array("1 weeks ago","2 weeks ago","3 weeks ago","4 weeks ago");

// Create the graph. These two calls are always required
$graph = new Graph(400,240,"activeChart");	
$graph->img->SetMargin(40,90,30,50);
$graph->SetScale("textlin");
$graph->SetShadow();

// Create the linear plots for each category
$dplot[] = new LinePLot($new_datay);
$dplot[] = new LinePLot($inprogress_datay);

$dplot[0]->SetFillColor("red");
$dplot[1]->SetFillColor("blue");

$dplot[0]->SetLegend("Sessions");
$dplot[1]->SetLegend("Hits");


// Create the accumulated graph
$accplot = new AccLinePlot($dplot);

// Add the plot to the graph
$graph->Add($accplot);

$graph->xaxis->SetTextTickInterval(2);
$graph->title->Set("1 Month activity for ".$modName);
$graph->xaxis->title->Set("date");
$graph->yaxis->title->Set("number");

$graph->title->SetFont(FF_FONT1,FS_BOLD);
$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);

$graph->xaxis->SetTickLabels($datax);
$graph->xaxis->SetTextTickInterval(1);

// Display the graph
$graph->Stroke();


        }
}
?>
