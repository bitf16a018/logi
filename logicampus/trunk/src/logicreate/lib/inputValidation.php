<?php

function validateUserID(){

}

function validateEmail($string){
	if (!preg_match("/^( [a-zA-Z0-9] )+( [a-zA-Z0-9\._-] )*@( [a-zA-Z0-9_-] )+( [a-zA-Z0-9\._-] +)+$/" , $string)) {
		  return false;
		   }
	 return true;
}

function validatePassword($string){
	if( strlen($string) >= 6 )
		return 1;
	return 0;
}

function validateLength($string,$minlength="0",$maxlength="255"){
	if (($maxlength >= strlen($string)) && (strlen($string) >= $minlength))
		return 1;
	return 0;	
}

?>
