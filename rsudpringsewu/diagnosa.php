<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diagnosa Pasien</title>
</head>
<body>

<a href="index.php">
    <img src="images/logo.png" alt="Logo" width="80" height="100">
</a>

</body>
</html>

<?php
include 'koneksi.php';

// Inisialisasi variabel keyword
$keyword = "";

// Proses pencarian jika formulir telah diajukan
if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    $query = "SELECT
                reg_periksa.no_rawat AS no_rawat,
                pasien.no_rkm_medis AS no_rkm_medis,
                pasien.nm_pasien AS nm_pasien,
                pasien.no_ktp AS no_ktp,
                diagnosa_pasien.kd_penyakit,
                penyakit.nm_penyakit AS nm_penyakit,
                pasien.alamat AS alamat,
                kelurahan.nm_kel AS nm_kel,
                kecamatan.nm_kec AS nm_kec,
                kabupaten.nm_kab AS nm_kab,
                propinsi.nm_prop AS nm_prop,
                kamar_inap.tgl_masuk AS tgl_masuk,
                kamar_inap.tgl_keluar AS tgl_keluar,
                kamar_inap.lama AS lama
            FROM
                reg_periksa
                JOIN pasien ON (reg_periksa.no_rkm_medis = pasien.no_rkm_medis)
                JOIN kelurahan ON (pasien.kd_kel = kelurahan.kd_kel)
                JOIN kecamatan ON (pasien.kd_kec = kecamatan.kd_kec)
                JOIN kabupaten ON (pasien.kd_kab = kabupaten.kd_kab)
                JOIN propinsi ON (pasien.kd_prop = propinsi.kd_prop)
                JOIN kamar_inap ON (kamar_inap.no_rawat = reg_periksa.no_rawat)
                JOIN diagnosa_pasien ON (diagnosa_pasien.no_rawat = reg_periksa.no_rawat)
                JOIN penyakit ON (diagnosa_pasien.kd_penyakit = penyakit.kd_penyakit)
            WHERE
                pasien.nm_pasien LIKE '%$keyword%' OR
                pasien.no_rkm_medis LIKE '%$keyword%' OR
                pasien.no_ktp LIKE '%$keyword%' OR
                penyakit.nm_penyakit LIKE '%$keyword%' OR
                kamar_inap.tgl_masuk LIKE '%$keyword%' OR
                diagnosa_pasien.kd_penyakit LIKE '%$keyword%' OR
                kamar_inap.tgl_keluar LIKE '%$keyword%'
        ";
} else {
    // Jika tidak ada keyword pencarian, set default query ke semua data
    $query = "SELECT
                reg_periksa.no_rawat AS no_rawat,
                pasien.no_rkm_medis AS no_rkm_medis,
                pasien.nm_pasien AS nm_pasien,
                pasien.no_ktp AS no_ktp,
                diagnosa_pasien.kd_penyakit,
                penyakit.nm_penyakit AS nm_penyakit,
                pasien.alamat AS alamat,
                kelurahan.nm_kel AS nm_kel,
                kecamatan.nm_kec AS nm_kec,
                kabupaten.nm_kab AS nm_kab,
                propinsi.nm_prop AS nm_prop,
                kamar_inap.tgl_masuk AS tgl_masuk,
                kamar_inap.tgl_keluar AS tgl_keluar,
                kamar_inap.lama AS lama
            FROM
                reg_periksa
                JOIN pasien ON (reg_periksa.no_rkm_medis = pasien.no_rkm_medis)
                JOIN kelurahan ON (pasien.kd_kel = kelurahan.kd_kel)
                JOIN kecamatan ON (pasien.kd_kec = kecamatan.kd_kec)
                JOIN kabupaten ON (pasien.kd_kab = kabupaten.kd_kab)
                JOIN propinsi ON (pasien.kd_prop = propinsi.kd_prop)
                JOIN kamar_inap ON (kamar_inap.no_rawat = reg_periksa.no_rawat)
                JOIN diagnosa_pasien ON (diagnosa_pasien.no_rawat = reg_periksa.no_rawat)
                JOIN penyakit ON (diagnosa_pasien.kd_penyakit = penyakit.kd_penyakit)
        ";
}

$result = $koneksi->query($query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Diagnosa Pasien</title>
</head>

<body>
    <h2>Data Pasien</h2>

    <!-- Form pencarian -->
    <form action="" method="get">
        <label for="keyword">Keyword Pencarian:</label>
        <input type="text" name="keyword" id="keyword" value="<?php echo $keyword; ?>">
        <button type="submit">Cari</button>
    </form>

    <?php
    // Tampilkan data jika ada hasil dari query
    if ($result->num_rows > 0) {
        echo "<table border='1'>
                <tr>
                    <th>No Rawat</th>
                    <th>No Rekam Medis</th>
                    <th>Nama Pasien</th>
                    <th>No KTP</th>
                    <th>Kode Penyakit</th>
                    <th>Nama Penyakit</th>
                    <th>Alamat</th>
                    <th>Nama Kelurahan</th>
                    <th>Nama Kecamatan</th>
                    <th>Nama Kabupaten</th>
                    <th>Nama Propinsi</th>
                    <th>Tanggal Masuk</th>
                    <th>Tanggal Keluar</th>
                    <th>Lama Inap</th>
                </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['no_rawat']}</td>
                    <td>{$row['no_rkm_medis']}</td>
                    <td>{$row['nm_pasien']}</td>
                    <td>{$row['no_ktp']}</td>
                    <td>{$row['kd_penyakit']}</td>
                    <td>{$row['nm_penyakit']}</td>
                    <td>{$row['alamat']}</td>
                    <td>{$row['nm_kel']}</td>
                    <td>{$row['nm_kec']}</td>
                    <td>{$row['nm_kab']}</td>
                    <td>{$row['nm_prop']}</td>
                    <td>{$row['tgl_masuk']}</td>
                    <td>{$row['tgl_keluar']}</td>
                    <td>{$row['lama']}</td>
                </tr>";
        }

        echo "</table>";
    } else {
        echo "Tidak ada data yang ditemukan.";
    }

    $koneksi->close();
    ?>
</body>

</html>
