<?php
include("../../koneksi.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Proses update kategori
    $id_kategori = $_POST['id_kategori'];
    $nama_kategori = $_POST['nama_kategori'];

    // Update data buku di database
    $queryUpdate = "UPDATE tbl_kategori 
                    SET nama_kategori='$nama_kategori';
                    WHERE id_kategori='$id_kategori'";

    if ($conn->query($queryUpdate) === TRUE) {
        header("location:../kategori.php?update_success=true");
    } else {
        echo "Error: " . $queryUpdate . "<br>" . $conn->error;
    }
} elseif (isset($_GET['id_kategori'])) {

    // Ambil data buku berdasarkan ID untuk ditampilkan di form edit
    $id_kategori = $_GET['id_kategori'];
    $queryGetBuku = "SELECT * FROM tbl_kategori WHERE id_kategori='$id_kategori'";
    $resultGetBuku = $conn->query($queryGetBuku);

    if ($resultGetBuku->num_rows > 0) {
        $bukuData = $resultGetBuku->fetch_assoc();
    } else {
        echo "Kategori not found";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku</title>
</head>
<body>
    <h1>Edit Buku</h1>
    
    <form method="post" action="" enctype="multipart/form-data">
        <label>Kategori: <input type="text" name="nama_kategori" value="<?php echo $bukuData['nama_kategori']; ?>" required></label><br>
        <input type="submit" value="Submit">
    </form>

    <a href="../kategori.php">Kembali</a>
</body>
</html>
