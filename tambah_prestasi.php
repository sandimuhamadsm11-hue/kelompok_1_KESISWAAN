<?php
include "koneksi.php";

// Ambil list siswa untuk pilihan dropdown
$siswa_list = mysqli_query($koneksi, "SELECT id_siswa, nama_lengkap FROM data_siswa");

if (isset($_POST['submit'])) {
    $id_prestasi      = mysqli_real_escape_string($koneksi, $_POST['id_prestasi']);
    $id_siswa         = mysqli_real_escape_string($koneksi, $_POST['id_siswa']);
    $tanggal_prestasi = mysqli_real_escape_string($koneksi, $_POST['tanggal_prestasi']);
    $jenis_prestasi   = mysqli_real_escape_string($koneksi, $_POST['jenis_prestasi']);
    $nama_prestasi    = mysqli_real_escape_string($koneksi, $_POST['nama_prestasi']);
    
    // Pastikan input peringkat berupa angka jika database bertipe INT
    // Mengambil hanya karakter angka dari input
    $peringkat_input  = $_POST['peringkat'];
    $peringkat        = (int) preg_replace('/[^0-9]/', '', $peringkat_input);
    
    // Jika input tidak mengandung angka sama sekali, beri nilai default 0
    if ($peringkat === 0 && !empty($peringkat_input) && $peringkat_input !== '0') {
        $peringkat = 0; 
    }

    $penyelenggara    = mysqli_real_escape_string($koneksi, $_POST['penyelenggara']);

    // Menambahkan id_prestasi ke dalam query INSERT
    $query = "INSERT INTO catatan_prestasi (id_prestasi, id_siswa, tanggal_prestasi, jenis_prestasi, nama_prestasi, peringkat, penyelenggara) 
              VALUES ('$id_prestasi', '$id_siswa', '$tanggal_prestasi', '$jenis_prestasi', '$nama_prestasi', '$peringkat', '$penyelenggara')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Catatan Prestasi Berhasil Ditambahkan!'); window.location='index.php#catatan-prestasi';</script>";
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
    <title>Tambah Catatan Prestasi - SMKN 1 MAJA</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f8fafc; padding: 40px 20px; color: #334155; }
        .form-card { max-width: 600px; background: #fff; margin: 0 auto; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); border-top: 4px solid #10b981; }
        h2 { margin-bottom: 20px; color: #0f172a; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: 600; font-size: 0.9rem; }
        input, select { width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 5px; font-size: 0.9rem; box-sizing: border-box; }
        .btn-group { display: flex; gap: 10px; margin-top: 20px; }
        .btn-save { background: #10b981; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-weight: 600; }
        .btn-cancel { background: #64748b; color: white; border: none; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-size: 0.9rem; text-align: center; }
        .btn-save:hover { background: #059669; }
    </style>
</head>
<body>
    <div class="form-card">
        <h2>Tambah Catatan Prestasi Siswa</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label>ID Prestasi</label>
                <input type="text" name="id_prestasi" required placeholder="Contoh: PRS001">
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
                <label>Tanggal Prestasi / Kejuaraan</label>
                <input type="date" name="tanggal_prestasi" value="<?= date('Y-m-d'); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Kategori / Jenis Prestasi</label>
                <select name="jenis_prestasi" required>
                    <option value="Akademik / LKS">Akademik / LKS</option>
                    <option value="Non-Akademik / Olahraga">Non-Akademik / Olahraga</option>
                    <option value="Seni & Budaya">Seni & Budaya</option>
                    <option value="Sertifikasi Industri">Sertifikasi Industri</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Nama Kejuaraan / Perlombaan</label>
                <input type="text" name="nama_prestasi" required placeholder="Contoh: LKS Web Technologies Tingkat Provinsi">
            </div>
            
            <div class="form-group">
                <label>Peringkat / Juara (Masukkan Angka)</label>
                <input type="number" name="peringkat" min="1" required placeholder="Contoh: 1 (untuk Juara 1)">
            </div>
            
            <div class="form-group">
                <label>Penyelenggara / Institusi</label>
                <input type="text" name="penyelenggara" placeholder="Contoh: Disdik Provinsi / Kemendikbud">
            </div>
            
            <div class="btn-group">
                <button type="submit" name="submit" class="btn-save">Simpan Prestasi</button>
                <a href="index.php#catatan-prestasi" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>