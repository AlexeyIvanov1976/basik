<?php
/**
 * WooCommerce Functions
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('WooCommerce')) {
    return;
}

/**
 * Update cart fragments for AJAX cart
 */
function pearlpool_woo_cart_link_fragment($fragments) {
    ob_start();
    ?>
    <a class="cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e('View your shopping cart', 'pearlpool-woo'); ?>">
        <?php echo '<span class="cart-count">' . WC()->cart->get_cart_contents_count() . '</span>'; ?>
    </a>
    <?php
    $fragments['a.cart-contents'] = ob_get_clean();
    return $fragments;
}
add_filter('woocommerce_add_to_cart_fragments', 'pearlpool_woo_cart_link_fragment');

/**
 * Product loop display settings
 */
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
add_action('woocommerce_before_shop_loop_item_title', 'pearlpool_woo_product_sale_flash', 10);

function pearlpool_woo_product_sale_flash() {
    global $product;
    if ($product->is_on_sale()) {
        echo '<span class="onsale">' . __('Sale!', 'pearlpool-woo') . '</span>';
    }
}

/**
 * Add wrapper around product image
 */
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
add_action('woocommerce_before_shop_loop_item_title', 'pearlpool_woo_template_loop_product_thumbnail', 10);

function pearlpool_woo_template_loop_product_thumbnail() {
    echo '<div class="product-image-wrapper">';
    woocommerce_template_loop_product_thumbnail();
    echo '</div>';
}

/**
 * Change add to cart button text on product archives
 */
add_filter('woocommerce_product_add_to_cart_text', 'pearlpool_woo_archive_add_to_cart_text');
function pearlpool_woo_archive_add_to_cart_text($text) {
    return __('Add to Cart', 'pearlpool-woo');
}

/**
 * Single product gallery thumbnails
 */
add_filter('woocommerce_gallery_thumbnail_html', 'pearlpool_woo_gallery_thumbnail_html', 10, 2);
function pearlpool_woo_gallery_thumbnail_html($html, $thumbnail_id) {
    $image_src = wp_get_attachment_image_src($thumbnail_id, 'thumbnail');
    $full_image_src = wp_get_attachment_image_src($thumbnail_id, 'full');
    
    return '<li data-thumb="' . esc_url($full_image_src[0]) . '" class="woocommerce-product-gallery__thumbnail">
        <a href="' . esc_url($full_image_src[0]) . '">
            <img src="' . esc_url($image_src[0]) . '" alt="' . get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true) . '" />
        </a>
    </li>';
}

/**
 * Mini cart in header
 */
function pearlpool_woo_header_cart() {
    if (!class_exists('WooCommerce')) {
        return;
    }
    ?>
    <div class="header-cart">
        <a class="cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e('View your shopping cart', 'pearlpool-woo'); ?>">
            <span class="cart-icon">🛒</span>
            <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
            <span class="cart-total"><?php echo WC()->cart->get_cart_subtotal(); ?></span>
        </a>
        
        <?php if (WC()->cart->get_cart_contents_count() > 0) : ?>
            <div class="mini-cart">
                <?php the_widget('WC_Widget_Cart'); ?>
            </div>
        <?php endif; ?>
    </div>
    <?php
}

/**
 * Product categories widget arguments
 */
add_filter('woocommerce_product_categories_widget_args', 'pearlpool_woo_product_categories_widget_args');
function pearlpool_woo_product_categories_widget_args($args) {
    $args['title'] = __('Categories', 'pearlpool-woo');
    return $args;
}

/**
 * Related products args
 */
add_filter('woocommerce_output_related_products_args', 'pearlpool_woo_related_products_args');
function pearlpool_woo_related_products_args($args) {
    $args['posts_per_page'] = 4;
    $args['columns'] = 4;
    return $args;
}

/**
 * Upsells products args
 */
add_filter('woocommerce_upsell_display_args', 'pearlpool_woo_upsells_display_args');
function pearlpool_woo_upsells_display_args($args) {
    $args['posts_per_page'] = 4;
    $args['columns'] = 4;
    return $args;
}

/**
 * Cross-sells products args
 */
add_filter('woocommerce_cross_sells_total', 'pearlpool_woo_cross_sells_total');
function pearlpool_woo_cross_sells_total($limit) {
    return 4;
}

add_filter('woocommerce_cross_sells_columns', 'pearlpool_woo_cross_sells_columns');
function pearlpool_woo_cross_sells_columns($columns) {
    return 4;
}

/**
 * Remove default WooCommerce sidebar on shop page
 */
add_action('wp', 'pearlpool_woo_remove_sidebar');
function pearlpool_woo_remove_sidebar() {
    if (is_shop() || is_product_category()) {
        remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
    }
}

/**
 * Custom shop columns
 */
add_action('pre_get_posts', 'pearlpool_woo_shop_columns');
function pearlpool_woo_shop_columns($q) {
    if (!is_admin() && $q->is_main_query() && is_shop()) {
        $q->set('posts_per_page', 12);
    }
}

/**
 * Product quick view support
 */
function pearlpool_woo_quick_view_button() {
    global $product;
    ?>
    <a href="#" class="button quick-view-button" data-product_id="<?php echo esc_attr($product->get_id()); ?>">
        <?php _e('Quick View', 'pearlpool-woo'); ?>
    </a>
    <?php
}
add_action('woocommerce_after_shop_loop_item', 'pearlpool_woo_quick_view_button', 9);

/**
 * Wishlist button (placeholder for integration)
 */
function pearlpool_woo_wishlist_button() {
    ?>
    <a href="#" class="wishlist-button" title="<?php esc_attr_e('Add to wishlist', 'pearlpool-woo'); ?>">
        <span class="wishlist-icon">♡</span>
    </a>
    <?php
}
add_action('woocommerce_after_shop_loop_item_title', 'pearlpool_woo_wishlist_button', 5);

/**
 * Compare button (placeholder for integration)
 */
function pearlpool_woo_compare_button() {
    ?>
    <a href="#" class="compare-button" title="<?php esc_attr_e('Compare', 'pearlpool-woo'); ?>">
        <span class="compare-icon">⚖</span>
    </a>
    <?php
}
add_action('woocommerce_after_shop_loop_item_title', 'pearlpool_woo_compare_button', 6);

/**
 * Stock availability badge
 */
add_filter('woocommerce_get_availability_text', 'pearlpool_woo_stock_badge', 10, 2);
function pearlpool_woo_stock_badge($availability, $product) {
    if (!$product->is_in_stock()) {
        return '<span class="stock-badge out-of-stock">' . __('Out of Stock', 'pearlpool-woo') . '</span>';
    } elseif ($product->get_stock_quantity() && $product->get_stock_quantity() < 10) {
        return '<span class="stock-badge low-stock">' . sprintf(__('Only %d left!', 'pearlpool-woo'), $product->get_stock_quantity()) . '</span>';
    }
    return $availability;
}

/**
 * Add product count to category links
 */
add_filter('woocommerce_subcategory_count_html', 'pearlpool_woo_category_count', 10, 2);
function pearlpool_woo_category_count($count_string, $category) {
    return ' <span class="product-count">(' . $count_string . ')</span>';
}

/**
 * Checkout fields customization
 */
add_filter('woocommerce_checkout_fields', 'pearlpool_woo_checkout_fields');
function pearlpool_woo_checkout_fields($fields) {
    // Add placeholders
    $fields['billing']['billing_first_name']['placeholder'] = __('First Name', 'pearlpool-woo');
    $fields['billing']['billing_last_name']['placeholder'] = __('Last Name', 'pearlpool-woo');
    $fields['billing']['billing_email']['placeholder'] = __('Email Address', 'pearlpool-woo');
    $fields['billing']['billing_phone']['placeholder'] = __('Phone Number', 'pearlpool-woo');
    
    return $fields;
}

/**
 * Order received page customization
 */
add_action('woocommerce_thankyou', 'pearlpool_woo_order_received_message');
function pearlpool_woo_order_received_message($order_id) {
    if (!$order_id) {
        return;
    }
    ?>
    <div class="order-received-extra">
        <p><?php _e('Thank you for your order! We will contact you soon.', 'pearlpool-woo'); ?></p>
    </div>
    <?php
}
