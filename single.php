<?php get_header(); ?>

  <main>
    <div class="container">
      <div class="row">
        <section class="col">
          <article id="post-<?php the_ID(); ?>">
            <h1><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
            <small><?php echo get_the_date('j F Y'); ?></small>
            <?php the_content(); ?>
          </article>
          <?php if (comments_open() || get_comments_number()) { comments_template(); } ?>
        </section>
      </div><!-- .row -->
    </div><!-- .container -->
  </main>
  
  <?php get_footer(); ?>