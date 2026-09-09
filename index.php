<?php
include "koneksi.php";
$query = "SELECT * FROM data_siswa";
$hasil = mysqli_query($koneksi, $query);
$data = mysqli_fetch_all($hasil, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
</head>
<body>
    <div class="table-responsive">
    <table border="1">
        <tr>
            <th>no</th>
            <th>id_siswa</th>
            <th>nama_lengkap</th>
            <th>jenis_kelamin</th>
            <th>tempat_tanggal_lahir</th>
            <th>kelas</th>
            <th>jurusan</th>
            <th>no_hp</th>
        </tr>
        <?php foreach ($data as $index => $data_siswa): ?>
        <tr>
            <td><?= $index + 1 ?></td>
            <td><?php echo $data_siswa['id_siswa']; ?></td>
            <td><?php echo $data_siswa['nama_lengkap']; ?></td>
            <td><?php echo $data_siswa['jenis_kelamin']; ?></td>
            <td><?php echo $data_siswa['tempat_tanggal_lahir']; ?></td>
            <td><?php echo $data_siswa['kelas']; ?></td>
            <td><?php echo $data_siswa['jurusan']; ?></td>
            <td><?php echo $data_siswa['no_hp']; ?></td>

             <div class="table-responsive">
    <table border="1">
        <tr>
            <th>no</th>
            <th>id_ekstrakurikuler</th>
            <th>nama_ekstrakurikuler</th>
            <th>nama_pembina</th>
            <th>jadwal</th>
            <th>tempat</th>
        </tr>
        <?php foreach ($data as $index => $data_siswa): ?>
        <tr>
            <td><?= $index + 1 ?></td>
            <td><?php echo $data_siswa['id_ekstrakurikuler']; ?></td>
            <td><?php echo $data_siswa['nama_ekstrakurikuler']; ?></td>
            <td><?php echo $data_siswa['nama_pembina']; ?></td>
            <td><?php echo $data_siswa['jadwal']; ?></td>
            <td><?php echo $data_siswa['tempat']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    
</body>
</html>