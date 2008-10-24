/* classes key was changed to avoid collisions */
UPDATE lcPerms SET `action`='adminclasses' where moduleID='administration' and `action`='classes';

DELETE FROM lcConfig WHERE mid='administration' AND k='_serviceFiles';
DELETE FROM lcConfig WHERE mid='administration' AND k='_serviceAdministration';

INSERT INTO lcConfig VALUES ('administration', '_serviceFiles', 'adminclasses.lcp=Classes Administration,courses.lcp=Courses Administration,groups.lcp=Group Administration,mod.lcp=Message of the Day,semesters.lcp=Manage Semesters,servicePermissions.lcp=Manage group permissions,users.lcp=User Administration', 'textarea', '');

INSERT INTO lcConfig VALUES ('administration', '_servicesAdministration', 'groups=Group Administration,adminclasses=Manage Classes,enrollment=Manage Class Enrollment,courses=Manage Courses,servicePermissions=Manage Group Permissions,mod=Message of the Day,semesters=Manage Semesters,users=Manage Users', 'textarea', '');
