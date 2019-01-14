<?php
//berkas sistem
require_once './app/config.php';
require_once './app/database.php';
require_once './app/fungsi.php';

//fungsi-fungsi
_isLogin();
_isLevel([1]);

//konfigurasi halaman
$limit = 5;
$offset = filter_input(INPUT_GET, 'o', FILTER_SANITIZE_NUMBER_INT);

if (empty($offset)) {
    $offset = 0;
}

//pencarian
$cari = filter_input(INPUT_POST, 'cari', FILTER_SANITIZE_STRING);
$clear = filter_input(INPUT_GET, 'c', FILTER_SANITIZE_STRING);

if (!empty($cari)) {
    $katacari = filter_input(INPUT_POST, 'katacari', FILTER_SANITIZE_STRING);
    $_SESSION['cari'] = TRUE;
    $_SESSION['katacari'] = $katacari;
}

if ($clear != null) {
    unset($_SESSION['cari']);
    unset($_SESSION['katacari']);
}

if (isset($_SESSION['cari']) == TRUE) {
    $katacari = $_SESSION['katacari'];
    $ruang = db_ruang_get_all_by_cari($db_conn, $limit, $offset, $katacari);
    $total = db_ruang_count_by_cari($db_conn, $katacari);
} else {
    $ruang = db_ruang_get_all($db_conn, $limit, $offset);
    $total = db_ruang_count($db_conn);
}

$no = $offset + 1;
$jumlah_data_semua = mysqli_num_rows($total);
$jumlah_data_per_halaman = mysqli_num_rows($ruang);
?>
<html>
    <head>
        <title>Data Ruang</title>
    </head>
    <body>
        <p><a href="./index.php">Home</a> > Ruang</p>
        <p><a href="./ruang_tambah.php">Tambah data ruang</a></p>
        <form action="./ruang.php" method="post">
            <input type="text" name="katacari" minlength="3" required placeholder="Cari nama ruang"><input type="submit" name="cari" value="Cari">
        </form>
        <?php if (isset($_SESSION['cari']) == true) : ?>
            <p>Mencari data <?= $_SESSION['katacari'] ?>, <a href="./ruang.php?c=1">Hapus pencarian</a></p>
        <?php endif; ?>
        <?php if ($jumlah_data_per_halaman < 1) : ?>
            <p><b>Data ruang tidak ditemukan.</b></p>
        <?php else : ?>
            <table border="1">
                <tr>
                    <th>No.</th>
                    <th>Kode Ruang</th>
                    <th>Nama Ruang</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
                <?php foreach ($ruang as $data) : ?>
                    <tr>
                        <td><?= $no ?></td>
                        <td><?= $data['kode_ruang'] ?></td>
                        <td><?= $data['nama_ruang'] ?></td>
                        <td><?= $data['keterangan'] ?></td>
                        <td>
                            <a href="./ruang_edit.php?id=<?= $data['id_ruang'] ?>">EDIT</a>
                            <a href="./ruang_hapus.php?id=<?= $data['id_ruang'] ?>">HAPUS</a>
                        </td>
                    </tr>
                    <?php $no++ ?>
                <?php endforeach; ?>                    
            </table>
            <p>Total data : <?= $jumlah_data_semua ?> Item</p>
            <p>
                <?php if ($offset > 0) : ?>
                    <a href="./ruang.php?o=<?= $offset - $limit ?>">Sebelumnya</a> 
                <?php endif; ?>                    
                <?php if (($offset + $limit) < $jumlah_data_semua) : ?>
                    <a href="./ruang.php?o=<?= $offset + $limit ?>">Selanjutnya</a> 
                <?php endif; ?>
            </p>
        <?php endif; ?>
    </body>
</html>