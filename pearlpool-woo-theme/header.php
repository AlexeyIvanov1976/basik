<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site-container">
    <a class="skip-link screen-reader-text" href="#primary"><?php _e('Skip to content', 'pearlpool-woo'); ?></a>

    <header id="masthead" class="site-header">
        <div class="container">
            <div class="header-main">
                <!-- Logo -->
                <div class="site-logo">
                    <?php pearlpool_woo_get_logo(); ?>
                </div>

                <!-- Mobile Menu Toggle -->
                <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                    <span>☰</span>
                </button>

                <!-- Primary Navigation -->
                <nav id="site-navigation" class="primary-navigation">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'menu_class'     => 'primary-menu',
                        'container'      => false,
                    ));
                    ?>
                </nav>

                <!-- Header Widgets -->
                <div class="header-widgets">
                    <!-- Search -->
                    <div class="header-search">
                        <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                            <label>
                                <span class="screen-reader-text"><?php _e('Search for:', 'pearlpool-woo'); ?></span>
                                <input type="search" class="search-field" placeholder="<?php esc_attr_e('Search products…', 'pearlpool-woo'); ?>" value="" name="s" />
                            </label>
                            <button type="submit" class="search-submit">
                                <span>🔍</span>
                            </button>
                        </form>
                    </div>

                    <!-- Cart -->
                    <?php if (class_exists('WooCommerce')) : ?>
                        <div class="header-cart">
                            <a class="cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e('View your shopping cart', 'pearlpool-woo'); ?>">
                                <span class="cart-icon">🛒</span>
                                <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                                <span class="cart-total"><?php echo WC()->cart->get_cart_subtotal(); ?></span>
                            </a>
                        </div>
                    <?php endif; ?>

                    <!-- My Account -->
                    <?php if (class_exists('WooCommerce')) : ?>
                        <div class="header-account">
                            <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>" title="<?php esc_attr_e('My Account', 'pearlpool-woo'); ?>">
                                <span class="account-icon">👤</span>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>

    <div id="content" class="site-content">
