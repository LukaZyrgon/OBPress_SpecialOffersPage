<?php
/*
  Plugin name: OBPress Special Offers Page by Zyrgon
  Plugin uri: www.zyrgon.net
  Text Domain: OBPress_SpecialOffersPage
  Description: Widgets to OBPress
  Version: 0.0.9
  Author: Zyrgon
  Author uri: www.zyrgon.net
  License: GPlv2 or Later
*/

function language_init_obpress_special_offers_page() {
  load_plugin_textdomain( 'OBPress_SpecialOffersPage', false, '/OBPress_SpecialOffersPage/languages' );
}
add_action('init', 'language_init_obpress_special_offers_page');

//Show Elementor plugins only if api token and chain/hotel are set in the admin
if(get_option('obpress_api_set') == true){
    require_once('elementor/init.php');
}


//register ajax calls
require_once(WP_PLUGIN_DIR . '/OBPress_SpecialOffersPage/ajax/special-offer-ajax.php');


// TODO, MAKE GIT BRANCH, CONNECT WITH UPDATE CHECKER

require_once(WP_PLUGIN_DIR . '/OBPress_SpecialOffersPage/plugin-update-checker-4.11/plugin-update-checker.php');
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
    'https://github.com/LukaZyrgon/OBPress_SpecialOffersPage',
    __FILE__,
    'OBPress_SpecialOffersPage'
);

$myUpdateChecker->setBranch('main');
