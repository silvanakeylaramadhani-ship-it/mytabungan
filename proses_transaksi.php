<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("location:login.php");
    exit;
}

$id_user    = $_SESSION['id_user'];
$jenis      = mysqli_real_escape_string($koneksi, $_POST['jenis']);
$nominal    = (int) $_POST['nominal'];
$keterangan = mysqli_real_escape_string($koneksi, $_POST['keterangan']);

if ($nominal <= 0) {
    header("location:dashboard.php?error=nominal");
    exit;
}

$query = "INSERT INTO transaksi (id_user, jenis, nominal, keterangan) VALUES ('$id_user', '$jenis', '$nominal', '$keterangan')";

if (mysqli_query($koneksi, $query)) {
    header("location:dashboard.php?success=1");
    exit;
} else {
    header("location:dashboard.php?error=1");
    exit;
}
?>
