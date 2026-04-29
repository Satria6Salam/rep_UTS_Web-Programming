<?php
header('Content-Type: application/json');
require_once 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id_kategori'];
    $nama = $_POST['nama_kategori'];
    $keterangan = $_POST['keterangan'];

    if (!empty($id)) {
        $query = "UPDATE kategori_artikel SET nama_kategori = ?, keterangan = ? WHERE id = ?";
        $stmt = mysqli_prepare($koneksi, $query);
        mysqli_stmt_bind_param($stmt, "ssi", $nama, $keterangan, $id);

        if (mysqli_stmt_execute($stmt)) {
            echo json_encode([
                "status" => "sukses", 
                "pesan"  => "Data kategori berhasil diperbarui"
            ]);
        } else {
            echo json_encode([
                "status" => "gagal", 
                "pesan"  => mysqli_error($koneksi)
            ]);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode([
            "status" => "gagal", 
            "pesan"  => "ID kategori tidak ditemukan"
        ]);
    }
}
mysqli_close($koneksi);
?>
