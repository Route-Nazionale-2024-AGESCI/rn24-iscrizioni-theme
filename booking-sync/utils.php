<?php

namespace BookingSyncUtils;

/**
 * Return the data grouped by ordinale gruppo
 * @return array
 */
function get_data() {
    $csv_path = get_template_directory()."/booking-sync/iscrizioni_complete.csv";

    $data = [];
    
    if (($handle = fopen($csv_path, "r")) !== FALSE) {
        // Read the headers
        $headers = fgetcsv($handle, 1000, ",");
        
        $ordinale_gruppo_index = array_search("ordinale gruppo", $headers);
        
        // Read the file line by line
        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {

            $ordinale_gruppo = $row[$ordinale_gruppo_index];
            unset($row[$ordinale_gruppo_index]);
            $data[$ordinale_gruppo][] = $row;
        }
        
        fclose($handle);
    }
    
    return $data;

}


function _success_message(string $message) {
    return _message($message, 'updated');
}

function _error_message(string $message) {
    return _message($message, 'error');
}

function _message(string $message, string $type) {
    return sprintf(
        '<div class="%s"><p>%s</p></div>',
        $type,
        $message,
    );
}

function _get_base64_csv(array $data) {
    $temp_handle = fopen('php://temp', 'w+');

    // Write CSV data to the temporary file handle
    foreach ($data as $row) {
        fputcsv($temp_handle, $row);
    }

    // Move the pointer to the beginning of the temporary file handle
    rewind($temp_handle);

    // Read the contents of the temporary file handle
    $csv_data = stream_get_contents($temp_handle);

    // Close the temporary file handle
    fclose($temp_handle);

    // Convert CSV data to Base64
    return base64_encode($csv_data);
}
