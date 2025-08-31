// --- Modal Profil ---
document.addEventListener("DOMContentLoaded", function () {
    const profileIcon = document.getElementById('profile-icon');
    const profileModal = document.getElementById('profile-modal');
    const closeModalBtn = document.getElementById('close-profile-modal');

    if (profileIcon && profileModal && closeModalBtn) {
        // Tampilkan modal saat ikon profil diklik
        profileIcon.addEventListener('click', function () {
            profileModal.classList.remove('hidden');
        });
        // Tutup modal saat tombol close diklik
        closeModalBtn.addEventListener('click', function () {
            profileModal.classList.add('hidden');
        });
        // Tutup modal jika klik di luar konten modal
        profileModal.addEventListener('click', function (e) {
            if (e.target === profileModal) {
                profileModal.classList.add('hidden');
            }
        });
    }
});

// --- Inisialisasi Select2 pada Filter OPD ---
$(document).ready(function () {
    $('#filter-user').select2({
        placeholder: "Cari atau pilih organisasi perangkat daerah",
        allowClear: true
    });
});