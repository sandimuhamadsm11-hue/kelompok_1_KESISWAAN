<?php
include "../config/koneksi.php";

$type = $_GET['type'] ?? '';
$id   = $_GET['id'] ?? '';

if (!$type || !$id) {
    header("Location: index.php");
    exit;
}

// Proses Update Data saat Form Dikirrim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($type === 'siswa') {
        $id_siswa = mysqli_real_escape_string($koneksi, $_POST['id_siswa']);
        $nama     = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
        $jk       = mysqli_real_escape_string($koneksi, $_POST['jenis_kelamin']);
        $ttl      = mysqli_real_escape_string($koneksi, $_POST['tempat_tanggal_lahir']);
        $kelas    = mysqli_real_escape_string($koneksi, $_POST['kelas']);
        $jurusan  = mysqli_real_escape_string($koneksi, $_POST['jurusan']);
        $no_hp    = mysqli_real_escape_string($koneksi, $_POST['no_hp']);

        $query = "UPDATE data_siswa SET 
                    nama_lengkap='$nama', 
                    jenis_kelamin='$jk', 
                    tempat_tanggal_lahir='$ttl', 
                    kelas='$kelas', 
                    jurusan='$jurusan', 
                    no_hp='$no_hp' 
                  WHERE id_siswa='$id_siswa'";
    } elseif ($type === 'ekskul') {
        $id_ekskul = mysqli_real_escape_string($koneksi, $_POST['id_ekstrakurikuler']);
        $nama      = mysqli_real_escape_string($koneksi, $_POST['nama_ekstrakurikuler']);
        $pembina   = mysqli_real_escape_string($koneksi, $_POST['nama_pembina']);
        $jadwal    = mysqli_real_escape_string($koneksi, $_POST['jadwal']);
        $tempat    = mysqli_real_escape_string($koneksi, $_POST['tempat']);

        $query = "UPDATE data_ekstrakurikuler SET 
                    nama_ekstrakurikuler='$nama', 
                    nama_pembina='$pembina', 
                    jadwal='$jadwal', 
                    tempat='$tempat' 
                  WHERE id_ekstrakurikuler='$id_ekskul'";
    } elseif ($type === 'pelanggaran') {
        $id_pelanggaran = mysqli_real_escape_string($koneksi, $_POST['id_pelanggaran']);
        $id_siswa       = mysqli_real_escape_string($koneksi, $_POST['id_siswa']);
        $tgl            = mysqli_real_escape_string($koneksi, $_POST['tanggal_kejadian']);
        $deskripsi      = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
        $point          = mysqli_real_escape_string($koneksi, $_POST['point']);
        $tindakan       = mysqli_real_escape_string($koneksi, $_POST['tindakan']);
        $guru_piket     = mysqli_real_escape_string($koneksi, $_POST['guru_piket']);

        $query = "UPDATE catatan_pelanggaran SET 
                    id_siswa='$id_siswa', 
                    tanggal_kejadian='$tgl', 
                    deskripsi='$deskripsi', 
                    point='$point', 
                    tindakan='$tindakan', 
                    guru_piket='$guru_piket' 
                  WHERE id_pelanggaran='$id_pelanggaran'";
    } elseif ($type === 'prestasi') {
        $id_prestasi = mysqli_real_escape_string($koneksi, $_POST['id_prestasi']);
        $id_siswa    = mysqli_real_escape_string($koneksi, $_POST['id_siswa']);
        $tgl         = mysqli_real_escape_string($koneksi, $_POST['tanggal_prestasi']);
        $jenis       = mysqli_real_escape_string($koneksi, $_POST['jenis_prestasi']);
        $nama        = mysqli_real_escape_string($koneksi, $_POST['nama_prestasi']);
        $peringkat   = mysqli_real_escape_string($koneksi, $_POST['peringkat']);
        $penyelenggara = mysqli_real_escape_string($koneksi, $_POST['penyelenggara']);

        $query = "UPDATE catatan_prestasi SET 
                    id_siswa='$id_siswa', 
                    tanggal_prestasi='$tgl', 
                    jenis_prestasi='$jenis', 
                    nama_prestasi='$nama', 
                    peringkat='$peringkat', 
                    penyelenggara='$penyelenggara' 
                  WHERE id_prestasi='$id_prestasi'";
    }

    if (isset($query) && mysqli_query($koneksi, $query)) {
        header("Location: ../views/index.php#data-" . $type);
        exit;
    } else {
        $error = "Gagal memperbarui data: " . mysqli_error($koneksi);
    }
}

// Fetch Data Berdasarkan Type dan ID
$data = null;
$safe_id = mysqli_real_escape_string($koneksi, $id);

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
    echo "Data tidak ditemukan!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data <?= ucfirst($type); ?> - SMKN 1 MAJA</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="container" style="margin-top: 40px; max-width: 600px;">
        <h2><i class="fa-solid fa-pen-to-square"></i> Edit Data <?= ucfirst($type); ?></h2>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?= $error; ?></p>
        <?php endif; ?>

        <form method="POST" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
            
            <?php if ($type === 'siswa'): ?>
                <input type="hidden" name="id_siswa" value="<?= htmlspecialchars($data['id_siswa']); ?>">
                <label>Nama Lengkap:</label>
                <input type="text" name="nama_lengkap" value="<?= htmlspecialchars($data['nama_lengkap']); ?>" required style="width:100%; margin-bottom:10px; padding:8px;">
                
                <label>Jenis Kelamin:</label>
                <select name="jenis_kelamin" style="width:100%; margin-bottom:10px; padding:8px;">
                    <option value="L" <?= $data['jenis_kelamin'] === 'L' ? 'selected' : ''; ?>>Laki-laki</option>
                    <option value="P" <?= $data['jenis_kelamin'] === 'P' ? 'selected' : ''; ?>>Perempuan</option>
                </select>
                
                <label>TTL:</label>
                <input type="text" name="tempat_tanggal_lahir" value="<?= htmlspecialchars($data['tempat_tanggal_lahir']); ?>" required style="width:100%; margin-bottom:10px; padding:8px;">
                
                <label>Kelas:</label>
                <input type="text" name="kelas" value="<?= htmlspecialchars($data['kelas']); ?>" required style="width:100%; margin-bottom:10px; padding:8px;">
                
                <label>Jurusan:</label>
                <input type="text" name="jurusan" value="<?= htmlspecialchars($data['jurusan']); ?>" required style="width:100%; margin-bottom:10px; padding:8px;">
                
                <label>No HP:</label>
                <input type="text" name="no_hp" value="<?= htmlspecialchars($data['no_hp']); ?>" required style="width:100%; margin-bottom:10px; padding:8px;">

            <?php elseif ($type === 'ekskul'): ?>
                <input type="hidden" name="id_ekstrakurikuler" value="<?= htmlspecialchars($data['id_ekstrakurikuler']); ?>">
                <label>Nama Ekstrakurikuler:</label>
                <input type="text" name="nama_ekstrakurikuler" value="<?= htmlspecialchars($data['nama_ekstrakurikuler']); ?>" required style="width:100%; margin-bottom:10px; padding:8px;">
                
                <label>Pembina:</label>
                <input type="text" name="nama_pembina" value="<?= htmlspecialchars($data['nama_pembina']); ?>" required style="width:100%; margin-bottom:10px; padding:8px;">
                
                <label>Jadwal:</label>
                <input type="text" name="jadwal" value="<?= htmlspecialchars($data['jadwal']); ?>" required style="width:100%; margin-bottom:10px; padding:8px;">
                
                <label>Tempat:</label>
                <input type="text" name="tempat" value="<?= htmlspecialchars($data['tempat']); ?>" required style="width:100%; margin-bottom:10px; padding:8px;">

            <?php elseif ($type === 'pelanggaran'): ?>
                <input type="hidden" name="id_pelanggaran" value="<?= htmlspecialchars($data['id_pelanggaran']); ?>">
                <label>ID Siswa:</label>
                <input type="text" name="id_siswa" value="<?= htmlspecialchars($data['id_siswa']); ?>" required style="width:100%; margin-bottom:10px; padding:8px;">
                
                <label>Tanggal Kejadian:</label>
                <input type="date" name="tanggal_kejadian" value="<?= htmlspecialchars($data['tanggal_kejadian']); ?>" required style="width:100%; margin-bottom:10px; padding:8px;">
                
                <label>Deskripsi Pelanggaran:</label>
                <textarea name="deskripsi" required style="width:100%; margin-bottom:10px; padding:8px;"><?= htmlspecialchars($data['deskripsi']); ?></textarea>
                
                <label>Poin:</label>
                <input type="number" name="point" value="<?= htmlspecialchars($data['point']); ?>" required style="width:100%; margin-bottom:10px; padding:8px;">
                
                <label>Tindakan:</label>
                <input type="text" name="tindakan" value="<?= htmlspecialchars($data['tindakan']); ?>" required style="width:100%; margin-bottom:10px; padding:8px;">
                
                <label>Guru Piket / BK:</label>
                <input type="text" name="guru_piket" value="<?= htmlspecialchars($data['guru_piket']); ?>" required style="width:100%; margin-bottom:10px; padding:8px;">

            <?php elseif ($type === 'prestasi'): ?>
                <input type="hidden" name="id_prestasi" value="<?= htmlspecialchars($data['id_prestasi']); ?>">
                <label>ID Siswa:</label>
                <input type="text" name="id_siswa" value="<?= htmlspecialchars($data['id_siswa']); ?>" required style="width:100%; margin-bottom:10px; padding:8px;">
                
                <label>Tanggal Prestasi:</label>
                <input type="date" name="tanggal_prestasi" value="<?= htmlspecialchars($data['tanggal_prestasi']); ?>" required style="width:100%; margin-bottom:10px; padding:8px;">
                
                <label>Kategori Prestasi:</label>
                <input type="text" name="jenis_prestasi" value="<?= htmlspecialchars($data['jenis_prestasi']); ?>" required style="width:100%; margin-bottom:10px; padding:8px;">
                
                <label>Nama Kejuaraan / LKS:</label>
                <input type="text" name="nama_prestasi" value="<?= htmlspecialchars($data['nama_prestasi']); ?>" required style="width:100%; margin-bottom:10px; padding:8px;">
                
                <label>Peringkat:</label>
                <input type="text" name="peringkat" value="<?= htmlspecialchars($data['peringkat']); ?>" required style="width:100%; margin-bottom:10px; padding:8px;">
                
                <label>Penyelenggara:</label>
                <input type="text" name="penyelenggara" value="<?= htmlspecialchars($data['penyelenggara']); ?>" required style="width:100%; margin-bottom:10px; padding:8px;">
            <?php endif; ?>

            <div style="margin-top: 15px;">
                <button type="submit" class="btn-cta" style="border:none; cursor:pointer;">Simpan Perubahan</button>
                <a href="../views/index.php" style="margin-left: 10px; text-decoration:none; color:#555;">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>