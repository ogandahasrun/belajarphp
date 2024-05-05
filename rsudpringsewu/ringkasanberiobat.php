<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ringkasan Beri Obat</title>
    <style>
        h1 {
            font-family: Arial, sans-serif;
            color: green;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            font-family: Arial, sans-serif;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        .back-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            font-family: Arial, sans-serif;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .back-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <header>
        <h1>Ringkasan Beri Obat</h1>
    </header>
    <div class="back-button">
        <a href="farmasi.php">Kembali ke Menu Farmasi</a>
    </div>
    <form method="POST">
        Filter Tanggal: 
        <input type="date" name="tanggal_awal" required value="<?php echo $tanggal_awal; ?>">
        <input type="date" name="tanggal_akhir" required value="<?php echo $tanggal_akhir; ?>">
        <button type="submit" name="filter">Filter</button>
    </form>

    <?php
    include 'koneksi.php';

    $tanggal_awal = $tanggal_akhir = "";

    if(isset($_POST['filter'])) {
        $tanggal_awal = $_POST['tanggal_awal'];
        $tanggal_akhir = $_POST['tanggal_akhir'];
        
        $query = "SELECT
                    detail_pemberian_obat.tgl_perawatan,
                    detail_pemberian_obat.kode_brng,
                    databarang.nama_brng,
                    AVG(detail_pemberian_obat.h_beli) as h_beli,
                    SUM(detail_pemberian_obat.biaya_obat) as biaya_obat,
                    SUM(detail_pemberian_obat.jml) as jml,
                    databarang.kode_sat,
                    SUM(detail_pemberian_obat.embalase) as embalase,
                    SUM(detail_pemberian_obat.tuslah) as tuslah,
                    SUM(detail_pemberian_obat.total) as total
                    FROM
                    detail_pemberian_obat
                    INNER JOIN databarang ON detail_pemberian_obat.kode_brng = databarang.kode_brng
                    WHERE
                    detail_pemberian_obat.tgl_perawatan BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
                    GROUP BY
                    detail_pemberian_obat.kode_brng
                    ORDER BY
                    kode_brng ASC";

        $result = mysqli_query($koneksi, $query);

        if (!$result) {
            die("Query error: " . mysqli_error($koneksi));
        }
    }

    if(isset($result)) {
        echo "<table>
        <tr>
            <th>TANGGAL</th>
            <th>KODE BARANG</th>
            <th>NAMA BARANG</th>
            <th>HARGA BELI</th>
            <th>BIAYA OBAT</th>
            <th>JUMLAH</th>
            <th>SATUAN</th>
            <th>EMBALASE</th>
            <th>TUSLAH</th>
            <th>TOTAL</th>
        </tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['tgl_perawatan'] . "</td>";
            echo "<td>" . $row['kode_brng'] . "</td>";
            echo "<td>" . $row['nama_brng'] . "</td>";
            echo "<td>" . $row['h_beli'] . "</td>";
            echo "<td>" . $row['biaya_obat'] . "</td>";
            echo "<td>" . $row['jml'] . "</td>";
            echo "<td>" . $row['kode_sat'] . "</td>";
            echo "<td>" . $row['embalase'] . "</td>";
            echo "<td>" . $row['tuslah'] . "</td>";
            echo "<td>" . $row['total'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    mysqli_close($koneksi);
    ?>
</body>
</html>
