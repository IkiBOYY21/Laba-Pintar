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