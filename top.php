<?php if (isLogin() == 1) : ?>
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" <?php if ($top == 1) echo 'class="active"'; ?>><a href="/index.php">用户管理</a></li>
        <li role="presentation" <?php if ($top == 2) echo 'class="active"'; ?>><a href="group.php">用户组管理</a></li>
        <li role="presentation" <?php if ($top == 3) echo 'class="active"'; ?>><a href="path.php">路径/权限</a></li>
    </ul>
<?php endif; ?>