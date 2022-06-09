jQuery(window).on("elementor/frontend/init", function () {
  //hook name is 'frontend/element_ready/{widget-name}.{skin} - i dont know how skins work yet, so for now presume it will
  //always be 'default', so for example 'frontend/element_ready/slick-slider.default'
  //$scope is a jquery wrapped parent element
  elementorFrontend.hooks.addAction(
    "frontend/element_ready/SpecialOfferPage.default",
    function ($scope, $) {



      $('.single-package-info-categories-bar').click(function() {
        $('.single-package-info-categories-bar').removeClass("active-bar");
        $(this).addClass("active-bar");

        $('.single-package-info-category-section').removeClass("active-section");
        $(".single-package-info-category-section[data-category='"+$(this).attr('data-category')+"']").addClass("active-section");
      });

      $('.package-more-description').click(function() {
        $(".package-description-long").show();
        $(".package-less-description").show();
        $(".package-description-short").hide();
        $(".package-more-description").hide();
      });

      $('.package-less-description').click(function() {
        $(".package-description-long").hide();
        $(".package-less-description").hide();
        $(".package-description-short").show();
        $(".package-more-description").show();
      });

      var url_no_parametres = location.protocol + '//' + location.host + location.pathname;

      $(".ob-searchbar-submit-so").click(function() {

        $("#package-results").empty();

        $(".obpress-hotel-results-item-top").empty();

        $(".obpress-hotel-total-price-value").html("0,00");

        $(".next-step-loader").show();
       
        // update info in basket

        $(".obpress-hotel-basket-stay-checkin-date").html(  moment( $("#date_from-so").val(), "DDMMYYYY").format("DD MMM") );

        $(".obpress-hotel-basket-stay-checkout-date").html( moment( $("#date_to-so").val(), "DDMMYYYY").format("DD MMM") );

        var occAdultsRooms = $("#ad-so").val().split(",");

        $(".obpress-hotel-basket-stay-rooms-num").html( occAdultsRooms.length );

        var occAdults = 0;

        for (i = 0 ; i < occAdultsRooms.length ; i++) {
            occAdults += Number(occAdultsRooms[i]);
        }

        $(".obpress-hotel-basket-stay-guests-num").html( occAdults );

        var startDay =  moment( $("#date_from-so").val(), "DDMMYYYY");
        var endDay = moment( $("#date_to-so").val(), "DDMMYYYY");

        $(".obpress-hotel-basket-stay-nights-num").html( endDay.diff(startDay, 'days') );

        var package_id = $(".single-package").data("package-id");
        var CheckIn = $("#date_from-so").val();
        var CheckOut = $("#date_to-so").val(); 
        var ad = $("#ad-so").val(); 
        var ch = $("#ch-so").val();
        var ag = $("#ag-so").val();

        $.get(specialOfferAjax.ajaxurl+"?action=get_data_for_rooms&package_id=" + package_id + "&CheckIn=" +  CheckIn + "&CheckOut=" + 
          CheckOut + "&ad=" + ad + "&ch=" + ch + "&ag=" + ag , function( res ) {
            
            $(".next-step-loader").hide();
          
            $("#package-results").html(res);

            //change url in browser 
             window.history.pushState(  "", "Title", url_no_parametres + "?package_id="+ package_id + "&" + $( $(".package-form")[0].elements ).not("#chain_code-so, #hotel_code-so").serialize()  );
        });

      });

      $('.single-package-info-category-title').on('click', function() {
        if($(this).closest('.single-package-info-category-holder').find('.single-package-info-description-holder').css('display') == 'none'){
          $(this).closest('.single-package-info-category-holder').find('.single-package-info-description-holder').slideDown(200);
          $(this).closest('.single-package-info-category-holder').find('.single-package-info-description-arrow').css('transform', 'rotate(180deg)')
        }
        else {
          $(this).closest('.single-package-info-category-holder').find('.single-package-info-description-holder').slideUp(200);
          $(this).closest('.single-package-info-category-holder').find('.single-package-info-description-arrow').css('transform', 'rotate(0deg)')
        }
      });


      /* add or update parameters in url */
      function updateUrlParam(key, value, url) {
          if (!url) url = window.location.href;
          var re = new RegExp("([?&])" + key + "=.*?(&|#|$)(.*)", "gi"),
              hash;

          if (re.test(url)) {
              if (typeof value !== 'undefined' && value !== null) {
                  return url.replace(re, '$1' + key + "=" + value + '$2$3');
              } 
              else {
                  hash = url.split('#');
                  url = hash[0].replace(re, '$1$3').replace(/(&|\?)$/, '');
                  if (typeof hash[1] !== 'undefined' && hash[1] !== null) {
                      url += '#' + hash[1];
                  }
                  return url;
              }
          }
          else {
              if (typeof value !== 'undefined' && value !== null) {
                  var separator = url.indexOf('?') !== -1 ? '&' : '?';
                  hash = url.split('#');
                  url = hash[0] + separator + key + '=' + value;
                  if (typeof hash[1] !== 'undefined' && hash[1] !== null) {
                      url += '#' + hash[1];
                  }
                  return url;
              }
              else {
                  return url;
              }
          }
      }


      /// main


      var width = window.innerWidth;
      var height = window.innerHeight;
      var resolutionMobile = false;
      var resolutionTablet = false;
      var resolution = 1; //1 desktop, 2 tablet, 3 mobile;

      if ( width < 1279 ) { 
        resolution = 3;
      } else{
        resolution = 1;
      }


    }

  );
  
});

jQuery(document).ready(function($){

  $(document).on("click", ".error_message_btn_calendar", function() {
    $("#calendar_dates-so").click();
  });

  $(document).on("click", ".error_message_btn_occupancy", function() {
    $("#guests-so").click();
  });


  // open calendar when click on Change Search
  $(document).on("click", ".restricted_modify_search", function() {

    $([document.documentElement, document.body]).animate({
        scrollTop: $("#calendar_dates-so").offset().top - 200
    }, 500);

    $("#calendar_dates-so").click();

  });


  
});