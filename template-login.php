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
              <p class="has-text-align-center">Per accedere utilizza l'indirizzo <b>e-mail istituzionale</b>
              e la password ricevuta in fase di registrazione</p>
                <?php
                if ( ! is_user_logged_in() ) {
                    $args = array (
                        'redirect' => site_url(),
                        'form_id' => 'rn24_loginform',
                        'label_username' => __( 'E-mail' ),
                        'label_password' => __( 'Password' ),
                        'label_log_in' => __( 'Entra' ),
                        'remember' => false
                    );
                    rn24_wp_login_form( $args );
                }?>
                </div>
              
            </article>

          <?php endwhile; ?>
        </section>
      </div><!-- .row -->
    </div><!-- .container -->
  </main>

<?php get_footer(); ?>