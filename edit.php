<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

require "function.php";

// Mengambil ID mahasiswa dari parameter URL
$id = $_GET["id"];

// Ambil daftar jurusan untuk dropdown
$jurusan = getAllJurusan();
$mhs = queryMahasiswaById($id);

// Cek apakah tombol submit sudah ditekan atau belum
if (isset($_POST['submit'])) {
    // Cek apakah data berhasil diubah atau tidak
    if (ubah($_POST) > 0) {
        echo "<script>
            alert('Data berhasil diubah!');
            document.location.href = 'index.php';   
            </script>";
    } else {
        echo "<script>
            alert('Data gagal diubah!');
            document.location.href = 'edit.php';   
            </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Mahasiswa</title>
    <link rel="stylesheet" href="style/tambah.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <div class="container">
        <h1 class="title"><i class="fas fa-user-edit"></i> Edit Data Mahasiswa</h1>
        <form action="" method="post" class="form" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $mhs["_id"] ?>">
            <input type="hidden" name="fotoLama" value="<?= $mhs["foto"] ?>">
            <div class="form-group">
                <label for="nim"><i class="fas fa-id-card"></i> NIM</label>
                <input type="text" name="nim" id="nim" class="form-control" value="<?= $mhs["nim"] ?>" required>
            </div>
            <div class="form-group">
                <label for="nama"><i class="fas fa-user"></i> Nama</label>
                <input type="text" name="nama" id="nama" class="form-control" value="<?= $mhs["nama"] ?>">
            </div>
            <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i> Email</label>
                <input type="email" name="email" id="email" class="form-control" value="<?= $mhs["email"] ?>">
            </div>
            <div class="form-group">
                <label for="jurusan_id"><i class="fas fa-graduation-cap"></i> Jurusan</label>
                <select name="jurusan_id" id="jurusan_id" class="form-control" required>
                    <option value="">Pilih Jurusan</option>
                    <?php foreach ($jurusan as $j): ?>
                        <option value="<?= $j->_id ?>" <?= ($mhs->jurusan_id == $j->_id) ? 'selected' : '' ?>>
                            <?= $j->nama ?> - <?= $j->fakultas ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="foto"><i class="fas fa-camera"></i> Foto</label>
                <img src="img/<?= $mhs['foto'] ?>" alt="foto-mahasiswa" class="img-preview">
                <input type="file" name="foto" id="foto" class="form-control">
            </div>
            <button type="submit" name="submit" class="btn-submit">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
        </form>
    </div>
</body>

</html>