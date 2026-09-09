-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 09, 2026 at 12:53 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kesiswaan`
--

-- --------------------------------------------------------

--
-- Table structure for table `catatan_pelanggaran`
--

CREATE TABLE `catatan_pelanggaran` (
  `id_siswa` int NOT NULL,
  `tanggal_kejadian` date NOT NULL,
  `deskripsi` varchar(200) NOT NULL,
  `point` int NOT NULL,
  `tindakan` varchar(80) NOT NULL,
  `guru_piket` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `catatan_pelanggaran`
--

INSERT INTO `catatan_pelanggaran` (`id_siswa`, `tanggal_kejadian`, `deskripsi`, `point`, `tindakan`, `guru_piket`) VALUES
(102625, '2026-09-30', 'SISWA MEMAKAI AKSESORIS KALUNG', 50, 'DISITA BARANGNYA', 'PA Yanto Bendi'),
(102626, '2026-10-01', 'SISWI MEMAKAI AKSESORIS BERLEBIHAN', 25, 'DI SITA BARANGNYA ', 'PAK DENDI JULIANSAH'),
(102627, '2026-10-02', 'MEMAKAI MAKEUP BERLEBIHAN', 35, 'DIHAPUS MAKEUPNYA', 'BU NURWATI'),
(102629, '2026-10-05', 'MEMBAWA KARTU UNO KE SEKOLAH', 45, 'DI SITA DAN DIBERI TINDAKAN', 'PAK DENDI JULIANSAH');

-- --------------------------------------------------------

--
-- Table structure for table `catatan_prestasi`
--

CREATE TABLE `catatan_prestasi` (
  `id_siswa` int NOT NULL,
  `tanggal_prestasi` date NOT NULL,
  `jenis_prestasi` varchar(50) NOT NULL,
  `nama_prestasi` varchar(100) NOT NULL,
  `peringkat` int NOT NULL,
  `penyelenggara` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `catatan_prestasi`
--

INSERT INTO `catatan_prestasi` (`id_siswa`, `tanggal_prestasi`, `jenis_prestasi`, `nama_prestasi`, `peringkat`, `penyelenggara`) VALUES
(102625, '2026-09-10', 'OLAHRAGA', 'BADMINTON CUP MAJALENGKA', 1, 'CABANG OLAHRAGA MAJALENGKA'),
(102626, '2026-10-07', 'OLAHRAGA', 'MENJUARAI LOMBA LARI 100KM', 1, 'CABANG OLAHRAGA MAJALENGKA'),
(102627, '2026-09-15', 'OLAHRAGA', 'BOXING', 2, 'CABANG OLAHRAGA MAJALENGKA'),
(102629, '2026-09-30', 'AKADEMIK', 'LOMBA PUBLIK SPEAKING', 1, 'CABANG AKADEMIK MAJALENGKA');

-- --------------------------------------------------------

--
-- Table structure for table `data_ekstrakurikuler`
--

CREATE TABLE `data_ekstrakurikuler` (
  `id_ekstrakurikuler` int NOT NULL,
  `nama_ekstrakurikuler` varchar(10) NOT NULL,
  `nama_pembina` varchar(25) NOT NULL,
  `jadwal` varchar(20) NOT NULL,
  `tempat` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `data_ekstrakurikuler`
--

INSERT INTO `data_ekstrakurikuler` (`id_ekstrakurikuler`, `nama_ekstrakurikuler`, `nama_pembina`, `jadwal`, `tempat`) VALUES
(1, 'PMR', 'Pa firman & Bu hasna', 'JUMAT', 'RUANG 1/2'),
(2, 'PKS', 'BU DINI', 'JUMAT', 'lapangan/parkiran RC'),
(3, 'PASKIBRA', 'PA DEKI G', 'JUMAT', 'LAPANGAN'),
(4, 'PRAMUKA', 'BU MIMIN', 'JUMAT', 'Menyesuaikan');

-- --------------------------------------------------------

--
-- Table structure for table `data_siswa`
--

CREATE TABLE `data_siswa` (
  `id_siswa` int NOT NULL,
  `nama_lengkap` varchar(50) NOT NULL,
  `jenis_kelamin` varchar(10) NOT NULL,
  `tempat_tanggal_lahir` date NOT NULL,
  `kelas` varchar(15) NOT NULL,
  `jurusan` varchar(10) NOT NULL,
  `no_hp` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `data_siswa`
--

INSERT INTO `data_siswa` (`id_siswa`, `nama_lengkap`, `jenis_kelamin`, `tempat_tanggal_lahir`, `kelas`, `jurusan`, `no_hp`) VALUES
(102625, 'M Dika Maulana ', 'L', '2010-01-18', 'XI PPLG 1', 'PPLG', '0881023705433'),
(102626, 'Wulan Rahmaniani', 'P', '2009-01-13', 'XI PPLG 1', 'PPLG', '08765896543'),
(102627, 'Visa Nur  Atika', 'P', '2010-05-11', 'XI PPLG 1', 'PPLG', '0876589654999'),
(102629, 'Sandi muhamad samsul', 'L', '2009-08-03', 'XI PPLG 1', 'PPLG', '08768654748');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `catatan_pelanggaran`
--
ALTER TABLE `catatan_pelanggaran`
  ADD PRIMARY KEY (`id_siswa`);

--
-- Indexes for table `catatan_prestasi`
--
ALTER TABLE `catatan_prestasi`
  ADD PRIMARY KEY (`id_siswa`);

--
-- Indexes for table `data_ekstrakurikuler`
--
ALTER TABLE `data_ekstrakurikuler`
  ADD PRIMARY KEY (`id_ekstrakurikuler`);

--
-- Indexes for table `data_siswa`
--
ALTER TABLE `data_siswa`
  ADD PRIMARY KEY (`id_siswa`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `catatan_pelanggaran`
--
ALTER TABLE `catatan_pelanggaran`
  MODIFY `id_siswa` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102630;

--
-- AUTO_INCREMENT for table `catatan_prestasi`
--
ALTER TABLE `catatan_prestasi`
  MODIFY `id_siswa` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102630;

--
-- AUTO_INCREMENT for table `data_ekstrakurikuler`
--
ALTER TABLE `data_ekstrakurikuler`
  MODIFY `id_ekstrakurikuler` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `data_siswa`
--
ALTER TABLE `data_siswa`
  MODIFY `id_siswa` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102630;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
