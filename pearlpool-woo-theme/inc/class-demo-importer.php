<?php
/**
 * Demo Importer Class
 * Handles automatic creation of pages, menus, widgets, and sample content
 */

if (!defined('ABSPATH')) {
    exit;
}

class PearlPool_Demo_Importer {

    private $created_pages = array();
    private $created_menus = array();
    private $imported_widgets = false;

    /**
     * Main import method
     */
    public function import() {
        try {
            // Create essential pages
            $this->create_pages();

            // Create navigation menus
            $this->create_menus();

            // Setup widgets
            $this->setup_widgets();

            // Set WooCommerce options
            $this->setup_woocommerce_options();

            // Set theme options
            $this->setup_theme_options();

            return array(
                'success' => true,
                'message' => __('Demo content imported successfully! Pages, menus, and widgets have been created.', 'pearlpool-woo'),
                'pages'   => $this->created_pages,
                'menus'   => $this->created_menus,
            );
        } catch (Exception $e) {
            return array(
                'success' => false,
                'message' => $e->getMessage(),
            );
        }
    }

    /**
     * Create essential pages
     */
    private function create_pages() {
        $pages = array(
            array(
                'title'   => __('Home', 'pearlpool-woo'),
                'slug'    => 'home',
                'content' => $this->get_home_page_content(),
                'template' => 'front-page.php',
            ),
            array(
                'title'   => __('Shop', 'pearlpool-woo'),
                'slug'    => 'shop',
                'content' => '',
                'template' => '',
            ),
            array(
                'title'   => __('About Us', 'pearlpool-woo'),
                'slug'    => 'about-us',
                'content' => $this->get_about_page_content(),
                'template' => '',
            ),
            array(
                'title'   => __('Delivery & Payment', 'pearlpool-woo'),
                'slug'    => 'delivery-payment',
                'content' => $this->get_delivery_page_content(),
                'template' => '',
            ),
            array(
                'title'   => __('Warranty', 'pearlpool-woo'),
                'slug'    => 'warranty',
                'content' => $this->get_warranty_page_content(),
                'template' => '',
            ),
            array(
                'title'   => __('Contacts', 'pearlpool-woo'),
                'slug'    => 'contacts',
                'content' => $this->get_contacts_page_content(),
                'template' => '',
            ),
            array(
                'title'   => __('Blog', 'pearlpool-woo'),
                'slug'    => 'blog',
                'content' => '',
                'template' => '',
            ),
        );

        foreach ($pages as $page) {
            $page_id = $this->create_page($page['title'], $page['slug'], $page['content']);
            if ($page_id) {
                $this->created_pages[$page['slug']] = $page_id;

                if (!empty($page['template'])) {
                    update_post_meta($page_id, '_wp_page_template', $page['template']);
                }
            }
        }

        // Set shop page for WooCommerce
        if (isset($this->created_pages['shop'])) {
            update_option('woocommerce_shop_page_id', $this->created_pages['shop']);
        }

        // Set front page
        if (isset($this->created_pages['home'])) {
            update_option('show_on_front', 'page');
            update_option('page_on_front', $this->created_pages['home']);
        }

        // Set blog page
        if (isset($this->created_pages['blog'])) {
            update_option('page_for_posts', $this->created_pages['blog']);
        }
    }

    /**
     * Create a single page
     */
    private function create_page($title, $slug, $content = '') {
        // Check if page already exists
        $existing_page = get_page_by_path($slug);
        if ($existing_page) {
            return $existing_page->ID;
        }

        $page_data = array(
            'post_title'   => $title,
            'post_name'    => $slug,
            'post_content' => $content,
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_author'  => get_current_user_id(),
        );

        $page_id = wp_insert_post($page_data);

        if (!is_wp_error($page_id)) {
            return $page_id;
        }

        return false;
    }

    /**
     * Create navigation menus
     */
    private function create_menus() {
        // Primary Menu
        $primary_menu_id = $this->create_menu(__('Primary Menu', 'pearlpool-woo'), 'primary');
        if ($primary_menu_id) {
            $this->add_menu_items($primary_menu_id, array(
                array('title' => __('Home', 'pearlpool-woo'), 'url' => home_url('/')),
                array('title' => __('Shop', 'pearlpool-woo'), 'url' => home_url('/shop')),
                array('title' => __('About Us', 'pearlpool-woo'), 'url' => home_url('/about-us')),
                array('title' => __('Delivery & Payment', 'pearlpool-woo'), 'url' => home_url('/delivery-payment')),
                array('title' => __('Warranty', 'pearlpool-woo'), 'url' => home_url('/warranty')),
                array('title' => __('Contacts', 'pearlpool-woo'), 'url' => home_url('/contacts')),
                array('title' => __('Blog', 'pearlpool-woo'), 'url' => home_url('/blog')),
            ));
            $this->assign_menu_location($primary_menu_id, 'primary');
        }

        // Footer Menu
        $footer_menu_id = $this->create_menu(__('Footer Menu', 'pearlpool-woo'), 'footer');
        if ($footer_menu_id) {
            $this->add_menu_items($footer_menu_id, array(
                array('title' => __('About Us', 'pearlpool-woo'), 'url' => home_url('/about-us')),
                array('title' => __('Delivery & Payment', 'pearlpool-woo'), 'url' => home_url('/delivery-payment')),
                array('title' => __('Warranty', 'pearlpool-woo'), 'url' => home_url('/warranty')),
                array('title' => __('Contacts', 'pearlpool-woo'), 'url' => home_url('/contacts')),
                array('title' => __('Privacy Policy', 'pearlpool-woo'), 'url' => home_url('/privacy-policy')),
            ));
            $this->assign_menu_location($footer_menu_id, 'footer');
        }

        // Mobile Menu
        $mobile_menu_id = $this->create_menu(__('Mobile Menu', 'pearlpool-woo'), 'mobile');
        if ($mobile_menu_id) {
            $this->add_menu_items($mobile_menu_id, array(
                array('title' => __('Home', 'pearlpool-woo'), 'url' => home_url('/')),
                array('title' => __('Shop', 'pearlpool-woo'), 'url' => home_url('/shop')),
                array('title' => __('Catalog', 'pearlpool-woo'), 'url' => home_url('/shop'), 'meta' => array('classes' => array('menu-item-has-children'))),
                array('title' => __('About Us', 'pearlpool-woo'), 'url' => home_url('/about-us')),
                array('title' => __('Contacts', 'pearlpool-woo'), 'url' => home_url('/contacts')),
            ));
            $this->assign_menu_location($mobile_menu_id, 'mobile');
        }
    }

    /**
     * Create a menu
     */
    private function create_menu($name, $location) {
        // Check if menu already exists
        $existing_menu = wp_get_nav_menu_object($name);
        if ($existing_menu) {
            return $existing_menu->term_id;
        }

        $menu_id = wp_create_nav_menu($name);

        if (!is_wp_error($menu_id)) {
            $this->created_menus[$location] = $menu_id;
            return $menu_id;
        }

        return false;
    }

    /**
     * Add items to menu
     */
    private function add_menu_items($menu_id, $items) {
        foreach ($items as $item) {
            $menu_item_data = array(
                'menu-item-title'     => $item['title'],
                'menu-item-url'       => $item['url'],
                'menu-item-status'    => 'publish',
                'menu-item-type'      => 'custom',
                'menu-item-object'    => 'custom',
            );

            if (isset($item['meta']) && !empty($item['meta'])) {
                $menu_item_data['menu-item-classes'] = isset($item['meta']['classes']) ? implode(' ', $item['meta']['classes']) : '';
            }

            wp_update_nav_menu_item($menu_id, 0, $menu_item_data);
        }
    }

    /**
     * Assign menu to location
     */
    private function assign_menu_location($menu_id, $location) {
        $locations = get_theme_mod('nav_menu_locations');
        if (!is_array($locations)) {
            $locations = array();
        }
        $locations[$location] = $menu_id;
        set_theme_mod('nav_menu_locations', $locations);
    }

    /**
     * Setup widgets
     */
    private function setup_widgets() {
        // Get all sidebars
        $sidebars_widgets = get_option('sidebars_widgets', array());

        // Footer Widget 1 - About
        $sidebars_widgets['footer-1'] = array(
            $this->add_widget('text', array(
                'title'   => __('About PearlPool', 'pearlpool-woo'),
                'text'    => __('We are a leading supplier of premium pool equipment and accessories. Quality guaranteed.', 'pearlpool-woo'),
            )),
        );

        // Footer Widget 2 - Contact Info
        $sidebars_widgets['footer-2'] = array(
            $this->add_widget('text', array(
                'title'   => __('Contact Information', 'pearlpool-woo'),
                'text'    => __('📞 +7 (XXX) XXX-XX-XX<br>📧 info@example.com<br>📍 Moscow, Russia', 'pearlpool-woo'),
            )),
        );

        // Footer Widget 3 - Working Hours
        $sidebars_widgets['footer-3'] = array(
            $this->add_widget('text', array(
                'title'   => __('Working Hours', 'pearlpool-woo'),
                'text'    => __('Mon-Fri: 9:00 - 18:00<br>Sat-Sun: 10:00 - 16:00', 'pearlpool-woo'),
            )),
        );

        // Shop Sidebar
        $sidebars_widgets['sidebar-shop'] = array(
            $this->add_widget('woocommerce_product_categories', array(
                'title' => __('Product Categories', 'pearlpool-woo'),
            )),
            $this->add_widget('price_filter', array(
                'title' => __('Filter by Price', 'pearlpool-woo'),
            )),
        );

        update_option('sidebars_widgets', $sidebars_widgets);
        $this->imported_widgets = true;
    }

    /**
     * Add widget instance
     */
    private function add_widget($widget_base, $instance) {
        $widget_instances = get_option('widget_' . $widget_base, array());
        
        // Find next available index
        $index = 1;
        while (isset($widget_instances[$index])) {
            $index++;
        }

        $widget_instances[$index] = $instance;
        update_option('widget_' . $widget_base, $widget_instances);

        return $widget_base . '-' . $index;
    }

    /**
     * Setup WooCommerce options
     */
    private function setup_woocommerce_options() {
        // General WooCommerce settings
        update_option('woocommerce_currency', 'RUB');
        update_option('woocommerce_currency_pos', 'right_space');
        update_option('woocommerce_price_thousand_sep', ' ');
        update_option('woocommerce_price_decimal_sep', ',');
        update_option('woocommerce_price_num_decimals', '0');

        // Catalog settings
        update_option('woocommerce_catalog_columns', 4);
        update_option('woocommerce_rows_per_page', 3);

        // Enable guest checkout
        update_option('woocommerce_enable_guest_checkout', 'yes');

        // Enable coupons
        update_option('woocommerce_enable_coupons', 'yes');

        // Calculate shipping
        update_option('woocommerce_calc_shipping', 'yes');

        // Enable reviews
        update_option('woocommerce_enable_reviews', 'yes');
        update_option('woocommerce_review_rating_verification_required', 'yes');
    }

    /**
     * Setup theme options
     */
    private function setup_theme_options() {
        // Set default color scheme
        set_theme_mod('header_textcolor', '000000');
        set_theme_mod('background_color', 'ffffff');

        // Set custom logo placeholder (if needed)
        // This would require an actual image ID
    }

    /**
     * Get home page content
     */
    private function get_home_page_content() {
        return '
<!-- wp:cover {"url":"' . PEARLPOOL_WOO_URI . '/images/hero-bg.jpg","dimRatio":50,"overlayColor":"black","align":"full"} -->
<div class="wp-block-cover alignfull has-black-background-color has-background-dim"><span aria-hidden="true" class="wp-block-cover__background has-black-background-color has-background-dim-50 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:heading {"textAlign":"center","level":1,"style":{"typography":{"fontSize":"48px"}}} -->
<h1 class="has-text-align-center" style="font-size:48px">' . __('Premium Pool Equipment', 'pearlpool-woo') . '</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"20px"}}} -->
<p class="has-text-align-center" style="font-size:20px">' . __('Quality products for your perfect pool', 'pearlpool-woo') . '</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"white","textColor":"black"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-black-color has-white-background-color has-text-color has-background">' . __('Shop Now', 'pearlpool-woo') . '</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div></div>
<!-- /wp:cover -->

<!-- wp:heading {"textAlign":"center"} -->
<h2 class="has-text-align-center">' . __('Popular Categories', 'pearlpool-woo') . '</h2>
<!-- /wp:heading -->

<!-- wp:woocommerce/product-categories {"columns":4,"catOperator":"and"} /-->

<!-- wp:heading {"textAlign":"center"} -->
<h2 class="has-text-align-center">' . __('Featured Products', 'pearlpool-woo') . '</h2>
<!-- /wp:heading -->

<!-- wp:woocommerce/featured-product {"editMode":false} /-->

<!-- wp:heading {"textAlign":"center"} -->
<h2 class="has-text-align-center">' . __('Why Choose Us', 'pearlpool-woo') . '</h2>
<!-- /wp:heading -->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3>' . __('✓ Quality Guarantee', 'pearlpool-woo') . '</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>' . __('All our products come with manufacturer warranty', 'pearlpool-woo') . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3>' . __('✓ Fast Delivery', 'pearlpool-woo') . '</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>' . __('Quick shipping across Russia', 'pearlpool-woo') . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3>' . __('✓ Expert Support', 'pearlpool-woo') . '</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>' . __('Professional consultation from our experts', 'pearlpool-woo') . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->
';
    }

    /**
     * Get about page content
     */
    private function get_about_page_content() {
        return '
<!-- wp:heading -->
<h2>' . __('About Our Company', 'pearlpool-woo') . '</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>' . __('PearlPool is a leading supplier of premium pool equipment and accessories in Russia. We have been serving our customers for over 10 years, providing high-quality products and excellent service.', 'pearlpool-woo') . '</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>' . __('Our mission is to make swimming pools accessible and enjoyable for everyone. We offer a wide range of products including pumps, filters, chemicals, cleaning equipment, and accessories from the world\'s leading manufacturers.', 'pearlpool-woo') . '</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2>' . __('Our Advantages', 'pearlpool-woo') . '</h2>
<!-- /wp:heading -->

<!-- wp:list -->
<ul><!-- wp:list-item -->
<li>' . __('Wide product range', 'pearlpool-woo') . '</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>' . __('Competitive prices', 'pearlpool-woo') . '</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>' . __('Fast delivery', 'pearlpool-woo') . '</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>' . __('Professional consultation', 'pearlpool-woo') . '</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>' . __('Warranty service', 'pearlpool-woo') . '</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->
';
    }

    /**
     * Get delivery page content
     */
    private function get_delivery_page_content() {
        return '
<!-- wp:heading -->
<h2>' . __('Delivery Information', 'pearlpool-woo') . '</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>' . __('We deliver our products throughout Russia using various delivery methods:', 'pearlpool-woo') . '</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3>' . __('Delivery Methods', 'pearlpool-woo') . '</h3>
<!-- /wp:heading -->

<!-- wp:list -->
<ul><!-- wp:list-item -->
<li>' . __('Courier delivery in Moscow and Moscow region', 'pearlpool-woo') . '</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>' . __('Delivery by transport companies to other regions', 'pearlpool-woo') . '</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>' . __('Pickup from our warehouse', 'pearlpool-woo') . '</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:heading {"level":3} -->
<h3>' . __('Payment Methods', 'pearlpool-woo') . '</h3>
<!-- /wp:heading -->

<!-- wp:list -->
<ul><!-- wp:list-item -->
<li>' . __('Cash on delivery', 'pearlpool-woo') . '</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>' . __('Bank card payment', 'pearlpool-woo') . '</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>' . __('Bank transfer for legal entities', 'pearlpool-woo') . '</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->
';
    }

    /**
     * Get warranty page content
     */
    private function get_warranty_page_content() {
        return '
<!-- wp:heading -->
<h2>' . __('Warranty Information', 'pearlpool-woo') . '</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>' . __('All products sold in our store come with manufacturer warranty. Warranty periods vary depending on the product type and manufacturer.', 'pearlpool-woo') . '</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3>' . __('Warranty Terms', 'pearlpool-woo') . '</h3>
<!-- /wp:heading -->

<!-- wp:list -->
<ul><!-- wp:list-item -->
<li>' . __('Warranty period: from 1 to 5 years depending on product', 'pearlpool-woo') . '</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>' . __('Warranty covers manufacturing defects', 'pearlpool-woo') . '</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>' . __('Warranty does not cover damage from improper use', 'pearlpool-woo') . '</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:paragraph -->
<p>' . __('For warranty service, please contact our support team with proof of purchase.', 'pearlpool-woo') . '</p>
<!-- /wp:paragraph -->
';
    }

    /**
     * Get contacts page content
     */
    private function get_contacts_page_content() {
        return '
<!-- wp:heading -->
<h2>' . __('Contact Us', 'pearlpool-woo') . '</h2>
<!-- /wp:heading -->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3>' . __('Address', 'pearlpool-woo') . '</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>' . __('Moscow, Russia', 'pearlpool-woo') . '</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3>' . __('Phone', 'pearlpool-woo') . '</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>+7 (XXX) XXX-XX-XX</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3>' . __('Email', 'pearlpool-woo') . '</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>info@example.com</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3>' . __('Working Hours', 'pearlpool-woo') . '</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>' . __('Monday - Friday: 9:00 - 18:00', 'pearlpool-woo') . '</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>' . __('Saturday - Sunday: 10:00 - 16:00', 'pearlpool-woo') . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:shortcode -->
[contact-form-7 id="contact-form" title="' . __('Contact Form', 'pearlpool-woo') . '"]
<!-- /wp:shortcode -->
';
    }
}
