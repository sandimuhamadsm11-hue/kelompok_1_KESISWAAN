<?php
include "../config/koneksi.php";

$pesan_error = "";

// Ambil list siswa untuk dropdown pilihan ID Siswa
$siswa_list = mysqli_query($koneksi, "SELECT id_siswa, nama_lengkap FROM data_siswa");

if (isset($_POST['submit'])) {
    $id_pelanggaran    = mysqli_real_escape_string($koneksi, $_POST['id_pelanggaran']);
    $id_siswa          = mysqli_real_escape_string($koneksi, $_POST['id_siswa']);
    $tanggal_kejadian  = mysqli_real_escape_string($koneksi, $_POST['tanggal_kejadian']);
    $deskripsi         = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    
    $point_input       = $_POST['point'];
    $point             = (int) preg_replace('/[^0-9]/', '', $point_input);
    
    $tindakan          = mysqli_real_escape_string($koneksi, $_POST['tindakan']);
    $guru_piket        = mysqli_real_escape_string($koneksi, $_POST['guru_piket']);

    // 1. Validasi Kolom Kosong
    if (empty($id_pelanggaran) || empty($id_siswa) || empty($tanggal_kejadian) || empty($deskripsi) || empty($point_input) || empty($guru_piket)) {
        $pesan_error = "Semua kolom wajib diisi, kecuali Tindakan / Pembinaan!";
    } 
    // 2. Validasi Point harus berupa angka positif
    elseif ($point <= 0) {
        $pesan_error = "Jumlah poin pelanggaran harus berupa angka yang valid (minimal 1)!";
    } 
    // 3. Cek apakah ID Pelanggaran sudah terdaftar di database
    else {
        $cek_id = mysqli_query($koneksi, "SELECT * FROM catatan_pelanggaran WHERE id_pelanggaran = '$id_pelanggaran'");
        if (mysqli_num_rows($cek_id) > 0) {
            $pesan_error = "Gagal: ID Pelanggaran '$id_pelanggaran' sudah terdaftar di database!";
        } else {
            // Jika lolos semua validasi, lakukan proses INSERT
            $query = "INSERT INTO catatan_pelanggaran (id_pelanggaran, id_siswa, tanggal_kejadian, deskripsi, point, tindakan, guru_piket) 
                      VALUES ('$id_pelanggaran', '$id_siswa', '$tanggal_kejadian', '$deskripsi', '$point', '$tindakan', '$guru_piket')";

            if (mysqli_query($koneksi, $query)) {
                echo "<script>alert('Catatan Pelanggaran Berhasil Ditambahkan!'); window.location='../views/index.php#catatan-pelanggaran';</script>";
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
    <title>Tambah Catatan Pelanggaran - SMKN 1 MAJA</title>
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
        <h2>Tambah Catatan Kedisiplinan</h2>

        <!-- Tampilkan Pesan Error Jika Ada -->
        <?php if (!empty($pesan_error)) : ?>
            <div class="alert-error">
                <strong>Peringatan!</strong> <?= $pesan_error; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label>ID Pelanggaran</label>
                <input type="text" name="id_pelanggaran" required placeholder="Contoh: PLG001" value="<?= isset($_POST['id_pelanggaran']) ? htmlspecialchars($_POST['id_pelanggaran']) : ''; ?>">
            </div>

            <div class="form-group">
                <label>Pilih Siswa</label>
                <select name="id_siswa" required>
                    <option value="">-- Pilih Siswa --</option>
                    <?php 
                    // Reset pointer query siswa agar dropdown terbaca dengan benar
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
                <label>Tanggal Kejadian</label>
                <input type="date" name="tanggal_kejadian" required value="<?= isset($_POST['tanggal_kejadian']) ? htmlspecialchars($_POST['tanggal_kejadian']) : date('Y-m-d'); ?>">
            </div>
            
            <div class="form-group">
                <label>Deskripsi Pelanggaran</label>
                <textarea name="deskripsi" rows="3" required placeholder="Rincian pelanggaran yang dilakukan"><?= isset($_POST['deskripsi']) ? htmlspecialchars($_POST['deskripsi']) : ''; ?></textarea>
            </div>
            
            <div class="form-group">
                <label>Jumlah Poin Pelanggaran</label>
                <input type="number" name="point" min="1" required placeholder="Contoh: 10" value="<?= isset($_POST['point']) ? htmlspecialchars($_POST['point']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label>Tindakan / Pembinaan</label>
                <input type="text" name="tindakan" placeholder="Contoh: Pemanggilan Orang Tua / Teguran lisan" value="<?= isset($_POST['tindakan']) ? htmlspecialchars($_POST['tindakan']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label>Guru Piket / Pembina BK</label>
                <input type="text" name="guru_piket" required placeholder="Nama Guru Penindak" value="<?= isset($_POST['guru_piket']) ? htmlspecialchars($_POST['guru_piket']) : ''; ?>">
            </div>
            
            <div class="btn-group">
                <button type="submit" name="submit" class="btn-save">Simpan Catatan</button>
                <a href="../views/index.php#catatan-pelanggaran" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>