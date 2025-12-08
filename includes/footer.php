<?php
if(is_logged_in()): ?>
        </div> </div> </div> 
        <?php else: ?>
    
    <?php if (isset($current_page) && $current_page != 'home.php'): ?>
        </div> 
    <?php endif; ?>

<?php endif; ?>

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