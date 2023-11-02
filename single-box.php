<?php get_header(); ?>

  <main>
    <div class="container single-page">

      <div class="row">
        <section class="col">
          <?php while ( have_posts() ) : the_post(); global $post; ?>

            <article class="<?php echo $post->post_name;?>">
              <div class="box-page-title">
                <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="Box image">
                <div class="box-page-title-wrap">
                  <h1 class="page-title"><?php the_title(); ?></h1>
                  <h2 class="page-subtitle"><?php the_excerpt(); ?></h2>
                </div>
              </div>

              <div class="box-map row">
                <div class="col-12 col-md-6 box-map-italy">
                  <?php echo get_italy_map(); ?>
                </div>
                <div class="col-12 col-md-6">
                  <div class="region-details">
                    <p class="region-details-title">
                      I Gruppi della Regione <span class="region-details-name">Lazio</span> che hanno scelto di essere felici così
                    </p>
                    <ul></ul>
                  </div>
                </div>
              </div>
              
              <h2 class="box-headline">Potrebbe interessarti...</h2>
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