<?php
include("../../koneksi.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Proses penambahan user
    $nama = $_POST['nama'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $level = $_POST['level'];
    $jenkel = $_POST['jenkel'];
    $telepon = $_POST['telepon'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];

    // Format tanggal menjadi Y-m-d
    $tgl_lahir = DateTime::createFromFormat('d/m/Y', $tgl_lahir)->format('Y-m-d');

    // Insert data ke database
    $queryInsert = "INSERT INTO tbl_login (nama, tempat_lahir, tgl_lahir, user, pass, level, jenkel, telepon, email, alamat)
                    VALUES ('$nama', '$tempat_lahir', '$tgl_lahir', '$username', '$password', '$level', '$jenkel', '$telepon', '$email', '$alamat')";

    if ($conn->query($queryInsert) === TRUE) {
        $last_id = $conn->insert_id; // Ambil ID terakhir yang di-generate (AUTO_INCREMENT)
        header("location:../data_pengguna.php?new_id=$last_id");
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
    <title>Tambah User</title>
</head>
<body>
    <h1>Tambah User</h1>
    
    <form method="post" action="">
        <!-- Hapus input anggota_id, karena ini di-handle secara otomatis oleh AUTO_INCREMENT -->
        <label>Nama Pengguna: <input type="text" name="nama" required></label><br>
        <label>Tempat Lahir: <input type="text" name="tempat_lahir" required></label><br>
        <label>Tanggal Lahir (dd/mm/yyyy): <input type="text" name="tgl_lahir" required></label><br>
        <label>Username: <input type="text" name="username" required></label><br>
        <label>Password: <input type="password" name="password" required></label><br>
        <label>Level: 
            <select name="level">
                <option value="Petugas">Petugas</option>
                <option value="Anggota">Anggota</option>
            </select>
        </label><br>
        <label>Jenis Kelamin: 
            <select name="jenkel">
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
        </label><br>
        <label>Telepon: <input type="text" name="telepon" required></label><br>
        <label>Email: <input type="email" name="email" required></label><br>
        <label>Alamat: <textarea name="alamat" required></textarea></label><br>
        <input type="submit" value="Submit">
    </form>

    <a href="../data_pengguna.php">Kembali</a>
</body>
</html>
