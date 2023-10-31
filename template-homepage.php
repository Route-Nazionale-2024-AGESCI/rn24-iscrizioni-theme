<?php /* Template Name: Homepage */
get_header('', array( 'logo' => 'AGESCI.svg.png' )); ?>

<main>
    <div class="container single-page">

      <div class="row">
        <section class="col">
          <?php while ( have_posts() ) : the_post(); ?>

            <article>
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