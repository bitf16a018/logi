if [ ! $1 ] || [ ! $2 ]
then
	echo 'you need to pass user and password'
	echo './wipe_clean.sh username password (database)'
	echo 'database name defaults to logicampus'
	exit 1
fi


if [ ! $3 ]
then
	db='logicampus';
else
	db=$3;
fi



for x in `echo 'SHOW TABLES' | mysql -u $1 -p$2 $db | tail +2`
do
	echo 'DROPPING '$x' from '$db
	echo 'DROP TABLE '$x | mysql -u $1 -p$2 $db
done


echo '***********************'
echo 'INSTALLING base LC data'
mysql -u $1 -p$2 $db < ../data/setup.sql 
echo 'lcRegistry'
mysql -u $1 -p$2 $db < ../data/lcRegistry.sql 
echo 'lcUsers'
mysql -u $1 -p$2 $db < ../data/lcUsers.sql 
echo 'lcPerms'
mysql -u $1 -p$2 $db < ../data/lcPerms.sql 
echo 'lcForms'
mysql -u $1 -p$2 $db < ../data/lcForms_and_lcFormInfo.sql 
echo 'lcConfig'
mysql -u $1 -p$2 $db < ../data/lcConfig.sql
echo 'lcGroups'
mysql -u $1 -p$2 $db < ../data/lcGroups.sql
echo '***********************'
echo 'INSTALLING base modules'
sh ./install_metainfo.sh $1 $2 $db


echo '***********************'
echo 'POPULATING with dummy data'
mysql -u $1 -p$2 $db < ../data/semesters_and_classes.sql
mysql -u $1 -p$2 $db < ../data/profile.sql 
mysql -u $1 -p$2 $db < ../data/assessments.sql 
