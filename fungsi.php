<?php
function koneksi() {
    $host = 'localhost'; 
    $user = 'root';  
    $password = '';  
    $dbname = 'db_saw';  
    
    // Create connection
    $conn = new mysqli($host, $user, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

// Fungsi untuk mengambil data dari database
function get_data($query) {
    $conn = koneksi();
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    } else {
        return [];
    }

    $conn->close();
}

// Fungsi untuk mengambil data relasi alternatif dan sub-kriteria
function get_rel_alternatif() {
    $conn = koneksi();
    $query = "SELECT a.id AS alternatif_id, k.id AS kriteria_id, s.id AS sub_id, s.nama_sub, s.nilai_bobot
              FROM tb_alternatif a
              JOIN tb_nilai_alternatif na ON na.kode_alternatif = a.kode_alternatif
              JOIN tb_sub s ON s.id = na.id_sub
              JOIN tb_kriteria k ON k.kode = na.kode_kriteria";
    $result = $conn->query($query);

    $rel_alternatif = [];

    while ($row = $result->fetch_assoc()) {
        $rel_alternatif[$row['alternatif_id']][$row['kriteria_id']] = $row;
    }

    $conn->close();
    return $rel_alternatif;
}

// Fungsi untuk mendapatkan normalisasi nilai
function get_normalisasi() {
    $conn = koneksi();
    $query = "SELECT a.kode_alternatif, a.nama_alternatif, k.id AS kriteria_id, 
              SUM(na.nilai_bobot) AS total_nilai
              FROM tb_alternatif a
              JOIN tb_nilai_alternatif na ON na.kode_alternatif = a.kode_alternatif
              JOIN tb_kriteria k ON k.kode = na.kode_kriteria
              GROUP BY a.id, k.id";
    $result = $conn->query($query);

    $normal = [];
    while ($row = $result->fetch_assoc()) {
        $normal[] = $row;
    }

    $conn->close();
    return $normal;
}
?>
