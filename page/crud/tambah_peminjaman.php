<?php
include("../../koneksi.php");
session_start();

if (!isset($_SESSION['login'])) {
    header('location:../login.php');
}

// Ambil data nama peminjam dengan level Anggota
$queryPeminjam = "SELECT id_login, nama FROM tbl_login WHERE level = 'Anggota'";
$resultPeminjam = $conn->query($queryPeminjam);

// Ambil data buku
$queryBuku = "SELECT id_buku, title FROM tbl_buku";
$resultBuku = $conn->query($queryBuku);

// Proses penambahan data peminjaman
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_login = $_POST['id_login'];
    $id_buku = $_POST['id_buku'];
    $status = 'Pinjam'; // Default status saat peminjaman
    $tgl_pinjam = DateTime::createFromFormat('d/m/Y', $_POST['tgl_pinjam'])->format('Y-m-d');
    $lama_pinjam = $_POST['lama_pinjam'];

    // Hitung tanggal balik (deadline)
    $tgl_balik = date('Y-m-d', strtotime($tgl_pinjam . ' + ' . $lama_pinjam . ' days'));

    // Insert data peminjaman ke tabel
    $queryTambahPinjam = "INSERT INTO tbl_pinjam (id_login, id_buku, status, tgl_pinjam, lama_pinjam, tgl_balik) 
                          VALUES ('$id_login', '$id_buku', '$status', '$tgl_pinjam', '$lama_pinjam', '$tgl_balik')";

    if ($conn->query($queryTambahPinjam) === TRUE) {
        header("location:../peminjaman.php?add_success=true");
    } else {
        echo "Error: " . $queryTambahPinjam . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Peminjaman</title>
</head>
<body>
    <h1>Welcome to Library - Tambah Peminjaman</h1>
    <ul>
        <li><a href="../dash_petugas.php">Dashboard</a></li>
        <li><a href="data_pengguna.php">Data Pengguna</a></li>
        <li><a href="data_buku.php">Data Buku</a></li>
        <li><a href="kategori.php">Kategori</a></li>
        <li><a href="peminjaman.php">Peminjaman</a></li>
        <li><a href="pengembalian.php">Pengembalian</a></li>
        <li><a href="denda.php">Denda</a></li>
        <li><a href="../logout.php">Logout</a></li>
    </ul>
    
    <h2>Tambah Peminjaman</h2>
    
    <form method="post" action="">
        <label>Nama Peminjam: 
            <select name="id_login" required>
                <?php
                while ($rowPeminjam = $resultPeminjam->fetch_assoc()) {
                    echo "<option value='{$rowPeminjam['id_login']}'>{$rowPeminjam['nama']}</option>";
                }
                ?>
            </select>
        </label><br>
        <label>Tanggal Peminjaman (dd/mm/yyyy): 
            <input type="text" name="tgl_pinjam" required>
        </label><br>
        <label>Lama Pinjam (hari): 
            <input type="number" name="lama_pinjam" required>
        </label><br>
        <label>Buku: 
            <select name="id_buku" required>
                <?php
                while ($rowBuku = $resultBuku->fetch_assoc()) {
                    echo "<option value='{$rowBuku['id_buku']}'>{$rowBuku['title']}</option>";
                }
                ?>
            </select>
        </label><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
