<?php
require_once 'helpers.php';
require_once 'includes/header.php';
?>
<div class="content-section">
    <h1 class="page-title">Hubungi Kami</h1>
    <p class="lead text-muted mb-5">Kami siap membantu pertanyaan atau masalah terkait Laba Pintar. Silakan hubungi kami melalui saluran berikut.</p>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="app-card interactive-card text-center">
                <i class="bi bi-telephone-fill text-primary fs-2 mb-3"></i>
                <h5 class="fw-bold">Nomor Telepon / WhatsApp</h5>
                <p class="text-muted">0812-3456-7890 (Khusus WhatsApp)</p>
                <a href="https://wa.me/6281234567890" target="_blank" class="btn btn-sm btn-primary">Kirim Pesan</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="app-card interactive-card text-center">
                <i class="bi bi-envelope-fill text-primary fs-2 mb-3"></i>
                <h5 class="fw-bold">Email Dukungan</h5>
                <p class="text-muted">support@labapintar.com</p>
                <a href="mailto:support@labapintar.com" class="btn btn-sm btn-primary">Kirim Email</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="app-card interactive-card text-center">
                <i class="bi bi-geo-alt-fill text-primary fs-2 mb-3"></i>
                <h5 class="fw-bold">Alamat Kantor</h5>
                <p class="text-muted">Jl. Digital No. 10, Kota Inovasi, Indonesia</p>
                <button class="btn btn-sm btn-secondary" disabled>Lihat Peta</button>
            </div>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>