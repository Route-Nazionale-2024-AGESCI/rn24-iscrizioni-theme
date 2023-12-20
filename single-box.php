<?php get_header(); ?>

  <main>
    <div class="container single-page">

      <div class="row">
        <section class="col">
          <?php while ( have_posts() ) : the_post(); global $post; 
          $id = get_the_ID();
          $video_url = get_post_meta( $id, 'box_video', true );
          ?>

            <article class="<?php echo $post->post_name;?>">
              <div class="box-page-title">
                <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="Box image">
                <div class="box-page-title-wrap">
                  <h1 class="page-title"><?php the_title(); ?></h1>
                  <h2 class="page-subtitle"><?php the_excerpt(); ?></h2>
                </div>
              </div>

              <div class="box-map row">
                <div class="col-12 col-md-7 coca-sidebar">
                    <?php the_content(); ?>
                </div>


                <div class="col-12 col-md-4 offset-md-1 box-map-italy">
                  <?php echo get_italy_map(); ?>
                  <div class="region-details">
                    <p class="region-details-title region-details-title-empty">
                      Seleziona una <span class="region-details-name">Regione</span> per scoprire i Gruppi che hanno scelto questi contenuti
                    </p>
                    <p class="region-details-title d-none">
                      I Gruppi della Regione <span class="region-details-name">Lazio</span> che hanno scelto questi contenuti
                    </p>
                    <ul></ul>
                  </div>
                </div>
                
              </div>
              
            </article>

          <?php endwhile; ?>
        </section>
      </div><!-- .row -->
    </div><!-- .container -->
  </main>

<?php get_footer(); ?>