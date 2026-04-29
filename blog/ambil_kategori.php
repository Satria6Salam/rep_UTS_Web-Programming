<?php
header('Content-Type: application/json');
require_once 'koneksi.php';

// Query 
$query = "SELECT id, nama_kategori, keterangan FROM kategori_artikel ORDER BY nama_kategori ASC";
$stmt = mysqli_prepare($koneksi, $query);

if ($stmt) {
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = [
            'id'            => $row['id'],
            'nama_kategori' => htmlspecialchars($row['nama_kategori']),
            'keterangan'    => htmlspecialchars($row['keterangan'])
        ];
    }

    echo json_encode($data);
    mysqli_stmt_close($stmt);
} else {
    echo json_encode(["error" => "Gagal mengambil data kategori"]);
}

mysqli_close($koneksi);
?>
