<?php
//berkas sistem
require_once './app/config.php';
require_once './app/database.php';
require_once './app/fungsi.php';

//fungsi-fungsi
_isLogin();

$error = 0;


if (!empty($ubah)) {
}

?>
<html>
<head>
    <title>Cetak Laporan</title>
</head>
<body>
<p><a href="./index.php">Home</a> > Cetak Laporan</p>
<br/>

<h3>Laporan Peminjaman</h3>
<form action="./laporan_cetak.php" method="get" target="_blank">
    <input type="hidden" name="jn" value="peminjaman">
    <table>
        <tr>
            <td>Rentang Tanggal Peminjaman</td>
            <td>:</td>
            <td>
                <input type="date" name="aw" value="<?= date('Y-m-d') ?>" required> :
                <input type="date" name="ak" value="<?= date('Y-m-d') ?>" required>
            </td>
        </tr>
        <tr>
            <td>Status Peminjaman</td>
            <td>:</td>
            <td>
                <select name="st" required>
                    <option value="semua">Semua Status</option>
                    <option value="0">Belum dikembalikan</option>
                    <option value="1">Sudah dikembalikan</option>
                </select>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="submit" value="CETAK">
            </td>
        </tr>
    </table>
</form>

<h3>Laporan Peminjaman Detail</h3>
<form action="./laporan_cetak.php" method="get" target="_blank">
    <input type="hidden" name="jn" value="detail_pinjam">
    <table>
        <tr>
            <td>Rentang Tanggal Peminjaman</td>
            <td>:</td>
            <td>
                <input type="date" name="aw" value="<?= date('Y-m-d') ?>" required> :
                <input type="date" name="ak" value="<?= date('Y-m-d') ?>" required>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="submit" value="CETAK">
            </td>
        </tr>
    </table>
</form>

<h3>Laporan Inventaris</h3>
<form action="./laporan_cetak.php" method="get" target="_blank">
    <input type="hidden" name="jn" value="inventaris">
    <table>
        <tr>
            <td>Rentang Tanggal Register</td>
            <td>:</td>
            <td>
                <input type="date" name="aw" value="<?= date('Y-m-d') ?>" required> :
                <input type="date" name="ak" value="<?= date('Y-m-d') ?>" required>
            </td>
        </tr>
        <tr>
            <td>Kondisi Inventaris</td>
            <td>:</td>
            <td>
                <select name="kd" required>
                    <option value="semua">Semua Kondisi</option>
                    <option value="bagus">Bagus</option>
                    <option value="rusak">Rusak</option>
                </select>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="submit" value="CETAK">
            </td>
        </tr>
    </table>
</form>

<?php
if ($error == 1) :
    echo '<p>Tidak ada data yang dirubah, pastikan ada perubahan pada Nama atau Password sebelumnya.</p>';
endif;
?>
</body>
</html>
