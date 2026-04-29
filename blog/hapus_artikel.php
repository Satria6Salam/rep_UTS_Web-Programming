<?php
header('Content-Type: application/json');
require_once 'koneksi.php';

// Ambil ID dari parameter POST
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

if ($id <= 0) {
    echo json_encode(['status' => 'error', 'pesan' => 'ID tidak valid']);
    exit;
}

$query_select = "SELECT gambar FROM artikel WHERE id = ?";
$stmt_select = mysqli_prepare($koneksi, $query_select);
mysqli_stmt_bind_param($stmt_select, "i", $id);
mysqli_stmt_execute($stmt_select);
$result = mysqli_stmt_get_result($stmt_select);
$row = mysqli_fetch_assoc($result);

if ($row) {
    $nama_file = $row['gambar'];

    // 2. Hapus data dari database
    $query_delete = "DELETE FROM artikel WHERE id = ?";
    $stmt_delete = mysqli_prepare($koneksi, $query_delete);
    mysqli_stmt_bind_param($stmt_delete, "i", $id);

    if (mysqli_stmt_execute($stmt_delete)) {
        $path = "uploads_artikel/" . $nama_file;
        if ($nama_file != "" && file_exists($path)) {
            unlink($path); 
        }
        
        echo json_encode(['status' => 'sukses', 'pesan' => 'Artikel berhasil dihapus']);
    } else {
        echo json_encode(['status' => 'error', 'pesan' => 'Gagal menghapus data di database']);
    }
    mysqli_stmt_close($stmt_delete);
} else {
    echo json_encode(['status' => 'error', 'pesan' => 'Data tidak ditemukan']);
}

mysqli_stmt_close($stmt_select);
mysqli_close($koneksi);
?>
