<?php
require_once 'helpers.php';
require_once 'includes/header.php';
?>

<div class="content-section">
    <?php if(isset($_SESSION['flash'])): ?>
        <div class="alert alert-success alert-dismissible fade show animate-on-scroll" role="alert">
            <?= flash('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="text-center mb-5 animate-on-scroll">
        <h1 class="page-title">Hubungi Kami</h1>
        <p class="lead text-muted mx-auto" style="max-width: 700px;">
            Kami siap membantu pertanyaan atau masalah terkait Laba Pintar.
        </p>
    </div>

    <div class="row g-5 justify-content-center">
        
       <div class="col-md-6 col-lg-4">
            <div class="card-3d-glass p-4 h-100 text-center position-relative animate-on-scroll" style="transition-delay: 0.1s;">
                 <div class="position-absolute top-0 start-50 translate-middle-x bg-success opacity-25 blur-3xl" style="width: 100px; height: 100px; filter: blur(40px); z-index: 0;"></div>
                <div class="position-relative" style="z-index: 1;">
                    <div class="team-img-wrapper mb-3 text-success">
                        <i class="bi bi-whatsapp fs-1"></i>
                    </div>
                    <h5 class="fw-bold mt-3">WhatsApp Support</h5>
                    <p class="text-muted small mb-4">Chat langsung dengan tim support kami.</p>
                    
                    <a href="https://wa.me/6281234567890" target="_blank" class="btn btn-gradient-3d px-4 fw-bold">
                        <i class="bi bi-whatsapp me-2"></i> Chat Sekarang
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card-3d-glass p-4 h-100 text-center position-relative animate-on-scroll" style="transition-delay: 0.2s;">
                <div class="position-absolute top-0 start-50 translate-middle-x bg-primary opacity-25 blur-3xl" style="width: 100px; height: 100px; filter: blur(40px); z-index: 0;"></div>
                <div class="position-relative" style="z-index: 1;">
                    <div class="team-img-wrapper mb-3 text-primary">
                        <i class="bi bi-envelope-paper-fill fs-1"></i>
                    </div>
                    <h5 class="fw-bold mt-3">Email Dukungan</h5>
                    <p class="text-muted small mb-4">Kirimkan detail kendala teknis Anda.</p>
                    
                    <button type="button" class="btn btn-gradient-3d px-4 fw-bold" data-bs-toggle="modal" data-bs-target="#emailModal">
                        <i class="bi bi-send-fill me-2"></i> Tulis Pesan
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card-3d-glass p-4 h-100 text-center position-relative animate-on-scroll" style="transition-delay: 0.3s;">
                <div class="position-absolute top-0 start-50 translate-middle-x bg-warning opacity-25 blur-3xl" style="width: 100px; height: 100px; filter: blur(40px); z-index: 0;"></div>
                
                <div class="position-relative" style="z-index: 1;">
                    <div class="team-img-wrapper mb-3 mx-auto" style="width: 90px; height: 90px; background: transparent; box-shadow: none;">
                        <img src="Assets\img\logo unnes.png" 
                             alt="Logo UNNES" 
                             style="width: 100%; height: 100%; object-fit: contain; filter: drop-shadow(0 5px 15px rgba(0,0,0,0.1));">
                    </div>
                    
                    <h5 class="fw-bold mt-3">Universitas Negeri Semarang</h5>
                    <p class="text-muted small mb-4">
                      Jl. Raya Banaran, Sekaran, Kec. Gn. Pati,<br>
                        Kota Semarang, Jawa Tengah 50229.
                    </p>
                    
                    <a href="https://maps.app.goo.gl/7jQ7ovKVXDdou1qU8" target="_blank" class="btn btn-gradient-3d px-4 fw-bold">
                        <i class="bi bi-map-fill me-2"></i> Lihat Peta
                    </a>
                </div>
            </div>
        </div>

<div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="emailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content card-3d-glass border-0">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title fw-bold text-primary" id="emailModalLabel"><i class="bi bi-envelope-at-fill me-2"></i>Kirim Pesan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="send_email.php" method="POST">
                    <div class="form-floating-3d mb-3">
                        <label class="form-label small fw-bold text-muted">Nama Anda</label>
                        <input type="text" name="nama" class="form-control" required placeholder="Nama Lengkap">
                    </div>
                    
                    <div class="form-floating-3d mb-3">
                        <label class="form-label small fw-bold text-muted">Email Balasan</label>
                        <input type="email" name="email" class="form-control" required placeholder="name@example.com">
                    </div>

                    <div class="form-floating-3d mb-4">
                        <label class="form-label small fw-bold text-muted">Isi Pesan</label>
                        <textarea name="pesan" class="form-control" style="height: 120px" required placeholder="Tuliskan kendala atau pertanyaan Anda..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-gradient-3d w-100 py-2 fw-bold">
                        <i class="bi bi-rocket-takeoff-fill me-2"></i> KIRIM SEKARANG
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>