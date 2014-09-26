<?php
include 'init.php';
include "function.php";
 //$_SESSION['auth'] =0;

IF (isLogin()) {
    header("Location: /index.php");
}

if(isPost()){
    $account = $_POST['account'];
    $pwd = $_POST['pwd'];
    if('admin' != ADMIN_ACCOUT || 'admin' != ADMIN_PWD) {
        $err = '账号或密码不正确';
    } else {
        $_SESSION['auth'] =1;
        header("Location: /index.php");
    }
}

?>
    <?php include 'header.php';?>
    <div class="container">
      <form class="form-signin" role="form" method="post">
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="" class="form-control" placeholder="账号" name="account" required autofocus>
        <input type="password" class="form-control" name="pwd" placeholder="密码" required>
        <div class="checkbox">
          <label>
<!--            <input type="checkbox" value="remember-me"> Remember me--><code><?PHP ECHO $err?></code>
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>
    </div> <!-- /container -->
    <?php include 'footer.php';?>
