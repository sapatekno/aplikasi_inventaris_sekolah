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
