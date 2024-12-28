<?php
session_start();
require_once  'vendor/autoload.php';

use MongoDB\BSON\ObjectId;
use MongoDB\Client;

// Koneksi ke MongoDB
$client = new MongoDB\Client("mongodb://localhost:27017");
$database = $client->phpdasar;
$usersCollection = $database->user;
if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {

    $id = new MongoDB\BSON\ObjectId($_COOKIE['id']); // Menggunakan MonggoDB ObjectId
    $key = $_COOKIE['key'];

    // ambil username berdasarkan id 
    $user = $usersCollection->findOne(['_id' => $id]);

    // cek cookie dan username 
    if ($user && $key === hash('sha256', $user['username'])) {
        $_SESSION['login'] = true;
    }
}

// cek session login
if (isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek user berdasarkan username
    $user = $usersCollection->findOne(['username' => $username]);

    // cek username 
    if ($user) {
        // cek password
        if (password_verify($password, $user['password'])) {
            // set session 
            $_SESSION["login"] = true;

            // cek remember me 
            if (isset($_POST['remember'])) {
                // buat cookie 
                setcookie('id', $user['_id'], time() + 60);
                setcookie('key', hash('sha256', $user['username']), time() + 60);
            }

            header("Location: index.php");
            exit;
        }
    }

    $error = true;
    if (isset($error)) {
        echo "<script>
        alert('Username / password salah!')
        </script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
    <link rel="stylesheet" href="style/login.css">
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>

<body>
    <form action="" method="post" class="login-form">
        <h1>Login</h1>
        <ul>
            <li class="input-box">
                <input type="text" name="username" id="username" required>
                <label for="username">Username</label>
                <i class="fas fa-user"></i>
            </li>
            <li class="input-box">
                <input type="password" name="password" id="password" required>
                <label for="password">Password</label>
                <i class="fas fa-lock"></i>
            </li>
            <li class="remember">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Remember me</label>
            </li>
            <li><button type="submit" name="login">Sign In</button></li>
            <p>Don't have an account? <a href="registrasi.php">Register</a></p>
        </ul>
    </form>
</body>

</html>