#!/bin/sh

if [ ! $1 ]
then
  echo "Please supply the path to your LogiCampus installtion"
fi

echo "!!!!!!!!!!!!!!!!!!!!!! NOTICE !!!!!!!!!!!!!!!!!!!!!!"
echo "This script makes the directories writable for your "
echo "webserver, but does it in a somewhat insecure manner"
echo "by using chmod 777. You may want to fix this.       "
echo "!!!!!!!!!!!!!!!!!!!!!! NOTICE !!!!!!!!!!!!!!!!!!!!!!"

chmod -R 777 $1/logicreate/content
chmod -R 777 $1/logicreate/cache
chmod -R 777 $1/logicreate/classLibrary
chmod -R 777 $1/public_html/images

