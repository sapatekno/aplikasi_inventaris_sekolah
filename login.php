<?php
//memanggil berkas sistem
require_once './app/config.php';
require_once './app/database.php';
require_once './app/fungsi.php';

//set variabel
$error = 0;
$login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);

if (!empty($login)) {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $cek_login = db_petugas_login($db_conn, $username, $password);

    if ($cek_login != TRUE) {
        //login gagal
        $error = 1;
    } else {
        //login berhasil ambil data dari user
        $user = db_petugas_get_data_by_username($db_conn, $username);

        //menyimpan data user ke session
        $_SESSION['login'] = TRUE;
        $_SESSION['id_petugas'] = $user['id_petugas'];
        $_SESSION['username'] = $username;
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['id_level'] = $user['id_level'];

        //login selesai pindah ke halaman index
        header('Location: index.php');
    }
}
?>
<html>
    <head>
        <title>Login</title>
    </head>
    <body>
        <form action="" method="post">
            <table>
                <tr>
                    <td>Username</td>
                    <td>:</td>
                    <td><input type="text" name="username" required autofocus></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td>:</td>
                    <td><input type="password" name="password" required></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td><input type="submit" name="login" value="login"></td>
                </tr>
            </table>
            <?php
            if ($error == 1) :
                echo '<p>Username atau password salah</p>';
            endif;
            ?>
        </form>
    </body>
</html>