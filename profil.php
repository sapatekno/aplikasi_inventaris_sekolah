<?php
//berkas sistem
require_once './app/config.php';
require_once './app/database.php';
require_once './app/fungsi.php';

//fungsi-fungsi
_isLogin();

$error = 0;
$username = $_SESSION['username'];
$profil = db_petugas_get_data_by_username($db_conn, $username);

$ubah = filter_input(INPUT_POST, 'ubah', FILTER_SANITIZE_STRING);

if (!empty($ubah)) {
    $nama = filter_input(INPUT_POST, 'nama', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRIPPED);

    $ubah = db_petugas_update($db_conn, $username, $nama, $password);

    if ($ubah > 0) {
        //kembali ke menu utama
        $_SESSION['nama'] = $nama;
        header('Location: index.php');
    } else {
        $error = 1;
    }
}
?>
<html>
    <head>
        <title>Profil</title>
    </head>
    <body>
        <p><a href="./index.php">Home</a> > Profil</p>
        <form action="./profil.php" method="post">
            <table>
                <tr>
                    <td>Username</td>
                    <td>:</td>
                    <td><?= $profil['username'] ?></td>
                </tr>
                <tr>
                    <td>Nama Pengguna</td>
                    <td>:</td>
                    <td><input type="text" name="nama" value="<?= $profil['nama'] ?>" required></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td>:</td>
                    <td><input type="password" name="password"></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>
                        <input type="submit" name="ubah" value="UBAH">
                    </td>
                </tr>
            </table>
        </form>
        <p>Catatan : Kosongkan Kolom Password Jika Tidak Ingin Di Rubah Datanya</p>
        <?php
        if ($error == 1) :
            echo '<p>Tidak ada data yang dirubah, pastikan ada perubahan pada Nama atau Password sebelumnya.</p>';
        endif;
        ?>
    </body>
</html>
