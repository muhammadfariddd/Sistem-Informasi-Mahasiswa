<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

require "function.php";

if (isset($_POST['submit'])) {
    if (tambahJurusan($_POST) > 0) {
        echo "<script>
            alert('Jurusan berhasil ditambahkan!');
            document.location.href = 'index.php';   
            </script>";
    } else {
        echo "<script>
            alert('Jurusan gagal ditambahkan!');
            document.location.href = 'tambah_jurusan.php';   
            </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Jurusan</title>
    <link rel="stylesheet" href="style/tambah.css">
</head>

<body>
    <div class="container">
        <h1 class="title">Tambah Jurusan</h1>
        <form action="" method="post" class="form">
            <div class="form-group">
                <label for="kode">Kode Jurusan</label>
                <input type="text" name="kode" id="kode" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="nama">Nama Jurusan</label>
                <input type="text" name="nama" id="nama" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="fakultas">Fakultas</label>
                <input type="text" name="fakultas" id="fakultas" class="form-control" required>
            </div>
            <button type="submit" name="submit" class="btn-submit">Tambah Jurusan</button>
        </form>
    </div>
</body>

</html>