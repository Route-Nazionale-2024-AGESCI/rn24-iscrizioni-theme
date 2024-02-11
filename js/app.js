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

    $('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
        if (!$(this).next().hasClass('show')) {
          $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
        }
        var $subMenu = $(this).next(".dropdown-menu");
        $subMenu.toggleClass('show');
      
      
        $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
          $('.dropdown-submenu .show').removeClass("show");
        });
      
      
        return false;
      });


    if ($('#map').is(':visible')) {
        // Creating map options
        var mapOptions = {
            center: [42.098, 12.634],
            zoom: 6
         };
         
         // Creating a map object
         var map = new L.map('map', mapOptions);
         
         // Creating a Layer object
         var layer = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
         
         // Adding layer to the map
         map.addLayer(layer);

         // a layer group, used here like a container for markers
        var markersGroup = L.layerGroup();
        map.addLayer(markersGroup);

        $.getJSON('https://rn24.agesci.it/wp-content/themes/rn24-iscrizioni-theme/data/groups.json', function(data) {
            var vita_giusta = L.icon({
                iconUrl: 'https://rn24.agesci.it/wp-content/uploads/2023/11/vita-giusta.png',        
                iconSize: [16],
                popupAnchor: [0, -45]
            });
            if (data) {

                for (var i = 0; i < data.length; i++) {
                    if (data[i]["Latitudine"] && data[i]["Longitudine"]) {
                        L.marker([
                            data[i]["Latitudine"],
                            data[i]["Longitudine"]
                        ], { icon: vita_giusta})
                        .bindPopup(L.popup().setContent(
                            data[i]["Denominazione Gruppo"] + '<br>'
                            + data[i]["zona"] + '<br>'
                            + data[i]["Regione"] 
                        ))
                        .addTo(markersGroup);
                    }
                }
            }
        });
    }

    $('.box-wrapper-container').click(function(e) {
        if ($(this).hasClass('selected')) {
            $('.box-wrapper-container').removeClass('selected');
            $('.box-wrapper-container').removeClass('unselected');
        } else {
            $('.box-wrapper-container').addClass('unselected');
            $(this).addClass('selected');
            $(this).removeClass('unselected');
        }
    });

    // Add the following code if you want the name of the file appear on select
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });

    $('.faq-item.row').click(function() {
        if ($(this).hasClass('opened')) {
            $(this).removeClass('opened');
            $('.faq-plus', $(this)).removeClass('fa-minus-circle');
            $('.faq-plus', $(this)).addClass('fa-plus-circle');
        } else {
            $('.faq-item.row').removeClass('opened');
            $('.faq-item.row .faq-plus').removeClass('fa-minus-circle');
            $('.faq-item.row .faq-plus').addClass('fa-plus-circle');
            $(this).addClass('opened');
            $('.faq-plus', $(this)).addClass('fa-minus-circle');
        }
    });


    $("#slideshow > div:gt(0)").hide();
    setInterval(function() { 
    $('#slideshow > div:first')
        .fadeOut(1000)
        .next()
        .fadeIn(1000)
        .end()
        .appendTo('#slideshow');
    },  5000);

    $('.box-map-italy .regione').on('click',function(){
        $('.box-map-italy .regione').removeClass('selected');
        $(this).addClass('selected'); 
        $('span.region-details-name').text($(this).data('nome-regione'));

        $('.region-details-title').removeClass('d-none');
        $('.region-details-title-empty').addClass('d-none');

        $.ajax({
            url: rn24_ajax_object.ajaxurl,
            type: "POST",
            dataType: "json",
            data: {
                region: $(this).data('nome-regione'),
                action: 'rn24_select_zones'
            },
            success: function(data){
                $('.region-details ul').empty();
                var tplDir = $('#template-directory-url').val();
                for (var i = 0; i < data.length; i++) {
                    var li = $('<li></li>');
                    li.append('<span class="region-zone">' + data[i] + '</span>');
                    var btn = $('<img src="' + tplDir + '/img/arrow-right.svg" class="region-zone-btn" alt="Dettaglio">');
                    li.append(btn);
                    $('.region-details ul').append(li);
                }
            },
            error: function(error){
                 console.log("Error:");
                 console.log(error);
            }
        });
      });

    
});