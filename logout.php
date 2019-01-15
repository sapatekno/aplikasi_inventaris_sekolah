<?php
//berkas sistem
require_once './app/config.php';
require_once './app/database.php';
require_once './app/fungsi.php';

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
