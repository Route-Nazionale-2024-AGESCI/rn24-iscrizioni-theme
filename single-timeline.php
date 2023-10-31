<?php get_header(); ?>

  <main>
    <div class="container single-page">

      <div class="row">
        <section class="col">
          <?php while ( have_posts() ) : the_post(); global $post; ?>

            <article class="<?php echo $post->post_name;?>">
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