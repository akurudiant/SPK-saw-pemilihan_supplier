<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>

<!-- ALERT JIKA ADA -->
<?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade in" role="alert">
        <?= htmlspecialchars($_SESSION['error']) ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade in" role="alert">
        <?= htmlspecialchars($_SESSION['success']) ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>
<!-- END ALERT -->

<div class="page-header">
    <h1>Tambah Kriteria</h1>
</div>

<div class="row">
    <div class="col-sm-6">
        <form method="post" action="aksi/tblTambahKriteria.php">
            <div class="form-group">
                <label>Kode <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="kode" value="<?= isset($_POST['kode']) ? $_POST['kode'] : '' ?>" />
            </div>
            <div class="form-group">
                <label>Nama Kriteria <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="nama" value="<?= isset($_POST['nama']) ? $_POST['nama'] : '' ?>" />
            </div>
            <div class="form-group">
                <label>Nilai Bobot <span class="text-danger">*</span></label>
                <input class="form-control" type="number" step="any" name="bobot" value="<?= isset($_POST['bobot']) ? $_POST['bobot'] : '' ?>" />
            </div>
            <div class="form-group">
                <label>Atribut <span class="text-danger">*</span></label>
                <select class="form-control" name="atribut">
                    <option value="benefit" <?= (isset($_POST['atribut']) && $_POST['atribut'] == 'benefit') ? 'selected' : '' ?>>Benefit</option>
                    <option value="cost" <?= (isset($_POST['atribut']) && $_POST['atribut'] == 'cost') ? 'selected' : '' ?>>Cost</option>
                </select>
            </div>
            <div class="form-group">
                <button class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                <a class="btn btn-danger" href="?m=kriteria"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
            </div>
        </form>
    </div>
</div>
