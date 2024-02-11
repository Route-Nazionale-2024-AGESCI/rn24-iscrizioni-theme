<?php get_header(); ?>

  <main>
    <div class="container">
      <div class="row">
        <section class="col">
          <article>
                <h1 class="page-title">Canzoni</h1>

                <?php while ( have_posts() ) : the_post(); 
                
                $id = get_the_ID();
                $lyrics_link = get_post_meta( $id, 'lyrics_link', true );
                $karaoke_link = get_post_meta( $id, 'karaoke_link', true );
                $preview_link = get_post_meta( $id, 'preview_link', true );
                $chords_link = get_post_meta( $id, 'chords_link', true );
                ?>

                <article class="post-song" id="post-<?php the_ID(); ?>">
                  <div class="row">
                    <div class="col-3">
                      <img src="<?php echo get_the_post_thumbnail_url();?>" class="song-image">
                    </div>
                    <div class="col-8 song-details">
                      <h2><?php the_title(); ?></h2>
                      <h3 class="song-authors"><i class="fa fa-microphone" aria-hidden="true"></i> <?php the_excerpt(); ?></h3>
                      <div class="song-play">
                      <i class="fa fa-headphones" aria-hidden="true"></i>
                      <span class="enter-song"><b>L'hai già imparata?</b> Fai il test con la versione <a href="<?php echo $karaoke_link;?>" target="_blank">Karaoke</a></span>
                      </div>
                    </div>
                    <div class="col-1 play-btn">
                        <a target="_blank" href="<?php echo $lyrics_link;?>"><i class="fa fa-play-circle-o" aria-hidden="true"></i></a>
                    </div>
                  </div>
                  <div class="row song-bottom-links">
                      <div class="col-6">
                        <a target="_blank" href="<?php echo $preview_link;?>"><i class="fa fa-youtube-play" aria-hidden="true"></i> Video lancio</a>
                      </div>
                      <div class="col-6 text-right song-links">
                        <a target="_blank" href="<?php echo $lyrics_link;?>"><i class="fa fa-music" aria-hidden="true"></i> Lyrics</a>
                        <a target="_blank" href="<?php echo $chords_link;?>"><i class="fa fa-music" aria-hidden="true"></i> Accordi</a>
                      </div>
                  </div>
                </article>

                <?php endwhile; // end of the loop. ?>

          </article>
            
          
        </section>
      </div><!-- .row -->
    </div><!-- .container -->
  </main>
  
  <?php get_footer(); ?>