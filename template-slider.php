<?php /* Template Name: Slider */
get_header(); ?>

<main>
    <div class="container single-page">

      <div class="row">
        <section class="col">
          <?php while ( have_posts() ) : the_post(); ?>
            <article>
              <div id="slideshow-wrapper">
                <div id="slideshow">
                  <div>
                    <img src="https://rn24.agesci.it/wp-content/uploads/2024/01/posa_Sostienici_1.jpg">
                  </div>
                  <div>
                    <img src="https://rn24.agesci.it/wp-content/uploads/2024/01/posa_Sostienici_2.jpg">
                  </div>
                  <div>
                    <img src="https://rn24.agesci.it/wp-content/uploads/2024/01/posa_Sostienici_3.jpg">
                  </div>
                  <div>
                    <img src="https://rn24.agesci.it/wp-content/uploads/2024/01/posa_Sostienici_4.jpg">
                  </div>
                </div>
              </div>
            
              <h1 class="page-title"><?php the_title(); ?></h1>

              <div class="page-content text-left">
              <?php the_content(); ?>
                </div>
              
            </article>

          <?php endwhile; ?>
        </section>
      </div><!-- .row -->
    </div><!-- .container -->
  </main>

<?php get_footer(); ?>