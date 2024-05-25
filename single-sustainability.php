<?php 
if (str_contains(get_permalink(), '/timeline/felici-di-box-per-lapprofondimento')) {
  wp_redirect( get_site_url().'/scatole/', 301 ); 
  exit;
}
get_header(); ?>

  <main>
    <div class="container single-page">

      <div class="row">
        <section class="col">
          <?php while ( have_posts() ) : the_post(); global $post; 
            $category = null;
          ?>

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