#!/bin/sh
set -e
usage ()
{
    echo "usage : python pack.py /source/dir/ /target/dir/for/packaging/ modulename versionnumber"
    echo "                 build packaging directory tree \n"
    echo "        python pack.py -h "
    echo "                 display this help\n"
    echo "ex:     python pack.py /home/user/sourcedir /home/user/builddir limba 0.1"
}
pack()
{
	echo "Packaging ..."
	if [ -d $2 ]
	then
		rm -rf $2/*
	else
		mkdir -p $2	
	fi
	mkdir -p $2/$3"-"$4
	cp -r $1/dev-scripts/pack/packdirs/etc/ $2/$3"-"$4
	cp -r $1/dev-scripts/pack/packdirs/usr/ $2/$3"-"$4
	
	mkdir -p $2/$3"-"$4"/var/lib/limba/tmp/"
	mkdir -p $2/$3"-"$4"/usr/share/limba/"
	mkdir -p $2/$3"-"$4"/etc/limba/siteconf/cache/"
	#touch $2/$3"-"$4"/etc/limba/siteconf/cache/libs.store"
	mkdir -p $2/$3"-"$4"/var/cache/limba"
	mkdir -p $2/$3"-"$4/DEBIAN
	cp -r $1/cgi/* $2/$3"-"$4/usr/share/limba
	#cp -r $1/config/*.* $2/$3"-"$4/etc/limba/siteconf/
    cat $1/database/DDL.sql >> $2/$3"-"$4/usr/share/dbconfig-common/data/limba/install/mysql
    cat $1/database/DATA.sql >> $2/$3"-"$4/usr/share/dbconfig-common/data/limba/install/mysql
    cd $2
    
    tar czf $2/$3"-"$4.tar.gz $2/$3"-"$4
    cp $2/$3"-"$4.tar.gz $2/$3"_"$4.orig.tar.gz
    cd $2/$3"-"$4
    #echo "enter" | dh_make -e lreenaers@ressource-toi.org -s -c gpl2
    cp -rf $1/dev-scripts/pack/packdirs/DEBIAN/* $2/$3"-"$4/DEBIAN
    #cd DEBIAN
    #rm -rf *ex *EX README*
    
    cd $2/$3"-"$4/
    
    md5sum `find . -type f | grep -v '^[.]/$3"-"$4/DEBIAN/'` > $2/$3"-"$4/DEBIAN/md5sums
#    debuild -S -sa -k77B2E5F6
	cd ..
	dpkg-deb --build $2/$3"-"$4
    dpkg-sig --sign builder $3"-"$4.deb
    
}

if [ $# != 4 ]
then
    usage
    exit
fi
if [ -d $1 ]
then
	T1=`echo $1 | sed 's#/*$##'`
	T2=`echo $2 | sed 's#/*$##'`
	pack $T1 $T2 $3 $4
fi