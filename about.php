<?php
require_once 'helpers.php';
require_once 'includes/header.php';
?>
<div class="content-section">
    <div class="text-center mb-5 animate-on-scroll">
        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary px-3 py-2 rounded-pill mb-3 fw-bold ls-1">OUR TEAM</span>
        <h1 class="page-title display-4 fw-bold mb-3">Tentang Kami</h1>
        <p class="lead text-muted mx-auto" style="max-width: 700px;">
            Kami adalah tim pengembang di balik Laba Pintar, berdedikasi untuk memberikan solusi manajemen keuangan terbaik untuk UKM.
        </p>
    </div>

    <div class="row g-4 justify-content-center">
        
        <div class="col-md-6 col-lg-3">
            <div class="card-3d-glass team-card p-4 h-100 text-center position-relative animate-on-scroll" style="transition-delay: 0.1s;">
                <div class="position-absolute top-0 start-50 translate-middle-x bg-primary opacity-25 blur-3xl" style="width: 100px; height: 100px; filter: blur(40px); z-index: 0;"></div>
                
                <div class="position-relative" style="z-index: 1;">
                    <div class="team-img-wrapper mb-3">
                        <img src="Assets\img\herdi.jpg" alt="Foto Anggota 1">
                    </div>
                    <h5 class="fw-bold mb-1">HERDI RIZKY GUNAWAN</h5>
                    <span class="badge bg-primary mb-3">Ketua Tim</span>
                    <p class="text-muted small">Bertanggung jawab atas manajemen proyek, arsitektur backend, dan integrasi sistem utama.</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card-3d-glass team-card p-4 h-100 text-center position-relative animate-on-scroll" style="transition-delay: 0.2s;">
                <div class="position-absolute top-0 start-50 translate-middle-x bg-info opacity-25 blur-3xl" style="width: 100px; height: 100px; filter: blur(40px); z-index: 0;"></div>
                
                <div class="position-relative" style="z-index: 1;">
                    <div class="team-img-wrapper mb-3">
                        <img src="Assets\img\bagas1.jpg" alt="Foto Anggota 2">
                    </div>
                    <h5 class="fw-bold mb-1">BAGAS SATRIO HIMAWAN</h5>
                    <span class="badge bg-info text-white mb-3">Anggota</span>
                    <p class="text-muted small">Merancang antarmuka pengguna (UI/UX) yang interaktif, responsif, dan estetis.</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card-3d-glass team-card p-4 h-100 text-center position-relative animate-on-scroll" style="transition-delay: 0.3s;">
                <div class="position-absolute top-0 start-50 translate-middle-x bg-warning opacity-25 blur-3xl" style="width: 100px; height: 100px; filter: blur(40px); z-index: 0;"></div>
                
                <div class="position-relative" style="z-index: 1;">
                    <div class="team-img-wrapper mb-3">
                        <img src="Assets\img\rara.jpg" alt="Foto Anggota 3">
                    </div>
                    <h5 class="fw-bold mb-1">RISTA AZ-ZAHRA N.W.</h5>
                    <span class="badge bg-info text-white mb-3">Anggota</span>
                    <span class="badge bg-warning text-dark mb-3"></span>
                    <p class="text-muted small">Mengelola struktur database, optimasi query, dan memastikan keamanan data pengguna.</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card-3d-glass team-card p-4 h-100 text-center position-relative animate-on-scroll" style="transition-delay: 0.4s;">
                <div class="position-absolute top-0 start-50 translate-middle-x bg-secondary opacity-25 blur-3xl" style="width: 100px; height: 100px; filter: blur(40px); z-index: 0;"></div>
                
                <div class="position-relative" style="z-index: 1;">
                    <div class="team-img-wrapper mb-3">
                        <img src="https://ui-avatars.com/api/?name=Bagas+Permana&background=26a69a&color=fff&size=150" alt="Foto Anggota 4">
                    </div>
                    <h5 class="fw-bold mb-1">BAGAS PERMANA PUTRA</h5>
                    <span class="badge bg-info text-white mb-3">Anggota</span>
                    <span class="badge bg-secondary mb-3"></span>
                    <p class="text-muted small">Melakukan pengujian sistem, mencari bug, dan mendokumentasikan penggunaan aplikasi.</p>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    /* OVERRIDE PENTING:
       Menggabungkan background 'Glass' dengan animasi 'Team Card' lama.
       Kita paksa transform hover agar menggunakan efek 'membal tinggi' (scale 1.03) 
       dari team-card, bukan efek 'naik sedikit' dari card-3d-glass.
    */
    .card-3d-glass.team-card {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .card-3d-glass.team-card:hover {
        transform: translateY(-15px) scale(1.03) !important; /* Paksa efek lama */
        box-shadow: 0 0 20px rgba(0, 150, 136, 0.4), 
                    0 0 45px rgba(0, 150, 136, 0.2) !important;
        border-color: var(--primary-color) !important;
    }
    
    /* Memastikan animasi gambar berputar tetap jalan */
    .card-3d-glass.team-card:hover .team-img-wrapper {
        transform: scale(1.1) rotate(5deg);
        box-shadow: 0 0 25px var(--primary-light);
    }
</style>

<?php include 'includes/footer.php'; ?>