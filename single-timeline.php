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
            $terms = get_the_terms( $post->ID, 'timeline_categories' ); 
            if (isset($terms) && count($terms) > 0) {
              $category = $terms[0]->slug;
            }
          ?>

            <article class="<?php echo $post->post_name;?>">
            <?php if ($category != null) : ?>
                            <p class="page-title-icon-category <?php echo $category;?>">
                              <img src="<?php echo get_bloginfo('template_directory'); ?>/img/<?php echo $category;?>.png" alt="Tipologia evento">
                            </p>
                            <?php endif; ?>
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