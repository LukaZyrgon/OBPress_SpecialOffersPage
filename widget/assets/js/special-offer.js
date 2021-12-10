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

      $(".ob-searchbar-submit").click(function() {
        // var data = {};
        // var action = "get_data_for_rooms";

        // data.action = action;

        var package_id = $(".single-package").data("package-id");
        var CheckIn = $("#date_from").val();
        var CheckOut = $("#date_to").val(); 
        var ad = $("#ad").val(); 
        var ch = $("#ch").val();
        var ag = $("#ag").val();

        $.get(specialOfferAjax.ajaxurl+"?action=get_data_for_rooms&package_id=" + package_id + "&CheckIn=" +  CheckIn + "&CheckOut=" + 
          CheckOut + "&ad=" + ad + "&ch=" + ch + "&ag=" + ag , function( res ) {
          $("#package-results").empty();
          $("#package-results").html(res);

          console.log("stigo");

          //change url in browser
          // window.history.pushState(  "", "Title", url_no_parametres + "?" + $( $("#rate_plan_form-lp")[0].elements ).not(".chain, #hotel_code").serialize()   );
        })
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
