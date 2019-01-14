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
    $data = db_jenis_get_data_by_id($db_conn, $id);

    if (!empty($edit)) {
        $kode_jenis = filter_input(INPUT_POST, 'kode_jenis', FILTER_SANITIZE_STRING);
        $nama_jenis = filter_input(INPUT_POST, 'nama_jenis', FILTER_SANITIZE_STRING);
        $keterangan = filter_input(INPUT_POST, 'keterangan', FILTER_SANITIZE_STRING);

        $simpan = db_jenis_update($db_conn, $id, $kode_jenis, $nama_jenis, $keterangan);

        if ($simpan > 0) {
            //berhasil menyimpan data
            header('Location: ./jenis.php');
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
        <title>Edit Data Jenis Barang</title>
    </head>
    <body>
        <p><a href="./index.php">Home</a> > <a href="./jenis.php">Jenis Barang</a> > Edit Jenis Barang</p>
        <?php if ($error == 1) : ?>
            <p><?= $pesan_error ?></p>
        <?php else : ?>

            <form action="" method="post">
                <table>
                    <tr>
                        <td>Kode Jenis Barang</td>
                        <td>:</td>
                        <td>
                            <input type="text" name="kode_jenis" value="<?= $data['kode_jenis'] ?>" required autofocus>
                        </td>
                    </tr>
                    <tr>
                        <td>Nama Jenis Barang</td>
                        <td>:</td>
                        <td>
                            <input type="text" name="nama_jenis" value="<?= $data['nama_jenis'] ?>" required>
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
