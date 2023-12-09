<?php
include("koneksi.php");
session_start();

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM tbl_login WHERE user='$username' AND pass='$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $_SESSION['login'] = true;
        header('location:index.php');
    } else {
        echo "Login failed. Please check your username and password.";
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
        <label>Username: <input type="text" name="username" required></label><br>
        <label>Password: <input type="password" name="password" required></label><br>
        <input type="submit" name="login" value="Login">
    </form>
</body>
</html>
