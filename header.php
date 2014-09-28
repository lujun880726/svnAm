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
        <nav role="navigation" class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="#" class="navbar-brand">SVNAM</a>
                </div>
                <div class="navbar-collapse collapse" id="navbar">
                    <?php if (1 == isLogin()): ?>
                        <ul class="nav navbar-nav">
                            <li class="dropdown">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#"><?php echo $_SESSION['pro'] ?> <span class="caret"></span></a>
                                <ul role="menu" class="dropdown-menu">
                                    <?php if ($projectList) : ?>
                                        <?php foreach ($projectList as $key => $val): ?>
                                            <li><a href="/index.php?pro=<?php echo $val ?>"><?php echo $val ?></a></li>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    <li class="divider"></li>
                                </ul>
                            </li>
                        </ul>

                    <?php endif; ?>
                    <?php if (isLogin() > 0): ?>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="#"><?php echo $_SESSION['name'] ?></a></li>
                            <li><a href="login.php?login=out">登出</a></li>
                        </ul>
                    <?php endif; ?>
                </div><!--/.nav-collapse -->
            </div>
        </nav>