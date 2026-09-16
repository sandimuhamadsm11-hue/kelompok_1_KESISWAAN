<?php
include "../config/koneksi.php";

$type = $_GET['type'] ?? '';
$id   = $_GET['id'] ?? '';

if (!empty($type) && !empty($id)) {
    $safe_id = mysqli_real_escape_string($koneksi, $id);

    // Tentukan query hapus berdasarkan type
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

    if ($query) {
        $result = mysqli_query($koneksi, $query);
        
        // Jika gagal karena constraint/foreign key atau query error
        if (!$result) {
            echo "<script>
                    alert('Gagal menghapus data! Error: " . addslashes(mysqli_error($koneksi)) . "');
                    window.location.href = '../views/index.php#data-" . $type . "';
                  </script>";
        } else {
            header("Location: ../views/index.php");
            exit;
        }
    }
}

// Redirect kembali ke section terkait di index.php
else{
    header("Location: ../views/index.php" . ($type ? "#data-" . $type : ""));
    exit;
}

?>