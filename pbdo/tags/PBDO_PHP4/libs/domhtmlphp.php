<?

/**
 * Library of DOM XML and HTML classes for PHP
 */



define ( 'XML_ELEMENT_NODE', 1);
define ( 'XML_TEXT_NODE', 2);
define ( 'XML_ENTITY_REF_NODE', 3);
define ( 'XML_COMMENT_NODE', 4);
define ( 'XML_PI_NODE', 5);
		


function & PDOM_Globalize(&$n) {
	static $nodes = array();

	if ($n === 0 ) {
		print_r($nodes);
		return;
	}

	if (is_object($n)) {
		$nodes[$n->id] = &$n;
	} else {
		return $nodes[$n];
	}
}



class PDOM_Node {

	var $content;
	var $children = array();
	var $sibling;
	var $document;
	var $attributes = array();
	var $id;
	var $type = XML_TEXT_NODE;


	function PDOM_Node() {
		$this->id = rand(50000,99999);
	}



	/**
	 * return the first child node of this node
	 *
	 * __FIXME__ add error checks for has any children
	 * return false/null if no children at all
	 */
	function & getFirstChild() {
		$x = & PDOM_Globalize($this->children[0]);
		return $x;
	}

	/**
	 * append one child node
	 */
	function appendChild(&$n) {
		$this->children[] = $n->id;
		PDOM_Globalize($n);
	}

	/**
	 * Print a string representation
	 */
	function toString( ) {
		switch($this->type) {
			case XML_TEXT_NODE:
				$retstr 	.= $this->content;
				break;
			case XML_ENTITY_REF_NODE:
				$retstr		.= "&" . $this->name . ";";
				break;
			case XML_COMMENT_NODE:
				$retstr		.= "<!-- " . $this->content . " -->";
				break;
			case XML_PI_NODE:
				$retstr		.= "<?" . $this->name . " " . $this->content . " ?>";
				break;
		}

	return $retstr;
	}


	/**
	 * sets the content of this node
	 *
	 * look for first child node of type XML_TEXT_NODE
	 * if type is not XML_TEXT_NODE
	 */
	function setContent($c) {
		$this->content = $c;
	}


	/**
	 * return a duplicate of this node
	 *
	 * change all the ids to new ones, repeat for children
	 */
	function clone() {

		reset($this->children);
		$copy = $this;
		$copy->children = array();
		$copy->id = rand(50000,99999);
		while ( list ($k,$v) = each ($this->children) ) {
		$v = PDOM_Globalize($v);
			if (is_object($v)) {
			$kid = $v->clone();
			$copy->appendChild($kid);
			}
		}
		PDOM_Globalize($copy);
//		print_r($this);
//		print_r($copy);
//		exit();
		reset($this->children);
	return $copy;
	}


	/**
	 * set an attribute of this node
	 */
	function setAttribute($k,$v) {
		$this->attributes[$k] = $v;
	}
}


/**
 * represent an entire document or a partial one
 */
class PDOM_Document extends PDOM_Node {

	var $title;
	var $name;



	/**
	 * __FIXME__
	 * add a toString function that adds doctype stuff
	 * guarantee format
	 */
}



class PDOM_Element extends PDOM_Node {

	var $tagname = 'BROKEN';
	var $type = XML_ELEMENT_NODE;
	var $needsClosing = false;


	/**
	 * return a string representation
	 * of this object
	 */
	function toString( ) {
		$retstr	.= "<" . $this->tagname;
		// Checking all Attributes
		$attrlist	= $this->attributes;
		if ( is_array( $attrlist ) ) {
			while ( list( $k, $attr ) = each( $attrlist ) ) {
				$retstr	.= " " . $k ."=\"". $attr . "\"";
			}
		}
		$elem = $this->children;
		if ( is_array( $elem ) && ( count ($elem) > 0 )) {
			// Children are present -> closing the Opening tag
			$retstr	.= ">";
			reset( $elem );
			while ( list( $k, $node ) = each( $elem ) ) {
				$node = PDOM_Globalize($node);
				if ($node->type == XML_ELEMENT_NODE) 
					$retstr .="\n\t";
				$retstr .= $node->toString();
			}
			$retstr	.= "</" . $this->tagname . ">";
		}
		else if ($this->content != '' ) {
			// No children are present - but content is
			$retstr	.= ">";
			$retstr .= $this->content;
			$retstr	.= "</" . $this->tagname . ">";
		}
		else if ( $this->needsClosing ) {
			$retstr	.= ">";
			$retstr	.= "</" . $this->tagname . ">";
		} else {
			// No children are present - closing the Opening tag
			$retstr .= "/>";
		}
		$retstr .= "\n";
	return $retstr;
	}



	function setContent($c) {
		$this->content = $c;
		if (!is_array($this->children)) return;

		foreach($this->children as $k=>$v) {
			if ($v->type== XML_TEXT_NODE) {
				$v->content = $c;
				$this->children[$v->id] = $v;
				PDOM_Globalize($v);
				return;
			}
		}
	}
}



class PDOM_Table extends PDOM_Element {

	var $tr = array();
	var $tagname = 'TABLE';
	var $width;


	function appendRow(&$row) {
		if ( strtolower($row->tagname) != 'tr' ) {
			return false;
		}
		$this->tr[] = &$row;
		$this->appendChild($row);
		return true;
	}


	function & insertRow($index) {
		$row =& new PDOM_TR();
		$this->tr[$index] = &$row;
		$this->appendChild($row);

		return $row;
	}
}

class PDOM_TR extends PDOM_Element {

	var $td = array();
	var $tagname = 'TR';


	function appendCell(&$cell) {
		if ( strtolower($cell->tagname) != 'td' ) {
			return false;
		}
		$this->td[] = &$cell;
		$this->appendChild($cell);
		return true;
	}
}

class PDOM_TD extends PDOM_Element {

	var $tagname = 'TD';

}

class PDOM_Heading extends PDOM_Element {

	var $tagname = 'H2';
	var $needsClosing = true;


	function PDOM_Heading($size=2) {
		$this->tagname = 'H'.$size;
	}


	function setSize($size=2) {
		$this->tagname = 'H'.$size;
	}
}

/**
 * Form's toSting method merges its widgets into its layout manager
 *
 * Widgets are not added to the global node space
 * __FIXME__ should they be?
 */
class PDOM_Form extends PDOM_Element {

	var $tagname = 'FORM';
	var $needsClosing = true;
	var $layout;
	var $widgets = array();

	function setLayout($l) {
		$this->layout = $l;
	}

	function appendWidget(&$w) {
		$this->widgets[] = &$w;
	}

	function toString() {
		if ( !is_object($this->layout) ) {
			$this->layout = new PDOM_VFlowLayout();
		}
		$inside = $this->layout->stroke($this->widgets);
		$this->setContent($inside);
		return parent::toString();
	}

	function appendChild(&$n) {
		$this->appendWidget($n);
	}
}

/**
 * Transparent container that has a layout and can take widgets
 */
class PDOM_Panel extends PDOM_Form {

	function toString() {
		if ( !is_object($this->layout) ) {
			$this->layout = new PDOM_HorizontalLayout();
		}
		$inside = $this->layout->stroke($this->widgets);
		return $inside;
	}

}


class PDOM_Widget extends PDOM_Element {

	var $label;
	var $value;
	var $name;
	var $attributes = array('type'=>'','name'=>'');
}

class PDOM_TextInput extends PDOM_Widget {

	var $tagname = 'INPUT';

	function PDOM_TextInput() {
		$this->attributes['type'] = 'text';
	}

}

class PDOM_Label extends PDOM_Widget {

	var $tagname = 'SPAN';
	var $attributes = array('name'=>'');

	function PDOM_Label($label) {
		$this->setContent($label);
	}
}


class PDOM_LayoutManager {

	function stroke($widgets) {

	}
}

class PDOM_VerticalLayout extends PDOM_LayoutManager {

	function stroke($widgets) {
		$retstr = '<table border="0">';
		$retstr .= "\n";
		foreach ($widgets as $k=>$w) {
			if (! $w->attributes['name']) {
				$w->attributes['name'] = 'widget'.sprintf('%d',$k);
			}
			$retstr .= "\t<tr><td>\n\t\t";
			$retstr .= $w->toString();
			$retstr .= "\t</td></tr>\n";
		}
		$retstr .= '</table>';
		$retstr .= "\n";
		return $retstr;
	}
}


class PDOM_HorizontalLayout extends PDOM_LayoutManager {

	function stroke($widgets) {
		$retstr = '<table border="0"><tr>';
		$retstr .= "\n";
		foreach ($widgets as $k=>$w) {
			if (! $w->attributes['name']) {
				$w->attributes['name'] = 'widget'.sprintf('%d',$k);
			}
			$retstr .= "\t<td>\n\t\t";
			$retstr .= $w->toString();
			$retstr .= "\t</td>\n";
		}
		$retstr .= '</tr></table>';
		$retstr .= "\n";
		return $retstr;
	}
}




class PDOM_VFlowLayout extends PDOM_LayoutManager {

	function stroke($widgets) {
		foreach ($widgets as $k=>$w) {
			if (! $w->attributes['name']) {
				$w->attributes['name'] = 'widget'.sprintf('%d',$k);
			}
			$retstr .= $w->toString();
			$retstr .= "<br/>\n";
		}
		return $retstr;
		
	}
}

class PDOM_HFlowLayout extends PDOM_LayoutManager {

	function stroke($widgets) {
		foreach ($widgets as $k=>$w) {
			if (! $w->attributes['name']) {
				$w->attributes['name'] = 'widget'.sprintf('%d',$k);
			}
			$retstr .= $w->toString();
			$retstr .= "&nbsp;\n";
		}
		return $retstr;
		
	}
}

?>
