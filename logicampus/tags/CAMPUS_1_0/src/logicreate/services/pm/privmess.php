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

		$user = lcUser::getuserByUsername($this->messageTo);

		# By default, users will get private messages
		# The following was commented out since certain applications rely on 
		# private message notifications to work.  Depending on your schools work
		# flow you may want to re-enable this feature.
		#if ($user->profile['emailNotify']=='Y') {

				if ( ! $this->dontMail ) {
					mail($user->email,"Message from ".BASE_URL,"There is a message addressed to you at ".BASE_URL." website.  Please login to that site to view your message as soon as possible.  You can view the message after logging in by visiting the site here:
				
				".APP_URL."pm
		","From: ".WEBMASTER_EMAIL."\nReply-To: ".WEBMASTER_EMAIL."");

				}
		#	}
		}

	function _getTransient() {
		return array('dontMail');
	}
}
?>
