<?php /* Template Name: Area Comunità capi */
get_header(); ?>

<main>
    <div class="container single-page coca-area">

      <div class="row">
        <section class="col-12">
          <?php while ( have_posts() ) : the_post(); ?>

            <article>
              

              <div class="row">
                <aside class="col-md-4 col-12 coca-sidebar d-none d-md-block">
                <img src="<?php echo get_bloginfo('template_directory'); ?>/img/AGESCI.svg" 
                  class="agesci-aside" alt="AGESCI">
                  <?php global $current_user;
                      wp_get_current_user();?>
                      <h2 class="coca-name"><?php echo $current_user->display_name; ?></h2>
                      <h3 class="coca-email"><?php echo $current_user->user_email; ?></h3>
                      <ul class="coca-menu">
                        <a href="<?php echo site_url('/eventi/le-mie-prenotazioni');?>" class="<?php echo str_contains(get_permalink(), '/le-mie-prenotazioni') ? 'active' : '';?>">
                          <li><i class="fa fa-bookmark" aria-hidden="true"></i>Prenotazioni</li>
                        </a>
                        <a href="<?php echo site_url('/box-coca');?>" class="<?php echo str_contains(get_permalink(), '/box-coca') ? 'active' : '';?>">
                          <li><i class="fa fa-archive" aria-hidden="true"></i>Il tangram</li>
                        </a>
                        <a href="<?php echo site_url('/azioni-di-felicita');?>" class="<?php echo str_contains(get_permalink(), '/azioni-di-felicita') ? 'active' : '';?>">
                          <li><i class="fa fa-smile-o" aria-hidden="true"></i>Azioni di felicità</li>
                        </a>
                      </ul>
                </aside>
                <div class="col-md-7 col-12 offset-md-1">
                  <h1 class="page-title"><?php the_title(); ?></h1>
                  <div class="page-content text-left">
                    
                    <?php the_content(); ?>
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