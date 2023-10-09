<?php /* Template Name: Timeline */
get_header(); ?>

<main>
    <div class="container single-page">

      <div class="row">
        <section class="col">
          <?php while ( have_posts() ) : the_post(); ?>

            <article>
              <h1 class="page-title"><?php the_title(); ?></h1>

              <div class="page-content container">

                <?php the_content(); ?>

                <div class="main-timeline-2 timeline">
                <?php 
                  $args = array(
                    'post_type' => 'timeline',
                    'posts_per_page' => -1,
                    'orderby'        => 'event_order',
                    'order'          => 'ASC'
                  );
                  $query = new WP_Query($args);
                  
                  if ($query->have_posts() ):
                    $count = 0;
                    while ( $query->have_posts() ) : $query->the_post();
                    $id = get_the_ID();
                    $event_date = get_post_meta( $id, 'event_date', true );
                    ?>

                  <div class="timeline-2 <?php echo $count % 2 == 0 ? 'left' : 'right' ?>-2">
                    <div class="card">
                      <div class="card-img-top" style="background-image: url(<?php echo get_the_post_thumbnail_url(); ?>);"></div>
                      <div class="card-body p-4">
                        <h4 class="fw-bold mb-4"><?php the_title(); ?></h4>
                        <p class="text-muted mb-4"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $event_date; ?></p>
                        <p class="mb-0"><?php the_content(); ?></p>
                      </div>
                    </div>
                  </div>

                  <?php $count++; endwhile; endif; ?>
                 
                </div>

              </div>
              
            </article>

          <?php endwhile; ?>
        </section>
      </div><!-- .row -->
    </div><!-- .container -->
  </main>

<?php get_footer(); ?>