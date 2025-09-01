<?php 
include 'koneksi.php';


// Cek apakah ada data penilaian di tb_nilai_alternatif
$cek_penilaian = $conn->query("SELECT COUNT(*) AS jumlah FROM tb_nilai_alternatif");
$jumlah_penilaian = $cek_penilaian->fetch_assoc()['jumlah'];

if ($jumlah_penilaian == 0) {
    echo '<div class="alert alert-warning text-center" role="alert">
            <strong>Perhatian!</strong> Silakan isi <a href="index.php?m=nilai_alternatif">penilaian alternatif</a> terlebih dahulu sebelum melihat hasil perhitungan.
          </div>';
    exit; // Stop semua proses di bawahnya
}


// Ambil daftar alternatif
$alternatif_query = "SELECT * FROM tb_alternatif ORDER BY kode_alternatif";
$alternatif_result = $conn->query($alternatif_query);

$ALTERNATIF = [];
while ($row = $alternatif_result->fetch_assoc()) {
    $ALTERNATIF[$row['kode_alternatif']] = $row['nama_alternatif'];
}

// Ambil daftar kriteria
$kriteria_query = "SELECT * FROM tb_kriteria ORDER BY kode";
$kriteria_result = $conn->query($kriteria_query);

$KRITERIA = [];
$ATRIBUT = [];
while ($row = $kriteria_result->fetch_assoc()) {
    $KRITERIA[$row['kode']] = $row['nama_kriteria'];
    $ATRIBUT[$row['kode']] = $row['atribut']; // Simpan atribut (benefit/cost)
}

// Ambil daftar sub-kriteria
$sub_query = "SELECT * FROM tb_sub ORDER BY kode_kriteria, nilai_bobot";
$sub_result = $conn->query($sub_query);

$SUB = [];
$SUB_BOBOT = [];
while ($row = $sub_result->fetch_assoc()) {
    $SUB[$row['id']] = $row; // Simpan berdasarkan ID sub
    $SUB_BOBOT[$row['id']] = $row['nilai_bobot']; // Simpan nilai bobotnya
}

// Ambil nilai alternatif
$nilai_query = "SELECT * FROM tb_nilai_alternatif";
$nilai_result = $conn->query($nilai_query);

$NILAI = [];
while ($row = $nilai_result->fetch_assoc()) {
    $NILAI[$row['kode_alternatif']][$row['kode_kriteria']] = $row['id_sub'];
}

?>

<div class="page-header">
    <center><h1>Perhitungan & Perangkingan</h1></center>
</div>

<div class="panel panel-primary">
    <div class="panel-heading">
        <center><h3 class="panel-title">Hasil Analisa</h3></center>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Alternatif</th>
                    <?php foreach ($KRITERIA as $kode => $nama): ?>
                        <th><?= $nama ?></th>
                    <?php endforeach ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ALTERNATIF as $kode_alternatif => $nama_alternatif): ?>
                    <tr>
                        <td><?= $kode_alternatif ?></td>
                        <td><?= htmlspecialchars($nama_alternatif) ?></td>
                        <?php foreach ($KRITERIA as $kode_kriteria => $nama_kriteria): ?>
                            <td>
                                <?php
                                $id_sub = $NILAI[$kode_alternatif][$kode_kriteria] ?? null;
                                echo $id_sub ? htmlspecialchars($SUB[$id_sub]['nama_sub']) : '-';
                                ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Tabel Pembobotan -->
<div class="panel panel-primary">
    <div class="panel-heading">
        <center><h3 class="panel-title">Hasil Pembobotan Sub-Kriteria</h3></center>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Alternatif</th>
                    <?php foreach ($KRITERIA as $kode => $nama): ?>
                        <th><?= $nama ?></th>
                    <?php endforeach ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($NILAI as $kode_alternatif => $nilai_alt): ?>
                    <tr>
                        <td><?= $kode_alternatif ?></td>
                        <td><?= htmlspecialchars($ALTERNATIF[$kode_alternatif]) ?></td>
                        <?php foreach ($KRITERIA as $kode_kriteria => $nama_kriteria): 
                            $id_sub = $nilai_alt[$kode_kriteria] ?? null;
                            $nilai_bobot = $id_sub ? $SUB_BOBOT[$id_sub] : 0;
                        ?>
                            <td><?= round($nilai_bobot, 4) ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Tabel Menormalisasi -->
<div class="panel panel-primary">
    <div class="panel-heading">
        <center><h3 class="panel-title">Hasil Normalisasi</h3></center>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Alternatif</th>
                    <?php foreach ($KRITERIA as $kode => $nama): ?>
                        <th><?= $nama ?></th>
                    <?php endforeach ?>
                </tr>
            </thead>
            <tbody>
                <?php
                // Ambil semua nilai dari tb_nilai_alternatif
                $nilai_query = "SELECT * FROM tb_nilai_alternatif";
                $nilai_result = $conn->query($nilai_query);

                // Simpan nilai dalam array
                $NILAI = [];
                while ($row = $nilai_result->fetch_assoc()) {
                    $NILAI[$row['kode_alternatif']][$row['kode_kriteria']] = $row['id_sub'];
                }

                // Ambil semua nilai sub-kriteria
                $sub_query = "SELECT * FROM tb_sub";
                $sub_result = $conn->query($sub_query);

                // Simpan nilai bobot sub-kriteria
                $SUB_BOBOT = [];
                while ($row = $sub_result->fetch_assoc()) {
                    $SUB_BOBOT[$row['id']] = $row['nilai_bobot'];
                }

                // Ambil atribut kriteria (benefit atau cost)
                $atribut_query = "SELECT kode, atribut FROM tb_kriteria";
                $atribut_result = $conn->query($atribut_query);
                
                $ATRIBUT = [];
                while ($row = $atribut_result->fetch_assoc()) {
                    $ATRIBUT[$row['kode']] = $row['atribut'];
                }

                // Mencari nilai max dan min untuk normalisasi
                $MAX = [];
                $MIN = [];
                foreach ($KRITERIA as $kode_kriteria => $nama_kriteria) {
                    $nilai_kriteria = array_map(function ($alt) use ($SUB_BOBOT, $kode_kriteria) {
                        return isset($SUB_BOBOT[$alt[$kode_kriteria]]) ? $SUB_BOBOT[$alt[$kode_kriteria]] : 0;
                    }, $NILAI);
                    
                    $MAX[$kode_kriteria] = max($nilai_kriteria);
                    $MIN[$kode_kriteria] = min($nilai_kriteria);
                }

                // Tampilkan hasil normalisasi
                foreach ($NILAI as $kode_alternatif => $nilai_alt): ?>
                    <tr>
                        <td><?= $kode_alternatif ?></td>
                        <td><?= $ALTERNATIF[$kode_alternatif] ?></td>
                        <?php foreach ($KRITERIA as $kode_kriteria => $nama_kriteria): 
                            $nilai = $SUB_BOBOT[$nilai_alt[$kode_kriteria]] ?? 0;
                            $atribut = $ATRIBUT[$kode_kriteria];

                            // Normalisasi
                            $normalisasi = ($atribut == 'benefit') ? ($nilai / $MAX[$kode_kriteria]) : ($MIN[$kode_kriteria] / $nilai);
                        ?>
                            <td><?= round($normalisasi, 4) ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- Tabel perangkingan ( mengalikan hasil normalisasi dengan nilai bobot kriteria ) -->
<?php 
include 'koneksi.php';

// Ambil daftar alternatif
$alternatif_query = "SELECT * FROM tb_alternatif ORDER BY kode_alternatif";
$alternatif_result = $conn->query($alternatif_query);

$ALTERNATIF = [];
while ($row = $alternatif_result->fetch_assoc()) {
    $ALTERNATIF[$row['kode_alternatif']] = $row['nama_alternatif'];
}

// Ambil daftar kriteria
$kriteria_query = "SELECT * FROM tb_kriteria ORDER BY kode";
$kriteria_result = $conn->query($kriteria_query);

$KRITERIA = [];
$ATRIBUT = [];
$BOBOT_KRITERIA = [];
while ($row = $kriteria_result->fetch_assoc()) {
    $KRITERIA[$row['kode']] = $row['nama_kriteria'];
    $ATRIBUT[$row['kode']] = $row['atribut']; // Benefit / Cost
    $BOBOT_KRITERIA[$row['kode']] = $row['nilai_bobot']; // Simpan bobot kriteria
}

// Ambil daftar sub-kriteria
$sub_query = "SELECT * FROM tb_sub ORDER BY kode_kriteria, nilai_bobot";
$sub_result = $conn->query($sub_query);

$SUB = [];
$SUB_BOBOT = [];
while ($row = $sub_result->fetch_assoc()) {
    $SUB[$row['id']] = $row; 
    $SUB_BOBOT[$row['id']] = $row['nilai_bobot'];
}

// Ambil nilai alternatif
$nilai_query = "SELECT * FROM tb_nilai_alternatif";
$nilai_result = $conn->query($nilai_query);

$NILAI = [];
while ($row = $nilai_result->fetch_assoc()) {
    $NILAI[$row['kode_alternatif']][$row['kode_kriteria']] = $row['id_sub'];
}

// Mencari nilai max dan min untuk normalisasi
$MAX = [];
$MIN = [];
foreach ($KRITERIA as $kode_kriteria => $nama_kriteria) {
    $nilai_kriteria = array_map(function ($alt) use ($SUB_BOBOT, $kode_kriteria) {
        return isset($SUB_BOBOT[$alt[$kode_kriteria]]) ? $SUB_BOBOT[$alt[$kode_kriteria]] : 0;
    }, $NILAI);
    
    $MAX[$kode_kriteria] = max($nilai_kriteria);
    $MIN[$kode_kriteria] = min($nilai_kriteria);
}

// Menghitung normalisasi
$NORMALISASI = [];
foreach ($NILAI as $kode_alternatif => $nilai_alt) {
    foreach ($KRITERIA as $kode_kriteria => $nama_kriteria) {
        $nilai = $SUB_BOBOT[$nilai_alt[$kode_kriteria]] ?? 0;
        $atribut = $ATRIBUT[$kode_kriteria];

        // Normalisasi
        if ($atribut == 'benefit') {
            $NORMALISASI[$kode_alternatif][$kode_kriteria] = ($nilai / $MAX[$kode_kriteria]);
        } else {
            $NORMALISASI[$kode_alternatif][$kode_kriteria] = ($MIN[$kode_kriteria] / $nilai);
        }
    }
}

// Menghitung total nilai untuk setiap alternatif
$TOTAL_NILAI = [];
foreach ($NILAI as $kode_alternatif => $nilai_alt) {
    $total = 0;
    foreach ($KRITERIA as $kode_kriteria => $nama_kriteria) {
        $total += $NORMALISASI[$kode_alternatif][$kode_kriteria] * $BOBOT_KRITERIA[$kode_kriteria];
    }
    $TOTAL_NILAI[$kode_alternatif] = $total;
}

// Mengurutkan berdasarkan total nilai
arsort($TOTAL_NILAI);

// Menentukan ranking
$RANKING = [];
$rank = 1;
foreach ($TOTAL_NILAI as $kode_alternatif => $total) {
    $RANKING[$kode_alternatif] = $rank;
    $rank++;
}

// Simpan hasil total dan ranking ke dalam database
foreach ($TOTAL_NILAI as $kode_alternatif => $total) {
    $ranking = $RANKING[$kode_alternatif];
    $update_query = "UPDATE tb_alternatif SET total_nilai='$total', ranking='$ranking' WHERE kode_alternatif='$kode_alternatif'";
    $conn->query($update_query);
}

// Menampilkan tabel perangkingan
?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <center><h3 class="panel-title"> Menghitung Nilai Bobot Preferensi dan Hasil Perangkingan</h3></center>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Alternatif</th>
                    <?php foreach ($KRITERIA as $kode => $nama): ?>
                        <th><?= $nama ?></th>
                    <?php endforeach ?>
                    <th>Total</th>
                    <th>Ranking</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($TOTAL_NILAI as $kode_alternatif => $total) : ?>
                    <tr>
                        <td><?= $kode_alternatif ?></td>
                        <td><?= htmlspecialchars($ALTERNATIF[$kode_alternatif]) ?></td>
                        <?php foreach ($KRITERIA as $kode_kriteria => $nama_kriteria) : ?>
                            <td><?= round($NORMALISASI[$kode_alternatif][$kode_kriteria] * $BOBOT_KRITERIA[$kode_kriteria], 4) ?></td>
                        <?php endforeach; ?>
                        <td><b><?= round($total, 4) ?></b></td>
                        <td><b><?= $RANKING[$kode_alternatif] ?></b></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php
// Ambil data nama alternatif dan total nilainya dari database
$_labelsChart = [];
$_valuesChart = [];

$queryChart = mysqli_query($conn, "SELECT nama_alternatif, total_nilai FROM tb_alternatif ORDER BY ranking ASC");
while ($rowChart = mysqli_fetch_assoc($queryChart)) {
    $_labelsChart[] = $rowChart['nama_alternatif'];
    $_valuesChart[] = (float)$rowChart['total_nilai'];
}
?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <center><h3 class="panel-title">Visualisasi Grafik</h3></center>
    </div>
    <div class="panel-body text-center">
        <canvas id="barChartAlternatif" height="100"></canvas>
    </div>
</div>

<script src="assets/js/chart.umd.js"></script>
<script>
// Data dari PHP ke JavaScript
const labelsAlt = <?= json_encode($_labelsChart) ?>;
const dataAlt = <?= json_encode($_valuesChart) ?>;

// Contoh warna berbeda untuk tiap batang
const warnaBackground = [
    'rgba(255, 99, 132, 0.6)',   // Merah muda
    'rgba(54, 162, 235, 0.6)',   // Biru
    'rgba(255, 206, 86, 0.6)',   // Kuning
    'rgba(75, 192, 192, 0.6)',   // Hijau toska
    'rgba(153, 102, 255, 0.6)',  // Ungu
    'rgba(255, 159, 64, 0.6)',   // Oranye
    'rgba(199, 199, 199, 0.6)'   // Abu-abu
];

const warnaBorder = [
    'rgba(255, 99, 132, 1)',
    'rgba(54, 162, 235, 1)',
    'rgba(255, 206, 86, 1)',
    'rgba(75, 192, 192, 1)',
    'rgba(153, 102, 255, 1)',
    'rgba(255, 159, 64, 1)',
    'rgba(199, 199, 199, 1)'
];

// Inisialisasi Chart.js
const ctxAlt = document.getElementById('barChartAlternatif').getContext('2d');
const barChartAlternatif = new Chart(ctxAlt, {
    type: 'bar',
    data: {
        labels: labelsAlt,
        datasets: [{
            label: 'Total Nilai',
            data: dataAlt,
            backgroundColor: warnaBackground.slice(0, dataAlt.length),
            borderColor: warnaBorder.slice(0, dataAlt.length),
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 0.1
                }
            }
        },
        plugins: {
            legend: {
                display: true,
                position: 'top'
            }
        }
    }
});

</script>

        <div class="panel panel-body">
            <?php
            // Ambil alternatif dengan nilai total tertinggi (peringkat 1)
            reset($TOTAL_NILAI);
            ?>
            <center>
                <p>Jadi pilihan terbaik adalah <strong><?= htmlspecialchars($ALTERNATIF[key($TOTAL_NILAI)]) ?></strong> 
                dengan perolehan nilai <strong><?= round(current($TOTAL_NILAI), 5) ?></strong></p>
            </center>
            <div class="text-center">
                <button class="btn btn-primary" onclick="window.open('cetak_hasil.php', '_blank')">🖨️ Cetak </button>
            </div>
        </div>
    </div>
</div>
