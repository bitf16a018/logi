<?php

include_once(LIB_PATH.'PBDO/ClassLessons.php');
include_once(LIB_PATH.'PBDO/ClassLessonSequence.php');
include_once(LIB_PATH.'lesson/lc_lesson.php');

/**
 * Process Lesson XML formats
 */
class Lc_Lesson_Xml {

	
	/**
	 * return an Lc_Lesson object
	 *
	 * @static
	 */
	function parseNode($n) {
		
		/*
	'idClassLessons'=>'integer',
	'idClasses'=>'integer',
	'createdOn'=>'integer',
	'title'=>'varchar',
	'description'=>'longvarchar',
	'activeOn'=>'integer',
	'inactiveOn'=>'integer',
	'checkList'=>'longvarchar');
		 */

		$lessonDo = new ClassLessons();

		$result = $n->getElementsByTagname('title');
		$title = $result->item(0);
		$lessonDo->title = $title->nodeValue;

		$result = $n->getElementsByTagname('description');
		$description = $result->item(0);
		$lessonDo->description = $description->nodeValue;

		// TODO: double check the DB id belongs to this user.
		$dbid = $n->getAttribute('dbid');
		$lessonDo->idClassLessons = $dbid;

		$lessonObj = Lc_Lesson::create($lessonDo);

		$guid = $n->getAttribute('guid');
		$lessonObj->setGuid($guid);
		return $lessonObj;
	}


	function parseSequenceNodes($learningPathNode) {
		$seqNodes = $learningPathNode->getElementsByTagname('lobsequence');
		$len = $seqNodes->length;
		$seqItems = array();
		for ($x=0; $x < $len; $x++) {
			$_seqNode = $seqNodes->item($x);
			$_seqItem = new ClassLessonSequence();
			$_start = $_seqNode->getElementsByTagname('start')->item(0);
			$_seqItem->startOffset = $_start->nodeValue - ( $_start->nodeValue % 86400 );
			$_seqItem->startTime   = ($_start->nodeValue % 86400);
			$_lobNode = $_seqNode->getElementsByTagname('lob')->item(0);
			$_seqItem->guid = $_lobNode->getAttribute('refid');
			$seqItems[] = $_seqItem;
		}
		return $seqItems;
	}
}

?>
