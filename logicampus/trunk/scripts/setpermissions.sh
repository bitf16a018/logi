#!/bin/sh

clear
echo
echo
echo
echo "THIS IS AN EXPERIMENTAL SCRIPT USE AT YOUR OWN RISK"
echo "RUNNING THIS SCRIPT MAY LEAVE YOUR SERVER IN AN INSECURE"
echo "STATE."
echo
echo "Do you wish to continue? "
echo -n "[yes/no]:$c "
read cc

if [ $cc == "no" ] 
then
	echo "STOPPING"
	exit 1
fi

if [ ! $1 ]
then
  echo 
  echo "Please supply the path to your LogiCampus installtion"
  echo "Example: /var/www  (no trailing slash)"
  echo "Example Usaage:  sh setpermissions.sh [path] [www-server-username]"
  echo
  exit 1
fi

if [ ! $2 ]
then
	echo
	echo "Please supply the username your web server is running as"
    echo "Example Usaage:  sh setpermissions.sh [path] [www-server-username]"
	echo
	exit 1
fi

echo
echo
echo "!!!!!!!!!!!!!!!!!!!!!! NOTICE !!!!!!!!!!!!!!!!!!!!!!"
echo "This script makes the directories writable for your "
echo "webserver."
echo "!!!!!!!!!!!!!!!!!!!!!! NOTICE !!!!!!!!!!!!!!!!!!!!!!"
echo 
echo

chmod -R 775 $1/logicreate/content
chmod -R 775 $1/logicreate/cache
chmod -R 775 $1/logicreate/classLibrary
chmod -R 775 $1/public_html/images

chown -R $2  $1/logicreate/content
chown -R $2  $1/logicreate/cache
chown -R $2  $1/logicreate/classLibrary
chown -R $2  $1/public_html/images
