jQuery(document).ready(function($){


    function update_cart(){

        var basket = $("#basket");
        var basket_room_name = "";
        var total_quantity = 0;
        var total_price = 0;
        var total_room_price_after_tax = 0;
        var different_room_types = 0;
        var total_adults = 0;
        var total_children = 0;
        var showParcels = false;
        var can_submit = false;

        $(".obpress-hotel-results-item-top").empty();

        $.each($(".roomrateinfo"), function() {

            var quantity = Number($(this).attr("data-quantity"));

            if ( quantity > 0 ) { 

                var nights = Number($(this).attr("data-nights"));

                var price = Number($(this).attr("data-price"));

                var price_before_discount = Number($(this).attr("data-price-before-discount"));

                var total_discount = Number($(this).attr("data-discount")) * quantity;

                var total_price_for_room_without_discount = quantity * price_before_discount * nights;

                var total_price_for_room =  quantity * price * nights;

                total_room_price_after_tax = Number($(this).attr("data-total-price-after-tax")) * quantity;

                var room_tax_price = total_room_price_after_tax - total_price_for_room;

                total_price = total_price + room_tax_price + quantity * price * nights;

                basket_room_name = $(this).find(".single-package-room-name").text(); 

                var adults = Number($(this).attr("data-adults"));

                total_adults = total_adults + adults * quantity;

                var children = Number($(this).attr("data-children"));

                total_children = total_children + children * quantity;

                policy = $(this).attr("data-policy");

                currency = $(this).attr("data-currency-symbol") ;

                var clone = $(".basket-room-div-clone .basket-room-div").clone();

                clone.find(".obpress-hotel-results-item-title").text( basket_room_name );

                clone.find(".obpress-hotel-results-item-curr").text(  currency );

                if(total_price_for_room_without_discount > 0) {
                    clone.find(".obpress-hotel-results-item-value").text( total_price_for_room_without_discount.toFixed(2) );
                } else {
                    clone.find(".obpress-hotel-results-item-value").text( total_price_for_room.toFixed(2) );
                }

                clone.find(".obpress-hotel-results-total-room-counter").text(quantity);

                clone.find(".obpress-hotel-results-item-promo").text( policy );

                clone.find(".obpress-hotel-results-discount-price").text(total_discount.toFixed(2));

                clone.find(".obpress-hotel-results-tax-message").text($(this).attr("data-tax-policy-name"));

                clone.find(".obpress-hotel-results-tax-price").text(room_tax_price.toFixed(2));

                if ( total_discount == "") {
                    clone.find(".obpress-hotel-results-discount-holder").css("display", "none");
                }

                if ( room_tax_price.toFixed(2) == 0 ) {
                    clone.find(".obpress-hotel-results-tax-holder").css("display", "none");
                }
        
                clone.appendTo(".obpress-hotel-results-item-top");

                clone.attr( "rate-id" , $(this).attr("data-rate-id") );

                clone.attr( "room-id" , $(this).attr("data-room-id") );

                can_submit = true;

            } else {

                $(this).find(".room-btn-add").prop("disabled", false);
                
            }

            total_quantity = total_quantity + quantity; 
            
        });


        if ( resolution == 3 && total_quantity > 0 ) {
            $(".obpress-hotel-results-basket-holder").show();
        } else if ( resolution == 3 && total_quantity == 0 ) {
            $(".obpress-hotel-results-basket-holder").hide();
        }


        if ( can_submit == false ) {
            $("#basket-send").attr("disabled", true);
        } else {
            $("#basket-send").removeAttr("disabled");
        }

        $(".obpress-hotel-total-price-value").text( total_price.toFixed(2) );


        return false;

    };


    /* function */

    var currency = null;

    function basket_add_to() {


        /* button clicks */
        /* get parent div of a click (the one that holds all the data) */
        var info = $(this).closest(".roomrateinfo");
        var room = $(this).closest(".roomrate");


        var on_request = $(info).hasClass("on-request");

        var add, remove, minus, plus = false;

        if ($(this).hasClass("room-btn-add")){ add = true; }
        if ($(this).hasClass("room-btn-minus")){ minus = true; }
        if ($(this).hasClass("room-btn-plus")){ plus = true; } 

        var max_total = 20; //maximum quantity total of rooms for hotel

        if ( Number($(this).closest("#hotels_grid").attr("data-max-rooms")) > 0 ) {
            max_total = Number($(this).closest("#hotels_grid").attr("data-max-rooms"));
        }

        var max = 10; //maximum quantity for room

        if ( Number(info.attr("data-max-quantity")) > 0 ){
            max = Number(info.attr("data-max-quantity"));    
        }

        //if the maximum room allow is bigger than maximum room allow for that hotel
        //make max rooms for that room = max available for that hotel

        
        if ( max_total < max ){        
            var limitRooms = max_total;
        } else if ( max_total > max ){
            var limitRooms = max;
        }


        //check quantity
        if ( add ) {
            info.attr("data-quantity", 1); /* first quantity set to 1 */
            info.find(".room-btn-add").hide();
            info.find(".room-btn-minus").css('display', 'flex');
            info.find(".room-btn-value").css('display', 'flex');
            info.find(".room-btn-plus").css('display', 'flex');     
            info.find(".text-number-of-rooms").show();  
        } else if( plus ) {
            info.attr("data-quantity", Number(info.attr("data-quantity"))+1);
        } else if ( minus ) {
            info.attr("data-quantity", Number(info.attr("data-quantity"))-1);
        }     


    /* reset others to quantity 0 if single is true */

    $.each($(".roomrateinfo"), function() {      

        if ($(this).attr("data-single")=="true" && $(this).attr("data-room-id")!=info.attr("data-room-id") && $(this).attr("data-rate-id")!=info.attr("data-rate-id")){
            $(this).attr("data-quantity",0);                
        }

        $(this).find(".room-btn-value").text($(this).attr("data-quantity")); 

        if($(this).attr("data-quantity")==0){
            $(this).find(".room-btn-add").css('display', 'inline-block');
            $(this).find(".room-btn-minus").hide();
            $(this).find(".room-btn-value").hide();
            $(this).find(".room-btn-plus").hide();
            $(this).find(".text-number-of-rooms").hide();
        }            
    }); 


    // if on request room maximus is 1 room
    if (on_request == true)  {

        var limitRooms = 1;
    }
    
    //enable all popups
    $(".room-btn-plus").prop("disable",false);

    var total_quantity = 0;
    var total_req_quantity = 0;
    var room_quantity = 0;

    //total_quantity is sum of all choosen for hotel
    $.each($(".roomrateinfo"), function() {
        var quantity = Number($(this).attr("data-quantity"));
        total_quantity = total_quantity + quantity;        
    });


    //room_quantity is sum of all choosen for room
    $.each($(room).find(".roomrateinfo"), function() {
        var quantity = Number($(this).attr("data-quantity"));
        room_quantity = room_quantity + quantity;        
    });


    //  Block if its above the total number of rooms for hotel
    if ( total_quantity >= max_total ) {

            $(".room-btn-plus").prop("disabled", "disabled");
            $(".room-btn-add").prop("disabled", "disabled");

             if ( room_quantity >= max )  { 
                  room.addClass("maximum");
               }

               
    } else {  // if not, enable pluses


             // enable all pluses , except the one that went to maximum
              $.each($(".roomrate"), function() { 

                    if ( $(this).hasClass("maximum")  == false ) {

                        $(this).find(".room-btn-plus").prop("disabled", false);
                        $(this).find(".room-btn-add").prop("disabled", false);
        
                    }  

              });

             //if it reached maximum give it class and disable it
             if ( room_quantity >= max )  {

                    room.find(".room-btn-plus").prop("disabled", "disabled");
                    room.find(".room-btn-add").prop("disabled", "disabled");

                    room.addClass("maximum");

             }  else { // take class off and enables it

                   room.removeClass("maximum");
                   
                   room.find(".room-btn-plus").prop("disabled", false);
                   room.find(".room-btn-add").prop("disabled", false);
             }


    }



    // if on request room
    if (on_request == true)  {

        $(".basket-send-book-now").hide();
        $(".basket-send-request-now").show();

        var clicked_index = $(info).index();
        var i = 3;

        $.each($(room).find(".rate_plan"), function() {

            if (clicked_index != i)  {  // if not the clicked roomrate dont disable
                if ( $(this).hasClass("on-request") == true ) {
                     $(this).find(".room-btn-plus").prop("disabled", "disabled");
                     $(this).find(".room-btn-add").prop("disabled", "disabled");
                     $(this).find(".room-btn-add").css('display', 'inline-block');
                     $(this).find(".room-btn-minus").hide();
                     $(this).find(".room-btn-value").hide();
                     $(this).attr("data-quantity","0");
                     $(this).find(".room-btn-plus").hide();
                     $(this).find(".text-number-of-rooms").hide();
               };
            }

            i++;

        });

      

        $.each($(".rate_plan"), function() {

             if ( $(this).hasClass("on-request") == false ) {
                     $(this).find(".room-btn-plus").prop("disabled", "disabled");
                     $(this).find(".room-btn-add").prop("disabled", "disabled");
                     $(this).find(".room-btn-add").css('display', 'inline-block');
                     $(this).find(".room-btn-minus").hide();
                     $(this).find(".room-btn-value").hide();
                     $(this).attr("data-quantity","0");
                     $(this).find(".room-btn-plus").hide();
                     $(this).find(".text-number-of-rooms").hide();
             };

             if (total_quantity == 0)  {
                 $(this).find(".room-btn-add").prop("disabled", false);

             }

        });

        //  if sum of all requests are 0 then enable all requests
         $.each($(room).find(".rate_plan"), function() {

            var req_quantity = Number($(this).attr("data-quantity"));
            total_req_quantity = total_req_quantity + req_quantity;  
               
        });


         // if it return on total 0 ,enable rate
        if (total_req_quantity == 0) {

           $(".request-popup").hide(); 

           $.each($(room).find(".rate_plan"), function() {

                if ( $(this).hasClass("on-request") == true ) {
                 $(this).find(".room-btn-plus").prop("disabled", false);
                 $(this).find(".room-btn-add").prop("disabled", false);
                 
               };
            
            });

        }  else {
             $(".request-popup").show();
        };

        }

        // if not request room
        if (on_request == false)  {


            $(".basket-send-request-now").hide();
            $(".basket-send-book-now").show();

            $.each($(".rate_plan"), function() {
                 if ( $(this).hasClass("on-request") == true ) {
                     //$(this).find(".room-btn-plus").prop("disabled", "disabled");
                     $(this).find(".room-btn-add").prop("disabled", "disabled");
                     $(this).find(".room-btn-add").css('display', 'inline-block');
                     $(this).find(".room-btn-minus").hide();
                     $(this).find(".room-btn-value").hide();
                     $(this).attr("data-quantity","0");
                     $(this).find(".room-btn-plus").hide();
                     $(this).find(".text-number-of-rooms").hide();
                 };

                 if (total_quantity == 0)  {
                     $(this).find(".room-btn-add").prop("disabled", false);
                 }

            });
        }
        


        //if total quantity = 1, check for currency and disable other currencies
        if(total_quantity>=1){

            currency = info.attr("data-currency");
            
            //find all info where currency is not this and disable it
            //$(".roomrateinfo[data-currency!=\""+currency+"\"]").find(".room-btn-plus").prop("disabled", "disabled");
            //$(".roomrateinfo[data-currency!=\""+currency+"\"]").find(".room-btn-add").prop("disabled", "disabled");
            $(".roomrateinfo[data-currency!=\""+currency+"\"]").find(".diff_currency").css('display', 'flex');
        }

        //if there is no quantity remove currency
        if(currency!=null && total_quantity==0){

            currency = null;
            $(".room-btn-plus").prop("disabled", false);
            $(".room-btn-add").prop("disabled", false);
            $(".roomrateinfo").find(".diff_currency").hide();
            //enable all again
        }

        $("[data-single=true]").find(".room-btn-add").prop("disabled",false);

        update_cart();
        return false;

    }



    function basket_send(e){

        e.preventDefault();


        // show loader
        $("body > .container").hide();
        $(".next-step-loader").css("display", "flex");
        $(".obpress-footer").hide();


        var chain = $("input[name='c']").val();
        var data = {};
        //data._token = $("#token").val(); // TODO
        data.sid = ( Math.random() + 1 ).toString(36).substring( 2,8 );
        var reservation = {};


        date_from = moment($("#date_from").val(), 'DDMMYYYY').format("YYYY-MM-DD");
        date_to = moment($("#date_to").val(), 'DDMMYYYY').format("YYYY-MM-DD");
        hotel_id = Number($("#hotel_code").val());
        nights = Number($("#NRooms").val());

        group_code = $("#group_code").val();
        promo_code = $("#Code").val();
        loyalty_code = $("#loyalty_code").val(); 
        
        reservation.start = date_from;    
        reservation.end = date_to;
        reservation.nights = nights;


        reservation.chain = chain;
        reservation.hotel_id = hotel_id;

        reservation.group_code = group_code; 
        reservation.promo_code = promo_code;
        reservation.loyalty_code = loyalty_code;    

        var hotel_code = hotel_id;        

        var rooms = [];
        var occupancies = [];    

        var occupancy_rph = 0; //occupancy

        var newCheckIn = [];
        var newCheckOut = [];
        var newAd = [];
        var newCh = [];
        var newAg = [];

        var room_id_single;
        var rateplan_id_single;


        $.each($(".roomrateinfo"), function() { 

            quantity = Number($(this).attr("data-quantity"));

            for ( i = 0; i < quantity; i++ ) { 

                if ( $(this).attr("data-single")=="true") {      
                    reservation.hotel_id = $(this).attr("data-hotel-id");
                    hotel_code = $(this).attr("data-hotel-id");
                }

                var room = {};
                var occupancie = {};

                room.room_id = Number($(this).attr("data-room-id"));
                room.room_name = $(this).attr("data-name");
                room.selected_rate_plan = Number($(this).attr("data-rate-id"));
                room.rate_name = $(this).attr("data-rate-name");
                room.adults = Number($(this).attr("data-adults"));
                room.children = Number($(this).attr("data-children"));
                room.nights = Number($(this).attr("data-nights"));
                room.rph = Number($(this).attr("data-rph")); 
                room.selected_extras = [];
                room.start = $(this).attr("data-start");
                room.end = $(this).attr("data-end");

                room_id_single = Number($(this).attr("data-room-id"));
                rateplan_id_single = Number($(this).attr("data-rate-id"));

                newCheckIn.push(moment(room.start).utc().format("DDMMYYYY"));
         
                newCheckOut.push(moment(room.end).utc().format("DDMMYYYY"));

                newAd.push(room.adults);
                newCh.push(room.children);

                children_age = $(this).attr("data-children-ages");
                newAg.push(children_age);
                ages = children_age.split(";");            
                ages = ages.filter(function(e){return e;});

                if ( ages.length==0 ){ ages = null; }

                room.children_age = ages;             

                occupancie.adults = Number($(this).attr("data-adults")); 
                occupancie.children = Number($(this).attr("data-children"));
                
                occupancie.rph = occupancy_rph++;
                occupancie.ages = ages;

                rooms.push(room);            
                occupancies.push(occupancie);   
            
            }
        });

        reservation.rooms = rooms;
        reservation.occupancies = occupancies;

        reservation.old_occupancies = occupancies;
     
        var ad = getUrlParam("ad");
        var ch = getUrlParam("ch");
        var ag = getUrlParam("ag");

        if (ad==null) ad = "";
        if (ch==null) ch = "";
        if (ag==null) ag = "";
        adArr = ad.split(",");
        chArr = ch.split(",");
        agArr = ag.split(",");
        var old_occupancies = [];

        for ( var i=0 ; i<rooms.length ; i++) {

            old_occupancy = {};
            
            old_occupancy.adults = (adArr[i]!=null && !isNaN(adArr[i])) ? adArr[i] : 1 ;

            if (chArr[i]!=null && !isNaN(chArr[i])) {
                old_occupancy.children = chArr[i];
                old_occupancy.ages = [];
                for(var j=0; j<old_occupancy.children; j++){
                    if(agArr[j]!=null && !isNaN(agArr[j])){
                        old_occupancy.ages.push(agArr[j]);
                    }
                }

            } else {
                old_occupancy.children = 0;
                old_occupancy.ages = [];
            }     
            
            old_occupancy.rph = i;

            old_occupancies.push(old_occupancy);

        }

        data.reservation = JSON.stringify(reservation);

        // send ajax request step 2 save

        $.ajax({

            type:"POST",
            url: ajaxurl,
            data: {
                action: "step2save_ajax_request",
                data: data

            },

            success:function(response){

                //redirect on success
                var url = window.location.hostname + "/extras"; // read the step3 url
                
                //url = url.replace("hotel-results","extras"); // replace step2 from step3
                url = updateUrlParam('c',null,url); //remove c param
                url = updateUrlParam('q',hotel_code,url);
                url = updateUrlParam('NRooms',rooms.length,url);                        
                url = updateUrlParam('sid',data.sid,url);
                url = updateUrlParam('CheckIn',newCheckIn.join(','),url);
                url = updateUrlParam('CheckOut',newCheckOut.join(','),url);
                url = updateUrlParam('ad',newAd.join(','),url);
                url = updateUrlParam('ch',newCh.join(','),url);
                url = updateUrlParam('ag',newAg.join(','),url);

                if (rooms.length == 1) {
                    url = updateUrlParam('roomuids', room_id_single, url);
                    url = updateUrlParam('rateuids', rateplan_id_single, url);
                }
                
                window.location.href = url; // redirect  

            },

            error: function(errorThrown) {
                alert(errorThrown);
            }

        });


    }



    // Listeners
    
    $(document).on('click',".room-btn-add,.room-btn-minus,.room-btn-plus",basket_add_to);

    $(document).on('click',"#basket-send",basket_send);


    $(document).on("click", ".select-btn", function() {
        
        defaultButtons();
        setQuantitiesTo(1);
        populateOcupation();

        $(this).hide();
        // $(this).next(".quantity-input").show();
        $(this).siblings(".add-room, .remove-room, .quantity-input").show();
        var room_id = $(this).parent().parent().parent().find('.room_name').data('roomid');
        var rateplan_id = $(this).parent().parent().parent().find('.room_name').data('rateplanid');
        var hotel_id = $(this).parent().parent().parent().find('.room_name').data('hotelid');

        var room_name = $(this).parent().parent().parent().find('.room_name').html();
        var room_price = $(this).parent().parent().find('.price-total').html();

        showBasket();
        $("#basket .room_name").html("1 Room - " + room_name);
        $("#basket .room_price").html(room_price);

        $('#basket #roomid_field').val(room_id);
        $('#basket #rateplanid_field').val(rateplan_id);
        $('#basket #hotelid_field').val(hotel_id);
        $('#basket #quantity_field').val('1');

    });


    $(document).on("change", ".quantity-input", function() {

        populateOcupation();

        var room_name = $(this).parent().parent().parent().find('.room_name').html();
        var room_price = $(this).parent().parent().find('.price-total').html();

        var quantity = $(this).val();

        $('#basket #quantity_field').val(quantity);
        $("#basket .room_name").html(quantity + " Rooms - " + room_name);


        if (quantity==0) {
            closeBasket();
        }
        else {
            showBasket();
        }

        var price = (room_price*quantity).toFixed(2);

        $("#basket .room_price").html(price);
    });


    $(document).on("click", "#basket-close", function() {
        closeBasket();
    });



    $(document).on("click", ".add-room", function() {
        var max = $(this).prev(".quantity-input").attr("max");
        // var max = $(".quantity-input").attr("max");
        if (parseInt($(".quantity-input").val()) < max) {
            $(".quantity-input").val(parseInt($(".quantity-input").val()) + 1);
            $(this).prev(".quantity-input").trigger("change");
        }
    });


    $(document).on("click", ".remove-room",function() {
        if (parseInt($(".quantity-input").val()) > 1) {
            $(".quantity-input").val(parseInt($(".quantity-input").val()) - 1);
            $(this).next(".quantity-input").trigger("change");  
        }
        else {
            closeBasket();
        }

    });

    function closeBasket() {
        setQuantitiesTo(1);
        defaultButtons();
        $('#basket').slideUp();
    }
    function showBasket() {
        $('#basket').slideDown();
    }
    function defaultButtons() {
        //shows all buttons for select and hide quantity input field
        $('.select-btn').show();
        $('.quantity-input, .add-room, .remove-room').hide();
    }
    function setQuantitiesTo(quantity) {
        $('.quantity-input').val(quantity);
    }
    function populateOcupation() {
        /* ie10 not working, find a fix */
        var searchParams = new URLSearchParams(window.location.search);
        $('#basket-adults').html(searchParams.get('ad'));
        $('#basket-children').html(searchParams.get('ch'));
    }


    $(document).on("click", ".request-popup-close", function() {
       $(".request-popup").hide();
    });


    $(document).on("click", ".obpress-hotel-results-item-edit", function() {

       var rate_id = $(this).closest(".basket-room-div").attr("rate-id") ;

       var room_id = $(this).closest(".basket-room-div").attr("room-id") ;

       var room_to_remove = $(".roomrateinfo[data-room-id='" + room_id +"']") ;

       $(room_to_remove).each(function() {

            if ( $(this).data("rate-id") == rate_id ) {

                var rate_to_remove = $(this);

                rate_to_remove.find(".room-btn-minus , .room-btn-value , .room-btn-plus").hide();

                rate_to_remove.find(".room-btn-add").show();

                rate_to_remove.attr("data-quantity","0");

            }

       });

       
       update_cart();


    });
    




    // show basket on click
  $(".obpress-hotel-results-basket-price").on("click", function() {
    $(this).closest("#basket").find(".obpress-hotel-results-basket-info-holder").toggleClass("open");
    $(this).toggleClass("open");
    $(this).closest("#basket").toggleClass("open");
  });


    
});