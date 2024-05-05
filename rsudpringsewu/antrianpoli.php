<!DOCTYPE html>
<html>
<head>
    <title>Form Pencarian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-top: 0;
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
        <h2>Pilih Poliklinik :</h2>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <select name="kd_poli" id="kd_poli">
                <?php 
                // Sertakan file koneksi.php
                include "koneksi.php";

                // Query untuk mengambil nilai unik dari kolom kd_poli
                $query_poli = "SELECT DISTINCT kd_poli FROM reg_periksa";
                $result_poli = mysqli_query($koneksi, $query_poli);

                // Simpan nilai-nilai unik dalam array
                $kd_poli_options = array();
                while ($row = mysqli_fetch_array($result_poli)) {
                    $kd_poli_options[] = $row['kd_poli'];
                }

                // Render dropdown options
                foreach ($kd_poli_options as $option) {
                    echo "<option value='$option'>$option</option>";
                }
                ?>
            </select>
            <input type="submit" value="Submit">
        </form>

        <?php
        // Proses formulir jika dikirim
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Ambil nilai kd_poli yang dipilih
            $kd_poli_selected = $_POST['kd_poli'];

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
</body>
</html>
