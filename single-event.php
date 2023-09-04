<?php
if (!is_user_logged_in()) {
	wp_redirect(site_url('/login'));
	exit();
}
get_header(); ?>

  <main>
    <div class="container event">
      <div class="row">
        <section class="col">
          <article id="post-<?php the_ID(); ?>">
            <h1 class="page-title"><?php the_title(); ?></h1>

            <div class="event-wrapper">
                    <?php 
                        if (is_active_sidebar('banner_evento')) { ?>
                        <div class="event-header"><?php
                            dynamic_sidebar( 'banner_evento' );
                        ?>
                        </div>
                        <?php }
                    ?>
                <?php the_content(); ?>
            </div>
          </article>
        </section>
      </div><!-- .row -->
    </div><!-- .container -->
  </main>
  
  <?php get_footer(); ?>