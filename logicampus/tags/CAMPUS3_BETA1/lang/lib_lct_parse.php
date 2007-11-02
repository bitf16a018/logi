<?php
/**
 * T_ML_COMMENT does not exist in PHP 5.
 * The following three lines define it in order to
 * preserve backwards compatibility.
 *
 * The next two lines define the PHP 5 only T_DOC_COMMENT,
 * which we will mask as T_ML_COMMENT for PHP 4.
 */
if (!defined('T_ML_COMMENT')) {
    //php 5 doesn't need this, but previously written scripts might
    define('T_ML_COMMENT', T_COMMENT);
} else {
    //php4 needs this
    define('T_DOC_COMMENT', T_ML_COMMENT);
}

if (is_array($argv) && isset($argv[1]) ) {
   $file = $argv[1];
  $file = '';
   //process the file, because we are in CLI mode
}

function findLctInFile($f) {

	$fileList[] = $f;
	//start parsing all files
	$classStack    = array();
	$callStack    = array();

	foreach ($fileList as $file) {
	//echo "*** STARTING FILE ".$file."\n";
	$source = file_get_contents($file);
	$tokens = token_get_all($source);

	$scope = 'global';
	$currentMethod = null;
	$currentClass  = null;
	$currentCall   = null;
	$indent        = 0;
	$line          = 1;


	foreach ($tokens as $tid => $token) {

		  if ($scope== 'class' && $currentClass != null) {
	//echo "visiting class with "; echo (is_array($token))?$token[1]:$token; echo "\n";
	//print_r($currentClass);
			$currentClass->visit($token);
		  }

		  if ($scope== 'method' && $currentMethod != null) {
			$currentMethod->visit($token);
		  }


		//handle inline brackets {$this->foo}
		if (is_array($token) && $token[1] == '{' ) { $indent++; /*echo "*** INDENT ".$indent."\n"; // */}
		if (is_string($token) ) {

			$line += substr_count($text,"\n");

			if ($token == '{') {
			  $indent++;
	//echo "*** INDENT ".$indent."\n";
			}

			if ($token == '}') {
			  $indent--;
	//echo "*** INDENT ".$indent."\n";
			  if ($currentClass != null && $currentClass->_indent == $indent ) {
	//echo "*** CLOSING CLASS ".$currentClass->name."\n";
				$classStack[] = $currentClass;
				$currentClass = null;
				$scope = 'global';
			  }

			  if ($currentMethod != null && $currentMethod->_indent == $indent ) {
				$currentClass->methods[] = $currentMethod;
				$currentMethod = null;
				$scope = 'class';
			  }

			}

			if ($scope == 'call') {
				$currentCall->visit($token);
			}

			if ($token == ')' && $scope == 'call') {
				if ($currentCall->isFinished() ) {
					$callStack[] = $currentCall;
					$currentCall = null;
					$scope = 'global';
				}
			}

		}

		if (is_array($token)) {
			// token array
			list($id, $text) = $token;

			$line += substr_count($text,"\n");

			switch ($id) {
				case T_COMMENT:
				case T_ML_COMMENT: // we've defined this
				case T_DOC_COMMENT: // and this
					// no action on comments
					break;

				case T_CLASS:
				  $scope = 'class';
				  $currentClass = new ParsedClass($indent,$file);
				  break;

				case T_FUNCTION:
				  $scope = 'method';
				  $currentMethod = new ParsedMethod($indent);
				  break;

				case T_STRING:
					//sub-call
					if ($scope == 'call') {
						$currentCall->visit($token);
						break;
					}
					if ($text == 'lct') {
						$scope = 'call';
						$currentCall = new ParsedCall($text, $file, $line);
					}
					break;
	/*
				  echo "\nTOKEN ID = ".$tid." METHOD ID  = ".$id."\n".$text."\n";
				  echo "METHOD NAME = "; print_r($tokens[$tid+2]);echo "\n";
	*/
				default:
					if ($scope == 'call') {
						$currentCall->visit($token);
					}
					break;
			}
		}
	}
	}//done with foreach fileList
	return $callStack;
}

//show the results
//showResults($classStack);


class ParsedCode {

  var $_indent;
  var $_doneName = false;

  function visit($token) {
	  if ( is_array($token)) {
		  $this->visitArray($token);
	  } else {
		  $this->visitSimple($token);
	  }
  }
}

class ParsedClass extends ParsedCode {
  var $name    = '';
  var $extends = '';
  var $methods = array();
  var $filename;
  var $_doneExt = false;

  function ParsedClass($i, $file) {
    $this->name = '';
    $this->_indent = $i;
    $this->filename = $file;
  }

  function visit($token) {
    if (! $this->_doneName ) {
      if ($token[1] == 'extends') { $this->_doneName = true; return;}
      if (is_array($token) ) {
        $this->name .= $token[1];
      }
    }

    if ( $this->_doneName && ! $this->_doneExt ) {
      $this->extends .= $token[1];
    }

    if ($token == '{') { $this->_doneName = true; $this->_doneExt = true;}
  }

  function isLinkDynamic() {
    foreach ($this->methods as $methObj) {
      //only deal with linkMap functions
      if ( !strstr($methObj->name, '_linkMap' ) ) { continue; }
      if ($methObj->isDynamic())  { return true; }
    }
    return false;
  }

  function isLinkEnd() {
    foreach ($this->methods as $methObj) {
      if ( !strstr($methObj->name, '_linkMap' ) ) { continue; }
      if ($methObj->isEndPoint())  { return true; }
    }
    return false;
  }

}

/**
 * Holds a function call
 */
class ParsedCall extends ParsedCode {
	var $fn = '';
	var $params = array();
	var $line = 0;
	var $file = '';
	var $orgSource = '';
	var $parensStack = 0;
	var $paramStack = 0;
	var $tempParam = '';

	function ParsedCall($name, $file, $line) {
		$this->fn = $name;
		$this->line = $line;
		$this->file = $file;
		$this->orgSource .= $name;
	}

	function addParam($prm) {
		$this->params[] = $prm;
	}


	function addSource($text) {
		$this->orgSource .= $text;
	}

	function visitSimple($token) {
		if ($token == '(' ) $this->parensStack++;
		if ($token == ')' ) $this->parensStack--;
		$this->addSource($token);

		if ($token == ')' && $this->parensStack == $this->paramStack && $this->paramStack != 0) {
			$this->tempParam .= $token;
			$this->params[] = $this->tempParam;
			$this->tempParam = '';
			$this->paramStack =0;
		}

		if ($this->tempParam != '') {
			$this->tempParam .= $token;
		}
	}

	function visitArray($token) {
		if ($token[1] == '(' ) $this->parensStack++;
		if ($token[1] == ')' ) $this->parensStack--;
		$this->addSource($token[1]);
		$this->buildParams($token);
	}

	function buildParams($token) {
		if ($token[0] == T_CONSTANT_ENCAPSED_STRING && $this->paramStack == 0) {
			$this->params[] = $token[1];
			return;
		}

		if ($token[0] == T_ARRAY) {
			$this->paramStack = $this->parensStack;
		}
		$this->tempParam .= $token[1];

	}
	function isFinished() {
		return $this->parensStack == 0;
	}
}

class ParsedMethod extends ParsedCode {
  var $name     = '';
  var $params   = array();
 // var $contents = array();
  var $contents = '';
  var $_dynamic = false;

  function ParsedMethod($i) {
    $this->_indent = $i;

  }


  function visit($token) {
    if ($token[0] == T_IF) { $this->_dynamic = true; }
    if (! $this->_doneName ) {
      if (is_array($token) ) {
        $this->name .= $token[1];
      } else {
        $this->name .= $token;
        if ($token == '{') { $this->_doneName = true;}
      }
    } else {
      //add anything else to the contents
      if (is_array($token) ) {$this->contents .= $token[1];} else { $this->contents .= $token; }
    }
  }

  function isDynamic() {
    return $this->_dynamic;
  }

  function isEndPoint() {
    $deletes = true;

      $lines = explode("\n", $this->contents);
      foreach ($lines as $l ) {
          if ( strstr($l, 'delete') ) {
          if ( strstr($l, 'true') ) {
            $deletes = false;
            return false;
          }
          }
      }
      return $deletes;
//    return ( ! strstr($this->contents,'delete') );
  }

}

?>

