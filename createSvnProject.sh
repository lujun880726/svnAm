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

