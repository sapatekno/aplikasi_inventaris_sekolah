<?php
//memanggil berkas sistem
require_once './app/config.php';
require_once './app/database.php';
require_once './app/fungsi.php';

//cek status login
_isLogin();
?>
<html>
    <head>
        <title>Aplikasi Inventory</title>
    </head>
    <body>
        <table>
            <tr>
                <td>Username</td>
                <td>:</td>
                <td><?= $_SESSION['username'] ?></td>
            </tr>
            <tr>
                <td>Nama Pengguna</td>
                <td>:</td>
                <td><?= $_SESSION['nama'] ?></td>
            </tr>
            <tr>
                <td>Level Pengguna</td>
                <td>:</td>
                <td><?= db_level_get_nama_by_id($db_conn, $_SESSION['id_level']) ?></td>
            </tr>
        </table>
        <br/>
        <ul>
            <?php if ($_SESSION['id_level'] == 1) : ?>
                <!-- menu untuk level admin -->
                <li><a href="./barang.php">Data Barang</a></li>
                <li><a href="./jenis.php">Data Jenis Barang</a></li>
                <li><a href="./pengguna.php">Data Pengguna</a></li>
                <li><a href="./ruang.php">Data Ruangan</a></li>
            <?php endif; ?>
            <?php if ($_SESSION['id_level'] == 2) : ?>
                <!-- menu untuk level operator -->
                <li><a href="./transaksi.php">Transaksi</a></li>
                <li><a href="./laporan.php">Laporan</a></li>
            <?php endif; ?>
            <li><a href="./profil.php">Profil</a></li>
            <li><a href="./logout.php">Logout</a></li>
        </ul>
    </body>
</html>
