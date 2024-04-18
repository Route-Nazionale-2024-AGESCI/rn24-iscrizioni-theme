<?php

require_once 'utils.php';
require_once 'exceptions.php';

use BookingSyncUtils as BSUtils;
use BookingSyncExceptions as BSExceptions;

/**
 * Complete booking
 */
function add_booking_sync_page() {
    add_menu_page(
        'Sincronizza iscrizioni', // Page title
        'Iscrizioni Sync', // Menu title
        'manage_options', // Capability
        'booking-sync-page', // Menu slug
        'booking_sync_page_content', // Callback function
        'dashicons-admin-generic', // Icon URL or Dashicons class
        99 // Position
    );
}
add_action('admin_menu', 'add_booking_sync_page');

// Callback function to display content on the custom admin page
function booking_sync_page_content() {
    global $wpdb;

    $completation_event_id = isset( $_POST['completation_event_id'] ) ? sanitize_text_field( $_POST['completation_event_id'] ) : get_option( 'completation_event_id' );


    $data = BSUtils\get_data();
    ksort($data);

    $usernames = array_keys($data);

    $usernames_placeholders = implode( ', ', array_fill( 0, count( $usernames ), '%s' ) );

    $sql = "
        SELECT bookings.booking_id, users.ID, users.display_name, users.user_email, users.user_login
        FROM {$wpdb->users} AS users
        LEFT JOIN {$wpdb->prefix}em_bookings AS bookings ON bookings.person_id = users.ID AND bookings.event_id = %d
        WHERE users.user_login IN ($usernames_placeholders)
        ORDER BY users.display_name
    ";

    $results = $wpdb->get_results(
        $wpdb->prepare($sql, array_merge([$completation_event_id], $usernames))
    );

    $results_by_user_login = [];
    foreach($results as $result) { 
        $results_by_user_login[$result->user_login] = $result;
    }


    $missing_users = array_diff($usernames, array_keys($results_by_user_login));
    ?>
    <div class="wrap">
        <h2>Pagina di sincronizzazione prenotazioni da BC</h2>
    <?php
        if($missing_users) {
            // Convert CSV data to Base64
            $csv_data = [
                ['ordinale'],
            ];

            foreach ($missing_users as $missing_user) {
                array_push($csv_data, [$missing_user]);
            }

            $base64_data = BSUtils\_get_base64_csv($csv_data);
            echo BSUtils\_error_message(
                sprintf(
                    'Ci sono %d non registrati al sito! <a href="data:application/octet-stream;base64,%s" download="fuggitivi.csv">Clicca qui</a> per scaricare la lista',
                    count($missing_users),
                    $base64_data,
                )
            );
        }

        if (isset($_POST['do_sync'])) {
        
            try {
                $to_import = [];
                
                foreach ($data as $user_login => $spaces) {
                    $db_data = $results_by_user_login[$user_login] ?? null;
                    
                    if(!is_null($db_data) && is_null($db_data->booking_id)) {
                        $to_import[] = [
                            'user_login' => $user_login,
                            'user_id' => $db_data->ID,
                            'spaces' => count($spaces),
                            'display_name' => $db_data->display_name,
                        ];
                    }
                }

                $result = do_sync(
                    $to_import,
                    $completation_event_id,
                );

                echo BSUtils\_success_message(
                    sprintf('Abbiamo inserito con sucesso %d prenotazioni', $result)
                );
                
                ?>
                <a href="">Clicca qui per ricaricare</a>
                <?php
                die();
            }
            catch(BSExceptions\Errors $errors) {
                echo BSUtils\_error_message('Oh no! Ci sono degli errori!');
                ?>
                <ul>
                <?php
                foreach ($errors->getErrors() as $error) {
                ?>
                    <li><?php echo $error->getMessage(); ?></li>
                <?php
                }
                ?>
                </ul>
                <?php
            }
        }
        elseif ( isset( $_POST['save_settings'] ) && wp_verify_nonce( $_POST['completation_event_id_nonce'], 'save_completation_event_id' ) ) {
            $completation_event_id = isset( $_POST['completation_event_id'] ) ? sanitize_text_field( $_POST['completation_event_id'] ) : '';
    
            update_option( 'completation_event_id', $completation_event_id );
    
            echo BSUtils\_success_message('Settings saved successfully!');
        }
    

    ?>
        <hr />
        <form action="" method="POST" onsubmit="return confirm('sicuro di voler sincronizzare? I dati già importati non saranno alterati')">
            <?php wp_nonce_field( 'do_sync', 'do_sync_nonce' ); ?>
            <input type="hidden" name="do_sync" value="bella" />
            <button type="submit">Sincronizza</button>
        </form>
        <hr />
        <form method="post" action="">
            <?php wp_nonce_field( 'save_completation_event_id', 'completation_event_id_nonce' ); ?>
            <label for="completation_event_id">Completion Event ID:</label><br />
            <select required name="completation_event_id" id="completation_event_id">
                <option value="">---- Seleziona una voce ---</option>
                <?php
                    foreach (EM_Events::get([]) as $event) {
                        echo sprintf(
                            '<option value="%d" %s>%s</option>',
                            $event->event_id,
                            $event->event_id == $completation_event_id ? 'selected' : '',
                            $event->event_name,
                        );
                    }
                ?>
            </select>
            <input type="submit" name="save_settings" value="Save Settings">
        </form>
        <hr />
        <table>
            <thead>
                <tr>
                    <th>
                        Ordinale
                    </th>
                    <th>
                        Gruppo
                    </th>
                    <th>
                        Email
                    </th>
                    <th>
                        Numero Iscritti
                    </th>
                    <th>
                        Importato
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach ($results as $result):
                        $users_code = $data[$result->user_login] ?? null;
                ?>
                    <tr>
                        <td><?php echo $result->user_login; ?></td>
                        <td><?php echo $result->display_name; ?></td>
                        <td><?php echo $result->user_email; ?></td>
                        <td><?php echo count($users_code); ?></td>
                        <td><?php echo $result->booking_id ? 'SI' : 'NO'; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
}


function _add( $EM_Bookings, $EM_Booking ){
    global $wpdb,$EM_Mailer;
    //Save the booking
    $email = false;
    //set status depending on approval settings
    if( empty($EM_Booking->booking_status) ){ //if status is not set, give 1 or 0 depending on approval settings
        $EM_Booking->booking_status = get_option('dbem_bookings_approval') ? 0:1;
    }
    $result = $EM_Booking->save(false);
    if($result){
        //Success
        do_action('em_bookings_added', $EM_Booking);
        if( $EM_Bookings->bookings === null ) $EM_Bookings->bookings = array();
        $EM_Bookings->bookings[] = $EM_Booking;
        //$email = $EM_Booking->email();
        if( get_option('dbem_bookings_approval') == 1 && $EM_Booking->booking_status == 0){
            $EM_Bookings->feedback_message = get_option('dbem_booking_feedback_pending');
        }else{
            $EM_Bookings->feedback_message = get_option('dbem_booking_feedback');
        }
        if(!$email){
            $EM_Booking->email_not_sent = true;
            $EM_Bookings->feedback_message .= ' '.get_option('dbem_booking_feedback_nomail');
            if( current_user_can('activate_plugins') ){
                if( count($EM_Booking->get_errors()) > 0 ){
                    $EM_Bookings->feedback_message .= '<br/><strong>Errors:</strong> (only admins see this message)<br/><ul><li>'. implode('</li><li>', $EM_Booking->get_errors()).'</li></ul>';
                }else{
                    $EM_Bookings->feedback_message .= '<br/><strong>No errors returned by mailer</strong> (only admins see this message)';
                }
            }
        }
        $filter = apply_filters('em_bookings_add', true, $EM_Booking);
        return $filter;
    }else{
        //Failure
        $this->errors[] = "<strong>".get_option('dbem_booking_feedback_error')."</strong><br />". implode('<br />', $EM_Booking->errors);
    }
    return apply_filters('em_bookings_add', false, $EM_Booking);
}

function do_sync(array $data, int $event_id) {
    global $EM_Event, $EM_Booking, $EM_Person;

    $errors = [];

    if ( ! wp_verify_nonce( $_POST['do_sync_nonce'], 'do_sync' ) ) {
        $errors[] = new BSExceptions\Error("Nonce non valido");
    }

    $_REQUEST['event_id'] = $event_id;
    $EM_Event = new EM_Event( absint($event_id) );
    $tickets = $EM_Event->get_tickets();
    $ticket = array_values($tickets->tickets)[0];
    $action = 'booking_add';
    
    $payload_template = [
        'action' => $action,
        'event_id' => $event_id,
        'em_tickets' => [$ticket->ticket_id => ['spaces' => null]],
        'person_id' => null,
        'user_name' => '', // to not set
        'user_email'=> '', // to not set
        'data_privacy_consent'=> 1,
        'gateway'=> 'offline',
        'manual_booking'=> wp_create_nonce('em_manual_booking_'.$EM_Event->event_id),
        'payment_amount'=> null, // to not set
    ];

    // TODO: torem
    // $data = array_filter($data, function($d) {
    //     return $d['user_login'] === 'H0470';
    // });

    $success = 0;

    foreach ($data as $user_data) {
        ob_start();
        $payload = $payload_template;

        $payload['em_tickets'][$ticket->ticket_id]['spaces'] = $user_data['spaces'];
        $payload['person_id'] = $user_data['user_id'];

        foreach ($payload as $key => $value) {
            $_REQUEST[$key] = $value;
        }
        do_action('em_before_booking_action_'.$action, $EM_Event, $EM_Booking);
        
        $EM_Booking = em_get_booking();
        $EM_Booking->person_id = $user_data['user_id'];
        $EM_Booking->person = new EM_Person($EM_Booking->person_id);
        $EM_Booking->get_post();
        
        $post_validation = $EM_Booking->validate();

        do_action('em_booking_add', $EM_Booking, $EM_Booking, $post_validation);
        
        if($post_validation) {
            $registration = em_booking_add_registration($EM_Booking);
            $EM_Bookings = $EM_Event->get_bookings();
            // if( $registration && $EM_Bookings->add($EM_Booking) ){
            // bypass filter
            $_REQUEST['manual_booking'] = '';
            if( $registration && _add($EM_Bookings, $EM_Booking) ){
                $_REQUEST['manual_booking'] = $payload_template['manual_booking'];
                if( is_user_logged_in() && is_multisite() && !is_user_member_of_blog(get_current_user_id(), get_current_blog_id()) ){
                    add_user_to_blog(get_current_blog_id(), get_current_user_id(), get_option('default_role'));
                }
            }else{
                foreach ($EM_Booking->get_errors() as $error) {
                    $errors[] = new BSExceptions\Error(
                        sprintf(
                            'ORDINALE: %s. ERRORE: %s',
                            $user_data['user_login'],
                            $error,
                        )
                    );
                }

                continue;
            }

            $success += 1;
        }
        else {
            foreach ($EM_Booking->get_errors() as $error) {
                $errors[] = new BSExceptions\Error(
                    sprintf(
                        'ORDINALE: %s. ERRORE: %s',
                        $user_data['user_login'],
                        $error,
                    )
                );
            }
            
        }
        ob_clean();
    }
    
    if(count($errors) > 0)
        throw new BSExceptions\Errors($errors);
    
    return $success;
}

add_filter(
    'em_bookings_build_sql_conditions',
    function ($conditions, ...$args) {
        global $wpdb;

        if(!empty($_REQUEST['em_search'])) {
            global $wpdb;

            if( !empty($conditions['search']) ){
                $conditions['search'] .= ' OR ';
            }
            else {
                $conditions['search'] = '';
            }

            $value = sanitize_text_field($_REQUEST['em_search']);
           
			$search = $wpdb->prepare(EM_BOOKINGS_TABLE.'.person_id IN (SELECT ID FROM '.$wpdb->users ." WHERE display_name LIKE %s)", $value.'%');
			$conditions['search'] .= '('.$search.')';
		}

        return $conditions;
    }
);
