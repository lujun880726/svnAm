<?php
include 'init.php';

checkLogin();

if (isset($_GET['pro']) && $_GET['pro']) {
    $tmpPro = $_GET['pro'];
    if (in_array($tmpPro, $projectList)) {
        $_SESSION['pro'] = $tmpPro;
    }
}

//初始操作前的用户列表
$userList = getPasswd();

//删除用户
if (10 == @$_GET['ac']) {
    $name = trim($_GET['name']);
    unset($userList['users'][$name]);
    putIniFile($userList, getPasswdPath());
    $err  = '用户删除成功';
}

//重置密码
if (11 == @$_GET['ac']) {
    $name                     = trim($_GET['name']);
    $userList['users'][$name] = 123456;
    putIniFile($userList, getPasswdPath());
    $err                      = '密码重置成功';
}

if (isPost()) {
    //提交用户
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

//获取最新用户列表
$userList = getPasswd();
$top      = 1;
?>
<?php include 'header.php'; ?>
<link href="/css/dashboard.css" rel="stylesheet">
<div class="container">
    <!-- Main component for a primary marketing message or call to action -->
    <div class="jumbotron">
        <?php include 'top.php'; ?>
        <!-- Tab panes -->
        <div class="tab-content">
            <form role="form" method="post" name="form1" action="/index.php">
                <div class="form-group">
                    <label for="exampleInputEmail1">添加用户</label>
                    <input type="" class="form-control" id="exampleInputEmail1"  name="zh" placeholder="ACCOUT">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name="pd" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
            </form>
            <table class="table table-bordered">
                <tr>
                    <td> 账号 </td>
                    <td> 操作 </td>
                </tr>
                <?php if ($userList) : ?>
                    <?php foreach ($userList as $key => $list) : ?>
                        <?php foreach ($list as $zh => $pd) : ?>
                            <tr>
                                <td ><?php echo $zh ?></td>
                                <td >
                                    <a href="/index.php?ac=10&name=<?php echo $zh ?>"><button class="btn btn-danger" type="button">删除</button></a>
                                    <a href="/index.php?ac=11&name=<?php echo $zh ?>"><button class="btn btn-danger" type="button">重置密码</button></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </table>
        </div>
    </div>

</div> <!-- /container -->
<?php include 'footer.php'; ?>
