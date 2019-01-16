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
    $inventaris = db_inventaris_get_all_by_cari($db_conn, $limit, $offset, $katacari);
    $total = db_inventaris_count_by_cari($db_conn, $katacari);
} else {
    $inventaris = db_inventaris_get_all($db_conn, $limit, $offset);
    $total = db_inventaris_count($db_conn);
}

$no = $offset + 1;
$jumlah_data_semua = mysqli_num_rows($total);
$jumlah_data_per_halaman = mysqli_num_rows($inventaris);
?>
<html>
    <head>
        <title>Data Inventaris</title>
    </head>
    <body>
        <p><a href="./index.php">Home</a> > Inventaris</p>
        <p><a href="./inventaris_tambah.php">Tambah data inventaris</a></p>
        <form action="./inventaris.php" method="post">
            <input type="text" name="katacari" minlength="3" required placeholder="Cari nama inventaris"><input type="submit" name="cari" value="Cari">
        </form>
        <?php if (isset($_SESSION['cari']) == true) : ?>
            <p>Mencari data <?= $_SESSION['katacari'] ?>, <a href="./inventaris.php?c=1">Hapus pencarian</a></p>
        <?php endif; ?>
        <?php if ($jumlah_data_per_halaman < 1) : ?>
            <p><b>Data inventaris tidak ditemukan.</b></p>
        <?php else : ?>
            <table border="1">
                <tr>
                    <th>No.</th>
                    <th>Kode Inventaris</th>
                    <th>Tanggal Register</th>
                    <th>Nama Inventaris</th>
                    <th>Jenis</th>
                    <th>Ruangan</th>
                    <th>Jumlah Stok</th>
                    <th>Kondisi</th>
                    <th>Petugas Pencatat</th>
                    <th>Aksi</th>
                </tr>
                <?php foreach ($inventaris as $data) : ?>
                    <tr>
                        <td><?= $no ?></td>
                        <td><?= $data['kode_inventaris'] ?></td>
                        <td><?= $data['tanggal_register'] ?></td>
                        <td><?= $data['nama'] ?></td>
                        <td><?= $data['id_jenis'] ?></td>
                        <td><?= $data['id_ruang'] ?></td>
                        <td><?= $data['jumlah'] ?></td>
                        <td><?= $data['kondisi'] ?></td>
                        <td><?= $data['id_petugas'] ?></td>
                        <td>
                            <a href="./inventaris_edit.php?id=<?= $data['id_inventaris'] ?>">EDIT</a>
                            <a href="./inventaris_hapus.php?id=<?= $data['id_inventaris'] ?>">HAPUS</a>
                        </td>
                    </tr>
                    <?php $no++ ?>
                <?php endforeach; ?>                    
            </table>
            <p>Total data : <?= $jumlah_data_semua ?> Item</p>
            <p>
                <?php if ($offset > 0) : ?>
                    <a href="./inventaris.php?o=<?= $offset - $limit ?>">Sebelumnya</a> 
                <?php endif; ?>                    
                <?php if (($offset + $limit) < $jumlah_data_semua) : ?>
                    <a href="./inventaris.php?o=<?= $offset + $limit ?>">Selanjutnya</a> 
                <?php endif; ?>
            </p>
        <?php endif; ?>
    </body>
</html>