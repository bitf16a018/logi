<?php

class LC_LessonSequence {

	var $lessonId = -1;
	var $classId  = -1;

	function LC_LessonSequence($lessonId,$classId) {
		$this->lessonId = $lessonId;
		$this->classId  = $classId;
	}

	function updateAssignments($contentIds,$lobData) {
		if (count($contentIds) < 1) { $contentIds = array(0);}
		$this->updateSequence($contentIds, $lobData, 'assignment');
	}

	function updateTests($contentIds,$lobData) {
		if (count($contentIds) < 1) { $contentIds = array(0);}
		$this->updateSequence($contentIds, $lobData, 'assessment');
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
		$sql = ('SELECT class_lesson_sequence_id, lob_id
			FROM class_lesson_sequence
			WHERE lesson_id = '.$this->lessonId.'
			AND class_id = '.$this->classId.'
			AND lob_type = "'.$type.'"
			AND lob_id NOT IN ('.implode(',',$contentIds).')');

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
		$sql = ('SELECT class_lesson_sequence_id, lob_id
			FROM class_lesson_sequence
			WHERE lesson_id = '.$this->lessonId.'
			AND class_id = '.$this->classId.'
			AND lob_type = "'.$type.'"
			AND lob_id IN ('.implode(',',$contentIds).')');

		$keepers = array();
		$db->query($sql);
		while ($db->nextRecord()) {
			$keepers[] = $db->record['lob_id'];
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
		(lesson_id,class_id, lob_id, lob_type, lob_title, lob_mime, link_text, rank)
		VALUES (%d, %d, %d, "'.$type.'", "%s", "%s", "%s",%d)';

		//debug($contentIds);
		//debug($lobData);
		foreach($contentIds as $k=>$v) {
			if ($v < 1 ) continue;
			$lob = $lobData[$v];
			$topRank++;
			$db->query( sprintf($insert, $this->lessonId, $this->classId, $v, $lob['lob_title'], $lob['lob_mime'], $lob['lob_urltitle'], $topRank));
		}
	}

}
