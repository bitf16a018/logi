<?

	/* Distance Learning User object
		Description:  There are four user types in the
		system.  
			
			Type  		Constant			Value
			*Standard	USERTYPE_STANDARD	1
			*Student	USERTYPE_STUDENT	2
			*Faculty	USERTYPE_FACULTY	3	
			*Admin		USERTYPE_ADMIN		4

		These user types make up the 4 user types that use
		this system.  In the defines.php there are four
		contstants as noted above.  These values match the column
		userType in the lcUsers table.  These values are used to
		load up one of the following user objects.
	*/

	/* 
		Students Dump
		username, passwd, ssn, section number
		"william.k","k1399","xxxxxxxx","26536"
		"william.p","p8879","xxxxxxxx","16585"
		"william.y","y4929","xxxxxxxx","36634"
		"william.y","y4929","xxxxxxxx","36678"
		"w.y","y2919","xxxxxxxx","26670"
	*/	




	/**
	 * Standard user object.  Used for future students
	 * or prospective students or community users.
	 */
	class StandardUser extends lcUser {
		var $profileTable = 'profile_standard';
		var $type = 'standard';
		var $userType = USERTYPE_STANDARD;

		# Constructor
		function StandardUser ($userid)
		{
			
		}
		
				
		# Returns true if the user is a student
		# False is user is not a student
		function isStudent()
		{
			return false;
		}
		
		function isFaculty()
		{
			return false;
		}
		
		function doesTeach($classID)
		{
			return false;
		}

		function isStandard()
		{
			return true;

		}
	
	}

 
	/**
	 * Things that are different from others
	 * courseFamily
	 */
	class FacultyUser extends lcUser {
		var $type = 'faculty';
		var $userType = USERTYPE_FACULTY;
		
		# stores all class objects the faculty teaches
		var $classesTaken = array();
		var $classesTaught = array();
		var $activeClassTaught = 0;
		var $profileTable = 'profile_faculty';
		
		# Constructor
		# Grabs all classes the faculty member teaches? Maybe?
		#only gets called on login
		function FacultyUser ($userid) 
		{
			$this->classesTaught = classObj::getClassesTaught($userid,'facultyId');
			$this->classesTaken = classObj::getClassesTaken($userid);

			for ($x=0; $x < count($this->classesTaught); ++$x) {
				$this->classesTaken[] = $this->classesTaught[$x];
			}
		}
		
		/**
		 *	Pulls in all classes (entire record(w/joins))
		 */
		function getAllClasses()
		{
		}
		
		
		
		# Returns true if the user is a faculty
		# False if they are not a faculty
		function isFaculty()
		{
			return true;
		}
		
		function isAdmin()
		{
			return false;
		}

		# Check if faculty is a student in a class
		function isStudent()
		{
			//if and id_classes is in getvars
			//make sure it's in classes taken,
			// then set it to the active class

			return count($this->classesTaken);
		}
		
		
		/**
		 *	Returns if teacher is teaching a certain class
		 *
		 *	@param	$id_class	int				class identifier
		 *	@return				boolean
		 */		
		# Wrapper function to see if faculty is teaching a class
		function doesTeach($classID)
		{
			while ( list($k,$v) = @each($lcUser->classesTaught) ) {
				if ($v->id_classes == $classID) return true;
			}
			return false;
		}
		
		# Wrapper function to see if faculty is taking a class
		function doesTake($classID)
		{
			
		}
	}
	

	/**
	 * represents students
	 */
	class StudentUser extends lcUser {

		var $classesTaken = array();
		//Beg. Geleli added for gradebookall
		var $overAllClassesTaken = array();
		//end of Gelali add
		var $type = 'student';
		var $userType = USERTYPE_STUDENT;
		
		# Constructor
		# Grabs all classes the faculty member teaches? Maybe?
		function StudentUser ($userid)
		{
			$this->classesTaken = classObj::getClassesTaken($userid);
			//Geleli added for gradebookall
//			$this->overAllClassesTaken = classObj::getOverAllClassesTaken($userid);
			//end of gelali add
			
		}

		function getAllClasses()
		{
		}
		
		
		/**
		 *	Is student in a certain class?
		 *
		 *	id_class will be searched for in the profile to
		 *	check if user is in class (search for section number)
		 *
		 *	@param $id_class	int				(class identifier)
		 *	@return 			boolean
		 */
		function inClass($id_class)
		{
			//true false
		}
		
		
		# Returns true if the user is a student
		# False is user is not a student
		function isStudent() {
			return true;
		}
		
		function isAdmin() {
			return false;
		}

		function isFaculty() {
			return false;
		}
		
		function doesTeach($classID) {
			return false;
		}

		/**
		 * @static
		 */
		function getAll() {
			$db = DB::getHandle();
			$db->query("select *, lc.username as lc_username from lcUsers as lc LEFT JOIN profile_student on lc.username = profile_student.username order by lc.username LIMIT ".$t['start'].",".$this->PAGE_SIZE);
			while ($db->next_record()) {
			$ret[] = $db->Record;
			}
			return $ret;
		}
	}
	
	

	
	/**
	 * Adminstrative user account which by definition has
	 * accesss to most everything in the site.
	 */
	class AdminUser extends lcUser {

		var $classesTaken = array();
		var $type = 'admin';
		var $userType = USERTYPE_ADMIN;
		
		# Constructor
		function AdminUser ($userid)
		{
			$this->classesTaught = classObj::_getAllFromDB($userid,'facultyId');
			
		}


		//admins will have to help a lot of students, so they should
		// get to act like a student always
		function isStudent()
		{
			return (count($this->classesTaken));
		}

		function isAdmin()
		{
			return true;
		}
		
		function isFaculty()
		{
			#debug( $this->classesTaught );
			return true;
		//	return (is_array($this->classesTaught));
		}


		/**
		 *	Returns if teacher is teaching a certain class
		 *
		 *	@param	$id_class	int				class identifier
		 *	@return				boolean
		 */		
		# Wrapper function to see if faculty is teaching a class
		function doesTeach($classID)
		{
			while ( list($k,$v) = @each($lcUser->classesTaught) ) {
				if ($v->id_classes == $classID) return true;
			}
			return false;
		}
	}	

?>
