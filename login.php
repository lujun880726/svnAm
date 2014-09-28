<?php
include 'init.php';

IF (isLogin()) {
    header("Location: /index.php");
}
if ('out' == @$_GET['login']) {
    session_destroy();
}

if (isPost()) {
    $account = $_POST['account'];
    $pwd     = $_POST['pwd'];
    //管理员判断
    if ($account == ADMIN_ACCOUT) {
        if ($account != ADMIN_ACCOUT || $pwd != ADMIN_PWD) {
            $err = '账号或密码不正确';
        } else {
            $_SESSION['auth'] = 1;
            $_SESSION['name'] = 'admin';

            header("Location: /index.php");
        }
    } else {
        //非管理员判断
        if (isset($userList['users'][$account]) && $userList['users'][$account] == $pwd) {
            $_SESSION['auth'] = 2;
            $_SESSION['name'] = $account;
            header("Location: /pwd.php");
        } else {
            $err = '账号或密码不正确';
        }
    }
}
?>
<?php include 'header.php'; ?>
<div class="container">
    <form class="form-signin" role="form" method="post">
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="" class="form-control" placeholder="账号" name="account" required autofocus>
        <input type="password" class="form-control" name="pwd" placeholder="密码" required>
        <div class="checkbox">
            <label>
  <!--            <input type="checkbox" value="remember-me"> Remember me--><code><?PHP ECHO $err ?></code>
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    </form>
</div> <!-- /container -->
<?php include 'footer.php'; ?>
