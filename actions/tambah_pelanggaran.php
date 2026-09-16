<?php
include "../config/koneksi.php";

// Ambil list siswa untuk dropdown pilihan ID Siswa
$siswa_list = mysqli_query($koneksi, "SELECT id_siswa, nama_lengkap FROM data_siswa");

if (isset($_POST['submit'])) {
    $id_pelanggaran  = mysqli_real_escape_string($koneksi, $_POST['id_pelanggaran']);
    $id_siswa        = mysqli_real_escape_string($koneksi, $_POST['id_siswa']);
    $tanggal_kejadian = mysqli_real_escape_string($koneksi, $_POST['tanggal_kejadian']);
    $deskripsi       = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $point           = mysqli_real_escape_string($koneksi, $_POST['point']);
    $tindakan        = mysqli_real_escape_string($koneksi, $_POST['tindakan']);
    $guru_piket      = mysqli_real_escape_string($koneksi, $_POST['guru_piket']);

    // Menambahkan id_pelanggaran ke dalam query INSERT
    $query = "INSERT INTO catatan_pelanggaran (id_pelanggaran, id_siswa, tanggal_kejadian, deskripsi, point, tindakan, guru_piket) 
              VALUES ('$id_pelanggaran', '$id_siswa', '$tanggal_kejadian', '$deskripsi', '$point', '$tindakan', '$guru_piket')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Catatan Pelanggaran Berhasil Ditambahkan!'); window.location='../views/index.php#catatan-pelanggaran';</script>";
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
    <title>Tambah Catatan Pelanggaran - SMKN 1 MAJA</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="form-card">
        <h2>Tambah Catatan Kedisiplinan</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label>ID Pelanggaran</label>
                <input type="text" name="id_pelanggaran" required placeholder="Contoh: PLG001">
            </div>

            <div class="form-group">
                <label>Pilih Siswa</label>
                <select name="id_siswa" required>
                    <option value="">-- Pilih Siswa --</option>
                    <?php while ($s = mysqli_fetch_assoc($siswa_list)): ?>
                        <option value="<?= $s['id_siswa']; ?>"><?= $s['id_siswa']; ?> - <?= $s['nama_lengkap']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label>Tanggal Kejadian</label>
                <input type="date" name="tanggal_kejadian" required>
            </div>
            
            <div class="form-group">
                <label>Deskripsi Pelanggaran</label>
                <textarea name="deskripsi" rows="3" required placeholder="Rincian pelanggaran yang dilakukan"></textarea>
            </div>
            
            <div class="form-group">
                <label>Jumlah Poin Pelanggaran</label>
                <input type="number" name="point" required placeholder="Contoh: 10">
            </div>
            
            <div class="form-group">
                <label>Tindakan / Pembinaan</label>
                <input type="text" name="tindakan" placeholder="Contoh: Pemanggilan Orang Tua / Teguran lisan">
            </div>
            
            <div class="form-group">
                <label>Guru Piket / Pembina BK</label>
                <input type="text" name="guru_piket" required placeholder="Nama Guru Penindak">
            </div>
            
            <div class="btn-group">
                <button type="submit" name="submit" class="btn-save">Simpan Catatan</button>
                <a href="../views/index.php#catatan-pelanggaran" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>