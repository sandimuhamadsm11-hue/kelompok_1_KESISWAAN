<?php
include "../config/koneksi.php";

if (isset($_POST['submit'])) {
    $id_siswa = mysqli_real_escape_string($koneksi, $_POST['id_siswa']);
    $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $jenis_kelamin = mysqli_real_escape_string($koneksi, $_POST['jenis_kelamin']);
    $tempat_tanggal_lahir = mysqli_real_escape_string($koneksi, $_POST['tanggal_lahir']);
    $kelas = mysqli_real_escape_string($koneksi, $_POST['kelas']);
    $jurusan = mysqli_real_escape_string($koneksi, $_POST['jurusan']);
    $no_hp = mysqli_real_escape_string($koneksi, $_POST['no_hp']);

    $query = "INSERT INTO data_siswa (id_siswa, nama_lengkap, jenis_kelamin, tempat_tanggal_lahir, kelas, jurusan, no_hp) 
              VALUES ('$id_siswa', '$nama_lengkap', '$jenis_kelamin', '$tempat_tanggal_lahir', '$kelas', '$jurusan', '$no_hp')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data Siswa Berhasil Ditambahkan!'); window.location='../views/index.php#data-siswa';</script>";
    } else {
        echo "<script>alert('Gagal Menambah Data: " . mysqli_error($koneksi) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Siswa - SMKN 1 MAJA</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="form-card">
        <h2>Tambah Data Siswa</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label>ID Siswa / NISN</label>
                <input type="text" name="id_siswa" required placeholder="Contoh: 10245">
            </div>
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama_lengkap" required placeholder="Nama Lengkap Siswa">
            </div>
            <div class="form-group">
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin" required>
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="L">Laki-laki (L)</option>
                    <option value="P">Perempuan (P)</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" required>
            </div>

            <div class="form-group">
                <label>Kelas</label>
                <input type="text" name="kelas" required placeholder="Contoh: XI RPL 1">
            </div>
            <div class="form-group">
                <label>Jurusan / Konsentrasi Keahlian</label>
                <input type="text" name="jurusan" required placeholder="Contoh: Rekayasa Perangkat Lunak">
            </div>
            <div class="form-group">
                <label>No HP / WhatsApp</label>
                <input type="text" name="no_hp" placeholder="Contoh: 08123456789">
            </div>
            <div class="btn-group">
                <button type="submit" name="submit" class="btn-save">Simpan Data</button>
                <a href="..views/index.php#data-siswa" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>