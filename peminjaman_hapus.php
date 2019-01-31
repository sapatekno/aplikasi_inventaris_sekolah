<?php
//berkas sistem
require_once './app/config.php';
require_once './app/database.php';
require_once './app/fungsi.php';

//fungsi
_isLogin();
_isLevel([1]);

$error = 0;
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);

if (!empty($id)) {
    $hapus = db_peminjaman_del($db_conn, $id);

    if ($hapus > 0) {
        //berhasil menghapus data peminjaman
        header('Location: ./peminjaman.php');
    } else {
        $error = 1;
        $pesan_error = "Kesalahan dalam menghapus data";
    }
} else {
    $error = 1;
    $pesan_error = "Tidak ada ID dalam parameter GET";
}
?>
<html>
    <head>
        <title>Hapus Data Peminjaman</title>
    </head>
    <body>
        <p><a href="./index.php">Home</a> > <a href="./peminjaman.php">Peminjaman</a> > Hapus Peminjaman</p>
        <?php
        if ($error == 1) :
            echo "<p>$pesan_error</p>";
        endif;
        ?>
    </form>
</body>
</html>
