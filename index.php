<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
header('Content-type: text/html; charset=UTF-8');
$svnPath = '/home/svn/';
$pr      = 'Iserver';

$qxArr = array(
    ''   => '无',
    'r'  => 'r',
    'rw' => 'rw',
);

ini_set('display_errors', 'On');
error_reporting(0);


$err      = '';
$userList = getPasswd();


$Authz = getAuthz();

if ('POST' == $_SERVER['REQUEST_METHOD']) {


    //提交用户
    if (1 == $_POST['ac']) {
        $zh = trim($_POST['zh']);
        $pd = trim($_POST['pd']);
        if (!$zh || !$pd) {
            $err = '账号或密码不能为空';
        }
        if (isset($userList['users'][$zh])) {
            $err = '此账号已存在';
        }
        if (!$err) {
            $userList['users'][$zh] = $pd;
            putIniFile($userList, getPasswdPath());
        }
    }
    //创建用户组
    if (2 == $_POST['ac']) {
        $Authz['aliases'] = array();
        $gname            = trim($_POST['gname']);
        if (!$gname) {
            $err = '组名不能为空';
        }
        if (isset($Authz['groups'][$gname])) {
            $err = '组名已存在';
        }
        if (!$err) {
            $Authz['groups'][$gname] = '';
            putIniFile($Authz, getAuthzPath());
        }
    }
    //组员添加
    if (3 == $_POST['ac']) {
        $Authz['aliases'] = array();
        $gname            = trim($_POST['gname']);
        $tmpgrow          = explode(',', $Authz['groups'][$gname]);
        $tmpList          = array_unique($_POST['member']);
        if ($tmpgrow[0]) {
            $tmpList = array_merge($tmpgrow, $tmpList);
        }
        $tmpList                 = array_unique($tmpList);
        $Authz['groups'][$gname] = implode(',', $tmpList);
        putIniFile($Authz, getAuthzPath());
    }

    //权限路径
    if (6 == $_POST['ac']) {
        $Authz['aliases'] = array();
        $ph               = trim($_POST['ph']);
        if (isset($Authz[$ph])) {
            $err = '路径已存在';
        }
        if (!$err) {
            $Authz[$ph] = array('*' => '');
            putIniFile($Authz, getAuthzPath());
        }
    }
    //路径添加权限
    if (7 == $_POST['ac']) {
        $Authz['aliases'] = array();
        $ph               = ($_POST['ph']);
        if (isset($_POST['member']) && $_POST['member']) {
            foreach ($_POST['member'] as $val) {
                $Authz[$ph][$val['k']] = $val['v'];
            }
        }
        if (isset($_POST['group']) && $_POST['group']) {
            foreach ($_POST['group'] as $val) {
                $Authz[$ph]['@' . $val['k']] = $val['v'];
            }
        }
        putIniFile($Authz, getAuthzPath());
    }
}

//删除组员添加
if (4 == $_GET['ac']) {
    $Authz['aliases'] = array();
    $gname            = trim($_GET['gname']);
    $mname            = trim($_GET['mname']);
    $tmpgrow          = explode(',', $Authz['groups'][$gname]);

    if ($tmpgrow) {
        foreach ($tmpgrow as $key => $val) {
            if ($mname == $val) {
                unset($tmpgrow[$key]);
            }
        }
        $Authz['groups'][$gname] = implode(',', $tmpgrow);
        putIniFile($Authz, getAuthzPath());
    }
}

//删除组
if (5 == $_GET['ac']) {
    $Authz['aliases'] = array();
    $gname            = trim($_GET['gname']);
    unset($Authz['groups'][$gname]);
    putIniFile($Authz, getAuthzPath());
}

//删除路径权限
if (8 == $_GET['ac']) {
    $Authz['aliases'] = array();
    $ph               = ($_GET['ph']);
    $k                = trim($_GET['k']);
    unset($Authz[$ph][$k]);
    putIniFile($Authz, getAuthzPath());
}

//删除路径
if (9 == $_GET['ac']) {
    $Authz['aliases'] = array();
    $ph               = ($_GET['ph']);
    unset($Authz[$ph]);
    putIniFile($Authz, getAuthzPath());
}



$qx    = $Authz = getAuthz();

$Authz = $Authz['groups'];
unset($qx['aliases']);
unset($qx['groups']);

$userList = getPasswd();
?>
<script src="http://cdn.bootcss.com/jquery/2.1.1-rc2/jquery.min.js"></script>
<script>

    function getMemberListSe()
    {
        str = '';
<?php if ($userList['users']) { ?>
            str += '<p><select name="member[]" >';
    <?php foreach ($userList['users'] as $key => $val) { ?>
                str += '<option value="<?php echo $key ?>"><?php echo $key ?></option>';
    <?php } ?>
            str += '</select>&nbsp;&nbsp;<img src="./X.png" height="19px" width="16px" onclick="gdelM(this)" />&nbsp;&nbsp;</p>';
<?php } ?>
        return str;
    }

    var qxNum = 1;

    function getMemberListSe2()
    {
        str = '';
<?php if ($userList['users']) { ?>
            str += '<p>成员：<select name="member[' + qxNum + '][k]" >';
    <?php foreach ($userList['users'] as $key => $val) { ?>
                str += '<option value="<?php echo $key ?>"><?php echo $key ?></option>';
    <?php } ?>
            str += '</select>&nbsp;&nbsp;';


            str += '<select name="member[' + qxNum + '][v]" >';
    <?php foreach ($qxArr as $key => $val) : ?>
                str += '<option value="<?php echo $key ?>"><?php echo $val ?></option>';
    <?php endforeach; ?>
            str += '</select>&nbsp;&nbsp;';
            str += '<img src="./X.png" height="19px" width="16px" onclick="gdelM(this)" />&nbsp;&nbsp;</p>';
<?php } ?>
        qxNum++;
        return str;

    }
    function getGroupListSe2()
    {
        str = '';
<?php if ($Authz) { ?>
            str += '<p>group:<select name="group[' + qxNum + '][k]" >';
    <?php foreach ($Authz as $key => $val) { ?>
                str += '<option value="<?php echo $key ?>"><?php echo $key ?></option>';
    <?php } ?>
            str += '</select>&nbsp;&nbsp;';


            str += '<select name="group[' + qxNum + '][v]" >';
    <?php foreach ($qxArr as $key => $val) : ?>
                str += '<option value="<?php echo $key ?>"><?php echo $val ?></option>';
    <?php endforeach; ?>
            str += '</select>&nbsp;&nbsp;';
            str += '<img src="./X.png" height="19px" width="16px" onclick="gdelM(this)" />&nbsp;&nbsp;</p>';
<?php } ?>
        qxNum++;
        return str;
    }
</script>

<!--用户 begin -->
<form method="post" name="form1" action="/">
    <table>
        <tr>
            <td>账号</td>
            <td><input type="text" name="zh" /></td>
        </tr>
        <tr>
            <td>密码</td>
            <td><input type="text" name="pd" /></td>
        </tr>
    </table>
    <input type="hidden" value="1" name="ac" />
    <input type="submit" value="提交" />
</form>
账号列表
<table style="border-collapse:collapse; border:1px solid #000000;">
    <tr style="border:1px solid #000000;">
        <td style="border:1px solid #000000;">账号</td>
        <td style="border:1px solid #000000;">密码</td>
    </tr>
    <?php foreach ($userList as $key => $list) : ?>
        <?php foreach ($list as $zh => $pd) : ?>
            <tr>
                <td style="border:1px solid #000000;"><?php echo $zh ?></td>
                <td style="border:1px solid #000000;"><?php echo $pd ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endforeach; ?>
</table>
<BR>
<!--用户 end -->



<!--用户组 begin -->
<form method="post" name="form2" action="/">
    <table>
        <tr>
            <td>组名</td>
            <td><input type="text" name="gname" /></td>
        </tr>

    </table>
    <input type="hidden" value="2" name="ac" />
    <input type="submit" value="提交" />
</form>
用户组
<table style="border-collapse:collapse; border:1px solid #000000;">
    <tr style="border:1px solid #000000;">
        <td style="border:1px solid #000000;">组名</td>
        <td style="border:1px solid #000000;">组员</td>
    </tr>
    <?php if ($Authz) : ?>
        <?php foreach ($Authz as $gn => $uL) : ?>
            <tr>
                <td style="border:1px solid #000000;"><?php echo $gn ?>&nbsp;&nbsp;<a href="/?ac=5&gname=<?php echo $gn ?>"><img width="16px" height="19px"   src="./X.png"></td>
                        <td style="border:1px solid #000000;">
                            <form method="post" name="form3_<?php echo $gn ?>" action="/">
                                <div id="mlist_<?php echo $gn ?>">
                                    <?php if ($uL) : ?>
                                        <?php $tmpuL = explode(',', $uL) ?>
                                        <?php foreach ($tmpuL as $m) : ?>
                                            <p><?php echo $m ?>&nbsp;&nbsp;<a href="/?ac=4&gname=<?php echo $gn ?>&mname=<?php echo $m; ?>"><img width="16px" height="19px"   src="./X.png"></a>&nbsp;&nbsp;</p>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <input type="button" value="添加"  onclick="gaddM('<?php echo $gn ?>');"/>
                                    <input type="submit" value="提交" />
                                </div>
                                <input type="hidden" value="<?php echo $gn ?>" name="gname" />
                                <input type="hidden" value="3" name="ac" />
                            </form>
                        </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>
<!--用户组 end -->
<Br>

<!--权限 begin -->
<form method="post" name="form6" action="/">
    <table>
        <tr>
            <td>添加路径</td>
            <td><input type="text" name="ph" /></td>
        </tr>

    </table>
    <input type="hidden" value="6" name="ac" />
    <input type="submit" value="提交" />
</form>
权限
<table style="border-collapse:collapse; border:1px solid #000000;">
    <tr style="border:1px solid #000000;">
        <td style="border:1px solid #000000;">组名</td>
        <td style="border:1px solid #000000;">组员</td>
    </tr>
    <?php if ($qx) : ?>
        <?php foreach ($qx as $gn => $uL) : ?>
            <tr>
                <td style="border:1px solid #000000;"><?php echo $gn ?>&nbsp;&nbsp;<a href="/?ac=9&ph=<?php echo $gn ?>"><img width="16px" height="19px"   src="./X.png"></td>
                        <td style="border:1px solid #000000;">
                            <form method="post" name="form3_<?php echo getOrdStr($gn) ?>" action="/">
                                <div id="qx_<?php echo getOrdStr($gn) ?>">
                                    <?php foreach ($uL as $k => $v) : ?>
                                        <p><?php echo substr($k, 0, 1) == '@' ? '组' : '成员'; ?>:<?php echo trim($k, '@') ?>：<?php echo $v ?>&nbsp;&nbsp;
                                            <?php if ('*' != $k) : ?>
                                                <a href="/?ac=8&ph=<?php echo $gn ?>&k=<?php echo $k; ?>"><img width="16px" height="19px"   src="./X.png">
                                                <?php endif; ?>
                                            </a>&nbsp;&nbsp;</p>
                                    <?php endforeach; ?>
                                </div>
                                <div>
                                    <input type="button" value="添加成员"  onclick="gaddM2('<?php echo getOrdStr($gn) ?>');"/>
                                    <input type="button" value="添加组"  onclick="gaddG('<?php echo getOrdStr($gn) ?>');"/>
                                    <input type="submit" value="提交" />
                                </div>
                                <input type="hidden" value="<?php echo $gn ?>" name="ph" />
                                <input type="hidden" value="7" name="ac" />
                            </form>
                        </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>
<!--权限 end -->

<script>
<?php if ($err) : ?>
        alert('<?php echo $err ?>');
<?php endif; ?>


    function gaddM(str)
    {
        $('#mlist_' + str).append(getMemberListSe());
    }
    function gaddM2(str)
    {
        $('#qx_' + str).append(getMemberListSe2());
    }
    function gaddG(str)
    {
        $('#qx_' + str).append(getGroupListSe2());
    }
    function gdelM(obj)
    {
        rowObj = $(obj).parent();
        rowObj.remove();
    }
</script>























<?php

function getOrdStr($str)
{
    $tmp = '';
    for ($i = 0; $i < strlen($str); $i++) {
        $tmp .= ord($str[$i]) . '_';
    }
    return $tmp;
}

function getAuthz()
{
    global $svnPath, $pr;
    $passwdFile = $svnPath . $pr . '/conf/' . 'authz';
    return parse_ini_file($passwdFile, true);
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
 *
 * @global string $svnPath
 * @global string $pr
 * @return type
 */
function getPasswdPath()
{
    global $svnPath, $pr;
    return $svnPath . $pr . '/conf/' . 'passwd';
}

function getAuthzPath()
{
    global $svnPath, $pr;
    return $svnPath . $pr . '/conf/' . 'authz';
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
 * 获取名员列表
 * @param type $mList
 */
function getMemberListSe($mList)
{
    $str = '';
    if ($mList) {
        $str .= '<select name="member[]" >';
        foreach ($mList as $key => $val) {
            $str .= '<option value="' . $key . '">' . $key . '</option>';
        }
        $str .= '</select>';
    }
    return $str;
}
