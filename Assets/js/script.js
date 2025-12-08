document.addEventListener('click', function(e){
  if(e.target && e.target.matches('.remove-item')){
    e.target.closest('.item-row').remove();
  }
});
document.getElementById && document.getElementById('addItem') && document.getElementById('addItem').addEventListener('click', function(){
  var container = document.getElementById('items');
  if(!container) return;
  var row = document.querySelector('.item-row');
  if(!row) return;
  var clone = row.cloneNode(true);
  clone.querySelectorAll('input').forEach(i=>i.value='1');
  container.appendChild(clone);
});

// LOGIC BARU: DARK MODE TOGGLE & SIDEBAR COLLAPSE
document.addEventListener('DOMContentLoaded', function() {
    const body = document.body;
    
    // 1. DARK MODE TOGGLE LISTENER
    const darkToggle = document.getElementById("darkToggle");

    if (darkToggle) {
        darkToggle.addEventListener("click", () => {
            body.classList.toggle("dark-mode");
            
            // save mode
            if (body.classList.contains("dark-mode")) {
                localStorage.setItem("theme", "dark");
            } else {
                localStorage.setItem("theme", "light");
            }
        });
    }

    // 2. SIDEBAR COLLAPSE LOGIC (Desktop Only)
    const sidebarToggle = document.getElementById('sidebarToggleDesktop');
    
    // Load saved state on page load (desktop only)
    if (window.matchMedia('(min-width: 992px)').matches) {
        if (localStorage.getItem('sidebarState') === 'closed') {
            body.classList.add('sidebar-closed');
        }

        // Handle click event
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function() {
                body.classList.toggle('sidebar-closed');
                
                // Save new state
                if (body.classList.contains('sidebar-closed')) {
                    localStorage.setItem('sidebarState', 'closed');
                } else {
                    localStorage.setItem('sidebarState', 'open');
                }
            });
        }
    }
});

// ==========================================
// SCROLL ANIMATION TRIGGER
// ==========================================
document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Pilih semua elemen yang ingin dianimasikan
    // Kita targetkan kartu, judul, dan kolom row
    const elementsToAnimate = document.querySelectorAll('.app-card, .page-title, .landing-title-home, .feature-hover, .team-card');
    
    // Tambahkan class dasar ke elemen tersebut
    elementsToAnimate.forEach((el) => {
        el.classList.add('animate-on-scroll');
    });

    // 2. Buat Observer untuk memantau scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            // Jika elemen terlihat di layar
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                // Optional: Hapus observer setelah muncul (agar animasi cuma sekali)
                observer.unobserve(entry.target); 
            }
        });
    }, {
        threshold: 0.1, // Picu animasi saat 10% elemen terlihat
        rootMargin: "0px 0px -50px 0px" // Offset sedikit dari bawah
    });

    // 3. Mulai memantau setiap elemen
    elementsToAnimate.forEach((el) => {
        observer.observe(el);
    });
});