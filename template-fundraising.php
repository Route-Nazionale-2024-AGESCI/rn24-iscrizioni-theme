<?php /* Template Name: Fundraising */
get_header('empty'); ?>
 <?php while ( have_posts() ) : the_post(); ?>
<main>
  <div class="top-image" style="background-image: url(<?php echo get_bloginfo('url'); ?>/wp-content/uploads/2023/10/carosello_iscrizioni_3.jpg)">
    <div class="page-title-wrap">
      <h1 class="page-title"><?php the_title(); ?></h1>
    </div>
</div>
    <div class="container single-page fundraising-page">

      <div class="row">
        <section class="col-12 col-md-6">
          <h2>Donazione Singola</h2>
          <div class="donation-wrap">
              <ul class="import-value">
                <li><a target="_blank" href="https://www.paypal.com/donate/?hosted_button_id=ZG5F22HSJFEFA">25 €</a></li>
                <li><a target="_blank" href="https://www.paypal.com/donate/?hosted_button_id=ZG5F22HSJFEFA">50 €*</a></li>
                <li><a target="_blank" href="https://www.paypal.com/donate/?hosted_button_id=ZG5F22HSJFEFA">75 €</a></li>
              </ul>

              <p class="socio-sostenitore">*così da diventare SOCIO SOSTENITORE AGESCI e ricevere l'abbonamento annuale a Proposta educativa (la rivista associativa per i Capi), la newsletter periodica e l'adesivo dei sostenitori.</p>
              <p class="socio-azienda">
                Sei un'AZIENDA e sei interessato a SOSTENERCI? <a href="mailto:fundraising@rn24.agesci.it">Contattaci</a>
              </p>
          </div>
          
        </section>
        <section class="col-12 col-md-6">
         <p class="fund-quote">
          <span>Il vero modo di essere felici è quello di procurare la felicità agli altri</span> BP
        </p> 
        <p>
        Puoi donare anche con:
        - bonifico bancario a xxxxxx

        - bollettino postale al conto corrente postale n xxxx
        </p>
        <p>Scopri le <a href="<?php echo get_bloginfo('url'); ?>/agevolazioni-fiscali/">Agevolazioni Fiscali</a></p>
          
        </section>
      </div><!-- .row -->
    </div><!-- .container -->
  </main>
  <?php endwhile; ?>
<?php get_footer(); ?>