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
mysql -u $1 -p$2 $db < setup.sql 
mysql -u $1 -p$2 $db < lcRegistry.sql 
mysql -u $1 -p$2 $db < lcUsers.sql 
mysql -u $1 -p$2 $db < lcPerms.sql 
mysql -u $1 -p$2 $db < lcForms_and_lcFormInfo.sql 
mysql -u $1 -p$2 $db < lcConfig.sql
mysql -u $1 -p$2 $db < lcGroups.sql
echo '***********************'
echo 'INSTALLING base modules'
sh ./install_metainfo.sh $1 $2 $db


echo '***********************'
echo 'POPULATING with dummy data'
mysql -u $1 -p$2 $db < semesters_and_classes.sql
mysql -u $1 -p$2 $db < profile.sql 
