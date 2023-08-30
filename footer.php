<footer class="footer mt-auto py-3 bg-dark">
    <div class="container">
      <div class="row justify-content-between">
        <div class="col">
          <img src="<?php echo get_bloginfo('template_directory'); ?>/img/rn24-agesci_neg_o.png" class="rn-logo-footer" alt="Logo RN24">
        </div>
        <div class="col text-right">
          <p class="follow-us-pre">Seguici anche su</p>
          <span class="follow-us-links">
            <a href="https://facebook.com/agesci.routenazionale2024" target="_blank">
              <img src="<?php echo get_bloginfo('template_directory'); ?>/img/facebook-f.svg" 
                class="social-link-footer" alt="Facebook RN24">
            </a>
            <a href="https://instagram.com/agesci.routenazionale2024" target="_blank">
              <img src="<?php echo get_bloginfo('template_directory'); ?>/img/instagram.svg" 
                  class="social-link-footer" alt="Instagram RN24">
            </a>
          </span>
        </div>
      </div><!-- .row -->
      <div class="footer-row"></div>
      <div class="row">
        <div class="col">
          <span class="footer-copy">&copy; AGESCI Associazione Guide e Scouts Cattolici Italiani</span>
        </div>
        <div class="col">
          <ul class="navbar-nav mr-auto footer-menu">
            <?php if (has_nav_menu('footer-menu')) {
              wp_nav_menu(array('theme_location' => 'footer-menu'));
            } ?>
        </ul>
        </div>
      </div><!-- .row -->
    </div><!-- .container -->
  </footer>

  

  <script src="<?php echo get_bloginfo('template_directory'); ?>/js/jquery-3.2.1.slim.min.js"></script>
  <script src="<?php echo get_bloginfo('template_directory'); ?>/js/bootstrap.min.js"></script>
  <script src="<?php echo get_bloginfo('template_directory'); ?>/js/app.js"></script>
</body>
</html>