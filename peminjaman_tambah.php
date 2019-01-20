<?php
//berkas sistem
require_once './app/config.php';
require_once './app/database.php';
require_once './app/fungsi.php';

//fungsi
_isLogin();
_isLevel([1]);

$error = 0;
$tambah = filter_input(INPUT_POST, 'tambah', FILTER_SANITIZE_STRING);

if (!empty($tambah)) {
    $kode_peminjaman = filter_input(INPUT_POST, 'kode_peminjaman', FILTER_SANITIZE_STRING);
    $nama_peminjaman = filter_input(INPUT_POST, 'nama_peminjaman', FILTER_SANITIZE_STRING);
    $keterangan = filter_input(INPUT_POST, 'keterangan', FILTER_SANITIZE_STRING);

    $simpan = db_peminjaman_add($db_conn, $kode_peminjaman, $nama_peminjaman, $keterangan);

    if ($simpan > 0) {
        //berhasil menyimpan data
        header('Location: ./peminjaman.php');
    } else {
        $error = 1;
    }
}
?>
<html>
    <head>
        <title>Tambah Data Peminjaman Inventaris</title>
    </head>
    <body>
        <p><a href="./index.php">Home</a> > <a href="./peminjaman.php">Peminjaman Inventaris</a> > Tambah Peminjaman Inventaris</p>
        <form action="" method="post">
            <table>
                <tr>
                    <td>Tanggal Pinjam</td>
                    <td>:</td>
                    <td>
                        <input type="text" name="kode_peminjaman" required autofocus>
                    </td>
                </tr>
                <tr>
                    <td>Tanggal Kembali</td>
                    <td>:</td>
                    <td>
                        <input type="text" name="nama_peminjaman" required>
                    </td>
                </tr>
                <tr>
                    <td>Keterangan</td>
                    <td>:</td>
                    <td>
                        <textarea name="keterangan"></textarea>
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
