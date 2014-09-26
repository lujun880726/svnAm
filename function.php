<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * 是否POST
 * @return type
 */
function isPost()
{
    return 'POST' == $_SERVER['REQUEST_METHOD'];
}

/**
 * 验证登录后跳转
 */
function checkLogin()
{

    if (!isset($_SESSION['auth']) || $_SESSION['auth'] < 0) {
        header("Location: /login.php");
    }
}

/**
 * 判断登录反正TRUE OR FALSE
 * @return boolean
 */
function isLogin()
{
    if (!isset($_SESSION['auth']) || $_SESSION['auth'] < 0) {
        return false;
    }
    return true;
}

/**
 * 通过SVN 根目录下的文件夹数列出有几个项目
 * @param type $path
 */
function getDirFile($Dir)
{
    $arr  = array();
    $dir  = @ dir($Dir);
    while (($file = $dir->read()) !== false) {
        if (is_dir($Dir . "/" . $file) && '.' != $file && '..' != $file) {
            $arr[] = $file;
        }
    }
    return $arr;
}
