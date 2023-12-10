<?php
include("../koneksi.php");
session_start();

if (!isset($_SESSION['login'])) {
    header('location:../login.php');
}

// Fungsi untuk mencari data berdasarkan filter
function searchBooks($keyword, $conn)
{
    $query = "SELECT b.id_buku, k.nama_kategori, b.sampul, b.title, b.penerbit, b.pengarang, b.thn_buku, b.jml, b.tgl_masuk
              FROM tbl_buku b
              JOIN tbl_kategori k ON b.id_kategori = k.id_kategori
              WHERE b.id_buku LIKE '%$keyword%' OR 
                    k.nama_kategori LIKE '%$keyword%' OR 
                    b.title LIKE '%$keyword%' OR 
                    b.penerbit LIKE '%$keyword%' OR 
                    b.pengarang LIKE '%$keyword%' OR 
                    b.thn_buku LIKE '%$keyword%' OR 
                    b.jml LIKE '%$keyword%' OR 
                    b.tgl_masuk LIKE '%$keyword%'";
    $result = $conn->query($query);
    return $result;
}

// Hapus buku
if (isset($_GET['action']) && $_GET['action'] == 'hapus' && isset($_GET['id'])) {
    $idToDelete = $_GET['id'];

    // Proses penghapusan buku
    $queryDelete = "DELETE FROM tbl_buku WHERE id_buku = $idToDelete";

    if ($conn->query($queryDelete) === TRUE) {
        header("location:data_buku.php?delete_success=true");
    } else {
        echo "Error: " . $queryDelete . "<br>" . $conn->error;
    }
}

// Ambil data buku
if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    $result = searchBooks($keyword, $conn);
} else {
    $query = "SELECT b.id_buku, k.nama_kategori, b.sampul, b.title, b.penerbit, b.pengarang, b.thn_buku, b.jml, b.tgl_masuk
              FROM tbl_buku b
              JOIN tbl_kategori k ON b.id_kategori = k.id_kategori";
    $result = $conn->query($query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Buku</title>
</head>
<body>
    <h1>Welcome to Library - Data Buku</h1>
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
    
    <div>
        <a href="crud/tambah_buku.php">Tambah Buku</a>
    </div>

    <div>
        <form method="get" action="">
            <label>Cari: 
                <input type="text" name="keyword" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>">
                <button type="button" onclick="clearSearch()">✖</button>
            </label>
            <input type="submit" value="Cari">
        </form>

        <script>
            function clearSearch() {
                document.querySelector('input[name="keyword"]').value = '';
            }
        </script>
    </div>

    <table border="1">
        <thead>
            <tr>
                <th>ID Buku</th>
                <th>Kategori</th>
                <th>Sampul</th>
                <th>Title</th>
                <th>Penerbit</th>
                <th>Pengarang</th>
                <th>Tahun Buku</th>
                <th>Jumlah</th>
                <th>Tanggal Masuk</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>B{$row['id_buku']}</td>";
                echo "<td>{$row['nama_kategori']}</td>";
                $pathWithSingleSlash = $row['sampul'];
                $pathWithDoubleSlash = str_replace("/", "//", $pathWithSingleSlash);
                echo "<td><img src='{$pathWithDoubleSlash}' alt='Sampul Buku' style='max-width: 100px; max-height: 100px;'></td>";
                echo "<td>{$row['title']}</td>";
                echo "<td>{$row['penerbit']}</td>";
                echo "<td>{$row['pengarang']}</td>";
                echo "<td>{$row['thn_buku']}</td>";
                echo "<td>{$row['jml']}</td>";
                echo "<td>{$row['tgl_masuk']}</td>";
                echo "<td>
                    <a href='./crud/edit_buku.php?id={$row['id_buku']}'>Edit</a>
                    <a href='?action=hapus&id={$row['id_buku']}'>Hapus</a>
                </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <script>
        function showForm() {
            var formTambahBuku = document.getElementById('formTambahBuku');
            formTambahBuku.style.display = 'block';
        }

        function editBuku(bukuId) {
            // Proses pengeditan buku
            // ...
            // Redirect atau tampilkan form edit buku
        }
    </script>
</body>
</html>
