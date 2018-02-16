#!/bin/bash

#check for a deployment directory definition

echo "*** Making deployment directory ***"
depDir=WEBDEPLOY

mkdir $depDir

echo
echo "*** Copying files ***"
cp -r images/ $depDir
cp -r js/ $depDir
cp -r txt/ $depDir
cp -r laundryBag/ $depDir
cp -r submission/ $depDir
cp -r diagnostic/ $depDir
cp -r fancybox/ $depDir
cp *.html $depDir
cp *.php $depDir
cp *.js $depDir
cp *.css $depDir
cp *.txt $depDir

# Copy css files
mkdir $depDir/css
python minimizeCSS.py css/style.css $depDir/css/style.css
python minimizeCSS.py css/diagnostic.css $depDir/css/diagnostic.css

echo
echo "*** Replacing strings ***"
cd $depDir
find . -type f | xargs sed -i 's/localhost/ndtees.db.8197430.hostedresource.com/g'
find . -type f | xargs sed -i 's/root/ndtees/g'
find . -type f | xargs sed -i 's/$rootPassword/$ndteesPassword/g'

echo
echo "*** Generating .htaccess ***"
echo "AddHandler x-httpd-php5-cgi .html" > .htaccess
echo "DirectoryIndex index.phtml construction.html" >> .htaccess

echo
echo "*** Replacing tabs with four spaces ***"
cd ..
replaceTabs.sh 1
