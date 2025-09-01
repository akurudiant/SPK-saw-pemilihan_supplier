<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit();
}
$mod = isset($_GET['m']) ? $_GET['m'] : 'home'; // Menentukan halaman aktif
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SPK Pemilihan Supplier</title>
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/index.css" rel="stylesheet">
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
</head>
<body>

<div id="wrapper"> 

  <!-- Navigation -->
  <nav class="navbar navbar-default navbar-fixed-top " role="navigation">
    <div class="navbar-header">
      <a class="navbar-brand" href="?m=home">SPK - Simple Additive Weighting</a>
    </div>

    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>

    <div class="navbar-collapse collapse">
  <ul class="nav navbar-nav navbar-right" style="margin-right: 20px;">
    <li class="dropdown">
      <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        <span class="glyphicon glyphicon-user"></span> Admin Toko <b class="caret"></b>
      </a>
      <ul class="dropdown-menu dropdown-user">
        <li><a href="?m=password"><span class="glyphicon glyphicon-pencil"></span> Ubah Password</a></li>
        <li><a href="aksi/tblLogout.php"><span class="glyphicon glyphicon-remove-sign"></span> Logout</a></li>
      </ul>
    </li>
  </ul>
  </nav>
</div>


  <!-- Sidebar -->
<div class="navbar-default sidebar" role="navigation">
  <div class="sidebar-nav navbar-collapse">
    <ul class="nav" id="side-menu">
      <li><a href="?m=home" class="<?= ($mod == 'home') ? 'active' : '' ?>"><i class="glyphicon glyphicon-home"></i> Beranda</a></li>
      <li><a href="?m=kriteria" class="<?= ($mod == 'kriteria') ? 'active' : '' ?>"><i class="glyphicon glyphicon-list-alt"></i> Kriteria</a></li>
      <li><a href="?m=sub" class="<?= ($mod == 'sub') ? 'active' : '' ?>"><i class="glyphicon glyphicon-th-list"></i> SubKriteria</a></li>
      <li><a href="?m=alternatif" class="<?= ($mod == 'alternatif') ? 'active' : '' ?>"><i class="glyphicon glyphicon-user"></i> Alternatif</a></li>
      <li><a href="?m=nilai_alternatif" class="<?= ($mod == 'nilai_alternatif') ? 'active' : '' ?>"><i class="glyphicon glyphicon-signal"></i> Nilai Alternatif</a></li>
      <li><a href="?m=hitung" class="<?= ($mod == 'hitung') ? 'active' : '' ?>"><i class="glyphicon glyphicon-dashboard"></i> Perhitungan</a></li>
    </ul>
  </div>
</div>

  <!-- Page Content -->
  <div id="page-wrapper">
    <div class="container-fluid">
      <?php
        // Menyertakan file berdasarkan nilai $mod
        if (file_exists("$mod.php")) {
          include "$mod.php";
        } else {
          include 'home.php'; // Default: home.php
        }
      ?>
    </div>
  </div>

</div> <!-- /#wrapper -->

<script type="text/javascript">
  $('.form-control').attr('autocomplete', 'off');
</script>

</body>
</html>
