<?php
include "../config/koneksi.php";

$type = $_GET['type'] ?? '';
$id   = $_GET['id'] ?? '';

// Konfigurasi mapping tabel, primary key, dan hash section di index.php
$config = [
    'siswa' => [
        'table' => 'data_siswa',
        'pk'    => 'id_siswa',
        'hash'  => 'data-siswa'
    ],
    'ekskul' => [
        'table' => 'data_ekstrakurikuler',
        'pk'    => 'id_ekstrakurikuler',
        'hash'  => 'data-ekskul'
    ],
    'pelanggaran' => [
        'table' => 'catatan_pelanggaran',
        'pk'    => 'id_pelanggaran',
        'hash'  => 'catatan-pelanggaran'
    ],
    'prestasi' => [
        'table' => 'catatan_prestasi',
        'pk'    => 'id_prestasi',
        'hash'  => 'catatan-prestasi'
    ]
];

// Validasi 1: Pastikan type terdaftar dan ID tidak kosong
if (!empty($type) && array_key_exists($type, $config) && !empty($id)) {
    $table = $config[$type]['table'];
    $pk    = $config[$type]['pk'];
    $hash  = $config[$type]['hash'];
    
    $safe_id = mysqli_real_escape_string($koneksi, $id);


    // menentukan query hapus berdasarkan type
    switch ($type) {
        case 'siswa':
            $query = "DELETE FROM data_siswa WHERE id_siswa = '$safe_id'";
            break;
        case 'ekskul':
            $query = "DELETE FROM data_ekstrakurikuler WHERE id_ekstrakurikuler = '$safe_id'";
            break;
        case 'pelanggaran':
            $query = "DELETE FROM catatan_pelanggaran WHERE id_pelanggaran = '$safe_id'";
            break;
        case 'prestasi':
            $query = "DELETE FROM catatan_prestasi WHERE id_prestasi = '$safe_id'";
            break;
        default:
            $query = null;
            break;
    }

    // Validasi 2: Cek apakah data benar-benar ada di database
    $cek_data = mysqli_query($koneksi, "SELECT * FROM $table WHERE $pk = '$safe_id'");


    if (mysqli_num_rows($cek_data) > 0) {
        // Eksekusi query DELETE
        $query = "DELETE FROM $table WHERE $pk = '$safe_id'";
        $result = mysqli_query($koneksi, $query);

        if ($result) {
            echo "<script>
                alert('Data berhasil dihapus!');
                window.location.href = '../views/index.php#" . $hash . "';
            </script>";
            exit;
        } else {
            // Validasi 3: Tangani error database (misal Foreign Key Constraint)
            $error_msg = mysqli_error($koneksi);
            if (strpos($error_msg, 'foreign key constraint fails') !== false) {
                $pesan = "Gagal menghapus! Data ini masih terhubung dengan data lain di sistem. Hapus data terkait terlebih dahulu.";
            } else {
                $pesan = "Gagal menghapus data: " . $error_msg;
            }
            
            echo "<script>
                alert('" . addslashes($pesan) . "');
                window.location.href = '../views/index.php#" . $hash . "';
            </script>";
            exit;
        }
    } else {
        // Jika ID tidak ditemukan di database
        echo "<script>
            alert('Data tidak ditemukan atau sudah dihapus sebelumnya!');
            window.location.href = '../views/index.php#" . $hash . "';
        </script>";
        exit;
    }
} else {
    // Jika parameter URL tidak lengkap atau tidak valid
    echo "<script>
        alert('Aksi penghapusan tidak valid!');
        window.location.href = '../views/index.php';
    </script>";
    exit;
}
?>