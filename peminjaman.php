<?php
//berkas sistem
require_once './app/config.php';
require_once './app/database.php';
require_once './app/fungsi.php';

//fungsi
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
    $jenis = db_jenis_get_all_by_cari($db_conn, $limit, $offset, $katacari);
    $total = db_jenis_count_by_cari($db_conn, $katacari);
} else {
    $jenis = db_jenis_get_all($db_conn, $limit, $offset);
    $total = db_jenis_count($db_conn);
}

$no = $offset + 1;
$jumlah_data_semua = mysqli_num_rows($total);
$jumlah_data_per_halaman = mysqli_num_rows($jenis);
?>
<html>
    <head>
        <title>Data Jenis</title>
    </head>
    <body>
        <p><a href="./index.php">Home</a> > Jenis Barang</p>
        <p><a href="./jenis_tambah.php">Tambah data Jenis Barang</a></p>
        <form action="./jenis.php" method="post">
            <input type="text" name="katacari" minlength="3" required placeholder="Cari nama jenis"><input type="submit" name="cari" value="Cari">
        </form>
        <?php if (isset($_SESSION['cari']) == true) : ?>
            <p>Mencari data <?= $_SESSION['katacari'] ?>, <a href="./jenis.php?c=1">Hapus pencarian</a></p>
        <?php endif; ?>
        <?php if ($jumlah_data_per_halaman < 1) : ?>
            <p><b>Data jenis barang tidak ditemukan.</b></p>
        <?php else : ?>
            <table border="1">
                <tr>
                    <th>No.</th>
                    <th>Kode Jenis</th>
                    <th>Nama Jenis Barang</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
                <?php foreach ($jenis as $data) : ?>
                    <tr>
                        <td><?= $no ?></td>
                        <td><?= $data['kode_jenis'] ?></td>
                        <td><?= $data['nama_jenis'] ?></td>
                        <td><?= $data['keterangan'] ?></td>
                        <td>
                            <a href="./jenis_edit.php?id=<?= $data['id_jenis'] ?>">EDIT</a>
                            <a href="./jenis_hapus.php?id=<?= $data['id_jenis'] ?>">HAPUS</a>
                        </td>
                    </tr>
                    <?php $no++ ?>
                <?php endforeach; ?>                    
            </table>
            <p>Total data : <?= $jumlah_data_semua ?> Item</p>
            <p>
                <?php if ($offset > 0) : ?>
                    <a href="./jenis.php?o=<?= $offset - $limit ?>">Sebelumnya</a> 
                <?php endif; ?>                    
                <?php if (($offset + $limit) < $jumlah_data_semua) : ?>
                    <a href="./jenis.php?o=<?= $offset + $limit ?>">Selanjutnya</a> 
                <?php endif; ?>
            </p>
        <?php endif; ?>
    </body>
</html>