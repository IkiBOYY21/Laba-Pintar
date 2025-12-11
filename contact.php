<?php
require_once 'helpers.php';
require_once 'includes/header.php';
?>

<div class="content-section">
    <div class="text-center mb-5 animate-on-scroll">
        <span class="badge bg-warning bg-opacity-10 text-warning border border-warning px-3 py-2 rounded-pill mb-3 fw-bold ls-1">CONTACT US</span>
        <h1 class="page-title display-4 fw-bold mb-3">Hubungi Kami</h1>
        <p class="lead text-muted mx-auto" style="max-width: 700px;">
            Pilih metode komunikasi yang paling nyaman untuk Anda. Kami siap membantu 24/7.
        </p>
    </div>

    <div class="row g-5 justify-content-center">
        
        <div class="col-md-6 col-lg-4">
            <div class="card-3d-glass p-4 h-100 text-center position-relative animate-on-scroll" style="transition-delay: 0.1s;">
                 <div class="position-absolute top-0 start-50 translate-middle-x bg-success opacity-25 blur-3xl" style="width: 100px; height: 100px; filter: blur(40px); z-index: 0;"></div>
                
                <div class="position-relative d-flex flex-column h-100" style="z-index: 1;">
                    <div class="mb-3">
                        <div class="icon-wrapper mb-3 text-success">
                            <i class="bi bi-whatsapp fs-1"></i>
                        </div>
                        <h5 class="fw-bold mt-3">WhatsApp Support</h5>
                        <p class="text-muted small">Chat langsung untuk respon instan.</p>
                    </div>
                    <a href="https://wa.me/6281234567890" target="_blank" class="btn btn-gradient-3d px-4 fw-bold mt-auto w-100">
                        <i class="bi bi-whatsapp me-2"></i> Chat Sekarang
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card-3d-glass p-4 h-100 text-center position-relative animate-on-scroll" style="transition-delay: 0.2s;">
                <div class="position-absolute top-0 start-50 translate-middle-x bg-primary opacity-25 blur-3xl" style="width: 100px; height: 100px; filter: blur(40px); z-index: 0;"></div>
                
                <div class="position-relative d-flex flex-column h-100" style="z-index: 1;">
                    <div class="mb-3">
                        <div class="icon-wrapper mb-3 text-primary">
                            <i class="bi bi-envelope-paper-fill fs-1"></i>
                        </div>
                        <h5 class="fw-bold mt-3">Email Gmail</h5>
                        <p class="text-muted small">Kirim pesan dan kritikan anda langsung via Gmail.</p>
                    </div>
                    
                    <button type="button" class="btn btn-gradient-3d px-4 fw-bold mt-auto w-100" data-bs-toggle="modal" data-bs-target="#emailModal">
                        <i class="bi bi-google me-2"></i> Tulis Pesan
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card-3d-glass p-4 h-100 text-center position-relative animate-on-scroll" style="transition-delay: 0.3s;">
                <div class="position-absolute top-0 start-50 translate-middle-x bg-warning opacity-25 blur-3xl" style="width: 100px; height: 100px; filter: blur(40px); z-index: 0;"></div>
                
                <div class="position-relative d-flex flex-column h-100" style="z-index: 1;">
                    <div class="mb-3">
                        <div class="icon-wrapper mb-3 mx-auto" style="width: 90px; height: 90px; display: flex; align-items: center; justify-content: center;">
                            <img src="Assets/img/logo unnes.png" 
                                 alt="Logo UNNES" 
                                 style="width: 100%; height: auto; filter: drop-shadow(0 5px 15px rgba(0,0,0,0.1));">
                        </div>
                        
                        <h5 class="fw-bold mt-3">Universitas Negeri Semarang</h5>
                        <p class="text-muted small">Sekaran, Kec. Gn. Pati, Kota Semarang.</p>
                    </div>
                    
                    <a href="https://goo.gl/maps/x" target="_blank" class="btn btn-gradient-3d px-4 fw-bold mt-auto w-100">
                        <i class="bi bi-map-fill me-2"></i> Lihat Peta
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="emailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content card-3d-glass border-0" style="background: var(--card-bg);">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title fw-bold text-primary"><i class="bi bi-envelope-at-fill me-2"></i>Kirim via Gmail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formGmail" onsubmit="bukaGmail(event)">
                    
                    <div class="form-floating-3d mb-3">
                        <label class="form-label small fw-bold text-muted">Nama Anda</label>
                        <input type="text" id="namaPengirim" class="form-control" required placeholder="Nama Lengkap">
                    </div>
                    
                    <div class="form-floating-3d mb-4">
                        <label class="form-label small fw-bold text-muted">Isi Pesan</label>
                        <textarea id="isiPesan" class="form-control" style="height: 120px" required placeholder="Tuliskan pesan Anda..."></textarea>
                    </div>

                    <div class="alert alert-info small py-2 mb-3">
                        <i class="bi bi-info-circle me-1"></i> Tombol ini akan membuka aplikasi/web Gmail Anda.
                    </div>

                    <button type="submit" class="btn btn-gradient-3d w-100 py-2 fw-bold">
                        <i class="bi bi-send-fill me-2"></i> BUKA GMAIL SEKARANG
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .icon-wrapper i, .icon-wrapper img {
        display: inline-block;
        transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .card-3d-glass:hover .icon-wrapper i, 
    .card-3d-glass:hover .icon-wrapper img {
        transform: scale(1.2) translateY(-8px);
    }
</style>

<script>
    function bukaGmail(e) {
        e.preventDefault(); // Mencegah reload halaman

        // 1. Ambil data dari form
        var nama = document.getElementById('namaPengirim').value;
        var pesan = document.getElementById('isiPesan').value;
        
        // 2. Tentukan Email Tujuan (GANTI EMAIL INI DENGAN EMAIL ANDA)
        var emailTujuan = "labapintar.official@gmail.com"; 
        
        // 3. Buat Subject & Body otomatis
        var subject = "Pesan dari: " + nama;
        var body = "Halo Admin Laba Pintar,\n\n" + pesan + "\n\nSalam,\n" + nama;

        // 4. Buat Link Gmail Web (Compose Mode)
        // Link ini memaksa membuka Gmail di browser dengan data yang sudah terisi
        var gmailLink = "https://mail.google.com/mail/?view=cm&fs=1&to=" + emailTujuan + 
                        "&su=" + encodeURIComponent(subject) + 
                        "&body=" + encodeURIComponent(body);

        // 5. Buka di Tab Baru
        window.open(gmailLink, '_blank');
        
        // Opsional: Tutup modal setelah diklik
        var modalEl = document.getElementById('emailModal');
        var modal = bootstrap.Modal.getInstance(modalEl);
        modal.hide();
    }
</script>

<?php include 'includes/footer.php'; ?>