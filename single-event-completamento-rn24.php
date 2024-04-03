<?php
if (!is_user_logged_in()) {
	wp_redirect(site_url('/login'));
	exit();
}
use BookingSyncUtils as BSUtils;

$em_event = new EM_Event(get_the_ID(), 'post_id');
$em_person = new EM_Person(get_current_user_id());
$user_bookings = $em_person->get_bookings();

$data = null;
$user_booking = null;
foreach ( $user_bookings as $booking ) {
    if ( $booking->event_id == $em_event->event_id ) {
      $user_booking = $booking;
      $data = BSUtils\get_data();
      break;
    }
}

get_header(); ?>

  <main>
    <div class="container event">
      <div class="row">
        <section class="col">
          <article id="post-<?php the_ID(); ?>">
            <h1 class="page-title"><?php the_title(); ?></h1>

            <div class="event-wrapper">
                    <?php 
                    if (is_null($user_booking)) {
                      ?>
                      <div class="alert alert-banner" role="alert">
                          <h4 class="alert-heading">Prenotazione non trovata!</h4>
                          <p class="mb-0">Contattaci per assistenza</p>
                      </div>
                      <?php
                    
                    }
                    // status in attesa di pagamento
                    elseif ($booking->booking_status === 5) {
                      ?>
                      <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">Prenotazione effettuata con successo!</h4>
                        <p class="mb-0">Abbiamo quasi finito!</p>
                        
                    </div>
                    <h3>Istruzioni per effettuare il pagamento</h3>
                    <table class="w-100">
                          <tbody>
                            <tr>
                              <th>IBAN:</th>
                              <td>IT75F0501803200000015112105</td>
                            </tr>
                            <tr>
                              <th>INTESTAZIONE:</th>
                              <td>AGESCI-Associazione Guide e Scouts Cattolici Italiani </td>
                            </tr>
                            <tr>
                              <th>CAUSALE:</th>
                              <td>ISCRIZIONE RN24 <?php echo $em_person->user_login; ?> <?php echo $booking->booking_id; ?></td>
                            </tr>
                            <tr>
                              <th>TOTALE:</th>
                              <td><?php echo $booking->get_price(true); ?></td>
                            </tr>
                          </tbody>
                        </table>

                      
                      <?php
                    } elseif ($booking->booking_status === 1) { ?>
                    <div class="alert alert-success" role="alert">
                      <h4 class="alert-heading">Prenotazione completata con successo!</h4>
                      <p class="mb-0">Abbiamo ricevuto il tuo pagamento, hai concluso il processo di prenotazione.</p>
                  </div>
                <?php } else { ?>
                  <div class="alert alert-banner" role="alert">
                          <h4 class="alert-heading">Qualcosa è andato storto!</h4>
                          <p class="mb-0">Contattaci per assistenza</p>
                      </div>
                      
                <?php } 
                
                  if($booking && in_array($booking->booking_status, [1, 5])) {
                ?>
                  <hr />
                      <h4>Informazioni sulla prenotazione</h4>
                      <table>
                            <tbody>
                              <tr>
                                <th>POSTI PRENOTATI:</th>
                                <td><?php echo $booking->booking_spaces; ?></td>
                              </tr>
                            </tbody>
                        </table>
                      <hr />
                      <h4>Ecco i capi che si sono iscritti</h4>
                      <ul>
                        <?php foreach ($data[$em_person->user_login] as $scout_leader): ?>
                        <li><?php echo $scout_leader;?></li>
                        <?php endforeach; ?>

                      </ul>

                      <p>Qualcosa che non ti torna? Contattaci!</p>
                <?php
                  }
                ?>
            </div>
          </article>
        </section>
      </div><!-- .row -->
    </div><!-- .container -->
  </main>
  
  <?php get_footer(); ?>