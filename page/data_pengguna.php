<?php
include("../koneksi.php");
session_start();

if (!isset($_SESSION['login'])) {
    header('location:../login.php');
}

// Fungsi untuk mencari data berdasarkan filter
function searchUsers($keyword, $conn)
{
    $query = "SELECT * FROM tbl_login 
              WHERE anggota_id LIKE '%$keyword%' OR 
                    nama LIKE '%$keyword%' OR 
                    user LIKE '%$keyword%' OR 
                    jenkel LIKE '%$keyword%' OR 
                    telepon LIKE '%$keyword%' OR 
                    level LIKE '%$keyword%' OR 
                    alamat LIKE '%$keyword%'";
    $result = $conn->query($query);
    return $result;
}

// Tambah user
if (isset($_POST['tambah_user'])) {
    // Proses penambahan user
    // ...
    // Redirect atau berikan pesan sukses
}

// Hapus user
if (isset($_GET['action']) && $_GET['action'] == 'hapus' && isset($_GET['id'])) {
    // Proses penghapusan user
    // ...
    // Redirect atau berikan pesan sukses
}

// Ambil data pengguna
if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    $result = searchUsers($keyword, $conn);
} else {
    $query = "SELECT * FROM tbl_login";
    $result = $conn->query($query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pengguna</title>
</head>
<body>
    <h1>Data Pengguna</h1>
    
    <div>
        <!-- Tambah User -->
        <a href="#" onclick="showForm()">Tambah User</a>
        <div id="formTambahUser" style="display:none;">
            <!-- Form tambah user -->
            <!-- ... -->
        </div>
    </div>

    <div>
        <!-- Search Box -->
        <form method="get" action="">
            <label>Cari: 
                <input type="text" name="keyword" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>">
            </label>
            <input type="submit" value="Cari">
        </form>
    </div>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>User</th>
                <th>Jenis Kelamin</th>
                <th>Telepon</th>
                <th>Level</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['anggota_id']}</td>";
                echo "<td>{$row['nama']}</td>";
                echo "<td>{$row['user']}</td>";
                echo "<td>{$row['jenkel']}</td>";
                echo "<td>{$row['telepon']}</td>";
                echo "<td>{$row['level']}</td>";
                echo "<td>{$row['alamat']}</td>";
                echo "<td>
                        <a href='#' onclick='editUser({$row['id_login']})'>Edit</a>
                        <a href='?action=hapus&id={$row['id_login']}'>Hapus</a>
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

        function editUser(userId) {
            // Proses pengeditan user
            // ...
            // Redirect atau tampilkan form edit user
        }
    </script>
</body>
</html>
