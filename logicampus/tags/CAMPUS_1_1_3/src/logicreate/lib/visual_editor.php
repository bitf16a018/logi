<?
/*
Visual Editor Class
mgk 1/12/04

Example usage:
	$e =new editor(450,250);
	list($t['_header'],$t['body']) = $e->render();

The list() part catches both a 'header' and a 'body' part 
that need to be put into the template.  The standard 
template handling should be modified to put $t['_header']
in the template header at all times.

The 'body' part can be put in the template wherever the editor 
should be placed.  

A unique name is generated for each editor so you can have multiple 
ones on a page.

This is an early version of this concept.  More checking can 
be done in the render() method for specific properties, 
and potentially things like fonts and styles, whether to turn on 
or off specific options (tables, etc) and so on.
*/

class editor {

	var $configs;
	var $name = '';
	var $popups = true;
	var $width = 500;
	var $height = 300;
	var $rows = 10;
	var $cols = 50;
	var $imageBase = "/htmlarea/images/";
	var $popupBase = "/htmlarea/popups/";
	var $fontname = true;
	var $fontsize = true;
	var $formatblock = true;
	var $formmatting = true;
	var $formmatting2 = true;
	var $justify = true;
	var $elists = true;
	var $ecolor = true;
	var $createlink = true;
	var $inserimage = true;
	var $inserttable = true;
	var $htmlmode = true;
	var $popup = true;


	function editor($width=500, $height=300) {
		global $_editorNumber;
		$this->width = $width;
		$this->height = $height;
		$_editorNumber++;
		$this->name = "visualEditor_$editorNumber";
	}

	function render() { 
		$header .= '<script type="text/javascript" src="'.BASE_URL.'htmlarea/htmlarea.js"></script>'."\n";
		if ($this->popups) { 
			$header .= '<script type="text/javascript" src="'.BASE_URL.'htmlarea/dialog.js"></script>'."\n";
		}
		$header .= '<script type="text/javascript" src="'.BASE_URL.'htmlarea/htmlarea-lang-en.js"></script>'."\n";
		$header .= '<style type="text/css">@import url('.BASE_URL.'htmlarea/htmlarea.css)</style>'."\n";
		$x = $header;
		$header = '';
		$x .= '<script type="text/javascript">'."\n";
		$x .= "function editor_init() { \n";
		$x .= "var ".$this->id." = new HTMLArea.Config();\n";
		$x .= $this->id.".width='".$this->width."';\n";
		$x .= $this->id.".height='".$this->height."';\n";
		$x .= $this->id.".imgURL='".BASE_URL.$this->imageBase."';\n";
		$x .= $this->id.".popupURL='".BASE_URL.$this->popupBase."';\n";
		$x .= $this->id.".toolbar = [\n";
		if ($this->fontname) { 
			 $tool[] = " [ 'fontname', 'space' ]";
		}
		if ($this->fontsize) { 
			  $tool[] = "[ 'fontsize', 'space' ]";
		}
		if ($this->formatblock) { 
			  $tool[] = "[ 'formatblock', 'space']";
		}
		if ($this->formmatting) { 
			  $tool[] = "[ 'bold', 'italic', 'underline', 'separator' ]";
		}
		if ($this->formmatting2) { 
			  $tool[] = "[ 'strikethrough', 'subscript', 'superscript', 'linebreak' ]";
		}
		if ($this->justify) { 
			  $tool[] = "[ 'justifyleft', 'justifycenter', 'justifyright', 'justifyfull', 'separator' ]";
		}
		if ($this->elists) { 
			$tool[]  = '[ "insertorderedlist", "insertunorderedlist", "outdent", "indent", "separator" ]';
		}
		if ($this->ecolor) { 
			  $tool[] = "[ 'forecolor', 'hilitecolor', 'textindicator', 'separator' ]";
		}
		if ($this->createlink)  { 
			  $tool[] = "[ 'inserthorizontalrule', 'createlink','separator' ]";
		}
		if ($this->insertimage) { 
			  $tool[] = "[ 'insertimage', 'separator' ]";
		}
		if ($this->inserttable) { 
			  $tool[] = "[ 'inserttable', 'separator' ]";
		}
		if ($this->htmlmode) { 
			  $tool[] = "[ 'htmlmode', 'separator' ]";
		}
		if ($this->popup) { 
			  $tool[] = "[ 'popupeditor', 'about' ]";
		}
		/*
		[ "fontname", "space" ],
		[ "space" ],
		[ "formatblock", "space"],
		[ "bold", "italic", "underline" ],
		[ "strikethrough", "subscript", "superscript", "separator" ],
		[ "copy", "cut", "paste", "space", "undo", "redo", "separator", "popupeditor", "linebreak" ],
		[ "justifyleft", "justifycenter", "justifyright", "justifyfull", "separator" ],
		[ "insertorderedlist", "insertunorderedlist", "outdent", "indent", "separator" ],
		[ "forecolor", "hilitecolor", "textindicator", "separator" ],
		[ "inserthorizontalrule", "createlink", "inserttable", "htmlmode" ]
		];
		*/


		$x .= implode(",\n",$tool);
			$x .= "];\n";
		$x .= "HTMLArea.replace('".$this->id."', $this->id);\n";
		$x .= " } \n";
		$x .= '</script>'."\n";
		$x .= "<textarea name='".$this->name."' id='".$this->id."' rows='".$this->rows."' cols='".$this->cols."'>";
		$x .= $this->value."</textarea>";
		return $x;
		return $header.$x;
		return array($header,$x);	
	}

}
class visual_editor extends editor {}
?>
