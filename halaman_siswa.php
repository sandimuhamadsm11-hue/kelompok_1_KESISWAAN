<?php
include "config/koneksi.php";

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
    <!-- External CSS -->
    <link rel="stylesheet" href="assets/style2.css">
</head>
<body>

    <!-- Navbar Navigation -->
    <nav class="navbar">
    <div class="logo">
        <i class="fas fa-graduation-cap"></i> SIMK
    </div>
    <ul class="nav-links">
        <!-- Menu Navigasi Utama -->
        <li><a href="views/login.php">Login</a></li>
        <li><a href="#beranda">Beranda</a></li>
        <li><a href="#siswa">Siswa</a></li>
        <li><a href="#ekskul">Ekskul</a></li>
        <li><a href="#pelanggaran">Pelanggaran</a></li>
        <li><a href="#prestasi">Prestasi</a></li>
        <li><a href="#info-kejuruan">Info Kejuruan</a></li>
    </ul>
</nav>
    <!-- Halaman Utama (Hero Section Khusus SMK) -->
    <section class="hero" id="home">
        <h1>Sistem Informasi Kesiswaan SMK NEGERI 1 MAJA</h1>
        <p>Pusat pengelolaan data siswa kejuruan, kegiatan ekstrakurikuler, kedisiplinan, serta rekam jejak prestasi siswa siap kerja. Sistem ini membantu sekolah dalam mengelola informasi kesiswaan secara terstruktur, mudah diakses, dan mendukung pemantauan perkembangan siswa.</p>
        <a href="#data-siswa" class="btn-cta"><i class="fa-solid fa-database"></i> Lihat Data Siswa</a>
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
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($data_siswa)): ?>
                            <tr><td colspan="8" class="text-center">Belum ada data siswa.</td></tr>
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
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($data_ekskul)): ?>
                            <tr><td colspan="6" class="text-center">Belum ada data ekstrakurikuler.</td></tr>
                        <?php else: ?>
                            <?php foreach ($data_ekskul as $index => $ekskul): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($ekskul['id_ekstrakurikuler']); ?></td>
                                <td><strong><?= htmlspecialchars($ekskul['nama_ekstrakurikuler']); ?></strong></td>
                                <td><?= htmlspecialchars($ekskul['nama_pembina']); ?></td>
                                <td><?= htmlspecialchars($ekskul['jadwal']); ?></td>
                                <td><?= htmlspecialchars($ekskul['tempat']); ?></td>
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
            </div>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Pelanggaran</th>
                            <th>ID Siswa</th>
                            <th>Tanggal</th>
                            <th>Deskripsi Pelanggaran</th>
                            <th>Poin</th>
                            <th>Tindakan / Pembinaan</th>
                            <th>Guru Piket / BK</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($data_pelanggaran)): ?>
                            <tr><td colspan="8" class="text-center">Belum ada catatan pelanggaran.</td></tr>
                        <?php else: ?>
                            <?php foreach ($data_pelanggaran as $index => $pelanggaran): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><strong><?= htmlspecialchars($pelanggaran['id_pelanggaran'] ?? '-'); ?></strong></td>
                                <td><?= htmlspecialchars($pelanggaran['id_siswa']); ?></td>
                                <td><?= format_tanggal($pelanggaran['tanggal_kejadian']); ?></td>
                                <td><?= htmlspecialchars($pelanggaran['deskripsi']); ?></td>
                                <td><span class="badge-poin">+<?= htmlspecialchars($pelanggaran['point']); ?> Poin</span></td>
                                <td><?= htmlspecialchars($pelanggaran['tindakan']); ?></td>
                                <td><?= htmlspecialchars($pelanggaran['guru_piket']); ?></td>
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
            </div>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Prestasi</th>
                            <th>ID Siswa</th>
                            <th>Tanggal</th>
                            <th>Kategori Prestasi</th>
                            <th>Nama Kejuaraan / LKS</th>
                            <th>Peringkat</th>
                            <th>Penyelenggara / Industri</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($data_prestasi)): ?>
                            <tr><td colspan="8" class="text-center">Belum ada catatan prestasi.</td></tr>
                        <?php else: ?>
                            <?php foreach ($data_prestasi as $index => $prestasi): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><strong><?= htmlspecialchars($prestasi['id_prestasi'] ?? '-'); ?></strong></td>
                                <td><?= htmlspecialchars($prestasi['id_siswa']); ?></td>
                                <td><?= format_tanggal($prestasi['tanggal_prestasi']); ?></td>
                                <td><?= htmlspecialchars($prestasi['jenis_prestasi']); ?></td>
                                <td><strong><?= htmlspecialchars($prestasi['nama_prestasi']); ?></strong></td>
                                <td><?= htmlspecialchars($prestasi['peringkat']); ?></td>
                                <td><?= htmlspecialchars($prestasi['penyelenggara']); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Informasi Tambahan Khas SMK -->
        <div class="smk-info-grid" id="info-smk">
            <div class="info-card">
               <h3><i class="fas fa-users-cog mr-2"></i> Informasi Ekstrakurikuler Kepemimpinan</h3>
               <ul>
                   <li><strong>Wadah pengembangan diri siswa untuk mengasah jiwa kepemimpinan, kedisiplinan, tanggung jawab, dan kerja sama tim. Pembinaan ini mencakup empat bidang utama:</strong></li>
                   <li>PMR: Pembinaan karakter kemanusiaan dan kesiapsiagaan kesehatan.</li>
                   <li>Paskibra: Pelatihan kedisiplinan tinggi, baris-berbaris, dan jiwa kepemimpinan..</li>
                   <li>PKS: Pelatihan ketertiban lalu lintas dan keamanan lingkungan sekolah.</li>
                   <li>Pramuka: Pembentukan karakter mandiri, gotong royong, dan kecakapan hidup.</li>
               </ul>
            </div>
            <div class="info-card">
                <h3><i class="fa-solid fa-certificate"></i> Kewirausahaan</h3>
                <ul>
                    <li><strong>Kewirausahaan adalah sikap dan kemampuan seseorang dalam menciptakan ide atau usaha yang kreatif dan bermanfaat. Kegiatan ini melibatkan proses mengembangkan ide, mengelola sumber daya, serta menghadapi risiko untuk mencapai tujuan usaha.</strong></li>
                    <li>Di SMKN 1 MAJA, siswa juga akan mempelajari dasar-dasar kewirausahaan sebagai bekal untuk mengembangkan kreativitas dan memulai usaha.</li>
                </ul>
            </div>
            <div class="info-card">
                <h3><i class="fas fa-users-cog mr-2"></i> Informasi Ekstrakurikuler Pilihan</h3>
                <ul>
                    <li><strong>Pengertian Umum: </strong> Ekstrakurikuler pilihan adalah kegiatan tambahan di luar jam pelajaran utama yang dapat dipilih oleh siswa sesuai dengan minat, bakat, dan potensi diri untuk mengembangkan keterampilan khusus.</li>
                    <li><strong>Tujuan Utama: </strong> Memberikan kebebasan kepada siswa untuk menyalurkan hobi, memperluas wawasan non-akademik, serta mengasah keterampilan praktis sebagai persiapan menghadapi dunia kerja maupun kehidupan sosial.</li>
                </ul>
            </div>
        </div>

    </div>

    <footer>
        &copy; 2026 SIM Kesiswaan SMKN 1 MAJA - Menguatkan Indonesia dengan SDM Unggul dan Siap Kerja.
    </footer>


    <!-- External JavaScript File -->
    <script src="assets/script.js"></script>
</body>
</html>