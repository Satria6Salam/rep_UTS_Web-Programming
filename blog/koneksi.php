<?php
    // --- Pengaturan Database
    $host     = "localhost";      
    $user     = "root";           
    $password = "";               
    $database = "db_blog";        

    // --- Membuat koneksi ke database
    $koneksi = mysqli_connect($host, $user, $password, $database);

    // --- Memeriksa apakah koneksi berhasil
    if (!$koneksi) {
        header('Content-Type: application/json');
        echo json_encode([
                "error" => "Koneksi database gagal: " . mysqli_connect_error()
        ]);
        exit;
    }

    // --- Mengatur charset ke utf8mb4
    mysqli_set_charset($koneksi, "utf8mb4");
?>
