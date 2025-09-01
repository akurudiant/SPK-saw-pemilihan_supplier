<?php
session_start();
include '../koneksi.php';  

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pass1 = mysqli_real_escape_string($conn, $_POST['pass1']);
    $pass2 = mysqli_real_escape_string($conn, $_POST['pass2']);
    $pass3 = mysqli_real_escape_string($conn, $_POST['pass3']);

    if (empty($pass1) || empty($pass2) || empty($pass3)) {
        $_SESSION['error'] = "Semua field wajib diisi!";
    } else {
        $query = "SELECT * FROM tb_admin WHERE user='{$_SESSION['user']}'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);

        if ($row && $pass1 === $row['pass']) { 
            if ($pass2 !== $pass3) {
                $_SESSION['error'] = "Password baru dan konfirmasi password tidak cocok!";
            } else {
                $update_query = "UPDATE tb_admin SET pass='$pass2' WHERE user='{$_SESSION['user']}'";

                if (mysqli_query($conn, $update_query)) {
                    $_SESSION['success'] = "Password berhasil diubah!";
                } else {
                    $_SESSION['error'] = "Gagal mengubah password! Error: " . mysqli_error($conn);
                }
            }
        } else {
            $_SESSION['error'] = "Password lama salah!";
        }
    }
    
    // Redirect setelah proses
    header("Location: ../index.php?m=password");
    exit();
} else {
    header("Location: ../index.php");
    exit();
}
?>
