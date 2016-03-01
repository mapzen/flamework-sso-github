#!/bin/sh

PYTHON=`which python`
WHOAMI=`${PYTHON} -c 'import os, sys; print os.path.realpath(sys.argv[1])' $0`

BIN=`dirname $WHOAMI`
ROOT=`dirname ${BIN}`

WWW="${ROOT}/www"

PROJECT=$1

echo "copy application files"
cp ${WWW}/*.php ${PROJECT}/www

echo "copy library files"
cp ${WWW}/include/*.php ${PROJECT}/www/include/

echo "copy template files"
cp ${WWW}/templates/*.txt ${PROJECT}/www/templates/

echo "copy .htaccess settings"
echo "" >> ${PROJECT}/www/.htaccess
cat ${WWW}/.htaccess >> ${PROJECT}/www/.htaccess
echo "" >> ${PROJECT}/www/.htaccess

echo "YOU WILL STILL NEED TO UNCOMMENT/ENABLE flamework-github-sso SETTINGS IN ${PROJECT}/www/.htaccess"

echo "copy config settings"
echo "" >> ${PROJECT}/www/include/config.php
cat ${WWW}/include/config.php.example >> ${PROJECT}/www/include/config.php
echo "" >> ${PROJECT}/www/include/config.php

echo "done"
exit 0
