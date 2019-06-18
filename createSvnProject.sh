#!/bin/bash
PATH=/bin:/sbin:/usr/bin:/usr/sbin:/usr/local/bin:/usr/local/sbin:/usr/bin/expect:~/bin
export PATH
svnPath=/data/svn
svnserveFile=/home/wwwroot/svnAm/conf/
svnserveFileT=\/home\/wwwroot\/svnAm\/conf\/



echo "Please setup svn project name"
read -p "Please enter: " projectname
if [ "${projectname}" = "" ]; then
	echo "projectname is not null!"
	exit 0
fi
echo "projectname: ${projectname}"


/usr/bin/svnadmin create ${svnPath}/${projectname}

cd ${svnPath}/${projectname}/conf
rm -rf ${svnPath}/${projectname}/conf/passwd
echo '' > ${svnPath}/${projectname}/conf/authz
cp ${svnserveFile}svnserve.conf ${svnPath}/${projectname}/conf/svnserve.conf 

#sed -i "s/tmppasswd/${svnserveFileT}passwd/g" ${svnPath}/${projectname}/conf/svnserve.conf
#sed -i "s/tmpauthz/authz/g" ${svnPath}/${projectname}/conf/svnserve.conf
#sed -i "s/tmpgroups/${svnserveFileT}groups/g" ${svnPath}/${projectname}/conf/svnserve.conf


chmod -R 777 ${svnPath}/${projectname}

echo '[aliases]' >> ${svnPath}/${projectname}/conf/authz
echo '[/]' >> ${svnPath}/${projectname}/conf/authz
echo 'svncreate=rw' >> ${svnPath}/${projectname}/conf/authz


cd /tmp/
svn checkout svn://192.168.0.21/${projectname}
cd ${projectname}/
ls
mkdir branch trunk
svn add branch/ trunk/
svn ci -m "init"
svn cp -m "create branch test" svn://192.168.0.21/${projectname}/trunk svn://192.168.0.21/${projectname}/branch/test
cd branch/
svn co svn://192.168.0.21/${projectname}/branch/test
svn cp -m "create branch produce" svn://192.168.0.21/${projectname}/branch/test svn://192.168.0.21/${projectname}/branch/produce
svn co svn://192.168.0.21/${projectname}/branch/produce
