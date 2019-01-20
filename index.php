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
        <ul>
            <b>Biodata</b>
            <li>Username : <?= $_SESSION['username'] ?></li>
            <li>Nama Pengguna : <?= $_SESSION['nama'] ?></li>
            <li>Level Pengguna : <?= db_level_get_nama_by_id($db_conn, $_SESSION['id_level']) ?></li>
        </ul>
        <ul>
            <b>Transaksi</b>
            <li><a href="./peminjaman_tambah.php">Tambah Peminjaman</a></li>
            <li><a href="./peminjaman.php">Daftar Peminjaman</a></li>
            <li><a href="./laporan.php">Laporan</a></li>
            <br/>
            <?php if ($_SESSION['id_level'] == 1) : ?>
                <!-- menu untuk level admin -->
                <b>Data Master</b>
                <li><a href="./pegawai.php">Pegawai</a></li>
                <li><a href="./inventaris.php">Inventaris</a></li>
                <li><a href="./jenis.php">Jenis Inventaris</a></li>
                <li><a href="./ruang.php">Ruangan</a></li>
                <br/>
            <?php endif; ?>
            <b>Pengaturan</b>
            <li><a href="./profil.php">Profil</a></li>
            <li><a href="./logout.php">Logout</a></li>
        </ul>
    </body>
</html>
