<?php
include "koneksi.php";

// Fetch Data dari Database
$data_siswa       = mysqli_fetch_all(mysqli_query($koneksi, "SELECT * FROM data_siswa"), MYSQLI_ASSOC);
$data_ekskul      = mysqli_fetch_all(mysqli_query($koneksi, "SELECT * FROM data_ekstrakurikuler"), MYSQLI_ASSOC);
$data_pelanggaran = mysqli_fetch_all(mysqli_query($koneksi, "SELECT * FROM catatan_pelanggaran"), MYSQLI_ASSOC);
$data_prestasi    = mysqli_fetch_all(mysqli_query($koneksi, "SELECT * FROM catatan_prestasi"), MYSQLI_ASSOC);

// Helper function untuk format tanggal Indonesia
function format_tanggal($tanggal) {
    if (!$tanggal || $tanggal == '0000-00-00') return '-';
    return date('d/m/Y', strtotime($tanggal));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Kesiswaan SMK NEGERI 1 MAJA</title>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background-color: #f8fafc;
            color: #334155;
        }

        /* Navbar Style */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            background-color: #0f172a;
            padding: 15px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.15);
            z-index: 1000;
        }

        .navbar .logo {
            color: #fff;
            font-size: 1.1rem;
            font-weight: bold;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-links {
            list-style: none;
            display: flex;
            gap: 20px;
        }

        .nav-links a {
            color: #cbd5e1;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: #38bdf8;
        }

        /* Hero Section */
        .hero {
            min-height: 55vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 110px 20px 50px;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #fff;
        }

        .hero h1 {
            font-size: 2.2rem;
            margin-bottom: 15px;
        }

        .hero p {
            font-size: 1rem;
            color: #94a3b8;
            max-width: 650px;
            margin-bottom: 25px;
            line-height: 1.6;
        }

        .btn-cta {
            background-color: #0284c7;
            color: #fff;
            padding: 10px 24px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.3s;
        }

        .btn-cta:hover {
            background-color: #0369a1;
        }

        /* Container Layout */
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        /* Section Kartu Statistik */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 50px;
        }

        .stat-card {
            background: #fff;
            padding: 22px;
            border-radius: 10px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
            border-top: 4px solid #0284c7;
            text-align: center;
        }

        .stat-card h3 {
            font-size: 2rem;
            color: #0f172a;
            margin-bottom: 5px;
        }

        .stat-card p {
            color: #64748b;
            font-size: 0.9rem;
        }

        /* Card Tabel Header Flex */
        .card-table {
            background: #fff;
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 50px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.08);
        }

        .card-header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .card-table h2 {
            font-size: 1.3rem;
            color: #0f172a;
            border-left: 4px solid #0284c7;
            padding-left: 12px;
        }

        .btn-add {
            background-color: #10b981;
            color: #fff;
            padding: 8px 16px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            transition: background 0.3s;
        }

        .btn-add:hover {
            background-color: #059669;
        }

        .table-responsive {
            overflow-x: auto;
        }

        /* Styling Table */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.88rem;
        }

        th {
            background-color: #f1f5f9;
            color: #334155;
            text-align: left;
            padding: 12px 14px;
            font-weight: 600;
            border-bottom: 2px solid #e2e8f0;
        }

        td {
            padding: 12px 14px;
            border-bottom: 1px solid #e2e8f0;
            color: #475569;
        }

        tr:hover {
            background-color: #f8fafc;
        }

        /* Action Buttons */
        .btn-action {
            display: inline-block;
            padding: 5px 10px;
            font-size: 0.78rem;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 500;
        }

        .btn-edit {
            background-color: #eab308;
            color: #fff;
        }

        .btn-edit:hover {
            background-color: #ca8a04;
        }

        .btn-delete {
            background-color: #ef4444;
            color: #fff;
        }

        .btn-delete:hover {
            background-color: #dc2626;
        }

        /* Badge Poin Pelanggaran */
        .badge-poin {
            background-color: #fee2e2;
            color: #991b1b;
            padding: 3px 8px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.8rem;
        }

        /* Informasi Khusus SMK (Grid 3 Kolom) */
        .smk-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-top: 30px;
            margin-bottom: 40px;
        }

        .info-card {
            background: #fff;
            padding: 22px;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
            border-left: 4px solid #0f172a;
        }

        .info-card h3 {
            font-size: 1.05rem;
            margin-bottom: 12px;
            color: #0f172a;
        }

        .info-card ul {
            list-style: none;
            padding: 0;
        }

        .info-card li {
            font-size: 0.85rem;
            color: #475569;
            margin-bottom: 8px;
            padding-bottom: 6px;
            border-bottom: 1px dashed #e2e8f0;
            line-height: 1.5;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #0f172a;
            color: #cbd5e1;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>

    <!-- Navbar Navigation -->
    <nav class="navbar">
        <div class="logo">
            <i class="fa-solid fa-graduation-cap"></i> SIMK SMKN 1 MAJA
        </div>
        <ul class="nav-links">
            <li><a href="#home">Beranda</a></li>
            <li><a href="#data-siswa">Siswa</a></li>
            <li><a href="#data-ekskul">Ekskul</a></li>
            <li><a href="#catatan-pelanggaran">Pelanggaran</a></li>
            <li><a href="#catatan-prestasi">Prestasi</a></li>
            <li><a href="#info-smk">Info Kejuruan</a></li>
        </ul>
    </nav>

    <!-- Halaman Utama (Hero Section Khusus SMK) -->
    <section class="hero" id="home">
        <h1>Sistem Informasi Kesiswaan SMK NEGERI 1 MAJA</h1>
        <p>Pusat pengelolaan data siswa kejuruan, kegiatan ekstrakurikuler, kedisiplinan, serta rekam jejak prestasi siswa siap kerja.</p>
        <a href="#data-siswa" class="btn-cta"><i class="fa-solid fa-database"></i> Kelola Data Siswa</a>
    </section>

    <!-- Main Content -->
    <div class="container">

        <!-- Ringkasan Statistik Data SMK -->
        <div class="stats-grid">
            <div class="stat-card">
                <h3><?= count($data_siswa); ?></h3>
                <p>Siswa Kejuruan Terdaftar</p>
            </div>
            <div class="stat-card">
                <h3><?= count($data_ekskul); ?></h3>
                <p>Ekstrakurikuler Aktif</p>
            </div>
            <div class="stat-card">
                <h3><?= count($data_pelanggaran); ?></h3>
                <p>Catatan Kedisiplinan</p>
            </div>
            <div class="stat-card">
                <h3><?= count($data_prestasi); ?></h3>
                <p>Prestasi & LKS Diraih</p>
            </div>
        </div>

        <!-- 1. DATA SISWA -->
        <div class="card-table" id="data-siswa">
            <div class="card-header-flex">
                <h2>Data Siswa Kejuruan</h2>
                <a href="tambah_siswa.php" class="btn-add"><i class="fa-solid fa-plus"></i> Tambah Siswa</a>
            </div>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Siswa</th>
                            <th>Nama Lengkap</th>
                            <th>JK</th>
                            <th>TTL</th>
                            <th>Kelas</th>
                            <th>Konsentrasi Keahlian (Jurusan)</th>
                            <th>No HP</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($data_siswa)): ?>
                            <tr><td colspan="9" style="text-align:center;">Belum ada data siswa.</td></tr>
                        <?php else: ?>
                            <?php foreach ($data_siswa as $index => $siswa): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($siswa['id_siswa']); ?></td>
                                <td><strong><?= htmlspecialchars($siswa['nama_lengkap']); ?></strong></td>
                                <td><?= htmlspecialchars($siswa['jenis_kelamin']); ?></td>
                                <td><?= htmlspecialchars($siswa['tempat_tanggal_lahir']); ?></td>
                                <td><?= htmlspecialchars($siswa['kelas']); ?></td>
                                <td><?= htmlspecialchars($siswa['jurusan']); ?></td>
                                <td><?= htmlspecialchars($siswa['no_hp']); ?></td>
                                <td>
                                    <a href="edit_siswa.php?id=<?= $siswa['id_siswa']; ?>" class="btn-action btn-edit"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                    <a href="hapus_siswa.php?id=<?= $siswa['id_siswa']; ?>" class="btn-action btn-delete" onclick="return confirm('Hapus data siswa ini?')"><i class="fa-solid fa-trash"></i> Hapus</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 2. DATA EKSTRAKURIKULER -->
        <div class="card-table" id="data-ekskul">
            <div class="card-header-flex">
                <h2>Data Ekstrakurikuler & Komunitas Keahlian</h2>
                <a href="tambah_ekskul.php" class="btn-add"><i class="fa-solid fa-plus"></i> Tambah Ekskul</a>
            </div>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Ekskul</th>
                            <th>Nama Ekstrakurikuler</th>
                            <th>Pembina / Instruktur</th>
                            <th>Jadwal</th>
                            <th>Tempat / Lab</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($data_ekskul)): ?>
                            <tr><td colspan="7" style="text-align:center;">Belum ada data ekstrakurikuler.</td></tr>
                        <?php else: ?>
                            <?php foreach ($data_ekskul as $index => $ekskul): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($ekskul['id_ekstrakurikuler']); ?></td>
                                <td><strong><?= htmlspecialchars($ekskul['nama_ekstrakurikuler']); ?></strong></td>
                                <td><?= htmlspecialchars($ekskul['nama_pembina']); ?></td>
                                <td><?= htmlspecialchars($ekskul['jadwal']); ?></td>
                                <td><?= htmlspecialchars($ekskul['tempat']); ?></td>
                                <td>
                                    <a href="edit_ekskul.php?id=<?= $ekskul['id_ekstrakurikuler']; ?>" class="btn-action btn-edit"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                    <a href="hapus_ekskul.php?id=<?= $ekskul['id_ekstrakurikuler']; ?>" class="btn-action btn-delete" onclick="return confirm('Hapus ekskul ini?')"><i class="fa-solid fa-trash"></i> Hapus</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 3. CATATAN PELANGGARAN -->
        <div class="card-table" id="catatan-pelanggaran">
            <div class="card-header-flex">
                <h2>Catatan Kedisiplinan & Pelanggaran Tatib SMK</h2>
                <a href="tambah_pelanggaran.php" class="btn-add"><i class="fa-solid fa-plus"></i> Tambah Pelanggaran</a>
            </div>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Siswa</th>
                            <th>Tanggal</th>
                            <th>Deskripsi Pelanggaran</th>
                            <th>Poin</th>
                            <th>Tindakan / Pembinaan</th>
                            <th>Guru Piket / BK</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($data_pelanggaran)): ?>
                            <tr><td colspan="8" style="text-align:center;">Belum ada catatan pelanggaran.</td></tr>
                        <?php else: ?>
                            <?php foreach ($data_pelanggaran as $index => $pelanggaran): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($pelanggaran['id_siswa']); ?></td>
                                <td><?= format_tanggal($pelanggaran['tanggal_kejadian']); ?></td>
                                <td><?= htmlspecialchars($pelanggaran['deskripsi']); ?></td>
                                <td><span class="badge-poin">+<?= htmlspecialchars($pelanggaran['point']); ?> Poin</span></td>
                                <td><?= htmlspecialchars($pelanggaran['tindakan']); ?></td>
                                <td><?= htmlspecialchars($pelanggaran['guru_piket']); ?></td>
                                <td>
                                    <!-- CATATAN: Ganti id_pelanggaran dengan Primary Key tabel catatan_pelanggaran kamu -->
                                    <a href="edit_pelanggaran.php?id=<?= $pelanggaran['id_pelanggaran'] ?? $pelanggaran['id_siswa']; ?>" class="btn-action btn-edit"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                    <a href="hapus_pelanggaran.php?id=<?= $pelanggaran['id_pelanggaran'] ?? $pelanggaran['id_siswa']; ?>" class="btn-action btn-delete" onclick="return confirm('Hapus catatan kedisiplinan ini?')"><i class="fa-solid fa-trash"></i> Hapus</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 4. CATATAN PRESTASI -->
        <div class="card-table" id="catatan-prestasi">
            <div class="card-header-flex">
                <h2>Catatan Prestasi & Ajang LKS (Lomba Kompetensi Siswa)</h2>
                <a href="tambah_prestasi.php" class="btn-add"><i class="fa-solid fa-plus"></i> Tambah Prestasi</a>
            </div>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Siswa</th>
                            <th>Tanggal</th>
                            <th>Kategori Prestasi</th>
                            <th>Nama Kejuaraan / LKS</th>
                            <th>Peringkat</th>
                            <th>Penyelenggara / Industri</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($data_prestasi)): ?>
                            <tr><td colspan="8" style="text-align:center;">Belum ada catatan prestasi.</td></tr>
                        <?php else: ?>
                            <?php foreach ($data_prestasi as $index => $prestasi): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($prestasi['id_siswa']); ?></td>
                                <td><?= format_tanggal($prestasi['tanggal_prestasi']); ?></td>
                                <td><?= htmlspecialchars($prestasi['jenis_prestasi']); ?></td>
                                <td><strong><?= htmlspecialchars($prestasi['nama_prestasi']); ?></strong></td>
                                <td><?= htmlspecialchars($prestasi['peringkat']); ?></td>
                                <td><?= htmlspecialchars($prestasi['penyelenggara']); ?></td>
                                <td>
                                    <!-- CATATAN: Ganti id_prestasi dengan Primary Key tabel catatan_prestasi kamu -->
                                    <a href="edit_prestasi.php?id=<?= $prestasi['id_prestasi'] ?? $prestasi['id_siswa']; ?>" class="btn-action btn-edit"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                    <a href="hapus_prestasi.php?id=<?= $prestasi['id_prestasi'] ?? $prestasi['id_siswa']; ?>" class="btn-action btn-delete" onclick="return confirm('Hapus catatan prestasi ini?')"><i class="fa-solid fa-trash"></i> Hapus</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Informasi Tambahan Khas SMK (3 Kartu Informasi Khusus Kejuruan) -->
        <div class="smk-info-grid" id="info-smk">
            <div class="info-card">
                <h3><i class="fa-solid fa-industry"></i> Informasi PKL / Prakerin</h3>
                <ul>
                    <li><strong>Persyaratan PKL:</strong> Bebas dari akumulasi poin pelanggaran > 30.</li>
                    <li><strong>Sertifikat Industri:</strong> Wajib dikumpulkan ke Pokja PKL setelah pembekalan usai.</li>
                    <li><strong>Monitoring:</strong> Dilakukan oleh guru pembimbing tiap 2 minggu sekali.</li>
                </ul>
            </div>
            <div class="info-card">
                <h3><i class="fa-solid fa-certificate"></i> Uji Kompetensi Keahlian (UKK)</h3>
                <ul>
                    <li><strong>Sertifikasi LSP-P1:</strong> Verifikasi tempat uji kompetensi (TUK) dimulai bulan depan.</li>
                    <li><strong>Ketentuan Kebersihan Lab:</strong> Poin kedisiplinan berimbas pada kelayakan paspor K3 siswa.</li>
                    <li><strong>Penguji Eksternal:</strong> Didatangkan langsung dari Mitra Industri / DUDI terkait.</li>
                </ul>
            </div>
            <div class="info-card">
                <h3><i class="fa-solid fa-briefcase"></i> Bursa Kerja Khusus (BKK) SMK</h3>
                <ul>
                    <li><strong>Layanan Rekrutmen:</strong> Informasi lowongan kerja khusus alumni & kelas XII.</li>
                    <li><strong>Penyaluran Kerja:</strong> Bekerja sama dengan lebih dari 20 mitra industri nasional.</li>
                    <li><strong>Kontak BKK:</strong> Gedung Hubin / Ruang BKK SMK (Jam kerja 08.00 - 15.00 WIB).</li>
                </ul>
            </div>
        </div>

    </div>

    <footer>
        &copy; 2026 SIM Kesiswaan SMKN 1 MAJA - Menguatkan Indonesia dengan SDM Unggul dan Siap Kerja.
    </footer>

</body>
</html>