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

              <div class="wp-block-columns is-layout-flex wp-container-core-columns-is-layout-1 wp-block-columns-is-layout-flex">
                <div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:66.66%">
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
                     <div class="timeline-date d-none d-md-block col-1">
                      </div>
                      <div class="col-1 d-block d-md-none"></div>
                      <div class="d-block d-md-none timeline-top-date">
                        </div>
                      <div class="timeline-content col-md-10 col-10 row">
                        <div class="timeline-image col-6" style="background-image: url(<?php echo get_the_post_thumbnail_url(); ?>);"></div>
                        <div class="timeline-data col-6">
                          <a href="<?php echo the_permalink();?>">
                            <p class="timeline-event-title"><?php the_title(); ?></p>
                          </a>
                          <div class="timeline-event-abstract sustainability"><?php the_excerpt(); ?></div>
                        </div>
                      </div>
                      <div class="timeline-date d-none d-md-block col-1">
                      </div>
                  </div>

                  <?php endwhile; endif; ?>
                 
                </div>

                </div>



                <div class="wp-block-column arena24-altri-eventi has-background is-layout-flow wp-block-column-is-layout-flow" style="background-color:#ececec;flex-basis:33.33%">
                <p><strong>Il programma del villaggio della sostenibilità</strong></p>


                <div class="wp-block-image">
                <figure class="aligncenter size-full is-resized"><a href="https://rn24.agesci.it/wp-content/uploads/2024/08/Arena24_Modulo-Incontri_Villaggio-della-Sostenibilita.pdf" target="_blank" rel="noreferrer noopener"><img fetchpriority="high" decoding="async" width="420" height="595" src="https://rn24.agesci.it/wp-content/uploads/2024/08/Arena24_Villaggio-della-SOST_cop-programma.jpg" alt="" class="wp-image-2705" style="width:143px;height:auto" srcset="https://rn24.agesci.it/wp-content/uploads/2024/08/Arena24_Villaggio-della-SOST_cop-programma.jpg 420w, https://rn24.agesci.it/wp-content/uploads/2024/08/Arena24_Villaggio-della-SOST_cop-programma-212x300.jpg 212w" sizes="(max-width: 420px) 100vw, 420px"></a></figure></div>


                <p></p>

                <hr class="wp-block-separator has-alpha-channel-opacity">

                <p><strong>Impatto sociale – aspettative dei partecipanti</strong></p>



                <figure class="wp-block-image size-large"><a href="https://rn24.agesci.it/wp-content/uploads/2024/08/240605_AGESCI_Impatto_Sintesi-esiti-survey_1.pdf" target="_blank" rel="noreferrer noopener"><img decoding="async" width="1024" height="576" src="https://rn24.agesci.it/wp-content/uploads/2024/08/240605_AGESCI_Impatto_Sintesi-esiti-survey_1_Pagina_01-1024x576.jpg" alt="" class="wp-image-2698" srcset="https://rn24.agesci.it/wp-content/uploads/2024/08/240605_AGESCI_Impatto_Sintesi-esiti-survey_1_Pagina_01-1024x576.jpg 1024w, https://rn24.agesci.it/wp-content/uploads/2024/08/240605_AGESCI_Impatto_Sintesi-esiti-survey_1_Pagina_01-300x169.jpg 300w, https://rn24.agesci.it/wp-content/uploads/2024/08/240605_AGESCI_Impatto_Sintesi-esiti-survey_1_Pagina_01-768x432.jpg 768w, https://rn24.agesci.it/wp-content/uploads/2024/08/240605_AGESCI_Impatto_Sintesi-esiti-survey_1_Pagina_01-1536x864.jpg 1536w, https://rn24.agesci.it/wp-content/uploads/2024/08/240605_AGESCI_Impatto_Sintesi-esiti-survey_1_Pagina_01-2048x1152.jpg 2048w" sizes="(max-width: 1024px) 100vw, 1024px"></a></figure>
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