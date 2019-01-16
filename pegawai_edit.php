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
    $data = db_pegawai_get_data_by_id($db_conn, $id);

    //jika id data tidak ditemukan dalam database
    if (empty($data)) {
        $error = 1;
        $pesan_error = 'ID data tidak ditemukan';
    }

    if (!empty($edit)) {
        $nip = filter_input(INPUT_POST, 'nip', FILTER_SANITIZE_STRING);
        $nama_pegawai = filter_input(INPUT_POST, 'nama_pegawai', FILTER_SANITIZE_STRING);
        $alamat = filter_input(INPUT_POST, 'alamat', FILTER_SANITIZE_STRING);

        $simpan = db_pegawai_update($db_conn, $id, $nip, $nama_pegawai, $alamat);

        if ($simpan > 0) {
            //berhasil menyimpan data
            header('Location: ./pegawai.php');
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
        <title>Edit Data Pegawai</title>
    </head>
    <body>
        <p><a href="./index.php">Home</a> > <a href="./pegawai.php">Pegawai</a> > Edit Pegawai</p>
        <?php if ($error == 1) : ?>
            <p><?= $pesan_error ?></p>
        <?php else : ?>

            <form action="" method="post">
                <table>
                    <tr>
                        <td>NIP</td>
                        <td>:</td>
                        <td>
                            <input type="text" name="nip" value="<?= $data['nip'] ?>" required autofocus>
                        </td>
                    </tr>
                    <tr>
                        <td>Nama Pegawai</td>
                        <td>:</td>
                        <td>
                            <input type="text" name="nama_pegawai" value="<?= $data['nama_pegawai'] ?>" required>
                        </td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td>
                            <textarea name="alamat" required><?= $data['alamat'] ?></textarea>
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
