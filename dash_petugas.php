<?php
include("koneksi.php");
session_start();
if (!isset($_SESSION['login'])) {
    header('location:login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Welcome to Library - Dashboard</h1>
    <ul>
        <li><a href="page/data_pengguna.php">Data Pengguna</a></li>
        <li><a href="page/data_buku.php">Data Buku</a></li>
        <li><a href="page/kategori.php">Kategori</a></li>
        <li><a href="page/rak.php">Rak</a></li>
        <li><a href="page/peminjaman.php">Peminjaman</a></li>
        <li><a href="page/pengembalian.php">Pengembalian</a></li>
        <li><a href="page/denda.php">Denda</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</body>
</html>
