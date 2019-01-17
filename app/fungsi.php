<?php

//pengecekan status login berdasarkan sesi
function _isLogin() {
    $login = $_SESSION['login'];
    if ($login != TRUE) {
        header('Location: login.php');
    }
}

//pengecekan status level berdasarkan data dalam array
function _isLevel($data) {
    $id_level = $_SESSION['id_level'];
    if (!in_array($id_level, $data)) {
        header('Location: noaccess.php');
    }
}

//merubah tanggal format international menjadi tanggal indonesia
function _tanggal_indo($tanggal) {
    $bulan = array(1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $split = explode('-', $tanggal);
    return $split[2] . ' ' . $bulan[(int) $split[1]] . ' ' . $split[0];
}