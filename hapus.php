<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

require "function.php";

$id = $_GET["id"]; // Ambil ID dari URL

// Menghapus data dari MongoDB menggunakan function 'hapus'
if (hapus($id) > 0) {
    echo "<script>
        alert('Data berhasil dihapus!');
        document.location.href = 'index.php';   
        </script>";
} else {
    echo "<script>
        alert('Data gagal dihapus!');
        document.location.href = 'index.php';   
        </script>";
}
