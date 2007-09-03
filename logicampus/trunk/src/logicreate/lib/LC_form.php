<?


/****
 * Form Manager
 * Author: Keith Elder (keith@tapinternet.com)
 * Last Updated:  5.26.03
 * Description:
 * This class is a library that can used to generate dynamic forms.
 * There are several ways to use this library. The standard way to use
 * this library in LogiCreate is as follows:
 * 
 * $f = new form();
 * $f->getForm(100, $arg->postvars);
 * $t['form'] = $f->ToHTML();
 * 
 * The above code assumes you are using the object with the HTML form
 * manager in Hercules.  The first parameter to getForm() is the form
 * ID in the database.  The getForm() can be passed a number or a
 * string of the form you want to load up from the database.  (note,
 * if you are passing a number DO NOT surround it in quotes or it will
 * evaluate the param as a string and will break.  
 * 
 * Each function that renders a form element typically has a three
 * functions.  
 * 
 * 1) 'add'.$formType (example: addText) - these functions
 * are functions which generate a form element statically.  As of
 * right now you will find some of these forms missing.  Mainly
 * because it is easier to rely on the interface to build forms and
 * form validation.  If you use thesee functions then you cannot use
 * the built in form validation.  
 * 
 * 2) 'gen'.$formType (example
 * genText) - these functions are used to generate *just* the form
 * element without surrounding HTML.  These were built primarily to
 * allow multiple forms elements to be included on the same row as
 * another element.  
 * 
 * 3) $formType.'ToHTML' (example: textToHTML) -
 * is called from the ToHTML() dynamically depending on what kind of
 * form element based on the "type" field in the lcForms DB table.  
 * 
 * 
 *      **** lcForms Table ****
 *  pkey  = primary key
 *  formId  =  pkey from lcFormInfo table
 *  type = stores the type of form element (text, radio, textarea)
 *  fieldName = the name of the form field
 *  displayName = Text the end user sees for that form element
 *  defaultValue  = Used to populate the form with a default value
 *  exp  = 
 *  validationType  = needs *default* to be set minimally, but you can
 *  use other ones such as email or write your own validation handles
 *  in your own subclass
 *  message = shown underneath the form field as help information
 *  stripTags = Y / N, calls the strip_tags()
 *  allowedTags = passes optional param to strip_tags()  
 *  min = minimum chars allowed (used in the default validation
 *  function
 *  max = maximum chars allowed (used in the default validation
 *  function
 *  req = Y / N, is the field required (places a '*' in front of the
 *  Display Name if it is required.
 *  sort = Used by the sort routine in the control center
 *  size = Various fields use this which require a size option
 *  maxlength = Use by various elements that have a maxlength option
 *  selectOptions = Stores select drop down options as key=val,key=val
 *  checked  = Y / N, used on check boxes 
 *  multiple  = Y / N, used in select elements
 *  useValue = Y / N, used in select elements to switch the key/val
 *  pairs
 *  cols = Number of columns for textareas
 *  rows = Number of rows for textareas
 *  image = (not implemented)
 *  parentPkey  = (not used right now)
 *  rowStyle = (not implemented, going to be used to change styles on
 *  each row
 *  groups = (not implemented)
 *  notgroups = (not implemented)
 *  row = (not implemented, going to be used to associate multiple
 *  elements on the same row
 *  startYear = Used on the dateDropDown()
 *  endYear = Used on the dateDropDown()
 *  dateTimeBit = 1, 2, 4, 8, 16, 32, used to build different options
 *  extra = Used for custom fields
 *
 *
 *  **** FORM VALIDATION ****
 *
 * The library has built in form validation that makes validating
 * forms easy.  
 * 
 * Example:
 * 
 * $f = new form();
 * $t['error'] = $f->validate(100, $arg->postvars);
 * # take the cleaned input to pass it back to populate the form
 * $this->cleanedArray = $f->cleanedArray;
 * if ($t['error'])
 * {
 *   $this->run($db, $u, $lc, $t);
 * }
 *
 * The validate() takes two params:  1) the form ID, 2) the post vars 
 * The first thing the validate() does is cleans the input and then
 * validates each field based on the 'validateType' specified in the
 * database.  The default validation is used the most and it checks
 * the minimum and maximum lengths and also the eregi expression
 * (which needs more work).  If you need more validation methods then
 * put those in your sub class or SiteForms.php.
 ****/
 
	class Form {
		
		var $data = array();  	#stores an array of data for current form 
    	var $action; 	#stores form action
    	var $method;  	#stores form method
		var $name;		#stores form name
		var $dataObject; #data object for persistent object?
		var $target; 	#stores form target
		var $enctype;	#stores encoding type
		var $rowStyle; 	# corresponding style for each row (only used on rows right now)
		var $border = 0;		# table params
		var $cellpadding = 1;	# table params
		var $cellspacing = 4;	# table params
		var $width = '100%';	# table params
		var $userGroups = array();  # groups the user has
		var $groups = array();   # groups allowed to view form
		var $notgroups = array();  # exclusion of groups allowed to view form
		var $lvalign = "top";  # left vertical alignment
		var $rvalign = "top";  # right vertical alignment
		var $cssLeft = '';  # Left style sheet
		var $cssRight = ''; # Right style sheet
		var $requiredMessage = '*denotes a required field';
		var $showRequiredMessage = false; // (boolean) Should we bother to show denotes a required field *above*
		var $message; #array();   #Used to put specific messages on specific rows $f->addMessage($row, $msg);
		var $cleanedArray = array();
		var $APP; # used to build the URLs for links
		var $PIC;  #used for image path
		var $error = false;  # boolean, true / false, used for validatation

		# if set to true, fields will be validated based on groups
		# you must set this to false if you are writing in the control
		# center
		var $fieldPermissions = true; 

		# If set to true, it will strip slashses while cleaning the input
		var $stripslashes = false;
		
		# Groups is an array of the groups
		# from the user object
		# Constructor
		function form ($groups='')
		{
			if (is_array($groups))
			{
				$this->userGroups = $groups;
			}
			$this->APP = _APP_URL.'formMgr/';
			$this->PIC = _PICS_URL;
		}
	
		/*
		 * TEXT INPUT METHODS
		 */
		function addText($name, $displayName, $defaultValue='', $size='', $maxlength='', $groups=array('public'), $row='')
		{
			$ar = array("type"=>"text", "fieldName"=>$name, "displayName"=>$displayName, "defaultValue"=>$defaultValue, "size"=>$size, "maxlength"=>$maxlength, "row"=>$row, "groups"=>$groups);
			$this->addToRow($row, $ar);
		}

		function genText($v)
		{	
			
			$HTML = '<input type="text" id="'.$v['fieldName'].'" name="'.$v['fieldName'].'" value="'.$v['defaultValue'].'" size="'.$v['size'].'" maxlength="'.$v['maxlength'].'">';
			return $HTML;
		}

		function textToHTML($v)
		{
			# If there is a message for this name, print it underneath the form tag
			#print_r($v);
			if ($v['message'] != '')
			{
				$msg = '<div style="font-size=80%;">'.$v['message'].'</div>';
			}
							
			if ($v['req'] == 'Y') { $ast = '*'; };
			$HTML = '<tr><td valign="'.$this->lvalign.'" class="'.$this->cssLeft.'">'.$ast.$v['displayName'].'</td>';
			$HTML .= '<td valign="'.$this->rvalign.'" class="'.$this->cssRight.'">';
			$HTML .= '<input type="text" id="'.$v['fieldName'].'" name="'.$v['fieldName'].'" value="'.$v['defaultValue'].'" size="'.$v['size'].'" maxlength="'.$v['maxlength'].'">';
			$HTML .= $msg.'</td></tr>';
			$HTML .= "\n";
			return $HTML;
		}	

		/*
		 * FILE UPLOAD METHODS
		 */

		function addFile($name, $displayName, $defaultValue='', $size='', $groups=array('public'), $row='')
		{
			$ar = array("type"=>"file", "fieldName"=>$name, "displayName"=>$displayName, "defaultValue"=>$defaultValue, "size"=>$size, "row"=>$row, "groups"=>$groups);
			$this->addToRow($row, $ar);
		}
				
		
		function genFile($v)
		{	
			
			$HTML = '<input type="file" id="'.$v['fieldName'].'" name="'.$v['fieldName'].'" value="'.$v['defaultValue'].'" size="'.$v['size'].'">';
			return $HTML;
		}		
		
		function fileToHTML($v)
		{
			# If there is a message for this name, print it underneath the form tag
			#print_r($v);
			if ($v['message'] != '')
			{
				$msg = '<div style="font-size=80%;">'.$v['message'].'</div>';
			}
							
			if ($v['req'] == 'Y') { $ast = '*'; };
			$HTML = '<tr><td valign="'.$this->lvalign.'" class="'.$this->cssLeft.'">'.$ast.$v['displayName'].'</td>';
			$HTML .= '<td valign="'.$this->rvalign.'" class="'.$this->cssRight.'">';
			$HTML .= '<input type="file" id="'.$v['fieldName'].'" name="'.$v['fieldName'].'" value="'.$v['defaultValue'].'" size="'.$v['size'].'">';
			$HTML .= $msg.'</td></tr>';
			$HTML .= "\n";
			return $HTML;
		}		

		/* 
		 * TEXTAREA METHODS
		 */
		function addTextArea($name, $displayName, $cols, $rows, $defaultValue='', $groups=array('public'), $row='')
		{
			$ar = array("type"=>"textarea", "fieldName"=>$name, "displayName"=>$displayName, "defaultValue"=>$defaultValue, "cols"=>$cols, "rows"=>$rows, "req"=>$req, "row"=>$row, "groups"=>$groups);
			$this->addToRow($row, $ar);
		}


		function gentextArea($v)
		{
			$HTML = '<textarea id="'.$v['fieldName'].'" name="'.$v['fieldName'].'" cols="'.$v['cols'].'" rows="'.$v['rows'].'">'.$v['defaultValue'].'</textarea>';
			return $HTML;
		}

		function textAreaToHTML($v)
		{
			static $in=2200;
			
			if ($v['message'] != '')
			{
				$msg = '<div style="font-size=80%;">'.$v['message'].'</div>';
			}
			
			if ($v['req'] == 'Y') { $ast = '*'; };
			$HTML = '<tr><td valign="'.$this->lvalign.'" class="'.$this->cssLeft.'" valign="top">'.$ast.$v['displayName'].'</td><td valign="'.$this->rvalign.'" class="'.$this->cssRight.'">';
			$HTML .= '<table cellpadding="0" cellspacing="0" border="0"><tr><td><textarea name="'.$v['fieldName'].'" cols="'.$v['cols'].'" rows="'.$v['rows'].'" id="'.$v['fieldName'].'">'.$v['defaultValue'].'</textarea>';


			/*
			if ($v['extra'] == 'E')
				$HTML .='<img src="'.IMAGES_URL.'wysig-help.gif" align="right">Toolbar buttons can access your File Resources.';
			 */
			$HTML .= '</td></tr></table>';
			$HTML .= "\n";
			$HTML .= $msg.'</td></tr>';
			$HTML .= "\n";

			/*  We use the extra column to turn on or off the WYSIWYG
			 *  editor
			 */
			if ($v['extra'] == 'L')
			{
				$resize_script = '';
				if ($v['cols'] < 70)
				{	$resize_script = '
					document.getElementById(\''.$v['fieldName'].'\').style.width = \'565\';
					';
				}
				
				$HTML .= '
				<script type="text/javascript" src="'.appurl('js/').'"></script>
				<script>
				function WYS'.$v['fieldName'].'()
				{
				'.$resize_script.'
				/** Wysiwyg loader */
				x'. $v['fieldName'].' = new HTMLArea("'.$v['fieldName'].'");
				x'.$v['fieldName'].'.config.editorURL = "'. BASE_URL.'htmlarea/";
				
				x'. $v['fieldName'].'.config.toolbar =[
					[ "bold", "italic", "underline" ],
					[ "strikethrough", "subscript", "superscript", "separator" ],
					[ "copy", "cut", "paste", "space", "undo", "redo", "separator", "linebreak" ],
					[ "justifyleft", "justifycenter", "justifyright", "justifyfull", "separator" ],
					[ "insertorderedlist", "insertunorderedlist", "outdent", "indent", "separator" ],
					[ "inserthorizontalrule", "createlink", "inserttable", "htmlmode", "popupeditor" ]
					];
				
				x'.$v['fieldName'].'.generate();
				}
				
				
				setTimeout(\'WYS'.$v['fieldName'].'()\', '.$in.');
				</script>';
				
				$in =$in+1500;
			}
			if ($v['extra'] == 'S')
			{
				$resize_script = '';
				if ($v['cols'] < 70)
				{	$resize_script = '
					document.getElementById(\''.$v['fieldName'].'\').style.width = \'565\';
					';
				}
				
				$HTML .= '
				<script type="text/javascript" src="'.appurl('js/').'"></script>
				<script>
				function WYS'.$v['fieldName'].'()
				{
				'.$resize_script.'
				/** Wysiwyg loader */
				x'. $v['fieldName'].' = new HTMLArea("'.$v['fieldName'].'");
				x'.$v['fieldName'].'.config.editorURL = "'. BASE_URL.'htmlarea/";
				
				x'.$v['fieldName'].'.generate();
				}
				
				
				setTimeout(\'WYS'.$v['fieldName'].'()\', '.$in.');
				</script>';

				$in =$in+1500;

			}

			if ($v['extra'] == 'E')
			{
				$resize_script = '';
				if ($v['cols'] < 70)
				{	$resize_script = '
					document.getElementById(\''.$v['fieldName'].'\').style.width = \'565\';
					';
				}
				
				$HTML .= '
				<script type="text/javascript" src="'.appurl('js/').'"></script>
				<script>
				function WYS'.$v['fieldName'].'()
				{
				'.$resize_script.'
				/** Wysiwyg loader */
				x'. $v['fieldName'].' = new HTMLArea("'.$v['fieldName'].'");
				x'.$v['fieldName'].'.config.editorURL = "'. BASE_URL.'htmlarea/";
				
				x'. $v['fieldName'].'.config.registerButton("insertdoclibimage", "Web Images", "doclib.gif", false, function(e) { e.execCommand("insertdoclibimage"); }); 
				x'. $v['fieldName'].'.config.toolbar.push(["separator", "insertdoclibimage"]);
				
				x'. $v['fieldName'].'.config.registerButton("insertdoclibcontentlinks", "Classroom Documents", "doccontentlib.gif", false, function(e) { e.execCommand("insertdoclibcontentlinks"); }); 
				x'. $v['fieldName'].'.config.toolbar.push(["separator", "insertdoclibcontentlinks"]);
				
				x'. $v['fieldName'].'.config.registerButton("insertcontentlinks", "Content Pages", "content.gif", false, function(e) { e.execCommand("insertcontentlinks"); }); 
				x'. $v['fieldName'].'.config.toolbar.push(["separator", "insertcontentlinks"]);
				
				x'. $v['fieldName'].'.config.registerButton("insertswf", "Insert .SWF", "flash.gif", false, function(e) { e.execCommand("insertswf"); }); 
				x'. $v['fieldName'].'.config.toolbar.push(["separator", "insertswf"]);

				x'.$v['fieldName'].'.generate();
				}
				
				
				setTimeout(\'WYS'.$v['fieldName'].'()\', '.$in.');
				</script>';
				
				$in =$in+1500;
			}
			
			return $HTML;
		}
	
		/*
		 * HIDDEN METHODS
		 */
		function addHidden($name, $defaultValue='', $groups=array('public'), $row='')
		{
			$ar = array("type"=>"hidden", "fieldName"=>$name, "defaultValue"=>$defaultValue, "groups"=>$groups);
			$this->addToRow($row, $ar);
		}
		
		function genHidden($v)
		{
			#print_r($v);
			#exit();
			$HTML .= "\n";
			$HTML = '<input type="hidden" name="'.$v['fieldName'].'" value="'.$v['defaultValue'].'">';
			$HTML .= "\n";
			return $HTML;
		}
	
		function hiddenToHTML($v)
		{
			#debug($v);
			$HTML .= "\n";
			$HTML = '<input type="hidden" name="'.$v['fieldName'].'" value="'.$v['defaultValue'].'">';
			$HTML .= "\n";
			return $HTML;
		}		
		
		/*
		 * SUBMIT METHODS
		 */
		function addSubmit($name, $defaultValue='', $image='', $groups=array('public'), $row='')
		{
			$ar = array("type"=>"submit", "fieldName"=>$name, "defaultValue"=>$defaultValue, "image"=>$image, "groups"=>$groups);
			$this->addToRow($row, $ar);
		}
		
		function submitToHTML($v)
		{
			$HTML = '<tr><td valign="'.$this->lvalign.'" class="'.$this->cssLeft.'">'.$v['displayName'].'</td><td valign="'.$this->rvalign.'" class="'.$this->cssRight.'">';
			$HTML .= '<input type="submit" id="'.$v['fieldName'].'" name="'.$v['fieldName'].'" value="'.$v['defaultValue'].'">';
			$HTML .= '</td></tr>';
			$HTML .= "\n";
			return $HTML;
		}
		
		/*
		 * RADIO BUTTON
		 */
		function addRadio($name, $defaultValue='', $image='', $groups=array('public'), $row='')
		{
			$ar = array("type"=>"reset", "fieldName"=>$name, "defaultValue"=>$defaultValue, "image"=>$image, "groups"=>$groups);
			$this->addToRow($row, $ar);
		}
		
		function radioToHTML($v)
		{
			# select values are stored in the database
			# as key=val, key2=val2, key3=val3, etc
			# this little snippet  breaks that
			# up into an array as key/value pairs
			if ($v['req'] == 'Y') { $ast = '*'; };
			$HTML = '<tr><td valign="'.$this->lvalign.'" class="'.$this->cssLeft.'">'.$ast.$v['displayName'].'</td><td valign="'.$this->rvalign.'" class="'.$this->cssRight.'">';
						
			$tmp = split(",", $v['selectOptions']);
			while (list($key, $val) = @each($tmp))
			{
				$z = split("=", $val);
				$newarray[$z[0]] = $z[1];
			}
			
			while ( list ($key,$val) = @each($newarray) ) {
				if ($v['defaultValue'] == $key) { $checked = 'checked'; }
				$HTML .= "	<input type=\"radio\" name=\"".$v['fieldName']."\" value=\"$key\" $checked> $val<br>\n";
				unset($checked);
			}			
			
			$HTML .= '</td></tr>';
			$HTML .= "\n";
			return $HTML;
		}		 
		 
		/*
		 * PASSWORD METHODS
		 */
		function addPassword($name, $displayName, $defaultValue='', $groups=array('public'))
		{
			$ar = array("type"=>"password", "fieldName"=>$name, "displayName"=>$displayName, "defaultValue"=>$defaultValue, "groups"=>$groups, "req"=>$req);
			$this->addToRow($row, $ar);
		}
		
		function passwordToHTML($v)
		{
			if ($v['message'] != '')
			{
				$msg = '<div style="font-size=80%;">'.$v['message'].'</div>';
			}
			
			if ($v['req'] == 'Y') { $ast = '*'; };
			$HTML = '<tr><td valign="'.$this->lvalign.'" class="'.$this->cssLeft.'">'.$ast.$v['displayName'].'</td><td valign="'.$this->rvalign.'" class="'.$this->cssRight.'">';
			$HTML .= '<input type="password" name="'.$v['fieldName'].'" value="'.$v['defaultValue'].'">';
			$HTML .= $msg.'</td></tr>';
			return $HTML;
		}
		
		/* 
		 * ROW METHODS
		 */

		# By default you can add a blank row to a form
		# Useful for separating a large form
		# also useful for instructions
		function addRow($title='', $css='', $groups=array('public'))
		{
			$ar = array("type"=>"Row", "defaultValue"=>$title, "rowStyle"=>$css, "groups"=>$groups);
			$this->addToRow($row, $ar);
		}

		# Used to grab the current row so you can
		# add a form to that same row.
		function getCurrentRow()
		{
			return	$num = count($this->data) -1;
			
		}
			
		function RowToHTML($v)
		{
			#debug($v);
			if ($v['defaultValue'] == '') {
				 $title = '&nbsp;';
			} else {
				$title = $v['defaultValue'];
			}
			$HTML = '<tr><td colspan="2" valign="'.$this->lvalign.'" class="'.$v['rowStyle'].'">'.$title.'</td></tr>';
			return $HTML;
		}	

		# Pass it the row number
		# you wish to add a form element to
		# Form elements that are on the same field as
		# other elements are placed on that row
		# with the methods starting with gen.
		function addToRow($row, $ar)
		{
			if (is_int($row))
			{
				#echo 'here<br>';
				$this->data[$row][] = $ar;	
			} else {
				#echo 'otherhere<br>';
				$this->data[][] = $ar;
			}
		}
		
	
		/***** 
		*  CHECK BOX METHODS
		*****/
				
		function addCheckBox($name, $displayName, $defaultValue, $checked='', $groups=array('public'), $row='')
		{
					
			if ($checked == 'Y') { $checked = 'checked'; }
			$ar = array("type"=>"checkbox", "fieldName"=>$name, "displayName"=>$displayName, "defaultValue"=>$defaultValue, "checked"=>$checked, "req"=>$req, "groups"=>$groups);
			$this->addToRow($row, $ar);

			#print_r($this->data);
		}

		function genCheckbox($v)
		{			
			
			#$name, $defaultValue, $checked='', $row=''
			$title = $v['message'];
			$HTML = ucfirst(strtolower($v['defaultValue'])) .' <input type="checkbox" name="'.$v['fieldName'].'" value="'.$v['defaultValue'].'" '.$v['checked'].'>';
			return $HTML;
		}

		function checkboxToHTML($v)
		{	
			if ($v['message'] != '')
			{
				$msg = '<div style="font-size=80%;">'.$v['message'].'</div>';
			}
			
			if ($v['checked'] == 'Y') { $checked = 'checked'; }
			if ($v['req'] == 'Y') { $ast = '*'; };
			$HTML = '<tr><td valign="'.$this->lvalign.'" class="'.$this->cssLeft.'">'.$ast.$v['displayName'].'</td><td valign="'.$this->rvalign.'" class="'.$this->cssRight.'">';
			$HTML .= '<input type="checkbox" id="'.$v['fieldName'].'" name="'.$v['fieldName'].'" '.$v['defaultValue'].' '.$checked.'>'. ucfirst(strtolower($v['defaultValue'])) ;
			$HTML .= $msg.'</td></tr>';
			return $HTML;
		}

		/* 
		 * SELECT METHODS
		 */
		function addSelect($name, $displayName, $array, $sel='', $multi='', $size='', $useValue=false, $groups=array('public'), $row='')
		{
			
			if ($multi == 'Y')
			{
				$multi = 'multiple';
			}
			
			$ar = array("type"=>"select", "fieldName"=>$name, "displayName"=>$displayName, "selectOptions"=>$array, "useValue"=>$useValue, "size"=>$size, "multiple"=>$multi, "sel"=>$sel, "req"=>$req, "row"=>$row, "groups"=>$groups);
			$this->addToRow($row, $ar);
		}
	
		function genSelect ($v) {
				
			#Set name to an array if multiple is passed
			
			if ($v['multiple'] == 'Y') {
				$x = '[]';
				$multiple = 'multiple';
			}
			
			# select values are stored in the database
			# as key=val, key2=val2, key3=val3, etc
			# this little snippet  breaks that
			# up into an array as key/value pairs
			$tmp = split(",", $v['selectOptions']);
			while (list($key, $val) = @each($tmp))
			{
				$z = split("=", $val);
				$newarray[$z[0]] = $z[1];
			}
			
			$HTML .= '<select id="'.$v['fieldName'].''.$x.'" name="'.$v['fieldName'].''.$x.'" '.$multiple.' size="'.$v['size'].'">';
			while ( list ($key,$val) = @each($newarray) ) {

				$optionval = $key;
				if ($v['useValue']) { $optionval = $val; }
				$HTML .= "	<option value=\"$optionval\"";
				#echo $v['sel'];
				if ($optionval == $v['defaultValue']) { $HTML .= " SELECTED "; }
				if (is_array($v['defaultValue']) && @in_array($optionval,$v['defaultValue']) ) { $HTML .= " SELECTED "; }
				$HTML .= ">$val</option>\n";
			}
			$HTML .= '</select>';
			return $HTML;
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
		function selectToHTML ($v) {
			#Set name to an array if multiple is passed
			#debug($v);
			if ($v['message'] != '')
				{
					$msg = '<div style="font-size=80%;">'.$v['message'].'</div>';
				} 
				
			if ($v['multiple'] == 'Y') {
				$x = '[]';
				$multiple = 'multiple';
			}
			
			# select values are stored in the database
			# as key=val, key2=val2, key3=val3, etc
			# this little snippet  breaks that
			# up into an array as key/value pairs
			
			# Remove spaces from $v['selectOptions']
			$v['selectOptions'] = eregi_replace(", ", ",", $v['selectOptions']);
			$tmp = split(",", $v['selectOptions']);
			while (list($key, $val) = @each($tmp))
			{
				$z = split("=", $val);
				$newarray[$z[0]] = $z[1];
			}
			#debug($newarray);
			if ($v['req'] == 'Y') { $ast = '*'; };
			$HTML = '<tr><td valign="'.$this->lvalign.'" class="'.$this->cssLeft.'">'.$ast.$v['displayName'].'</td><td valign="'.$this->rvalign.'" class="'.$this->cssRight.'">';
			$HTML .= '<select id="'.$v['fieldName'].''.$x.'" name="'.$v['fieldName'].''.$x.'" '.$multiple.' size="'.$v['size'].'">';
			while ( list ($key,$val) = @each($newarray) ) {

				$optionval = $key;
				if ($v['useValue'] == 'Y') { $optionval = $val; }
				$HTML .= "	<option value=\"$optionval\"";
				#echo $v['sel'];
				#echo "$optionval = ".$v['defaultValue']."<br>";
				if ($optionval == $v['defaultValue']) { $HTML .= " SELECTED "; }
				if ($optionval == $v['sel']) { $HTML .= " SELECTED "; }
				if (is_array($v['defaultValue']) && @in_array($optionval,$v['defaultValue']) ) { $HTML .= " SELECTED "; }
				$HTML .= ">$val</option>\n";
			}
			$HTML .= '</select>';
			$HTML .= $msg.'</td></tr>';
			return $HTML;
		}

		
		/******
		* DATE DROP DOWN METHODS
		******/
	
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
	
		function dateDropDownToHtml($v) {
		 
			if ($v['defaultValue']['ampm'] == 'PM')
			{	$v['defaultValue']['hours'] += 12;
			}
			/*
			This is the right way below but i need to test it
			if (($v['defaultValue']['ampm'] == 'PM' && $v['defaultValue']['hours'] != 12) || ($v['defaultValue']['ampm'] == 'AM' && $v['defaultValue']['hours'] == 12))
			{	$v['defaultValue']['hours'] += 12;
				if ($v['defaultValue']['hours'] >= 24)
				{	$v['defaultValue']['hours'] = '00';
				}
			}
			*/
			
			/**
			 * A simple detection system of the various prepopulation methods
			 *
			 *	1) determine if it's an array ( date[month] date[year])
			 *		a) easiest of them, use mktime
			 *	2) determine if it's not an array
			 *		a) determine if it's 0 or blank, which would mean a ".DB::getFuncName('NOW()')." (current datetime)
			 *		b) determine if it's completely numeric but not 0 (timestamp, or time())
			 *		c) last thing that could be sent is a string of information so we turn it to a time() (strtotime()) (works on database datetime or date fields)
			 *
			 *	NOTE: one thing i can't do, and i need your help in figuring this out keith
			 *		is when you are just using a YEAR dropdown or a MONTH
			 *		how do i convert that to a date (how do i knowit's a year or month to convert into a time/date?)
			 *
			 */			
			if (is_array($v['defaultValue']) == false)
			{	
				if ((int)$v['defaultValue'] == 0)
				{	
					$date = time();
					
				} elseif (is_numeric($v['defaultValue']))
				{	
					$date = $v['defaultValue'];
					
				} else
				{	
					$date = strtotime($v['defaultValue']);
				}
				
			} else
			{
				$date=mktime((int)$v['defaultValue']['hours'], (int)$v['defaultValue']['minutes'], 0, (int)$v['defaultValue']['month'],(int)$v['defaultValue']['day'], (int)$v['defaultValue']['year']);
			}
			
			$name=$v['fieldName'];
			$startyear= date('Y') + $v['startYear'];
			$endyear = $startyear + $v['endYear'];
			$bits = $v['dateTimeBit'];
			
			define (_MONTH,4);
			define (_DAY,2);
			define (_YEAR,1);
			define (_HOURS,8);
			define (_MINUTES,16);
			define (_12HOUR, 32);
			
			if ($endyear<$startyear) { $s = $startyear; $startyear = $endyear; $endyear = $s; }



			if ( $date != ""  &&  $date !="0000-00-00 00:00:00") {
				if ( (string)intval($date) != (string)$date) {
					$date = strtotime($date);
				} else { 
					$date = (int)$date;
				}
			} else {
				$date = time();
			}
			list ($newdate, $newtime) =  explode(" ", date("m-d-Y h:i:s:A",$date) );
			list($m, $d, $y) = explode("-", $newdate);
			list($h, $i, $s, $a) = explode(":", $newtime);


			$m = intval($m);
			$d = intval($d);
			$y = intval($y);
			$h = intval($h);
			$i = intval($i);
			$s = intval($s);
			
			if ($m == 0) { 
			$m = date("m");
			$d = date("d");
			$y = date("Y");
			$h = date("h");
			$i = date("i");
			$a = date("A");
			
			}
			
			# month is 4 bits
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
			                 
			    # days are 2 bits
			    for ($x=1; $x < 32; ++$x) {
			        $days[$x] = $x;
			    }
			    
			    # years is 1 bit
			    for ($x=$startyear; $x<= $endyear; ++$x) {
			        $years[$x] = $x;
			    }
			
			    # hours is 8 bits
			    for ($x=1; $x < 13; ++$x) {
			        $hours[$x] = $x;
			    }
			
			    # minutes is 16 bits
			    $mins[] = "00";
			    for ($x=5; $x < 60; $x+=5) {
			        $mins[$x] = $x;
			    }
			
			    # Build AM / PM array
			    $ampm['AM'] = 'AM';
			    $ampm['PM'] = 'PM';
			    
			if ($bits & _MONTH) {  
				$ret .= "<select name='".$name."[month]'>".Form::makeOptions($months,$m)."</select>\n";
			}
			
			if ($bits & _DAY) {  
				$ret .= "<select name='".$name."[day]'>".Form::makeOptions($days,$d)."</select>\n";
			}
			
			if ($bits & _YEAR) {  
				$ret .= "<select name='".$name."[year]'>".Form::makeOptions($years,$y)."</select>\n";
			}
			
			if ($bits & _HOURS) {  
				$ret .= "<select name='".$name."[hours]'>".Form::makeOptions($hours,$h)."</select>\n";
			}

			if ($bits & _MINUTES) {  
				$ret .= "<select name='".$name."[minutes]'>".Form::makeOptions($mins,$i)."</select>\n";
			}

			if ($bits & _12HOUR) {  
				$ret .= "<select name='".$name."[ampm]'>".Form::makeOptions($ampm,$a)."</select>\n";
			}
		
			if ($v['req'] == 'Y') $ast = '*';

			$HTML = '<tr><td valign="'.$this->lvalign.'" class="'.$this->cssLeft.'">'.$ast.$v['displayName'].'</td><td valign="'.$this->rvalign.'" class="'.$this->cssRight.'">';
			$HTML .= $ret;
			$HTML .= $msg.'</td></tr>';
			
			return $HTML;
			
		}

		
		
		/*****
		*  TO HTML METHODS
		*****/
		function ToHTML()
		{
			#debug($this);
			#debug($this->userGroups);
			#debug($this->groups);
			
			if (is_array($this->data))
			{	reset($this->data); // making sure we are starting in correct position
			}
			
			# Error checking for group permissions needs to be put in
			# not sure the best way to handle it
		
			$HTML = '<form action="'.$this->action.'" method="'.$this->method.'" enctype="'.$this->enctype.'">';
			$HTML .= "\n";
			$HTML .= '<table width="'.$this->width.'" border="'.$this->border.'" cellspacing="'.$this->cellspacing.'" cellpadding="'.$this->cellpadding.'">';
			foreach ($this->data as $k=>$v) 
			{
				# Check to see if the row has more than one form
				# if it does, we need to process it differently
				# $v is an array of form information, could be multiples

				# Need form field permission?
				if ($this->fieldPermissions)
				{
						if (count(array_intersect($v[0]['groups'], $this->userGroups) ) ==  0 )
						{
							// User is not allowed to see this field
							continue;
						}
				}
				if (count($v) >= 2)
				{
					#print_r($v);
								
					while (list($key, $val) = @each($v))
				 	{
						# See if the user has permission to view this
						# field
						if ($this->fieldPermissions)
						{
								if (count(array_intersect($this->userGroups, $val['groups']) ) == 0 )
								{
									// User is not allowed to see this field
									continue;
								}
						}
						#print_r($val);
				 		if ($val['req']) { $ast = '*'; }
				 		
				 		# put this in because sometimes you want to put two 
				 		# different fields on one row, if you do not put
				 		# anything in the DB, it will take the name of the first
				 		# field used
				 		if ($val['displayName'] != '')
				 		{  
				 			$title .= $ast.$val['displayName'].' / ';
				 		}
				 		
				 		#Check to see if a message was assigned to this row
				 		
				 		if (is_int($val['parentPkey']))
				 		{
				 			$msg = '<div style="font-size=80%;">'.$this->message[$val['parentPkey']].'</div>';
				 		}	
				 		
				 		$x = $val['type'];
						$y = 'gen'.$x;
						
						if (strtolower($y) == 'genrow')
						{
							echo "YOU CANNOT PUT ADD A ROW TO AN EXISTING ROW, CHECK YOUR SORTING ON YOUR FORM";
							exit();
						}
						
						$tmpForm .= $this->$y($val).' ';
						unset($ast);
				 	}
				 						 
				 	$title = substr($title, 0, -3);		
				 	#echo $tmpForm;
				 	
				 	#if ($v['row'] != '') {
				 	#echo $v['row'];
					
					#}
					
				 	$HTML .= '<tr><td valign="'.$this->lvalign.'" class="'.$this->cssLeft.'">'.$title.'</td><td valign="'.$this->rvalign.'" class="'.$this->cssRight.'">'.$tmpForm.' '.$msg.'</td></tr>';
					$HTML .= "\n";
				 	unset($tmpForm);
				 	unset($title);
				 	unset($msg);
				 	continue;
				}
			
				# Get rid of the [0] array
				$v = $v[0];
							
				/*
					I want to give the form a change to NOT show the "denoted fields" message
				 */
				if ($this->showRequiredMessage == false && $v['req'] == 'Y')
				{	$this->showRequiredMessage = true;
				}
				
				$tmp = $v['type'];
				#echo $func;
				$func = $tmp.'ToHTML';
				
				$HTML .= $this->$func($v);
				
			}		
			$HTML .= '</table></form>';
			
			if ($this->showRequiredMessage)
			{	$HTML .= '<div style="font-size: 85%">'.$this->requiredMessage.'</div>';
			}
			
			return $HTML;
		}


	
		# Used to return the title that is wanted on a certain form
		# Update lcFormTitles if a field you want is missing
		function getTitle($title)
		{
			#echo $title . $this->titles[$title]['val'].'<hr>';
			$title = strtolower($title);
			return  $this->titles[$title]['val'];
		}
		
		# Don't need this one anymore
		function getStyle($x)
		{
			return $this->rowStyle[$x];
		}
		
		function addStyle($x, $y)
		{
			$this->rowStyle[] = array($x, $y);
		}
	
		# Static class method to generate a form.
		# Needs finishing.  Just an idea, don't know
		# if it is worth finishing or not.
		function generateForm($arr, $mappings, $exclude, $s1, $s2) #s1, s2 are style sheets
		{
			$f = new form();
			while(list($k, $v) = @each($arr))
			{  
				
				if (in_array($k, array_keys($mappings)))
				{
					
					$type = $mappings[$k];
					$type = "add".$type;
					
					switch($type)
					{
						case "addTextArea";
						$f->addTextArea($k, 20, 10, $v);
						$f->addStyle($s1, $s2);
						break;
						
						case "addText";
						$f->addText($k, $v);
						$f->addStyle($s1, $s2);
						break;
											
					}
					reset($mappings);				
					continue;
				}
				
				# skip the exclusions array
				if (in_array($k, $exclude)) { continue; }
				
				# Otherwise make text inputs out of everything else
				$f->addText($k, $v);
				$f->addStyle($s1, $s2);
		}
		return $f;
		} 
		
		# This function expects to receive an array of fields
		# submitted from a form.  Normally in LC this will be $arg->postvars
		# $formId is the formId located in the lcForms table
		# This has to be a hidden field type in your form
		# to use this validation
		
		function validateForm($code, &$arr)
		{		
			#debug($code,1);
			$db = DB::getHandle();
						
			$sql = "select pkey from lcFormInfo where formCode='$code'";
			$db->queryOne($sql);
			$pkey = $db->Record['pkey'];
			
			$sql = "select * from lcForms where formId='$pkey'";
			
			$db->RESULT_TYPE = MYSQL_ASSOC;
			$db->query($sql);
			while ($db->next_record())
			{
				$tmp[$db->Record['fieldName']] = $db->Record;
				# take the groups and unserialize them
				# so we don't have to later on
				$tmp[$db->Record['fieldName']]['groups'] = unserialize($db->Record['groups']);
			}

			// making sure we are passing an array (just incase we pass an object for prepopulation
			if ( is_object($arr) ) $arr = $this->object2array($arr);
			
			$this->cleanedArray = $this->cleanInput($tmp, $arr);
#			$arr = $this->cleanedArray;
			#debug($tmp, 1);
			@reset($this->cleanedArray);
			while (list ($k, $v) = @each($tmp))
			{
				# Check if the user has access to a field
				# before we try to validate against it
				if ($this->fieldPermissions)
				{
						if (count(array_intersect($v['groups'], $this->userGroups) ) ==  0 )
						{
							# skip validation
							continue;
						}
				}
				# call validation routine on field
				$error .= $this->validate($k, $this->cleanedArray[$k], $v);
			}
			
			if ($error) {
				$this->error = TRUE;
				return lcMessageBox($error,'e');
			} else {
				$this->error = FALSE;
				return;
			}
			
		}

		# This function is called by validate Form
		# but could be called statically if desired	
		function validate($key, $val, $v)
		{
			
			# See if we already have a predefined validate function
			# for the called key.  If we do, run it instead of this one.
			# Mainly this was put in because of email handling but
			# could be used for other things.
			
			$type = $v['validationType'];

			#debug($v);
			#exit();
			# in case someone forgets to set the validation type to default
			if ($type == '') $type = 'default';
		
			$funcType = "validate".$type;

			
			# Check to see if we have a validation function
			# for the specific key being passed, example: email
		
			#echo $funcType.'<br>';
			if ( method_exists($this, $funcType))
				{
					
					# $v is an array of the record we are 
					# validating against in the database (min, max, exp, etc, req)
					# echo $funcType.'<br>';
					# We only need to validate required fields
					#debug($v);
					if ($v['req'] == 'Y')
					{
						$error = $this->$funcType($key, $val, $v);
					}
				} 
			
			if ($error)
				{
					return $error;
				} else {
					return;
				}
		}
		
		# All titles must at least be defined as type "default"
		# This default validation checks if the string is filled in
		# and that it matches the regular expression	
		# Other options can be "email" or selectMultiple as they
		# have different ways they are validated and produce different errors.
		function validateDefault($key, $val, $v)
		{ 
		
					#debug($val);
					# Check length
					
					if (strlen($val) < $v['min'] )
					{
						$error .= "<li>".$v['displayName'] ."&nbsp;needs to be at least <b>".$v['min'] ."</b> characters.<br>";
					}
					
					# Check length
					if (strlen($val) > $v['max'] )
					{
						$error .= "<li>".$v['displayName'] ."&nbsp;needs to be no longer than <b>".$v['max'] ."</b> characters.<br></li>";
					}
					
					# Check expression to make sure it matches
					# to see if it starts with a ^, if it does
					# we need to call !eregi instead of just eregi.

					if (@eregi("^\^", $v['exp']))
					{
						#echo "starts with ^";
						if (!@eregi($v['exp'], $val))
						{
							#echo "in the if";
							$error .= "<li>".$v['displayName'] ."&nbsp;contains <b>illegal</b> characters or is not in the desired format required.<br></li>";
						}
					} else if (trim($v['exp']) != '') {
						#echo "in the else";
						if (!@eregi($v['exp'], $val))
						{
							$error .= "<li>".$v['displayName'] ."&nbsp;contains <b>illegal</b> characters or is not in the desired format required.<br></li>";
						}
					}
					
				return $error;			
		}

		# Validates input to only have alpha characters in it
		function validateAlphaChars($key, $val, $v)
		{ 
					
					if (strlen($val) < $v['min'] )
					{
						$error .= "<li>".$v['displayName'] ."&nbsp;needs to be at least <b>".$v['min'] ."</b> characters.<br>";
					}
					
					# Check length
					if (strlen($val) > $v['max'] )
					{
						$error .= "<li>".$v['displayName'] ."&nbsp;needs to be no longer than <b>".$v['max'] ."</b> characters.<br></li>";
					}
					
					# Check expression to make sure it matches
					# to see if it starts with a ^, if it does
					# we need to call !eregi instead of just eregi.

					if (!@eregi("^[a-zA-Z]+$", $val))
					{
						$error .= "<li>".$v['displayName'] ."&nbsp;contains non-alpha characters. Please check your input.<br></li>";
					}
										
				return $error;			
		}
		
		
		# Validates input to only have alpha characters in it
		function validateNumericChars($key, $val, $v)
		{ 
					
					if (strlen($val) < $v['min'] )
					{
						$error .= "<li>".$v['displayName'] ."&nbsp;needs to be at least <b>".$v['min'] ."</b> characters.<br>";
					}
					
					# Check length
					if (strlen($val) > $v['max'] )
					{
						$error .= "<li>".$v['displayName'] ."&nbsp;needs to be no longer than <b>".$v['max'] ."</b> characters.<br></li>";
					}
					
					# Check expression to make sure it matches
					# to see if it starts with a ^, if it does
					# we need to call !eregi instead of just eregi.

					if (!@eregi("^[0-9\.]+$", $val))
					{
						$error .= "<li>".$v['displayName'] ."&nbsp;must contain only numeric characters. Please check your input.<br></li>";
					}
										
				return $error;			
		}


		# Validates input to only have alpha characters in it
		function validateAlphaNumeric($key, $val, $v)
		{ 
					
					if (strlen($val) < $v['min'] )
					{
						$error .= "<li>".$v['displayName'] ."&nbsp;needs to be at least <b>".$v['min'] ."</b> characters.<br>";
					}
					
					# Check length
					if (strlen($val) > $v['max'] )
					{
						$error .= "<li>".$v['displayName'] ."&nbsp;needs to be no longer than <b>".$v['max'] ."</b> characters.<br></li>";
					}
					
					# Check expression to make sure it matches
					# to see if it starts with a ^, if it does
					# we need to call !eregi instead of just eregi.

					if (!@eregi("^[a-zA-Z0-9 ]+$", $val))
					{
						$error .= "<li>".$v['displayName'] ."&nbsp;must contain only alpha or numeric characters. Please check your input.<br></li>";
					}
										
				return $error;			
		}
		
		# This function is called by setting the type in lcFormTitles to 'email'
		# It will validate that the email is a minimum length and that it resolves
		# to a real hostname.  Additional checks could be added later.
		function validateEmail($key, $val, $v)
		{
				
				# Check length
				if (strlen($val) < $v['min'] )
				{
					$error .= "<li>".$v['displayName'] ."&nbsp;needs to be at least <b>".$v['min'] ."</b> characters.<br></li>";
				}
			
				# Check length
				if (strlen($val) > $v['max'] )
				{
					$error .= "<li>".$v['displayName'] ."&nbsp;needs to be no longer than <b>".$v['max'] ."</b> characters.<br></li>";
				}
				
				# Check expression to make sure it matches
				#echo $this->titles[$key]['exp'];
				if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@([0-9a-z](-?[0-9a-z])*\.)+[a-z]{2}([zmuvtg]|fo|me)?$", $val)) 
				{
					$error .= "<li>".$v['displayName'] ."&nbsp;contains <b>illegal</b> characters or is not in the desired format required.<br></li>";
				}
				
				
			# Validate that the hostname given actually resolves.
			$tmp = split("@", $val);
			
			if (gethostbyname($tmp[1]) == $tmp[1])
			{
				$error .= '<li>We were unable to resolve the hostname <u>'.$tmp[1]. '</u> in your email address. Please check that the hostname you provided exists.  If you provided a valid hostname, please <a href="'.APP_URL.'html/main/contactus.html">contact us</a>.</li>';
			}
						
			if ($error)
			{
				
				return $error;
			} else {
				return;
			}
		}		
		
		# This method validates to make sure a 
		function validateSelect($key, $val, $v)
		{
			#debug($key);
			#debug($val);
			#debug($v);
			
			if (trim($val) != '')
			{
				return;
			} else {
				return $error = '<li>Please select an option from '.$v['displayName'];
			}
		}

		# This method validates to make sure a 
		function validateRadio($key, $val, $v)
		{
			
			#debug($v);
			#debug($key);
			#debug($val);
			
			$tmp = split(",", $v['selectOptions']);
			while (list($x, $y) = @each($tmp))
			{
				$z = split("=", $y);
				$newarray[$z[0]] = $z[0];
			}		
			
			#debug($newarray);
			#echo $val;
			if (!in_array($val, $newarray))
			{
				return $error = '<li>Please select a valid option for "'.$v['displayName'].'"';
			} else {
				return;
			}
		}
				
		# This doesn't work right now because you only
		# get an array back when something is selected.
		# If nothing is selected in the form then by the nature
		# of how the form works, this check will never be executed
		# since the function is never called because it isn't submitted
		# via postvars.  Just added as a place holder for now.
		function validateSelectMultiple($key, $val, $v)
		{
			return;
		}
	
		# This just returns to keep things working
		# not the best solution FIX_ME
		function validateDateDropDown($key, $val, $v)
		{
			return;
		}

		# Would like to run the HTML through a formatter of some type.	
		function PrintForm()
		{
			$tmp = htmlspecialchars($this->ToHTML());
			#$tmp = nl2br($tmp);
			echo $tmp;
		}
		
		# By default pass in the form ID or Name that you want to use
		# as well as an array ofinformation that you want to pre-populate
		# your form with.  
		# Example:  $f->getForm(123123, $this->cleanedInput);
		function getForm($code, $vars='')
		{
			#debug($vars);

			// make sure vars is an ARRAY of values, but accept an object.
			if ( is_object($vars) ) $vars = $this->object2array($vars);
					
			$sql = "select * from lcFormInfo where formCode='$code'";
			
			#debug($sql, 1);
			# Grab the form info
			$db = DB::gethandle();
			$db->RESULT_TYPE = MYSQL_ASSOC;
			$db->queryOne($sql);
			$formInfo = $db->Record;
			#debug($formInfo);
			#Fill in all of the form properties
			#from the DB
			while(list ($k, $v) = @each($formInfo))
			{
				# Add the groups and notgroups array to a form
				if ($k == 'groups')
				{
					$v = unserialize($v);
				}

				# All form properties are mapped in the form object			
				$this->$k = $v;
			}
			#debug($this, 1);
			$sql = "select * from lcForms where formId = '".$formInfo['pkey']."' and parentPkey ='0' order by sort asc";
			$db->RESULT_TYPE = MYSQL_ASSOC;
			$db->query($sql);
			
			$n = 0;
			while($db->next_record())
			{
				++$formRow;	
				
				# If the default value is blank then either
				# nothing was entered into the form or the 
				# field doesn't have a defaultValue. 
				# If the form was submitted we want to take what ever
				# was sent to us and use that as the default value.
				# Fields such as event or submit should not be
				# overwritten.
				#debug($db->Record);
				
				if (is_array($vars) )
				{
					#debug($db->Record['type']);
					if ( !( ($db->Record['type'] == 'hidden') || ($db->Record['type'] == 'submit') || ($db->Record['type'] == 'row')  || ($db->Record['type'] == 'checkbox') || ($db->Record['type'] == 'radio')))
					{
						#debug($db->Record);
						
						$db->Record['defaultValue'] = $vars[$db->Record['fieldName']];	
						
					}

					# Checkboxes and radio buttons require us to do some 
					# extra things to see whether they are checked or not. 
					# I am setting it to Y be default and then checking 
					# if the var even exists
					# if it doesn't we know the person didn't check
					# the checkbox or unchecked it.
					if ($db->Record['type'] == 'checkbox') 
					{
						$db->Record['checked'] = 'Y';
						if ( !isset($vars[$db->Record['fieldName']]) )
						{ 
							$db->Record['checked'] = 'N';
						} else {
							if ( $vars[$db->Record['fieldName']] == false) {

								$db->Record['checked'] = 'N';
							}
						}
					} 

					# If the type is a radio button, we
					# need to see if value was passed and 
					# if so use it.  Otherwise, use the default
					# value.  If we didn't do this, radio buttons
					# would not have anything selected by default.
					if ($db->Record['type'] == 'radio') 
					{
						if ( $vars[$db->Record['fieldName']] != '' )
						{ 
							$db->Record['defaultValue'] =
							$vars[$db->Record['fieldName']];
						}
					} 
				} 
				
				
				# echo $db->Record['fieldName'] .'='.$db->Record['defaultValue'].'<br>';
				# Build up the groups for each form field
				$db->Record['groups'] = unserialize($db->Record['groups']);
				
				# Figure out if the 
				#$row = $db->Record['row'];
				#debug($db->Record);
				$this->data[$formRow][] = $db->Record;
			}
			
			#print_r($this);
		}
		
		# Takes an array of information from a form
		# and loops through and cleans it.
		# If someone tries to post values that are not
		# pre-defined, it will remove those from this array.
		function cleanInput($tmp, &$ar)
		{
			# Took the following out to reduce a SQL query.
			# Now it is passsed in from the $this->validateForm().
			#print_r($ar);
			#$db = DB::getHandle();
			#$db->query("select * from lcForms where formId='$formId'");
			#while($db->next_record())
			#{
			#		$tmp[$db->Record['fieldName']] = $db->Record;
			#}
			
			//while (list ($k, $v) = @each($ar))
			while (list ($k, $v) = @each($ar))
			{
				// removes elements submitted that are not identified in the database
				if ($tmp[$k] == false)
				{
					unset($ar[$k]);
					continue;
				}
				#echo $ar[$k].'----->ar<br>';
				#echo $db->Record['fieldName'].'------->Record<br>';
				if (is_array($ar[$k]))
				{
					continue;
				}
				if ($k == $tmp[$k]['fieldName'] )
				{
					# Remove HTML and Javascript Tags
					if ($tmp[$k]['stripTags'] == 'Y')
					{
						$ar[$k] = strip_tags($ar[$k], $tmp[$k]['allowedTags']);
					}
					
					# trim input
					$ar[$k] = trim($ar[$k]);
			
					if ($this->stripslashes)
					{
						$ar[$k] = stripslashes($ar[$k]);
					}
				} 
								
			}
			# return the array cleaned
			return $ar; 
		}

		# By default pass in the form ID or Name that you want to use
		
		function adminGetForm($form)
		{
			$sql = "select * from lcFormInfo where pkey='$form'";
						
			$db = DB::gethandle();
			$db->RESULT_TYPE = MYSQL_ASSOC;
			$db->queryOne($sql);
			$formInfo = $db->Record;
			
			#Fill in all of the form properties
			#from the DB
			while(list ($k, $v) = @each($formInfo))
			{
				# Add the groups and notgroups array to a form
				if ($k == 'groups')
				{
					$v = explode("|", $v);
				}
				if ($k == 'notgroups')
				{
					$v = explode("|", $v);
				}
				
				# Store everything in the object
				$this->$k = $v;
			}
			
			$sql = "select * from lcForms where formId ='".$formInfo['pkey']."' order by sort asc";
			
			$db->query($sql);
			$db->RESULT_TYPE = MYSQL_ASSOC;
			#print_r($db->Record);

			while($db->next_record())
			{

				
				if  ($req[$db->Record['fieldName']] != '') {
					$db->Record['defaultValue'] = $req[$db->Record['fieldName']];
				}
				
				if  ($opt[$db->Record['fieldName']] != '') {
					$db->Record['defaultValue'] = $opt[$db->Record['fieldName']];
				}
				
				# Build up the groups for each form field
				$db->Record['groups'] = explode("|", $db->Record['groups']);
				$db->Record['notgroups'] = explode("|", $db->Record['notgroups']);
				$this->data[] = $db->Record;
			}
			
			#print_r($this);
		}

		# This function displays one form so
		# it can be administrated
		# this method will be used to build a middleware
		# form  editor in the future
		# Example:  
		# $f = new Form();
		# $f->getForm($id); 
		# $HTML = $f->adminToHTML();
		function adminToHTML()
		{
			$HTML = '<table width="'.$this->width.'" border="'.$this->border.'" cellspacing="'.$this->cellspacing.'" cellpadding="'.$this->cellpadding.'">';
			
			if (count($this->data) >= 1)
			{
			$HTML .= '<tr><td class="grey">Field Type</td><td class="grey">Display Name (field name)</td><td class="grey">Sort</td><td class="grey">Action</td></tr>';
			$HTML .= "\n";
			while(list($k, $v) = @each($this->data))
			{
				if ($v['type'] == strtolower('row') )
				{
					$v['displayName'] = "Row";
					$v['fieldName'] = substr($v['defaultValue'], 0, 25).'...';	
				}
				
				if ($v['req'] == 'Y') $ast = '*';
				
				#debug($v);
				$HTML .= '<tr>
							<td>'.$v['type'].'</td>
							<td>'.$ast.$v['displayName'].' ('.strip_tags($v['fieldName']).')</td>
							<td>
								<a href="'.$this->APP.'event=sort/method=up/pkey='.$v['pkey'].'">
								<img src="'.$this->PIC.'up_arrow.gif" width=8 height=13 border=0 alt="click to move field up"></a>&nbsp;&nbsp;
				
								<a href="'.$this->APP.'event=sort/method=down/pkey='.$v['pkey'].'">
								<img src="'.$this->PIC.'down_arrow.gif" width=8 height=13 border=0 alt="click to move field down"></a>
							</td>
							<td><a href="'.$this->APP.'event=addModifyFormField/type='.$v['type'].'/pkey='.$v['pkey'].'/formId='.$v['formId'].'/action=update">Modify</a></td>
						  </tr>';
				unset($ast);
			}
			} else {
				$HTML .= '<tr><td colspan="5">This form is empty.</td></tr>';
				$HTML .= "\n";
			}
			$HTML .= '</table>';
			return $HTML;
		}
		
		
		# This is kind of a stupid function but 
		# I found myself typing the same things
		# over and over so I made it into a function.
		function getFormData($sql)
		{
			# First, grab the information for this field
			
			$db = DB::getHandle();
			$db->RESULT_TYPE = MYSQL_ASSOC;
			$db->queryOne($sql);
			return $db->Record;
		}
		
		
		/****
		* STATIC CLASS METHOD
		*****/
		
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
		 *	All forms have an event associated with it
		 *	If a form does not, this won't break anything
		 *	If it finds an element named "event" it will replace
		 *	it's default value with @param 1
		 *
		 *	@param	$event_name			string
		 *	@return						void
		 */
		function updateEvent($event_name)
		{	
			if (is_array($this->data) == false)
			{	return;
			}

			foreach($this->data as $key_row=>$v)
			{	
				foreach($v as $key_column=>$element)
				{
					if ($element['fieldName'] == 'event')
					{	
						$this->data[$key_row][$key_column]['defaultValue'] = $event_name;
					}
					
				}

			}

		}
		
		/**
		 *	All purpose form value "Default value" modifier
		 *	If a form does not, this won't break anything
		 *	If it finds an element named $element_name it will replace
		 *	it's default value with $new_value
		 *
		 *	@param	$event_name			string
		 *	@param	$new_value			string		// don't about how option/selects work with this yet, this is mainly for input/text/hidden fields
		 *	@return						void
		 */
		function modFormValue($element_name, $new_value, $sub_value='')
		{	
			if (is_array($this->data) == false)
			{	return;
			}

			$field = $sub_value ? $sub_value : 'defaultValue';

			foreach($this->data as $key_row=>$v)
			{	
				foreach($v as $key_column=>$element)
				{
					if ($element['fieldName'] == $element_name)
					{	
						$this->data[$key_row][$key_column][$field] = $new_value;
					}
				
				}
				
			}
		
		}

		/**
		 *	Removes a field from the form if it is not needed 
		 *  Note:  if you remove a required field and you use
		 *  the validation, you will need to remove it again
		 *  before you validate, otherwise you will get an error
		 *  message for that field even though it was never submitted.
		 *
		 *	@param	$element_name 	string
		 *	@return						void
		 */
		function removeFormField($element_name)
		{	
			if (is_array($this->data) == false)
			{	return;
			}
			foreach($this->data as $key_row=>$v)
			{	
				foreach($v as $key_column=>$element)
				{
					if ($element['fieldName'] == $element_name)
					{	
				
						unset($this->data[$key_row]);
					}
				
				}
			}
		
		}
	
		
		/**
		 *	Form::updateSubmitBtn()
		 *
		 *	Allows you to change the label of your submit button
		 *	If you execute this function and it doesn't exist
		 *	nothing will break, no harm to foul.
		 *
		 *	@param $label_name			string
		 *	@return						void
		 */
		function updateSubmitBtn($label_name)
		{
			if (is_array($this->data) == false)
			{	return;
			}

			foreach($this->data as $key_row=>$v)
			{	
				foreach($v as $key_column=>$element)
				{
					if ($element['type'] == 'submit')
					{	
						$this->data[$key_row][$key_column]['defaultValue'] = $label_name;
					}
					
				}

			}
			
		}
		
		# Call it after calling
		# $error = $f->validate(100);
		function hasErrors()
		{	return (boolean)$this->error;
		}

		// This is used at the top of getForm() if it was passed an object
		// instead of an array as Keith had originally intended.
		function object2array($object)
		{
			if (!is_object($object)) return $object;
		
			$ret = array();
			$v = get_object_vars($object);
		
			while (list($prop, $value)= @each($v))
			{	$ret[$prop] = $this->object2array($value);
			}
		
			return $ret;
		}
	}
?>
