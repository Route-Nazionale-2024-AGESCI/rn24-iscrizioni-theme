<?php /* Template Name: Mappa */
get_header(); ?>

<main>
    <div class="container single-page">

      <div class="row">
        <section class="col">
          <?php while ( have_posts() ) : the_post(); ?>

            <article>
              <h1 class="page-title"><?php the_title(); ?></h1>

              <div class="page-content text-left">
                <?php the_content(); ?>
                <!--<div id="map" style="width: 100%;min-height: 660px;"></div>-->
              </div>

              <h2 class="box-headline">Generazioni Felici di...</h2>
              <p class="box-subtitle">La felicità di oggi è forse l'elemento imprescindibile che testimonia come la vita buona e piena proposta dal Vangelo è vera e praticabile. Scopri come le altre Comunità capi hanno scelto di essere felici.</p>


              <div class="boxes row">
              <?php $args = array(
                    'post_type' => 'box',
                    'posts_per_page' => -1,
                    'meta_key'  => 'box_number',
                    'meta_type' => 'NUMERIC',
                    'orderby' => 'meta_value_num',
                    'order'          => 'ASC'
                  );
                  $query = new WP_Query($args);
                  
                  if ($query->have_posts() ): 
                    while ( $query->have_posts() ) : $query->the_post();
                    $id = get_the_ID();
                  ?>
                  <div class="box-wrapper-container col-12 col-sm-6 col-md-4 col-lg-3 <?php echo 'box-id-'.$id;?>">
                      <div class="box-wrapper">
                        <div class="box-image">
                          <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="Box image">
                        </div>
                        <p class="box-title"><?php the_title(); ?></p>

                        <?php 
                        global $wpdb; $results = $wpdb->get_results(" SELECT count(*) as 'box_coca' FROM $wpdb->usermeta WHERE meta_key = '_selected_box' AND meta_value = '$id'"); ?>
                        <p class="box-counter"><b><?php echo $results[0]->box_coca; ?></b> Comunità capi</p>
                        <a href="<?php echo the_permalink();?>"><button class="btn btn-primary">Scopri di più</button></a>
                      </div>
                  </div>
                  

                    <?php endwhile; endif; ?>
                </div>              
              
            </article>

          <?php endwhile; ?>
        </section>
      </div><!-- .row -->
    </div><!-- .container -->
  </main>

<?php get_footer(); ?>