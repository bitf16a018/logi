<?php

/**
 * Class Utilities
 *
 * @package lib
 */
class ClassUtility {


	/**
	 * Copy one class setup over another, removing all information about
	 * the destination class.
	 *
	 * Available class features are:
	 * <ul><li>Assessments</li><li>Lessons</li><li>Assignments</li></ul>
	 *
	 * @static
	 * @param int $source_class_id
	 * @param int $dest_class_id
	 * @param array $features an array of feature of the class to copy
	 */
	function copyClass($source_class_id, $dest_class_id ,$features ) {
		$db = DB::getHandle();
		//what to update: 
		// assignments, assignments_link 
		// assessment_lesson_link
		// gradebook, gradebook_categories, gradebook_entries
		// class_lessons, class_lesson_links, class_lesson_content, class_links, class_links_categories, class_objectives, class_lesson_objectives
		// class_syllabuses

		// don't do this anymore
		// classdoclib_Files, Folders, Sharing

		//what not to update, announcements
		// assignments_grades
		// class_presentations 
		// class_sections
		// class_student_sections
		// 

		//need info on (exams, textbooks)

		$dest_class_id = $dest_class_id;

		$source_class_id = $source_class_id;

		//USE PBDO
		include_once(LIB_PATH.'PBDO/ClassAssignments.php');
		#include_once(LIB_PATH.'PBDO/ClassAssignmentsLink.php');
		include_once(LIB_PATH.'PBDO/ClassLessonContent.php');
		include_once(LIB_PATH.'PBDO/ClassLessons.php');
		include_once(LIB_PATH.'PBDO/ClassLinks.php');
		include_once(LIB_PATH.'PBDO/ClassLinksCategories.php');
		include_once(LIB_PATH.'PBDO/ClassFaqs.php');
		include_once(LIB_PATH.'PBDO/ClassObjectives.php');
		include_once(LIB_PATH.'PBDO/ClassSyllabuses.php');

		include_once(LIB_PATH.'PBDO/Assessment.php');
		include_once(LIB_PATH.'PBDO/AssessmentQuestion.php');

		include_once(LIB_PATH.'ClassGradebook.php');
		include_once(LIB_PATH.'ClassGradebookCategories.php');
		include_once(LIB_PATH.'ClassGradebookEntries.php');

		// wipe table of new id_classes or class_id (dest_class_id)
		// load an objecti (source_class_id)
		// set _new to true (to force an insert)
		// remove primary key
		// update id_classes or class_id
		// update relationships (if any)
		// save

		// if it's a many to many table,
		// cycle through array of old to new mappings for the lesson
		// select the old relationshp from the table via the old id
		// if the the related data via the old key just pulled from the table
		// insert the new relation into the table with both new keys
		// (does this logic leave orphaned data if there was a class already in 
		//  the copy to slot?)
//print "<pre>\n";

		//class lessons
		//clean out lesson relationships to make room in the destination class
		// no orphaned data this way.
		$pbdoArray = ClassLessonsPeer::doSelect(' id_classes = '.$dest_class_id);
		for ($x = 0; $x < count($pbdoArray); $x++) {
			$pbdo = $pbdoArray[$x];
			$db->query("DELETE FROM class_lesson_links WHERE id_class_lessons = ".$pbdo->getPrimaryKey());
			$db->query("DELETE FROM assessment_lesson_link WHERE lesson_id = ".$pbdo->getPrimaryKey());
		}

		$lessons_old_to_new = array();
		$db->query("DELETE FROM class_lessons WHERE id_classes = $dest_class_id");
		$pbdoArray = ClassLessonsPeer::doSelect(' id_classes = '.$source_class_id);
		for ($x = 0; $x < count($pbdoArray); $x++) {
			$pbdo = $pbdoArray[$x];
			$oldid = $pbdo->idClassLessons;
			$lessons_old_to_new[$oldid] = 0;
			$pbdo->_new = true;
			$pbdo->idClassAssignments = '';
			$pbdo->set('idClasses', $dest_class_id);
			$pbdo->save();
			$lessons_old_to_new[$oldid] = $pbdo->getPrimaryKey();
		}


		//class faqs 
		$db->query("DELETE FROM class_faqs WHERE id_classes = $dest_class_id");
		$pbdoArray = ClassFaqsPeer::doSelect(' id_classes = '.$source_class_id);
		for ($x = 0; $x < count($pbdoArray); $x++) {
			$pbdo = $pbdoArray[$x];
			$pbdo->_new = true;
			$pbdo->idClassFaqs= '';
			$pbdo->set('idClasses', $dest_class_id);
			$pbdo->save();
		}

		//class assignments
		$assignments_old_to_new = array();
		$db->query("DELETE FROM class_assignments WHERE id_classes = $dest_class_id");
		$pbdoArray = ClassAssignmentsPeer::doSelect(' id_classes = '.$source_class_id);
		for ($x = 0; $x < count($pbdoArray); $x++) {
			$pbdo = $pbdoArray[$x];
			$oldid = $pbdo->idClassAssignments;
			$assignments_old_to_new[$oldid] = 0;
			$pbdo->_new = true;
			$pbdo->idClassAssignments = '';
			$pbdo->set('idClasses', $dest_class_id);
			$pbdo->save();
			$assignments_old_to_new[$oldid] = $pbdo->getPrimaryKey();
		}

		//class assignments link (many to many table)
		while ( list($oldid, $newid) = @each($lessons_old_to_new) ) {
			$db->query("SELECT * FROM class_assignments_link WHERE id_class_lessons = ".$oldid);
			while ($db->nextRecord()) {
				$new_assignment = $assignments_old_to_new[$db->record['id_class_assignments']];
				//did this old lesson have an assignment?
				if ( $new_assignment > 0 ) {
					$db->query("INSERT INTO class_assignments_link
					(id_class_lessons,id_class_assignments)
					VALUES
					(".$newid.",".$new_assignment.")");
				}
			}
		}



		//class links categories
		$links_cats_old_to_new = array();
		$db->query("DELETE FROM class_links_categories WHERE id_classes = $dest_class_id");
		$pbdoArray = ClassLinksCategoriesPeer::doSelect(' id_classes = '.$source_class_id);
		for ($x = 0; $x < count($pbdoArray); $x++) {
			$pbdo = $pbdoArray[$x];
			$oldid = $pbdo->idClassLinksCategories;
			$links_cats_old_to_new[$oldid] = 0;
			$pbdo->_new = true;
			$pbdo->idClassLinks = '';
			$pbdo->set('idClasses', $dest_class_id);
			$pbdo->save();
			$links_cats_old_to_new[$oldid] = $pbdo->getPrimaryKey();
		}

		//assume that every old categories is now a new one
		// traverse throu links_cats_old_to_new and update the parent id
		reset($links_cats_old_to_new);
		while ( list($oldid, $newid) = @each($links_cats_old_to_new) ) {
			$db->query('UPDATE class_links_categories SET id_class_links_categories_parent = '.$newid.' where id_class_links_categories_parent = '.$oldid.' and id_classes = '.$dest_class_id);

		}

		//class links
		$links_old_to_new = array();
		$db->query("DELETE FROM class_links WHERE id_classes = $dest_class_id");
		$pbdoArray = ClassLinksPeer::doSelect(' id_classes = '.$source_class_id);
		for ($x = 0; $x < count($pbdoArray); $x++) {
			$pbdo = $pbdoArray[$x];
			$oldid = $pbdo->idClassLinks;
			$links_old_to_new[$oldid] = 0;
			$pbdo->_new = true;
			$pbdo->idClassLinks = '';
			$pbdo->set('idClasses', $dest_class_id);
			$pbdo->set('idClassLinksCategories', sprintf('%d',$links_cats_old_to_new[$pbdo->idClassLinksCategories]));
			$pbdo->save();
			$links_old_to_new[$oldid] = $pbdo->getPrimaryKey();
		}

		//class lesson links (many to many table)
		@reset($lessons_old_to_new);
		while ( list($oldid, $newid) = @each($lessons_old_to_new) ) {
			$db->query("SELECT * FROM class_lesson_links WHERE id_class_lessons = ".$oldid);
			while ($db->nextRecord()) {
				$new_link = $links_old_to_new[$db->record['id_class_links']];
				//did this old lesson have a link?
				if ( $new_link > 0 ) {
					$db->query("INSERT INTO class_lesson_links
					(id_class_lessons,id_class_links)
					VALUES
					(".$newid.",".$new_link.")");
				}
			}
		}




		//class objectives
		$objectives_old_to_new = array();
		$db->query("DELETE FROM class_objectives WHERE id_classes = $dest_class_id");
		$pbdoArray = ClassObjectivesPeer::doSelect(' id_classes = '.$source_class_id);
		for ($x = 0; $x < count($pbdoArray); $x++) {
			$pbdo = $pbdoArray[$x];
			$oldid = $pbdo->idClassObjectives;
			$objectives_old_to_new[$oldid] = 0;
			$pbdo->_new = true;
			$pbdo->idClassObjectives = '';
			$pbdo->set('idClasses', $dest_class_id);
			$pbdo->save();
			$objectives_old_to_new[$oldid] = $pbdo->getPrimaryKey();
		}


		//class lesson objectives (many to many table)
		@reset($lessons_old_to_new);
		while ( list($oldid, $newid) = @each($lessons_old_to_new) ) {
			$db->query("SELECT * FROM class_lesson_objectives WHERE id_class_lesson = ".$oldid);
			while ($db->nextRecord()) {
				$new_objective = $objectives_old_to_new[$db->record['id_class_objectives']];
				//did this old lesson have a link?
				if ( $new_objective > 0 ) {
					$db->query("INSERT INTO class_lesson_objectives
					(id_class_lesson,id_class_objectives)
					VALUES
					(".$newid.",".$new_objective.")");
				}
			}
		}


		//no more many to many relationships
		// basically no more lesson data



		//class lesson content
		$db->query("DELETE FROM class_lesson_content WHERE id_classes = $dest_class_id");
		$pbdoArray = ClassLessonContentPeer::doSelect(' id_classes = '.$source_class_id);
		for ($x = 0; $x < count($pbdoArray); $x++) {
			$pbdo = $pbdoArray[$x];
			$oldid = $pbdo->idClassLessonContent;
			$pbdo->_new = true;
			$pbdo->idClassLessonContent = '';
			$pbdo->set('idClasses', $dest_class_id);
			$pbdo->set('idClassLessons', $lessons_old_to_new[$pbdo->idClassLessons]);
			$pbdo->save();
			$idswap[$oldid] = $pbdo->getPrimaryKey();
		}

// mgk - 8/25/04 - need to swap links to the old content ids to the new ones
		$sql = "select * from class_lesson_content where id_classes=$dest_class_id";
		$db->query($sql);
		$db2 = db::GetHandle();
		while($db->next_record()) {
			$temp = $db->Record['txText'];
			$tempid = $db->Record['id_class_lesson_content'];
			reset($idswap);
			foreach($idswap as $old=>$new) { 
	 $temp = str_replace("/lessons/event=viewcontent/id=$old\"","/lessons/event=viewcontent/id=$new\"",$temp);
			}
			$temp = addslashes($temp);
			$sql = "update class_lesson_content set txText='$temp' where id_class_lesson_content=$tempid";
			$db2->query($sql);
		}

		//class syllabuses
		$db->query("DELETE FROM class_syllabuses WHERE id_classes = $dest_class_id");
		$pbdoArray = ClassSyllabusesPeer::doSelect(' id_classes = '.$source_class_id);
		for ($x = 0; $x < count($pbdoArray); $x++) {
			$pbdo = $pbdoArray[$x];
			$pbdo->_new = true;
			$pbdo->idClassSyllabuses = '';
			$pbdo->set('idClasses', $dest_class_id);
			$pbdo->save();
		}


		//class gradebook
		$db->query("DELETE FROM class_gradebook WHERE id_classes = $dest_class_id");
		$pbdoArray = ClassGradebookPeer::doSelect(' id_classes = '.$source_class_id);
		for ($x = 0; $x < count($pbdoArray); $x++) {
			$pbdo = $pbdoArray[$x];
			$pbdo->_new = true;
			$pbdo->idClassGradebook = '';
			$pbdo->set('idClasses', $dest_class_id);
			$pbdo->save();
		}


		//class gradebook categories
		$db->query("DELETE FROM class_gradebook_categories WHERE id_classes = $dest_class_id");
		$pbdoArray = ClassGradebookCategoriesPeer::doSelect(' id_classes = '.$source_class_id);
		for ($x = 0; $x < count($pbdoArray); $x++) {
			$pbdo = $pbdoArray[$x];
			$pbdo->_new = true;
			$origCat = $pbdo->idClassGradebookCategories;
			$pbdo->idClassGradebookCategories = '';
			$pbdo->set('idClasses', $dest_class_id);
			$pbdo->save();
			$cats[$origCat] = $pbdo->getPrimaryKey();
		}


		//class gradebook entries
		$db->query("DELETE FROM class_gradebook_entries WHERE id_classes = $dest_class_id");
		$pbdoArray = ClassGradebookEntriesPeer::doSelect(' id_classes = '.$source_class_id);
		for ($x = 0; $x < count($pbdoArray); $x++) {
			$pbdo = $pbdoArray[$x];
			$pbdo->_new = true;
			$pbdo->idClassGradebookCategories = $cats[$pbdo->idClassGradebookCategories];
			$pbdo->idClassGradebookEntries = '';
			$pbdo->set('idClasses', $dest_class_id);
			$pbdo->save();
			$gbtestentries[$pbdo->assessmentId] = $pbdo->getPrimaryKey();
			$gbassignmententries[$pbdo->assignmentId] = $pbdo->getPrimaryKey();

		}


               //class quizzess/assessments
	       $assessments_old_to_new = array();
               $db->query("DELETE FROM assessment WHERE class_id= $dest_class_id");
               $pbdoArray = Assessment2Peer::doSelect(' class_id= '.$source_class_id);

               $db2 = db::GetHandle();
               for ($x = 0; $x < count($pbdoArray); $x++) {
                       $pbdo = $pbdoArray[$x];
                       $pbdo->_new = true;
                       $origId = $pbdo->assessmentId;
		       $assessments_old_to_new[$origId] = 0;
                       $pbdo->assessmentId= '';
                       $pbdo->set('classId', $dest_class_id);
                       $pbdo->save();
                       $thiskey = $pbdo->getPrimaryKey();
		       $assessments_old_to_new[$origId] = $thiskey;
                       $ids[$origId] = $thiskey;
                       // update the assessment id in the gradebook entry with the new one
                       if ($gbtestentries[$origId]>0)  {
                               $db->query("update class_gradebook_entries set assessment_id=$thiskey where id_class_gradebook_entries=".$gbtestentries[$origId]." and assessment_id>0");
                       }
                       if ($gbassignmententries[$origId]>0)  {
                               $db->query("update class_gradebook_entries set assignment_id=$thiskey where id_class_gradebook_entries=".$gbassignmententries[$origId]." and assignment_id>0");
                       }
               }
 reset($ids);
               while(list($origId,$thiskey) = each($ids)) {
                       $db2->query("DELETE FROM assessment_question WHERE assessment_id= ".$thiskey);
                       $pbdoArray = AssessmentQuestion2Peer::doSelect(' assessment_id= '.$origId);
                       for ($y = 0; $y < count($pbdoArray); $y++) {
                               $pbdo2 = $pbdoArray[$y];
                               $pbdo2->_new = true;
                               $pbdo2->assessmentId= $thiskey;
                               $pbdo2->assessmentQuestionId= '';
                               $pbdo2->save();
                       }
		}

		//assessment lesson link (one to many table)
		@reset($lessons_old_to_new);
		while ( list($oldid, $newid) = @each($lessons_old_to_new) ) {
			$db->query("SELECT * FROM assessment_lesson_link WHERE lesson_id = ".$oldid);
			while ($db->nextRecord()) {
				$new_assessment = $assessments_old_to_new[$db->record['assessment_id']];
				//did this old lesson have a link?
				if ( $new_assessment > 0 ) {
					$db->query("INSERT INTO assessment_lesson_link
					(lesson_id,assessment_id)
					VALUES
					(".$newid.",".$new_assessment.")");
				}
			}
		}
	}


	/**
	 * Copy the file resources from one class into another
	 *
	 * Put all the copied files in a folder called 'Copied From (courseFamilyNumber)
	 *
	 * @static
	 * @param int $source_class_id
	 * @param int $dest_class_id
	 * @return array an array with a 'message' of good and bad uploads
	 */
	function copyFileResources($source_class_id, $dest_class_id ,$features ) {
		include_once(LIB_PATH."documentLibraryLib.php");

		$sourceClass = classObj::_getFromDB($source_class_id,'id_classes');
		$destClass = classObj::_getFromDB($dest_class_id,'id_classes');
		$sourceFaculty = $sourceClass->facultyId;
		$destFaculty = $destClass->facultyId;

		//make a new folder in the destination class
		//TODO: delete the contents if you find a similarly named folder
		$importFolder = new LC_folder();

		$importFolder->name = 'Copied From ('.$sourceClass->courseFamilyNumber.')';
		$importFolder->owner = $destFaculty;
		$importFolder->folderType = 2;	//user definable folder

		$importFolder_pkey = $importFolder->_save('classdoclib_Folders');

		//get a copy of the resources in source class
		// scan each piece of content for referenced links
		// then use the hash ids to pull the source files "in use"
		// only copy those.  The relationship between file and class
		// was at the folder level, but it has been destroyed.
		$sourceContent = ClassUtility::getClassContent($source_class_id);

		$finalMatches = array();
		foreach($sourceContent as $k=>$v) {
			$matches = array();
	 		$count = preg_match("/\/fhash=[0-9a-zA-Z]{32}/",$v['txText'],$matches);
			if ($count > 0 ) {
				$finalMatches = array_merge($finalMatches,$matches);
			}
		}
		$finalMatches = array_unique($finalMatches);

		//load the full file paths into memory
		$db = DB::getHandle();
		$db->RESULT_TYPE = MYSQL_ASSOC;
		foreach($finalMatches as $k =>$v ) {
			$v = str_replace('/fhash=','',$v);
			$db->query("SELECT * FROM classdoclib_Files
			WHERE daHasha = '$v'");
			$db->nextRecord();
			$files[] = $db->record;
			$filePaths[] = LC_DiskRepository::getFullPath($db->record['diskName']);
			$oldHashes[] = $v;
		}

		//re-insert them into the DB, they know how to copy themselves on the disk
		static $hash_count = 2;
		$newUploads = array(); //hold the map of old to new hashes
		foreach ($files as $k => $v) {
			$tmp = new LC_file();
			$tmp->size = $v['size'];
			$tmp->file = $v['file'];
			$tmp->tmpfile = $filePaths[$k];
			$tmp->mime = $v['mime'];

			$tmp->daHasha = md5($tmp->size.microtime().$hash_count++.$tmp->file);

			$tmp->displayname = $v['displayname'];
			$tmp->description = $v['description'];
			$tmp->owner = $destFaculty;
			$tmp->filedate = $v['filedate'];
			$tmp->folder = $importFolder_pkey;

			if(! $tmp->save() ) {
				$baduploads .= '<p>'.$tmp->file .'  was not handled properly<p>';
			} else {
				$gooduploads .= '<li>'.$tmp->file .'</li>';
				$newUploads[$oldHashes[$k]] = $tmp;
			}
		}

		if ($baduploads) {
			$ret['error_message'] .= 'There was a problem with the file uploads.  Not all of the uploads were successfully processed.<BR>';
			$ret['error_message'] .= $baduploads;
		}
		if ($gooduploads) {
			$ret['message'] .= '<p>The following files were successfully uploaded and saved: <p><ul>';
			$ret['message'] .= $gooduploads;
			$ret['message'] .= '</ul>';
		}

		//finally, update all the content in the new class
		$destContent = ClassUtility::getClassContent($dest_class_id);
		foreach($destContent as $k=>$v) {
			$temp = $v['txText'];
			$tempid = $v['id_class_lesson_content'];
			reset($newUploads);
			foreach($newUploads as $oldHash=>$newFile) { 
				$temp = str_replace("/fhash=$oldHash\"",
				"/fhash=".$newFile->daHasha."\"",$temp);
			}
			$temp = addslashes($temp);
//			debug( $temp );
			$sql = "update class_lesson_content set txText='$temp' where id_class_lesson_content=$tempid";
			$db->query($sql);
		}
		//return the messages
		return $ret;
	}


	/**
	 * Retrieve all the content files from a class
	 *
	 * @return array Struct of database records
	 */
	function getClassContent($class_id) {
		$db = DB::getHandle();
		$db->RESULT_TYPE = MYSQL_ASSOC;
		$sql = "select * from class_lesson_content where id_classes=$class_id";
		$db->query($sql);
		$ret = array();
		while($db->nextRecord()) {
			$ret[] = $db->record;
		}
		return $ret;
	}


	/**
	 * Return a list of usernames in this class
	 *
	 * @return array List of usernames
	 */
	function getUsernameList($class_id) {
		$db = DB::getHandle();
		$db->RESULT_TYPE = MYSQL_ASSOC;
		$sql = "SELECT id_student 
	       		FROM class_student_sections AS A 
			LEFT JOIN class_sections AS B
			using (sectionNumber)
			WHERE B.id_classes=$class_id";
		$db->query($sql);
		$ret = array();
		while($db->nextRecord()) {
			$ret[] = $db->record['id_student'];
		}
		return $ret;
	}
}

?>
