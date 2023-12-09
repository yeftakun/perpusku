<?php
include("../../koneksi.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Proses update user
    $id = $_POST['id']; // ID pengguna yang akan diupdate
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

    // Update data di database
    $queryUpdate = "UPDATE tbl_login 
                    SET nama='$nama', tempat_lahir='$tempat_lahir', tgl_lahir='$tgl_lahir', 
                        user='$username', pass='$password', level='$level', jenkel='$jenkel', 
                        telepon='$telepon', email='$email', alamat='$alamat' 
                    WHERE id_login='$id'";

    if ($conn->query($queryUpdate) === TRUE) {
        header("location:../data_pengguna.php?update_success=true");
    } else {
        echo "Error: " . $queryUpdate . "<br>" . $conn->error;
    }
} elseif (isset($_GET['id'])) {
    // Ambil data pengguna berdasarkan ID untuk ditampilkan di form edit
    $id = $_GET['id'];
    $queryGetUser = "SELECT * FROM tbl_login WHERE id_login='$id'";
    $resultGetUser = $conn->query($queryGetUser);

    if ($resultGetUser->num_rows > 0) {
        $userData = $resultGetUser->fetch_assoc();
    } else {
        echo "User not found";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<body>
    <h1>Edit User</h1>
    
    <form method="post" action="">
        <input type="hidden" name="id" value="<?php echo $userData['id_login']; ?>">
        <label>Nama Pengguna: <input type="text" name="nama" value="<?php echo $userData['nama']; ?>" required></label><br>
        <label>Tempat Lahir: <input type="text" name="tempat_lahir" value="<?php echo $userData['tempat_lahir']; ?>" required></label><br>
        <label>Tanggal Lahir (dd/mm/yyyy): <input type="text" name="tgl_lahir" value="<?php echo date('d/m/Y', strtotime($userData['tgl_lahir'])); ?>" required></label><br>
        <label>Username: <input type="text" name="username" value="<?php echo $userData['user']; ?>" required></label><br>
        <label>Password: <input type="password" name="password" value="<?php echo $userData['pass']; ?>" required></label><br>
        <label>Level: 
            <select name="level">
                <option value="Petugas" <?php echo ($userData['level'] == 'Petugas') ? 'selected' : ''; ?>>Petugas</option>
                <option value="Anggota" <?php echo ($userData['level'] == 'Anggota') ? 'selected' : ''; ?>>Anggota</option>
            </select>
        </label><br>
        <label>Jenis Kelamin: 
            <select name="jenkel">
                <option value="Laki-laki" <?php echo ($userData['jenkel'] == 'Laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
                <option value="Perempuan" <?php echo ($userData['jenkel'] == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
            </select>
        </label><br>
        <label>Telepon: <input type="text" name="telepon" value="<?php echo $userData['telepon']; ?>" required></label><br>
        <label>Email: <input type="email" name="email" value="<?php echo $userData['email']; ?>" required></label><br>
        <label>Alamat: <textarea name="alamat" required><?php echo $userData['alamat']; ?></textarea></label><br>
        <input type="submit" value="Submit">
    </form>

    <a href="../data_pengguna.php">Kembali</a>
</body>
</html>
