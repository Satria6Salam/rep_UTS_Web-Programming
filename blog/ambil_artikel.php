<?php
header('Content-Type: application/json');
require_once 'koneksi.php';

$query = "SELECT 
            a.id, 
            a.judul, 
            a.isi, 
            a.gambar, 
            a.hari_tanggal, 
            k.nama_kategori, 
            p.nama_depan, 
            p.nama_belakang, 
            p.user_name,
            CONCAT(
                COALESCE(p.nama_depan, ''), 
                ' ', 
                COALESCE(p.nama_belakang, '')
            ) AS nama_lengkap_db
          FROM artikel a
          LEFT JOIN kategori_artikel k ON a.id_kategori = k.id
          LEFT JOIN penulis p ON a.id_penulis = p.id
          ORDER BY a.id DESC"; 

$stmt = mysqli_prepare($koneksi, $query);

if ($stmt) {
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $nama_penulis = trim($row['nama_lengkap_db']);
        if (empty($nama_penulis)) {
            $nama_penulis = $row['user_name'] ?? 'Anonim';
        }

        $data[] = [
            'id'             => $row['id'],
            'judul'          => htmlspecialchars($row['judul']),
            'isi'            => htmlspecialchars($row['isi']),
            'nama_kategori'  => htmlspecialchars($row['nama_kategori'] ?? 'Tanpa Kategori'),
            
        
            'nama_lengkap'   => htmlspecialchars($nama_penulis),
            
            'hari_tanggal'   => $row['hari_tanggal'],
            'gambar'         => $row['gambar'] 
        ];
    }

    echo json_encode($data);
    mysqli_stmt_close($stmt);
} else {
    echo json_encode(["error" => "Gagal mengambil data artikel: " . mysqli_error($koneksi)]);
}

mysqli_close($koneksi);
?>
