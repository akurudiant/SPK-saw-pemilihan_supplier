<?php
session_start(); // Memulai session
include '../koneksi.php';  

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = mysqli_real_escape_string($conn, $_POST['user']);
    $pass = mysqli_real_escape_string($conn, $_POST['pass']);

    // Query untuk memeriksa username dan password
    $query = "SELECT * FROM tb_admin WHERE user='$user' AND pass='$pass'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user'] = $row['user']; 
        $_SESSION['level'] = 'admin';     
        $_SESSION['login'] = true; 
        header("Location: ../index.php");  
        exit();
    } else {
        $_SESSION['error'] = "Username atau password salah!";
        header("Location: ../login.php");  
        exit();
    }
} else {
    // Jika file ini diakses langsung, arahkan ke halaman login
    header("Location: ../login.php");
    exit();
}
?>
