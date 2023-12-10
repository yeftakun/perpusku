<?php
include("../koneksi.php");
session_start();

if (!isset($_SESSION['login'])) {
    header('location:../login.php');
}

// Fungsi untuk mencari data berdasarkan filter
function searchPinjaman($keyword, $conn)
{
    $query = "SELECT p.id_pinjam, l.nama, b.title, b.sampul, p.status, p.tgl_pinjam, p.lama_pinjam, p.tgl_balik, p.tgl_kembali
              FROM tbl_pinjam p
              JOIN tbl_login l ON p.id_login = l.id_login
              JOIN tbl_buku b ON p.id_buku = b.id_buku
              WHERE p.id_pinjam LIKE '%$keyword%' OR 
                    l.nama LIKE '%$keyword%' OR 
                    b.title LIKE '%$keyword%' OR 
                    p.status LIKE '%$keyword%' OR 
                    p.tgl_pinjam LIKE '%$keyword%' OR 
                    p.lama_pinjam LIKE '%$keyword%' OR 
                    p.tgl_balik LIKE '%$keyword%' OR 
                    p.tgl_kembali LIKE '%$keyword%'";
    $result = $conn->query($query);
    return $result;
}

// Hapus peminjaman
if (isset($_GET['action']) && $_GET['action'] == 'hapus' && isset($_GET['id'])) {
    $idToDelete = $_GET['id'];

    // Proses penghapusan peminjaman
    $queryDelete = "DELETE FROM tbl_pinjam WHERE id_pinjam = $idToDelete";

    if ($conn->query($queryDelete) === TRUE) {
        header("location:peminjaman.php?delete_pinjam=true");
    } else {
        echo "Error: " . $queryDelete . "<br>" . $conn->error;
    }
}

// Ambil data peminjaman
if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    $result = searchPinjaman($keyword, $conn);
} else {
    $query = "SELECT p.id_pinjam, l.nama, b.title, b.sampul, p.status, p.tgl_pinjam, p.lama_pinjam, p.tgl_balik, p.tgl_kembali
              FROM tbl_pinjam p
              JOIN tbl_login l ON p.id_login = l.id_login
              JOIN tbl_buku b ON p.id_buku = b.id_buku";
    $result = $conn->query($query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Peminjaman</title>
</head>
<body>
    <h1>Welcome to Library - Data Peminjaman</h1>
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
    
    <!-- Tambahkan tombol untuk menambah peminjaman -->
    <div>
        <a href="crud/tambah_peminjaman.php">Tambah Peminjaman</a>
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
                <th>ID Peminjaman</th>
                <th>Nama Peminjam</th>
                <th>Judul Buku</th>
                <th>Sampul Buku</th>
                <th>Status</th>
                <th>Tanggal Pinjam</th>
                <th>Lama Pinjam (hari)</th>
                <th>Tanggal Balik</th>
                <th>Tanggal Kembali</th>
                <th>Denda</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['id_pinjam']}</td>";
                echo "<td>{$row['nama']}</td>";
                echo "<td>{$row['title']}</td>";
                $pathWithSingleSlash = $row['sampul'];
                $pathWithDoubleSlash = str_replace("/", "//", $pathWithSingleSlash);
                echo "<td><img src='{$pathWithDoubleSlash}' alt='Sampul Buku' style='max-width: 100px; max-height: 100px;'></td>";
                echo "<td>{$row['status']}</td>";
                echo "<td>{$row['tgl_pinjam']}</td>";
                echo "<td>{$row['lama_pinjam']}</td>";
                echo "<td>{$row['tgl_balik']}</td>";
                echo "<td>{$row['tgl_kembali']}</td>";
                echo "<td>{$row['denda']}</td>";
                echo "<td>
                    <a href='crud/edit_peminjaman.php?id={$row['id_pinjam']}'>Edit</a>
                    <a href='?action=hapus&id={$row['id_pinjam']}'>Hapus</a>
                </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <script>
        // Fungsi-fungsi JavaScript jika diperlukan
    </script>
</body>
</html>
