<?php
if (!is_user_logged_in()) {
	wp_redirect(site_url('/login'));
	exit();
}
global $EM_Booking;
get_header(); ?>

  <main>
    <div class="container event">
      <div class="row">
        <section class="col">
          <article id="post-<?php the_ID(); ?>">
            <h1 class="page-title"><?php the_title(); ?></h1>

            <div class="event-wrapper">
                    <?php 
                    if (empty($EM_Booking) || empty($EM_Booking->booking_id)) {
                      if (is_active_sidebar('banner_evento')) { ?>
                        <div class="event-header"><?php
                            dynamic_sidebar( 'banner_evento' );
                        ?>
                        </div>
                        <?php }
                         the_content();
                    } else { ?>
                <div class="alert alert-success" role="alert">
                      <h4 class="alert-heading">Prenotazione effettuata con successo!</h4>
                      <p class="mb-0">Verifica la casella e-mail istituzionale per procedere con il pagamento</p>
                  </div>
                <?php }  ?>
            </div>
          </article>
        </section>
      </div><!-- .row -->
    </div><!-- .container -->
  </main>
  
  <?php get_footer(); ?>