
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login - SPK Pemilihan Supplier</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="assets/css/login.css" rel="stylesheet">
</head>
<body>

<div class="container-box">
  <!-- Info Box -->
  <div class="info-box">
  <h2>Selamat Datang!</h2>
  <p><strong>Sistem Pendukung Keputusan pemilihan supplier minyak terbaik di Toko Maya</strong> <br>
  <br>ini dirancang untuk membantu dalam pengambilan keputusan secara lebih cepat, tepat, dan objektif.</p>
  <p>Silakan login untuk mulai menggunakan sistem.</p>
</div>


  <!-- Login Box -->
  <div class="login-box">
    <h3><center>Silakan Masuk</center></h3>
    <form method="POST" action="aksi/tblLogin.php">
      <?php
        session_start();
        if (isset($_SESSION['error'])):
      ?>
        <div class="alert-danger">
          <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
      <?php endif; ?>
      <input type="text" name="user" class="form-control" placeholder="Masukkan Username" required>
      <input type="password" name="pass" class="form-control" placeholder="Masukkan Password" required>
      <button type="submit" class="btn-primary">Login</button>
    </form>
  </div>
</div>

<script>
  document.querySelectorAll('.form-control').forEach(input => input.setAttribute('autocomplete', 'off'));
</script>

</body>
</html>