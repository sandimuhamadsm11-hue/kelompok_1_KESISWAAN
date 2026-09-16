<?php
include "koneksi.php";

if (isset($_POST['submit'])) {
    $id_siswa = mysqli_real_escape_string($koneksi, $_POST['id_siswa']);
    $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $jenis_kelamin = mysqli_real_escape_string($koneksi, $_POST['jenis_kelamin']);
    
    // Ambil tanggal lahir langsung format asli HTML: YYYY-MM-DD
    // Jangan diubah ke teks agar sesuai dengan tipe data DATE di MySQL
    $tempat_tanggal_lahir = mysqli_real_escape_string($koneksi, $_POST['tanggal_lahir']);

    $kelas = mysqli_real_escape_string($koneksi, $_POST['kelas']);
    $jurusan = mysqli_real_escape_string($koneksi, $_POST['jurusan']);
    $no_hp = mysqli_real_escape_string($koneksi, $_POST['no_hp']);

    $query = "INSERT INTO data_siswa (id_siswa, nama_lengkap, jenis_kelamin, tempat_tanggal_lahir, kelas, jurusan, no_hp) 
              VALUES ('$id_siswa', '$nama_lengkap', '$jenis_kelamin', '$tempat_tanggal_lahir', '$kelas', '$jurusan', '$no_hp')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data Siswa Berhasil Ditambahkan!'); window.location='index.php#data-siswa';</script>";
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
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f8fafc; padding: 40px 20px; color: #334155; }
        .form-card { max-width: 600px; background: #fff; margin: 0 auto; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); border-top: 4px solid #0284c7; }
        h2 { margin-bottom: 20px; color: #0f172a; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: 600; font-size: 0.9rem; }
        input, select { width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 5px; font-size: 0.9rem; box-sizing: border-box; }
        .btn-group { display: flex; gap: 10px; margin-top: 20px; }
        .btn-save { background: #10b981; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-weight: 600; }
        .btn-cancel { background: #64748b; color: white; border: none; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-size: 0.9rem; }
        .btn-save:hover { background: #059669; }
    </style>
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
                <a href="index.php#data-siswa" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>