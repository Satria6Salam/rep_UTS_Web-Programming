<?php
header('Content-Type: application/json');
require_once 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_kategori'];
    $keterangan = $_POST['keterangan'];

    // Hanya untuk INSERT data baru
    $query = "INSERT INTO kategori_artikel (nama_kategori, keterangan) VALUES (?, ?)";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "ss", $nama, $keterangan);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode([
            "status" => "sukses", 
            "pesan"  => "Data kategori baru berhasil disimpan"
        ]);
    } else {
        echo json_encode([
            "status" => "gagal", 
            "pesan"  => mysqli_error($koneksi)
        ]);
    }

    mysqli_stmt_close($stmt);
}
mysqli_close($koneksi);
?>
