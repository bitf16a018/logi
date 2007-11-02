UPDATE lcEvents, assessment
set lcEvents.startdate=assessment.date_available,
 lcEvents.enddate=assessment.date_unavailable
WHERE 1=1
AND assessment.assessment_id = lcEvents.id_item
AND lcEvents.calendarType = 'assessmentscheduling';

# Connection: local
# Host: localhost
# Saved: 2005-08-25 21:33:29
#
--cols needed
-- calendarType, username, title, startdate, enddate, groups, notgroups, lastmodified,
-- id_item, id_classes, f_allday=1, f_showwhenactive=1
INSERT INTO lcEvents (calendarType, username, title, startdate, enddate, groups, notgroups, lastmodified, id_item, id_classes, f_allday, f_showwhenactive)
SELECT 'assessmentscheduling' AS calendarType,
    B.facultyId AS username,
    A.display_name as title, 
    A.date_available as startdate,
    A.date_unavailable as enddate,
    '|students|' as groups,
    '|pub|' as notgroups,
    NOW() as lastmodified,
    A.assessment_id AS id_item,
    B.id_classes,
    1 AS  f_allday,
    1 AS f_showwhenactive
FROM `assessment` AS A

LEFT JOIN assessment_event_link D
  ON A.assessment_id = D.assessment_id

LEFT join lcEvents AS C
  ON D.assessment_id = C.id_item

left join classes B 
 on A.class_id = B.id_classes

WHERE 1=1
--AND B.id_semesters =13
AND D.assessment_id IS NULL
