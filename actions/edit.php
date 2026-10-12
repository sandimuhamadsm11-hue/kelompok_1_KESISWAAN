<?php
include "../config/koneksi.php";

$type = $_GET['type'] ?? '';
$id   = $_GET['id'] ?? '';
$error = "";

if (!$type || !$id) {
    header("Location: index.php");
    exit;
}

$safe_id = mysqli_real_escape_string($koneksi, $id);


// Proses Update Data saat Form Dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($type === 'siswa') {
        $id_siswa = mysqli_real_escape_string($koneksi, $_POST['id_siswa']);
        $nama     = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
        $jk       = mysqli_real_escape_string($koneksi, $_POST['jenis_kelamin']);
        $ttl      = mysqli_real_escape_string($koneksi, $_POST['tempat_tanggal_lahir']);
        $kelas    = mysqli_real_escape_string($koneksi, $_POST['kelas']);
        $jurusan  = mysqli_real_escape_string($koneksi, $_POST['jurusan']);
        $no_hp    = mysqli_real_escape_string($koneksi, $_POST['no_hp']);

        if (empty($nama) || empty($jk) || empty($ttl) || empty($kelas) || empty($jurusan)) {
            $error = "Semua kolom wajib diisi, kecuali No HP!";
        } elseif (!empty($no_hp) && (!is_numeric($no_hp) || strlen($no_hp) < 10 || strlen($no_hp) > 13)) {
            $error = "Nomor HP tidak valid! Harus berupa angka dengan panjang 10 sampai 13 digit.";
        } else {
            $query = "UPDATE data_siswa SET 
                        nama_lengkap='$nama', 
                        jenis_kelamin='$jk', 
                        tempat_tanggal_lahir='$ttl', 
                        kelas='$kelas', 
                        jurusan='$jurusan', 
                        no_hp='$no_hp' 
                      WHERE id_siswa='$id_siswa'";
        }
    } elseif ($type === 'ekskul') {
        $id_ekskul = mysqli_real_escape_string($koneksi, $_POST['id_ekstrakurikuler']);
        $nama      = mysqli_real_escape_string($koneksi, $_POST['nama_ekstrakurikuler']);
        $pembina   = mysqli_real_escape_string($koneksi, $_POST['nama_pembina']);
        $jadwal    = mysqli_real_escape_string($koneksi, $_POST['jadwal']);
        $tempat    = mysqli_real_escape_string($koneksi, $_POST['tempat']);

        if (empty($nama) || empty($pembina) || empty($jadwal) || empty($tempat)) {
            $error = "Semua kolom ekstrakurikuler wajib diisi!";
        } else {
            $query = "UPDATE data_ekstrakurikuler SET 
                        nama_ekstrakurikuler='$nama', 
                        nama_pembina='$pembina', 
                        jadwal='$jadwal', 
                        tempat='$tempat' 
                      WHERE id_ekstrakurikuler='$id_ekskul'";
        }
    } elseif ($type === 'pelanggaran') {
        $id_pelanggaran = mysqli_real_escape_string($koneksi, $_POST['id_pelanggaran']);
        $id_siswa       = mysqli_real_escape_string($koneksi, $_POST['id_siswa']);
        $tgl            = mysqli_real_escape_string($koneksi, $_POST['tanggal_kejadian']);
        $deskripsi      = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
        
        $point_input    = $_POST['point'];
        $point          = (int) preg_replace('/[^0-9]/', '', $point_input);
        
        $tindakan       = mysqli_real_escape_string($koneksi, $_POST['tindakan']);
        $guru_piket     = mysqli_real_escape_string($koneksi, $_POST['guru_piket']);

        if (empty($id_siswa) || empty($tgl) || empty($deskripsi) || empty($point_input) || empty($guru_piket)) {
            $error = "Semua kolom wajib diisi, kecuali Tindakan!";
        } elseif ($point <= 0) {
            $error = "Jumlah poin pelanggaran harus berupa angka yang valid (minimal 1)!";
        } else {
            $query = "UPDATE catatan_pelanggaran SET 
                        id_siswa='$id_siswa', 
                        tanggal_kejadian='$tgl', 
                        deskripsi='$deskripsi', 
                        point='$point', 
                        tindakan='$tindakan', 
                        guru_piket='$guru_piket' 
                      WHERE id_pelanggaran='$id_pelanggaran'";
        }
    } elseif ($type === 'prestasi') {
        $id_prestasi   = mysqli_real_escape_string($koneksi, $_POST['id_prestasi']);
        $id_siswa      = mysqli_real_escape_string($koneksi, $_POST['id_siswa']);
        $tgl           = mysqli_real_escape_string($koneksi, $_POST['tanggal_prestasi']);
        $jenis         = mysqli_real_escape_string($koneksi, $_POST['jenis_prestasi']);
        $nama          = mysqli_real_escape_string($koneksi, $_POST['nama_prestasi']);
        
        $peringkat_input = $_POST['peringkat'];
        $peringkat       = (int) preg_replace('/[^0-9]/', '', $peringkat_input);
        
        $penyelenggara = mysqli_real_escape_string($koneksi, $_POST['penyelenggara']);

        if (empty($id_siswa) || empty($tgl) || empty($jenis) || empty($nama) || empty($peringkat_input)) {
            $error = "Semua kolom wajib diisi, kecuali Penyelenggara!";
        } elseif ($peringkat <= 0) {
            $error = "Peringkat / Juara harus berupa angka yang valid (minimal 1)!";
        } else {
            $query = "UPDATE catatan_prestasi SET 
                        id_siswa='$id_siswa', 
                        tanggal_prestasi='$tgl', 
                        jenis_prestasi='$jenis', 
                        nama_prestasi='$nama', 
                        peringkat='$peringkat', 
                        penyelenggara='$penyelenggara' 
                      WHERE id_prestasi='$id_prestasi'";
        }
    }

    // Eksekusi Update jika tidak ada pesan error validasi
    if (empty($error) && isset($query)) {
        if (mysqli_query($koneksi, $query)) {
            header("Location: ../views/index.php#data-" . $type);
            exit;
        } else {
            $error = "Gagal memperbarui data: " . mysqli_error($koneksi);
        }
    }
}

// Fetch Data Berdasarkan Type dan ID untuk ditampilkan di form
$data = null;
if ($type === 'siswa') {
    $res = mysqli_query($koneksi, "SELECT * FROM data_siswa WHERE id_siswa='$safe_id'");
    $data = mysqli_fetch_assoc($res);
} elseif ($type === 'ekskul') {
    $res = mysqli_query($koneksi, "SELECT * FROM data_ekstrakurikuler WHERE id_ekstrakurikuler='$safe_id'");
    $data = mysqli_fetch_assoc($res);
} elseif ($type === 'pelanggaran') {
    $res = mysqli_query($koneksi, "SELECT * FROM catatan_pelanggaran WHERE id_pelanggaran='$safe_id'");
    $data = mysqli_fetch_assoc($res);
} elseif ($type === 'prestasi') {
    $res = mysqli_query($koneksi, "SELECT * FROM catatan_prestasi WHERE id_prestasi='$safe_id'");
    $data = mysqli_fetch_assoc($res);
}

if (!$data) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='../views/index.php';</script>";
    exit;
}

// Ambil list siswa untuk dropdown (jika tipe yang diedit memerlukan relasi siswa)
$siswa_list = mysqli_query($koneksi, "SELECT id_siswa, nama_lengkap FROM data_siswa");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data <?= ucfirst($type); ?> - SMKN 1 MAJA</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/style.css">
    <style>
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
    <div class="container" style="margin-top: 40px; max-width: 600px;">
        <h2><i class="fa-solid fa-pen-to-square"></i> Edit Data <?= ucfirst($type); ?></h2>
        
        <?php if (!empty($error)): ?>
            <div class="alert-error">
                <strong>Peringatan!</strong> <?= $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
            
            <?php if ($type === 'siswa'): ?>
                <input type="hidden" name="id_siswa" value="<?= htmlspecialchars($data['id_siswa']); ?>">
                <label>Nama Lengkap:</label>
                <input type="text" name="nama_lengkap" value="<?= htmlspecialchars($_POST['nama_lengkap'] ?? $data['nama_lengkap']); ?>" required style="width:100%; margin-bottom:10px; padding:8px;">
                
                <label>Jenis Kelamin:</label>
                <select name="jenis_kelamin" style="width:100%; margin-bottom:10px; padding:8px;" required>
                    <?php $jk_val = $_POST['jenis_kelamin'] ?? $data['jenis_kelamin']; ?>
                    <option value="L" <?= $jk_val === 'L' ? 'selected' : ''; ?>>Laki-laki (L)</option>
                    <option value="P" <?= $jk_val === 'P' ? 'selected' : ''; ?>>Perempuan (P)</option>
                </select>
                
                <label>TTL / Tanggal Lahir:</label>
                <input type="text" name="tempat_tanggal_lahir" value="<?= htmlspecialchars($_POST['tempat_tanggal_lahir'] ?? $data['tempat_tanggal_lahir']); ?>" required style="width:100%; margin-bottom:10px; padding:8px;">
                
                <label>Kelas:</label>
                <input type="text" name="kelas" value="<?= htmlspecialchars($_POST['kelas'] ?? $data['kelas']); ?>" required style="width:100%; margin-bottom:10px; padding:8px;">
                
                <label>Jurusan:</label>
                <input type="text" name="jurusan" value="<?= htmlspecialchars($_POST['jurusan'] ?? $data['jurusan']); ?>" required style="width:100%; margin-bottom:10px; padding:8px;">
                
                <label>No HP:</label>
                <input type="text" name="no_hp" value="<?= htmlspecialchars($_POST['no_hp'] ?? $data['no_hp']); ?>" style="width:100%; margin-bottom:10px; padding:8px;">

            <?php elseif ($type === 'ekskul'): ?>
                <input type="hidden" name="id_ekstrakurikuler" value="<?= htmlspecialchars($data['id_ekstrakurikuler']); ?>">
                <label>Nama Ekstrakurikuler:</label>
                <input type="text" name="nama_ekstrakurikuler" value="<?= htmlspecialchars($_POST['nama_ekstrakurikuler'] ?? $data['nama_ekstrakurikuler']); ?>" required style="width:100%; margin-bottom:10px; padding:8px;">
                
                <label>Pembina:</label>
                <input type="text" name="nama_pembina" value="<?= htmlspecialchars($_POST['nama_pembina'] ?? $data['nama_pembina']); ?>" required style="width:100%; margin-bottom:10px; padding:8px;">
                
                <label>Jadwal:</label>
                <input type="text" name="jadwal" value="<?= htmlspecialchars($_POST['jadwal'] ?? $data['jadwal']); ?>" required style="width:100%; margin-bottom:10px; padding:8px;">
                
                <label>Tempat:</label>
                <input type="text" name="tempat" value="<?= htmlspecialchars($_POST['tempat'] ?? $data['tempat']); ?>" required style="width:100%; margin-bottom:10px; padding:8px;">

            <?php elseif ($type === 'pelanggaran'): ?>
                <input type="hidden" name="id_pelanggaran" value="<?= htmlspecialchars($data['id_pelanggaran']); ?>">
                <label>Pilih Siswa:</label>
                <select name="id_siswa" style="width:100%; margin-bottom:10px; padding:8px;" required>
                    <option value="">-- Pilih Siswa --</option>
                    <?php 
                    $selected_siswa = $_POST['id_siswa'] ?? $data['id_siswa'];
                    mysqli_data_seek($siswa_list, 0);
                    while ($s = mysqli_fetch_assoc($siswa_list)): 
                    ?>
                        <option value="<?= $s['id_siswa']; ?>" <?= ($selected_siswa == $s['id_siswa']) ? 'selected' : ''; ?>>
                            <?= $s['id_siswa'] . ' - ' . $s['nama_lengkap']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
                
                <label>Tanggal Kejadian:</label>
                <input type="date" name="tanggal_kejadian" value="<?= htmlspecialchars($_POST['tanggal_kejadian'] ?? $data['tanggal_kejadian']); ?>" required style="width:100%; margin-bottom:10px; padding:8px;">
                
                <label>Deskripsi Pelanggaran:</label>
                <textarea name="deskripsi" required style="width:100%; margin-bottom:10px; padding:8px;" rows="3"><?= htmlspecialchars($_POST['deskripsi'] ?? $data['deskripsi']); ?></textarea>
                
                <label>Poin:</label>
                <input type="number" name="point" min="1" value="<?= htmlspecialchars($_POST['point'] ?? $data['point']); ?>" required style="width:100%; margin-bottom:10px; padding:8px;">
                
                <label>Tindakan:</label>
                <input type="text" name="tindakan" value="<?= htmlspecialchars($_POST['tindakan'] ?? $data['tindakan']); ?>" style="width:100%; margin-bottom:10px; padding:8px;">
                
                <label>Guru Piket / BK:</label>
                <input type="text" name="guru_piket" value="<?= htmlspecialchars($_POST['guru_piket'] ?? $data['guru_piket']); ?>" required style="width:100%; margin-bottom:10px; padding:8px;">

            <?php elseif ($type === 'prestasi'): ?>
                <input type="hidden" name="id_prestasi" value="<?= htmlspecialchars($data['id_prestasi']); ?>">
                <label>Pilih Siswa:</label>
                <select name="id_siswa" style="width:100%; margin-bottom:10px; padding:8px;" required>
                    <option value="">-- Pilih Siswa --</option>
                    <?php 
                    $selected_siswa = $_POST['id_siswa'] ?? $data['id_siswa'];
                    mysqli_data_seek($siswa_list, 0);
                    while ($s = mysqli_fetch_assoc($siswa_list)): 
                    ?>
                        <option value="<?= $s['id_siswa']; ?>" <?= ($selected_siswa == $s['id_siswa']) ? 'selected' : ''; ?>>
                            <?= $s['id_siswa'] . ' - ' . $s['nama_lengkap']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
                
                <label>Tanggal Prestasi:</label>
                <input type="date" name="tanggal_prestasi" value="<?= htmlspecialchars($_POST['tanggal_prestasi'] ?? $data['tanggal_prestasi']); ?>" required style="width:100%; margin-bottom:10px; padding:8px;">
                
                <label>Kategori Prestasi:</label>
                <select name="jenis_prestasi" style="width:100%; margin-bottom:10px; padding:8px;" required>
                    <?php $jenis_val = $_POST['jenis_prestasi'] ?? $data['jenis_prestasi']; ?>
                    <option value="Akademik / LKS" <?= ($jenis_val === 'Akademik / LKS') ? 'selected' : ''; ?>>Akademik / LKS</option>
                    <option value="Non-Akademik / Olahraga" <?= ($jenis_val === 'Non-Akademik / Olahraga') ? 'selected' : ''; ?>>Non-Akademik / Olahraga</option>
                    <option value="Seni & Budaya" <?= ($jenis_val === 'Seni & Budaya') ? 'selected' : ''; ?>>Seni & Budaya</option>
                    <option value="Sertifikasi Industri" <?= ($jenis_val === 'Sertifikasi Industri') ? 'selected' : ''; ?>>Sertifikasi Industri</option>
                </select>
                
                <label>Nama Kejuaraan / LKS:</label>
                <input type="text" name="nama_prestasi" value="<?= htmlspecialchars($_POST['nama_prestasi'] ?? $data['nama_prestasi']); ?>" required style="width:100%; margin-bottom:10px; padding:8px;">
                
                <label>Peringkat (Angka):</label>
                <input type="number" name="peringkat" min="1" value="<?= htmlspecialchars($_POST['peringkat'] ?? $data['peringkat']); ?>" required style="width:100%; margin-bottom:10px; padding:8px;">
                
                <label>Penyelenggara:</label>
                <input type="text" name="penyelenggara" value="<?= htmlspecialchars($_POST['penyelenggara'] ?? $data['penyelenggara']); ?>" style="width:100%; margin-bottom:10px; padding:8px;">
            <?php endif; ?>

            <div style="margin-top: 15px;">
                <button type="submit" class="btn-cta" style="border:none; cursor:pointer;">Simpan Perubahan</button>
                <a href="../views/index.php#data-<?= $type; ?>" style="margin-left: 10px; text-decoration:none; color:#555;">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>