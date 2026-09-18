<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("location:login.php");
    exit;
}

$id      = (int) $_GET['id'];
$id_user = $_SESSION['id_user'];

// Pastikan hanya hapus transaksi milik user sendiri
$query = mysqli_query($koneksi, "DELETE FROM transaksi WHERE id='$id' AND id_user='$id_user'");

if ($query) {
    header("location:dashboard.php?deleted=1");
} else {
    header("location:dashboard.php?error=1");
}
exit;
?>
