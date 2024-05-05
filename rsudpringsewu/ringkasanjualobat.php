<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ringkasan Penjualan Obat</title>
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
        <h1>Ringkasan Penjualan Obat</h1>
    </header>
    <div class="back-button">
        <a href="farmasi.php">Kembali ke Menu Farmasi</a>
    </div>
    <form method="POST">
        Filter Tanggal: 
        <input type="date" name="tanggal_awal" required value="<?php echo isset($tanggal_awal) ? $tanggal_awal : ''; ?>">
        <input type="date" name="tanggal_akhir" required value="<?php echo isset($tanggal_akhir) ? $tanggal_akhir : ''; ?>">
        <button type="submit" name="filter">Filter</button>
    </form>

    <?php
    include 'koneksi.php';

    $tanggal_awal = $tanggal_akhir = "";

    if(isset($_POST['filter'])) {
        $tanggal_awal = $_POST['tanggal_awal'];
        $tanggal_akhir = $_POST['tanggal_akhir'];
        
        $query = "SELECT
                    detailjual.kode_brng AS Kode_Barang,
                    databarang.nama_brng AS Nama_Barang,
                    databarang.kode_sat AS Satuan,
                    Sum(detailjual.jumlah) AS Jumlah,
                    Avg(detailjual.h_beli) AS Harga_Beli,
                    Avg(detailjual.h_jual) AS Harga_Jual,
                    Sum(detailjual.subtotal) AS Sub_Total,
                    Sum(detailjual.dis) AS Diskon_Persen,
                    Sum(detailjual.bsr_dis) AS Diskon_Rp,
                    Sum(detailjual.tambahan) AS Tambahan,
                    Sum(detailjual.embalase) AS Embalase,
                    Sum(detailjual.tuslah) AS Tuslah,
                    Sum(detailjual.total) AS Total
                    FROM
                    penjualan
                    INNER JOIN detailjual ON detailjual.nota_jual = penjualan.nota_jual
                    INNER JOIN databarang ON detailjual.kode_brng = databarang.kode_brng
                    WHERE
                    penjualan.tgl_jual BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
                    GROUP BY
                    detailjual.kode_brng
                    ORDER BY
                    detailjual.kode_brng ASC";

        $result = mysqli_query($koneksi, $query);

        if (!$result) {
            die("Query error: " . mysqli_error($koneksi));
        }

        echo "<table>
        <tr>
            <th>KODE BARANG</th>
            <th>NAMA BARANG</th>
            <th>SATUAN</th>
            <th>JUMLAH</th>
            <th>HARGA BELI</th>
            <th>HARGA JUAL</th>
            <th>SUB TOTAL</th>
            <th>DISKON %</th>
            <th>DISKON Rp</th>
            <th>TAMBAHAN</th>
            <th>EMBALASE</th>
            <th>TUSLAH</th>
            <th>TOTAL</th>
        </tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['Kode_Barang'] . "</td>";
            echo "<td>" . $row['Nama_Barang'] . "</td>";
            echo "<td>" . $row['Satuan'] . "</td>";
            echo "<td>" . $row['Jumlah'] . "</td>";
            echo "<td>" . $row['Harga_Beli'] . "</td>";
            echo "<td>" . $row['Harga_Jual'] . "</td>";
            echo "<td>" . $row['Sub_Total'] . "</td>";
            echo "<td>" . $row['Diskon_Persen'] . "</td>";
            echo "<td>" . $row['Diskon_Rp'] . "</td>";
            echo "<td>" . $row['Tambahan'] . "</td>";
            echo "<td>" . $row['Embalase'] . "</td>";
            echo "<td>" . $row['Tuslah'] . "</td>";
            echo "<td>" . $row['Total'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    mysqli_close($koneksi);
    ?>
</body>
</html>
