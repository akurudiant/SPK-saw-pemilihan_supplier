<?php
include 'koneksi.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$kode_alt = $_GET['ID'];
$row = $conn->query("SELECT * FROM tb_alternatif WHERE kode_alternatif='$kode_alt'")->fetch_object();
?>

<?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($_SESSION['success']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<div class="page-header">
    <h1>Ubah Nilai Bobot &raquo; <small><?= htmlspecialchars($row->nama_alternatif) ?></small></h1>
</div>
<div class="row">
    <div class="col-sm-6">
        <form method="post" action="aksi/simpan_nilai.php?act=rel_alternatif_ubah">
            <input type="hidden" name="kode_alternatif" value="<?= htmlspecialchars($kode_alt) ?>">

            <?php
            $query = "
                SELECT 
                    k.kode AS kode_kriteria,
                    k.nama_kriteria,
                    na.id AS id_nilai,
                    na.id_sub
                FROM tb_kriteria k
                LEFT JOIN tb_nilai_alternatif na 
                    ON na.kode_kriteria = k.kode AND na.kode_alternatif = '$kode_alt'
                ORDER BY k.kode
            ";
            $result = $conn->query($query);
            while ($r = $result->fetch_assoc()):
                $kode_kriteria = $r['kode_kriteria'];
                $id_nilai = $r['id_nilai']; // bisa null jika belum pernah diisi
                $id_sub_terpilih = $r['id_sub'];

                $sub_query = $conn->query("SELECT * FROM tb_sub WHERE kode_kriteria = '$kode_kriteria'");
            ?>
                <div class="form-group">
                    <label><?= htmlspecialchars($r['nama_kriteria']) ?></label>
                    <select class="form-control" name="<?= $id_nilai ? "nilai[$id_nilai]" : "nilai_baru[$kode_kriteria]" ?>">
                        <?php while ($sub = $sub_query->fetch_assoc()): ?>
                            <option value="<?= $sub['id'] ?>" <?= $sub['id'] == $id_sub_terpilih ? 'selected' : '' ?>>
                                <?= htmlspecialchars($sub['nama_sub']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            <?php endwhile; ?>

            <button class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Simpan</button>
            <a class="btn btn-danger" href="?m=nilai_alternatif"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
        </form>
    </div>
</div>
