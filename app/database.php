<?php

//variabel untuk mysqli connect
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'prasarana';

//koneksi ke mysqli menggunakan mysqli
$db_conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name) or die(mysqli_error());

//melakukan pengecekan login berdasarkan username dan password
function db_petugas_login($db_conn, $username, $password)
{
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
function db_petugas_get_data_by_username($db_conn, $username)
{
    $sql = "SELECT * FROM petugas WHERE username = '$username'";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));
    $result = mysqli_fetch_assoc($query);

    return $result;
}

//mengambil data user berdasarkan username
function db_petugas_get_nama_by_id($db_conn, $id)
{
    $sql = "SELECT nama FROM petugas WHERE id_petugas = '$id'";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));
    $result = mysqli_fetch_assoc($query);

    return $result['nama'];
}

//mengupdate data petugas lama
function db_petugas_update($db_conn, $username, $nama, $password)
{
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

//mengambil nama level berdasarkan id level
function db_level_get_nama_by_id($db_conn, $id_level)
{
    $sql = "SELECT nama_level FROM level WHERE id_level = '$id_level'";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));
    $result = mysqli_fetch_assoc($query);

    return $result['nama_level'];
}

//mengambil nama jenis berdasarkan id jenis
function db_jenis_get_nama_by_id($db_conn, $id_level)
{
    $sql = "SELECT nama_jenis FROM jenis WHERE id_jenis = '$id_level'";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));
    $result = mysqli_fetch_assoc($query);

    return $result['nama_jenis'];
}

//mengambil semua data jenis untuk inventaris
function db_jenis_all($db_conn)
{
    $sql = "SELECT * FROM jenis";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));
    return $query;
}

//mengambil semua data jenis
function db_jenis_get_all($db_conn, $limit, $offset)
{
    $sql = "SELECT * FROM jenis ORDER BY kode_jenis ASC LIMIT $limit OFFSET $offset";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));

    return $query;
}

//mengambil semua data jenis berdasarkan pencarian
function db_jenis_get_all_by_cari($db_conn, $limit, $offset, $katacari)
{
    $sql = "SELECT * FROM jenis WHERE nama_jenis LIKE '%$katacari%' ORDER BY kode_jenis ASC LIMIT $limit OFFSET $offset";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));

    return $query;
}

//menghitung data jenis
function db_jenis_count($db_conn)
{
    $sql = "SELECT * FROM jenis";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));

    return $query;
}

//menghitung semua data jenis
function db_jenis_count_by_cari($db_conn, $katacari)
{
    $sql = "SELECT * FROM jenis WHERE nama_jenis LIKE '%$katacari%'";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));

    return $query;
}

//menambahkan data jenis baru
function db_jenis_add($db_conn, $kode_jenis, $nama_jenis, $keterangan)
{
    $sql = "INSERT INTO jenis VALUES(null,'$kode_jenis','$nama_jenis','$keterangan') ";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));
    $result = mysqli_affected_rows($db_conn);
    return $result;
}

//mengupdate data jenis lama
function db_jenis_update($db_conn, $id, $kode_jenis, $nama_jenis, $keterangan)
{
    $sql = "UPDATE jenis SET kode_jenis = '$kode_jenis', nama_jenis = '$nama_jenis', keterangan = '$keterangan' WHERE id_jenis = $id";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));
    $result = mysqli_affected_rows($db_conn);
    return $result;
}

//menghapus data jenis berdasarkan id
function db_jenis_del($db_conn, $id)
{
    $sql = "DELETE FROM jenis WHERE id_jenis = $id";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));
    $result = mysqli_affected_rows($db_conn);
    return $result;
}

//mengambil data jenis berdasarkan id jenis
function db_jenis_get_data_by_id($db_conn, $id)
{
    $sql = "SELECT * FROM jenis WHERE id_jenis = '$id'";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));
    $result = mysqli_fetch_assoc($query);

    return $result;
}

//mengambil semua data ruang untuk inventaris
function db_ruang_all($db_conn)
{
    $sql = "SELECT * FROM ruang";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));

    return $query;
}

//mengambil semua data ruang
function db_ruang_get_all($db_conn, $limit, $offset)
{
    $sql = "SELECT * FROM ruang ORDER BY id_ruang DESC LIMIT $limit OFFSET $offset";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));

    return $query;
}

//mengambil semua data ruang berdasarkan pencarian
function db_ruang_get_all_by_cari($db_conn, $limit, $offset, $katacari)
{
    $sql = "SELECT * FROM ruang WHERE nama_ruang LIKE '%$katacari%' ORDER BY id_ruang DESC LIMIT $limit OFFSET $offset";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));

    return $query;
}

//menghitung data ruang
function db_ruang_count($db_conn)
{
    $sql = "SELECT * FROM ruang";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));

    return $query;
}

//menghitung semua data ruang
function db_ruang_count_by_cari($db_conn, $katacari)
{
    $sql = "SELECT * FROM ruang WHERE nama_ruang LIKE '%$katacari%'";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));

    return $query;
}

//mengambil nama ruang berdasarkan id ruang
function db_ruang_get_nama_by_id($db_conn, $id_ruang)
{
    $sql = "SELECT nama_ruang FROM ruang WHERE id_ruang = '$id_ruang'";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));
    $result = mysqli_fetch_assoc($query);

    return $result['nama_ruang'];
}

//menambahkan data ruang baru
function db_ruang_add($db_conn, $kode_ruang, $nama_ruang, $keterangan)
{
    $sql = "INSERT INTO ruang VALUES(null,'$kode_ruang','$nama_ruang','$keterangan') ";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));
    $result = mysqli_affected_rows($db_conn);
    return $result;
}

//mengupdate data ruang lama
function db_ruang_update($db_conn, $id, $kode_ruang, $nama_ruang, $keterangan)
{
    $sql = "UPDATE ruang SET kode_ruang = '$kode_ruang', nama_ruang = '$nama_ruang', keterangan = '$keterangan' WHERE id_ruang = $id";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));
    $result = mysqli_affected_rows($db_conn);
    return $result;
}

//menghapus data ruang berdasarkan id
function db_ruang_del($db_conn, $id)
{
    $sql = "DELETE FROM ruang WHERE id_ruang = $id";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));
    $result = mysqli_affected_rows($db_conn);
    return $result;
}

//mengambil data ruang berdasarkan id ruang
function db_ruang_get_data_by_id($db_conn, $id)
{
    $sql = "SELECT * FROM ruang WHERE id_ruang = '$id'";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));
    $result = mysqli_fetch_assoc($query);

    return $result;
}

//mengambil semua data pegawai untuk select option
function db_pegawai_all($db_conn)
{
    $sql = "SELECT * FROM pegawai";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));

    return $query;
}

//mengambil semua data pegawai
function db_pegawai_get_all($db_conn, $limit, $offset)
{
    $sql = "SELECT * FROM pegawai ORDER BY nip ASC LIMIT $limit OFFSET $offset";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));

    return $query;
}

//mengambil semua data pegawai berdasarkan pencarian
function db_pegawai_get_all_by_cari($db_conn, $limit, $offset, $katacari)
{
    $sql = "SELECT * FROM pegawai WHERE nama_pegawai LIKE '%$katacari%' ORDER BY nip ASC LIMIT $limit OFFSET $offset";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));

    return $query;
}

//menghitung data pegawai
function db_pegawai_count($db_conn)
{
    $sql = "SELECT * FROM pegawai";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));

    return $query;
}

//menghitung semua data pegawai
function db_pegawai_count_by_cari($db_conn, $katacari)
{
    $sql = "SELECT * FROM pegawai WHERE nama_pegawai LIKE '%$katacari%'";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));

    return $query;
}

//menambahkan data pegawai baru
function db_pegawai_add($db_conn, $nip, $nama_pegawai, $alamat)
{
    $sql = "INSERT INTO pegawai VALUES(null, '$nama_pegawai', '$nip', '$alamat') ";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));
    $result = mysqli_affected_rows($db_conn);
    return $result;
}

//mengupdate data pegawai lama
function db_pegawai_update($db_conn, $id, $nip, $nama_pegawai, $alamat)
{
    $sql = "UPDATE pegawai SET nip = '$nip', nama_pegawai = '$nama_pegawai', alamat = '$alamat' WHERE id_pegawai = $id";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));
    $result = mysqli_affected_rows($db_conn);
    return $result;
}

//menghapus data pegawai berdasarkan id
function db_pegawai_del($db_conn, $id)
{
    $sql = "DELETE FROM pegawai WHERE id_pegawai = $id";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));
    $result = mysqli_affected_rows($db_conn);
    return $result;
}

//mengambil data pegawai berdasarkan id pegawai
function db_pegawai_get_data_by_id($db_conn, $id)
{
    $sql = "SELECT * FROM pegawai WHERE id_pegawai = '$id'";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));
    $result = mysqli_fetch_assoc($query);

    return $result;
}

//mengambil data user berdasarkan username
function db_pegawai_get_nama_by_id($db_conn, $id)
{
    $sql = "SELECT nama_pegawai FROM pegawai WHERE id_pegawai = '$id'";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));
    $result = mysqli_fetch_assoc($query);

    return $result['nama_pegawai'];
}

//mengambil semua data inventaris untuk select option
function db_inventaris_all($db_conn)
{
    $sql = "SELECT * FROM inventaris";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));

    return $query;
}

//mengambil semua data inventaris
function db_inventaris_get_all($db_conn, $limit, $offset)
{
    $sql = "SELECT * FROM inventaris ORDER BY id_inventaris ASC LIMIT $limit OFFSET $offset";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));

    return $query;
}

//mengambil semua data inventaris berdasarkan pencarian
function db_inventaris_get_all_by_cari($db_conn, $limit, $offset, $katacari)
{
    $sql = "SELECT * FROM inventaris WHERE nama LIKE '%$katacari%' ORDER BY id_inventaris ASC LIMIT $limit OFFSET $offset";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));

    return $query;
}

//menghitung data inventaris
function db_inventaris_count($db_conn)
{
    $sql = "SELECT * FROM inventaris";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));

    return $query;
}

//menghitung semua data inventaris
function db_inventaris_count_by_cari($db_conn, $katacari)
{
    $sql = "SELECT * FROM inventaris WHERE nama LIKE '%$katacari%'";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));

    return $query;
}

//menambahkan data inventaris baru
function db_inventaris_add($db_conn, $kode_inventaris, $tanggal_register, $nama, $id_jenis, $id_ruang, $jumlah, $kondisi, $keterangan, $id_petugas)
{
    $sql = "INSERT INTO inventaris VALUES(null, '$nama', '$kondisi', '$keterangan', $jumlah, $id_jenis, '$tanggal_register', $id_ruang, '$kode_inventaris', $id_petugas) ";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));
    $result = mysqli_affected_rows($db_conn);
    return $result;
}

//mengupdate data inventaris lama
function db_inventaris_update($db_conn, $id, $tanggal_register, $nama, $id_jenis, $id_ruang, $jumlah, $kondisi, $keterangan, $id_petugas)
{
    $sql = "UPDATE inventaris SET tanggal_register = '$tanggal_register', nama = '$nama', id_jenis = $id_jenis, id_ruang = $id_ruang, jumlah = $jumlah, kondisi = '$kondisi', keterangan = '$keterangan', id_petugas = $id_petugas WHERE id_inventaris = $id";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));
    $result = mysqli_affected_rows($db_conn);
    return $result;
}

//menghapus data inventaris berdasarkan id
function db_inventaris_del($db_conn, $id)
{
    $sql = "DELETE FROM inventaris WHERE id_inventaris = $id";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));
    $result = mysqli_affected_rows($db_conn);
    return $result;
}

//mengambil data inventaris berdasarkan id inventaris
function db_inventaris_get_data_by_id($db_conn, $id)
{
    $sql = "SELECT * FROM inventaris WHERE id_inventaris = '$id'";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));
    $result = mysqli_fetch_assoc($query);
    return $result;
}

//mengambil id terakhir peminjaman dari petugas
function db_peminjaman_get_latest_add($db_conn, $id_petugas)
{
    $sql = "SELECT id_peminjaman FROM peminjaman WHERE id_petugas= $id_petugas ORDER BY id_peminjaman DESC";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));
    $result = mysqli_fetch_assoc($query);
    return $result['id_peminjaman'];
}

//menambahkan data peminjaman baru
function db_peminjaman_add($db_conn, $tanggal_pinjam, $tanggal_kembali, $status_peminjaman, $id_petugas, $id_pegawai)
{
    $sql = "INSERT INTO peminjaman VALUES(null, '$tanggal_pinjam', '$tanggal_kembali', $status_peminjaman, $id_petugas, $id_pegawai) ";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));
    $result = mysqli_affected_rows($db_conn);
    return $result;
}

//mengambil semua data peminjaman
function db_peminjaman_get_all($db_conn, $limit, $offset)
{
    $sql = "SELECT peminjaman.*, petugas.nama, pegawai.nama_pegawai FROM peminjaman INNER JOIN petugas ON peminjaman.id_petugas = petugas.id_petugas INNER JOIN pegawai ON peminjaman.id_pegawai = pegawai.id_pegawai ORDER BY id_peminjaman ASC LIMIT $limit OFFSET $offset";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));

    return $query;
}

//mengambil semua data peminjaman berdasarkan pencarian
function db_peminjaman_get_all_by_cari($db_conn, $limit, $offset, $katacari)
{
    $sql = "SELECT peminjaman.*, petugas.nama, pegawai.nama_pegawai FROM peminjaman INNER JOIN petugas ON peminjaman.id_petugas = petugas.id_petugas INNER JOIN pegawai ON peminjaman.id_pegawai = pegawai.id_pegawai WHERE nama_peminjaman LIKE '%$katacari%' ORDER BY nip ASC LIMIT $limit OFFSET $offset";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));

    return $query;
}

//menghitung data peminjaman
function db_peminjaman_count($db_conn)
{
    $sql = "SELECT * FROM peminjaman";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));

    return $query;
}

//menghitung semua data peminjaman
function db_peminjaman_count_by_cari($db_conn, $katacari)
{
    $sql = "SELECT * FROM peminjaman WHERE nama_peminjaman LIKE '%$katacari%'";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));

    return $query;
}

//menghapus data peminjaman berdasarkan id
function db_peminjaman_del($db_conn, $id)
{
    $sql = "DELETE FROM peminjaman WHERE id_peminjaman = $id";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));
    $result = mysqli_affected_rows($db_conn);
    return $result;
}

//mengambil data peminjaman berdasarkan id_peminjaman
function db_peminjaman_get_data_by_id($db_conn, $id)
{
    $sql = "SELECT * FROM peminjaman WHERE id_peminjaman = '$id'";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));
    $result = mysqli_fetch_assoc($query);

    return $result;
}

//mengambil semua data inventaris
function db_peminjaman_detail_get_all($db_conn, $id, $limit, $offset)
{
    $sql = "SELECT detail_pinjam.*, inventaris.kode_inventaris, inventaris.nama FROM detail_pinjam INNER JOIN inventaris ON detail_pinjam.id_inventaris = inventaris.id_inventaris WHERE id_peminjaman = $id ORDER BY nama ASC LIMIT $limit OFFSET $offset";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));

    return $query;
}

//menghitung data peminjaman detail
function db_peminjaman_detail_count($db_conn, $id)
{
    $sql = "SELECT * FROM detail_pinjam WHERE id_peminjaman = $id";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));

    return $query;
}

//menambahkan peminjaman detail baru
function db_peminjaman_detail_add($db_conn, $id_inventaris, $jumlah, $id_peminjaman)
{
    $sql = "INSERT INTO detail_pinjam VALUES(null, $id_inventaris, $jumlah, $id_peminjaman) ";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));
    $result = mysqli_affected_rows($db_conn);
    return $result;
}

//menghapus data peminjaman detail berdasarkan id
function db_peminjaman_detail_del($db_conn, $id)
{
    $sql = "DELETE FROM detail_pinjam WHERE id_detail_pinjam = $id";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));
    $result = mysqli_affected_rows($db_conn);
    return $result;
}

//mengambil data inventaris untuk laporan
function db_lap_inventaris($db_conn, $tanggal_awal, $tanggal_akhir, $kondisi)
{
    $sql = "SELECT * FROM inventaris WHERE tanggal_register BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
    if ($kondisi != 'semua') {
        $sql += " AND kondisi='$kondisi'";
    }
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));
    return $query;
}

//mengambil data peminjaman untuk laporan
function db_lap_peminjaman($db_conn, $tanggal_awal, $tanggal_akhir, $status)
{
    $sql = "SELECT
  pegawai.nama_pegawai,
  peminjaman.*
FROM peminjaman
  INNER JOIN pegawai
    ON peminjaman.id_pegawai = pegawai.id_pegawai WHERE tanggal_pinjam BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
    if ($status != 'semua') {
        $sql += " AND status_peminjaman=$status";
    }
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));
    return $query;
}

//mengambil data detail pinjam untuk laporan
function db_lap_peminjaman_detail($db_conn, $tanggal_awal, $tanggal_akhir)
{
    $sql = "SELECT
  detail_pinjam.*,
  peminjaman.*,
  inventaris.kode_inventaris,
  inventaris.nama,
  detail_pinjam.jumlah,
  detail_pinjam.id_peminjaman,
  peminjaman.status_peminjaman,
  peminjaman.tanggal_pinjam,
  pegawai.nama_pegawai
FROM detail_pinjam
  INNER JOIN peminjaman
    ON detail_pinjam.id_peminjaman = peminjaman.id_peminjaman
  INNER JOIN inventaris
    ON detail_pinjam.id_inventaris = inventaris.id_inventaris
  INNER JOIN pegawai
    ON peminjaman.id_pegawai = pegawai.id_pegawai
WHERE peminjaman.tanggal_pinjam BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
    $query = mysqli_query($db_conn, $sql) or die(mysqli_error($db_conn));
    return $query;
}