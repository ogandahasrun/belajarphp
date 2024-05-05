<!DOCTYPE html>
<html>
<head>
    <title>Tiga Kolom</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .container {
            display: flex;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            justify-content: space-between;
        }
        .column {
            width: 30%;
            margin-right: 2%;
            padding-right: 10px; /* Tambahkan padding atau margin kanan */
            border-right: 1px solid #ccc; /* Tambahkan garis pemisah */
        }
        /* Mengatur margin kanan terakhir menjadi 0 */
        .column:last-child {
            margin-right: 0;
            padding-right: 0; /* Hilangkan padding atau margin kanan pada kolom terakhir */
            border-right: none; /* Hilangkan garis pemisah pada kolom terakhir */
        }
        form {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        select, input[type="submit"] {
            padding: 10px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Kolom pertama -->
    <div class="column">
        <h2>Pilih Poliklinik :</h2>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <select name="kd_poli_1" id="kd_poli_1">
                <?php 
                    // Sertakan file koneksi.php
                    include "koneksi.php";

                    // Query untuk mengambil nilai unik dari kolom kd_poli
                    $query_poli = "SELECT DISTINCT kd_poli FROM reg_periksa";
                    $result_poli = mysqli_query($koneksi, $query_poli);

                    // Render dropdown options
                    while ($row = mysqli_fetch_array($result_poli)) {
                        $kd_poli = $row['kd_poli'];
                        echo "<option value='$kd_poli'>$kd_poli</option>";
                    }
                ?>
            </select>
            <input type="submit" name="submit1" value="Submit">
        </form>
        <!-- Tampilkan hasil query jika ada -->
        <?php 
            if (isset($_POST['submit1'])) {
                // Ambil nilai kd_poli yang dipilih dari kolom pertama
                $kd_poli_selected = $_POST['kd_poli_1'];
                // Query untuk menampilkan data sesuai kd_poli yang dipilih
                $query_data = "SELECT reg_periksa.no_reg, pasien.no_rkm_medis, pasien.nm_pasien, reg_periksa.stts
                                FROM reg_periksa
                                INNER JOIN pasien ON reg_periksa.no_rkm_medis = pasien.no_rkm_medis
                                WHERE DATE(reg_periksa.tgl_registrasi) = CURDATE()
                                AND reg_periksa.kd_poli = '$kd_poli_selected'";
                $result_data = mysqli_query($koneksi, $query_data);
                // Tampilkan hasil query
                echo "<h2>Daftar Pasien </h2>";
                echo "<table>
                        <tr>
                            <th>Nomor Registrasi</th>
                            <th>Nomor Rekam Medis</th>
                            <th>Nama Pasien</th>
                            <th>Status Periksa</th>
                        </tr>";
                while ($row = mysqli_fetch_array($result_data)) {
                    echo "<tr>";
                    echo "<td>" . $row['no_reg'] . "</td>";
                    echo "<td>" . $row['no_rkm_medis'] . "</td>";
                    echo "<td>" . $row['nm_pasien'] . "</td>";
                    echo "<td>" . $row['stts'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
        ?>
    </div>

    <!-- Kolom kedua -->
    <div class="column">
        <h2>Pilih Poliklinik :</h2>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <select name="kd_poli_2" id="kd_poli_2">
                <?php 
                    // Reset pointer result set
                    mysqli_data_seek($result_poli, 0);
                    // Render dropdown options
                    while ($row = mysqli_fetch_array($result_poli)) {
                        $kd_poli = $row['kd_poli'];
                        echo "<option value='$kd_poli'>$kd_poli</option>";
                    }
                ?>
            </select>
            <input type="submit" name="submit2" value="Submit">
        </form>
        <!-- Tampilkan hasil query jika ada -->
        <?php 
            if (isset($_POST['submit2'])) {
                // Ambil nilai kd_poli yang dipilih dari kolom kedua
                $kd_poli_selected = $_POST['kd_poli_2'];
                // Query untuk menampilkan data sesuai kd_poli yang dipilih
                $query_data = "SELECT reg_periksa.no_reg, pasien.no_rkm_medis, pasien.nm_pasien, reg_periksa.stts
                                FROM reg_periksa
                                INNER JOIN pasien ON reg_periksa.no_rkm_medis = pasien.no_rkm_medis
                                WHERE DATE(reg_periksa.tgl_registrasi) = CURDATE()
                                AND reg_periksa.kd_poli = '$kd_poli_selected'";
                $result_data = mysqli_query($koneksi, $query_data);
                // Tampilkan hasil query
                echo "<h2>Daftar Pasien </h2>";
                echo "<table>
                        <tr>
                            <th>Nomor Registrasi</th>
                            <th>Nomor Rekam Medis</th>
                            <th>Nama Pasien</th>
                            <th>Status Periksa</th>
                        </tr>";
                while ($row = mysqli_fetch_array($result_data)) {
                    echo "<tr>";
                    echo "<td>" . $row['no_reg'] . "</td>";
                    echo "<td>" . $row['no_rkm_medis'] . "</td>";
                    echo "<td>" . $row['nm_pasien'] . "</td>";
                    echo "<td>" . $row['stts'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
        ?>
    </div>

    <!-- Kolom ketiga -->
    <div class="column">
        <h2>Pilih Poliklinik :</h2>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <select name="kd_poli_3" id="kd_poli_3">
                <?php 
                    // Reset pointer result set
                    mysqli_data_seek($result_poli, 0);
                    // Render dropdown options
                    while ($row = mysqli_fetch_array($result_poli)) {
                        $kd_poli = $row['kd_poli'];
                        echo "<option value='$kd_poli'>$kd_poli</option>";
                    }
                ?>
            </select>
            <input type="submit" name="submit3" value="Submit">
        </form>
        <!-- Tampilkan hasil query jika ada -->
        <?php 
            if (isset($_POST['submit3'])) {
                // Ambil nilai kd_poli yang dipilih dari kolom ketiga
                $kd_poli_selected = $_POST['kd_poli_3'];
                // Query untuk menampilkan data sesuai kd_poli yang dipilih
                $query_data = "SELECT reg_periksa.no_reg, pasien.no_rkm_medis, pasien.nm_pasien, reg_periksa.stts
                                FROM reg_periksa
                                INNER JOIN pasien ON reg_periksa.no_rkm_medis = pasien.no_rkm_medis
                                WHERE DATE(reg_periksa.tgl_registrasi) = CURDATE()
                                AND reg_periksa.kd_poli = '$kd_poli_selected'";
                $result_data = mysqli_query($koneksi, $query_data);
                // Tampilkan hasil query
                echo "<h2>Daftar Pasien </h2>";
                echo "<table>
                        <tr>
                            <th>Nomor Registrasi</th>
                            <th>Nomor Rekam Medis</th>
                            <th>Nama Pasien</th>
                            <th>Status Periksa</th>
                        </tr>";
                while ($row = mysqli_fetch_array($result_data)) {
                    echo "<tr>";
                    echo "<td>" . $row['no_reg'] . "</td>";
                    echo "<td>" . $row['no_rkm_medis'] . "</td>";
                    echo "<td>" . $row['nm_pasien'] . "</td>";
                    echo "<td>" . $row['stts'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
        ?>
    </div>
</div>

</body>
</html>
