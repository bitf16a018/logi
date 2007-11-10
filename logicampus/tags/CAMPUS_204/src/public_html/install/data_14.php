<?
$installTableSchemas = array();
$table = <<<campusdelimeter
INSERT INTO `profile` (`username`, `firstname`, `lastname`, `emailAlternate`, `homePhone`, `workPhone`, `faxPhone`, `cellPhone`, `pagerPhone`, `address`, `address2`, `city`, `state`, `zip`, `showaddinfo`, `url`, `icq`, `aim`, `yim`, `msn`, `showonlineinfo`, `occupation`, `gender`, `sig`, `bio`, `showbioinfo`, `counter`, `emailNotify`, `photo`) VALUES ('admin', 'Seymour', 'Skinner', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Male', '', '', '', 0, '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO `profile` (`username`, `firstname`, `lastname`, `emailAlternate`, `homePhone`, `workPhone`, `faxPhone`, `cellPhone`, `pagerPhone`, `address`, `address2`, `city`, `state`, `zip`, `showaddinfo`, `url`, `icq`, `aim`, `yim`, `msn`, `showonlineinfo`, `occupation`, `gender`, `sig`, `bio`, `showbioinfo`, `counter`, `emailNotify`, `photo`) VALUES ('teacher1', 'Edna', 'Krabappel', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Female', '', '', '', 0, '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO `profile` (`username`, `firstname`, `lastname`, `emailAlternate`, `homePhone`, `workPhone`, `faxPhone`, `cellPhone`, `pagerPhone`, `address`, `address2`, `city`, `state`, `zip`, `showaddinfo`, `url`, `icq`, `aim`, `yim`, `msn`, `showonlineinfo`, `occupation`, `gender`, `sig`, `bio`, `showbioinfo`, `counter`, `emailNotify`, `photo`) VALUES ('teacher2', 'Dewey', 'Largo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Male', '', '', '', 0, '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO `profile` (`username`, `firstname`, `lastname`, `emailAlternate`, `homePhone`, `workPhone`, `faxPhone`, `cellPhone`, `pagerPhone`, `address`, `address2`, `city`, `state`, `zip`, `showaddinfo`, `url`, `icq`, `aim`, `yim`, `msn`, `showonlineinfo`, `occupation`, `gender`, `sig`, `bio`, `showbioinfo`, `counter`, `emailNotify`, `photo`) VALUES ('staff', 'Otto', 'Mann', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Male', '', '', '', 0, '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO `profile` (`username`, `firstname`, `lastname`, `emailAlternate`, `homePhone`, `workPhone`, `faxPhone`, `cellPhone`, `pagerPhone`, `address`, `address2`, `city`, `state`, `zip`, `showaddinfo`, `url`, `icq`, `aim`, `yim`, `msn`, `showonlineinfo`, `occupation`, `gender`, `sig`, `bio`, `showbioinfo`, `counter`, `emailNotify`, `photo`) VALUES ('student1', 'Bart', 'Simpson', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Male', '', '', '', 0, '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO `profile` (`username`, `firstname`, `lastname`, `emailAlternate`, `homePhone`, `workPhone`, `faxPhone`, `cellPhone`, `pagerPhone`, `address`, `address2`, `city`, `state`, `zip`, `showaddinfo`, `url`, `icq`, `aim`, `yim`, `msn`, `showonlineinfo`, `occupation`, `gender`, `sig`, `bio`, `showbioinfo`, `counter`, `emailNotify`, `photo`) VALUES ('student2', 'Lisa', 'Simpson', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Female', '', '', '', 0, '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO `profile` (`username`, `firstname`, `lastname`, `emailAlternate`, `homePhone`, `workPhone`, `faxPhone`, `cellPhone`, `pagerPhone`, `address`, `address2`, `city`, `state`, `zip`, `showaddinfo`, `url`, `icq`, `aim`, `yim`, `msn`, `showonlineinfo`, `occupation`, `gender`, `sig`, `bio`, `showbioinfo`, `counter`, `emailNotify`, `photo`) VALUES ('student3', 'Ralph', 'Wiggum', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Male', '', '', '', 0, '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO `profile` (`username`, `firstname`, `lastname`, `emailAlternate`, `homePhone`, `workPhone`, `faxPhone`, `cellPhone`, `pagerPhone`, `address`, `address2`, `city`, `state`, `zip`, `showaddinfo`, `url`, `icq`, `aim`, `yim`, `msn`, `showonlineinfo`, `occupation`, `gender`, `sig`, `bio`, `showbioinfo`, `counter`, `emailNotify`, `photo`) VALUES ('student4', 'Nelson', 'Muntz', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Male', '', '', '', 0, '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO profile_faculty_coursefamily (username, id_profile_faculty_coursefamily) VALUES ('teacher1', 'ENGL')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO profile_faculty_coursefamily (username, id_profile_faculty_coursefamily) VALUES ('teacher1', 'ARTS')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO profile_faculty_coursefamily (username, id_profile_faculty_coursefamily) VALUES ('teacher2', 'PHYS')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO profile_faculty_coursefamily (username, id_profile_faculty_coursefamily) VALUES ('teacher2', 'CHEM');
campusdelimeter;
$installTableSchemas[] = $table;

?>