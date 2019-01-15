<?php

//variabel untuk mysqli connect
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'prasarana';

//koneksi ke mysqli menggunakan mysqli
$db_conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name) or die(mysqli_error());

//melakukan pengecekan login berdasarkan username dan password
function db_petugas_login($db_conn, $username, $password) {
    $password_hash = sha1($password);
    $sql = "SELECT * FROM petugas WHERE username = '$username' AND password = '$password_hash'";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));
    $result = mysqli_num_rows($query);

    if ($result > 0) {
        return TRUE;
    } else {
        return FALSE;
    }
}

//mengambil data user berdasarkan username
function db_petugas_get_data_by_username($db_conn, $username) {
    $sql = "SELECT * FROM petugas WHERE username = '$username'";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));
    $result = mysqli_fetch_assoc($query);

    return $result;
}

//mengupdate data petugas lama
function db_petugas_update($db_conn, $username, $nama, $password) {
    if (!empty($password)) {
        $password = sha1($password);
        $sql = "UPDATE petugas SET nama = '$nama', password = '$password' WHERE username = '$username'";
    } else {
        $sql = "UPDATE petugas SET nama = '$nama' WHERE username = '$username'";
    }
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));
    $result = mysqli_affected_rows($db_conn);
    return $result;
}

//mengambil nama level berdasarkan id leverl
function db_level_get_nama_by_id($db_conn, $id_level) {
    $sql = "SELECT nama_level FROM level WHERE id_level = '$id_level'";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));
    $result = mysqli_fetch_assoc($query);

    return $result['nama_level'];
}

//mengambil semua data jenis
function db_jenis_get_all($db_conn, $limit, $offset) {
    $sql = "SELECT * FROM jenis ORDER BY kode_jenis ASC LIMIT $limit OFFSET $offset";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));

    return $query;
}

//mengambil semua data jenis berdasarkan pencarian
function db_jenis_get_all_by_cari($db_conn, $limit, $offset, $katacari) {
    $sql = "SELECT * FROM jenis WHERE nama_jenis LIKE '%$katacari%' ORDER BY kode_jenis ASC LIMIT $limit OFFSET $offset";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));

    return $query;
}

//menghitung data jenis
function db_jenis_count($db_conn) {
    $sql = "SELECT * FROM jenis";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));

    return $query;
}

//menghitung semua data jenis
function db_jenis_count_by_cari($db_conn, $katacari) {
    $sql = "SELECT * FROM jenis WHERE nama_jenis LIKE '%$katacari%'";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));

    return $query;
}

//menambahkan data jenis baru
function db_jenis_add($db_conn, $kode_jenis, $nama_jenis, $keterangan) {
    $sql = "INSERT INTO jenis VALUES(null,'$kode_jenis','$nama_jenis','$keterangan') ";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));
    $result = mysqli_affected_rows($db_conn);
    return $result;
}

//mengupdate data jenis lama
function db_jenis_update($db_conn, $id, $kode_jenis, $nama_jenis, $keterangan) {
    $sql = "UPDATE jenis SET kode_jenis = '$kode_jenis', nama_jenis = '$nama_jenis', keterangan = '$keterangan' WHERE id_jenis = $id";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));
    $result = mysqli_affected_rows($db_conn);
    return $result;
}

//menghapus data jenis berdasarkan id
function db_jenis_del($db_conn, $id) {
    $sql = "DELETE FROM jenis WHERE id_jenis = $id";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));
    $result = mysqli_affected_rows($db_conn);
    return $result;
}

//mengambil data jenis berdasarkan id jenis
function db_jenis_get_data_by_id($db_conn, $id) {
    $sql = "SELECT * FROM jenis WHERE id_jenis = '$id'";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));
    $result = mysqli_fetch_assoc($query);

    return $result;
}

//mengambil semua data ruang
function db_ruang_get_all($db_conn, $limit, $offset) {
    $sql = "SELECT * FROM ruang ORDER BY id_ruang DESC LIMIT $limit OFFSET $offset";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));

    return $query;
}

//mengambil semua data ruang berdasarkan pencarian
function db_ruang_get_all_by_cari($db_conn, $limit, $offset, $katacari) {
    $sql = "SELECT * FROM ruang WHERE nama_ruang LIKE '%$katacari%' ORDER BY id_ruang DESC LIMIT $limit OFFSET $offset";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));

    return $query;
}

//menghitung data ruang
function db_ruang_count($db_conn) {
    $sql = "SELECT * FROM ruang";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));

    return $query;
}

//menghitung semua data ruang
function db_ruang_count_by_cari($db_conn, $katacari) {
    $sql = "SELECT * FROM ruang WHERE nama_ruang LIKE '%$katacari%'";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));

    return $query;
}

//menambahkan data ruang baru
function db_ruang_add($db_conn, $kode_ruang, $nama_ruang, $keterangan) {
    $sql = "INSERT INTO ruang VALUES(null,'$kode_ruang','$nama_ruang','$keterangan') ";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));
    $result = mysqli_affected_rows($db_conn);
    return $result;
}

//mengupdate data ruang lama
function db_ruang_update($db_conn, $id, $kode_ruang, $nama_ruang, $keterangan) {
    $sql = "UPDATE ruang SET kode_ruang = '$kode_ruang', nama_ruang = '$nama_ruang', keterangan = '$keterangan' WHERE id_ruang = $id";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));
    $result = mysqli_affected_rows($db_conn);
    return $result;
}

//menghapus data ruang berdasarkan id
function db_ruang_del($db_conn, $id) {
    $sql = "DELETE FROM ruang WHERE id_ruang = $id";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));
    $result = mysqli_affected_rows($db_conn);
    return $result;
}

//mengambil data ruang berdasarkan id ruang
function db_ruang_get_data_by_id($db_conn, $id) {
    $sql = "SELECT * FROM ruang WHERE id_ruang = '$id'";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));
    $result = mysqli_fetch_assoc($query);

    return $result;
}
