<?php
//berkas sistem
require_once './config.php';
require_once './database.php';
require_once './fungsi.php';

//pengecekan login
_isLogin();
?>
<html>
    <head>
        <title>Error tidak ada hak akses</title>
    </head>
    <body>
        <p>Anda tidak memiliki hak akses untuk membuka halaman ini.</p>
        <p><a href="./login.php">Login</a></p>
    </body>
</html>