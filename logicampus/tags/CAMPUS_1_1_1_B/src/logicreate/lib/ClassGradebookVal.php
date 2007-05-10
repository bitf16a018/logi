<?

class ClassGradebookValBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $idClassGradebookVal;
	var $idClassGradebookEntries;
	var $idClasses;
	var $username;
	var $score;
	var $comments;
	var $dateCreated;
	var $dateModified;

	var $__attributes = array(
	'idClassGradebookVal'=>'int',
	'idClassGradebookEntries'=>'ClassGradebookEntries',
	'idClasses'=>'Classes',
	'username'=>'varchar',
	'score'=>'float',
	'comments'=>'text',
	'dateCreated'=>'datetime',
	'dateModified'=>'datetime');

	function getClassGradebookEntries() {
		if ( $this->idClassGradebookEntries == '' ) { trigger_error('Peer doSelect with empty key'); return false; }
		$array = ClassGradebookEntriesPeer::doSelect('id_class_gradebook_entries = \''.$this->idClassGradebookEntries.'\'');
		if ( count($array) > 1 ) { trigger_error('multiple objects on one-to-one relationship'); }
		return $array[0];
	}

	function getClasses() {
		if ( $this->idClasses == '' ) { trigger_error('Peer doSelect with empty key'); return false; }
		$array = ClassesPeer::doSelect('id_classes = \''.$this->idClasses.'\'');
		if ( count($array) > 1 ) { trigger_error('multiple objects on one-to-one relationship'); }
		return $array[0];
	}



	function getPrimaryKey() {
		return $this->idClassGradebookVal;
	}

	function setPrimaryKey($val) {
		$this->idClassGradebookVal = $val;
	}
	
	function save() {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(ClassGradebookValPeer::doInsert($this));
		} else {
			ClassGradebookValPeer::doUpdate($this);
		}
	}

	function load($key) {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "id_class_gradebook_val='".$key."'";
		}
		$array = ClassGradebookValPeer::doSelect($where);
		return $array[0];
	}

	function isNew() {
		return $this->_new;
	}

	function isModified() {
		return $this->_modified;

	}

	function get($key) {
		return $this->{$key};
	}

	function set($key,$val) {
		$this->_modified = true;
		$this->{$key} = $val;

	}

	/**
	 * set all properties of an object that aren't
	 * keys.  Relation attributes must be set manually
	 * by the programmer to ensure security
	 */
	function setArray($array) {
		if ($array['username'])
			$this->username = $array['username'];
		if ($array['score'])
			$this->score = $array['score'];
		if ($array['comments'])
			$this->comments = $array['comments'];
		if ($array['dateCreated'])
			$this->dateCreated = $array['dateCreated'];
		if ($array['dateModified'])
			$this->dateModified = $array['dateModified'];

		$this->_modified = true;
	}

	function getPea() {
		$p = new BasePea();
		$p->setAttributes($this->__attributes);
		return $p;
	}

}


class ClassGradebookValPeerBase {

	var $tableName = 'class_gradebook_val';

	function doSelect($where) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_SelectStatement("class_gradebook_val",$where);
		$st->fields['id_class_gradebook_val'] = 'id_class_gradebook_val';
		$st->fields['id_class_gradebook_entries'] = 'id_class_gradebook_entries';
		$st->fields['id_classes'] = 'id_classes';
		$st->fields['username'] = 'username';
		$st->fields['score'] = 'score';
		$st->fields['comments'] = 'comments';
		$st->fields['date_created'] = 'date_created';
		$st->fields['date_modified'] = 'date_modified';

		$st->key = $this->key;
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = ClassGradebookValPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_InsertStatement("class_gradebook_val");
		$st->fields['id_class_gradebook_val'] = $this->idClassGradebookVal;
		$st->fields['id_class_gradebook_entries'] = $this->idClassGradebookEntries;
		$st->fields['id_classes'] = $this->idClasses;
		$st->fields['username'] = $this->username;
		$st->fields['score'] = $this->score;
		$st->fields['comments'] = $this->comments;
		$st->fields['date_created'] = $this->dateCreated;
		$st->fields['date_modified'] = $this->dateModified;

		$st->key = 'id_class_gradebook_val';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_UpdateStatement("class_gradebook_val");
		$st->fields['id_class_gradebook_val'] = $obj->idClassGradebookVal;
		$st->fields['id_class_gradebook_entries'] = $obj->idClassGradebookEntries;
		$st->fields['id_classes'] = $obj->idClasses;
		$st->fields['username'] = $obj->username;
		$st->fields['score'] = $obj->score;
		$st->fields['comments'] = $obj->comments;
		$st->fields['date_created'] = $obj->dateCreated;
		$st->fields['date_modified'] = $obj->dateModified;

		$st->key = 'id_class_gradebook_val';
		$db->executeQuery($st);
		$obj->_modified = false;

	}

	function doReplace($obj) {
		//use this tableName
		if ($this->isNew() ) {
			$db->executeQuery(new LC_InsertStatement($criteria));
		} else {
			$db->executeQuery(new LC_UpdateStatement($criteria));
		}
	}



	function doDelete(&$obj,$shallow=false) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_DeleteStatement("class_gradebook_val","id_class_gradebook_val = '".$obj->getPrimaryKey()."'");

		$db->executeQuery($st);

		if ( !$shallow ) {

		}

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function row2Obj($row) {
		$x = new ClassGradebookVal();
		$x->idClassGradebookVal = $row['id_class_gradebook_val'];
		$x->idClassGradebookEntries = $row['id_class_gradebook_entries'];
		$x->idClasses = $row['id_classes'];
		$x->username = $row['username'];
		$x->score = $row['score'];
		$x->comments = $row['comments'];
		$x->dateCreated = $row['date_created'];
		$x->dateModified = $row['date_modified'];

		$x->_new = false;
		return $x;
	}

}


//You can edit this class, but do not change this next line!
class ClassGradebookVal extends ClassGradebookValBase {

	var $disqualified = false;

	/*
	// Given an entry id, I will return an array of ClassGradebookVal objects, ordered
	// by the students' last names.
	function getValsByEntry($entryid) {

		global $lcUser;
		$arr = array();

		$db = DB::getHandle();

		$db->query('select id_class_gradebook_val from class_gradebook_val
			where id_class_gradebook_entries="'.$entryid.'"
			and id_classes="'.$lcUser->activeClassTaught->id_classes.'"');

//		$db->query('select v.id_class_gradebook_val,e.title,e.id_class_gradebook_entries
//			from class_gradebook_entries as e
//			left join class_gradebook_val as v on e.id_class_gradebook_entries');

		while ($db->next_record()) {
			$arr[] = ClassGradebookVal::load($db->Record['id_class_gradebook_val']);
		}

		return $arr;

	}
	*/


	function isDisqualified() {
		return $this->disqualified;
	}


	// given a student username, I will return an array of ClassGradebookVal objects
	function getValsByStudent($username) {

		global $lcUser;

		$db = DB::getHandle();
		$entries = array();  // all entries for the class
		$vals = array();     // all vals for the user/class that exist
		$arr = array();      // the array of objects to ultimately be returned

		/*
		$sql = 'select v.id_class_gradebook_val,e.title,e.id_class_gradebook_entries
			from class_gradebook_entries as e
			left join class_gradebook_val as v on e.id_class_gradebook_entries=v.id_class_gradebook_entries
			where e.id_classes="'.$lcUser->activeClassTaught->id_classes.'"
			and username="'.$username.'"';
		*/
		// Get all entries for the class
		$db->query('select e.title,e.id_class_gradebook_entries from class_gradebook_entries as e
			where e.id_classes="'.$lcUser->activeClassTaught->id_classes.'"');
		while ( $db->next_record() )
			$entries[$db->Record['id_class_gradebook_entries']] = $db->Record['title'];

		// Get all values for the user/class
		$db->query('select id_class_gradebook_val,id_class_gradebook_entries from class_gradebook_val
			where id_classes="'.$lcUser->activeClassTaught->id_classes.'"
			and username="'.$username.'"');
		while ( $db->next_record() )
			$vals[$db->Record['id_class_gradebook_entries']] = $db->Record['id_class_gradebook_val'];

		// build the array of objects to return. create new val objects if they're missing
		while ( list($eid,$title) = @each($entries) ) {
			if ( $vals[$eid] ) {
				// they already have a val for this entry. load it up.
				$val = ClassGradebookVal::load($vals[$eid]);
			} else {
				// they dont't have a val for this entry. create a new one.
				$val = new ClassGradebookVal();
			}
			$val->set( 'title', $title );
			$val->set( 'idClassGradebookEntries', $eid );
			$arr[] = $val;
		}

		return $arr;

	}

	// given a student username, I will return an array of ClassGradebookVal objects
	function getValsByEntry($entryid) {
		global $lcUser;

		$db = DB::getHandle();
		$entries = array();  // all entries for the class
		$students = array(); // all vals for the user/class that exist
		$arr = array();      // the array of objects to ultimately be returned

		/*
		$sql = 'select v.id_class_gradebook_val,e.title,e.id_class_gradebook_entries
			from class_gradebook_entries as e
			left join class_gradebook_val as v on e.id_class_gradebook_entries=v.id_class_gradebook_entries
			where e.id_classes="'.$lcUser->activeClassTaught->id_classes.'"
			and username="'.$username.'"';
		*/
		// Get the entry title
		$db->queryOne('select title from class_gradebook_entries as e
			where e.id_classes="'.$lcUser->activeClassTaught->id_classes.'"
			and id_class_gradebook_entries="'.$entryid.'"');
		$etitle = $db->Record['title'];
		
		// Get all the students in the class
		$sql = 'select p.firstname,p.lastname,p.username from profile as p
			left join class_student_sections as ss on ss.id_student=p.username
			left join class_sections as s on s.sectionNumber=ss.sectionNumber
			where s.id_classes="'.$lcUser->activeClassTaught->id_classes.'" 
			AND active=\'1\' 
			ORDER BY p.lastname';
		$db->query($sql);
		while ($db->next_record()) {
			$students[$db->Record['username']] = array(
				'firstname' => $db->Record['firstname'],
				'lastname' => $db->Record['lastname'],
			);
		}

		// Get all values for the entry/class
		$db->query('select id_class_gradebook_val,id_class_gradebook_entries from class_gradebook_val
			where id_classes="'.$lcUser->activeClassTaught->id_classes.'"
			and id_class_gradebook_entries="'.$entryid.'"');
		while ( $db->next_record() )
			$vals[$db->Record['id_class_gradebook_entries']] = $db->Record['id_class_gradebook_val'];


		// build the array of objects to return. create new val objects if they're missing
		while ( list($user,$namearr) = @each($students) ) {
			$val = ClassGradebookVal::load( array(
				'id_classes' => $lcUser->activeClassTaught->id_classes,
				'username' => $user,
				'id_class_gradebook_entries' => $entryid
			) );
			if ( !is_object($val) ) {
				$val = new ClassGradebookVal();
				$val->title = $etitle;
				$val->set( 'idClassGradebookEntries', $entryid );
				$val->set( 'username', $user );
			}
			$val->title =  $title;
			$val->idClasses = $lcUser->activeClassTaught->id_classes;
			$arr[] = $val;
		}

		return $arr;

	}


	/**
	 * override to ensure good dateCreated and dateModified values
	 */
	function save() {
		$this->comments = stripslashes($this->comments);
		if ( is_numeric($this->score) ) {
			$this->score = sprintf('%.2f',$this->score);
		} else {
			$this->score = null;
		}

		if ( $this->_originalScore != $this->score || $this->_originalComments != $this->comments) {

			$msg = "One of your grades has changed, click the following link to view it.
http://dl.tccd.edu/index.php/classroom/gradebook/id_classes=".$this->idClasses;

/*
   __FIXME__ THIS NEEDS TO BE CUSTOMIZED TO NOTIFY PEOPLE OF GRADE CHANGES 
    
			mail($this->username.'@dl.tccd.edu','Gradebook Value Changed',$msg, "From: ".WEBMASTER_EMAIL);
*/
			//mylog("/tmp/email_".$this->username,$msg);
		} else {
			//$msg = "originalScore = ".$this->_originalScore."\n";
			//$msg .= "score = ".$this->score."\n";
			//$msg .= "originalComments = ".$this->_originalComments."\n";
			//$msg .= "comments = ".$this->comments."\n";
			//mylog("/tmp/failed_email_".$this->username,$msg);
		}
		$this->set('dateModified',time());
		if ( $this->isNew() ) {
			$this->set('dateCreated',time());
			$this->setPrimaryKey(ClassGradebookValPeer::doInsert($this));
		} else {
			ClassGradebookValPeer::doUpdate($this);
		}
	}

}

class ClassGradebookValPeer extends ClassGradebookValPeerBase {

	/**
	 * override to find changed comments and score, email student if
	 * either of those two changed
	 */
	function row2Obj($row) {
		$x = parent::row2Obj($row);
		$x->_originalComments = $x->comments;
		$x->_originalScore = sprintf('%.2f',$x->score);
	return $x;
	}

}
?>
