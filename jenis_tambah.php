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
    $kode_jenis = filter_input(INPUT_POST, 'kode_jenis', FILTER_SANITIZE_STRING);
    $nama_jenis = filter_input(INPUT_POST, 'nama_jenis', FILTER_SANITIZE_STRING);
    $keterangan = filter_input(INPUT_POST, 'keterangan', FILTER_SANITIZE_STRING);

    $simpan = db_jenis_add($db_conn, $kode_jenis, $nama_jenis, $keterangan);

    if ($simpan > 0) {
        //berhasil menyimpan data
        header('Location: ./jenis.php');
    } else {
        $error = 1;
    }
}
?>
<html>
    <head>
        <title>Tambah Data Jenis Barang</title>
    </head>
    <body>
        <p><a href="./index.php">Home</a> > <a href="./jenis.php">Jenis Barang</a> > Tambah Jenis Barang</p>
        <form action="" method="post">
            <table>
                <tr>
                    <td>Kode Jenis Barang</td>
                    <td>:</td>
                    <td>
                        <input type="text" name="kode_jenis" required autofocus>
                    </td>
                </tr>
                <tr>
                    <td>Nama Jenis Barang</td>
                    <td>:</td>
                    <td>
                        <input type="text" name="nama_jenis" required>
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
