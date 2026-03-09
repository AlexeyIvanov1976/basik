<?php
/**
 * Template Functions
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Display primary navigation
 */
function pearlpool_woo_primary_nav() {
    wp_nav_menu(array(
        'theme_location' => 'primary',
        'menu_class'     => 'primary-menu',
        'container'      => 'nav',
        'container_class' => 'primary-navigation',
    ));
}

/**
 * Display footer navigation
 */
function pearlpool_woo_footer_nav() {
    wp_nav_menu(array(
        'theme_location' => 'footer',
        'menu_class'     => 'footer-menu',
        'container'      => 'nav',
        'container_class' => 'footer-navigation',
    ));
}

/**
 * Display mobile navigation
 */
function pearlpool_woo_mobile_nav() {
    wp_nav_menu(array(
        'theme_location' => 'mobile',
        'menu_class'     => 'mobile-menu',
        'container'      => 'nav',
        'container_class' => 'mobile-navigation',
    ));
}

/**
 * Get site logo
 */
function pearlpool_woo_get_logo() {
    if (has_custom_logo()) {
        the_custom_logo();
    } else {
        echo '<a href="' . esc_url(home_url('/')) . '" class="site-logo-text">' . get_bloginfo('name') . '</a>';
    }
}

/**
 * Breadcrumb navigation
 */
function pearlpool_woo_breadcrumb() {
    if (is_front_page()) {
        return;
    }

    echo '<nav class="breadcrumb" aria-label="' . esc_attr__('Breadcrumb', 'pearlpool-woo') . '">';
    echo '<a href="' . esc_url(home_url('/')) . '">' . __('Home', 'pearlpool-woo') . '</a>';

    if (is_shop()) {
        echo ' <span class="separator">/</span> ';
        echo '<span class="current">' . __('Shop', 'pearlpool-woo') . '</span>';
    } elseif (is_product_category()) {
        echo ' <span class="separator">/</span> ';
        echo '<a href="' . esc_url(get_permalink(get_option('woocommerce_shop_page_id'))) . '">' . __('Shop', 'pearlpool-woo') . '</a>';
        echo ' <span class="separator">/</span> ';
        echo '<span class="current">' . single_cat_title('', false) . '</span>';
    } elseif (is_product()) {
        global $product;
        echo ' <span class="separator">/</span> ';
        echo '<a href="' . esc_url(get_permalink(get_option('woocommerce_shop_page_id'))) . '">' . __('Shop', 'pearlpool-woo') . '</a>';
        
        $categories = wc_get_product_category_list($product->get_id(), ', ');
        if ($categories) {
            echo ' <span class="separator">/</span> ';
            echo '<span class="current">' . get_the_title() . '</span>';
        } else {
            echo ' <span class="separator">/</span> ';
            echo '<span class="current">' . get_the_title() . '</span>';
        }
    } elseif (is_page()) {
        echo ' <span class="separator">/</span> ';
        echo '<span class="current">' . get_the_title() . '</span>';
    }

    echo '</nav>';
}

/**
 * Post thumbnail with fallback
 */
function pearlpool_woo_post_thumbnail($size = 'post-thumbnail', $attr = '') {
    if (has_post_thumbnail()) {
        the_post_thumbnail($size, $attr);
    } else {
        echo '<div class="post-thumbnail-placeholder">' . __('No Image', 'pearlpool-woo') . '</div>';
    }
}

/**
 * Custom excerpt length
 */
function pearlpool_woo_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'pearlpool_woo_excerpt_length');

/**
 * Custom excerpt more
 */
function pearlpool_woo_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'pearlpool_woo_excerpt_more');

/**
 * Add body classes
 */
function pearlpool_woo_body_classes($classes) {
    // Adds a class of hfeed to non-singular pages.
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    // Adds a class of no-sidebar when there is no sidebar present.
    if (!is_active_sidebar('sidebar-main')) {
        $classes[] = 'no-sidebar';
    }

    // WooCommerce specific classes
    if (class_exists('WooCommerce')) {
        if (is_shop() || is_product_category() || is_product_tag()) {
            $classes[] = 'woocommerce-archive';
        }
        if (is_product()) {
            $classes[] = 'woocommerce-single';
        }
        if (is_cart()) {
            $classes[] = 'woocommerce-cart';
        }
        if (is_checkout()) {
            $classes[] = 'woocommerce-checkout';
        }
    }

    return $classes;
}
add_filter('body_class', 'pearlpool_woo_body_classes');

/**
 * Pingback header
 */
function pearlpool_woo_pingback_header() {
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
    }
}
add_action('wp_head', 'pearlpool_woo_pingback_header');

/**
 * Preload fonts
 */
function pearlpool_woo_resource_hints($urls, $relation_type) {
    if ('preconnect' === $relation_type) {
        $urls[] = array(
            'href' => 'https://fonts.googleapis.com',
        );
        $urls[] = array(
            'href' => 'https://fonts.gstatic.com',
            'crossorigin' => 'anonymous',
        );
    }

    return $urls;
}
add_filter('wp_resource_hints', 'pearlpool_woo_resource_hints', 10, 2);
