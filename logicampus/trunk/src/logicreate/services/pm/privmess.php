<?

class privMess extends PersistantObject {


	/**
	 * constructor
	 */
	function privMess() {
		global $lcObj;
		$lcObj->templateStyle = 'private';
	}

        function load($pkey) {

                return  PersistantObject::_load("privMess","privateMessages",$pkey,"*","pkey");

        }



        function add() {

	      	$this->_save("privateMessages");

		$this->sentReceived = 1;
	      	$this->_save("privateMessages");


		$user = lcUser::getuserByUsername($this->messageTo);

		# Commented this out to not check email notifies, we are always going to send emails to the
		# user no matter what.
		# call("string.lower",array("name"=>"foo"); //  ha ha
		if (strtolower($user->profile->values['emailNotify'])=='y') { 
		#if ( ! $this->dontMail ) {
			mail($user->email,"Message from ".BASE_URL,"There is a message addressed to you at ".BASE_URL." website.  Please login to that site to view your message as soon as possible.  You can view the message after logging in by visiting the site here:
		
		".APP_URL."pm
","From: ".WEBMASTER_EMAIL."\nReply-To: ".WEBMASTER_EMAIL."");

		}
	}

	function _getTransient() {
		return array('dontMail');
	}
}
?>
