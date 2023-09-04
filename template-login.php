<?php /* Template Name: Login */
get_header(); ?>

  <main>
    <div class="container single-page">

      <div class="row">
        <section class="col">
          <?php while ( have_posts() ) : the_post(); ?>

            <article>
              <h1 class="page-title">Accedi</h1>

              <div class="page-content">
                <?php
                if ( ! is_user_logged_in() ) { ?>
                <p class="has-text-align-center">Per accedere utilizza l'indirizzo <b>e-mail istituzionale</b>
              e la password ricevuta in fase di registrazione</p>
                  <?php if (isset($_GET['error-login'])) { ?>
                  <div class="alert alert-danger" role="alert">
                    Le credenziali inserite non sono corrette
                  </div>
                  <?php } ?>
                  <?php
                    $args = array (
                        'redirect' => site_url(),
                        'form_id' => 'rn24_loginform',
                        'label_username' => __( 'E-mail' ),
                        'label_password' => __( 'Password' ),
                        'label_log_in' => __( 'Entra' ),
                        'value_username' => isset($_GET['email']) ? $_GET['email'] : '',
                        'remember' => false
                    );
                    rn24_wp_login_form( $args );
                  } else {
                    global $current_user;
                    wp_get_current_user();
                  ?>
                <p class="has-text-align-center">Hai effettuato l'accesso come <b><?php echo $current_user->display_name; ?></b></p>
                <a class="logout-btn-login btn btn-primary" href="<?php echo wp_logout_url( home_url() ); ?>" title="Logout">Logout</a>
                <?php } ?>
                </div>
            </article>

          <?php endwhile; ?>
        </section>
      </div><!-- .row -->
    </div><!-- .container -->
  </main>

<?php get_footer(); ?>