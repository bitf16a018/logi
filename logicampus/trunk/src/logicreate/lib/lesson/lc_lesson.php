<?php
include_once(LIB_PATH.'PBDO/ClassLessons.php');

/**
 * A lesson is the wrapper for content and content sequence for
 *  a particular timeframe.  The time may be based on a semester, or
 *  on the enrollment date for a student.
 */
class Lc_Lesson {

	var $lessonDo      = null;
	var $guid          = '';
	var $lessonSeq   = null;
	var $seqLoaded     = false;

	function Lc_Lesson($id=-1) {
		if ($id > 0) {
			$this->lessonDo = ClassLessons::load($id);
		}
	}

	/**
	 * Create a Lc_Lesson object from a loaded dataobject
	 *
	 * @static
	 */
	function create($do) {
		$x = new Lc_Lesson();

		$x->lessonDo = $do;
		return $x;
	}

	/**
	 * Save the lessonDo
	 */
	function save() {
		$goodSave = true;
		$goodSave &= $this->lessonDo->save();

		if (is_object($this->lessonSeq) ) {
			if ($this->lessonSeq->lessonId != $this->getId() ) {
				$this->lessonSeq->lessonId = $this->getId();
			}
			$goodSave &= $this->lessonSeq->save();
		}
		return $goodSave;
	}

	/**
	 * Load up the LOB sequence that goes with this lesson
	 */
	function loadSequence($classId) {
		$this->lessonSeq = new Lc_LessonSequence($this->getId(),$classId);
		$this->lessonSeq->loadItems();
		$this->seqLoaded = true;
	}

	/**
	 * Set the GUID
	 */
	function setGuid($g) {
		$this->guid = $g;
	}

	/**
	 * Load all lessons for this class
	 *
	 * @static
	 */
	function loadClassLessons($classId) {
		$classId = intval($classId);
		if ($classId ==0 ) {
			lcError::throwError(E_USER_ERROR,'no class id specified');
			return false;
		}
		$db = DB::getHandle();

		$sql = "SELECT
		cl.*
		FROM class_lessons as cl
		WHERE id_classes = ".$classId."
		ORDER BY activeOn ASC";


		$ret = array();
		$db->query($sql);
		while ($db->nextRecord() ) {
			$temp = ClassLessonsPeer::row2Obj($db->record);
			$wrapper = LC_Lesson::create($temp);
			$ret[] = $wrapper;
		}
		return $ret;
	}

	/**
	 * Count 'content' items linked to this lesson in class_lesson_sequence
	 */
	function getContentCount() {
		$db = DB::getHandle();
		$sql = "SELECT
		count(class_lesson_sequence_id) as total
		FROM class_lesson_sequence
		WHERE lesson_id = ".$this->lessonDo->getPrimaryKey()."
		AND lob_type = 'content'
		";

		$db->query($sql);
		$db->nextRecord();
		$db->freeResult();
		return $db->record['total'];
	}

	/**
	 * Count 'interaction' items linked to this lesson in class_lesson_sequence
	 */
	function getObjectCountByType($type='content') {
		$db = DB::getHandle();
		$sql = "SELECT
		count(class_lesson_sequence_id) as total
		FROM class_lesson_sequence
		WHERE lesson_id = ".$this->lessonDo->getPrimaryKey()."
		AND lob_type = '".$type."'
		";

		$db->query($sql);
		$db->nextRecord();
		$db->freeResult();
		return $db->record['total'];
	}


	/**
	 * __TODO__ make this relative to when a user enrolls
	 */
	function getStartDate() {
		return $this->lessonDo->activeOn;
	}

	/**
	 * Returns integer representing the number of days left until this lesson starts
	 */
	function daysTilStart() {
		$days = floor(($this->lessonDo->activeOn - time()) / 86400);
		if ($days < 1) { return 0;}
		return $days;
	}

	/**
	 * Returns integer representing the number of days left until this lesson ends 
	 */
	function daysTilEnd() {
		$days = floor(($this->lessonDo->inactiveOn - time()) / 86400);
		if ($days < 1) { return 0;}
		return $days;
	}

	/**
	 * Access Getters
	 */
	function getId() {
		return $this->lessonDo->getPrimaryKey();
	}

	/**
	 * Access Getters
	 */
	function getTitle() {
		return $this->lessonDo->title;
	}

	/**
	 * Is this lesson over?
	 */
	function isFinished() {
		return $this->lessonDo->inactiveOn < time();
	}

	/**
	 * Store a lesson into the users' session
	 */
	function storeLessonInSession($lessonId, &$u) {
		$ut = time();
		$db = DB::getHandle();
		$sql = "select * from class_lessons
			where id_class_lessons='".$lesson_id."'
			and id_classes='{$u->activeClassTaken->id_classes}'";
		if (!$u->isFaculty())
			$sql .= " and (activeOn < ".time()."
				and inactiveOn > ".time().')';

		$db->queryOne($sql);
		$u->sessionvars['activeLesson'] = $db->record;
	}

	/**
	 * Find a lesson ID for a particular sequence
	 */
	function getLessonIdForSequenceId($seqId) {
		$seqObj = ClassLessonSequence::load($seqId);
		return $seqObj->lessonId;
	}
}
?>
