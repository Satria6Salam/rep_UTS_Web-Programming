<?php
header('Content-Type: application/json');
require_once 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    // 1. VALIDASI: Cek apakah kategori masih digunakan di tabel artikel
    $checkQuery = "SELECT COUNT(*) as total FROM artikel WHERE id_kategori = ?";
    $stmtCheck = mysqli_prepare($koneksi, $checkQuery);
    mysqli_stmt_bind_param($stmtCheck, "i", $id);
    mysqli_stmt_execute($stmtCheck);
    $resCheck = mysqli_stmt_get_result($stmtCheck);
    $rowCheck = mysqli_fetch_assoc($resCheck);

    if ($rowCheck['total'] > 0) {
        echo json_encode([
            "status" => "gagal",
            "pesan"  => "Kategori tidak dapat dihapus karena masih memiliki artikel terkait."
        ]);
    } else {
        // 2. Jika aman, lakukan penghapusan (Prepared Statement)
        $query = "DELETE FROM kategori_artikel WHERE id = ?";
        $stmt = mysqli_prepare($koneksi, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);

        if (mysqli_stmt_execute($stmt)) {
            echo json_encode([
                "status" => "sukses",
                "pesan"  => "Kategori berhasil dihapus."
            ]);
        } else {
            echo json_encode([
                "status" => "gagal",
                "pesan"  => "Error database: " . mysqli_error($koneksi)
            ]);
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_stmt_close($stmtCheck);
}
mysqli_close($koneksi);
?>
