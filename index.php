<?php

/**
 * Plugin Name: Tvs Debates System Core 
 * Author: Tvs Debates System Core - css, js and tvs Elementor Widget 
 * Text-domain: wp-single-system
 * Plugin URI: https://github.com/stnc/tvs-core
 * Version: 4.0.0
 * Description: For frontend css and js 
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// use STNC\Controllers\Players_Controller;


include "DebugDemo.php";


//cancel 
//Elementor_STNC_Extension::instance();






 function ssCore_enqueue_style()
 {
     wp_enqueue_style( "ss-style-boot",plugins_url("assets/css/tvsCore.css", __FILE__) ,"","4.0.44" );
 
 }
 add_action('wp_enqueue_scripts', 'ssCore_enqueue_style');
 
 