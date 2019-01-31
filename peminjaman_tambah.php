<?php
//berkas sistem
require_once './app/config.php';
require_once './app/database.php';
require_once './app/fungsi.php';

//fungsi
_isLogin();
_isLevel([1]);

//variabel dasar
$error = 0;
$tambah = filter_input(INPUT_POST, 'tambah', FILTER_SANITIZE_STRING);
$d_pegawai = db_pegawai_all($db_conn);
$Date = date('Y-m-d');

if (!empty($tambah)) {
    $id_petugas = $_SESSION['id_petugas'];
    $id_pegawai = filter_input(INPUT_POST, 'id_pegawai', FILTER_SANITIZE_STRING);
    $tanggal_pinjam = filter_input(INPUT_POST, 'tanggal_pinjam', FILTER_SANITIZE_STRING);
    $tanggal_kembali = filter_input(INPUT_POST, 'tanggal_kembali', FILTER_SANITIZE_STRING);
    $status_peminjaman = 0; //belum dikembalikan

    $simpan = db_peminjaman_add($db_conn, $tanggal_pinjam, $tanggal_kembali, $status_peminjaman, $id_petugas, $id_pegawai);

    if ($simpan > 0) {
        //berhasil menyimpan data saatnya menampilkan penyimpanan detail
        $id_peminjaman_latest = db_peminjaman_get_latest_add($db_conn, $id_petugas);
        header('Location: ./peminjaman_detail.php?id='.$id_peminjaman_latest);
    } else {
        $error = 1;
    }
}
?>
<html lang="id">
<head>
    <title>Tambah Data Peminjaman Inventaris</title>
</head>
<body>
<p><a href="./index.php">Home</a> > <a href="./peminjaman.php">Peminjaman Inventaris</a> > Tambah Peminjaman Inventaris
</p>
<form action="" method="post">
    <table>
        <tr>
            <td>Petugas Input</td>
            <td>:</td>
            <td>
                <?= $_SESSION['nama'] ?>
            </td>
        <tr>
            <td>Tanggal Pinjam</td>
            <td>:</td>
            <td>
                <input type="date" name="tanggal_pinjam" value="<?= $Date ?>" required autofocus>
            </td>
        </tr>
        <tr>
            <td>Tanggal Kembali</td>
            <td>:</td>
            <td>
                <input type="date" name="tanggal_kembali" value="<?= date('Y-m-d', strtotime($Date . ' + 3 days')) ?>"
                       required>
            </td>
        </tr>
        <tr>
            <td>Peminjam</td>
            <td>:</td>
            <td>
                <select name="id_pegawai">
                    <?php foreach ($d_pegawai as $data) : ?>
                        <option value="<?= $data['id_pegawai'] ?>"><?= $data['nip'] ?>
                            - <?= $data['nama_pegawai'] ?></option>
                    <?php endforeach; ?>
                </select>
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
    <?php
    if ($error == 1) :
        echo '<p>Kesalahan dalam menyimpan data kedalam database.</p>';
    endif;
    ?>
</form>
</body>
</html>
