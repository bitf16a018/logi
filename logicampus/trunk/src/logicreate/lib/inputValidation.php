<?php

function validateUserID(){
}

function validateEmail(){
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
