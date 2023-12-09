<?php
include("koneksi.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    $query = "SELECT * FROM tbl_login WHERE user='$user' AND pass='$pass'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['login'] = true;
        $_SESSION['user_id'] = $row['id_login'];
        $_SESSION['level'] = $row['level'];

        if ($row['level'] == 'Anggota') {
            header('location:dash_anggota.php');
        } elseif ($row['level'] == 'Petugas') {
            header('location:dash_petugas.php');
        } else {
            // Handle jika level tidak sesuai (opsional)
            header('location:index.php'); // Redirect ke halaman utama jika level tidak dikenali
        }
    } else {
        echo "Login failed";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>

    <form method="post" action="">
        <label>Username: <input type="text" name="user" required></label><br>
        <label>Password: <input type="password" name="pass" required></label><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
