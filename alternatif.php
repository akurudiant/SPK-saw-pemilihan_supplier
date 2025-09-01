<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>

<!-- ALERT JIKA ADA -->

<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade in" role="alert">
        <?= htmlspecialchars($_SESSION['success']) ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<div class="page-header">
    <h1>Alternatif</h1>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <form class="form-inline" method="GET">
            <input type="hidden" name="m" value="alternatif" />
            <div class="form-group">
                <input class="form-control" type="text" placeholder="Pencarian..." name="q" 
                       value="<?= isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '' ?>" />
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">
                    <span class="glyphicon glyphicon-search"></span> Cari
                </button>
            </div>
            <div class="form-group">
                <a class="btn btn-warning" href="?m=alternatif"><span class="glyphicon glyphicon-refresh"></span> Reset</a>
            </div>
            <div class="form-group">
                <a class="btn btn-primary" href="?m=alternatif_tambah">
                    <span class="glyphicon glyphicon-plus"></span> Tambah
                </a>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama Alternatif</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <?php
            include 'koneksi.php';
            $q = isset($_GET['q']) ? mysqli_real_escape_string($conn, $_GET['q']) : ''; 
            $query = "SELECT * FROM tb_alternatif 
                      WHERE kode_alternatif LIKE '%$q%' 
                      OR nama_alternatif LIKE '%$q%'
                      ORDER BY kode_alternatif";

            $result = mysqli_query($conn, $query);
            $no = 0;

            while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?= ++$no ?></td>
                    <td><?= htmlspecialchars($row['kode_alternatif']) ?></td>
                    <td><?= htmlspecialchars($row['nama_alternatif']) ?></td>
                    <td>
                        <a class="btn btn-xs btn-success" href="?m=EditAlternatif&ID=<?= urlencode($row['kode_alternatif']) ?>">
                            <span class="glyphicon glyphicon-edit"></span> Edit
                        </a>
                        <a class="btn btn-xs btn-danger" href="aksi/tblHapusAlternatif.php?ID=<?= urlencode($row['kode_alternatif']) ?>" 
                            onclick="return confirm('Hapus data ini?')">
                            <span class="glyphicon glyphicon-trash"></span> Hapus
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>
