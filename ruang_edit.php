<?php
//berkas sistem
require_once './app/config.php';
require_once './app/database.php';
require_once './app/fungsi.php';

_isLogin();
_isLevel([1]);

$error = 0;
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
$edit = filter_input(INPUT_POST, 'edit', FILTER_SANITIZE_STRING);

if (!empty($id)) {
    $data = db_ruang_get_data_by_id($db_conn, $id);

    if (!empty($edit)) {
        $kode_ruang = filter_input(INPUT_POST, 'kode_ruang', FILTER_SANITIZE_STRING);
        $nama_ruang = filter_input(INPUT_POST, 'nama_ruang', FILTER_SANITIZE_STRING);
        $keterangan = filter_input(INPUT_POST, 'keterangan', FILTER_SANITIZE_STRING);

        $simpan = db_ruang_update($db_conn, $id, $kode_ruang, $nama_ruang, $keterangan);

        if ($simpan > 0) {
            //berhasil menyimpan data
            header('Location: ./ruang.php');
        } else {
            $error = 1;
            $pesan_error = 'Tidak dapat memperbaharui database';
        }
    }
} else {
    $error = 1;
    $pesan_error = 'Tidak ada parameter id dalam GET';
}
?>
<html>
    <head>
        <title>Edit Data Ruang</title>
    </head>
    <body>
        <p><a href="./index.php">Home</a> > <a href="./ruang.php">Ruang</a> > Edit Ruang</p>
        <?php if ($error == 1) : ?>
            <p><?= $pesan_error ?></p>
        <?php else : ?>

            <form action="" method="post">
                <table>
                    <tr>
                        <td>Kode Ruang</td>
                        <td>:</td>
                        <td>
                            <input type="text" name="kode_ruang" value="<?= $data['kode_ruang'] ?>" required autofocus>
                        </td>
                    </tr>
                    <tr>
                        <td>Nama Ruang</td>
                        <td>:</td>
                        <td>
                            <input type="text" name="nama_ruang" value="<?= $data['nama_ruang'] ?>" required>
                        </td>
                    </tr>
                    <tr>
                        <td>Keterangan</td>
                        <td>:</td>
                        <td>
                            <textarea name="keterangan"><?= $data['keterangan'] ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>
                            <input type="submit" name="edit" value="Edit">
                        </td>
                    </tr>                
                </table>
            </form>
        <?php endif; ?>
    </body>
</html>
