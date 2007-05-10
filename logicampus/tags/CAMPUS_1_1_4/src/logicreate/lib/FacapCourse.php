<?

class FacapCourseBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = 1.2;	//PBDO version number
	var $idFacapCourse;
	var $username;
	var $proposedCourse;
	var $courseFamNum;
	var $instructionMode;
	var $semesterDeveloped;
	var $yearDeveloped;
	var $semesterOffered;
	var $yearOffered;
	var $courseOfferedWhen;
	var $courseDevelopedBy;
	var $developmentOfficePhone;
	var $facultyToTeach;
	var $facultyOfficePhone;
	var $periodsOffered;
	var $courseOutline;
	var $justification;
	var $projectedEnrollment;
	var $otherInfo;
	var $createdOn;
	var $status;

	var $__attributes = array(
	'idFacapCourse'=>'int',
	'username'=>'varchar',
	'proposedCourse'=>'varchar',
	'courseFamNum'=>'varchar',
	'instructionMode'=>'varchar',
	'semesterDeveloped'=>'varchar',
	'yearDeveloped'=>'varchar',
	'semesterOffered'=>'varchar',
	'yearOffered'=>'varchar',
	'courseOfferedWhen'=>'text',
	'courseDevelopedBy'=>'text',
	'developmentOfficePhone'=>'varchar',
	'facultyToTeach'=>'varchar',
	'facultyOfficePhone'=>'varchar',
	'periodsOffered'=>'text',
	'courseOutline'=>'text',
	'justification'=>'text',
	'projectedEnrollment'=>'text',
	'otherInfo'=>'text',
	'createdOn'=>'datetime',
	'status'=>'varchar');

	function getFacapCourseActions() {
		$array = FacapCourseActionPeer::doSelect('id_facap_course = \''.$this->getPrimaryKey().'\'');
		return $array;
	}



	function getPrimaryKey() {
		return $this->idFacapCourse;
	}

	function setPrimaryKey($val) {
		$this->idFacapCourse = $val;
	}
	
	function save() {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(FacapCoursePeer::doInsert($this));
		} else {
			FacapCoursePeer::doUpdate($this);
		}
	}

	function load($key) {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "id_facap_course='".$key."'";
		}
		$array = FacapCoursePeer::doSelect($where);
		return $array[0];
	}

	function delete($deep=false) {
		FacapCoursePeer::doDelete($this,$deep);
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
		if ($array['proposedCourse'])
			$this->proposedCourse = $array['proposedCourse'];
		if ($array['courseFamNum'])
			$this->courseFamNum = $array['courseFamNum'];
		if ($array['instructionMode'])
			$this->instructionMode = $array['instructionMode'];
		if ($array['semesterDeveloped'])
			$this->semesterDeveloped = $array['semesterDeveloped'];
		if ($array['yearDeveloped'])
			$this->yearDeveloped = $array['yearDeveloped'];
		if ($array['semesterOffered'])
			$this->semesterOffered = $array['semesterOffered'];
		if ($array['yearOffered'])
			$this->yearOffered = $array['yearOffered'];
		if ($array['courseOfferedWhen'])
			$this->courseOfferedWhen = $array['courseOfferedWhen'];
		if ($array['courseDevelopedBy'])
			$this->courseDevelopedBy = $array['courseDevelopedBy'];
		if ($array['developmentOfficePhone'])
			$this->developmentOfficePhone = $array['developmentOfficePhone'];
		if ($array['facultyToTeach'])
			$this->facultyToTeach = $array['facultyToTeach'];
		if ($array['facultyOfficePhone'])
			$this->facultyOfficePhone = $array['facultyOfficePhone'];
		if ($array['periodsOffered'])
			$this->periodsOffered = $array['periodsOffered'];
		if ($array['courseOutline'])
			$this->courseOutline = $array['courseOutline'];
		if ($array['justification'])
			$this->justification = $array['justification'];
		if ($array['projectedEnrollment'])
			$this->projectedEnrollment = $array['projectedEnrollment'];
		if ($array['otherInfo'])
			$this->otherInfo = $array['otherInfo'];
		if ($array['createdOn'])
			$this->createdOn = $array['createdOn'];
		if ($array['status'])
			$this->status = $array['status'];

		$this->_modified = true;
	}

	function getPea() {
		$p = new BasePea();
		$p->setAttributes($this->__attributes);
		return $p;
	}

}


class FacapCoursePeerBase {

	var $tableName = 'facap_course';

	function doSelect($where) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_SelectStatement("facap_course",$where);
		$st->fields['id_facap_course'] = 'id_facap_course';
		$st->fields['username'] = 'username';
		$st->fields['proposed_course'] = 'proposed_course';
		$st->fields['course_fam_num'] = 'course_fam_num';
		$st->fields['instruction_mode'] = 'instruction_mode';
		$st->fields['semester_developed'] = 'semester_developed';
		$st->fields['year_developed'] = 'year_developed';
		$st->fields['semester_offered'] = 'semester_offered';
		$st->fields['year_offered'] = 'year_offered';
		$st->fields['course_offered_when'] = 'course_offered_when';
		$st->fields['course_developed_by'] = 'course_developed_by';
		$st->fields['development_office_phone'] = 'development_office_phone';
		$st->fields['faculty_to_teach'] = 'faculty_to_teach';
		$st->fields['faculty_office_phone'] = 'faculty_office_phone';
		$st->fields['periods_offered'] = 'periods_offered';
		$st->fields['course_outline'] = 'course_outline';
		$st->fields['justification'] = 'justification';
		$st->fields['projected_enrollment'] = 'projected_enrollment';
		$st->fields['other_info'] = 'other_info';
		$st->fields['created_on'] = 'created_on';
		$st->fields['status'] = 'status';

		$st->key = $this->key;

		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = FacapCoursePeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_InsertStatement("facap_course");
		$st->fields['id_facap_course'] = $this->idFacapCourse;
		$st->fields['username'] = $this->username;
		$st->fields['proposed_course'] = $this->proposedCourse;
		$st->fields['course_fam_num'] = $this->courseFamNum;
		$st->fields['instruction_mode'] = $this->instructionMode;
		$st->fields['semester_developed'] = $this->semesterDeveloped;
		$st->fields['year_developed'] = $this->yearDeveloped;
		$st->fields['semester_offered'] = $this->semesterOffered;
		$st->fields['year_offered'] = $this->yearOffered;
		$st->fields['course_offered_when'] = $this->courseOfferedWhen;
		$st->fields['course_developed_by'] = $this->courseDevelopedBy;
		$st->fields['development_office_phone'] = $this->developmentOfficePhone;
		$st->fields['faculty_to_teach'] = $this->facultyToTeach;
		$st->fields['faculty_office_phone'] = $this->facultyOfficePhone;
		$st->fields['periods_offered'] = $this->periodsOffered;
		$st->fields['course_outline'] = $this->courseOutline;
		$st->fields['justification'] = $this->justification;
		$st->fields['projected_enrollment'] = $this->projectedEnrollment;
		$st->fields['other_info'] = $this->otherInfo;
		$st->fields['created_on'] = $this->createdOn;
		$st->fields['status'] = $this->status;

		$st->key = 'id_facap_course';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_UpdateStatement("facap_course");
		$st->fields['id_facap_course'] = $obj->idFacapCourse;
		$st->fields['username'] = $obj->username;
		$st->fields['proposed_course'] = $obj->proposedCourse;
		$st->fields['course_fam_num'] = $obj->courseFamNum;
		$st->fields['instruction_mode'] = $obj->instructionMode;
		$st->fields['semester_developed'] = $obj->semesterDeveloped;
		$st->fields['year_developed'] = $obj->yearDeveloped;
		$st->fields['semester_offered'] = $obj->semesterOffered;
		$st->fields['year_offered'] = $obj->yearOffered;
		$st->fields['course_offered_when'] = $obj->courseOfferedWhen;
		$st->fields['course_developed_by'] = $obj->courseDevelopedBy;
		$st->fields['development_office_phone'] = $obj->developmentOfficePhone;
		$st->fields['faculty_to_teach'] = $obj->facultyToTeach;
		$st->fields['faculty_office_phone'] = $obj->facultyOfficePhone;
		$st->fields['periods_offered'] = $obj->periodsOffered;
		$st->fields['course_outline'] = $obj->courseOutline;
		$st->fields['justification'] = $obj->justification;
		$st->fields['projected_enrollment'] = $obj->projectedEnrollment;
		$st->fields['other_info'] = $obj->otherInfo;
		$st->fields['created_on'] = $obj->createdOn;
		$st->fields['status'] = $obj->status;

		$st->key = 'id_facap_course';
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



	function doDelete(&$obj,$deep=false) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_DeleteStatement("facap_course","id_facap_course = '".$obj->getPrimaryKey()."'");

		$db->executeQuery($st);

		if ( $deep ) {

			$st = new LC_DeleteStatement("facap_course_action","id_facap_course = '".$obj->getPrimaryKey()."'");
			$db->executeQuery($st);
		}

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function row2Obj($row) {
		$x = new FacapCourse();
		$x->idFacapCourse = $row['id_facap_course'];
		$x->username = $row['username'];
		$x->proposedCourse = $row['proposed_course'];
		$x->courseFamNum = $row['course_fam_num'];
		$x->instructionMode = $row['instruction_mode'];
		$x->semesterDeveloped = $row['semester_developed'];
		$x->yearDeveloped = $row['year_developed'];
		$x->semesterOffered = $row['semester_offered'];
		$x->yearOffered = $row['year_offered'];
		$x->courseOfferedWhen = $row['course_offered_when'];
		$x->courseDevelopedBy = $row['course_developed_by'];
		$x->developmentOfficePhone = $row['development_office_phone'];
		$x->facultyToTeach = $row['faculty_to_teach'];
		$x->facultyOfficePhone = $row['faculty_office_phone'];
		$x->periodsOffered = $row['periods_offered'];
		$x->courseOutline = $row['course_outline'];
		$x->justification = $row['justification'];
		$x->projectedEnrollment = $row['projected_enrollment'];
		$x->otherInfo = $row['other_info'];
		$x->createdOn = $row['created_on'];
		$x->status = $row['status'];

		$x->_new = false;
		return $x;
	}

}


//You can edit this class, but do not change this next line!
class FacapCourse extends FacapCourseBase {



}



class FacapCoursePeer extends FacapCoursePeerBase {

}

?>