<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id_user'])) {
    header("location:login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

mysqli_query($koneksi, "DELETE FROM transaksi WHERE id_user='$id_user'");
$hapus_user = mysqli_query($koneksi, "DELETE FROM users WHERE id='$id_user'");

if ($hapus_user) {
    session_destroy();
    header("location:daftar.php?deleted=1");
} else {
    header("location:dashboard.php?error=hapus_akun");
}
exit;
?>
