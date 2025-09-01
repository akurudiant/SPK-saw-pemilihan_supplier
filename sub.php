<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>

<!-- ALERT JIKA ADA -->
<?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade in" role="alert">
        <?= htmlspecialchars($_SESSION['success']) ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade in" role="alert">
        <?= htmlspecialchars($_SESSION['error']) ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>
<!-- END ALERT -->

<div class="page-header">
    <h1>Sub Kriteria</h1>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <form class="form-inline" method="GET">
            <input type="hidden" name="m" value="sub" />
            <div class="form-group">
                <input class="form-control" type="text" placeholder="Pencarian..." name="q" value="<?= isset($_GET['q']) ? $_GET['q'] : '' ?>" />
            </div>
            <div class="form-group">
                <button class="btn btn-success" type="submit"><span class="glyphicon glyphicon-search"></span> Cari</button>
            </div>
            <div class="form-group">
                <a class="btn btn-warning" href="?m=sub"><span class="glyphicon glyphicon-refresh"></span> Reset</a>
            </div>
            <div class="form-group">
                <a class="btn btn-primary" href="?m=sub_tambah"><span class="glyphicon glyphicon-plus"></span> Tambah</a>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Kriteria</th>
                    <th>Nama Kriteria</th>
                    <th>Nama Sub Kriteria</th>
                    <th>Nilai Bobot Sub-Kriteria</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'koneksi.php'; 
                $q = isset($_GET['q']) ? $_GET['q'] : '';
                
                $query = "SELECT s.*, k.nama_kriteria FROM tb_sub s 
                          JOIN tb_kriteria k ON s.kode_kriteria = k.kode 
                          WHERE k.kode LIKE '%$q%' 
                          OR k.nama_kriteria LIKE '%$q%' 
                          OR s.nama_sub LIKE '%$q%'
                          OR s.nilai_bobot LIKE '%$q%'
                          ORDER BY k.kode, s.nama_sub";
                
                $result = $conn->query($query);
                $no = 1;
                while ($row = $result->fetch_assoc()) :
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row['kode_kriteria'] ?></td>
                        <td><?= $row['nama_kriteria'] ?></td>
                        <td><?= $row['nama_sub'] ?></td>
                        <td><?= $row['nilai_bobot'] ?></td>
                        <td>
                            <div class="btn-group" role="group">
                                <form method="post" action="index.php?m=EditSubKriteria" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <button type="submit" class="btn btn-success btn-xs">
                                        <span class="glyphicon glyphicon-edit"></span> Edit
                                    </button>
                                </form>
                                <form method="post" action="aksi/tblHapusSubKriteria.php" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <button type="submit" class="btn btn-danger btn-xs">
                                        <span class="glyphicon glyphicon-trash"></span> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
