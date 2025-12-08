// ==========================================
// 1. LOGIC TRANSAKSI & FORMAT RUPIAH
// ==========================================

function formatRupiah(angka) {
    var number_string = angka.toString(),
        sisa = number_string.length % 3,
        rupiah = number_string.substr(0, sisa),
        ribuan = number_string.substr(sisa).match(/\d{3}/g);

    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }
    return 'Rp ' + rupiah;
}

// Event Delegation untuk Input di Halaman Transaksi
document.addEventListener('input', function (e) {
    if (e.target.matches('.qty-input') || e.target.matches('.product-select')) {
        updateRow(e.target.closest('.item-row'));
        updateGrandTotal();
    }
});

// Update Baris per Item
function updateRow(row) {
    const select = row.querySelector('.product-select');
    const qtyInput = row.querySelector('.qty-input');
    const subOutput = row.querySelector('.subtotal-output');
    
    // Cek apakah elemen ada (mencegah error di halaman lain)
    if (!select || !qtyInput || !subOutput) return;

    const selectedOption = select.options[select.selectedIndex];
    const harga = parseFloat(selectedOption.getAttribute('data-harga')) || 0;
    const stok = parseInt(selectedOption.getAttribute('data-stok')) || 0;
    
    let qty = parseInt(qtyInput.value) || 0;

    // Validasi Stok
    if(qty > stok && stok > 0) {
        qtyInput.classList.add('is-invalid'); 
    } else {
        qtyInput.classList.remove('is-invalid');
    }

    const subtotal = harga * qty;
    subOutput.value = formatRupiah(subtotal);
    row.setAttribute('data-subtotal', subtotal);
}

// Hitung Total Keseluruhan
function updateGrandTotal() {
    let total = 0;
    document.querySelectorAll('.item-row').forEach(row => {
        total += parseFloat(row.getAttribute('data-subtotal')) || 0;
    });
    
    const grandTotalEl = document.getElementById('grandTotal');
    if(grandTotalEl) {
        grandTotalEl.innerText = formatRupiah(total);
    }
}

// Tombol Tambah Item (Clone Row)
const addItemBtn = document.getElementById('addItem');
if(addItemBtn) {
    addItemBtn.addEventListener('click', function() {
        const container = document.getElementById('items');
        const rows = container.getElementsByClassName('item-row');
        
        if(rows.length > 0) {
            const clone = rows[0].cloneNode(true);
            clone.querySelectorAll('input').forEach(input => input.value = 1);
            clone.querySelector('select').value = "";
            clone.querySelector('.subtotal-output').value = "Rp 0";
            clone.setAttribute('data-subtotal', 0);
            
            // Hapus class invalid jika tercopy
            clone.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

            container.appendChild(clone);
        }
    });
}

// Tombol Hapus Item
document.addEventListener('click', function(e) {
    if (e.target.closest('.remove-item')) {
        const row = e.target.closest('.item-row');
        if (document.querySelectorAll('.item-row').length > 1) {
            row.remove();
            updateGrandTotal();
        } else {
            alert("Minimal harus ada satu item transaksi.");
        }
    }
});


// ==========================================
// 2. LOGIC DARK MODE & SIDEBAR (RESTORED)
// ==========================================

document.addEventListener('DOMContentLoaded', function() {
    const body = document.body;
    
    // A. DARK MODE TOGGLE
    const darkToggle = document.getElementById("darkToggle");
    if (darkToggle) {
        darkToggle.addEventListener("click", () => {
            body.classList.toggle("dark-mode");
            
            if (body.classList.contains("dark-mode")) {
                localStorage.setItem("theme", "dark");
            } else {
                localStorage.setItem("theme", "light");
            }
        });
    }

    // B. SIDEBAR COLLAPSE (Desktop Only)
    const sidebarToggle = document.getElementById('sidebarToggleDesktop');
    
    // Load saved state
    if (window.matchMedia('(min-width: 992px)').matches) {
        if (localStorage.getItem('sidebarState') === 'closed') {
            body.classList.add('sidebar-closed');
        }

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function() {
                body.classList.toggle('sidebar-closed');
                
                if (body.classList.contains('sidebar-closed')) {
                    localStorage.setItem('sidebarState', 'closed');
                } else {
                    localStorage.setItem('sidebarState', 'open');
                }
            });
        }
    }

    // C. SCROLL ANIMATION
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
            }
        });
    });

    const hiddenElements = document.querySelectorAll('.animate-on-scroll');
    hiddenElements.forEach((el) => observer.observe(el));
});

// ==========================================
// SCROLL ANIMATION TRIGGER (UPDATED)
// ==========================================
document.addEventListener('DOMContentLoaded', function() {
    
    // 1. DAFTAR ELEMEN YANG INGIN DIANIMASIKAN
    // Saya menambahkan '#main-content-area', '.auth-card', dll ke dalam daftar
    const selectors = [
        '.app-card', 
        '.page-title', 
        '.landing-title-home', 
        '.feature-hover', 
        '.team-card',
        '#main-content-area', // Konten utama dashboard
        '.landing-wrapper',   // Halaman Home/Landing
        '.auth-card',         // Halaman Login/Register
        '.table-responsive',  // Tabel data
        '.stat-card'          // Kartu statistik
    ];

    const elementsToAnimate = document.querySelectorAll(selectors.join(', '));
    
    // Tambahkan class dasar (invisible) ke semua elemen target
    elementsToAnimate.forEach((el) => {
        el.classList.add('animate-on-scroll');
    });

    // 2. SETUP OBSERVER (Mata-mata Scroll)
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            // Jika elemen masuk ke layar (terlihat)
            if (entry.isIntersecting) {
                // Tambahkan class 'is-visible' untuk memicu transisi CSS
                entry.target.classList.add('is-visible');
                
                // Stop memantau elemen ini (agar animasi cuma sekali)
                observer.unobserve(entry.target); 
            }
        });
    }, {
        threshold: 0.15, // Animasi mulai saat 15% elemen terlihat
        rootMargin: "0px 0px -50px 0px" // Offset sedikit dari bawah agar tidak terlalu sensitif
    });

    // 3. MULAI MEMANTAU
    elementsToAnimate.forEach((el) => {
        observer.observe(el);
    });
});