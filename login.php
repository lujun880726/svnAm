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
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
<!--    <link rel="icon" href="../../favicon.ico">-->
    <title>SVN WEB 管理工具</title>
    <!-- Bootstrap core CSS -->
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/signin.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
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
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
