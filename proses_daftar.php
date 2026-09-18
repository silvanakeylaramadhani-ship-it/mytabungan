<?php
include 'koneksi.php';

$nama     = mysqli_real_escape_string($koneksi, $_POST['nama']);
$email    = mysqli_real_escape_string($koneksi, $_POST['email']);
$password = $_POST['password'];

// Cek email sudah ada
$cek = mysqli_query($koneksi, "SELECT id FROM users WHERE email='$email'");
if (mysqli_num_rows($cek) > 0) {
    header("location:daftar.php?error=email_exists");
    exit;
}

$query = "INSERT INTO users (nama, email, password) VALUES ('$nama', '$email', '$password')";

if (mysqli_query($koneksi, $query)) {
    header("location:login.php?success=1");
    exit;
} else {
    header("location:daftar.php?error=1");
    exit;
}
?>
