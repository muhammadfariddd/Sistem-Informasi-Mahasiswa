<?php
require 'vendor/autoload.php';

use MongoDB\Client;
use MongoDB\BSON\ObjectId;
use MongoDB\BSON\Regex;
use MongoDB\BSON\UTCDateTime;

// Koneksi ke database MongoDB
$client = new MongoDB\Client("mongodb://localhost:27017");
$db = $client->phpdasar;

// Fungsi untuk mengambil semua data mahasiswa
function getAllMahasiswa()
{
    global $db;
    $mahasiswaCollection = $db->mahasiswa;

    $pipeline = [
        [
            '$lookup' => [
                'from' => 'jurusan', // Menentukan collection yang akan di-join
                'localField' => 'jurusan_id', //  Field dari collection mahasiswa yang menjadi referensi
                'foreignField' => '_id', // Field dari collection jurusan yang direferensikan
                'as' => 'jurusan_info' // Nama array tempat menyimpan hasil join
            ]
        ],
        [
            '$unwind' => [
                'path' => '$jurusan_info',
                'preserveNullAndEmptyArrays' => true // Menghindari array kosong
            ]
        ],
        [
            '$project' => [
                '_id' => 1,
                'nim' => 1,
                'nama' => 1,
                'email' => 1,
                'foto' => 1,
                'jurusan' => '$jurusan_info.nama' // Mengambil nama jurusan dari hasil join
            ]
        ]
    ];

    return $mahasiswaCollection->aggregate($pipeline)->toArray();
}

/**
 * Fungsi untuk menambah data jurusan
 */
function tambahJurusan($data)
{
    global $db;
    $jurusanCollection = $db->jurusan;

    $document = [
        'kode' => htmlspecialchars($data['kode']),
        'nama' => htmlspecialchars($data['nama']),
        'fakultas' => htmlspecialchars($data['fakultas']),
        'created_at' => new UTCDateTime(),
        'updated_at' => new UTCDateTime()
    ];

    $result = $jurusanCollection->insertOne($document);
    return $result->getInsertedCount();
}

// Fungsi untuk menambah data mahasiswa
function tambah($data)
{
    global $db;
    $mahasiswaCollection = $db->mahasiswa;

    // Upload foto
    $foto = upload();
    if (!$foto) {
        return false;
    }

    $document = [
        'nim' => htmlspecialchars($data['nim']),
        'nama' => htmlspecialchars($data['nama']),
        'email' => htmlspecialchars($data['email']),
        'jurusan_id' => new ObjectId($data['jurusan_id']),
        'foto' => $foto
    ];

    $result = $mahasiswaCollection->insertOne($document);
    return $result->getInsertedCount();
}

// Fungsi untuk mengambil semua jurusan
function getAllJurusan()
{
    global $db;
    return $db->jurusan->find()->toArray();
}


function upload()
{
    $namaFile = $_FILES['foto']['name'];
    $ukuranFile = $_FILES['foto']['size'];
    $error = $_FILES['foto']['error'];
    $tmpName = $_FILES['foto']['tmp_name'];

    if ($error == 4) {
        echo "<script>alert('Pilih gambar terlebih dahulu');</script>";
        return false;
    }

    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>alert('Pilih format gambar yang valid! (jpg, jpeg, png)');</script>";
        return false;
    }

    if ($ukuranFile > 1000000) {
        echo "<script>alert('Ukuran gambar terlalu besar! (Maksimal 1MB)');</script>";
        return false;
    }

    $imageSize = getimagesize($tmpName);
    $width = $imageSize[0];
    $height = $imageSize[1];

    if ($width != $height) {
        echo "<script>alert('Gambar harus berbentuk bujur sangkar!');</script>";
        return false;
    }

    $namaFileBaru = uniqid() . '.' . $ekstensiGambar;
    move_uploaded_file($tmpName, 'img/' . $namaFileBaru);

    return $namaFileBaru;
}

// Fungsi untuk menghapus data mahasiswa berdasarkan id
function hapus($id)
{
    $db = getMongoDB();
    $mahasiswaCollection = $db->mahasiswa; // Koleksi 'mahasiswa'

    // Menghapus dokumen berdasarkan '_id'
    $result = $mahasiswaCollection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);

    return $result->getDeletedCount(); // Mengembalikan jumlah dokumen yang dihapus
}


// Fungsi untuk mengubah data mahasiswa 
function ubah($data)
{
    $db = getMongoDB();
    $mahasiswaCollection = $db->mahasiswa;

    $id = $data["id"];
    $nim = htmlspecialchars($data["nim"]);
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan_id = new ObjectId($data["jurusan_id"]);
    $fotoLama = $data["fotoLama"];

    if ($_FILES['foto']['error'] === 4) {
        $foto = $fotoLama;
    } else {
        $foto = upload();
        if (!$foto) {
            return false;
        }
    }

    $updatedMahasiswa = [
        "nim" => $nim,
        "nama" => $nama,
        "email" => $email,
        "jurusan_id" => $jurusan_id,
        "foto" => $foto
    ];

    $result = $mahasiswaCollection->updateOne(
        ['_id' => new ObjectId($id)],
        ['$set' => $updatedMahasiswa]
    );

    return $result->getModifiedCount();
}

// Fungsi untuk mencari mahasiswa
function cari($keyword)
{
    global $db;
    $mahasiswaCollection = $db->mahasiswa;

    $regex = new Regex($keyword, 'i');

    $pipeline = [
        [
            '$lookup' => [
                'from' => 'jurusan',
                'localField' => 'jurusan_id',
                'foreignField' => '_id',
                'as' => 'jurusan_info'
            ]
        ],
        [
            '$unwind' => [
                'path' => '$jurusan_info',
                'preserveNullAndEmptyArrays' => true
            ]
        ],
        [
            '$match' => [
                '$or' => [
                    ['nim' => $regex],
                    ['nama' => $regex],
                    ['jurusan_info.nama' => $regex]
                ]
            ]
        ],
        [
            '$project' => [
                '_id' => 1,
                'nim' => 1,
                'nama' => 1,
                'email' => 1,
                'foto' => 1,
                'jurusan' => '$jurusan_info.nama'
            ]
        ]
    ];

    return $mahasiswaCollection->aggregate($pipeline)->toArray();
}

function getMongoDB()
{
    try {
        $client = new MongoDB\Client("mongodb://localhost:27017");
        $database = $client->phpdasar; // Nama database
        return $database;
    } catch (Exception $e) {
        echo "Gagal terhubung ke MongoDB: " . $e->getMessage();
        exit;
    }
}

function registrasi($data)
{
    $db = getMongoDB();
    $usersCollection = $db->user;

    $username = strtolower(stripslashes($data['username']));
    $password = $data['password'];
    $confirmPassword = $data['confirm_password'];

    // Cek apakah username sudah ada
    $userExists = $usersCollection->findOne(['username' => $username]);
    if ($userExists) {
        echo "<script>alert('Username sudah terdaftar!');</script>";
        return 0;
    }

    // Cek konfirmasi password
    if ($password !== $confirmPassword) {
        echo "<script>alert('Konfirmasi password salah!');</script>";
        return 0;
    }

    // Enkripsi password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Masukkan user baru ke database MongoDB
    $insertResult = $usersCollection->insertOne([
        'username' => $username,
        'password' => $hashedPassword
    ]);

    return $insertResult->getInsertedCount();
}



// Fungsi untuk mengambil data mahasiswa berdasarkan ID dari MongoDB
function queryMahasiswaById($id)
{
    $db = getMongoDB();
    $mahasiswaCollection = $db->mahasiswa;

    // Mengambil data mahasiswa berdasarkan _id
    $mahasiswa = $mahasiswaCollection->findOne(['_id' => new MongoDB\BSON\ObjectID($id)]);

    return $mahasiswa;
}
