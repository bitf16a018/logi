<?php

include_once(LIB_PATH.'PBDO/ClassLessons.php');
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

		// TODO: double check the DB id belongs to this user.
		$dbid = $n->getAttribute('dbid');
		$lessonDo->idClassLessons = $dbid;

		$lessonObj = Lc_Lesson::create($lessonDo);

		$guid = $n->getAttribute('guid');
		$lessonObj->setGuid($guid);
		return $lessonObj;
		/*
		$children = $type->childNodes;
		$content = '';
		if ($children->length) {
			$content = trim($children->item(0)->nodeValue);
			$guid = $n->getAttribute('guid');
			$dbid = $n->getAttribute('dbid');
		}
		else {
			die ('unknown class: '. get_class($type)); 
			return null;
		}

		$lob = null;
		$lob    = new LobRepoEntry();
		$lob->set('lobGuid',$guid);
		switch ($content) {
			case 'content':
				$lob->set('lobType','content');
				break;
			case 'activity':
				$lob->set('lobType','activity');
				break;
			case 'test':
				$lob->set('lobType','test');
				break;
		}
		if ($lob->lobType == '') { return null; die ('unknown type '. $content); }


		$result = $n->getElementsByTagname('title');
		$node = $result->item(0);
		$children = $node->childNodes;
		$lob->set('lobTitle', trim($children->item(0)->nodeValue) );

		$result = $n->getElementsByTagname('content');
		$node = $result->item(0);
		if (is_object($node) ){
			$children = $node->childNodes;
			$lob->set('lobContent', trim($children->item(0)->nodeValue) );
		}

		$result = $n->getElementsByTagname('filename');
		$node = $result->item(0);
		if (is_object($node) ){
			$children = $node->childNodes;
			$lob->set('lobFilename', trim($children->item(0)->nodeValue) );

			$urlTitle = Lc_Lob_Util::createLinkText(trim($children->item(0)->nodeValue));
			$lob->set('lobUrltitle', $urlTitle );
			$lob->set('lobBinary', file_get_contents($this->tempdir.'/content/'.trim($children->item(0)->nodeValue)) );
		} else {
			$urlTitle = Lc_Lob_Util::createLinkText(trim( $lob->get('lobTitle')) );
			$lob->set('lobUrltitle', $urlTitle );
		}

		$result = $n->getElementsByTagname('description');
		$node = $result->item(0);
		if (is_object($node) ){
			$children = $node->childNodes;
			$lob->set('lobDescription', trim($children->item(0)->nodeValue) );
		}


		$result = $n->getElementsByTagname('subtype');
		$node = $result->item(0);
		if (is_object($node) ){
			$children = $node->childNodes;
			$lob->set('lobSubType', trim($children->item(0)->nodeValue) );
		}

		$result = $n->getElementsByTagname('mime');
		$node = $result->item(0);
		if (is_object($node) ){
			$children = $node->childNodes;
			$lob->set('lobMime', trim($children->item(0)->nodeValue) );
		}

		return $lob;
//		debug($children);
				*/
	}
}

?>
