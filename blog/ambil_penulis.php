<?php
    header('Content-Type: application/json');
    require_once 'koneksi.php';

    $query = "SELECT id, nama_depan, nama_belakang, user_name, password, foto FROM penulis ORDER BY id DESC";
    $stmt = mysqli_prepare($koneksi, $query);

    if ($stmt) {
        mysqli_stmt_execute($stmt); 
        $hasil = mysqli_stmt_get_result($stmt); 
        $data = []; 
        
        while ($baris = mysqli_fetch_assoc($hasil)) { 
            $data[] = [ 
                'id'            => $baris['id'], 
                'nama_lengkap'  => htmlspecialchars($baris['nama_depan'] . ' ' . $baris['nama_belakang']), 
                'username'      => htmlspecialchars($baris['user_name']), 
                'password'      => $baris['password'], // Data password
                'foto'          => htmlspecialchars($baris['foto']) 
            ]; 
        } 

        echo json_encode($data);
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(["error" => "Gagal query"]);
    }

    mysqli_close($koneksi); 
?>
