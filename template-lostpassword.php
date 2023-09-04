<?php /* Template Name: Lost Password */
$reset_password_requested = false;
$reset_password_ok = false;
$reset_password_error = false;
if (isset($_POST['username'])) {
  $user = get_user_by('email', $_POST['username']);
  if ( ! empty( $user ) ) {
    $reset_key = get_password_reset_key($user);
    $reset_password_requested = true;
    // Send password reset email to the user
    try {
      $template = prepare_recover_password_email($_POST['username'], get_group_denominazione_from_ordinale($user->user_login, $user->user_login), $reset_key);
      $result = wp_mail($_POST['username'], 'Recupera password RN24', $template);  
    } catch (Exception $e) {
        var_dump($e);
    }
  }
} else if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['repeat-password'])) {
  $user = get_user_by('email', $_POST['email']);
  $user = check_password_reset_key($_POST['key'], $user->user_login);
  if ( ! empty( $user ) ) {
    if($user instanceof WP_Error) {
      $reset_password_error = true;
    } else {
      wp_update_user(array( 
        'ID' => $user->ID,
        'user_pass' => $_POST['password']
      ));
      $reset_password_ok = true;
    }
  } else {
    $reset_password_error = true;
  }
}
get_header(); ?>

  <main>
    <div class="container single-page">

      <div class="row">
        <section class="col">
          <?php while ( have_posts() ) : the_post(); ?>

            <article>
              <h1 class="page-title">Recupera password</h1>

              <div class="page-content">
              <?php if (!$reset_password_requested && !$reset_password_ok && !$reset_password_error) { ?>
                <?php if (!isset($_GET['key'])) {?>
                  <p class="has-text-align-center">Inserisci l'indirizzo <b>e-mail istituzionale</b> per ricevere la nuova password di accesso</p>
                <?php } else { ?>
                  <p class="has-text-align-center">Scegli una nuova password per l'accesso</p>
                <?php } ?>
                <form name="form-reset-pwd" id="form-reset-pwd" action="" method="post">
                  <div class="form-group login-username">
                    <label for="username">E-mail</label>
                    <input type="text" name="username" id="username" autocomplete="username" 
                      <?php echo isset($_GET['key']) ? 'disabled' : ''; ?>
                      value="<?php echo isset($_GET['email']) ? $_GET['email'] : ''; ?>" class="form-control w-100" />
                  </div>
                  <input type="hidden" name="email" id="email"
                      value="<?php echo isset($_GET['email']) ? $_GET['email'] : ''; ?>" />
                  <input type="hidden" name="key" id="reset-key"
                      value="<?php echo isset($_GET['key']) ? $_GET['key'] : ''; ?>" />
                  <?php if (isset($_GET['key'])) {?>
                    <div class="form-group login-password">
                      <label for="password">Password</label>
                      <input type="password" required name="password" id="password" autocomplete="password" 
                        class="form-control w-100" />
                    </div>
                    <div class="form-group login-password">
                      <label for="password">Ripeti password</label>
                      <input type="password" required name="repeat-password" id="repeat-password" autocomplete="repeat-password" 
                        class="form-control w-100" />
                        <div class="invalid-feedback">
                          Le password inserite non coincidono
                        </div>
                    </div>
                    <?php } ?>
                  <button type="submit" name="wp-submit" id="reset-password-btn" class="btn btn-primary">Recupera password</button>
                  <a href="<?php echo site_url('/login'); ?>" class="lost-password-url">Torna alla login</a>
                </form>
                <?php } else if ($reset_password_requested) { ?>
                  <div class="alert alert-success" role="alert">
                      <h4 class="alert-heading">Reset password richiesta!</h4>
                      <p class="mb-0">Verifica la casella email che hai indicato per completare la procedura.</p>
                  </div>
                  <?php } else if ($reset_password_ok) { ?>
                  <div class="alert alert-success" role="alert">
                  Password modificata con successo
                  </div>
                  <?php } else if ($reset_password_error) { ?>
                  <div class="alert alert-danger" role="alert">
                    Si è verificato un errore nella procedura di recupero della password. Riprovare.
                  </div>
                  <?php } ?>
                </div>
            </article>

          <?php endwhile; ?>
        </section>
      </div><!-- .row -->
    </div><!-- .container -->
  </main>

<?php get_footer(); ?>