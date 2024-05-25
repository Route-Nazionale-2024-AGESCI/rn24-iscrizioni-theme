<?php /* Template Name: Sostenibilità */
get_header(); ?>

<main>
    <div class="container single-page timeline-page">

      <div class="row">
        <section class="col">
          <?php while ( have_posts() ) : the_post(); ?>

            <article>
              <h1 class="page-title"><?php the_title(); ?></h1>

              <div class="page-content container">

                <?php the_content(); ?>

                <div class="timeline-wrapper">
                <?php 
                  $args = array(
                    'post_type' => 'sustainability',
                    'posts_per_page' => -1,
                    'orderby'   => array(
                      'date' =>'DESC',
                      'menu_order'=>'ASC',
                     )
                  );
                  $query = new WP_Query($args);
                  
                  if ($query->have_posts() ):
                    while ( $query->have_posts() ) : $query->the_post();
                    $id = get_the_ID();
                    $event_date = get_the_date('d F');
                    $event_year = get_the_date('Y');
                    $event_fulldate = get_the_date('d-m-Y');

                    $passed = false;
                    if (isset($event_fulldate)) {
                      $passed = time() >= strtotime($event_fulldate);
                    }
                    ?>

                  <div class="timeline-card row <?php echo $passed ? 'passed' : '';?>">
                     <div class="timeline-date d-none d-md-block col-3">
                        <div>
                          <p class="timeline-date-year"><?php echo $event_year; ?></p>
                          <p class="timeline-date-month"><?php echo $event_date; ?></p>
                        </div>
                      </div>
                      <div class="col-1 d-block d-md-none"></div>
                      <div class="timeline-divider col-1">
                        <img src="<?php echo get_bloginfo('template_directory'); ?>/img/Ellipse_<?php echo $passed ? 'full' : 'empty';?>.svg" alt="Ellipse">
                      </div>
                      <div class="d-block d-md-none timeline-top-date">
                          <p class="timeline-date-year"><?php echo $event_year; ?> <span class="timeline-date-month"><?php echo $event_date; ?></span></p>
                        </div>
                      <div class="timeline-content col-md-8 col-10 row">
                        <div class="timeline-image col-4 <?php echo $category;?>" style="background-image: url(<?php echo get_the_post_thumbnail_url(); ?>);"></div>
                        <div class="timeline-data col-8">
                          <a href="<?php echo the_permalink();?>">
                            <p class="timeline-event-title"><?php the_title(); ?></p>
                          </a>
                          <div class="timeline-event-abstract sustainability"><?php the_excerpt(); ?></div>
                        </div>
                      </div> 
                  </div>

                  <?php endwhile; endif; ?>
                 
                </div>

              </div>
              
            </article>

          <?php endwhile; ?>
        </section>
      </div><!-- .row -->
    </div><!-- .container -->
  </main>

<?php get_footer(); ?>