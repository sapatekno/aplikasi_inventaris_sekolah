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
    $pegawai = db_pegawai_get_all_by_cari($db_conn, $limit, $offset, $katacari);
    $total = db_pegawai_count_by_cari($db_conn, $katacari);
} else {
    $pegawai = db_pegawai_get_all($db_conn, $limit, $offset);
    $total = db_pegawai_count($db_conn);
}

$no = $offset + 1;
$jumlah_data_semua = mysqli_num_rows($total);
$jumlah_data_per_halaman = mysqli_num_rows($pegawai);
?>
<html>
    <head>
        <title>Data Pegawai</title>
    </head>
    <body>
        <p><a href="./index.php">Home</a> > Pegawai</p>
        <p><a href="./pegawai_tambah.php">Tambah data pegawai</a></p>
        <form action="./pegawai.php" method="post">
            <input type="text" name="katacari" minlength="3" required placeholder="Cari nama pegawai"><input type="submit" name="cari" value="Cari">
        </form>
        <?php if (isset($_SESSION['cari']) == true) : ?>
            <p>Mencari data <?= $_SESSION['katacari'] ?>, <a href="./pegawai.php?c=1">Hapus pencarian</a></p>
        <?php endif; ?>
        <?php if ($jumlah_data_per_halaman < 1) : ?>
            <p><b>Data pegawai tidak ditemukan.</b></p>
        <?php else : ?>
            <table border="1">
                <tr>
                    <th>No.</th>
                    <th>NIP</th>
                    <th>Nama Pegawai</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
                <?php foreach ($pegawai as $data) : ?>
                    <tr>
                        <td><?= $no ?></td>
                        <td><?= $data['nip'] ?></td>
                        <td><?= $data['nama_pegawai'] ?></td>
                        <td><?= $data['alamat'] ?></td>
                        <td>
                            <a href="./pegawai_edit.php?id=<?= $data['id_pegawai'] ?>">EDIT</a>
                            <a href="./pegawai_hapus.php?id=<?= $data['id_pegawai'] ?>">HAPUS</a>
                        </td>
                    </tr>
                    <?php $no++ ?>
                <?php endforeach; ?>                    
            </table>
            <p>Total data : <?= $jumlah_data_semua ?> Item</p>
            <p>
                <?php if ($offset > 0) : ?>
                    <a href="./pegawai.php?o=<?= $offset - $limit ?>">Sebelumnya</a> 
                <?php endif; ?>                    
                <?php if (($offset + $limit) < $jumlah_data_semua) : ?>
                    <a href="./pegawai.php?o=<?= $offset + $limit ?>">Selanjutnya</a> 
                <?php endif; ?>
            </p>
        <?php endif; ?>
    </body>
</html>