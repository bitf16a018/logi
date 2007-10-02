<?php
include_once(LIB_PATH.'PBDO/ClassLessonSequence.php');

class LC_LessonSequence {

	var $lessonId = -1;
	var $classId  = -1;
	var $items    = array();

	function LC_LessonSequence($lessonId,$classId) {
		$this->lessonId = $lessonId;
		$this->classId  = $classId;
	}

	/**
	 *  Load all class_lesson_sequence items and store them in ->items
	 */
	function loadItems() {
		$this->items = ClassLessonSequencePeer::doSelect( 'class_id = '.$this->classId.' and lesson_id = '.$this->lessonId);
	}

	function fetchObject($sequenceId) {
		$type = 'content';
		foreach ($this->items as $seqItem) {
			if ($seqItem->classLessonSequenceId == $sequenceId) {
				$type = $seqItem->lobType;
			}
		}
		switch($type) {
			case 'activity':
				$activityLob = new Lc_Lob_ClassActivity($seqItem->lobClassRepoId);
				return $activityLob;
				break;
		}
	}

	function getSequence($sequenceId) {
		foreach ($this->items as $seqItem) {
			if ($seqItem->classLessonSequenceId == $sequenceId) {
				return $seqItem;
			}
		}
	}

	function getStartDate(&$lessonObj, $sequenceId) {
		foreach ($this->items as $seqItem) {
			if ($seqItem->classLessonSequenceId == $sequenceId) {
				return $lessonObj->getStartDate() + $seqItem->startOffset;
			}
		}
	}

	function getDueDate(&$lessonObj, $sequenceId) {
		foreach ($this->items as $seqItem) {
			if ($seqItem->classLessonSequenceId == $sequenceId) {
				return $lessonObj->getStartDate() + $seqItem->dueOffset;
			}
		}
	}

	function updateAssignments($contentIds,$lobData) {
		if (count($contentIds) < 1) { $contentIds = array(0);}
		$this->updateSequence($contentIds, $lobData, 'activity');
	}

	function updateTests($contentIds,$lobData) {
		if (count($contentIds) < 1) { $contentIds = array(0);}
		$this->updateSequence($contentIds, $lobData, 'test');
	}

	function updateContent($contentIds,$lobData) {
		if (count($contentIds) < 1) { $contentIds = array(0);}
		$this->updateSequence($contentIds, $lobData, 'content');
	}

	/**
	 * Wrap utility function to update sequence table.
	 */
	function updateSequence($contentIds,$lobData,$type ='content') {
		$db = Db::getHandle();

		//find content objects that we didn't recieve a checkbox for
		$sql = ('SELECT class_lesson_sequence_id, lob_class_repo_id
			FROM class_lesson_sequence
			WHERE lesson_id = '.$this->lessonId.'
			AND class_id = '.$this->classId.'
			AND lob_type = "'.$type.'"
			AND lob_class_repo_id NOT IN ('.implode(',',$contentIds).')');

		//needs work to delete
		$deletes = array();
		$db->query($sql);
		while ($db->nextRecord()) {
			$deletes[] = $db->record['class_lesson_sequence_id'];
		}

		//wipe all previous content links for this lesson
		if (count ($deletes) > 0 ) {
		$db->query('DELETE from class_lesson_sequence
			WHERE class_lesson_sequence_id IN ('.implode(',',$deletes).')');
		}

		//find objects that got a checkbox but are already present in the DB
		$sql = ('SELECT class_lesson_sequence_id, lob_class_repo_id
			FROM class_lesson_sequence
			WHERE lesson_id = '.$this->lessonId.'
			AND class_id = '.$this->classId.'
			AND lob_type = "'.$type.'"
			AND lob_class_repo_id IN ('.implode(',',$contentIds).')');

		$keepers = array();
		$db->query($sql);
		while ($db->nextRecord()) {
			$keepers[] = $db->record['lob_class_repo_id'];
		}

//		debug($contentIds);
//		debug($keepers);
		//so we're only inserting absolutely new checkboxes,
		// this should keep the pkey count down significantly 
		// over other methods of deleting all records in a table
		// and then adding all new records.
		$contentIds = array_diff($contentIds,$keepers);

		//one last thing, we need to find out the maximum rank in the sequence
		$sql = ('SELECT MAX(`rank`) as toprank
			FROM class_lesson_sequence
			WHERE lesson_id = '.$this->lessonId.'
			AND class_id = '.$this->classId);

		$db->query($sql);
		$db->nextRecord();
		$topRank = $db->record['toprank'];


		//insert each new link
		$insert = 'INSERT INTO class_lesson_sequence
		(lesson_id,class_id, lob_class_repo_id, lob_type, lob_sub_type, lob_mime, lob_title, link_text, rank)
		VALUES (%d, %d, %d, "'.$type.'", "%s", "%s", "%s", "%s", %d)';

		//debug($contentIds,1);
		//debug($lobData,1);
		foreach($contentIds as $k=>$v) {
			if ($v < 1 ) continue;
			$lob = $lobData[$v];
			$topRank++;
			$db->query( sprintf($insert, $this->lessonId, $this->classId, $v, $lob['lob_sub_type'], $lob['lob_mime'], $lob['lob_title'], $lob['lob_urltitle'], $topRank));
		}
	}

	function fetchLob() {
	}
}
