$(document).ready(function() {

    $('#em-ticket-spaces-2').change(function($event) {
        var price = $('#em-booking-intent-1').data('amount_base');
        var places = parseInt(this.value);
        $('.em-bs-cell-qty').text(places);
        $('.em-bs-cell-price').text('€' + (places * price));
    });


    $('form#form-reset-pwd').submit(function(e) {
        $('form#form-reset-pwd .invalid-feedback').hide();
        var pwd = $('#password').val();
        var pwdRepeat = $('#repeat-password').val();
        if (pwd !== pwdRepeat) {
            $('form#form-reset-pwd #repeat-password .invalid-feedback').show();
            return false;
        } else {
            return
        }
    })
});