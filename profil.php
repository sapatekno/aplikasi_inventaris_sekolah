
<?php
require_once './config.php';
require_once './database.php';
require_once './fungsi.php';

_isLogin();

$username = $_SESSION['username'];
$profil = db_user_get_data_by_username($db_conn, $username);
?>
<html>
    <head>
        <title>Profil</title>
    </head>
    <body>
        <p><a href="./index.php">Home</a> > Profil</p>
        <table>
            <tr>
                <td>Username</td>
                <td>:</td>
                <td><?= $profil['username'] ?></td>
            </tr>
            <tr>
                <td>NIP</td>
                <td>:</td>
                <td><?= $profil['nip'] ?></td>
            </tr>
            <tr>
                <td>Nama Pengguna</td>
                <td>:</td>
                <td><input type="text" name="nama" value="<?= $profil['nama'] ?>"></td>
            </tr>
            <tr>
                <td>Password</td>
                <td>:</td>
                <td><input type="password" name="password"></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>
                    <textarea name="alamat">
                        <?= $profil['alamat'] ?>
                    </textarea>
                </td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>
                    <input type="submit" name="ubah" value="UBAH">
                </td>
            </tr>
        </table>
        <p>Catatan : Kosongkan Kolom Jika Tidak Ingin Di Rubah Datanya</p>
    </body>
</html>
