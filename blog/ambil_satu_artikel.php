<?php
header('Content-Type: application/json');
require_once 'koneksi.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    echo json_encode(['status' => 'gagal', 'pesan' => 'ID tidak valid']);
    exit;
}

$query = "SELECT id, judul, isi, id_kategori, id_penulis, gambar FROM artikel WHERE id = ?";
$stmt = mysqli_prepare($koneksi, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);

    if ($data) {
        echo json_encode([
            'status' => 'sukses',
            'data'   => [
                'id'            => $data['id'],
                'judul'         => htmlspecialchars($data['judul']),
                'isi'           => htmlspecialchars($data['isi']),
                'id_kategori'   => $data['id_kategori'],
                'id_penulis'    => $data['id_penulis'],
                'gambar'        => htmlspecialchars($data['gambar'])
            ]
        ]);
    } else {
        echo json_encode(['status' => 'gagal', 'pesan' => 'Data tidak ditemukan']);
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($koneksi);
?>
