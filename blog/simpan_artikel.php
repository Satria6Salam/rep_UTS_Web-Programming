<?php
header('Content-Type: application/json');
require_once 'koneksi.php';

// 1. SET TIMEZONE DAN FORMAT HARI/TANGGAL OTOMATIS
date_default_timezone_set('Asia/Jakarta');
$hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
$bulan = [
    1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
    4 => 'April',   5 => 'Mei',      6 => 'Juni',
    7 => 'Juli',    8 => 'Agustus',  9 => 'September',
    10 => 'Oktober', 11 => 'November', 12 => 'Desember'
];

$sekarang    = new DateTime();
$nama_hari   = $hari[$sekarang->format('w')];
$tanggal     = $sekarang->format('j');
$nama_bulan  = $bulan[(int)$sekarang->format('n')];
$tahun       = $sekarang->format('Y');
$jam         = $sekarang->format('H:i');
$hari_tanggal = "$nama_hari, $tanggal $nama_bulan $tahun | $jam";

// 2. TANGKAP DATA DARI FORM
$judul       = $_POST['judul'] ?? '';
$isi         = $_POST['isi'] ?? '';
$id_kategori = $_POST['id_kategori'] ?? '';
$id_penulis  = $_POST['id_penulis'] ?? '';
$gambar_nama = "";

// 3. PROSES UPLOAD GAMBAR (VALIDASI KETAT)
if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === 0) {
    $file_tmp  = $_FILES['gambar']['tmp_name'];
    $file_size = $_FILES['gambar']['size'];
    
    // Validasi Ukuran (Maks 2MB)
    if ($file_size > 2 * 1024 * 1024) {
        echo json_encode(["status" => "error", "pesan" => "Ukuran file maksimal 2 MB"]);
        exit;
    }

    // Validasi Tipe File menggunakan FINFO (Bukan $_FILES['type'])
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime  = finfo_file($finfo, $file_tmp);
    finfo_close($finfo);

    $allowed_types = ['image/jpeg', 'image/png', 'image/webp'];
    if (!in_array($mime, $allowed_types)) {
        echo json_encode(["status" => "error", "pesan" => "Tipe file harus JPG, PNG, atau WEBP"]);
        exit;
    }

    // Buat Nama File Unik
    $ekstensi    = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
    $gambar_nama = uniqid() . "." . $ekstensi;
    $tujuan      = "uploads_artikel/" . $gambar_nama;

    if (!move_uploaded_file($file_tmp, $tujuan)) {
        echo json_encode(["status" => "error", "pesan" => "Gagal mengunggah gambar"]);
        exit;
    }
} else {
    // Jika tidak ada gambar, gunakan default atau beri pesan error jika wajib
    $gambar_nama = "default_artikel.png"; 
}

// 4. SIMPAN KE DATABASE DENGAN PREPARED STATEMENTS
$query = "INSERT INTO artikel (judul, isi, id_kategori, id_penulis, gambar, hari_tanggal) VALUES (?, ?, ?, ?, ?, ?)";
$stmt  = mysqli_prepare($koneksi, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "ssiiss", $judul, $isi, $id_kategori, $id_penulis, $gambar_nama, $hari_tanggal);
    
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(["status" => "sukses", "pesan" => "Artikel berhasil disimpan"]);
    } else {
        echo json_encode(["status" => "error", "pesan" => "Gagal menyimpan ke database: " . mysqli_stmt_error($stmt)]);
    }
    mysqli_stmt_close($stmt);
} else {
    echo json_encode(["status" => "error", "pesan" => "Gagal menyiapkan statement"]);
}

mysqli_close($koneksi);
?>
