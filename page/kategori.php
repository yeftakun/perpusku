<?php
include("../koneksi.php");
session_start();

if (!isset($_SESSION['login'])) {
    header('location:../login.php');
}

// Fungsi untuk mencari data berdasarkan filter
function searchUsers($keyword, $conn)
{
    $query = "SELECT * FROM tbl_kategori 
              WHERE id_kategori LIKE '%$keyword%' OR 
                    nama_kategori LIKE '%$keyword%'";
    $result = $conn->query($query);
    return $result;
}

// Hapus kategori
if (isset($_GET['action']) && $_GET['action'] == 'hapus' && isset($_GET['id'])) {
    $idToDelete = $_GET['id'];

    // Proses penghapusan buku
    $queryDelete = "DELETE FROM tbl_kategori WHERE id_kategori = $idToDelete";

    if ($conn->query($queryDelete) === TRUE) {
        header("location:kategori.php?delete_success=true");
    } else {
        echo "Error: " . $queryDelete . "<br>" . $conn->error;
    }
}

// Ambil data pengguna
if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    $result = searchUsers($keyword, $conn);
} else {
    $query = "SELECT * FROM tbl_kategori";
    $result = $conn->query($query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Buku</title>
</head>
<body>
    <h1>Welcome to Library - Kategori Buku</h1>
    <ul>
        <li><a href="..\dash_petugas.php">Dashboard</a></li>
        <li><a href="data_pengguna.php">Data Pengguna</a></li>
        <li><a href="data_buku.php">Data Buku</a></li>
        <li><a href="kategori.php">Kategori</a></li>
        <li><a href="peminjaman.php">Peminjaman</a></li>
        <li><a href="pengembalian.php">Pengembalian</a></li>
        <li><a href="denda.php">Denda</a></li>
        <li><a href="..\logout.php">Logout</a></li>
    </ul>
    
    <div>
    <!-- Tambah User -->
        <a href="crud/tambah_kategori.php">Tambah Kategori</a>
    </div>


    <div>
        <!-- Search Box -->
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
                <th>ID</th>
                <th>Kategori</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>K{$row['id_kategori']}</td>";
                echo "<td>{$row['nama_kategori']}</td>";
                echo "<td>
                    <a href='./crud/edit_kategori.php?id={$row['id_kategori']}'>Edit</a>
                    <a href='?action=hapus&id={$row['id_kategori']}'>Hapus</a>
                </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <script>
        function showForm() {
            var formTambahUser = document.getElementById('formTambahUser');
            formTambahUser.style.display = 'block';
        }
    </script>
</body>
</html>
