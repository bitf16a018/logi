#!/bin/sh
cd ../7ziptmp
cp ../win-setup/logicampus_start_page.url ./$1/
../win-setup/p7zip_4.55/bin/7z a $1.7z $1
cat ../win-setup/7z.win.sfx $1.7z > $1.exe
