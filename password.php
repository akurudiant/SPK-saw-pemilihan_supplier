<div class="page-header">
    <h1>Ubah Password</h1>
</div>
<div class="row">
    <div class="col-sm-5">
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        
        <form method="post" action="aksi/tblUbahPassword.php">
            <div class="form-group">
                <label>Password Lama <span class="text-danger">*</span></label>
                <input class="form-control" type="password" name="pass1" required />
            </div>
            <div class="form-group">
                <label>Password Baru <span class="text-danger">*</span></label>
                <input class="form-control" type="password" name="pass2" required />
            </div>
            <div class="form-group">
                <label>Konfirmasi Password Baru <span class="text-danger">*</span></label>
                <input class="form-control" type="password" name="pass3" required />
            </div>
            <div class="form-group">
                <button class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                <a href="javascript:history.back()" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> Kembali</a>
            </div>
        </form>
    </div>
</div>
