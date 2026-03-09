<?php
/**
 * 404 Page Template
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container">
        <section class="error-404 not-found">
            <header class="page-header">
                <h1 class="page-title"><?php _e('404 - Page Not Found', 'pearlpool-woo'); ?></h1>
            </header>

            <div class="page-content">
                <p><?php _e('Oops! The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'pearlpool-woo'); ?></p>

                <?php get_search_form(); ?>

                <div class="error-suggestions">
                    <h2><?php _e('What can I do?', 'pearlpool-woo'); ?></h2>
                    <ul>
                        <li><?php _e('If you typed the URL directly, check your spelling and capitalization.', 'pearlpool-woo'); ?></li>
                        <li><?php _e('Visit our homepage for helpful tools and resources.', 'pearlpool-woo'); ?></li>
                        <li><?php _e('Contact us and we will point you in the right direction.', 'pearlpool-woo'); ?></li>
                    </ul>

                    <div class="error-buttons">
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="button">
                            <?php _e('Return to Homepage', 'pearlpool-woo'); ?>
                        </a>
                        <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_shop_page_id'))); ?>" class="button secondary">
                            <?php _e('Browse Shop', 'pearlpool-woo'); ?>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

<style>
.error-404 {
    text-align: center;
    padding: 4rem 0;
}

.error-404 .page-title {
    font-size: 3rem;
    color: #dc3232;
    margin-bottom: 2rem;
}

.error-suggestions {
    margin-top: 3rem;
    padding: 2rem;
    background: #f5f5f5;
    border-radius: 8px;
}

.error-suggestions h2 {
    margin-bottom: 1.5rem;
}

.error-suggestions ul {
    text-align: left;
    max-width: 500px;
    margin: 0 auto 2rem;
    list-style: disc;
    padding-left: 20px;
}

.error-suggestions li {
    margin-bottom: 0.5rem;
}

.error-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}
</style>

<?php
get_footer();
