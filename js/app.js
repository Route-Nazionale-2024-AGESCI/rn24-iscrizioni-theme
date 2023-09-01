$(document).ready(function() {

    $('#em-ticket-spaces-2').change(function($event) {
        var price = $('#em-booking-intent-1').data('amount_base');
        var places = parseInt(this.value);
        $('.em-bs-cell-qty').text(places);
        $('.em-bs-cell-price').text('€' + (places * price));
    });
});