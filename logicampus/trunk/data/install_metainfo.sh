if [ ! $1 ] || [ ! $2 ]
then
	echo 'you need to pass user and password'
	echo './install_metainfo.sh username password (database)'
	echo 'database name defaults to logicampus'
	exit 1
fi


if [ ! $3 ]
then
	db='logicampus';
else
	db=$3;
fi

if [ -d '../src/' ] 
then
	location='../src/logicreate/services/'
fi


if [ -d '../services/' ] 
then
	location='../services/'
fi

if [ ! $location ]
then
	echo 'you need to run this from either the cvs/data dir or'
	echo 'src/logicreate/scripts/'
	exit 1
fi


for x in `find $location -name 'META-INFO'`
do
	echo 'installing setup.sql in '$x;
	mysql -u $1 -p$2 $db < $x/setup.sql;
done

