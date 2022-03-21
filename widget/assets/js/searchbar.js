jQuery(document).ready(function($){



  jQuery(".obpress-mobile-close-hotels-dropdown-holder-so img").click(function () {
    $(this).closest(".hotels_dropdown-so").hide();
    $(".ob-searchbar-so-hotel").removeClass("opened");
  });

  jQuery(document).mouseup(function (e) {
    var box = jQuery(".hotels_dropdown-so");
    if (!box.is(e.target) && box.has(e.target).length === 0) {
      box.slideUp(200);
      jQuery(".ob-searchbar-so-hotel").removeClass("opened");
    }
  });

  jQuery("#hotels-so").keyup(function () {
    
    jQuery(this).parent().find(".hotels_dropdown-so").slideDown(200);
    var folder_id = 0;
    var query = jQuery(this).val();
    var divs = jQuery(this).parent().find(".hotels_dropdown-so").children();

    if ( resolution == 1) {
        jQuery(".zcalendar-so").slideUp(200);
        jQuery(".ob-searchbar-calendar-so").removeClass("opened");
    }

    for (var i = 0; i < divs.length; i++) {
      var text = divs.eq(i).text();
      if (
        text.toLowerCase().indexOf(query.toLowerCase()) >= 0 ||
        query == ""
      ) {
        divs.eq(i).removeClass("d-none");
        //if its a folder all children should be left also
        if (divs.eq(i).attr("data-folder-id") != null) {
          folder_id = divs.eq(i).attr("data-folder-id");
        }
        //if it has a folder show the folder of it
        if (divs.eq(i).attr("data-parent-id") != null) {
          jQuery(
            "[data-folder-id='" + divs.eq(i).attr("data-parent-id") + "']"
          ).removeClass("d-none");
        }
      } else {
        divs.eq(i).addClass("d-none");
        if (divs.eq(i).attr("data-parent-id") != null) {
          //make children of a parent visible
          var parent_id = divs.eq(i).attr("data-parent-id");
          if (parent_id == folder_id) {
            divs.eq(i).removeClass("d-none");
          }
        }
      }
    }
  });

  //Promo Code Js

  jQuery("#promo_code-so").click(function () {

    if ( resolution == 1) {
        jQuery(".zcalendar-so").slideUp(200);
        jQuery(".ob-searchbar-calendar-so").removeClass("opened");
    }

    if (jQuery("#promo_code_dropdown-so").css("display") == "none") {
      jQuery("#promo_code_dropdown-so").slideDown(200);
      promoCodeDisabler();
      jQuery(".ob-searchbar-promo-so").addClass("opened");
    }

  });

  jQuery("#promo_code_apply-so").click(function () {
    jQuery("#promo_code_dropdown-so").slideUp(200);
    jQuery(".ob-searchbar-promo-so").removeClass("opened");
  });

  jQuery(document).mousedown(function (e) {
    var promo_code_dropdown = jQuery("#promo_code_dropdown-so");

    // if the target of the click isn't the container nor a descendant of the container
    if(resolution == 1) {
      if (
        !promo_code_dropdown.is(e.target) &&
        promo_code_dropdown.has(e.target).length === 0
      ) {
        promo_code_dropdown.slideUp(200);
        jQuery(".ob-searchbar-promo-so").removeClass("opened");
      }
    }
    
  });

  jQuery("#promo_code_apply-so").click(function (e) {
    e.preventDefault();

    if (
      jQuery("#group_code-so").val() != null &&
      jQuery("#group_code-so").val() != ""
    ) {
      jQuery("#promo_code-so").val(jQuery("#group_code-so").val());
    } else if (
      jQuery("#Code-so").val() != null &&
      jQuery("#Code-so").val() != ""
    ) {
      jQuery("#promo_code-so").val(jQuery("#Code-so").val());
    } else if (
      jQuery("#loyalty_code-so").val() != null &&
      jQuery("#loyalty_code-so").val() != ""
    ) {
      jQuery("#promo_code-so").val(jQuery("#loyalty_code-so").val());
    } else {
      jQuery("#promo_code-so").val("");
    }

    jQuery("#promo_code_dropdown-so").slideUp(200);
    jQuery(".ob-searchbar-promo-so").removeClass("opened");
    //togglePromoCodeDropdown();
    promoCodeDisabler();
  });

  jQuery("#group_code-so,#Code-so,#loyalty_code-so").keyup(promoCodeDisabler);

  function promoCodeDisabler() {
    //enable all
    jQuery("#group_code-so").prop("disabled", false);
    jQuery("#Code-so").prop("disabled", false);
    jQuery("#loyalty_code-so").prop("disabled", false);

    //disable empty
    if (jQuery("#group_code-so").val().length > 0) {
      jQuery("#Code-so").prop("disabled", true);
      jQuery("#loyalty_code-so").prop("disabled", true);
    } else if (jQuery("#Code-so").val().length > 0) {
      jQuery("#group_code-so").prop("disabled", true);
      jQuery("#loyalty_code-so").prop("disabled", true);
    } else if (jQuery("#loyalty_code-so").val().length > 0) {
      jQuery("#group_code-so").prop("disabled", true);
      jQuery("#Code-so").prop("disabled", true);
    }
  }

  //Occupancy Javascript
  var adultsInput = jQuery("#ad-so");
  var childrenInput = jQuery("#ch-so");

  //Default Number of Rooms
  var maxRooms = 10;

  // Array of Objects that holds information for every room
  var guests = [
    {
      adult: 1,
      children: 0,
      childrenAges: [],
    },
  ];

  //All of the Url Parameters
  var adultsParam = getUrlParam("ad");

  var childrenParam = getUrlParam("ch");

  var childrenAgesParam = getUrlParam("ag");

  var numberOfRoomsParam = parseInt(getUrlParam("NRooms"));

  if (isNaN(numberOfRoomsParam)) {
    numberOfRoomsParam = 1;
  }

  if (numberOfRoomsParam == 0) {
    numberOfRoomsParam = 1;
  }

  if (
    jQuery("#hotel_code-so").val() != "" &&
    jQuery("#hotel_code-so").val() != "0"
  ) {
    // childrenAllowed();

    var hotel_id = parseInt(jQuery("#hotel_code-so").val());
    var currency_id = parseInt(
      jQuery("#occupancy_dropdown-so").attr("data-default-currency")
    );

    //TODO!!! Figure out how to get max rooms

    var action = "get_max_rooms";
    var data = {};
    data.hotel_id = JSON.stringify(hotel_id);
    data.currency_id = JSON.stringify(currency_id);
    data.action = action;

    jQuery.post(searchbarAjax.ajaxurl, data, function (response) {
      maxRooms = response;
      if (maxRooms > 1) {
        // $('.select-room-add').css('display', 'block');
        jQuery(".select-room-plus-so").prop("disabled", false);
      }

      //If a url comes with more rooms than max rooms
      if (numberOfRoomsParam > maxRooms) {
        numberOfRoomsParam = maxRooms;
      }

      //If Url comes with a NRooms param
      if (
        typeof numberOfRoomsParam != "undefined" ||
        numberOfRoomsParam != null
      ) {
        //Clone the first room to as much rooms needed
        for (i = 1; i < numberOfRoomsParam; i++) {
          jQuery(".select-room-so")
            .eq(0)
            .clone()
            .appendTo(".select-room-holder-so");

          // Stores the cloned room in a variable and pushes the default settings for the room
          var clonedRoom = jQuery(".select-room-so").last();
          var defaultGuestValues = {
            adult: 1,
            children: 0,
            childrenAges: [],
          };

          guests.push(defaultGuestValues);
          //Sets the appropriate room counter for the cloned room, and shows it next to the Room String
          clonedRoom.attr(
            "data-room-counter",
            jQuery(".select-room-so").length - 1
          );
          clonedRoom
            .find(".select-room-counter-so")
            .text(parseInt(clonedRoom.attr("data-room-counter")) + 1);

          //Sets the string value of adults and children to the default value
          clonedRoom
            .find(".select-adults-value-so")
            .text(defaultGuestValues.adult);
          clonedRoom
            .find(".select-child-value-so")
            .text(defaultGuestValues.children);

          //Enables the + and disables the - just in case
          clonedRoom.find(".select-button-plus-so").prop("disabled", false);
          clonedRoom.find(".select-button-minus-so").prop("disabled", true);

          //Removes all the child ages input fields if the 1st room contains any
          clonedRoom.find(".select-child-ages").remove();

          //If Room is added show the divider line
          jQuery(".select-room-divider").css("display", "block");

          // var removeRoomStringAttribute = $('#guests-so').attr('data-remove-room');
          // //Add a button to be able to remove the added room
          // var removeRoomString = '<p class="select-remove-room custom-text">'+removeRoomStringAttribute+'</p>'
          // $(removeRoomString).insertBefore('.select-room:last hr');
        }

        //If maximum number of rooms is selected disable adding rooms
        if (jQuery(".select-room-so").length == maxRooms) {
          jQuery(".select-room-plus-so").prop("disabled", true);
        }

        if (jQuery(".select-room-so").length < maxRooms) {
          jQuery(".select-room-plus-so").prop("disabled", false);
        }

        if (jQuery(".select-room-so").length == 1) {
          jQuery(".select-room-minus-so").prop("disabled", true);
        }

        if (jQuery(".select-room-so").length > 1) {
          jQuery(".select-room-minus-so").prop("disabled", false);
        }
      }

      //If Url comes with a adults param
      if (typeof adultsParam != "undefined" || adultsParam != null) {
        //Split the adults param by , and turn the strings it returns in to numbers
        var adultsParamArray = adultsParam.split(",");
        var arrayParamArrayNumbers = adultsParamArray.map(Number);

        //If NRooms is 1 but there are more than 1 adults in the param
        if (numberOfRoomsParam == 1) {
          arrayParamArrayNumbers.length = 1;
        }

        //Set number of adults for each room
        for (i = 0; i < numberOfRoomsParam; i++) {
          //If there are more than 10 adults, set number of adults for that room to 1
          if (arrayParamArrayNumbers[i] > 10) {
            arrayParamArrayNumbers[i] = 1;
          }

          //If adult param is invalid set it to 1
          if (isNaN(arrayParamArrayNumbers[i])) {
            arrayParamArrayNumbers[i] = 1;
          }

          //Get number of adults for current room, and put it in the span representing the value,also check if buttons should be disabled
          guests[i].adult = parseInt(arrayParamArrayNumbers[i]);
          jQuery(".select-adults-value-so").eq(i).text(guests[i].adult);

          if (guests[i].adult > 1) {
            jQuery(".select-adult-minus-so").eq(i).prop("disabled", false);
          }

          if (guests[i].adult == 1) {
            jQuery(".select-adult-minus-so").eq(i).prop("disabled", true);
          }

          if (guests[i].adult == 10) {
            jQuery(".select-adult-plus-so").eq(i).prop("disabled", true);
          }

          if (guests[i].adult < 10) {
            jQuery(".select-adult-plus-so").eq(i).prop("disabled", false);
          }
        }

        //Update adults input field
        adultsInput.attr("value", adultsParam);
      }

      //If Url comes with a children param
      if (typeof childrenParam != "undefined" || childrenParam != null) {
        //Split the children param by , and turn the strings it returns in to numbers
        var childrenParamArray = childrenParam.split(",");
        var childrenParamArrayNumbers = childrenParamArray.map(Number);

        //If NRooms is 1 but there are more than 1 children in the param
        if (numberOfRoomsParam == 1) {
          childrenParamArrayNumbers.length = 1;
        }

        //Set number of children for each room
        for (i = 0; i < numberOfRoomsParam; i++) {
          if (childrenParamArrayNumbers[i] > 10) {
            childrenParamArrayNumbers[i] = 1;
          }

          //If children param is invalid set it to 1
          if (isNaN(childrenParamArrayNumbers[i])) {
            childrenParamArrayNumbers[i] = 0;
          }

          //Get number of children for current room, and put it in the span representing the value,also check if buttons should be disabled
          guests[i].children = parseInt(childrenParamArrayNumbers[i]);
          jQuery(".select-child-value-so").eq(i).text(guests[i].children);

          if (guests[i].children > 0) {
            jQuery(".select-child-minus-so").eq(i).prop("disabled", false);
          }

          if (guests[i].children == 0) {
            jQuery(".select-child-minus-so").eq(i).prop("disabled", true);
          }

          if (guests[i].children == 10) {
            jQuery(".select-child-plus-so").eq(i).prop("disabled", true);
          }

          if (guests[i].children < 10) {
            jQuery(".select-child-plus-so").eq(i).prop("disabled", false);
          }
        }

        //Update Children input fild
        childrenInput.attr("value", childrenParam);
      }

      // If no child ages for childs, set 0
      var childrenAgesParam = getUrlParam("ag");

      if (
        (typeof childrenParam != "undefined" || childrenParam != null) &&
        (typeof childrenAgesParam == "undefined" ||
          childrenAgesParam == null)
      ) {
        var childrenAgesParam = "";

        for (i = 0; i < childrenParamArray.length; i++) {
          var numberOfKidsPerRoom = Number(childrenParamArray[i]);

          for (k = 0; k < numberOfKidsPerRoom; k++) {
            childrenAgesParam += "99";

            if (k != numberOfKidsPerRoom - 1) {
              childrenAgesParam += ";";
            }
          }

          if (i != childrenParamArray.length - 1) {
            childrenAgesParam += ",";
          }
        }
      }

      //If Url comes with a children ages param
      if (
        typeof childrenAgesParam != "undefined" ||
        childrenAgesParam != null
      ) {
        var childrenAgesParamArray = childrenAgesParam.split(",");
        for (i = 0; i < numberOfRoomsParam; i++) {
          //Split children ages in current room iteration
          guests[i].childrenAges = childrenAgesParamArray[i];
          var childrenAges = guests[i].childrenAges.split(";");

          // loop childs
          for (j = 0; j < guests[i].children; j++) {
            // Clones the first child age div and stores it in a variable
            jQuery(".select-child-ages-clone-so").clone();

            var childAge = jQuery(".select-child-ages-clone-so")
              .clone()
              .last();

            //Removes the clone class and adds the real class
            childAge.removeClass("select-child-ages-clone-so");
            childAge.addClass("select-child-ages");

            //Appends the child age clone to the div its supposed to be in
            childAge.appendTo(jQuery(".select-child-ages-holder-so").eq(i));

            //Appends the apropriate number next to 'Child' eg. Child 1, Child 2, Child 3
            childAge.find(".select-child-ages-number-so").text(j + 1);

            //Removes the clone class from the input select field and adds the real class
            childAge
              .find(".select-child-ages-input-clone-so")
              .addClass("select-child-ages-input");
            childAge
              .find(".select-child-ages-input-clone-so")
              .removeClass("select-child-ages-input-clone-so");

            childAge
              .find(".select-child-ages-input")
              .find("option[data-value=" + childrenAges[j] + "]")
              .attr("selected", "selected");
          }
        }
        jQuery("#ag-so").attr("value", childrenAgesParam);
      }

      // Update the string in the #guests input field and on the button with current number of Guests and Rooms
      var guestNumber = 0;

      for (i = 0; i < guests.length; i++) {
        guestNumber = guestNumber + guests[i].adult + guests[i].children;
      }

      var roomString = "";
      if (numberOfRoomsParam > 1) {
        roomString = jQuery("#guests-so").attr("data-rooms");
      } else {
        roomString = jQuery("#guests-so").attr("data-room");
      }

      var guestString = "";
      if (guestNumber > 1) {
        guestString = jQuery("#guests-so").attr("data-guests");
      } else {
        guestString = jQuery("#guests-so").attr("data-guest");
      }

      //Set the whole string
      var guestsInputString =
        numberOfRoomsParam +
        " " +
        roomString +
        ", " +
        guestNumber +
        " " +
        guestString;

      jQuery("#guests-so").attr("value", guestsInputString);

      jQuery(".select-occupancy-apply-info-rooms-so").attr(
        "data-rooms",
        numberOfRoomsParam
      );
      jQuery(".select-occupancy-apply-info-rooms-so").text(numberOfRoomsParam);

      jQuery(".select-room-value-so").text(numberOfRoomsParam);
      if (numberOfRoomsParam > 1) {
        jQuery(".select-occupancy-apply-info-rooms-string-so").text(
          jQuery("#guests-so").attr("data-rooms")
        );
      } else {
        jQuery(".select-occupancy-apply-info-rooms-string-so").text(
          jQuery("#guests-so").attr("data-room")
        );
      }

      jQuery(".select-occupancy-apply-info-guests-so").attr(
        "data-guests",
        guestNumber
      );
      jQuery(".select-occupancy-apply-info-guests-so").text(guestNumber);
      if (guestNumber > 1) {
        jQuery(".select-occupancy-apply-info-guests-string-so").text(
          jQuery("#guests-so").attr("data-guests")
        );
      } else {
        jQuery(".select-occupancy-apply-info-guests-string-so").text(
          jQuery("#guests-so").attr("data-guest")
        );
      }
    });
  }
  //Same logic applied as in hotels, just for chain, because chain can only have 1 room
  else {

    jQuery(".add-room-holder-so").css("display", "none");

    // childrenAllowedChain();

    if (
      typeof numberOfRoomsParam != "undefined" ||
      numberOfRoomsParam != null
    ) {
      numberOfRoomsParam = 1;
    }

    if (typeof adultsParam != "undefined" || adultsParam != null) {
      var adultsParamArray = adultsParam.split(",");

      var arrayParamArrayNumbers = adultsParamArray.map(Number);

      arrayParamArrayNumbers.length = 1;

      if (arrayParamArrayNumbers[0] > 10) {
        arrayParamArrayNumbers[0] = 1;
      }

      guests[0].adult = parseInt(arrayParamArrayNumbers[0]);
      jQuery(".select-adults-value-so").text(guests[0].adult);

      if (guests[0].adult > 1) {
        jQuery(".select-adult-minus-so").prop("disabled", false);
      }

      if (guests[0].adult == 1) {
        jQuery(".select-adult-minus-so").prop("disabled", true);
      }

      if (guests[0].adult == 10) {
        jQuery(".select-adult-plus-so").prop("disabled", true);
      }

      if (guests[0].adult < 10) {
        jQuery(".select-adult-plus-so").prop("disabled", false);
      }

      adultsInput.attr("value", adultsParam);
    }

    if (typeof childrenParam != "undefined" || childrenParam != null) {
      var childrenParamArray = childrenParam.split(",");
      var childrenParamArrayNumbers = childrenParamArray.map(Number);

      childrenParamArrayNumbers.length = 1;

      if (childrenParamArrayNumbers[0] > 10) {
        childrenParamArrayNumbers[0] = 1;
      }
      guests[0].children = parseInt(childrenParamArrayNumbers[0]);
      jQuery(".select-child-value-so").text(guests[0].children);

      if (guests[0].children > 0) {
        jQuery(".select-child-minus-so").prop("disabled", false);
      }

      if (guests[0].children == 0) {
        jQuery(".select-child-minus-so").prop("disabled", true);
      }

      if (guests[0].children == 10) {
        jQuery(".select-child-plus-so").prop("disabled", true);
      }

      if (guests[0].children < 10) {
        jQuery(".select-child-plus-so").prop("disabled", false);
      }

      childrenInput.attr("value", childrenParam);
    }

    // If no child ages for childs, set 0
    var childrenAgesParam = getUrlParam("ag");

    if (
      (typeof childrenParam != "undefined" || childrenParam != null) &&
      (typeof childrenAgesParam == "undefined" || childrenAgesParam == null)
    ) {
      var childrenAgesParam = "";

      for (i = 0; i < childrenParamArray.length; i++) {
        var numberOfKidsPerRoom = Number(childrenParamArray[i]);

        for (k = 0; k < numberOfKidsPerRoom; k++) {
          childrenAgesParam += "99";

          if (k != numberOfKidsPerRoom - 1) {
            childrenAgesParam += ";";
          }
        }

        if (i != childrenParamArray.length - 1) {
          childrenAgesParam += ",";
        }
      }
    }

    if (
      typeof childrenAgesParam != "undefined" ||
      childrenAgesParam != null
    ) {
      var childrenAgesParamArray = childrenAgesParam.split(",");

      // loop every room
      for (i = 0; i < numberOfRoomsParam; i++) {
        guests[i].childrenAges = childrenAgesParamArray[i];
        var childrenAges = guests[i].childrenAges.split(";");

        // loop childs
        for (j = 0; j < guests[i].children; j++) {
          // Clones the first child age div and stores it in a variable
          jQuery(".select-child-ages-clone-so").clone();

          var childAge = jQuery(".select-child-ages-clone-so").clone().last();

          //Removes the clone class and adds the real class
          childAge.removeClass("select-child-ages-clone-so");
          childAge.addClass("select-child-ages");

          //Appends the child age clone to the div its supposed to be in
          childAge.appendTo(jQuery(".select-child-ages-holder-so").eq(i));

          //Appends the apropriate number next to 'Child' eg. Child 1, Child 2, Child 3
          childAge.find(".select-child-ages-number-so").text(j + 1);

          //Removes the clone class from the input select field and adds the real class
          childAge
            .find(".select-child-ages-input-clone-so")
            .addClass("select-child-ages-input");
          childAge
            .find(".select-child-ages-input-clone-so")
            .removeClass("select-child-ages-input-clone-so");

          childAge
            .find(".select-child-ages-input")
            .find("option[data-value=" + childrenAges[j] + "]")
            .attr("selected", "selected");
        }
      }
      jQuery("#ag-so").attr("value", childrenAgesParam);
    }

    var guestNumber = 0;

    for (i = 0; i < guests.length; i++) {
      guestNumber = guestNumber + guests[i].adult + guests[i].children;
    }

    var roomString = "";
    if (numberOfRoomsParam > 1) {
      roomString = jQuery("#guests-so").attr("data-rooms");
    } else {
      roomString = jQuery("#guests-so").attr("data-room");
    }

    var guestString = "";
    if (guestNumber > 1) {
      guestString = jQuery("#guests-so").attr("data-guests");
    } else {
      guestString = jQuery("#guests-so").attr("data-guest");
    }

    //Set the whole string
    var guestsInputString =
      numberOfRoomsParam +
      " " +
      roomString +
      ", " +
      guestNumber +
      " " +
      guestString;

    jQuery("#guests-so").attr("value", guestsInputString);

    jQuery(".select-occupancy-apply-info-rooms-so").attr(
      "data-rooms",
      numberOfRoomsParam
    );
    jQuery(".select-occupancy-apply-info-rooms-so").text(numberOfRoomsParam);
    if (numberOfRoomsParam > 1) {
      jQuery(".select-occupancy-apply-info-rooms-string-so").text(
        jQuery("#guests-so").attr("data-rooms")
      );
    } else {
      jQuery(".select-occupancy-apply-info-rooms-string-so").text(
        jQuery("#guests-so").attr("data-room")
      );
    }

    jQuery(".select-occupancy-apply-info-guests-so").attr(
      "data-guests",
      guestNumber
    );
    jQuery(".select-occupancy-apply-info-guests-so").text(guestNumber);
    if (guestNumber > 1) {
      jQuery(".select-occupancy-apply-info-guests-string-so").text(
        jQuery("#guests-so").attr("data-guests")
      );
    } else {
      jQuery(".select-occupancy-apply-info-guests-string-so").text(
        jQuery("#guests-so").attr("data-guest")
      );
    }
  }

  //If anything is clicked outside the occupancy div, slide it up
  jQuery(document).mousedown(function (e) {
    var occupancy_dropdown = jQuery("#occupancy_dropdown-so");
    if(resolution == 1) {
      if (
        !occupancy_dropdown.is(e.target) &&
        occupancy_dropdown.has(e.target).length === 0
      ) {
        occupancy_dropdown.slideUp(200);
        jQuery(".ob-searchbar-guests-so").removeClass("opened");
      }
    }
    
  });

  // If it's not a single hotel, disable the option to add multiple rooms, else allow it
  if (
    jQuery("#hotel_code-so").val() == "" ||
    jQuery("#hotel_code-so").val() == "0"
  ) {
    jQuery(".add-room-holder-so").css("display", "none");
  } else {
       jQuery(".add-room-holder-so").css("display", "flex");
  }

  jQuery("#guests-so").on("click", function () {

    var occupancyDropdown = jQuery("#occupancy_dropdown-so");

    if ( resolution == 1) {
        jQuery(".zcalendar-so").slideUp(200);
        jQuery(".ob-searchbar-calendar-so").removeClass("opened");
    }

    //Slide down occupancy dropdown and swap the arrow if it isnt visible
    if (occupancyDropdown.css("display") == "none") {
      occupancyDropdown.slideDown(200);

      jQuery(".ob-searchbar-guests-so").addClass("opened");
    }

    //Slide up occupancy dropdown and swap the arrow if it is visible
    else {
      occupancyDropdown.slideUp(200);
      jQuery(this).css(
        "background-image",
        // "url(/icons/icons_GreyDark/iconGreyDark_ArrowDown.svg)"
      );
      jQuery(".ob-searchbar-guests-so").removeClass("opened");
    }
  });

  //Function that runs when input guest input field is clicked

  //Event listener for select single hotel,all hotels or area in the search bar
  jQuery(".hotels_all, .hotels_hotel-so, .hotels_folder-so").on(
    "click",
    function () {
      //Remove all rooms if different hotel is selected
      if (jQuery(".select-room-so").length > 1) {
        jQuery(".select-room-so").not(":first").remove();
        jQuery(".select-room-divider").css("display", "none");
        //Remove all the rooms from the guests array
        guests.length = 1;
        jQuery("#NRooms-so").attr("value", 1);
        //Trigger a click on apply, so it would update input fields, update guests array properly and update the strings in apply button and #guests input
        jQuery(".select-occupancy-apply-so").trigger("click");
      }

      //If it's all hotels or area disable the option to add other rooms
      //Else get the hotel id and currency, and send an AJAX request to check the maximal number of rooms for that hotel
      if (
        jQuery("#hotel_code-so").val() == "" ||
        jQuery("#hotel_code-so").val() == "0"
      ) {
        jQuery(".add-room-holder-so").css("display", "none");
      } else {
        //TODO!!! Figure out how to get max rooms
        var hotel_id = parseInt($("#hotel_code-so").val());
        var currency_id = parseInt(
          jQuery("#occupancy_dropdown-so").attr("data-default-currency")
        );

        var action = "get_max_rooms";
        var data = {};
        data.hotel_id = JSON.stringify(hotel_id);
        data.currency_id = JSON.stringify(currency_id);
        data.action = action;
        jQuery.post(searchbarAjax.ajaxurl, data, function (response) {
          maxRooms = response;
          if (maxRooms > 1) {
            jQuery(".add-room-holder-so").css("display", "flex");
            jQuery(".select-room-plus-so").prop("disabled", false);
          }
        });
      }
    }
  );

  // Adult Buttons

  // Add Adults button
  jQuery(document).on("click", ".select-adult-plus-so", function () {
    var roomCounter = jQuery(this)
      .closest(".select-room-so")
      .attr("data-room-counter");

    //Increment value of adults input only if number of adults are bellow limit
    if (guests[roomCounter].adult < 10) {
      guests[roomCounter].adult = guests[roomCounter].adult + 1;
      jQuery(".select-adults-value-so")
        .eq(roomCounter)
        .text(guests[roomCounter].adult);
    }

    //Disable + button otherwise
    if (guests[roomCounter].adult == 10) {
      jQuery(this).prop("disabled", true);
    }

    //If number of adults is above the minimum enable the - button
    if (guests[roomCounter].adult > 1) {
      jQuery(".select-adult-minus-so").eq(roomCounter).prop("disabled", false);
    }

    //Change the string in the apply button on each + click
    var applyButtonGuests =
      parseInt(
        jQuery(".select-occupancy-apply-info-guests-so").attr("data-guests")
      ) + 1;
    jQuery(".select-occupancy-apply-info-guests-so").attr(
      "data-guests",
      applyButtonGuests
    );
    jQuery(".select-occupancy-apply-info-guests-so").text(applyButtonGuests);
    if (applyButtonGuests > 1) {
      jQuery(".select-occupancy-apply-info-guests-string-so").text(
        jQuery("#guests-so").attr("data-guests")
      );
    } else {
      jQuery(".select-occupancy-apply-info-guests-string-so").text(
        jQuery("#guests-so").attr("data-guest")
      );
    }
  });

  //Remove Adults button
  jQuery(document).on("click", ".select-adult-minus-so", function () {
    var roomCounter = jQuery(this)
      .closest(".select-room-so")
      .attr("data-room-counter");

    //Reduce value of adults input only if number of adults are above minimum
    if (guests[roomCounter].adult > 1) {
      guests[roomCounter].adult = guests[roomCounter].adult - 1;
      jQuery(".select-adults-value-so")
        .eq(roomCounter)
        .text(guests[roomCounter].adult);
    }

    // Disable - button otherwise
    if (guests[roomCounter].adult == 1) {
      jQuery(this).prop("disabled", true);
    }

    //If number of adults is bellow the limit enable the + button
    if (guests[roomCounter].adult < 10) {
      jQuery(".select-adult-plus-so").eq(roomCounter).prop("disabled", false);
    }

    //Change the string in the apply button on each - click
    var applyButtonGuests =
      parseInt(
        jQuery(".select-occupancy-apply-info-guests-so").attr("data-guests")
      ) - 1;
    jQuery(".select-occupancy-apply-info-guests-so").attr(
      "data-guests",
      applyButtonGuests
    );
    jQuery(".select-occupancy-apply-info-guests-so").text(applyButtonGuests);
    if (applyButtonGuests > 1) {
      jQuery(".select-occupancy-apply-info-guests-string-so").text(
        jQuery("#guests-so").attr("data-guests")
      );
    } else {
      jQuery(".select-occupancy-apply-info-guests-string-so").text(
        jQuery("#guests-so").attr("data-guest")
      );
    }
  });

  // Children Buttons

  // Add Children button
  jQuery(document).on("click", ".select-child-plus-so", function () {
    var roomCounter = jQuery(this)
      .closest(".select-room-so")
      .attr("data-room-counter");

    //Increment value of children input only if number of children are bellow limit
    if (guests[roomCounter].children < 10) {
      guests[roomCounter].children = guests[roomCounter].children + 1;
      jQuery(".select-child-value-so")
        .eq(roomCounter)
        .text(guests[roomCounter].children);

      // Clones the first child age div and stores it in a variable
      jQuery(".select-child-ages-clone-so").clone();
      var childAge = jQuery(".select-child-ages-clone-so").clone().last();

      //Removes the clone class and adds the real class
      childAge.removeClass("select-child-ages-clone-so");
      childAge.addClass("select-child-ages");

      //Appends the child age clone to the div its supposed to be in
      childAge.appendTo(
        jQuery(".select-child-ages-holder-so").eq(roomCounter)
      );

      //Appends the apropriate number next to 'Child' eg. Child 1, Child 2, Child 3
      childAge
        .find(".select-child-ages-number-so")
        .text(guests[roomCounter].children);

      //Removes the clone class from the input select field and adds the real class
      childAge
        .find(".select-child-ages-input-clone-so")
        .addClass("select-child-ages-input");
      childAge
        .find(".select-child-ages-input-clone-so")
        .removeClass("select-child-ages-input-clone-so");

      //Change the string in the apply button on each + click
      var applyButtonGuests =
        parseInt(
          jQuery(".select-occupancy-apply-info-guests-so").attr("data-guests")
        ) + 1;
      jQuery(".select-occupancy-apply-info-guests-so").attr(
        "data-guests",
        applyButtonGuests
      );
      jQuery(".select-occupancy-apply-info-guests-so").text(applyButtonGuests);
      if (applyButtonGuests > 1) {
        jQuery(".select-occupancy-apply-info-guests-string-so").text(
          jQuery("#guests-so").attr("data-guests")
        );
      } else {
        jQuery(".select-occupancy-apply-info-guests-string-so").text(
          jQuery("#guests-so").attr("data-guest")
        );
      }
    }

    //Disable + button otherwise
    if (guests[roomCounter].children == 10) {
      jQuery(this).prop("disabled", true);
    }

    //If number of adults is above the minimum enable the - button
    if (guests[roomCounter].children > 0) {
      jQuery(".select-child-minus-so").eq(roomCounter).prop("disabled", false);
    }
  });

  //Remove Children button
  jQuery(document).on("click", ".select-child-minus-so", function () {
    var roomCounter = jQuery(this)
      .closest(".select-room-so")
      .attr("data-room-counter");

    //Decreases child number if child number is above the minimum, updates the text value between the buttons and removes child select field
    if (guests[roomCounter].children > 0) {
      guests[roomCounter].children = guests[roomCounter].children - 1;
      jQuery(".select-child-value-so")
        .eq(roomCounter)
        .text(guests[roomCounter].children);

      jQuery(".select-child-ages-holder-so")
        .eq(roomCounter)
        .find(".select-child-ages")
        .last()
        .remove();
    }

    //Disables the - button if child minimum is reached
    if (guests[roomCounter].children == 0) {
      jQuery(this).prop("disabled", true);
    }

    //Enables the + button if children number is bellow the limit
    if (guests[roomCounter].children < 10) {
      jQuery(".select-child-plus-so").eq(roomCounter).prop("disabled", false);
    }

    //Change the string in the apply button on each - click
    var applyButtonGuests =
      parseInt(
        jQuery(".select-occupancy-apply-info-guests-so").attr("data-guests")
      ) - 1;
    jQuery(".select-occupancy-apply-info-guests-so").attr(
      "data-guests",
      applyButtonGuests
    );
    jQuery(".select-occupancy-apply-info-guests-so").text(applyButtonGuests);
    if (applyButtonGuests > 1) {
      jQuery(".select-occupancy-apply-info-guests-string-so").text(
        jQuery("#guests-so").attr("data-guests")
      );
    } else {
      jQuery(".select-occupancy-apply-info-guests-string-so").text(
        jQuery("#guests-so").attr("data-guest")
      );
    }
  });

  jQuery(document).on("click", ".select-room-plus-so", function () {
    //Clones the first room and appends it to the room holder div
    jQuery(".select-room-so").eq(0).clone().appendTo(".select-room-holder-so");

    // Stores the cloned room in a variable and pushes the default settings for the room
    var clonedRoom = jQuery(".select-room-so").last();

    var defaultRoomSettings = {
      adult: 1,
      children: 0,
      childrenAges: [],
    };
    guests.push(defaultRoomSettings);

    //Sets the appropriate room counter for the cloned room, and shows it next to the Room String
    clonedRoom.attr("data-room-counter", jQuery(".select-room-so").length - 1);
    clonedRoom
      .find(".select-room-counter-so")
      .text(parseInt(clonedRoom.attr("data-room-counter")) + 1);

    //Sets the string value of adults and children to the default value
    clonedRoom.find(".select-adults-value-so").text(defaultRoomSettings.adult);
    clonedRoom
      .find(".select-child-value-so")
      .text(defaultRoomSettings.children);

    //Enables the + and disables the - just in case
    clonedRoom.find(".select-button-plus-so").prop("disabled", false);
    clonedRoom.find(".select-button-minus-so").prop("disabled", true);

    //Removes all the child ages input fields if the 1st room contains any
    clonedRoom.find(".select-child-ages").remove();

    //If Room is added show the divider line
    // jQuery(".select-room-divider").css("display", "block");

    if (maxRooms == jQuery(".select-room-so").length) {
      jQuery(this).prop("disabled", true);
    }

    var applyButtonGuests =
      parseInt(
        jQuery(".select-occupancy-apply-info-guests-so").attr("data-guests")
      ) + 1;

    jQuery(".select-occupancy-apply-info-guests-so").attr(
      "data-guests",
      applyButtonGuests
    );
    jQuery(".select-occupancy-apply-info-guests-so").text(applyButtonGuests);
    if (applyButtonGuests > 1) {
      jQuery(".select-occupancy-apply-info-guests-string-so").text(
        jQuery("#guests-so").attr("data-guests")
      );
    } else {
      jQuery(".select-occupancy-apply-info-guests-string-so").text(
        jQuery("#guests-so").attr("data-guest")
      );
    }

    //Change the string in the apply button on each room added
    var applyButtonRooms =
      parseInt(
        jQuery(".select-occupancy-apply-info-rooms-so").attr("data-rooms")
      ) + 1;
    jQuery(".select-occupancy-apply-info-rooms-so").attr(
      "data-rooms",
      applyButtonRooms
    );

    jQuery(".select-occupancy-apply-info-rooms-so").text(applyButtonRooms);
    jQuery(".select-room-value-so").text(applyButtonRooms);
    if (applyButtonRooms > 1) {
      jQuery(".select-occupancy-apply-info-rooms-string-so").text(
        jQuery("#guests-so").attr("data-rooms")
      );
    } else {
      jQuery(".select-occupancy-apply-info-rooms-string-so").text(
        jQuery("#guests-so").attr("data-room")
      );
    }

    //Enable - if number of rooms is bigger than minimum
    if (jQuery(".select-room-so").length > 1) {
      jQuery(".select-room-minus-so").prop("disabled", false);
    }
  });

  // Remove a Room button

  jQuery(document).on("click", ".select-room-minus-so", function () {
    var roomCounter = jQuery(".select-room-so")
      .last()
      .attr("data-room-counter");

    var applyButtonGuests =
      parseInt(
        $(".select-occupancy-apply-info-guests-so").attr("data-guests")
      ) -
      guests[roomCounter].adult -
      guests[roomCounter].children;
    jQuery(".select-occupancy-apply-info-guests-so").attr(
      "data-guests",
      applyButtonGuests
    );
    jQuery(".select-occupancy-apply-info-guests-so").text(applyButtonGuests);
    if (applyButtonGuests > 1) {
      jQuery(".select-occupancy-apply-info-guests-string-so").text(
        jQuery("#guests-so").attr("data-guests")
      );
    } else {
      jQuery(".select-occupancy-apply-info-guests-string-so").text(
        jQuery("#guests-so").attr("data-guest")
      );
    }

    var applyButtonRooms =
      parseInt($(".select-occupancy-apply-info-rooms-so").attr("data-rooms")) -
      1;
    jQuery(".select-occupancy-apply-info-rooms-so").attr(
      "data-rooms",
      applyButtonRooms
    );
    jQuery(".select-occupancy-apply-info-rooms-so").text(applyButtonRooms);
    jQuery(".select-room-value-so").text(applyButtonRooms);

    if (jQuery(".select-room-so").length > 1) {
      jQuery(".select-occupancy-apply-info-rooms-string-so").text(
        jQuery("#guests-so").attr("data-rooms")
      );
    } else {
      jQuery(".select-occupancy-apply-info-rooms-string-so").text(
        jQuery("#guests-so").attr("data-room")
      );
    }

    guests.splice(roomCounter, 1);

    jQuery(".select-room-so").last().remove();

    if (maxRooms > jQuery(".select-room-so").length) {
      jQuery(".select-room-plus-so").prop("disabled", false);
    }

    if (jQuery(".select-room-so").length == 1) {
      jQuery(".select-room-minus-so").prop("disabled", true);
    }
  });

  // show and hide child age
  jQuery(document).on("click", ".age-picker-so", function () {
    if ($(this).find(".age-picker-options-so").is(":visible")) {
      $(".age-picker-options-so").hide();

      $(this).find(".age-picker-options-so").hide();
    } else {
      $(".age-picker-options-so").hide();

      $(this).find(".age-picker-options-so").show();
    }
  });

  // choose age
  jQuery(document).on("click", ".age-picker-options-so div", function () {
    var age = $(this).data("age");

    $(this).parent().parent().find(".age-picker-value-so").text(age);

    var selectInput = $(this).parent().next();

    selectInput.children().removeAttr("selected");

    selectInput.find("[data-value='" + age + "']").attr("selected", "");
  });

  //Apply Button
  jQuery(document).on("click", ".select-occupancy-apply-so", function () {
    var childAgeHolder = jQuery(".select-child-ages-holder-so");

    var adultsInput = jQuery("#ad-so");
    var adultsArray = [];

    var childrenInput = jQuery("#ch-so");
    var childrenArray = [];

    var childrenAgesInput = jQuery("#ag-so");
    var childrenAgesString = "";

    var numberOfRoomsInput = jQuery("#NRooms-so");
    var numberOfRooms = jQuery(".select-room-so").length;

    var guestNumber = 0;

    var roomsAreSame = false;

    for (i = 1; i < numberOfRooms; i++) {
      if (
        guests[0].adult == guests[i].adult &&
        guests[0].children == guests[i].children
      ) {
        roomsAreSame = true;
      } else {
        roomsAreSame = false;
        break;
      }
    }

    //Set all the input values to 0
    adultsInput.attr("value", 0);
    childrenInput.attr("value", 0);
    childrenAgesInput.attr("value", 0);

    //Loop through all the rooms
    for (i = 0; i < jQuery(".select-room-so").length; i++) {
      //Always reset the children ages array, so it doesen't keep adding values to it if you click apply more than once
      guests[i].childrenAges = [];

      //Get all guest value for the #guests input field
      guestNumber = guestNumber + guests[i].adult + guests[i].children;

      //Loop through all the ages in the current room iteration, and push it to the childrenAges
      for (
        j = 0;
        j < childAgeHolder.eq(i).find(".select-child-ages-input").length;
        j++
      ) {
        guests[i].childrenAges.push(
          childAgeHolder
            .eq(i)
            .find(".select-child-ages-input")
            .eq(j)
            .find("option:selected")
            .attr("data-value")
        );
      }

      //Make a string out of the array, and add ; at the end to separate arrays by room
      childrenAgesString += guests[i].childrenAges.join(";") + ",";

      //Push number of adults and children in to each rooms array
      adultsArray.push(guests[i].adult);
      childrenArray.push(guests[i].children);
    }

    //If there is only 1 room, replace all the commas, with the semicolon
    if (numberOfRooms == 1) {
      childrenAgesString = childrenAgesString.replace(/,/g, ";");
    }

    //Remove last char from the children ages String
    childrenAgesString = childrenAgesString.slice(0, -1);

    //Make a string out of adults and children Array
    var adultsString = adultsArray.join();
    var childrenString = childrenArray.join();

    //Set the input values
    adultsInput.attr("value", adultsString);
    childrenInput.attr("value", childrenString);
    childrenAgesInput.attr("value", childrenAgesString);

    if (roomsAreSame == true) {
      adultsStringTrim = adultsString.split(",");
      adultsInput.attr("value", adultsStringTrim[0]);

      childrenStringTrim = childrenString.split(",");
      childrenInput.attr("value", childrenStringTrim[0]);

      childrenAgesTrim = childrenAgesString.split(",");
      childrenAgesInput.attr("value", childrenAgesTrim[0]);

      numberOfRoomsInput.attr("value", "1");
    } else {
      numberOfRoomsInput.attr("value", numberOfRooms);
    }

    //Getting the strings for #guests input in the search bar, checking if it should be singular, plural
    var roomString = "";
    if (numberOfRooms > 1) {
      roomString = jQuery("#guests-so").attr("data-rooms");
    } else {
      roomString = jQuery("#guests-so").attr("data-room");
    }

    var guestString = "";
    if (guestNumber > 1) {
      guestString = jQuery("#guests-so").attr("data-guests");
    } else {
      guestString = jQuery("#guests-so").attr("data-guest");
    }

    //Set the whole string
    var guestsInputString =
      numberOfRooms +
      " " +
      roomString +
      ", " +
      guestNumber +
      " " +
      guestString;

    jQuery(".select-occupancy-apply-info-rooms-so").attr(
      "data-rooms",
      numberOfRooms
    );
    jQuery(".select-occupancy-apply-info-rooms-so").text(numberOfRooms);
    jQuery(".select-occupancy-apply-info-rooms-string-so").text(roomString);

    jQuery(".select-occupancy-apply-info-guests-so").attr(
      "data-guests",
      guestNumber
    );
    jQuery(".select-occupancy-apply-info-guests-so").text(guestNumber);
    jQuery(".select-occupancy-apply-info-guests-string-so").text(guestString);

    jQuery("#guests-so").attr("value", guestsInputString);

    // Check if kids have age

    if (childrenAgesString.includes("/")) {
      jQuery(".search-button, #btn-search").prop("disabled", true);

      jQuery(".select-child-ages-input").each(function (index) {
        if (jQuery(this).val() == "/") {
          jQuery(this).next().show();
        } else {
          jQuery(this).next().hide();
        }
      });
    } else {
      //Close the occupancy dropdown
      jQuery(".incorect-age-so").hide();
      jQuery(".search-button, #btn-search").prop("disabled", false);
      if(resolution == 1) {
        jQuery("#occupancy_dropdown-so").slideUp(200);
      }
      jQuery(".ob-searchbar-guests-so").removeClass("opened");
    }

    // Check if children are allowed

    if (jQuery("#hotel_code-so").val() != "") {
      childrenAllowed();
    } else {
      childrenAllowedChain();
    }
  });

    // disable submit if children are choosen on hotels which dont allow them
      // disable submit if children are choosen on hotels which dont allow them

      function childrenAllowed(load) {

          var currencyId = $(".obpress-currencies-select").find(":selected").attr("data-curr") ;
          var hotelCode = $("#hotel_code-so").val();
          var selectedChildren = Number( $("#ch-so").val() );


           $(".age-picker-options-so div").hide();


            // prepare ajax request for children availability and max age

              jQuery.get(searchbarAjax.ajaxurl + "?q=" +  hotelCode + '&currencyId=' + currencyId + "&action=get_children_availability", function(response){

                      var allowed =  JSON.parse(response) ;

                      var max_age = allowed[1]; 

                      $(".child-max-age-so").text( max_age );

                      $(".age-picker-options-so").each(function() {

                           for ( i = 0 ; i <= max_age ; i++) {

                                $(this).find("div:eq("+i+")").show();
                            }
                      });


                      if ( selectedChildren > 0 ) { 

                          if ( allowed[0] == false  ) {

                            $(".ob-searchbar-submit-so").attr('disabled', 'disabled');

                            $("#children-not-allowed-phone").text(response[1]);

                            $("#children-not-allowed-email").text(response[2]);

                            if (load == "load") {

                                $(".ob-searchbar-submit-so").trigger( "click" );
                            };

                          }  else  {

                             $(".ob-searchbar-submit-so").removeAttr("disabled");

                        }  

                      } else {

                         $(".ob-searchbar-submit-so").removeAttr("disabled");

                      }
              });
           

        // end of request

      };

      function childrenAllowedChain() {

        $(".child-max-age-so").text("17");

        $(".age-picker-options-so div").show();

        $(".ob-searchbar-submit-so").removeAttr("disabled");
        
      };


    // go back
     jQuery(document).on("click", ".obpress-hotel-searchbar-back-holder", function () {
      window.history.back();
     });

    // show next step loader
    jQuery(document).on("click", ".obpress-hotel-searchbar-back-holder, .obpress-extras-submit", function () {
      $("body > .container").hide();
      $(".next-step-loader").css("display", "flex");
      $(".obpress-footer").hide();
      $(".grey-background").hide();
      $(this).closest(".modal-content").find(".close-modal").click();
    });

    // jQuery(document).on("click", ".ob-searchbar-submit", function() {
    //   $(this).closest(".obpress-hotel-searchbar-custom").find(".select-occupancy-apply").click();
    //   $(this).closest(".obpress-hotel-searchbar-custom").find("#promo_code_apply").click();
    //   $("body > .container").hide();
    //   $(".next-step-loader").css("display", "flex");
    //   $(".obpress-footer").hide();
    //   $(".grey-background").hide();
    //   $(this).closest(".modal-content").find(".close-modal").click();
    // });

    // open calendar on mobile inputs
    jQuery(document).on("click", "#check_in_mobile-so, #check_out_mobile-so", function() {
      $(this).closest(".ob-searchbar-calendar-so").find("#calendar_dates-so").click();
    });

    // show promo code input on mobile
    jQuery(document).on("click", ".ob-mobile-i-have-a-code-input-so", function() {
      if($("#promo_code_dropdown-so").css("display") == "none" && $(".ob-mobile-i-have-a-code-input-so").is(":checked")) {
        $("#promo_code_dropdown-so").show();
      } else {
        $("#promo_code_dropdown-so").hide();
      }
    });

    if(resolution != 1) {
      $("#group_code-so ,#Code-so, #loyalty_code-so").attr("placeholder", "");
    }

    $(document).on("click", ".zc-close", function() {
      if(resolution != 1) {
        if($(".zcalendar-wrap-so").css("display") == "none") {
          $(".zcalendar-wrap-so").show();
        } else {
          $(".zcalendar-wrap-so").hide();
        }
      }
    });
});
