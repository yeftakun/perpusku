<?php
include("../../koneksi.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Proses penambahan buku
    $id_kategori = $_POST['id_kategori'];
    $judul_buku = $_POST['judul_buku'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $tahun_buku = $_POST['tahun_buku'];
    $jumlah_buku = $_POST['jumlah_buku'];

    // Upload dan simpan gambar sampul
    $sampul_path = "../../assets/sampul/"; // Ubah menjadi dua backslash
    $sampul_file = $sampul_path . basename($_FILES["sampul"]["name"]);

    if (move_uploaded_file($_FILES["sampul"]["tmp_name"], $sampul_file)) {
        echo "File ". htmlspecialchars(basename($_FILES["sampul"]["name"])). " berhasil diupload.";
    } else {
        echo "File upload gagal.";
    }


    // Tanggal masuk otomatis dari current_date
    $tgl_masuk = date("Y-m-d");

    // Insert data ke database
    $queryInsert = "INSERT INTO tbl_buku (id_kategori, sampul, title, pengarang, penerbit, thn_buku, jml, tgl_masuk)
                    VALUES ('$id_kategori', '$sampul_file', '$judul_buku', '$pengarang', '$penerbit', '$tahun_buku', '$jumlah_buku', '$tgl_masuk')";

    if ($conn->query($queryInsert) === TRUE) {
        $last_id = $conn->insert_id; // Ambil ID terakhir yang di-generate (AUTO_INCREMENT)
        header("location:../data_buku.php?new_id=$last_id");
    } else {
        echo "Error: " . $queryInsert . "<br>" . $conn->error;
    }
}

// Ambil data kategori untuk opsi pada form
$queryKategori = "SELECT * FROM tbl_kategori";
$resultKategori = $conn->query($queryKategori);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku</title>
</head>
<body>
    <h1>Tambah Buku</h1>
    
    <form method="post" action="" enctype="multipart/form-data">
        <label>Kategori: 
            <select name="id_kategori">
                <?php
                while ($rowKategori = $resultKategori->fetch_assoc()) {
                    echo "<option value='{$rowKategori['id_kategori']}'>{$rowKategori['nama_kategori']}</option>";
                }
                ?>
            </select>
        </label><br>
        <label>Judul Buku: <input type="text" name="judul_buku" required></label><br>
        <label>Pengarang: <input type="text" name="pengarang" required></label><br>
        <label>Penerbit: <input type="text" name="penerbit" required></label><br>
        <label>Tahun Buku: <input type="text" name="tahun_buku" required></label><br>
        <label>Jumlah Buku: <input type="text" name="jumlah_buku" required></label><br>
        <label>Sampul: <input type="file" name="sampul" required></label><br>
        <input type="submit" value="Submit">
    </form>

    <a href="../data_buku.php">Kembali</a>
</body>
</html>
