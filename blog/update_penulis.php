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

// Ambil data POST
$id            = isset($_POST['id_penulis']) ? intval($_POST['id_penulis']) : 0;
$nama_depan    = $_POST['nama_depan'] ?? '';
$nama_belakang = $_POST['nama_belakang'] ?? '';
$user_name     = $_POST['user_name'] ?? '';
$password      = $_POST['password'] ?? '';

// Validasi
if ($id <= 0) {
    echo json_encode([
        'status' => 'gagal',
        'pesan'  => 'ID tidak valid'
    ]);
    exit;
}

if (empty($nama_depan) || empty($nama_belakang) || empty($user_name)) {
    echo json_encode([
        'status' => 'gagal',
        'pesan'  => 'Data tidak lengkap'
    ]);
    exit;
}

// ===============================
// 1. Update data utama
// ===============================
$query = "UPDATE penulis SET nama_depan = ?, nama_belakang = ?, user_name = ? WHERE id = ?";
$stmt = mysqli_prepare($koneksi, $query);

if (!$stmt) {
    echo json_encode([
        'status' => 'gagal',
        'pesan'  => 'Prepare gagal: ' . mysqli_error($koneksi)
    ]);
    exit;
}

mysqli_stmt_bind_param($stmt, "sssi", $nama_depan, $nama_belakang, $user_name, $id);

if (!mysqli_stmt_execute($stmt)) {
    echo json_encode([
        'status' => 'gagal',
        'pesan'  => 'Gagal update data: ' . mysqli_error($koneksi)
    ]);
    exit;
}

// ===============================
// 2. Update password (opsional)
// ===============================
if (!empty($password)) {
    $pass_hashed = password_hash($password, PASSWORD_DEFAULT);

    $stmt_pass = mysqli_prepare($koneksi, "UPDATE penulis SET password = ? WHERE id = ?");

    if ($stmt_pass) {
        mysqli_stmt_bind_param($stmt_pass, "si", $pass_hashed, $id);
        mysqli_stmt_execute($stmt_pass);
        mysqli_stmt_close($stmt_pass);
    }
}

// ===============================
// 3. Upload foto (opsional)
// ===============================
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {

    // Pastikan folder ada
    if (!is_dir('uploads_penulis')) {
        mkdir('uploads_penulis', 0777, true);
    }

    $nama_file = $_FILES['foto']['name'];
    $tmp_name  = $_FILES['foto']['tmp_name'];
    $ekstensi  = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));

    $allowed = ['jpg', 'jpeg', 'png'];

    if (!in_array($ekstensi, $allowed)) {
        echo json_encode([
            'status' => 'gagal',
            'pesan'  => 'Format file harus JPG, JPEG, atau PNG'
        ]);
        exit;
    }

    $nama_baru = "foto_" . $id . "_" . time() . "." . $ekstensi;
    $tujuan    = 'uploads_penulis/' . $nama_baru;

    if (move_uploaded_file($tmp_name, $tujuan)) {
        $stmt_foto = mysqli_prepare($koneksi, "UPDATE penulis SET foto = ? WHERE id = ?");

        if ($stmt_foto) {
            mysqli_stmt_bind_param($stmt_foto, "si", $nama_baru, $id);
            mysqli_stmt_execute($stmt_foto);
            mysqli_stmt_close($stmt_foto);
        }
    } else {
        echo json_encode([
            'status' => 'gagal',
            'pesan'  => 'Gagal upload file'
        ]);
        exit;
    }
}

// Tutup koneksi
mysqli_stmt_close($stmt);
mysqli_close($koneksi);

// Response sukses
echo json_encode([
    'status' => 'sukses',
    'pesan'  => 'Data penulis berhasil diperbarui'
]);
?>
