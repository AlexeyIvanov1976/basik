    </div><!-- #content -->

    <footer id="colophon" class="site-footer">
        <div class="container">
            <!-- Footer Widgets -->
            <?php if (is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3')) : ?>
                <div class="footer-widgets">
                    <?php if (is_active_sidebar('footer-1')) : ?>
                        <div class="footer-widget">
                            <?php dynamic_sidebar('footer-1'); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (is_active_sidebar('footer-2')) : ?>
                        <div class="footer-widget">
                            <?php dynamic_sidebar('footer-2'); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (is_active_sidebar('footer-3')) : ?>
                        <div class="footer-widget">
                            <?php dynamic_sidebar('footer-3'); ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- Footer Menu -->
            <?php if (has_nav_menu('footer')) : ?>
                <nav class="footer-navigation">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer',
                        'menu_id'        => 'footer-menu',
                        'menu_class'     => 'footer-menu',
                        'container'      => false,
                        'depth'          => 1,
                    ));
                    ?>
                </nav>
            <?php endif; ?>

            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <div class="copyright">
                    &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php _e('All rights reserved.', 'pearlpool-woo'); ?>
                </div>
                
                <?php if (class_exists('WooCommerce')) : ?>
                    <div class="payment-methods">
                        <img src="<?php echo PEARLPOOL_WOO_URI; ?>/images/payment-icons.png" alt="<?php esc_attr_e('Payment Methods', 'pearlpool-woo'); ?>" style="height: 30px;">
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </footer>
</div><!-- #page -->

<!-- Quick View Modal -->
<div id="quick-view-modal"></div>

<?php wp_footer(); ?>

</body>
</html>
