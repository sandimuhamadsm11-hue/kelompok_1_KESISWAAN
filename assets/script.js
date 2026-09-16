document.addEventListener("DOMContentLoaded", function () {
    // 1. Konfirmasi Hapus Data via Event Delegation (Menggantikan inline onclick="return confirm(...)")
    const deleteButtons = document.querySelectorAll('.btn-confirm-delete');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            const message = this.getAttribute('data-message') || 'Apakah Anda yakin ingin menghapus data ini?';
            if (!confirm(message)) {
                e.preventDefault(); // Membatalkan aksi navigasi (link) jika pengguna menekan "Cancel"
            }
        });
    });

    // 2. Smooth Scroll untuk Link Navigasi navbar
    const navLinks = document.querySelectorAll('.navbar a[href^="#"], .hero a[href^="#"]');
    
    navLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);

            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});

