<?php

/**
 * A lesson is the wrapper for content and content sequence for
 *  a particular timeframe.  The time may be based on a semester, or
 *  on the enrollment date for a student.
 */
class LC_Lesson {

	var $lessonDo = null;

	function LC_Lesson($id=-1) {
		if ($id > 0) {
			$this->lessonDo = new ClassLesson();
			$this->lessonDo->load($id);
		}
	}

	/**
	 * Create a LC_Lesson object from a loaded dataobject
	 *
	 * @static
	 */
	function create($do) {
		$x = new LC_Lesson();

		$x->lessonDo = $do;
		return $x;
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
		return $db->record['total'];
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
}
?>
