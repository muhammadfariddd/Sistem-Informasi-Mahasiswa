<?php

session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

require "function.php";

$mahasiswa = getAllMahasiswa();

if (isset($_POST["cari"])) {
    $mahasiswa = cari($_POST["keyword"]);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Mahasiswa</title>
    <link rel="stylesheet" href="style/style.css">
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/script.js"></script>
    <script src="https://kit.fontawesome.com/fb46cf958f.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <div class="header-icon">
            <a href="print.php" class="print" target="_blank" aria-label="Cetak"><i class="fa-solid fa-print"></i></a>
            <a href="logout.php" class="logout" aria-label="Logout"><i class="fa-solid fa-right-from-bracket"></i></a>
        </div>
        <h1>Daftar Mahasiswa <i class="fa-solid fa-users"></i></h1>
        <h1 class="highlight">Fakultas Sains dan Teknologi</h1>

        <div class="header">
            <a href="tambah.php" class="btn-add"><i class="fas fa-plus-circle"></i> Tambah Mahasiswa</a>
            <form class="search-form" method="post">
                <span class="loader"></span>
                <input type="text" name="keyword" class="search-input" placeholder="Cari mahasiswa..." autofocus autocomplete="off">
                <button type="submit" class="search-button" name="cari"><i class="fas fa-search"></i> Cari</button>
            </form>
        </div>

        <div id="table-container">
            <table class="table-responsive">
                <tr>
                    <th>No</th>
                    <th>Aksi</th>
                    <th>Foto</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Jurusan</th>
                </tr>

                <?php $i = 1 ?>
                <?php foreach ($mahasiswa as $row) : ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td class="actions">
                            <a href="edit.php?id=<?= $row["_id"] ?>" class="btn-edit">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="hapus.php?id=<?= $row["_id"] ?>" class="btn-delete" onclick="return confirm('Apakah yakin untuk menghapus data ini?')">
                                <i class="fas fa-trash-alt"></i> Hapus
                            </a>
                        </td>
                        <td>
                            <a href="img/<?= $row["foto"] ?>" target="_blank">
                                <img src="img/<?= $row["foto"] ?>" alt="Foto <?= $row["nama"] ?>" width="50" class="img-hover">
                            </a>
                        </td>
                        <td><?= $row["nim"] ?></td>
                        <td><?= $row["nama"] ?></td>
                        <td><?= $row["email"] ?></td>
                        <td><?= $row["jurusan"] ?></td>
                    </tr>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </table>
        </div>

    </div>

</body>

</html>