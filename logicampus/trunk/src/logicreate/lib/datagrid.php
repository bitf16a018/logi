<?
include_once(LIB_PATH."LC_html.php");

/*
sample code

class foo extends DataGrid {

	var $table = 'mytable';
	var $rowsPerPage = 5;
	var $column = 'col1,col2,col3,col4';
	
	function run() {
		$this->ignore = array('col1');
		$this->sortColumns = array("col2","col3");
		$this->headers = array('col2'=>'Name','col3'=>'Date',"view"=>"  ");
		$this->prependColumn('<a href="<?=appurl("mod/svc/event=view/id=$col1");?>">view</a>','view');
		$this->overrideColumn('<?=date("m/d/Y",strtotime($col4));?>','col4');
		$t['table'] = $this->toHTML();
	}
*/

class DataGrid {

	var $class = '';			// css class for the entire rendered table
	var $width = '100%'; 			// width for entire rendered table
	var $rowClasses = array('even','odd'); // css for rendered rows - rotates through entire array
	var $headerClass = 'even';		// css used on header row
	var $navClass = '';			// css used on row with prev/next nav links
	var $headers = array();			// columnname=>displayname mapping for header row
	var $sortColumns = array();		// column names which should be able to be sorted
	var $start =0;				// page of data to start on
	var $sortVar = 'dgorder';		// variable used for internal 'order by' clauses
	var $startVar = 'dgstart';		// variable used for internal page counting
	var $rowsPerPage = 20;			// number of data rows per page
	var $sql = ''; 				// not required - can pass in any associative array
	var $dsn = 'default';			// dsn to use if we need to hit a data table 
	var $array = array(); 			// data array
	var $ignore = array();			// array of columns to ignore - data is still available for evaling
	var $evalCols = array(); 		// array of column names to evaluate for embedded PHP
	var $callbackCols = array();		// array of column names to call an external function for getting data
	var $override = array();		// array of columns to override with PHP formatting
	var $prepend = array();			// array of columns to prepend to each row of data
	var $postend = array();			// array of columns to postpend to each row of data
	var $showHeader = true;			// display the header?
	var $showNavLinks = true;		// display the prev/next links if required?
	var $tdObject = "grid_td";			// experimental
	var $trObject = "grid_tr";			// experimental
	var $table = '';
	var $column = '*';
	var $where = '';	
	var $joins = '';
	
	var $a_cell_width= array(); 	// 
	var $a_cell_align= array();
	
	var $sort_order = 'ASC';		// sort order
	var $sortOrderVar = 'dgsorder';// GET variable for retrieving the sort order

	var $use_pagedropdown = true; 	// should we show a dropdown of pages? default(false)
	
	var $name_module;
	var $name_service;
	
	var $extra_url; 			// use if you want to use a datagrid in an event of a module
// was initially passing in service and arg, but 
// they should be automatic.  we have no good way of getting these except to 
// globalize them right now.  Eventually they should be functions/methods 
// to grab them from something else.  (system object?)


// SETTERS
	
	/**
	 *	Set the wdith of a specific cell
	 *
	 *	@param 	$cellName			string			name of header (datafieldname!cell)
	 *	@param	$cellWidth			mixed			int (50) or string 50% of the cell table width
	 */
	function setCellWidth($cellName, $cellWidth)
	{	$this->a_cell_width[$cellName] = $cellWidth;
	}

	/**
	 *	Set the alignment of a specific cell
	 *
	 *	@param 	$cellName			string			name of header (datafieldname!cell)
	 *	@param	$cellAlign			string			int (50) or string 50% of the cell table width
	 */
	function setCellAlign($cellName, $cellAlign)
	{	$this->a_cell_align[$cellName] = $cellAlign;
	}
		
	/**
	 *	Show a dropdown of all pages for quick access
	 */
	function usePageDropdown($boolean)
	{
		$this->use_pagedropdown = false;
		
		if ((boolean)$boolean)
		{	$this->use_pagedropdown = true;
		}

	}
	
	
	function DataGrid($module, $service) { 
		$this->name_module = $module;
		$this->name_service = $service;

	
		global $lcObj;
		$this->obj = $lcObj;	// had to add this back in becuase ->obj is not available
		
		$this->getvars = $this->obj->getvars;
		$this->postvars = $this->obj->postvars;
		unset($this->getvars['event']);
		$this->startPage = (int)$this->obj->getvars[$this->startVar];
		
		$this->beginpage = '<img title="First page" alt="First page" src="'. IMAGES_URL. 'prevprev.gif" border="0">';
		$this->prevpage =  '<img title="Previous page" alt="Previous page" src="'. IMAGES_URL. 'prev.gif" border="0">';
		$this->nextpage = '<img title="Next page" alt="Next page" src="'. IMAGES_URL. 'next.gif" border="0">';;
		$this->lastpage = '<img title="Last page" alt="Last page" src="'. IMAGES_URL. 'nextnext.gif" border="0">';;
	}

	function genID() {
		if ($this->_id=='') { 
// the module and service should be taken from the index.php URL parsing stuff, 
// not necessarily passed in
// this is ryan's evil doing, and wasn't in my initial version
// we'll rectify this later, and when we do, the _id will need
// to be changed accordingly
		$this->_id = $this->name_module."_".$this->name_service;
		}
	}

// init calls the genID method which generates an ID for the table
// if an ID is already set ($this->_id) after datagrid initialization,
// this will be used instead.  The ID is used to reference this particular 
// datagrid's data in a user's session.  I added this in because
// there may be a need for multiple datagrids on the same page, 
// but using different tables/SQL.

	function init()
	{
		$this->genID();
		$u =&lcUser::getCurrentUser();
		//don't reset orderby if it's already set
		if ( strlen ($this->orderby) < 1 ) {
			$this->orderby = $this->obj->getvars[$this->sortVar];
			if (trim($this->orderby)!='') { 
				$u->sessionvars['dg_info'][$this->_id] = array($this->orderby,$this->obj->getvars[$this->sortOrderVar]);
			} else {
				$this->orderby =  $u->sessionvars['dg_info'][$this->_id][0];
				$this->sort_order=  $u->sessionvars['dg_info'][$this->_id][1];
			}
		}


		
		if ($this->where) 
		{	$this->where = ' where '. $this->where; 
		}
		
		// setting the sort order
		/**	The unfortunate fact is that someone could put something OTHER than ASC DESC
		 */
		if ($this->obj->getvars[$this->sortOrderVar]) { 
			$this->sort_order = $this->obj->getvars[$this->sortOrderVar];
		}
		if ($this->sort_order != 'DESC')
		{
			$this->sort_order = 'ASC';
		}
		
	}


// function to create URL for methods which need links
// was initially in constructor, but that left no way to 
// override the event, for example

	function baseURL() {
		while(list($k,$v)=  @each($this->obj->getvars)) {
			if (!is_int($k)) {
				if (substr($k,0,2)!='dg') { 
				$j[] = "$k=$v";
				}
			}
		}
		//$x = @implode("/",$j);
		//$this->baseurl = appurl($this->name_module."/".$this->name_service."/$x/");
		$this->baseurl = appurl($this->name_module."/".$this->name_service.$this->extra_url);
	}
	

// create an SQL statement if we're trying to pull 
// data from a SQL database
	function prepareSQL() {
		$sql = $this->sql;

// was a separate method call once
		if (!$sql) { 
			$sql = "select $this->column from $this->table $this->joins $this->where";
		}
		if ($this->orderby) 
		{
			$sql .= " order by ".$this->orderby. ' '. $this->sort_order;
		}
		
		$sql .= " limit ".( ($this->startPage) * $this->rowsPerPage).",".$this->rowsPerPage;

		return $sql;
	}

// get the rows to display in the grid	
	function getRows() {
		$db = DB::getHandle($this->dsn);
		
		//debug($this->prepareSQL());
		$db->query($this->prepareSQL());
		
		$db->RESULT_TYPE = MYSQL_ASSOC;
		
		while($db->nextRecord()) {
			$this->datarows[] = $db->record;
		}
		
		$this->rowsset=true;
		$sql = $this->countsql;
		if ($sql) {
			$db->queryOne($sql);
			$this->_totalRows = $db->record['totalcount'];
		} else {
			$db->queryOne("select count(*) as totalcount from {$this->table} {$this->joins} {$this->where}");
			$this->_totalRows = $db->record['totalcount'];
		}

		$this->_totalPages = ceil((int)$this->_totalRows / (int)$this->rowsPerPage) - 1;
	}

	
	function setRows($datarows='') {
		$this->datarows = $datarows;
		$this->_totalRows = @count($datarows);
		$this->rowsset = true;
	}

// process the row data into displayable HTML
// if we have no rows already in the object ($this->datarows)
// we'll attempt to get the rows via the internal $getRows method
// this will check for an SQL statement or try to build one 
// from the original constructor arguments (table, cols, where clause)
	
	function processRows() {

		$this->rows = array();
		if (!$this->rowsset) {
			if ($this->table) { 
				$this->getRows();
				
			}
		}
		
		@reset($this->datarows);
		while(list($k,$v) = @each($this->datarows)) {
			$row = $this->arrayToRow($v);
			if (is_array($this->rowClasses)) {
				$row->class = $this->rowClasses[(int)$rowcount];
				$rowcount++;
				if ($rowcount>=count($this->rowClasses)) {
					$rowcount=0;
				}
			}
			$this->rows[] = $row->toHTML();
		}
		$this->data = @implode("",$this->rows);
		$this->headers();
		$this->processed = true;
	}

/*
 method to attach new display rules for a particular named column
 for example, a database may be returning a timestamp in column 'mytime'
 we can 'override' the display for that column with processed PHP
 
 $grid->overrideColumn('<?=date("m/d/Y",$mytime);?>','mytime');
 the name of the column is available as a local PHP variable when the 
 row data is being processed
*/

	function overrideColumn($data,$name='',$eval=true) {
		if ($name!='') { 
			$this->override[$name] = $data;
		} else {
			$this->override[] = $data;	
		}
		if ($eval==true) { 
			$this->evalCols[] = $name;
		}
	}

/*
 similar to override column, but adds a new column name 
 to be processed during each row's processing, and attaches 
 it to the beginning of the row
 can be used for creating 'edit' style links with dynamic data
 from the current row
 
 for example,
 $grid->prependColumn('<a href="<?=appurl("module/service/event=foo/id=$pkey");?>">edit me</a>','editLink');

 this will create a link in the first column of each row which jumps to the 
 module/service/event and uses the value of the row's $pkey in each link
*/

	function prependColumn($data,$name='',$eval=true) {
		if ($name!='') { 
			$this->prepend[$name] = $data;
		} else {
			$this->prepend[] = $data;	
		}
		if ($eval==true) { 
			$this->evalCols[] = $name;
		}
	}
//
// similar to prependColumn, but the column is at the end of the row
//
	function postpendColumn($data,$name='',$eval=true) {
		if ($name!='') { 
			$this->postpend[$name] = $data;
		} else {
			$this->postpend[] = $data;	
		}
		if ($eval==true) { 
			$this->evalCols[] = $name;
		}

	}


	function postpendCallbackColumn($data,$name) {
		$this->postpend[$name] = $data;
		$this->callbackCols[] = $name;
	}


// internal - don't call yourself

	function headers() {
		$this->baseURL();
		if (is_array($this->headerNames)) {
			while(list($k,$v) = each($this->headerNames)) {
				if ($this->headers[$v]) { 
					$this->headerNames[$k] = $this->headers[$v];
				}
				if (in_array($v,$this->sortColumns)) { 

					$x = "<a href=\"".$this->baseurl."/{$this->startVar}={$this->startPage}/".$this->sortVar."=$v/".$this->sortOrderVar.'='.(($this->sort_order == 'DESC' ) ? 'ASC' : 'DESC' )."\">".$this->headerNames[$k]."</a>";
					$this->headerNames[$k] = $x;
				}
			}
			$this->ignorePrePost = true;
			$h =$this->arrayToRow($this->headerNames, true);
			$h->class= $this->headerClass;
			$this->headerHTML = $h->toHTML();
			
		}

		
		if ($this->startPage > 0) { // previous
			$this->beginpage = "<a href=\"".$this->baseurl."/".$this->startVar."=0/{$this->sortVar}={$this->orderby}/{$this->sortOrderVar}={$this->sort_order}\">{$this->beginpage}</a>";
			$this->prevpage = "<a href=\"".$this->baseurl."/".$this->startVar."=".($this->startPage -1)."/{$this->sortVar}={$this->orderby}/{$this->sortOrderVar}={$this->sort_order}\">{$this->prevpage}</a>";
		} else
		{
			$this->beginpage = str_replace('prevprev.gif', 'noprevprev.gif', $this->beginpage);
			$this->prevpage = str_replace('prev.gif', 'noprev.gif', $this->prevpage);
		
		}
		
		if ($this->startPage < $this->_totalPages) { //  next
			$this->lastpage = "<a href=\"".$this->baseurl."/".$this->startVar."=".$this->_totalPages."/{$this->sortVar}={$this->orderby}/{$this->sortOrderVar}={$this->sort_order}\">{$this->lastpage}</a>";
			$this->nextpage = "<a href=\"".$this->baseurl."/".$this->startVar."=".($this->startPage +1)."/{$this->sortVar}={$this->orderby}/{$this->sortOrderVar}={$this->sort_order}\">{$this->nextpage}</a>";
		} else
		{ 
			$this->lastpage = str_replace('nextnext.gif', 'nonextnext.gif', $this->lastpage);
			$this->nextpage = str_replace('next.gif', 'nonext.gif', $this->nextpage);
			
		}
		if ($this->_totalPages<0) { 
			$this->beginpage='';
			$this->lastpage='';
			$this->prevpage = '';
			$this->nextpage='';
		}
	}
//
// take the grid object and render it as HTML
//

	/**
	 *
	 */
	function _getPageDropdown($pageCurrent, $pageTotal)
	{
		$pageCurrent++;
		$select_text = '';
		
		if ($pageTotal > 1)
		{
			$select_text = '
			<select name="dgStart" onchange="location.href = \''.$this->baseurl."/".$this->startVar."='+(this.value-1)+'"."/{$this->sortVar}={$this->orderby}/{$this->sortOrderVar}={$this->sort_order}".'\'">';
			
			for ($i=1; $i <= $pageTotal; ++$i)
			{
				$select_text .= '
				<option value="'.$i.'"';
				
				if ($pageCurrent == $i)
				{	$select_text .= ' selected';
				}
				
				$select_text .= '> '. $i. '</option>';
				
			}
			$select_text .= '
			</select>';
			
		} else
		{	
			if ($pageTotal >0)
			{	$select_text = $pageCurrent;
			} else
			{	$select_text = 0;
			}
			
		}
		
	return $select_text;
	}

	function getNavTable() {
		$total_pages = (int)ceil($this->_totalRows/$this->rowsPerPage);
		$j ='		
		<table cellpadding="2" cellspacing="0" class="'. $this->navClass. '" width="'. $this->width.'">
		<tr>
			<td>Page '.
		(($this->use_pagedropdown) ? $this->_getPageDropdown($this->startPage, (int)ceil($this->_totalRows/$this->rowsPerPage)) :
		(($total_pages == 0) ? 0 : ($this->startPage+1))
		).' of '. (int)ceil($this->_totalRows/$this->rowsPerPage).'</td>
			<td align="right">';
		if ($this->showNavLinks) { 
		$j .= "{$this->beginpage} &nbsp; {$this->prevpage} &nbsp; {$this->nextpage} &nbsp; {$this->lastpage}";
		}
		$j .= '</td>
		</tr>
		</table>';
		return $j;		
	}
	
	function toHTML() {
		
		$this->init();

		if (!$this->processed) { $this->processRows(); } 
		if ($this->class) { $class = " class='".$this->class."'"; }
		
		$total_pages = (int)ceil($this->_totalRows/$this->rowsPerPage);
		$j .= $this->getNavTable();
		
		$j .= '
		<span id="datagrid">
		<table'.$class.' width="'. $this->width. '" cellpadding="2" cellspacing="1">
		';
		if ($this->showHeader) { 
		$j .= $this->headerHTML;
		}
		if ($total_pages == 0)
		{	$j.= '
		<tr>
			<td align="center">No Records Available</td>
		</tr>';
		}
		$j .= $this->data. '
		</table>';
		$j .= '
		</span>';
		
		$j .=	$this->getNavTable();	

		return $j;
	}

// internal - don't use
		
	function arrayToRow($array, $b_header=false) {
		if (is_object($array)) {
			$array = get_object_vars($array);
		}
		if (!$this->ignorePrePost) { 
		if (is_array($this->prepend)) {
			$array = array_merge($this->prepend,$array);
		}
		if (is_array($this->postpend)) {
			$array = array_merge($array,$this->postpend);
		}
		}
		
		@extract($array);
		@reset($array);
		while(list($k,$v) = @each($array)) {
			if (!in_array("$k",$this->ignore)) {
				if ($this->override["$k"]!='') {
					$v = $this->override["$k"];
				}
				if (in_array("$k",$this->evalCols)) {
					ob_start();eval("?>$v<? ");$j = ob_get_contents();ob_end_clean();
				} else if ( in_array("$k", $this->callbackCols) ) {
					$f = $this->postpend[$k];
					//call user func can't properly pass
					// references, so use this "eval"
					// type calling style.
					if( function_exists($f) ) {
						$f($array,$j);
					}
				} else {
				       	$j = $v; 
				}

				if ($b_header) {
					$td[] = new grid_th($j);
				} else {
					$td[] = new $this->tdObject($j, $this->a_cell_width[$k], $this->a_cell_align[$k]);
				}
			}
		}

		$row = new $this->trObject;
		$row->arrayToRow($td);
		if (!is_array($this->headerNames)) {
			$this->headerNames = array_diff(array_keys($array), $this->ignore);
		}
		return $row;
	}
}

// supporting class
class grid_tr {
	var $class = '';
	
	function grid_tr($data='') {
		$this->data = $data;
	}
	function arrayToRow($array) {
		if (is_array($array) == false) return;
		while(list($k,$v) = @each($array)) {
			$temp[] = $v->toHTML();
		}
		$this->data = @implode("",$temp);
	}
	function toHTML() {
		if ($this->class) { $class = " class='".$this->class."'"; }
		return '
		<tr valign="top"'. $class. '>'.$this->data. '
		</tr>';	
	}	
	
}

// supporting class
class grid_td {
	var $class='';
	var $cellWidth=0;
	var $cellAlign='';
	
	function grid_td($data, $cellWidth=0, $cellAlign='left') {
		$this->data = $data;
		
		$this->cellAlign = ($cellAlign != '') ? $cellAlign : '';
		$this->cellWidth = ($cellWidth != '') ? $cellWidth : 0;
	}
	function toHTML() {
		if ($this->class) { $class = ' class="'.$this->class. '"'; }
		if ($this->cellWidth != '') { $width= ' width="'. $this->cellWidth. '"'; }		
		if ($this->cellAlign != '') { $align= ' align="'. $this->cellAlign. '"'; }
		return '
			<td valign="top"'. $class. $width. $align. '>'. stripslashes($this->data). '</td>';
	}
}

// supporting class
class grid_th {
	var $class='';
	function grid_th($data) {
		$this->data = $data;
	}
	function toHTML() {
		if ($this->class) { $class = " class='".$this->class."'"; }
		return '
			<th valign="top"'. $class. '>'. $this->data. '</th>';
	}
}


// used to add 'input filter' functionality
// to let people filter based on freeform input 
// assigned to a column
//
// examples

/*
$x = new searchGrid();
$x->addInputFilter("Teacher Name","teacherName");
$x->toHTML();
*/

class searchGrid extends datagrid {

	var $inputFilters;	// array of columns to filter on
	var $inputFilterVar = "dgInputFilter";		// column of input filter
	var $inputFilterVal = "dgInputFilterText" ;	// value of input Filter
	var $topNav = 'true'; // will be set to false after getNavTable is called
	
	# holds all of the select filters in one array
	var $selectFilters = array();

	# html to put at the bottom of the datagrid before the close form tag
	var $footer = '';

	function setFooter( $footer ) {
		$this->footer = $footer;
	}

	function drawSelectFilter( $columnName) {
		$arr = array( '' => 'All' ) + $this->selectFilters[$columnName];
		unset( $arr['!displayName'] );
		return makeOptions( $arr, $this->postvars['selectfilter'][$columnName] );
	}


// add an input filter 
	function addInputFilter($displayName, $columnName, $exact=false, $type='string') { // type may be used later
		$x['displayName'] = $displayName;
		$x['columnName'] = $columnName;
		$x['type'] = $type;
		$x['exact'] = $exact;
		$this->inputFilters[] = $x;
	}

// draw the option box for input filter

	function drawInputFilter() {
		global $lcObj;
		if (!is_array($this->inputFilters)) return;

		reset($this->inputFilters);
		while(list($k,$v) =each($this->inputFilters)) {
			$opt[$v['columnName']] = $v['displayName'];
		}
		$j = makeOptions($opt, $lcObj->postvars['dgInputFilter']);
		return $j;
	}

	function _getPageDropdown($pageCurrent, $pageTotal)
	{
		$pageCurrent++;
		$select_text = '';
		
		if ($pageTotal > 1)
		{
			$select_text = '
			<select name="dgStart" onchange="document.datagrid.action = \''.$this->baseurl."/".$this->startVar."='+(this.value-1)+'"."/{$this->sortVar}={$this->orderby}/{$this->sortOrderVar}={$this->sort_order}".'\'; document.datagrid.submit(); ">';
			
			for ($i=1; $i <= $pageTotal; ++$i)
			{
				$select_text .= '
				<option value="'.$i.'"';
				
				if ($pageCurrent == $i)
				{	$select_text .= ' selected';
				}
				
				$select_text .= '> '. $i. '</option>';
				
			}
			$select_text .= '
			</select>';
			
		} else
		{	
			if ($pageTotal >0)
			{	$select_text = $pageCurrent;
			} else
			{	$select_text = 0;
			}
			
		}
		
	return $select_text;
	}

// overrides datagrid::getNavTable, which draws the page 1 of x and fwd/next buttons
// input filter box goes above

	function getNavTable() {

		global $lcObj;
		include_once(LIB_PATH.'LC_html.php');
		
		$cols = 0;
		$total_pages = (int)ceil($this->_totalRows/$this->rowsPerPage);
		if ( $this->topNav ) $j .= '<form action="'.modurl($this->name_service).'" method="post" name="datagrid">';
		$j .= '<table border=0 cellpadding="2" cellspacing="0" class="'. $this->navClass. '" width="'. $this->width.'">';

		if ( $this->topNav ) { // don't print this the second time around

		if ( count($this->inputFilters) || count($this->selectFilters) ) 
		{
			$j .= '<tr><td colspan=2>'
				.'<b>Select search type:</b> &nbsp;&nbsp;';

			if ( count($this->inputFilters) && count($this->selectFilters) ) {
				$j .= '<u onclick="getElementById(\'filterresults\').style.display=\'block\';">Filter</u> &nbsp; '
					.'/ &nbsp; <u onclick="getElementById(\'searchresults\').style.display=\'block\';">Search</u>';
			} else if ( count($this->inputFilters) ) {
				$j .= '<u onclick="getElementById(\'searchresults\').style.display=\'block\';">Search</u>';
			} else {
				$j .= '<u onclick="getElementById(\'filterresults\').style.display=\'block\';">Filter</u>';
			}

			if ( count($this->selectFilters) ) {
				$j .= '<div id="filterresults" style="padding-top:5px;display: '.(count($lcObj->postvars['selectfilter']) ? 'block' : 'none').';">'
					.'<FIELDSET style="padding:5px;">'
					.'<LEGEND><b>Filter results ( <u onclick="getElementById(\'filterresults\').style.'
					.'display=\'none\';">Hide</u> )</b></LEGEND>';
				foreach ( $this->selectFilters as $columnName => $arr ) {
					$filts[] = '<b>'.$this->selectFilters[$columnName]['!displayName'].':</b> '
						.'<select name="selectfilter['.$columnName.']">'.$this->drawSelectFilter($columnName).'</select>';
				}
				$filts[] = '<input type="submit" value="Filter">';
				$j .= htmlTable($filts, 3, '', '', 2, 0, 0, 'left')
					.'</fieldset></div>';
			}

			if ( count($this->inputFilters) ) {
				$j .= '<div id="searchresults" style="padding-top:5px;display: '.($lcObj->postvars['dgInputFilterText'] ? 'block' : 'none').';">'
					.'<FIELDSET style="padding:5px;">'
					.'<LEGEND><b>Select search criteria ( <u onclick="getElementById(\'searchresults\').style.'
					.'display=\'none\';">Hide</u> )</b></LEGEND>';

				$cell[] = "<select name='{$this->inputFilterVar}'>".$this->drawInputFilter()."</select>";
				$cell[] = "<input type='text' name='{$this->inputFilterVal}' value='{$lcObj->postvars['dgInputFilterText']}' maxlength='15' size='10'>";
				$cell[] = "<input type='submit' value='Go'>";
				$j .= htmlTable($cell, 3, '', '', 2, 0, 0, 'left', 'bottom');
				$j .= "</fieldset></div>";
			}

			$j .= "</td>";
			$j .= '</tr>';
		}

			$this->topNav = false;
			$printedFilters = true;
		} // if $this->topNav

		$j .= '
		<tr>
			<td>Page '.
		(($this->use_pagedropdown) ? $this->_getPageDropdown($this->startPage, (int)ceil($this->_totalRows/$this->rowsPerPage)) :
		(($total_pages == 0) ? 0 : ($this->startPage+1))
		).' of '. (int)ceil($this->_totalRows/$this->rowsPerPage).'</td>
			<td align="right">';
		if ($this->showNavLinks) { 
		$j .= "{$this->beginpage} &nbsp; {$this->prevpage} &nbsp; {$this->nextpage} &nbsp; {$this->lastpage}";
		}
		$j .= '</td>
		</tr>
		</table>
		'.($printedFilters ? '' : $this->footer.'</form>' );
		return $j;		
	}

// init is overridden, but calls parent
// functionality - we're only adding on extra functionality
// clarifying the where clause based on the posted info we may have
// from the input filter box(es)

	function init() {
		parent::init();

		if ($this->postvars[$this->inputFilterVal]) { 

			foreach ( $this->inputFilters as $key => $arr ) {

				if ( $arr['columnName'] == $this->postvars[$this->inputFilterVar] ) {

					$word = $this->where ? 'and' : 'where';


// mgk 10/31/03
if ($arr['columnName']=="hdtext") { // helpdesk specific
	$this->where .= " where hd_incident_log.comment like '%".$this->postvars[$this->inputFilterVal]."%'";
	$this->joins = " left join hd_incident_log on hd_incident_log.helpdesk_id=hd_incident.helpdesk_id "; 
} else { 

					if ( $arr['exact'] ) {
						$this->where .= " $word ".$this->postvars[$this->inputFilterVar].'="'
							.$this->postvars[$this->inputFilterVal].'"';
					} else {
						$this->where .= " $word ".$this->postvars[$this->inputFilterVar].' like "%'
							.$this->postvars[$this->inputFilterVal].'%"';
					}
}


				}
			}
		}

		foreach ( $this->postvars['selectfilter'] as $columnName => $val ) {
			if ( !$val ) continue;  // they're probably on "All"
			if ($this->where) {
				$this->where .= " and $columnName='$val' ";
			} else {
				$this->where .= "where $columnName='$val' ";
			}
		}

	}


	/*** FILTERS ***/

	# Faculty Drop down filter
	function addInstructorSelectFilter($displayName, $columnName)
	{
		$db = DB::getHandle();
		$db->RESULT_TYPE = MYSQL_ASSOC;
		$sql = 'select u.username, p.firstname, p.lastname from lcUsers as u
			left join profile as p on p.username=u.username
			where u.userType='.USERTYPE_FACULTY.'
			order by p.lastname';
		$db->query($sql);
		while( $db->next_record() ) {
			$this->selectFilters[$columnName][$db->Record['username']] = $db->Record['lastname'].', '.$db->Record['firstname'];
		}
		$this->selectFilters[$columnName]['!displayName'] = $displayName;
	}

	# Course familynumber drop down filter
	function addCourseFamilyNumberSelectFilter($displayName, $columnName)
	{
		$db = DB::getHandle();
		$db->RESULT_TYPE = MYSQL_ASSOC;
		$sql = 'select distinct concat(courseFamily, courseNumber) as courseFamilyNumber,
			id_courses from courses order by courseFamily, courseNumber';
		$db->query($sql);
		while ( $db->next_record() ) {
			$this->selectFilters[$columnName][$db->Record['id_courses']] = $db->Record['courseFamilyNumber'];
		}
		$this->selectFilters[$columnName]['!displayName'] = $displayName;
	}

	# classType field of courses table
	function addClassTypeSelectFilter($displayName, $columnName)
	{
		$db = DB::getHandle();
		$db->RESULT_TYPE = MYSQL_ASSOC;
		$sql = 'select distinct classType from classes';
		$db->query($sql);
		while ( $db->next_record() ) {
			$this->selectFilters[$columnName][$db->Record['classType']] = $db->Record['classType'];
		}
		$this->selectFilters[$columnName]['!displayName'] = $displayName;
	}

	# classType field of courses table
	function addCourseFamilySelectFilter($displayName, $columnName)
	{
		$db = DB::getHandle();
		$db->RESULT_TYPE = MYSQL_ASSOC;
		$sql = 'select distinct courseFamily from courses';
		$db->query($sql);
		while ( $db->next_record() ) {
			$this->selectFilters[$columnName][$db->Record['courseFamily']] = $db->Record['courseFamily'];
		}
		$this->selectFilters[$columnName]['!displayName'] = $displayName;
	}

	# Status filter. 1=New, 2=Pending, 3=Approved, 4=Waiting on instructor
	function add4StatusSelectFilter($displayName, $columnName)
	{
		$this->selectFilters[$columnName] = array(
			1 => 'New',
			2 => 'Pending',
			3 => 'Approved',
			4 => 'Waiting on instructor',
			'!displayName' => $displayName
		);
	}

	# Status filter. 1=Pending, 2=Approved (presentations)
	function add2StatusSelectFilter($displayName, $columnName)
	{
		$this->selectFilters[$columnName] = array(
			1 => 'Pending',
			2 => 'Approved',
			'!displayName' => $displayName
		);
	}

	# "Semester" filter.
	function add4SeminarSelectFilter($displayName, $columnName)
	{
		$this->selectFilters[$columnName] = array(
			1 => 'Semester 1',
			2 => 'Semester 2',
			3 => 'Semester 3',
			4 => 'Semester 4',
			'!displayName' => $displayName
		);
	}
	
	# "Technician" filter for Helpdesk
	function addTechnicianSelectFilter($displayName, $columnName, $table='helpdesk_incident')
	{
		$db = DB::getHandle();
		$db->RESULT_TYPE = MYSQL_ASSOC;
		$sql = 'select distinct assigned_to from '.$table.' order by assigned_to';
		$db->query($sql);
		while ( $db->next_record() ) {
			$this->selectFilters[$columnName][$db->Record['assigned_to']] =
				$db->Record['assigned_to'];
		}
		$this->selectFilters[$columnName]['!displayName'] = $displayName;
	}

  /**
  * addOwnerSelectFilter
  *
  * Added filter by owner to address issues in help desk ticket 493. Also
  * ordered by username for readability.
  *
  * @author Joe Stump <joe@joestump.net> 
  * @access public
  * @return void
  */
	function addOwnerSelectFilter($displayName, $columnName, $table='helpdesk_incident')
	{
		$db = DB::getHandle();
		$db->RESULT_TYPE = MYSQL_ASSOC;
		$sql = 'select distinct userid from '.$table.' order by userid';
		$db->query($sql);
		while ( $db->next_record() ) {
			$this->selectFilters[$columnName][$db->Record['userid']] =
				$db->Record['userid'];
		}
		$this->selectFilters[$columnName]['!displayName'] = $displayName;
	}

	function addHelpdeskStatusFilter($displayName, $columnName, $table='helpdesk_status')
	{
		$db = DB::getHandle();
		$db->RESULT_TYPE = MYSQL_ASSOC;
		$sql = 'select helpdesk_status_id, helpdesk_status_label from '.$table;
		$db->query($sql);
		while ( $db->next_record() ) {
			$this->selectFilters[$columnName][$db->Record['helpdesk_status_id']] = $db->Record['helpdesk_status_label'];
		}
		$this->selectFilters[$columnName]['!displayName'] = $displayName;
	}
	
	function addHelpdeskTicketCategoryFilter($displayName, $columnName,$table='helpdesk_categories')
	{
		$db = DB::getHandle();
		$db->RESULT_TYPE = MYSQL_ASSOC;
		$sql = "select * from $table order by helpdesk_category_label ASC";
		$db->query($sql);
		while ( $db->next_record() ) {
			$this->selectFilters[$columnName][$db->Record['helpdesk_category_id']] = $db->Record['helpdesk_category_label'];
		}
		$this->selectFilters[$columnName]['!displayName'] = $displayName;
	}
}

class questionPoolGrid extends SearchGrid {

	function headers() {
		$this->baseURL();
		if (is_array($this->headerNames)) {
			while(list($k,$v) = each($this->headerNames)) {
				if ($this->headers[$v]) { 
					$this->headerNames[$k] = $this->headers[$v];
				}
				if (in_array($v,$this->sortColumns)) { 

					$x = "<a href=\"#\" onClick=\"document.datagrid.action='".$this->baseurl."/{$this->startVar}={$this->startPage}/".$this->sortVar."=$v/".$this->sortOrderVar.'='.(($this->sort_order == 'DESC' ) ? 'ASC' : 'DESC' )."'; document.datagrid.method='POST'; document.datagrid.submit(); return false;\">".$this->headerNames[$k]."</a>";
					$this->headerNames[$k] = $x;
				}
			}
			$this->ignorePrePost = true;
			$h =$this->arrayToRow($this->headerNames, true);
			$h->class= $this->headerClass;
			$this->headerHTML = $h->toHTML();
			
		}

		
		if ($this->startPage > 0) { // previous
			$this->beginpage = "<a href=\"".$this->baseurl."/".$this->startVar."=0/{$this->sortVar}={$this->orderby}/{$this->sortOrderVar}={$this->sort_order}\" onClick=\"document.datagrid.action=this.href; document.datagrid.method='POST'; document.datagrid.submit(); return false;\">{$this->beginpage}</a>";
			$this->prevpage = "<a href=\"".$this->baseurl."/".$this->startVar."=".($this->startPage -1)."/{$this->sortVar}={$this->orderby}/{$this->sortOrderVar}={$this->sort_order}\" onClick=\"document.datagrid.action=this.href; document.datagrid.method='POST'; document.datagrid.submit(); return false;\">{$this->prevpage}</a>";
		} else
		{
			$this->beginpage = str_replace('prevprev.gif', 'noprevprev.gif', $this->beginpage);
			$this->prevpage = str_replace('prev.gif', 'noprev.gif', $this->prevpage);
		
		}
		
		if ($this->startPage < $this->_totalPages) { // previous
			$this->lastpage = "<a href=\"".$this->baseurl."/".$this->startVar."=".$this->_totalPages."/{$this->sortVar}={$this->orderby}/{$this->sortOrderVar}={$this->sort_order}\" onClick=\"document.datagrid.action=this.href; document.datagrid.method='POST'; document.datagrid.submit(); return false;\">{$this->lastpage}</a>";
			$this->nextpage = "<a href=\"".$this->baseurl."/".$this->startVar."=".($this->startPage +1)."/{$this->sortVar}={$this->orderby}/{$this->sortOrderVar}={$this->sort_order}\" onClick=\"document.datagrid.action=this.href; document.datagrid.method='POST'; document.datagrid.submit(); return false; \">{$this->nextpage}</a>";
		} else
		{ 
			$this->lastpage = str_replace('nextnext.gif', 'nonextnext.gif', $this->lastpage);
			$this->nextpage = str_replace('next.gif', 'nonext.gif', $this->nextpage);
		}
		if ($this->_totalPages<0) { 
			$this->beginpage='';
			$this->lastpage='';
			$this->prevpage = '';
			$this->nextpage='';
		}
	}
}
?>
