<?php
include("../../koneksi.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Proses penambahan buku
    $id_kategori = $_POST['id_kategori'];
    $nama_kategori = $_POST['nama_kategori'];

    // Insert data ke database
    $queryInsert = "INSERT INTO tbl_kategori (id_kategori, nama_kategori)
                    VALUES ('$id_kategori', '$nama_kategori')";

    if ($conn->query($queryInsert) === TRUE) {
        $last_id = $conn->insert_id; // Ambil ID terakhir yang di-generate (AUTO_INCREMENT)
        header("location:../kategori.php?new_id=$last_id");
    } else {
        echo "Error: " . $queryInsert . "<br>" . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kategori</title>
</head>
<body>
    <h1>Tambah Kategori</h1>
    
    <form method="post" action="" enctype="multipart/form-data">
        <label>Nama Kategori: <input type="text" name="nama_kategori" required></label><br>
        <input type="submit" value="Submit">
    </form>

    <a href="../kategori.php">Kembali</a>
</body>
</html>
