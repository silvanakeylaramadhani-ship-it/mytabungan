<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

$email    = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

if (empty($email) || empty($password)) {
    header("Location: login.php?error=1");
    exit;
}

$email = mysqli_real_escape_string($koneksi, $email);
$query = mysqli_query($koneksi, "SELECT * FROM users WHERE email='$email' LIMIT 1");

if (!$query) {
    header("Location: login.php?error=db");
    exit;
}

if (mysqli_num_rows($query) > 0) {
    $data  = mysqli_fetch_assoc($query);
    $valid = ($data['password'] === $password);

    if ($valid) {
        $_SESSION['id_user'] = $data['id'];
        $_SESSION['nama']    = $data['nama'];
        $_SESSION['email']   = $data['email'];
        $_SESSION['status']  = "login";
        header("Location: dashboard.php");
        exit;
    }
}

header("Location: login.php?error=1");
exit;