#!/bin/bash
for x in `find ../temp/* -name '*php' -or -name '*lcp' -or -name '*lcs'|grep -v templates `
do
     ./injectheader.pl $x > ./licensedfile.tmp
     mv -f ./licensedfile.tmp $x
done

