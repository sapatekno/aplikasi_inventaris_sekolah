<?php
//berkas sistem
require_once './app/config.php';
require_once './app/database.php';
require_once './app/fungsi.php';

//fungsi
_isLogin();
_isLevel([1]);

//deklarasi variabel awal
$error = 0;
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
$edit = filter_input(INPUT_POST, 'edit', FILTER_SANITIZE_STRING);
$d_inventaris = db_inventaris_all($db_conn);
$tambah = filter_input(INPUT_POST, 'tambah', FILTER_SANITIZE_STRING);

//pengecekan jika id tidak ada
if (!empty($id)) {
    $data = db_peminjaman_get_data_by_id($db_conn, $id);

    //jika id data tidak ditemukan dalam database
    if (empty($data)) {
        $error = 1;
        $pesan_error = 'ID data tidak ditemukan';
    }

    //tambah detail pinjaman baru
    if (!empty($tambah)) {
        $id_inventaris = filter_input(INPUT_POST, 'id_inventaris', FILTER_SANITIZE_STRING);
        $jumlah = filter_input(INPUT_POST, 'jumlah', FILTER_SANITIZE_STRING);
        $id_peminjaman = $id;
        $simpan = db_peminjaman_detail_add($db_conn, $id_inventaris, $jumlah, $id_peminjaman);

        //pengecekan berhasil disimpan
        if ($simpan < 1) {
            $error = 1;
            $pesan_error = "Kesalahan dalam menyimpan data kedalam database";
        }
    }

    //konfigurasi halaman
    $limit = 5;
    $offset = filter_input(INPUT_GET, 'o', FILTER_SANITIZE_NUMBER_INT);

    if (empty($offset)) {
        $offset = 0;
    }

    $ruang = db_peminjaman_detail_get_all($db_conn, $id, $limit, $offset);
    $total = db_peminjaman_detail_count($db_conn, $id);

    $no = $offset + 1;
    $jumlah_data_semua = mysqli_num_rows($total);
    $jumlah_data_per_halaman = mysqli_num_rows($ruang);
} else {
    $error = 1;
    $pesan_error = 'Tidak ada parameter id dalam GET';
}
?>
<html>
<head>
    <title>Detail Peminjaman Detail</title>
</head>
<body>
<p><a href="./index.php">Home</a> > <a href="./peminjaman.php">Peminjaman</a> > Peminjaman Detail</p>
<?php if ($error == 1) : ?>
    <p><?= $pesan_error ?></p>
<?php else : ?>

    <form action="" method="post">
        <table>
            <tr>
                <td>Kode Peminjaman</td>
                <td>:</td>
                <td>
                    <?= $data['id_peminjaman'] ?>
                </td>
            </tr>
            <tr>
                <td>Tanggal Pinjam</td>
                <td>:</td>
                <td>
                    <?= _tanggal_indo($data['tanggal_pinjam']) ?>
                </td>
            </tr>
            <tr>
                <td>Tanggal Kembali</td>
                <td>:</td>
                <td>
                    <?= _tanggal_indo($data['tanggal_kembali']) ?>
                </td>
            </tr>
            <tr>
                <td>Petugas Pencatat</td>
                <td>:</td>
                <td>
                    <?= db_petugas_get_nama_by_id($db_conn, $data['id_petugas']) ?>
                </td>
            </tr>
            <tr>
                <td>Peminjam (Pegawai)</td>
                <td>:</td>
                <td>
                    <?= db_pegawai_get_nama_by_id($db_conn, $data['id_pegawai']) ?>
                </td>
            </tr>
        </table>
        <br>
        <b>Tambahkan detail peminjaman</b>
        <br><br>
        <form action="./peminjaman_detail.php?id=<?= $id ?>" method="post">
            <table>
                <tr>
                    <td>Inventaris yang dipinjam</td>
                    <td>:</td>
                    <td>
                        <select name="id_inventaris">
                            <?php foreach ($d_inventaris as $data) : ?>
                                <option value="<?= $data['id_inventaris'] ?>"><?= $data['kode_inventaris'] ?>
                                    - <?= $data['nama'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Jumlah yang dipinjam</td>
                    <td>:</td>
                    <td>
                        <input type="number" name="jumlah" min="1" value="1">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>
                        <input type="submit" name="tambah" value="Tambah">
                    </td>
                </tr>
            </table>
        </form>
        <br/><br/>
        <?php if ($jumlah_data_per_halaman < 1) : ?>
            <p><b>Data ruang tidak ditemukan.</b></p>
        <?php else : ?>
            <table border="1">
                <tr>
                    <th>No.</th>
                    <th>Kode Inventaris</th>
                    <th>Nama Inventaris</th>
                    <th>Jumlah Pinjam</th>
                    <th>Aksi</th>
                </tr>
                <?php foreach ($ruang as $data) : ?>
                    <tr>
                        <td><?= $no ?></td>
                        <td><?= $data['kode_inventaris'] ?></td>
                        <td><?= $data['nama'] ?></td>
                        <td><?= $data['jumlah'] ?> Unit</td>
                        <td>
                            <a href="./peminjaman_detail_hapus.php?id=<?= $data['id_detail_pinjam'] ?>&id_peminjaman=<?= $data['id_peminjaman']?>">HAPUS</a>
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
    </form>
<?php endif; ?>
</body>
</html>
