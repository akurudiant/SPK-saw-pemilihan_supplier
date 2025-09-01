<?php
include 'koneksi.php';
include 'fungsi.php';

$KRITERIA = get_data("SELECT * FROM tb_kriteria ORDER BY id");
$ALTERNATIF = get_data("SELECT * FROM tb_alternatif ORDER BY id");
$SUB = get_data("SELECT * FROM tb_sub ORDER BY id");
$REL_ALTERNATIF = get_rel_alternatif();

// Dapatkan tanggal cetak
$tanggalCetak = date("d M Y");

// Hitung normalisasi dengan mempertimbangkan atribut (benefit/cost)
$normalisasi = [];

foreach ($KRITERIA as $k) {
    $id_kriteria = $k['id'];
    $atribut = $k['atribut'];

    $nilai_kriteria = [];
    foreach ($ALTERNATIF as $a) {
        $nilai = @$REL_ALTERNATIF[$a['id']][$id_kriteria]['nilai_bobot'] ?? 0;
        $nilai_kriteria[] = $nilai;
    }

    $max_nilai = max($nilai_kriteria);
    $min_nilai = min($nilai_kriteria);

    foreach ($ALTERNATIF as $a) {
        $nilai = @$REL_ALTERNATIF[$a['id']][$id_kriteria]['nilai_bobot'] ?? 0;
        if ($atribut == 'benefit') {
            $normalisasi[$a['kode_alternatif']][$id_kriteria] = ($max_nilai != 0) ? $nilai / $max_nilai : 0;
        } else {
            $normalisasi[$a['kode_alternatif']][$id_kriteria] = ($nilai != 0) ? $min_nilai / $nilai : 0;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Hasil SAW</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; color: #000; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: center; }
        h2, h3, h4 { margin-bottom: 5px; }
        .btn-cetak { margin: 20px 0; padding: 10px 20px; background: #007bff; color: white; border: none; cursor: pointer; }
        ol, ul { padding-left: 20px; margin-top: 0; }
        ul { list-style-type: disc; }
        @media print {
            .btn-cetak { display: none; }
        }
    </style>
</head>
<body>

<h2 style="text-align: center;">
    Laporan Hasil<br>Perhitungan dan Perangkingan SAW<br>Pemilihan Supplier Minyak Terbaik Pada Toko Maya
</h2>
<hr style="border: 2px solid black; margin-bottom: 20px;">

<p>Tanggal Cetak: <?= $tanggalCetak ?></p>

<!-- Tombol Cetak -->
<button class="btn-cetak" onclick="window.print()">🖨️ Cetak Sekarang</button>

<h2>Data Kriteria dan Subkriteria</h2>
<div style="display: flex; justify-content: space-between; gap: 30px; margin-bottom: 30px;">
    <!-- Kriteria -->
    <div style="flex: 1;">
        <h3>Kriteria</h3>
        <ol>
            <?php foreach($KRITERIA as $k): ?>
                <li style="margin-bottom: 10px;">
                    <strong><?= $k['kode'] ?></strong> – <?= $k['nama_kriteria'] ?><br>
                    Bobot: <?= $k['nilai_bobot'] ?> | Atribut: <?= ucfirst($k['atribut']) ?>
                </li>
            <?php endforeach; ?>
        </ol>
    </div>

    <!-- Subkriteria -->
    <div style="flex: 1;">
        <h3>Subkriteria</h3>
        <ol>
            <?php foreach($KRITERIA as $k): ?>
                <li style="margin-bottom: 5px;">
                    <strong><?= $k['kode'] ?> - <?= $k['nama_kriteria'] ?></strong>
                    <ul>
                        <?php foreach($SUB as $s): ?>
                            <?php if($s['kode_kriteria'] == $k['kode']): ?>
                                <li><?= $s['nama_sub'] ?> (Bobot: <?= $s['nilai_bobot'] ?>)</li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </li>
            <?php endforeach; ?>
        </ol>
    </div>
</div>
<br><br>
<!-- Tabel Hasil Analisa -->
<h3>1. Tabel Hasil Analisa</h3>
<table>
    <thead>
        <tr>
            <th>Kode</th>
            <th>Nama Alternatif</th>
            <?php foreach($KRITERIA as $k): ?>
                <th><?= $k['kode'] ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
    <?php foreach($ALTERNATIF as $a): ?>
        <tr>
            <td><?= $a['kode_alternatif'] ?></td>
            <td style="text-align: left;"><?= $a['nama_alternatif'] ?></td>
            <?php foreach($KRITERIA as $k): ?>
                <td><?= @$REL_ALTERNATIF[$a['id']][$k['id']]['nama_sub'] ?: '-' ?></td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<!-- Tabel Pembobotan Sub-Kriteria -->
<h3>2. Tabel Pembobotan Sub-Kriteria</h3>
<table>
    <thead>
        <tr>
            <th>Kode</th>
            <th>Nama Alternatif</th>
            <?php foreach($KRITERIA as $k): ?>
                <th><?= $k['kode'] ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
    <?php foreach($ALTERNATIF as $a): ?>
        <tr>
            <td><?= $a['kode_alternatif'] ?></td>
            <td style="text-align: left;"><?= $a['nama_alternatif'] ?></td>
            <?php foreach($KRITERIA as $k): ?>
                <td><?= @$REL_ALTERNATIF[$a['id']][$k['id']]['nilai_bobot'] ?: '-' ?></td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<!-- Tabel Normalisasi -->
<h3>3. Tabel Normalisasi</h3>
<table>
    <thead>
        <tr>
            <th>Kode</th>
            <th>Nama Alternatif</th>
            <?php foreach($KRITERIA as $k): ?>
                <th><?= $k['kode'] ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
    <?php foreach($ALTERNATIF as $a): ?>
        <tr>
            <td><?= $a['kode_alternatif'] ?></td>
            <td style="text-align: left;"><?= $a['nama_alternatif'] ?></td>
            <?php foreach($KRITERIA as $k): ?>
                <td><?= rtrim(rtrim(number_format($normalisasi[$a['kode_alternatif']][$k['id']], 4, '.', ''), '0'), '.') ?></td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<!-- Tabel Pembobotan Preferensi -->
<h3>4. Tabel Pembobotan Preferensi</h3>
<table>
    <thead>
        <tr>
            <th>Kode</th>
            <th>Nama Alternatif</th>
            <?php foreach($KRITERIA as $k): ?>
                <th><?= $k['kode'] ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
    <?php foreach($ALTERNATIF as $a): ?>
        <tr>
            <td><?= $a['kode_alternatif'] ?></td>
            <td style="text-align: left;"><?= $a['nama_alternatif'] ?></td>
            <?php foreach($KRITERIA as $k): ?>
                <?php
                    $nilai_normal = $normalisasi[$a['kode_alternatif']][$k['id']] ?? 0;
                    $nilai_bobot = $k['nilai_bobot'];
                    $preferensi = $nilai_normal * $nilai_bobot;
                ?>
                <td><?= rtrim(rtrim(number_format($preferensi, 4, '.', ''), '0'), '.') ?></td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<!-- Tabel Perangkingan -->
<h3>5. Tabel Hasil Perangkingan</h3>
<?php
$data_rangking = get_data("SELECT * FROM tb_alternatif ORDER BY ranking ASC");
$no = 1;
?>
<table>
    <thead>
        <tr>
            <th>Ranking</th>
            <th>Kode</th>
            <th>Nama Alternatif</th>
            <th>Total Nilai</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($data_rangking as $dr): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $dr['kode_alternatif'] ?></td>
            <td style="text-align: left;"><?= $dr['nama_alternatif'] ?></td>
            <td><?= number_format($dr['total_nilai'], 4) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<script>
    window.onload = function() {
        window.print();
    };
</script>
</body>
</html>
