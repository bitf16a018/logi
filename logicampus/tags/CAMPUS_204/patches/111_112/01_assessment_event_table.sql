CREATE TABLE `assessment_event_link` (

	`assessment_event_link_id` int (10) NOT NULL auto_increment,  --

	`assessment_id` int (10),  --

	`lc_event_id` int (10),  --

	PRIMARY KEY (assessment_event_link_id)
)TYPE=InnoDB;

CREATE INDEX assessment_idx ON assessment_event_link (assessment_id);
CREATE INDEX lc_event_idx ON assessment_event_link (lc_event_id);

insert into assessment_event_link (assessment_id,lc_event_id)
SELECT B.assessment_id, A.pkey
FROM lcEvents A
left join `assessment` B
  ON A.id_item = B.assessment_id
LEFT JOIN `classes` C
  ON A.id_classes = C.id_classes
WHERE 1=1
AND A.calendarType = 'assessmentscheduling';
