<?php /* Template Name: Tangrams */
get_header(); ?>

<main>
    <div class="container single-page tangrams">

      <div class="row">
        <section class="col">
        <article class="tangram-images">
          <h1 class="page-title"><?php the_title(); ?></h1>
          <div class="page-content text-left">
          <?php 
          global $wpdb;    
    
          $pageSize = 25;
          $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;

          $sql = "SELECT count(*)
          FROM wp_usermeta um
          WHERE um.meta_key = '_happy_description'";
          $totalResults = intval($wpdb->get_var($sql)); ?>

          <div class="total-images"><b><?php echo $totalResults;?></b> risultati</div>

          <?php $sql = "SELECT u.user_login AS codice, u.display_name AS display_name, g.zona, g.regione,
          (SELECT p.post_title FROM wp_usermeta umb 
          LEFT JOIN wp_posts p ON p.ID = umb.meta_value where umb.meta_key = '_selected_box'
          and umb.user_id = u.ID) AS selected_box,
          (SELECT umb.meta_value FROM wp_usermeta umb where umb.meta_key = 'tangram_photo' and umb.user_id = u.ID) AS tangram_photo,
          um.meta_value as descrizione
          FROM wp_usermeta um
          LEFT JOIN wp_users u ON u.ID = um.user_id
          LEFT JOIN rn24_gruppi g ON g.codice_gruppo = u.user_login
          WHERE um.meta_key = '_happy_description'
          ORDER BY u.display_name limit ".($pageSize * $offset).", ".$pageSize.";";
      
          $result = $wpdb->get_results($sql);
          
          foreach ($result as &$value): ?>
              <a style="background-image: url(<?php echo $value->tangram_photo;?>)" 
                href="<?php echo $value->tangram_photo;?>" target="_blank" class="tangram-image-coca">
                <span class="tangram-image-name"><?php echo $value->display_name;?></span>             
              </a>

          <?php endforeach; ?>
          </div>

            <div class="image-navs">
            <?php if ($offset > 0) : ?>
            <div class="wp-block-button"><a class="wp-block-button__link wp-element-button" 
            href="https://rn24.agesci.it/immagini-di-felicita/?offset=<?php echo $offset - 1; ?>">Indietro</a></div>
            <?php endif;?>
            <div class="pages">Pagina <b><?php echo $offset + 1;?></b> di <b><?php echo intval($totalResults / $pageSize) + 1 ;?></b></div>
            <?php if ($offset < intval($totalResults / $pageSize)) : ?>
            <div class="wp-block-button"><a class="wp-block-button__link wp-element-button" 
            href="https://rn24.agesci.it/immagini-di-felicita/?offset=<?php echo $offset + 1; ?>">Avanti</a></div>
            <?php endif; ?>
          </div>

          </article>
        </section>
      </div><!-- .row -->
    </div><!-- .container -->
  </main>

<?php get_footer(); ?>