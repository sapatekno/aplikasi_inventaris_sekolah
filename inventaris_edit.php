<?php
//berkas sistem
require_once './app/config.php';
require_once './app/database.php';
require_once './app/fungsi.php';

_isLogin();
_isLevel([1]);

$error = 0;
$d_jenis = db_jenis_all($db_conn);
$d_ruang = db_ruang_all($db_conn);
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
$edit = filter_input(INPUT_POST, 'edit', FILTER_SANITIZE_STRING);

if (!empty($id)) {
    $data = db_inventaris_get_data_by_id($db_conn, $id);

    //jika id data tidak ditemukan dalam database
    if (empty($data)) {
        $error = 1;
        $pesan_error = 'ID data tidak ditemukan';
    }

    if (!empty($edit)) {
        $tanggal_register = filter_input(INPUT_POST, 'tanggal_register', FILTER_SANITIZE_STRING);
        $nama = filter_input(INPUT_POST, 'nama', FILTER_SANITIZE_STRING);
        $id_jenis = filter_input(INPUT_POST, 'id_jenis', FILTER_SANITIZE_STRING);
        $id_ruang = filter_input(INPUT_POST, 'id_ruang', FILTER_SANITIZE_STRING);
        $jumlah = filter_input(INPUT_POST, 'jumlah', FILTER_SANITIZE_STRING);
        $kondisi = filter_input(INPUT_POST, 'kondisi', FILTER_SANITIZE_STRING);
        $keterangan = filter_input(INPUT_POST, 'keterangan', FILTER_SANITIZE_STRING);
        $id_petugas = $_SESSION['id_petugas'];

        $simpan = db_inventaris_update($db_conn, $id, $tanggal_register, $nama, $id_jenis, $id_ruang, $jumlah, $kondisi, $keterangan, $id_petugas);

        if ($simpan > 0) {
            //berhasil menyimpan data
            header('Location: ./inventaris.php');
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
        <title>Edit Data Inventaris</title>
    </head>
    <body>
        <p><a href="./index.php">Home</a> > <a href="./inventaris.php">Inventaris</a> > Edit Inventaris</p>
        <?php if ($error == 1) : ?>
            <p><?= $pesan_error ?></p>
        <?php else : ?>

            <form action="" method="post">
                <table>
                    <tr>
                    <tr>
                        <td>Petugas Input</td>
                        <td>:</td>
                        <td>
                            <?= db_petugas_get_nama_by_id($db_conn, $data['id_petugas']) ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Kode Inventaris</td>
                        <td>:</td>
                        <td>
                            <?= $data['kode_inventaris'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Tanggal Register</td>
                        <td>:</td>
                        <td>
                            <input type="date" name="tanggal_register" value="<?= $data['tanggal_register'] ?>" required>
                        </td>
                    </tr>
                    <tr>
                        <td>Nama Inventaris</td>
                        <td>:</td>
                        <td>
                            <input type="text" name="nama" value="<?= $data['nama'] ?>" required>
                        </td>
                    </tr>
                    <tr>
                        <td>Jenis Inventaris</td>
                        <td>:</td>
                        <td>
                            <select name="id_jenis">
                                <option value="<?= $data['id_jenis'] ?>">Tidak dirubah</option>
                                <?php foreach ($d_jenis as $djenis) : ?>
                                    <option value="<?= $djenis['id_jenis'] ?>"><?= $djenis['kode_jenis'] ?> - <?= $djenis['nama_jenis'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Ruangan</td>
                        <td>:</td>
                        <td>
                            <select name="id_ruang">
                                <option value="<?= $data['id_ruang'] ?>">Tidak dirubah</option>
                                <?php foreach ($d_ruang as $druang) : ?>
                                    <option value="<?= $data['id_ruang'] ?>"><?= $druang['kode_ruang'] ?> - <?= $druang['nama_ruang'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Jumlah</td>
                        <td>:</td>
                        <td>
                            <input type="number" value="<?= $data['jumlah'] ?>" min="0" name="jumlah" required >
                        </td>
                    </tr>
                    <tr>
                        <td>Kondisi Inventaris</td>
                        <td>:</td>
                        <td>
                            <select name="kondisi">
                                <option value="<?= $data['kondisi'] ?>">Tidak dirubah</option>
                                <option value="bagus">BAGUS</option>
                                <option value="rusak">RUSAK</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Keterangan</td>
                        <td>:</td>
                        <td>
                            <textarea name="keterangan" required><?= $data['keterangan'] ?></textarea>
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
                <p>Data petugas akan diperbaharui oleh petugas yang mengubah terakhir.</p>
            </form>
        <?php endif; ?>
    </body>
</html>
