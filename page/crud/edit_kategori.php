<?php
include("../../koneksi.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Proses update kategori
    $id = $_POST['id']; // ID kategori yang akan diupdate
    $nama_kategori = $_POST['nama_kategori'];

    // Update data di database
    $queryUpdate = "UPDATE tbl_kategori 
                    SET nama_kategori='$nama_kategori'
                    WHERE id_kategori='$id'";

    if ($conn->query($queryUpdate) === TRUE) {
        header("location:../kategori.php?update_success=true");
    } else {
        echo "Error: " . $queryUpdate . "<br>" . $conn->error;
    }
} elseif (isset($_GET['id'])) {
    // Ambil data kategori berdasarkan ID untuk ditampilkan di form edit
    $id = $_GET['id'];
    $queryGetKategori = "SELECT * FROM tbl_kategori WHERE id_kategori='$id'";
    $resultGetKategori = $conn->query($queryGetKategori);

    if ($resultGetKategori->num_rows > 0) {
        $kategoriData = $resultGetKategori->fetch_assoc();
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
    <title>Edit Kategori</title>
</head>
<body>
    <h1>Edit Kategori</h1>
    
    <form method="post" action="">
        <input type="hidden" name="id" value="<?php echo $kategoriData['id_kategori']; ?>">
        <label>Nama Kategori: <input type="text" name="nama_kategori" value="<?php echo $kategoriData['nama_kategori']; ?>" required></label><br>
        <input type="submit" value="Submit">
    </form>

    <a href="../kategori.php">Kembali</a>
</body>
</html>
