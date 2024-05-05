<?php
// Include file koneksi.php
include "koneksi.php";

// Query untuk mengambil data
$query = "SELECT
            gudangbarang.kode_brng,
            databarang.nama_brng,
            kodesatuan.satuan,
            gudangbarang.stok,
            bangsal.nm_bangsal
          FROM
            gudangbarang
          INNER JOIN databarang ON gudangbarang.kode_brng = databarang.kode_brng
          INNER JOIN kodesatuan ON databarang.kode_sat = kodesatuan.kode_sat
          INNER JOIN bangsal ON gudangbarang.kd_bangsal = bangsal.kd_bangsal";

$result = $conn->query($query);

// Cek apakah query berhasil dijalankan
if (!$result) {
    die("Query error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Gudang Barang</title>
</head>
<body>

    <h2>Data Gudang Barang</h2>

    <table border="1">
        <tr>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Satuan</th>
            <th>Stok</th>
            <th>Nama Bangsal</th>
        </tr>
        <?php
        // Menampilkan data ke dalam tabel
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['kode_brng'] . "</td>";
            echo "<td>" . $row['nama_brng'] . "</td>";
            echo "<td>" . $row['satuan'] . "</td>";
            echo "<td>" . $row['stok'] . "</td>";
            echo "<td>" . $row['nm_bangsal'] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <?php
    // Menutup koneksi
    $conn->close();
    ?>

</body>
</html>
