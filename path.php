<?php
include 'init.php';

checkLogin();

//删除路径权限
if (8 == @$_GET['ac']) {
    $Authz['aliases'] = array();
    $ph               = ($_GET['ph']);
    $k                = trim($_GET['k']);
    unset($Authz[$ph][$k]);
    putIniFile($Authz, getAuthzPath());
}

//删除路径
if (9 == @$_GET['ac']) {
    $Authz['aliases'] = array();
    $ph               = ($_GET['ph']);
    unset($Authz[$ph]);
    putIniFile($Authz, getAuthzPath());
}

if (isPost()) {
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

$qx    = $Authz = getAuthz();
//整理数据
$Authz = @$groups['groups'];
unset($qx['aliases']);
unset($qx['groups']);

$qxArr = array(
    ''   => '无',
    'r'  => 'r',
    'rw' => 'rw',
);

$top = 3;
?>
<?php include 'header.php'; ?>
<link href="/css/dashboard.css" rel="stylesheet">
<div class="container">
    <!-- Main component for a primary marketing message or call to action -->
    <div class="jumbotron">
        <?php include 'top.php'; ?>
        <!-- Tab panes -->
        <div class="tab-content">
            <form role="form" method="post" name="form1" action="/path.php">
                <div class="form-group">
                    <label for="exampleInputEmail1">添加路径</label>
                    <input type="" class="form-control" id="exampleInputEmail1"  name="ph" placeholder="path">
                </div>
                <input type="hidden" value="6" name="ac" />
                <button type="submit" class="btn btn-default">Submit</button>
            </form>
            <table class="table table-bordered">
                <tr >
                    <td >路径</td>
                    <td >权限</td>
                </tr>
                <?php if ($qx) : ?>
                    <?php foreach ($qx as $gn => $uL) : ?>
                        <tr>
                            <td ><?php echo $gn ?>&nbsp;&nbsp;<a href="/path.php?ac=9&ph=<?php echo $gn ?>"><button class="btn btn-danger small" type="button">删除</button></td>
                            <td >
                                <form method="post" name="form3_<?php echo getOrdStr($gn) ?>" action="/path.php">
                                    <div id="qx_<?php echo getOrdStr($gn) ?>">
                                        <?php foreach ($uL as $k => $v) : ?>
                                            <p><?php echo substr($k, 0, 1) == '@' ? '组' : '成员'; ?>:<?php echo trim($k, '@') ?>：<?php echo $v ?>&nbsp;&nbsp;
                                                <?php if ('*' != $k) : ?>
                                                    <a href="/path.php?ac=8&ph=<?php echo $gn ?>&k=<?php echo $k; ?>"><button class="btn btn-danger small" type="button">删除</button></a>
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
        </div>
    </div>

</div> <!-- /container -->
<script>
    function gaddM2(str)
    {
        $('#qx_' + str).append(getMemberListSe2());
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
            str += '<button class="btn btn-danger small" type="button" onclick="gdelM(this)" >删除</button>&nbsp;&nbsp;</p>';
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
            str += '<button class="btn btn-danger small" type="button" onclick="gdelM(this)" >删除</button>&nbsp;&nbsp;</p>';
<?php } ?>
        qxNum++;
        return str;
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
<?php include 'footer.php'; ?>
