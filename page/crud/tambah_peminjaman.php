<?php
include("../../koneksi.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Proses penambahan peminjaman
    $id_login = $_POST['id_login'];
    $id_buku = $_POST['id_buku'];
    $tgl_pinjam = DateTime::createFromFormat('d/m/Y', $_POST['tgl_pinjam'])->format('Y-m-d');
    $lama_pinjam = $_POST['lama_pinjam'];

    // Tanggal balik dihitung dari tanggal pinjam + lama pinjam
    $tgl_balik = date('Y-m-d', strtotime($tgl_pinjam . ' + ' . $lama_pinjam . ' days'));

    // Insert data ke database
    $queryInsert = "INSERT INTO tbl_pinjam (id_login, id_buku, status, tgl_pinjam, lama_pinjam, tgl_balik)
                    VALUES ('$id_login', '$id_buku', 'Dipinjam', '$tgl_pinjam', '$lama_pinjam', '$tgl_balik')";

    if ($conn->query($queryInsert) === TRUE) {
        header("location:../peminjaman.php?new_pinjam=true");
    } else {
        echo "Error: " . $queryInsert . "<br>" . $conn->error;
    }
}

// Ambil data pengguna dan buku untuk opsi pada form
$queryPengguna = "SELECT id_login, nama FROM tbl_login";
$resultPengguna = $conn->query($queryPengguna);

$queryBuku = "SELECT id_buku, title FROM tbl_buku";
$resultBuku = $conn->query($queryBuku);
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
    <h1>Tambah Peminjaman</h1>
    
    <form method="post" action="">
        <label>Nama Peminjam: 
            <select name="id_login">
                <?php
                while ($rowPengguna = $resultPengguna->fetch_assoc()) {
                    echo "<option value='{$rowPengguna['id_login']}'>{$rowPengguna['nama']}</option>";
                }
                ?>
            </select>
        </label><br>
        <label>Tanggal Peminjaman (dd/mm/yyyy): 
            <input type="text" name="tgl_pinjam" required>
        </label><br>
        <label>Lama Peminjaman (hari): 
            <input type="number" name="lama_pinjam" required>
        </label><br>
        <label>Nama Buku: 
            <select name="id_buku">
                <?php
                while ($rowBuku = $resultBuku->fetch_assoc()) {
                    echo "<option value='{$rowBuku['id_buku']}'>{$rowBuku['title']}</option>";
                }
                ?>
            </select>
        </label><br>
        <input type="submit" value="Submit">
    </form>

    <a href="../peminjaman.php">Kembali</a>
</body>
</html>
