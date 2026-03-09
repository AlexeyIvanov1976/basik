<?php
/**
 * Theme Name: PearlPool WooCommerce
 * Theme URI: https://example.com/pearlpool-woo
 * Author: Developer
 * Author URI: https://example.com
 * Description: WooCommerce theme inspired by pearlpool.ru with automatic setup, navigation menu, widgets, and demo data importer.
 * Version: 1.0.0
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: pearlpool-woo
 * Domain Path: /languages
 * Requires at least: 5.8
 * Requires PHP: 7.4
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define theme constants
define('PEARLPOOL_WOO_VERSION', '1.0.0');
define('PEARLPOOL_WOO_DIR', get_template_directory());
define('PEARLPOOL_WOO_URI', get_template_directory_uri());

/**
 * Theme Setup
 */
function pearlpool_woo_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails
    add_theme_support('post-thumbnails');

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'pearlpool-woo'),
        'footer'  => __('Footer Menu', 'pearlpool-woo'),
        'mobile'  => __('Mobile Menu', 'pearlpool-woo'),
    ));

    // Switch default core markup to output valid HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    // Add support for custom logo
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    // Add support for WooCommerce
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    // Custom background support
    add_theme_support('custom-background');

    // Custom header support
    add_theme_support('custom-header', array(
        'default-image'      => '',
        'default-text-color' => '000000',
        'width'              => 1920,
        'height'             => 400,
        'flex-width'         => true,
        'flex-height'        => true,
    ));

    // Load text domain
    load_theme_textdomain('pearlpool-woo', PEARLPOOL_WOO_DIR . '/languages');
}
add_action('after_setup_theme', 'pearlpool_woo_setup');

/**
 * Enqueue scripts and styles
 */
function pearlpool_woo_scripts() {
    // Main stylesheet
    wp_enqueue_style('pearlpool-woo-style', get_stylesheet_uri(), array(), PEARLPOOL_WOO_VERSION);

    // Custom CSS
    wp_enqueue_style('pearlpool-woo-custom', PEARLPOOL_WOO_URI . '/css/custom.css', array(), PEARLPOOL_WOO_VERSION);

    // jQuery
    wp_enqueue_script('jquery');

    // Custom JavaScript
    wp_enqueue_script('pearlpool-woo-scripts', PEARLPOOL_WOO_URI . '/js/scripts.js', array('jquery'), PEARLPOOL_WOO_VERSION, true);

    // Comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'pearlpool_woo_scripts');

/**
 * Register widget areas
 */
function pearlpool_woo_widgets_init() {
    register_sidebar(array(
        'name'          => __('Main Sidebar', 'pearlpool-woo'),
        'id'            => 'sidebar-main',
        'description'   => __('Add widgets here for the main sidebar.', 'pearlpool-woo'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => __('Shop Sidebar', 'pearlpool-woo'),
        'id'            => 'sidebar-shop',
        'description'   => __('Add widgets here for the shop sidebar.', 'pearlpool-woo'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => __('Footer Widget 1', 'pearlpool-woo'),
        'id'            => 'footer-1',
        'description'   => __('First footer widget area.', 'pearlpool-woo'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));

    register_sidebar(array(
        'name'          => __('Footer Widget 2', 'pearlpool-woo'),
        'id'            => 'footer-2',
        'description'   => __('Second footer widget area.', 'pearlpool-woo'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));

    register_sidebar(array(
        'name'          => __('Footer Widget 3', 'pearlpool-woo'),
        'id'            => 'footer-3',
        'description'   => __('Third footer widget area.', 'pearlpool-woo'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));

    register_sidebar(array(
        'name'          => __('Header Widget', 'pearlpool-woo'),
        'id'            => 'header-widget',
        'description'   => __('Widget area in the header.', 'pearlpool-woo'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<span class="widget-title">',
        'after_title'   => '</span>',
    ));
}
add_action('widgets_init', 'pearlpool_woo_widgets_init');

/**
 * WooCommerce specific functions
 */
if (class_exists('WooCommerce')) {
    // Remove default WooCommerce wrapper
    remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
    remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

    // Add custom WooCommerce wrapper
    add_action('woocommerce_before_main_content', 'pearlpool_woo_woocommerce_wrapper_start', 10);
    add_action('woocommerce_after_main_content', 'pearlpool_woo_woocommerce_wrapper_end', 10);

    function pearlpool_woo_woocommerce_wrapper_start() {
        echo '<main id="primary" class="site-main woocommerce-main">';
    }

    function pearlpool_woo_woocommerce_wrapper_end() {
        echo '</main>';
    }

    // Change number of products per page
    add_filter('loop_shop_per_page', 'pearlpool_woo_products_per_page', 20);
    function pearlpool_woo_products_per_page($cols) {
        return 12;
    }

    // Change number of columns
    add_filter('loop_shop_columns', 'pearlpool_woo_loop_columns');
    function pearlpool_woo_loop_columns() {
        return 4;
    }

    // Remove related products
    remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
}

/**
 * Include required files
 */
require_once PEARLPOOL_WOO_DIR . '/inc/class-demo-importer.php';
require_once PEARLPOOL_WOO_DIR . '/inc/template-functions.php';
require_once PEARLPOOL_WOO_DIR . '/inc/woocommerce-functions.php';

/**
 * Admin menu for demo importer
 */
function pearlpool_woo_admin_menu() {
    add_theme_page(
        __('Demo Importer', 'pearlpool-woo'),
        __('Demo Importer', 'pearlpool-woo'),
        'manage_options',
        'pearlpool-demo-importer',
        'pearlpool_woo_demo_importer_page'
    );
}
add_action('admin_menu', 'pearlpool_woo_admin_menu');

/**
 * Demo importer page callback
 */
function pearlpool_woo_demo_importer_page() {
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <div class="pearlpool-admin-panel" style="max-width: 800px; background: #fff; padding: 30px; margin-top: 20px; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
            <h2><?php _e('Import Demo Data', 'pearlpool-woo'); ?></h2>
            <p><?php _e('Click the button below to automatically create pages, menus, widgets, and sample content similar to pearlpool.ru', 'pearlpool-woo'); ?></p>
            
            <div id="pearlpool-import-status" style="margin: 20px 0; padding: 15px; display: none;"></div>
            
            <button type="button" id="pearlpool-import-btn" class="button button-primary button-hero" style="margin: 20px 0;">
                <?php _e('📦 Import Demo Content', 'pearlpool-woo'); ?>
            </button>
            
            <div id="pearlpool-progress" style="margin-top: 20px; display: none;">
                <progress id="import-progress" value="0" max="100" style="width: 100%; height: 30px;"></progress>
                <p id="import-status-text" style="margin-top: 10px;"></p>
            </div>
        </div>

        <script>
        jQuery(document).ready(function($) {
            $('#pearlpool-import-btn').on('click', function() {
                var btn = $(this);
                var statusDiv = $('#pearlpool-import-status');
                var progressDiv = $('#pearlpool-progress');
                var progressBar = $('#import-progress');
                var statusText = $('#import-status-text');
                
                btn.prop('disabled', true).text('<?php _e('Importing...', 'pearlpool-woo'); ?>');
                statusDiv.show().removeClass('error success').addClass('notice notice-alt');
                progressDiv.show();
                
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'pearlpool_import_demo_data',
                        nonce: '<?php echo wp_create_nonce('pearlpool_import_nonce'); ?>'
                    },
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = evt.loaded / evt.total;
                                progressBar.val(percentComplete * 100);
                                statusText.text(Math.round(percentComplete * 100) + '%');
                            }
                        }, false);
                        return xhr;
                    },
                    success: function(response) {
                        if (response.success) {
                            statusDiv.addClass('notice-success').html('<p><strong>' + response.data.message + '</strong></p>');
                            progressBar.val(100);
                            statusText.text('<?php _e('Complete!', 'pearlpool-woo'); ?>');
                        } else {
                            statusDiv.addClass('notice-error').html('<p><strong>Error:</strong> ' + response.data.message + '</p>');
                        }
                        btn.prop('disabled', false).text('<?php _e('📦 Import Demo Content', 'pearlpool-woo'); ?>');
                    },
                    error: function() {
                        statusDiv.addClass('notice-error').html('<p><strong>Error:</strong> <?php _e('An error occurred during import.', 'pearlpool-woo'); ?></p>');
                        btn.prop('disabled', false).text('<?php _e('📦 Import Demo Content', 'pearlpool-woo'); ?>');
                    }
                });
            });
        });
        </script>
        
        <style>
            .pearlpool-admin-panel h2 { margin-top: 0; color: #23282d; }
            .pearlpool-admin-panel p { color: #555d66; line-height: 1.6; }
            .notice-alt { border-left: 4px solid #0073aa; }
            .notice-success { border-left: 4px solid #46b450 !important; background: #edfaef !important; }
            .notice-error { border-left: 4px solid #dc3232 !important; background: #fbeaea !important; }
        </style>
    </div>
    <?php
}

/**
 * AJAX handler for demo import
 */
function pearlpool_ajax_import_demo_data() {
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'pearlpool_import_nonce')) {
        wp_send_json_error(array('message' => __('Security check failed', 'pearlpool-woo')));
    }

    // Check capabilities
    if (!current_user_can('manage_options')) {
        wp_send_json_error(array('message' => __('Insufficient permissions', 'pearlpool-woo')));
    }

    try {
        $importer = new PearlPool_Demo_Importer();
        $result = $importer->import();
        
        if ($result['success']) {
            wp_send_json_success(array('message' => $result['message']));
        } else {
            wp_send_json_error(array('message' => $result['message']));
        }
    } catch (Exception $e) {
        wp_send_json_error(array('message' => $e->getMessage()));
    }
}
add_action('wp_ajax_pearlpool_import_demo_data', 'pearlpool_ajax_import_demo_data');

/**
 * Theme activation hook - auto setup
 */
function pearlpool_woo_theme_activation() {
    // Run demo importer on activation
    $importer = new PearlPool_Demo_Importer();
    $importer->import();
    
    // Set default options
    update_option('thumbnail_size_w', 300);
    update_option('thumbnail_size_h', 300);
    update_option('medium_size_w', 600);
    update_option('medium_size_h', 600);
    update_option('large_size_w', 1200);
    update_option('large_size_h', 1200);
    
    // Flush rewrite rules
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'pearlpool_woo_theme_activation');
