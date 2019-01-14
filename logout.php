<?php
require_once './config.php';
require_once './database.php';
require_once './fungsi.php';

if ($_SESSION['login'] == TRUE){
    //hapus sesi jika ada
    session_destroy();
}
header('Location: ./login.php');
?>
<html>
    <head>
        <title>Logout</title>
    </head>
    <body>
        <!-- Tidak ada kode -->
    </body>
</html>
