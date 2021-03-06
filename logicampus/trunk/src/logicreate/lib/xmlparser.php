<?php


class xmlparser
{

	var $root;                    // @var root    (object)       
	var $parser;                  // @var parser  (resource)     
	var $data;                    // @var data    (string)       
	var $vals;                    // @var vals    (array)        
	var $index;                   // @var index   (array)        
	var $charset = "ISO-8859-1"; 
	var $doctype = '';


	function xmlparser($data='') 
	{    
		// I dont want to force you
		if ($data == '')
		{	return;
		}
			
		$this->data = $data;
		//$this->data = eregi_replace(">"."[[:space:]]+"."<","><",$this->data); // strange.. this takes more than 10 seconds?!
		$this->_parseFile();
	}
	
	function write_file($fh)
	{
		fwrite($fh, "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n");
		if ( $this->doctype != '') {
			fwrite($fh, $this->doctype."\n");
		}	
		if (is_object($this->root)) {
			$this->root->wr_node($fh);
		} else  {
			return false;
		}
	}
	
	function &getRoot() {
		return $this->root;
	}
	

	function _parseFile() 
	{
		$this->parser = xml_parser_create($this->charset);
		xml_parser_set_option($this->parser, XML_OPTION_TARGET_ENCODING, $this->charset);
		xml_parser_set_option($this->parser, XML_OPTION_SKIP_WHITE, 1);
		xml_parser_set_option($this->parser, XML_OPTION_CASE_FOLDING, false);
		
		if (!@xml_parse_into_struct($this->parser,$this->data,$this->vals,$this->index)) 
		{	$this->_raiseError("Error while parsing XML File: ".xml_error_string(xml_get_error_code($this->parser))." at line ".xml_get_current_line_number($this->parser));
		}
		
		xml_parser_free($this->parser);
		$this->_buildRoot(0);
	}


	function _buildRoot() 
	{	$i = 0;
		$this->root = new 
			xml_node(@$this->vals[$i]['tag'], @$this->vals[$i]['attributes'], @$this->_getChildren(@$this->vals, $i), @$this->vals[$i]['value'], true);
	}


	function _getChildren($vals, &$i) 
	{
		$children = array();
		while (++$i < sizeof($vals)) 
		{
			switch ($vals[$i]['type']) 
			{
				case 'cdata':       
					@array_push($children, $vals[$i]['value']);
					break;
				case 'complete':    
					@array_push($children, new xml_node($vals[$i]['tag'], $vals[$i]['attributes'], null, $vals[$i]['value'], true));
					break;
				case 'open':        
					@array_push($children, new xml_node($vals[$i]['tag'], $vals[$i]['attributes'], $this->_getChildren($vals, $i), $vals[$i]['value'], true));
					break;
				case 'close':       
				return $children;
			}
		}
		
	}

	// subclass and raise your own errors for it's specific usage
	function _raiseError($errorMsg)
	{	error_log('.::ORB:2:Failed to build menu, check XML syntax'. $errorMsg,0);
	}
	
	
}



class xml_node
{
	
	var $tag;
	var $attrs;
	var $children;
	var $value;
	var $cdata = false;


	function xml_node($nTag, $nAttrs, $nChildren=null, $nValue=null, $base64_check=false) 
	{
		$this->tag = $nTag;
		$this->attrs = $nAttrs;
		$this->children = $nChildren;
		$this->value = '';
		if (strlen($nValue) > 0)
		{	
			if ($base64_check && @$nAttrs['BASE64']) {
				$this->value = base64_decode($nValue);
			} else {
				$this->value = $nValue;
			}
			
		}
		
	}
	
	function wr_node($fh, $prepend_str='')
	{
		# Get the attribute string
		$attrs = array();
		$attr_str = '';
		if (is_array($this->attrs))
		foreach($this->attrs as $key => $val)
		{	$attrs[] = $key . '="'. htmlspecialchars($val, ENT_QUOTES, 'UTF-8'). '"'; // encode this
		}
		
		if ($attrs) 
		{	$attr_str = join(' ', $attrs);
		}
		
		# Write out the start element
		$tagstr = $prepend_str.'<'.$this->tag;
		
		if ($attr_str) 
		{	$tagstr .= " $attr_str";
		}
		
		if (is_array($this->children))
		{	$keys = array_keys($this->children);
		} else 
		{	$keys = array();
		}
		
		# If there are subtags and no data (only whitespace), 
		# then go ahead and add a carriage
		# return.  Otherwise the tag should be of this form:
		# <tag>val</tag>
		# If there are no subtags and no data, then the tag should be
		# closed: <tag attrib="val"/>
		$numtags = sizeof($keys);
		$this->value = trim($this->value);
		if ($numtags && ($this->value == '')) {
			$tagstr .= ">\n";
		} elseif ($numtags == false && ($this->value == '')) {
			$tagstr .= "/>\n";
		} else {
			$tagstr .= ">";
		}
		if ($this->cdata && ($this->value != '')) {
			$tagstr .= "<![CDATA[";
		}
		
		fwrite($fh, $tagstr);

		# Write out the data if it is not purely whitespace
		if ($this->value != "") 
		{	if ($this->attrs['BASE64'])
			{	fwrite($fh, base64_encode($this->value));
			} else 
			{	fwrite($fh, $this->value);
			}
			
		}

		# Write out each subtag
		foreach($keys as $k) {
			$this->children[$k]->wr_node( $fh, "$prepend_str\t" );
		}
		$tagstr = '';
		if ($this->cdata) {
			$tagstr .= "]]>\n".$prepend_str;
		}

		# Write out the end element if necessary
		if ($numtags || ($this->value != "")) {
			$tagstr .= "</{$this->tag}>\n";
			if ($numtags) {
				$tagstr = $prepend_str.$tagstr;
			}
		fwrite( $fh, $tagstr );
		}
		
	}
	
	
}
?>
