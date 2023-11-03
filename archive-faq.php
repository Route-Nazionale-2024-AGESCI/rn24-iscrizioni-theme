<?php /* Template Name: FAQ */
get_header(); ?>

<main>
    <div class="container single-page faq-page">

      <div class="row">
        <section class="col">

            <article>
              <h1 class="page-title">FAQ</h1>

              <div class="page-content container">

                <?php 
                $page = get_page_by_path( 'faq-info' );
                echo $page->post_content; ?>

                <ul class="faq-wrapper">
                <?php 
                  $args = array(
                    'post_type' => 'faq',
                    'posts_per_page' => -1,
                    'orderby'   => array(
                      'date' =>'ASC'
                     )
                  );
                  $query = new WP_Query($args);
                  
                  if ($query->have_posts() ):
                    while ( $query->have_posts() ) : $query->the_post(); ?>

                  <li class="faq-item row">
                    <div class="faq-header">
                      <span class="faq-title"><?php the_title(); ?></span>
                      <i class="fa fa-plus-circle faq-plus" aria-hidden="true"></i>
                    </div>
                    <div class="faq-content"><?php the_content(); ?></div>
                  </li>

                  <?php endwhile; endif; ?>
                 
                  </ul>

                <div class="faq-disclaimer">

                    <div class="faq-disclaimer-icon">
                      <img class="faq-email" src="<?php echo get_bloginfo('template_directory'); ?>/img/email.svg" alt="Email">
                    </div>
                    <div class="faq-disclaimer-text">
                      Per tutti i casi che non rientrano in queste FAQ, scrivici all'indirizzo <a href="mailto:iscrizioni@rn24.agesci.it">iscrizioni@rn24.agesci.it</a>
                    </div>

                  </div>

              </div>
              
            </article>
        </section>
      </div><!-- .row -->
    </div><!-- .container -->
  </main>

<?php get_footer(); ?>