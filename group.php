<?php
include 'init.php';

checkLogin();

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

if (isPost()) {
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
}

//整理数据
$Authz = $Authz['groups'];
unset($qx['aliases']);
unset($qx['groups']);

$top = 2;
?>
<?php include 'header.php'; ?>
<link href="/css/dashboard.css" rel="stylesheet">
<div class="container">
    <!-- Main component for a primary marketing message or call to action -->
    <div class="jumbotron">
        <?php include 'top.php'; ?>
        <!-- Tab panes -->
        <div class="tab-content">
            <form role="form" method="post" name="form1" action="/group.php">
                <div class="form-group">
                    <label for="exampleInputEmail1">添加用户组</label>
                    <input type="" class="form-control" id="exampleInputEmail1"  name="gname" placeholder="GROUP NAME">
                </div>
                <input type="hidden" value="2" name="ac" />
                <button type="submit" class="btn btn-default">Submit</button>
            </form>
            <table class="table table-bordered">
                <tr>
                    <td>组名</td>
                    <td>组员</td>
                </tr>
                <?php if ($Authz) : ?>
                    <?php foreach ($Authz as $gn => $uL) : ?>
                        <tr>
                            <td><?php echo $gn ?>&nbsp;&nbsp;<a href="/group.php?ac=5&gname=<?php echo $gn ?>"><button class="btn btn-danger small"  type="button">删除</button></td>
                            <td>
                                <form method="post" name="form3_<?php echo $gn ?>" action="/group.php">
                                    <div id="mlist_<?php echo $gn ?>">
                                        <?php if ($uL) : ?>
                                            <?php $tmpuL = explode(',', $uL) ?>
                                            <?php foreach ($tmpuL as $m) : ?>
                                                <p><?php echo $m ?>&nbsp;&nbsp;<a href="/group.php?ac=4&gname=<?php echo $gn ?>&mname=<?php echo $m; ?>"><button class="btn btn-danger" type="button">删除</button></a>&nbsp;&nbsp;</p>
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
        </div>
    </div>

</div> <!-- /container -->
<script>
    function gaddM(str)
    {
        $('#mlist_' + str).append(getMemberListSe());
    }
    function getMemberListSe()
    {
        str = '';
<?php if ($userList['users']) { ?>
            str += '<p><select name="member[]" >';
    <?php foreach ($userList['users'] as $key => $val) { ?>
                str += '<option value="<?php echo $key ?>"><?php echo $key ?></option>';
    <?php } ?>
            str += '</select>&nbsp;&nbsp;<button class="btn btn-danger" type="button" onclick="gdelM(this)">删除</button>&nbsp;&nbsp;</p>';
<?php } ?>
        return str;
    }

    function gdelM(obj)
    {
        rowObj = $(obj).parent();
        rowObj.remove();
    }
</script>
<?php include 'footer.php'; ?>
