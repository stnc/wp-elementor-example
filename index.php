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

// use SeriouslySimplePodcasting\Controllers\Players_Controller;

final class Elementor_Castos_Extension {
    /**
     * Plugin Version
     *
     * @since 1.0.0
     *
     * @var string The plugin version.
     */
    const VERSION = '1.0.0';

    /**
     * Minimum Elementor Version
     *
     * @since 1.0.0
     *
     * @var string Minimum Elementor version required to run the plugin.
     */
    const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

    /**
     * Minimum PHP Version
     *
     * @since 1.0.0
     *
     * @var string Minimum PHP version required to run the plugin.
     */
    const MINIMUM_PHP_VERSION = '7.0';

    /**
     * Instance
     *
     * @since 1.0.0
     *
     * @access private
     * @static
     *
     * @var Elementor_Castos_Extension The single instance of the class.
     */
    private static $_instance = null;

    /**
     * Instance
     *
     * Ensures only one instance of the class is loaded or can be loaded.
     *
     * @since 1.0.0
     *
     * @access public
     * @static
     *
     * @return Elementor_Castos_Extension An instance of the class.
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Constructor
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function __construct() {
        add_action( 'init', [ $this, 'i18n' ] );
        add_action( 'plugins_loaded', [ $this, 'init' ] );
    }

    /**
     * Load Textdomain
     *
     * Load plugin localization files.
     *
     * Fired by `init` action hook.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function i18n() {
        load_plugin_textdomain( 'elementor-test-extension' );
    }


    /**
     * Initialize the plugin
     *
     * Load the plugin only after Elementor (and other plugins) are loaded.
     * Checks for basic plugin requirements, if one check fail don't continue,
     * if all check have passed load the files required to run the plugin.
     *
     * Fired by `plugins_loaded` action hook.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function init() {
        // Check if Elementor installed and activated
        if ( ! did_action( 'elementor/loaded' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
            return;
        }

        // Check for required Elementor version
        if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
            return;
        }

        // Check for required PHP version
        if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
            return;
        }

        // Add Plugin actions
        add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
        add_action( 'elementor/controls/controls_registered', [ $this, 'init_controls' ] );

        // Register Widget Styles
        add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'widget_styles' ] );

        // add_action('plugins_loaded', 'my_coupon_init');

        // function my_coupon_init() {
        //     if ( class_exists('Players_Controller') ) {
        //         $coupon = new Players_Controller();
        //         // some code here
        //     } else {
        //         add_action('admin_notices', 'wc_not_loaded');
        //     }
        // }

        // function wc_not_loaded() {
        //     printf(
        //         '<div class="error"><p>%s</p></div>',
        //         __('Sorry cannot create coupon because WooCommerce is not loaded')
        //     );
        // }
    }

    public function widget_styles() {

        wp_register_style( 'widget-1', plugins_url( 'css/castos-widget-1.css', __FILE__ ) );

    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have Elementor installed or activated.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function admin_notice_missing_main_plugin() {

        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

        $message = sprintf(
        /* translators: 1: Plugin name 2: Elementor */
            esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'elementor-test-extension' ),
            '<strong>' . esc_html__( 'Elementor Castos Extension', 'elementor-castos-extension' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor', 'elementor-castos-extension' ) . '</strong>'
        );

        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have a minimum required Elementor version.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function admin_notice_minimum_elementor_version() {

        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

        $message = sprintf(
        /* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-test-extension' ),
            '<strong>' . esc_html__( 'Elementor Castos Extension', 'elementor-castos-extension' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor', 'elementor-castos-extension' ) . '</strong>',
            self::MINIMUM_ELEMENTOR_VERSION
        );

        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have a minimum required PHP version.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function admin_notice_minimum_php_version() {

        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

        $message = sprintf(
        /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-test-extension' ),
            '<strong>' . esc_html__( 'Elementor Castos Extension', 'elementor-castos-extension' ) . '</strong>',
            '<strong>' . esc_html__( 'PHP', 'elementor-castos-extension' ) . '</strong>',
            self::MINIMUM_PHP_VERSION
        );

        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

    }

    /**
     * Init Widgets
     *
     * Include widgets files and register them
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function init_widgets() {

        // Include Widget files
        require_once( __DIR__ . '/widgets/test-widget.php' );

        // Register widget
        \Elementor\Plugin::instance()->widgets_manager->register( new \Elementor_Test_Widget() );

    }

    /**
     * Init Controls
     *
     * Include controls files and register them
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function init_controls() {}

    public function includes() {}

}

Elementor_Castos_Extension::instance();






 function ssCore_enqueue_style()
 {
     wp_enqueue_style( "ss-style-boot",plugins_url("assets/css/tvsCore.css", __FILE__) ,"","4.0.40" );
 
 }
 add_action('wp_enqueue_scripts', 'ssCore_enqueue_style');
 
 
 
 //forked
 
 // Plugin Name99: Post List With Featured Image
 // Plugin URI999: http://angelwebsolution.in/
 // Version999: 1.2.1
 // Author999: Dharmesh Patel
 /* Display custom column in Post List Page */
 // function display_posts_featured_image_dp_CORE($column, $post_id) {
 //     // $final_data = get_option("post_with_image_dp_data");
     
 //     $max_width = "100px"; // default 100px
 //     $max_height = "100px"; // default 100px
 //     $width = "auto"; // default auto
 //     $height = "auto"; // default auto
 //     // if (!empty($final_data)) {
 //     //     $max_width = intval($final_data['max_width'])."px";
 //     //     $max_height = intval($final_data['max_height'])."px";
 //     //     $width = $final_data['width'];
 //     //     $height = $final_data['height'];
 //     // }
 //     if ($column == 'image') {
 //         $image = get_the_post_thumbnail_url($post_id, "thumbnail");
 //         if ($image == "") {
 //             $image = plugins_url("/images/dummy-150x150.png", __FILE__);  //dummy image 
 //         }
 //         echo '<img src=' . $image . ' style="max-height:' . $max_height . ';max-width:' . $max_width . '; height:' . $height . '; width:' . $width . '">';
 //     }
 // }
 // // add_action('manage_posts_custom_column', 'display_posts_featured_image_dp', 10, 2);
 
 
 // /* Display custom column in Post List Page */
 // function add_image_column_to_post_dp_CORE($columns) {
 //     return array_merge($columns, array('image' => __('Image', 'Image of the post')));
 // }
 // // add_filter('manage_posts_columns', 'add_image_column_to_post_dp');
 
 
 // $post_types = get_post_types();
 // foreach ( $post_types  as $post_type ) {
 //     add_action('manage_'.$post_type.'_posts_custom_column', 'display_posts_featured_image_dp', 10, 2);
 //     add_filter('manage_'.$post_type.'_posts_columns', 'add_image_column_to_post_dp');
 // }
 // add_action('manage_branch_posts_custom_column', 'display_posts_featured_image_dp', 10, 2);
 // add_filter('manage_branch_posts_columns', 'add_image_column_to_post_dp');