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
    });

    $('button.em-tooltip-ddm.em-clickable.input.button-secondary').text('Azioni');

    $('input.em-form-submit.em-booking-submit').click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        $('#confirm-dialog .modal-title').text('Conferma prenotazione');
        $('#confirm-dialog .modal-body p').html('Procedere con la prenotazione di <b>' +  $('#em-ticket-spaces-2').val() + '</b> posti per la tua Comunità capi?');
        $('#confirm-dialog').on('shown.bs.modal', function () {
            $('#confirm-dialog .cancel').click(function() {
                $('#confirm-dialog').modal('hide');
            });
            $('#confirm-dialog .save').click(function() {
                $('#confirm-dialog').modal('hide');
                $('.em-booking-form').submit();
            });
        });
        $('#confirm-dialog').modal('toggle');
    });
});