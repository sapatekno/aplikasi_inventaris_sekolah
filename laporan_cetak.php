<?php
//berkas sistem
require_once './app/config.php';
require_once './app/database.php';
require_once './app/fungsi.php';

//komponen composer mPdf
require_once './vendor/autoload.php';

//fungsi-fungsi
_isLogin();

//variabel awal
$error = 0;
$no = 1;
$jenis = filter_input(INPUT_GET, 'jn', FILTER_SANITIZE_STRING);
$stylesheet = file_get_contents('./laporan.css');

if ($jenis == 'inventaris') {
    $tanggal_awal = filter_input(INPUT_GET, 'aw', FILTER_SANITIZE_STRING);
    $tanggal_akhir = filter_input(INPUT_GET, 'ak', FILTER_SANITIZE_STRING);
    $kondisi = filter_input(INPUT_GET, 'kd', FILTER_SANITIZE_STRING);
    $laporan = db_lap_inventaris($db_conn, $tanggal_awal, $tanggal_akhir, $kondisi);
} elseif ($jenis == 'peminjaman') {
    $tanggal_awal = filter_input(INPUT_GET, 'aw', FILTER_SANITIZE_STRING);
    $tanggal_akhir = filter_input(INPUT_GET, 'ak', FILTER_SANITIZE_STRING);
    $status = filter_input(INPUT_GET, 'st', FILTER_SANITIZE_STRING);
    $laporan = db_lap_peminjaman($db_conn, $tanggal_awal, $tanggal_akhir, $status);
} elseif ($jenis == 'detail_pinjam') {
    $tanggal_awal = filter_input(INPUT_GET, 'aw', FILTER_SANITIZE_STRING);
    $tanggal_akhir = filter_input(INPUT_GET, 'ak', FILTER_SANITIZE_STRING);
    $laporan = db_lap_peminjaman_detail($db_conn, $tanggal_awal, $tanggal_akhir);
}

$config = [
    'format' => 'A4',
    'orientation' => 'P'
];

$pdf = new \Mpdf\Mpdf();
$pdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
$pdf->WriteHTML('<h2>LAPORAN</h2>');
$pdf->WriteHTML('<br/>');
$pdf->WriteHTML('<table>');
$pdf->WriteHTML('<tr>');

if ($jenis == 'inventaris') {
    $pdf->WriteHTML('<th>No.</th>');
    $pdf->WriteHTML('<th>Kode Inventaris</th>');
    $pdf->WriteHTML('<th>Nama</th>');
    $pdf->WriteHTML('<th>Tanggal Register</th>');
    $pdf->WriteHTML('<th>Jumlah</th>');
    $pdf->WriteHTML('<th>Kondisi</th>');
} elseif ($jenis == 'peminjaman') {
    $pdf->WriteHTML('<th>No.</th>');
    $pdf->WriteHTML('<th>Kode Peminjaman</th>');
    $pdf->WriteHTML('<th>Peminjam</th>');
    $pdf->WriteHTML('<th>Tanggal Pinjam</th>');
    $pdf->WriteHTML('<th>Tanggal Kembali</th>');
    $pdf->WriteHTML('<th>Status Peminjaman</th>');
} elseif ($jenis == 'detail_pinjam') {
    $pdf->WriteHTML('<th>No.</th>');
    $pdf->WriteHTML('<th>Kode Peminjaman</th>');
    $pdf->WriteHTML('<th>Nama Peminjam</th>');
    $pdf->WriteHTML('<th>Nama Inventaris</th>');
    $pdf->WriteHTML('<th>Jumlah</th>');
    $pdf->WriteHTML('<th>Status Peminjaman</th>');
}

$pdf->WriteHTML('</tr>');
foreach ($laporan as $data) {
    $pdf->WriteHTML('<tr>');
    $pdf->WriteHTML("<td>$no</td>");

    if ($jenis == 'inventaris') {
        $pdf->WriteHTML("<td>$data[kode_inventaris]</td>");
        $pdf->WriteHTML("<td>$data[nama]</td>");
        $pdf->WriteHTML('<td>' . _tanggal_indo($data['tanggal_register']) . '</td>');
        $pdf->WriteHTML("<td>$data[jumlah] Item</td>");
        $pdf->WriteHTML('<td>' . ucwords($data['kondisi']) . '</td>');
    } elseif ($jenis == 'peminjaman') {
        $pdf->WriteHTML("<td>$data[id_peminjaman]</td>");
        $pdf->WriteHTML("<td>$data[nama_pegawai]</td>");
        $pdf->WriteHTML('<td>' . _tanggal_indo($data['tanggal_pinjam']) . '</td>');
        $pdf->WriteHTML('<td>' . _tanggal_indo($data['tanggal_kembali']) . '</td>');
        $pdf->WriteHTML('<td>' . _status_peminjaman_nama($data['status_peminjaman']) . '</td>');
    } elseif ($jenis == 'detail_pinjam') {
        $pdf->WriteHTML("<td>$data[id_peminjaman]</td>");
        $pdf->WriteHTML("<td>$data[nama_pegawai]</td>");
        $pdf->WriteHTML("<td>$data[nama]</td>");
        $pdf->WriteHTML("<td>$data[jumlah] Item</td>");
        $pdf->WriteHTML('<td>' . _status_peminjaman_nama($data['status_peminjaman']) . '</td>');

    }

    $pdf->WriteHTML('</tr>');
    $no++;
}
$pdf->WriteHTML('</table>');
$pdf->Output();
?>