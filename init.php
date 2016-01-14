<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

header('Content-type: text/html; charset=UTF-8');

ini_set('display_errors', 'On');
error_reporting(E_ALL);

include "function.php";

session_start();

//管理员账号
define('ADMIN_ACCOUT', 'admin');
define('ADMIN_PWD', 'admin');
define('CONF_PATH', true);//true  为当前目录 

// svn 根目录 ----需要修改
if (CONF_PATH || strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
	define('SVN_PATH', dirname(__FILE__) . '/svndata/');
} else {
    define('SVN_PATH', '/home/svn/');
}


//define('SVN_PATH', './tmp/');


//项目列表
$projectList = getDirFile(SVN_PATH);


//设置当前项目
if (!isset($_SESSION['pro']) || !$_SESSION['pro']) {
    $_SESSION['pro'] = $projectList[0];
}

//用户列表
$userList = @getPasswd();
//用户组
$groups = @getGrpups();
//权限列表
$Authz    = @getAuthz();


$err = '';

