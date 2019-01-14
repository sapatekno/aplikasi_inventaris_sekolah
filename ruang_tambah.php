<?php
//berkas sistem
require_once './app/config.php';
require_once './app/database.php';
require_once './app/fungsi.php';

_isLogin();
_isLevel([1]);

$error = 0;
$tambah = filter_input(INPUT_POST, 'tambah', FILTER_SANITIZE_STRING);

if (!empty($tambah)) {
    $kode_ruang = filter_input(INPUT_POST, 'kode_ruang', FILTER_SANITIZE_STRING);
    $nama_ruang = filter_input(INPUT_POST, 'nama_ruang', FILTER_SANITIZE_STRING);
    $keterangan = filter_input(INPUT_POST, 'keterangan', FILTER_SANITIZE_STRING);

    $simpan = db_ruang_add($db_conn, $kode_ruang, $nama_ruang, $keterangan);

    if ($simpan > 0) {
        //berhasil menyimpan data
        header('Location: ./ruang.php');
    } else {
        $error = 1;
    }
}
?>
<html>
    <head>
        <title>Tambah Data Ruang</title>
    </head>
    <body>
        <p><a href="./index.php">Home</a> > <a href="./ruang.php">Ruang</a> > Tambah Ruang</p>
        <form action="" method="post">
            <table>
                <tr>
                    <td>Kode Ruang</td>
                    <td>:</td>
                    <td>
                        <input type="text" name="kode_ruang" required autofocus>
                    </td>
                </tr>
                <tr>
                    <td>Nama Ruang</td>
                    <td>:</td>
                    <td>
                        <input type="text" name="nama_ruang" required>
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
