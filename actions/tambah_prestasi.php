<?php
include "../config/koneksi.php";

$pesan_error = "";

// Ambil list siswa untuk pilihan dropdown
$siswa_list = mysqli_query($koneksi, "SELECT id_siswa, nama_lengkap FROM data_siswa");

if (isset($_POST['submit'])) {
    $id_prestasi        = mysqli_real_escape_string($koneksi, $_POST['id_prestasi']);
    $id_siswa           = mysqli_real_escape_string($koneksi, $_POST['id_siswa']);
    $tanggal_prestasi   = mysqli_real_escape_string($koneksi, $_POST['tanggal_prestasi']);
    $jenis_prestasi     = mysqli_real_escape_string($koneksi, $_POST['jenis_prestasi']);
    
    // Trim untuk membersihkan spasi berlebih
    $nama_prestasi      = trim($_POST['nama_prestasi']);
    
    $peringkat_input    = $_POST['peringkat'];
    $peringkat          = (int) preg_replace('/[^0-9]/', '', $peringkat_input);
    
    $penyelenggara      = mysqli_real_escape_string($koneksi, $_POST['penyelenggara']);

    // 1. Validasi Kolom Kosong
    if (empty($id_prestasi) || empty($id_siswa) || empty($tanggal_prestasi) || empty($jenis_prestasi) || empty($nama_prestasi) || empty($peringkat_input)) {
        $pesan_error = "Semua kolom wajib diisi!";
    } 
    // 2. Validasi Nama Kejuaraan / Perlombaan (Mencegah input asal-asalan)
    elseif (strlen($nama_prestasi) < 5) {
        $pesan_error = "Nama kejuaraan terlalu pendek! Minimal harus 5 karakter.";
    }
    elseif (count(explode(' ', preg_replace('/\s+/', ' ', $nama_prestasi))) < 2) {
        $pesan_error = "Nama kejuaraan tidak valid! Mohon masukkan nama kejuaraan yang benar (minimal terdiri dari 2 kata).";
    }
    elseif (is_numeric($nama_prestasi)) {
        $pesan_error = "Nama kejuaraan tidak boleh hanya berisi angka!";
    }
    // 3. Validasi Peringkat harus berupa angka positif
    elseif ($peringkat <= 0) {
        $pesan_error = "Peringkat / Juara harus berupa angka yang valid (minimal 1)!";
    } 
    // 4. Cek apakah ID Prestasi sudah terdaftar di database
    else {
        // Amankan string nama prestasi setelah lolos validasi
        $nama_prestasi_aman = mysqli_real_escape_string($koneksi, $nama_prestasi);

        $cek_id = mysqli_query($koneksi, "SELECT * FROM catatan_prestasi WHERE id_prestasi = '$id_prestasi'");
        if (mysqli_num_rows($cek_id) > 0) {
            $pesan_error = "Gagal: ID Prestasi '$id_prestasi' sudah terdaftar di database!";
        } else {
            // Jika lolos semua validasi, lakukan proses INSERT
            $query = "INSERT INTO catatan_prestasi (id_prestasi, id_siswa, tanggal_prestasi, jenis_prestasi, nama_prestasi, peringkat, penyelenggara) 
                      VALUES ('$id_prestasi', '$id_siswa', '$tanggal_prestasi', '$jenis_prestasi', '$nama_prestasi_aman', '$peringkat', '$penyelenggara')";

            if (mysqli_query($koneksi, $query)) {
                echo "<script>alert('Catatan Prestasi Berhasil Ditambahkan!'); window.location='../views/index.php#catatan-prestasi';</script>";
                exit;
            } else {
                $pesan_error = "Gagal menyimpan ke database: " . mysqli_error($koneksi);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Catatan Prestasi - SMKN 1 MAJA</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        /* Desain alert error */
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px 15px;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="form-card">
        <h2>Tambah Catatan Prestasi Siswa</h2>

        <!-- Tampilkan Pesan Error Jika Ada -->
        <?php if (!empty($pesan_error)) : ?>
            <div class="alert-error">
                <strong>Peringatan!</strong> <?= $pesan_error; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label>ID Prestasi</label>
                <input type="text" name="id_prestasi" required placeholder="Contoh: PRS001" value="<?= isset($_POST['id_prestasi']) ? htmlspecialchars($_POST['id_prestasi']) : ''; ?>">
            </div>

            <div class="form-group">
                <label>Pilih Siswa</label>
                <select name="id_siswa" required>
                    <option value="">-- Pilih Siswa --</option>
                    <?php 
                    mysqli_data_seek($siswa_list, 0);
                    while ($s = mysqli_fetch_assoc($siswa_list)): 
                        $selected = (isset($_POST['id_siswa']) && $_POST['id_siswa'] == $s['id_siswa']) ? 'selected' : '';
                    ?>
                        <option value="<?= $s['id_siswa']; ?>" <?= $selected; ?>>
                            <?= $s['id_siswa'] . ' - ' . $s['nama_lengkap']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label>Tanggal Prestasi / Kejuaraan</label>
                <input type="date" name="tanggal_prestasi" value="<?= isset($_POST['tanggal_prestasi']) ? htmlspecialchars($_POST['tanggal_prestasi']) : date('Y-m-d'); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Kategori / Jenis Prestasi</label>
                <select name="jenis_prestasi" required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="Akademik / LKS" <?= (isset($_POST['jenis_prestasi']) && $_POST['jenis_prestasi'] == 'Akademik / LKS') ? 'selected' : ''; ?>>Akademik / LKS</option>
                    <option value="Non-Akademik / Olahraga" <?= (isset($_POST['jenis_prestasi']) && $_POST['jenis_prestasi'] == 'Non-Akademik / Olahraga') ? 'selected' : ''; ?>>Non-Akademik / Olahraga</option>
                    <option value="Seni & Budaya" <?= (isset($_POST['jenis_prestasi']) && $_POST['jenis_prestasi'] == 'Seni & Budaya') ? 'selected' : ''; ?>>Seni & Budaya</option>
                    <option value="Sertifikasi Industri" <?= (isset($_POST['jenis_prestasi']) && $_POST['jenis_prestasi'] == 'Sertifikasi Industri') ? 'selected' : ''; ?>>Sertifikasi Industri</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Nama Kejuaraan / Perlombaan</label>
                <!-- Tambahan minlength untuk HTML5 -->
                <input type="text" name="nama_prestasi" required minlength="5" placeholder="Contoh: LKS Web Technologies Tingkat Provinsi" value="<?= isset($_POST['nama_prestasi']) ? htmlspecialchars($_POST['nama_prestasi']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label>Peringkat / Juara (Masukkan Angka)</label>
                <input type="number" name="peringkat" min="1" required placeholder="Contoh: 1 (untuk Juara 1)" value="<?= isset($_POST['peringkat']) ? htmlspecialchars($_POST['peringkat']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label>Penyelenggara / Institusi</label>
                <input type="text" name="penyelenggara" placeholder="Contoh: Disdik Provinsi / Kemendikbud" value="<?= isset($_POST['penyelenggara']) ? htmlspecialchars($_POST['penyelenggara']) : ''; ?>">
            </div>
            
            <div class="btn-group">
                <button type="submit" name="submit" class="btn-save">Simpan Prestasi</button>
                <a href="../views/index.php#catatan-prestasi" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>