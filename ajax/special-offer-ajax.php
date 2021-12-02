<?php

add_action('wp_ajax_get_data_for_rooms', 'get_data_for_rooms');
add_action('wp_ajax_nopriv_get_data_for_rooms', 'get_data_for_rooms');






function get_data_for_rooms() {



    require_once(WP_CONTENT_DIR . '/plugins/obpress_plugin_manager/BeApi/BeApi.php');
    require_once(WP_PLUGIN_DIR . '/obpress_plugin_manager/class-lang-curr-functions.php');
    require_once(WP_PLUGIN_DIR . '/obpress_plugin_manager/class-analyze-avail.php');
    require_once(WP_PLUGIN_DIR . '/obpress_plugin_manager/class-analyze-descriptive-infos-response.php');

    new Lang_Curr_Functions();

    Lang_Curr_Functions::chainOrHotel($id);


    $promotion_id = $_GET["package_id"];
    $chain = get_option('chain_id');

    $languages = Lang_Curr_Functions::getLanguagesArray();
    $language = Lang_Curr_Functions::getLanguage();
    $language_object = Lang_Curr_Functions::getLanguageObject();        
    $currencies = Lang_Curr_Functions::getCurrenciesArray();
    $currency = Lang_Curr_Functions::getCurrency();

    foreach ($currencies as $currency_from_api) {
        if ($currency_from_api->UID == $currency) {
            $currency_string = $currency_from_api->CurrencySymbol;
            break;
        }
    }


    //get check in and out times or set default ones
    Lang_Curr_Functions::getCheckTimes($_GET['CheckIn'], $_GET['CheckOut']);
    $CheckIn = Lang_Curr_Functions::getCheckIn();
    $CheckOut = Lang_Curr_Functions::getCheckOut();

    $hotels_in_chain = [];
    $hotels = BeApi::ApiCache('hotel_search_chain_'.$chain.'_'.$language.'_true', BeApi::$cache_time['hotel_search_chain'], function() use ($chain, $language){
        return BeApi::getHotelSearchForChain($chain, "true",$language);
    });


    foreach($hotels->PropertiesType->Properties as $Property) {
        $hotels_in_chain[$Property->HotelRef->HotelCode]["HotelCode"] = $Property->HotelRef->HotelCode;
        $hotels_in_chain[$Property->HotelRef->HotelCode]["HotelName"] = $Property->HotelRef->HotelName;
        $hotels_in_chain[$Property->HotelRef->HotelCode]["ChainName"] = $Property->HotelRef->ChainName;
        $hotels_in_chain[$Property->HotelRef->HotelCode]["Country"] = $Property->Address->CountryCode;
        $hotels_in_chain[$Property->HotelRef->HotelCode]["City"] = $Property->Address->CityCode;
        $hotels_in_chain[$Property->HotelRef->HotelCode]["StateProvCode"] = $Property->Address->StateProvCode;
        $hotels_in_chain[$Property->HotelRef->HotelCode]["AddressLine"] = $Property->Address->AddressLine;
        $hotels_in_chain[$Property->HotelRef->HotelCode]["Latitude"] = $Property->Position->Latitude;
        $hotels_in_chain[$Property->HotelRef->HotelCode]["Longitude"] = $Property->Position->Longitude;
        $hotels_in_chain[$Property->HotelRef->HotelCode]["MaxPartialPaymentParcel"] = $Property->MaxPartialPaymentParcel;
    }

    if(isset($_GET["mobile"]) && $_GET["mobile"] != null && $_GET["mobile"] == true) {
        $mobile = "true";
    }
    else {
        $mobile = "false";
    }

    $available_packages = BeApi::ApiCache('available_packages_'.$chain.'_'.$currency.'_'.$language.'_'.$mobile, BeApi::$cache_time['available_packages'], function() use ($chain, $currency, $language, $mobile){
        return BeApi::getClientAvailablePackages($chain, $currency, $language, null, $mobile);
    });

    foreach ($available_packages->RoomStaysType->RoomStays as $RoomStay) {
        foreach ($RoomStay->RatePlans as $RatePlan) {
            if($promotion_id == $RatePlan->RatePlanID) {
                $hotel_from_package = $RoomStay->BasicPropertyInfo->HotelRef->HotelCode;
            }
        }
    }
    $property = $hotel_from_package;

    $rateplans = [];
    $rateplans_per_hotel = [];
    $hotel_id = null;

    $rateplans[$hotel_from_package] = BeApi::ApiCache('rateplans_array_'.$hotel_from_package.'_'.$language, BeApi::$cache_time['rateplans_array'], function() use ($hotel_from_package, $language){
        return BeApi::getHotelRatePlans($hotel_from_package, $language);
    });

    $hotel_search = BeApi::ApiCache('hotel_search_property_'.$property.'_'.$language.'_true', BeApi::$cache_time['hotel_search_property'], function() use ($property, $language) {
        return BeApi::getHotelSearchForProperty($property, "true", $language);
    });

    foreach ($rateplans as $rateplan) {
        if($rateplan->RatePlans != null) {
            foreach ($rateplan->RatePlans->RatePlan as $RatePlan) {
                if ($RatePlan->RatePlanTypeCode == 11) {
                    $rateplans_per_hotel[$rateplan->RatePlans->HotelRef->HotelCode][$RatePlan->RatePlanID] = $RatePlan;
                }
            }
        }
    }


    foreach ($available_packages->RoomStaysType->RoomStays as $RoomStay) {
        foreach ($RoomStay->RoomRates as $RoomRate) {
            $package_offers[$RoomStay->BasicPropertyInfo->HotelRef->HotelCode][$RoomRate->RatePlanID]["room_rate"] = $RoomRate;
        }
        foreach ($RoomStay->RatePlans as $RatePlan) {
            $package_offers[$RoomStay->BasicPropertyInfo->HotelRef->HotelCode][$RatePlan->RatePlanID]["rate_plan"] = $RatePlan;
        }  
    }

    if($available_packages->TPA_Extensions != null) {
        foreach ($available_packages->TPA_Extensions->MultimediaDescriptionsType->MultimediaDescriptions as  $MultimediaDescription) {
            foreach ($package_offers as $hotel_code => $package_offer) {
                foreach ($package_offer as $rate_plan_code => $offer) {
                    if ($MultimediaDescription->ID == $rate_plan_code) {
                        $package_offers[$hotel_code][$rate_plan_code]["image"] = $MultimediaDescription;
                    }
                }
            }
        }
    }


    if(isset($package_offers)) {
        foreach ($package_offers as $hotel_code => $package_offer) {
            foreach ($package_offer as $rate_plan_code => $offer) {
                foreach ($rateplans_per_hotel as $hotel_code2 => $per_hotel) {
                    foreach ($per_hotel as $rate_plan_code2 => $rateplan) {
                        if($rate_plan_code2 == $rate_plan_code) {

                            $package_offers[$hotel_code][$rate_plan_code]["get_rate_plans"] = $rateplan;

                        }
                    }
                }
            }
        }
    }
    else {
        $package_offers = null;
    }

    if($_GET['ad'] == null) {
        $adults = 1;
    }
    else {
        $adults = $_GET['ad'];
    }
   
    $promocode = "";
    if($_GET['Code'] != null && $_GET['Code'] != '') {
        $promocode = $_GET['Code'];
    }

    $groupcode = "";
    if ($_GET['group_code'] != null && $_GET['group_code'] != '') {
        $groupcode = $_GET['group_code'];
    }


    $data = BeApi::getChainData($chain, $CheckIn, $CheckOut, $adults, ($_GET['ch'] != null && $_GET["ch"] > 0) ? $_GET['ch'] : 0, $_GET['ag'], $property, "false", $currency, $language, $promocode, $groupcode, $mobile);
    $data = new AnalyzeAvailRes($data);



    $descriptive_info = BeApi::ApiCache('hotel_descriptive_info_'.$property.'_'.$language, BeApi::$cache_time['hotel_descriptive_info'], function() use ($property, $language) {
        return BeApi::getHotelDescriptiveInfo($property, $language);
    });
    $descriptive_info = new AnalyzeDescriptiveInfosRes($descriptive_info);

    $style = BeApi::ApiCache('style_'.$property.'_'.$currency.'_'.$language, BeApi::$cache_time['omnibees.style'], function () use ($property, $currency, $language) {
        return BeApi::getPropertyStyle($property, $currency, $language);
    });

    $plugin_directory_path = plugins_url( '', __FILE__ );
    $plugins_directory = plugins_url();


    require_once(WP_PLUGIN_DIR . '/OBPress_SpecialOffersPage/widget/assets/templates/template-rooms.php');

    die();
}