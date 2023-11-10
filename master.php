<?php

include "koneksi.php";

// Menentukan metode request
$method = $_SERVER['REQUEST_METHOD'];

header('Content-Type: application/json');

switch($method) {
    case 'GET':
        $sql = "SELECT * FROM objek_wisata";
        $stmt = $pdo->query($sql);
        $objek_wisata = $stmt->fetchAll();
        echo json_encode($objek_wisata);
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        if(isset($data->nama_objek) && isset($data->alamat) && isset($data->fasilitas) && isset($data->harga_tiket) && isset($data->status) && isset($data->jam_buka) && isset($data->jam_tutup)) {
            $sql = "INSERT INTO objek_wisata (nama_objek, alamat, fasilitas, harga_tiket, status, jam_buka, jam_tutup) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$data->nama_objek, $data->alamat, $data->fasilitas, $data->harga_tiket, $data->status, $data->jam_buka, $data->jam_tutup]);
            echo json_encode(['message' => 'Objek Wisata berhasil ditambahkan']);
        } else {
            echo json_encode(['message' => 'Data tidak lengkap']);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));
        if(isset($data->nama_objek) && isset($data->alamat) && isset($data->fasilitas) && isset($data->harga_tiket) && isset($data->status) && isset($data->jam_buka) && isset($data->jam_tutup)) {
            $sql = "UPDATE objek_wisata SET nama_objek=?, alamat=?, fasilitas=?, harga_tiket=?, status=?, jam_buka=?, jam_tutup=? WHERE id_objek=?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$data->nama_objek, $data->alamat, $data->fasilitas, $data->harga_tiket, $data->status, $data->jam_buka, $data->jam_tutup, $data->id_objek]);
            echo json_encode(['message' => 'Objek Wisata berhasil diperbarui']);
        } else {
            echo json_encode(['message' => 'Data tidak lengkap']);
        }
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));
        if(isset($data->id_objek)) {
            $sql = "DELETE FROM objek_wisata WHERE id_objek=?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$data->id_objek]);
            echo json_encode(['message' => 'Objek Wisata berhasil dihapus']);
        } else {
            echo json_encode(['message' => 'ID tidak ditemukan']);
        }
        break;

    default:
        echo json_encode(['message' => 'Metode tidak dikenali']);
        break;
}

?>
