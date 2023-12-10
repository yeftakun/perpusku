<?php
include("../../koneksi.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Proses update buku
    $id = $_POST['id']; // ID buku yang akan diupdate
    $id_kategori = $_POST['id_kategori'];
    $title = $_POST['title'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $thn_buku = $_POST['thn_buku'];
    $jml = $_POST['jml'];

    // Proses update sampul jika ada file yang diunggah
    if ($_FILES['sampul']['size'] > 0) {
        $uploadDir = "../../assets/sampul/";
        $sampulName = $_FILES['sampul']['name'];
        $sampulTemp = $_FILES['sampul']['tmp_name'];
        $sampulPath = $uploadDir . $sampulName;

        move_uploaded_file($sampulTemp, $sampulPath);

        // Update path sampul di database
        $queryUpdateSampul = "UPDATE tbl_buku SET sampul='$sampulPath' WHERE id_buku='$id'";
        $conn->query($queryUpdateSampul);
    }

    // Update data buku di database
    $queryUpdate = "UPDATE tbl_buku 
                    SET id_kategori='$id_kategori', title='$title', pengarang='$pengarang', 
                        penerbit='$penerbit', thn_buku='$thn_buku', jml='$jml' 
                    WHERE id_buku='$id'";

    if ($conn->query($queryUpdate) === TRUE) {
        header("location:../data_buku.php?update_success=true");
    } else {
        echo "Error: " . $queryUpdate . "<br>" . $conn->error;
    }
} elseif (isset($_GET['id'])) {
    // Ambil data buku berdasarkan ID untuk ditampilkan di form edit
    $id = $_GET['id'];
    $queryGetBuku = "SELECT * FROM tbl_buku WHERE id_buku='$id'";
    $resultGetBuku = $conn->query($queryGetBuku);

    if ($resultGetBuku->num_rows > 0) {
        $bukuData = $resultGetBuku->fetch_assoc();
    } else {
        echo "Buku not found";
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
        <input type="hidden" name="id" value="<?php echo $bukuData['id_buku']; ?>">
        <label>Kategori: 
            <select name="id_kategori">
                <?php
                // Ambil daftar kategori
                $queryKategori = "SELECT * FROM tbl_kategori";
                $resultKategori = $conn->query($queryKategori);

                while ($kategori = $resultKategori->fetch_assoc()) {
                    $selected = ($kategori['id_kategori'] == $bukuData['id_kategori']) ? 'selected' : '';
                    echo "<option value='{$kategori['id_kategori']}' $selected>{$kategori['nama_kategori']}</option>";
                }
                ?>
            </select>
        </label><br>
        <label>Judul Buku: <input type="text" name="title" value="<?php echo $bukuData['title']; ?>" required></label><br>
        <label>Pengarang: <input type="text" name="pengarang" value="<?php echo $bukuData['pengarang']; ?>" required></label><br>
        <label>Penerbit: <input type="text" name="penerbit" value="<?php echo $bukuData['penerbit']; ?>" required></label><br>
        <label>Tahun Buku: <input type="text" name="thn_buku" value="<?php echo $bukuData['thn_buku']; ?>" required></label><br>
        <label>Jumlah Buku: <input type="text" name="jml" value="<?php echo $bukuData['jml']; ?>" required></label><br>
        <label>Sampul: 
            <?php
            // $pathWithDoubleSlash = $bukuData['sampul'];
            // $pathWithSingleSlash = str_replace("//", "/", $pathWithDoubleSlash);
            if (!empty($bukuData['sampul'])) {
                echo "<br><img src='{$bukuData['sampul']}' alt='Sampul Buku' style='max-width: 200px;'><br>";
            }
            ?>
            <input type="file" name="sampul">
        </label><br>
        <input type="submit" value="Submit">
    </form>

    <a href="../data_buku.php">Kembali</a>
</body>
</html>
