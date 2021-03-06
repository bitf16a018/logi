
INSERT INTO semesters (id_semesters, semesterId, semesterTerm, dateCensus, dateFinalDrop, dateDeactivation, dateStart, dateEnd, dateRegistrationStart, dateRegistrationEnd, dateAccountActivation, dateStudentActivation, semesterYear, dateStartITVseminar, dateEndITVseminar, dateStartOrientation, dateEndOrientation, dateStartTextbook, dateEndTextbook, dateStartExam, dateEndExam) VALUES (1, CONCAT(IF(MONTH(NOW()) < 7,'SP','WI'), YEAR(SUBDATE(NOW(),INTERVAL 4 MONTH))), IF (MONTH(NOW()) < 7,'Spring','Winter'), ADDDATE(NOW(),INTERVAL 2 DAY), ADDDATE(NOW(),INTERVAL 30 DAY), ADDDATE(NOW(),INTERVAL 4 MONTH), SUBDATE(NOW(),INTERVAL 1 MONTH), ADDDATE(NOW(),INTERVAL 4 MONTH), SUBDATE(NOW(),INTERVAL 2 MONTH), SUBDATE(NOW(),INTERVAL 1 MONTH), SUBDATE(NOW(),INTERVAL 2 MONTH), SUBDATE(NOW(),INTERVAL 1 MONTH), YEAR(ADDDATE(NOW(),INTERVAL 4 MONTH)), SUBDATE(NOW(),INTERVAL 2 MONTH), ADDDATE(NOW(),INTERVAL 2 MONTH), SUBDATE(NOW(),INTERVAL 2 MONTH), ADDDATE(NOW(),INTERVAL 2 MONTH), SUBDATE(NOW(),INTERVAL 2 MONTH), ADDDATE(NOW(),INTERVAL 2 MONTH), SUBDATE(NOW(),INTERVAL 2 MONTH), ADDDATE(NOW(),INTERVAL 2 MONTH));

INSERT INTO semesters (id_semesters, semesterId, semesterTerm, dateCensus, dateFinalDrop, dateDeactivation, dateStart, dateEnd, dateRegistrationStart, dateRegistrationEnd, dateAccountActivation, dateStudentActivation, semesterYear, dateStartITVseminar, dateEndITVseminar, dateStartOrientation, dateEndOrientation, dateStartTextbook, dateEndTextbook, dateStartExam, dateEndExam) VALUES (2, CONCAT(IF(MONTH(NOW()) < 7,'SM','FA'), YEAR(SUBDATE(NOW(),INTERVAL 4 MONTH))), IF (MONTH(NOW()) < 7,'Summer','Fall'), ADDDATE(NOW(),INTERVAL 2 DAY), ADDDATE(NOW(),INTERVAL 30 DAY), ADDDATE(NOW(),INTERVAL 5 MONTH), ADDDATE(NOW(),INTERVAL 2 MONTH), ADDDATE(NOW(),INTERVAL 5 MONTH), ADDDATE(NOW(),INTERVAL 3 MONTH), ADDDATE(NOW(),INTERVAL 2 MONTH), SUBDATE(NOW(),INTERVAL 1 MONTH), ADDDATE(NOW(),INTERVAL 2 MONTH), YEAR(ADDDATE(NOW(),INTERVAL 5 MONTH)), ADDDATE(NOW(),INTERVAL 3 MONTH), ADDDATE(NOW(),INTERVAL 3 MONTH), ADDDATE(NOW(),INTERVAL 3 MONTH), ADDDATE(NOW(),INTERVAL 3 MONTH), ADDDATE(NOW(),INTERVAL 3 MONTH), ADDDATE(NOW(),INTERVAL 3 MONTH), ADDDATE(NOW(),INTERVAL 3 MONTH), ADDDATE(NOW(),INTERVAL 3 MONTH));

INSERT INTO semesters_course_info (id_semesters, campusClosings, lateGuidelines, noChildren, withdrawalPolicy, gradeVerify, examInfo, gradeChallenge, leaseKit, campusViewing, testingLocations, itvGrades, cable, textbooks, helpdesk, syllabusDisclaimer, specialInfo, testHours, accessClassSite, emailGuidelines, studentConduct) VALUES (1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

INSERT INTO semesters_course_info (id_semesters, campusClosings, lateGuidelines, noChildren, withdrawalPolicy, gradeVerify, examInfo, gradeChallenge, leaseKit, campusViewing, testingLocations, itvGrades, cable, textbooks, helpdesk, syllabusDisclaimer, specialInfo, testHours, accessClassSite, emailGuidelines, studentConduct) VALUES (2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

INSERT INTO lcEvents (pkey, calendarID, calendarType, username, title, description, location, startdate, enddate, groups, notgroups, lastmodified, repeatType, repeatCount, repeatData, repeatExclude, repeatUntil, id_item, id_item_sub, id_classes, f_allday, f_showwhenactive) VALUES (1, '', '', 'admin', '<font color="MediumBlue">Thanksgiving Day</font>', 'Happy Thanks Giving!!!', '', 1069977600, 1069977600, '|public|', '', 20031118155605, 0, 0, '', '', -1, 0, 0, 0, 1, 0);


INSERT INTO courses (id_courses, courseFamily, courseNumber, courseName, courseDescription, preReq1, preReq2, preReq3, preReq4, coReq1, coReq2, coReq3, coReq4) VALUES (1, 'ENGL', 1101, 'American Literature I', 'American literature from its beginnings to the late 19th century.', '', '', '', '', '', '', '', '');

INSERT INTO courses (id_courses, courseFamily, courseNumber, courseName, courseDescription, preReq1, preReq2, preReq3, preReq4, coReq1, coReq2, coReq3, coReq4) VALUES (2, 'ENGL', 1401, 'World Literature I', 'onsists of the following options from selected works of literature.\r\nA. Survey of World Literature.\r\nWorld literature from its beginnings through the 17th century.\r\nB. Themes in World Literature.\r\nReadings, lectures, and discussions of selected philosophical themes in world masterpieces. (Themes may vary from semester to semester.)\r\nC. Genres in World Literature.\r\nReadings, lectures, and discussions of selected masterpieces written by authors of international prominence in genres such as novels and short stories.\r\nH. Honors World Literature.\r\nA first-semester honors course surveying major ideas and techniques in world literature.', '', '', '', '', '', '', '', '');

INSERT INTO courses (id_courses, courseFamily, courseNumber, courseName, courseDescription, preReq1, preReq2, preReq3, preReq4, coReq1, coReq2, coReq3, coReq4) VALUES (3, 'GEOG', 1300, 'Elements of Natural Geography', 'Basic physical elements of geography, maps, weather and climate, landforms, and natural resources.', '', '', '', '', '', '', '', '');

INSERT INTO courses (id_courses, courseFamily, courseNumber, courseName, courseDescription, preReq1, preReq2, preReq3, preReq4, coReq1, coReq2, coReq3, coReq4) VALUES (4, 'GOVT', 2305, 'United States Government', 'United States constitutional and governmental systems.', '', '', '', '', '', '', '', '');

INSERT INTO courses (id_courses, courseFamily, courseNumber, courseName, courseDescription, preReq1, preReq2, preReq3, preReq4, coReq1, coReq2, coReq3, coReq4) VALUES (5, 'SPCH', 1601, 'Interpersonal Communication', 'Theory and practice in person-to-person communication with focus on development, maintenance, and termination of relationships.', '', '', '', '', '', '', '', '');

INSERT INTO courses (id_courses, courseFamily, courseNumber, courseName, courseDescription, preReq1, preReq2, preReq3, preReq4, coReq1, coReq2, coReq3, coReq4) VALUES (6, 'BUSG', 1315, 'Small Business Operations', 'A course in the unique aspects of managing a small business. Topics address management functions including how managers plan, exercise leadership, organize, and control the operations. Examines the decision-making process and strategies needed to operate a business successfully.', '', '', '', '', '', '', '', '');

INSERT INTO courses (id_courses, courseFamily, courseNumber, courseName, courseDescription, preReq1, preReq2, preReq3, preReq4, coReq1, coReq2, coReq3, coReq4) VALUES (7, 'PSYC', 2301, 'Introduction to Psychology', 'Methods and content of the science of psychology.', '', '', '', '', '', '', '', '');

INSERT INTO courses (id_courses, courseFamily, courseNumber, courseName, courseDescription, preReq1, preReq2, preReq3, preReq4, coReq1, coReq2, coReq3, coReq4) VALUES (8, 'COSC', 1420, 'C Programming', 'Structured programming technique using the C language.', '', '', '', '', '', '', '', '');



INSERT INTO `classes` (`id_classes`, `id_courses`, `id_semesters`, `sectionNumbers`, `classType`, `facultyId`, `courseFamily`, `courseNumber`, `courseFamilyNumber`, `stylesheet`, `id_class_resource`, `noexam`) VALUES (1, 6, 1, '', 'Internet', 'teacher1', 'BUSG', 1315, 'BUSG1315', '', 1, 0);
INSERT INTO `classes` (`id_classes`, `id_courses`, `id_semesters`, `sectionNumbers`, `classType`, `facultyId`, `courseFamily`, `courseNumber`, `courseFamilyNumber`, `stylesheet`, `id_class_resource`, `noexam`) VALUES (2, 1, 1, '', 'Internet', 'teacher1', 'ENGL', 1401, 'ENGL1401', '', 0, 0);


INSERT INTO `class_gradebook` (`id_class_gradebook`, `id_classes`, `a_upper`, `a_lower`, `b_lower`, `c_lower`, `d_lower`, `calculation_type`, `color_missing_grade`, `roundScoresUp`, `total_points`) VALUES (1, 1, 0, 0, 0, 0, 0, 0, 'FFC2CD', 0, 0);
INSERT INTO `class_gradebook` (`id_class_gradebook`, `id_classes`, `a_upper`, `a_lower`, `b_lower`, `c_lower`, `d_lower`, `calculation_type`, `color_missing_grade`, `roundScoresUp`, `total_points`) VALUES (2, 2, 0, 0, 0, 0, 0, 0, 'FFC2CD', 0, 0);
  

INSERT INTO `class_gradebook_categories` (`id_class_gradebook_categories`, `id_classes`, `label`, `weight`, `drop_count`) VALUES (1, 2, 'TESTS', NULL, NULL);
        

INSERT INTO `class_sections` (`sectionNumber`, `id_classes`) VALUES (1111, 1);
INSERT INTO `class_sections` (`sectionNumber`, `id_classes`) VALUES (1112, 1);
INSERT INTO `class_sections` (`sectionNumber`, `id_classes`) VALUES (2111, 2);
INSERT INTO `class_sections` (`sectionNumber`, `id_classes`) VALUES (2112, 2);



INSERT INTO `class_student_sections` (`sectionNumber`, `id_student`, `semester_id`, `active`, `dateWithdrawn`) VALUES (1111, 'bart.simpson', 1, 1, NULL);
INSERT INTO `class_student_sections` (`sectionNumber`, `id_student`, `semester_id`, `active`, `dateWithdrawn`) VALUES (2111, 'lisa.simpson', 1, 1, NULL);
INSERT INTO `class_student_sections` (`sectionNumber`, `id_student`, `semester_id`, `active`, `dateWithdrawn`) VALUES (1112, 'nelson.muntz', 1, 1, NULL);
INSERT INTO `class_student_sections` (`sectionNumber`, `id_student`, `semester_id`, `active`, `dateWithdrawn`) VALUES (2112, 'ralph.wiggum', 1, 1, NULL);



INSERT INTO exam_schedule_dates VALUES (1, 1, CONCAT(YEAR(ADDDATE(NOW(),INTERVAL 1 MONTH)),'-',MONTH(ADDDATE(NOW(),INTERVAL 1 MONTH)),'-',DAYOFMONTH(ADDDATE(NOW(),INTERVAL 1 MONTH)),' 14:00:00'), CONCAT(YEAR(ADDDATE(NOW(),INTERVAL 1 MONTH)),'-',MONTH(ADDDATE(NOW(),INTERVAL 1 MONTH)),'-',DAYOFMONTH(ADDDATE(NOW(),INTERVAL 1 MONTH)),' 18:00:00'));

INSERT INTO exam_schedule_dates VALUES (2, 1, CONCAT(YEAR(ADDDATE(NOW(),INTERVAL 1 MONTH)),'-',MONTH(ADDDATE(NOW(),INTERVAL 1 MONTH)),'-',DAYOFMONTH(ADDDATE(NOW(),INTERVAL 1 MONTH)),' 14:00:00'), CONCAT(YEAR(ADDDATE(NOW(),INTERVAL 1 MONTH)),'-',MONTH(ADDDATE(NOW(),INTERVAL 1 MONTH)),'-',DAYOFMONTH(ADDDATE(NOW(),INTERVAL 1 MONTH)),' 18:00:00'));



INSERT INTO exam_schedule_classes VALUES (1, 1, 1, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, '');



INSERT INTO orientation_dates VALUES (1, 1, ADDDATE(NOW(),INTERVAL 1 MONTH), '14:10:00', '18:10:00');

INSERT INTO orientation_dates VALUES (2, 1, ADDDATE(NOW(),INTERVAL 20 DAY), '08:00:00', '18:00:00');



INSERT INTO classdoclib_Folders VALUES (2526, 'Trash', 0, 'teacher', 1, 'Place files viewable by your classroom in here.', '', 0, 0);

INSERT INTO classdoclib_Folders VALUES (2527, 'Classroom', 0, 'teacher', 1, 'Place files viewable by your classroom in here.', '', 0, 1);

INSERT INTO classdoclib_Folders VALUES (2528, 'Web Images', 0, 'teacher', 1, 'Place images for your lesson web pages here.', '', 0, 1);

INSERT INTO classdoclib_Folders VALUES (2529, 'Assignments', 0, 'teacher', 1, 'Use this folder to store assignments for students that are not uploaded via the assignments manager.', '', 0, 1);
