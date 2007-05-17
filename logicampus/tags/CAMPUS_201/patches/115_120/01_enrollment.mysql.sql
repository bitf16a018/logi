#
# MySQLDiff 1.5.0
#
# http://www.mysqldiff.org
# (c) 2001-2004, Lippe-Net Online-Service
#
# Create time: 21.04.2007 10:56
#
# --------------------------------------------------------
# Source info
# Host: localhost
# Database: campus115
# --------------------------------------------------------
# Target info
# Host: localhost
# Database: campus
# --------------------------------------------------------
#

SET FOREIGN_KEY_CHECKS = 0;

#
# DDL START
#
CREATE TABLE class_enrollment (
	    class_enrollment_id int(11) NOT NULL auto_increment,
	    student_id int(11) NOT NULL DEFAULT '0' COMMENT '',
	    semester_id int(11) NOT NULL DEFAULT '0' COMMENT '',
	    class_id int(11) NOT NULL DEFAULT '0' COMMENT '',
	    section_number int(11) NOT NULL DEFAULT '0' COMMENT '',
	    enrolled_on int(11) NOT NULL DEFAULT '0' COMMENT '',
	    active int(11) NOT NULL DEFAULT '0' COMMENT '',
	    withdrew_on int(11) NOT NULL DEFAULT '0' COMMENT '',
	    PRIMARY KEY (class_enrollment_id),
	    INDEX student_idx (student_id),
	    INDEX semester_idx (semester_id),
	    INDEX class_idx (class_id),
	    INDEX active_idx (active)
);

#
# DDL END
#

INSERT INTO `class_enrollment` (student_id, semester_id, class_id, section_number, enrolled_on, active, withdrew_on)
SELECT 
             A.id_student
            , A.semester_id
            , C.id_classes
            , A.sectionNumber
            , UNIX_TIMESTAMP(B.dateRegistrationStart)
            , A.active
            , UNIX_TIMESTAMP(A.dateWithdrawn)
FROM `class_student_sections` AS A
LEFT JOIN semesters AS B ON A.semester_id = B.id_semesters
LEFT JOIN class_sections AS C ON C.sectionNumber = A.sectionNumber;

DROP TABLE `class_student_sections`;

SET FOREIGN_KEY_CHECKS = 1;
