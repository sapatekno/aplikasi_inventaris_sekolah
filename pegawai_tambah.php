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
    $nip = filter_input(INPUT_POST, 'nip', FILTER_SANITIZE_STRING);
    $nama_pegawai = filter_input(INPUT_POST, 'nama_pegawai', FILTER_SANITIZE_STRING);
    $alamat = filter_input(INPUT_POST, 'alamat', FILTER_SANITIZE_STRING);

    $simpan = db_pegawai_add($db_conn, $nip, $nama_pegawai, $alamat);

    if ($simpan > 0) {
        //berhasil menyimpan data
        header('Location: ./pegawai.php');
    } else {
        $error = 1;
    }
}
?>
<html>
    <head>
        <title>Tambah Data Pegawai</title>
    </head>
    <body>
        <p><a href="./index.php">Home</a> > <a href="./pegawai.php">Pegawai</a> > Tambah Pegawai</p>
        <form action="" method="post">
            <table>
                <tr>
                    <td>NIP</td>
                    <td>:</td>
                    <td>
                        <input type="text" name="nip" required autofocus>
                    </td>
                </tr>
                <tr>
                    <td>Nama Pegawai</td>
                    <td>:</td>
                    <td>
                        <input type="text" name="nama_pegawai" required>
                    </td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td>
                        <textarea name="alamat"></textarea>
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
