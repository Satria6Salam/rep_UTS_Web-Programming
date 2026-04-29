<?php
header('Content-Type: application/json');
require_once 'koneksi.php';

// Cek koneksi
if (!$koneksi) {
    echo json_encode([
        'status' => 'gagal',
        'pesan'  => 'Koneksi database gagal'
    ]);
    exit;
}

// Ambil ID
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    echo json_encode([
        'status' => 'gagal',
        'pesan'  => 'ID tidak valid'
    ]);
    exit;
}

// Gunakan alias agar user_name -> username
$query = "SELECT id, nama_depan, nama_belakang, user_name AS username, foto 
          FROM penulis WHERE id = ?";

$stmt = mysqli_prepare($koneksi, $query);

if (!$stmt) {
    echo json_encode([
        'status' => 'gagal',
        'pesan'  => 'Prepare gagal: ' . mysqli_error($koneksi)
    ]);
    exit;
}

// Bind
mysqli_stmt_bind_param($stmt, "i", $id);

// Execute
if (!mysqli_stmt_execute($stmt)) {
    echo json_encode([
        'status' => 'gagal',
        'pesan'  => 'Execute gagal: ' . mysqli_error($koneksi)
    ]);
    exit;
}

// Ambil hasil
$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    echo json_encode([
        'status' => 'gagal',
        'pesan'  => 'Gagal mengambil hasil query'
    ]);
    exit;
}

$data = mysqli_fetch_assoc($result);

// Output
if ($data) {
    echo json_encode([
        'status' => 'sukses',
        'data'   => [
            'id'            => $data['id'],
            'nama_depan'    => htmlspecialchars($data['nama_depan']),
            'nama_belakang' => htmlspecialchars($data['nama_belakang']),
            'username'      => htmlspecialchars($data['username']), 
            'foto'          => htmlspecialchars($data['foto'])
        ]
    ]);
} else {
    echo json_encode([
        'status' => 'gagal',
        'pesan'  => 'Data tidak ditemukan'
    ]);
}

// Tutup
mysqli_stmt_close($stmt);
mysqli_close($koneksi);
?>
