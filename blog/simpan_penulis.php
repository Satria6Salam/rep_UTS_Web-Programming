<?php
    header('Content-Type: application/json');
    require_once 'koneksi.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nama_depan    = $_POST['nama_depan'];
        $nama_belakang = $_POST['nama_belakang'];
        $user_name     = $_POST['user_name'];
        $password      = password_hash($_POST['password'], PASSWORD_DEFAULT);
        
        // 1. Logika Foto Default
        $foto_name = 'Default.png'; 
        $target_dir = "uploads_penulis/";

        // 2. Cek apakah ada file yang diupload dan tidak error
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $file_extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            $new_filename = $user_name . "_" . time() . "." . $file_extension;
            $target_file = $target_dir . $new_filename;

            if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
                $foto_name = $new_filename;
            }
        }

        $query = "INSERT INTO penulis (nama_depan, nama_belakang, user_name, password, foto) VALUES (?, ?, ?, ?, ?)";
        $stmt  = mysqli_prepare($koneksi, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssss", $nama_depan, $nama_belakang, $user_name, $password, $foto_name);
            
            if (mysqli_stmt_execute($stmt)) {
                echo json_encode(["status" => "sukses", "pesan" => "Data berhasil disimpan"]);
            } else {
                echo json_encode(["status" => "sukses", "pesan" => "Gagal menyimpan ke database"]);
            }
            mysqli_stmt_close($stmt);
        } else {
            echo json_encode(["status" => "sukses", "pesan" => "Gagal menyiapkan query"]);
        }
    }
    
    mysqli_close($koneksi);
?>
