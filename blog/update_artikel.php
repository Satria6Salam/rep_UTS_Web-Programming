<?php
header('Content-Type: application/json');
require_once 'koneksi.php';

// Ambil data dari POST
$id          = $_POST['id_artikel'] ?? '';
$judul       = $_POST['judul'] ?? '';
$isi         = $_POST['isi'] ?? '';
$id_kategori = $_POST['id_kategori'] ?? '';
$id_penulis  = $_POST['id_penulis'] ?? '';

if (empty($id)) {
    echo json_encode(["status" => "error", "pesan" => "ID Artikel tidak ditemukan"]);
    exit;
}

// 1. Ambil nama gambar lama dari database (untuk cadangan atau dihapus)
$query_lama = "SELECT gambar FROM artikel WHERE id = ?";
$stmt_lama = mysqli_prepare($koneksi, $query_lama);
mysqli_stmt_bind_param($stmt_lama, "i", $id);
mysqli_stmt_execute($stmt_lama);
$res_lama = mysqli_stmt_get_result($stmt_lama);
$data_lama = mysqli_fetch_assoc($res_lama);
$gambar_final = $data_lama['gambar'];

// 2. Cek apakah user mengunggah gambar baru
if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === 0) {
    $file_tmp  = $_FILES['gambar']['tmp_name'];
    $file_size = $_FILES['gambar']['size'];

    // Validasi Ukuran (Maks 2MB)
    if ($file_size > 2 * 1024 * 1024) {
        echo json_encode(["status" => "error", "pesan" => "Gambar maksimal 2MB"]);
        exit;
    }

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime  = finfo_file($finfo, $file_tmp);
    finfo_close($finfo);

    $allowed = ['image/jpeg', 'image/png', 'image/webp'];
    if (in_array($mime, $allowed)) {
        $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $nama_baru = uniqid() . "." . $ext;
        $tujuan = "uploads_artikel/" . $nama_baru;

        if (move_uploaded_file($file_tmp, $tujuan)) {
            // Hapus gambar lama jika bukan gambar default
            if ($gambar_final != "default.png" && file_exists("uploads_artikel/" . $gambar_final)) {
                unlink("uploads_artikel/" . $gambar_final);
            }
            $gambar_final = $nama_baru;
        }
    }
}

// 3. Update data ke Database
$query_update = "UPDATE artikel SET judul=?, isi=?, id_kategori=?, id_penulis=?, gambar=? WHERE id=?";
$stmt_upd = mysqli_prepare($koneksi, $query_update);

if ($stmt_upd) {
    mysqli_stmt_bind_param($stmt_upd, "ssiisi", $judul, $isi, $id_kategori, $id_penulis, $gambar_final, $id);
    
    if (mysqli_stmt_execute($stmt_upd)) {
        echo json_encode(["status" => "sukses", "pesan" => "Artikel berhasil diperbarui"]);
    } else {
        echo json_encode(["status" => "error", "pesan" => "Gagal update: " . mysqli_error($koneksi)]);
    }
}

mysqli_close($koneksi);
?>
