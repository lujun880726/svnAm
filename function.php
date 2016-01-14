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
    if (!isset($_SESSION['auth']) || $_SESSION['auth'] < 1) {
        return false;
    }
    return $_SESSION['auth'];
}

/**
 * 通过SVN 根目录下的文件夹数列出有几个项目
 * @param type $path
 */
function getDirFile($Dir)
{
    $arr  = array();
    $dir  = dir($Dir);
    while (($file = $dir->read()) !== false) {
        if (is_dir($Dir . "/" . $file) && '.' != $file && '..' != $file) {
            $arr[] = $file;
        }
    }
    return $arr;
}

/**
 * 配置写入文件
 * @param type $data
 * @param type $filename
 */
function putIniFile($data, $filename)
{
    ob_start();
    if ($data) {
        foreach ($data as $key => $list) {
            echo '[' . $key . ']' . "\r\n";
            if ($list && is_array($list)) {
                foreach ($list as $name => $pd) {
                    echo $name . '=' . $pd . "\r\n";
                }
            }
        }
    }
    $tmp = ob_get_contents();
    ob_clean();
    file_put_contents($filename, $tmp);
}

/**
 * 用户列表
 * @global string $svnPath
 * @global string $pr
 * @return type
 */
function getPasswd()
{
    return parse_ini_file(getPasswdPath(), true);
}

/**
 * 获取PASSWD路径
 * @return type
 */
function getPasswdPath()
{
    return SVN_PATH . $_SESSION['pro'] . '/conf/' . 'passwd';
}
/**
 *  获取Authz路径
 * @return type
 */
function getAuthzPath()
{
    return SVN_PATH . $_SESSION['pro'] . '/conf/' . 'authz';
}

/**
 *  获取Grpups路径
 * @return type
 */
function getGrpupsPath()
{
    return SVN_PATH . $_SESSION['pro'] . '/conf/' . 'groups';
}

/**
 * 获取权限住处
 * @return type
 */
function getAuthz()
{
    return parse_ini_file(getAuthzPath(), true);
}

/**
 * 字符变ASII
 * @param type $str
 * @return string
 */
function getOrdStr($str)
{
    $tmp = '';
    for ($i = 0; $i < strlen($str); $i++) {
        $tmp .= ord($str[$i]) . '_';
    }
    return $tmp;
}
