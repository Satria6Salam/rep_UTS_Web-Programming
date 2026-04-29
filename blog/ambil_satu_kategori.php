<?php
header('Content-Type: application/json');
require_once 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT * FROM kategori_artikel WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        $data = mysqli_fetch_assoc($result);

        if ($data) {
            // Sanitasi output sebelum dikirim ke client
            echo json_encode([
                "status" => "sukses",
                "data"   => [
                    "id"            => $data['id'],
                    "nama_kategori" => htmlspecialchars($data['nama_kategori']),
                    "keterangan"    => htmlspecialchars($data['keterangan'])
                ]
            ]);
        } else {
            echo json_encode(["status" => "gagal", "pesan" => "Data tidak ditemukan"]);
        }
    } else {
        echo json_encode(["status" => "gagal", "pesan" => mysqli_error($koneksi)]);
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($koneksi);
?>
