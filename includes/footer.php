<?php
// ikiboyy21/laba-pintar/Laba-Pintar-074ca69357fb28dc6f11b9e6d279be5dd0ec7c2c/includes/footer.php

if(is_logged_in()): ?>
        </div> </div> <script>
    // Logic untuk mengaktifkan offcanvas sidebar di mobile
    document.addEventListener('DOMContentLoaded', () => {
        const sidebar = document.getElementById('sidebarOffcanvas');
        if (sidebar && !window.matchMedia('(min-width: 992px)').matches) {
            new bootstrap.Offcanvas(sidebar, { backdrop: true, scroll: true });
        }
    });
    </script>
<?php else: ?>
    </div> <?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= BASE_URL ?>/assets/js/script.js"></script>

<script>
  // DARK MODE TOGGLE LOGIC
  const body = document.body;
  const toggle = document.getElementById("darkToggle");

  if(toggle) {
      toggle.addEventListener("click", () => {
          body.classList.toggle("dark-mode");

          // save mode
          if (body.classList.contains("dark-mode")) {
              localStorage.setItem("theme", "dark");
          } else {
              localStorage.setItem("theme", "light");
          }
      });
  }
</script>

</body>
</html>