<?php
include 'init.php';

checkLogin();
if (isPost()) {
    $userList['users'][$_SESSION['name']] = $_POST['pwd1'];
    putIniFile($userList, getPasswdPath());
    $err                                  = '修改成功';
}
?>
<?php include 'header.php'; ?>
<link href="/css/dashboard.css" rel="stylesheet">
<div class="container">
    <!-- Main component for a primary marketing message or call to action -->
    <div class="jumbotron">
        <?php include 'top.php'; ?>
        <!-- Tab panes -->
        <div class="tab-content">
            <form role="form" method="post" name="form1" action="/pwd.php">
                <div class="form-group">
                    <label for="exampleInputEmail1">新密码</label>
                    <input type="" class="form-control" id="exampleInputEmail1"  name="pwd1" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
            </form>
        </div>
    </div>

</div> <!-- /container -->
<?php include 'footer.php'; ?>
