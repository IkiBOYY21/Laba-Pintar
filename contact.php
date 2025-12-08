<?php
require_once 'helpers.php';
require_once 'includes/header.php';
?>
<div class="content-section">
    <div class="text-center mb-5">
        <h1 class="page-title">Hubungi Kami</h1>
        <p class="lead text-muted mx-auto" style="max-width: 700px;">
            Kami siap membantu pertanyaan atau masalah terkait Laba Pintar. Silakan hubungi kami melalui saluran berikut.
        </p>
    </div>

    <div class="row g-5 justify-content-center">
        
        <div class="col-md-6 col-lg-4">
            <div class="app-card team-card text-center p-4 h-100">
                <div class="team-img-wrapper">
                    <i class="bi bi-whatsapp"></i>
                </div>
                <h5 class="fw-bold mt-3">WhatsApp Support</h5>
                <p class="text-muted small mb-4">Chat langsung dengan tim support kami untuk respon cepat.</p>
                
                <a href="https://wa.me/6281234567890" target="_blank" class="btn btn-outline-primary rounded-pill px-4 fw-bold">
                    <i class="bi bi-chat-dots me-2"></i> Chat Sekarang
                </a>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="app-card team-card text-center p-4 h-100">
                <div class="team-img-wrapper">
                    <i class="bi bi-envelope-paper-fill"></i>
                </div>
                <h5 class="fw-bold mt-3">Email Dukungan</h5>
                <p class="text-muted small mb-4">Kirimkan detail kendala teknis atau pertanyaan bisnis Anda.</p>
                
                <a href="mailto:support@labapintar.com" class="btn btn-outline-primary rounded-pill px-4 fw-bold">
                    <i class="bi bi-send me-2"></i> Kirim Email
                </a>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="app-card team-card text-center p-4 h-100">
                <div class="team-img-wrapper">
                    <i class="bi bi-geo-alt-fill"></i>
                </div>
                <h5 class="fw-bold mt-3">Kunjungi Kantor</h5>
                <p class="text-muted small mb-4">Jl. Digital No. 10, Kota Inovasi, Indonesia.</p>
                
                <a href="#" class="btn btn-outline-secondary rounded-pill px-4 fw-bold disabled">
                    <i class="bi bi-map me-2"></i> Lihat Peta
                </a>
            </div>
        </div>

    </div>
</div>
<?php include 'includes/footer.php'; ?>