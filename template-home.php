<?php /* Template Name: Home */
if (is_user_logged_in() && get_permalink() == home_url('/')) {
	wp_redirect(site_url('inizia'));
	exit();
}
get_header(); ?>

<main>
    <div class="container single-page">

      <div class="row">
        <section class="col">
          <?php while ( have_posts() ) : the_post(); ?>

            <article>
              <h1 class="page-title"><?php the_title(); ?></h1>

              <div class="page-content">
              <?php the_content(); ?>
                </div>
              
            </article>

          <?php endwhile; ?>
        </section>
      </div><!-- .row -->
    </div><!-- .container -->
  </main>

<?php get_footer(); ?>