<?php
include "../config/koneksi.php";

$pesan_error = "";
$sukses = false;

if (isset($_POST['submit'])) {
    // Ambil dan bersihkan data input
    $id_siswa = mysqli_real_escape_string($koneksi, $_POST['id_siswa']);
    $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $jenis_kelamin = mysqli_real_escape_string($koneksi, $_POST['jenis_kelamin']);
    $tempat_tanggal_lahir = mysqli_real_escape_string($koneksi, $_POST['tanggal_lahir']);
    $kelas = mysqli_real_escape_string($koneksi, $_POST['kelas']);
    $jurusan = mysqli_real_escape_string($koneksi, $_POST['jurusan']);
    $no_hp = mysqli_real_escape_string($koneksi, $_POST['no_hp']);

    // 1. Validasi Kolom Kosong
    if (empty($id_siswa) || empty($nama_lengkap) || empty($jenis_kelamin) || empty($tempat_tanggal_lahir) || empty($kelas) || empty($jurusan)) {
        $pesan_error = "Semua kolom wajib diisi, kecuali No HP!";
    } 
    // 2. Validasi Format No HP (jika diisi, harus angka dan panjang minimal 10-13 digit)
    elseif (!empty($no_hp) && (!is_numeric($no_hp) || strlen($no_hp) < 10 || strlen($no_hp) > 13)) {
        $pesan_error = "Nomor HP tidak valid! Harus berupa angka dengan panjang antara 10 sampai 13 digit.";
    } 
    // 3. Cek apakah ID Siswa / NISN sudah terdaftar di database
    else {
        $cek_id = mysqli_query($koneksi, "SELECT * FROM data_siswa WHERE id_siswa = '$id_siswa'");
        if (mysqli_num_rows($cek_id) > 0) {
            $pesan_error = "Gagal: ID Siswa / NISN '$id_siswa' sudah terdaftar di database!";
        } else {
            // Jika lolos semua validasi, lakukan proses INSERT
            $query = "INSERT INTO data_siswa (id_siswa, nama_lengkap, jenis_kelamin, tempat_tanggal_lahir, kelas, jurusan, no_hp) 
                      VALUES ('$id_siswa', '$nama_lengkap', '$jenis_kelamin', '$tempat_tanggal_lahir', '$kelas', '$jurusan', '$no_hp')";

            if (mysqli_query($koneksi, $query)) {
                echo "<script>alert('Data Siswa Berhasil Ditambahkan!'); window.location='../views/index.php#data-siswa';</script>";
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
    <title>Tambah Data Siswa - SMKN 1 MAJA</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        /* Tambahan CSS sederhana untuk pesan error */
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
        <h2>Tambah Data Siswa</h2>

        <!-- Tampilkan Pesan Error Jika Ada -->
        <?php if (!empty($pesan_error)) : ?>
            <div class="alert-error">
                <strong>Peringatan!</strong> <?= $pesan_error; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label>ID Siswa / NISN</label>
                <input type="text" name="id_siswa" required placeholder="Contoh: 10245" value="<?= isset($_POST['id_siswa']) ? htmlspecialchars($_POST['id_siswa']) : ''; ?>">
            </div>
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama_lengkap" required placeholder="Nama Lengkap Siswa" value="<?= isset($_POST['nama_lengkap']) ? htmlspecialchars($_POST['nama_lengkap']) : ''; ?>">
            </div>
            <div class="form-group">
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin" required>
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="L" <?= (isset($_POST['jenis_kelamin']) && $_POST['jenis_kelamin'] == 'L') ? 'selected' : ''; ?>>Laki-laki (L)</option>
                    <option value="P" <?= (isset($_POST['jenis_kelamin']) && $_POST['jenis_kelamin'] == 'P') ? 'selected' : ''; ?>>Perempuan (P)</option>
                </select>
            </div>
            <div class="form-group">
                <label>Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" required value="<?= isset($_POST['tanggal_lahir']) ? htmlspecialchars($_POST['tanggal_lahir']) : ''; ?>">
            </div>
            <div class="form-group">
                <label>Kelas</label>
                <input type="text" name="kelas" required placeholder="Contoh: XI RPL 1" value="<?= isset($_POST['kelas']) ? htmlspecialchars($_POST['kelas']) : ''; ?>">
            </div>
            <div class="form-group">
                <label>Jurusan / Konsentrasi Keahlian</label>
                <input type="text" name="jurusan" required placeholder="Contoh: Rekayasa Perangkat Lunak" value="<?= isset($_POST['jurusan']) ? htmlspecialchars($_POST['jurusan']) : ''; ?>">
            </div>
            <div class="form-group">
                <label>No HP / WhatsApp</label>
                <input type="text" name="no_hp" placeholder="Contoh: 08123456789" value="<?= isset($_POST['no_hp']) ? htmlspecialchars($_POST['no_hp']) : ''; ?>">
            </div>
            <div class="btn-group">
                <button type="submit" name="submit" class="btn-save">Simpan Data</button>
                <a href="../views/index.php#data-siswa" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>