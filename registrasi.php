<?php
require "function.php";

if (isset($_POST["register"])) {
    if (registrasi($_POST) > 0) {
        echo "<script>
        alert('User berhasil ditambahkan!');
        document.location.href = 'login.php';
        </script>";
    } else {
        echo "Gagal menambahkan user!";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Registrasi</title>
    <link rel="stylesheet" href="style/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>

<body>
    <form action="" method="post" class="login-form">
        <h1>Registration</h1>
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
            <li class="input-box">
                <input type="password" name="confirm_password" id="confirm_password" required>
                <label for="confirm_password">Confirm Password</label>
                <i class="fas fa-lock"></i>
            </li>
            <li>
                <button type="submit" name="register">Sign Up</button>
            </li>
            <p>Already have an account? <a href="login.php">Login</a></p>
        </ul>
    </form>
</body>

</html>