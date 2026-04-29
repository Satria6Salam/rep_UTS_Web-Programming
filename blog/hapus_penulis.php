<?php
header('Content-Type: application/json');
require_once 'koneksi.php';

// 1. Ambil ID dari POST
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

if ($id <= 0) {
    echo json_encode(['status' => 'gagal', 'pesan' => 'ID tidak valid']);
    exit;
}

// 2. Ambil nama file foto sebelum datanya dihapus dari database
$query_select = "SELECT foto FROM penulis WHERE id = ?";
$stmt_select = mysqli_prepare($koneksi, $query_select);
mysqli_stmt_bind_param($stmt_select, "i", $id);
mysqli_stmt_execute($stmt_select);
$result = mysqli_stmt_get_result($stmt_select);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo json_encode(['status' => 'gagal', 'pesan' => 'Data tidak ditemukan']);
    exit;
}

$nama_file_foto = $data['foto'];

// 3. Proses hapus data dari database
$stmt_delete = mysqli_prepare($koneksi, "DELETE FROM penulis WHERE id = ?");
mysqli_stmt_bind_param($stmt_delete, "i", $id);

if (mysqli_stmt_execute($stmt_delete)) {
    
    // 4. LOGIKA PENGHAPUSAN FILE FISIK
    if ($nama_file_foto != "default.png" && !empty($nama_file_foto)) {
        $path = "uploads_penulis/" . $nama_file_foto;
        
        // Cek apakah file benar-benar ada di folder sebelum dihapus
        if (file_exists($path)) {
            unlink($path); // Menghapus file dari folder
        }
    }

    echo json_encode([
        'status' => 'sukses',
        'pesan'  => 'Data dan file foto berhasil dihapus'
    ]);
} else {
    echo json_encode([
        'status' => 'gagal',
        'pesan'  => 'Gagal menghapus data di database'
    ]);
}

mysqli_stmt_close($stmt_select);
mysqli_stmt_close($stmt_delete);
mysqli_close($koneksi);
?>
