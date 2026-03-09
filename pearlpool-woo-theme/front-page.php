<?php
/**
 * Template Name: Front Page
 * The front page template file
 */

get_header();
?>

<main id="primary" class="site-main">
    <?php
    while (have_posts()) :
        the_post();
        ?>
        
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="container">
                <h1 class="hero-title"><?php the_title(); ?></h1>
                <p class="hero-subtitle"><?php _e('Quality products for your perfect pool', 'pearlpool-woo'); ?></p>
                <div class="hero-buttons">
                    <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_shop_page_id'))); ?>" class="button">
                        <?php _e('Shop Now', 'pearlpool-woo'); ?>
                    </a>
                    <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>" class="button secondary">
                        <?php _e('My Account', 'pearlpool-woo'); ?>
                    </a>
                </div>
            </div>
        </section>

        <!-- Featured Products -->
        <section class="featured-products-section">
            <div class="container">
                <h2 class="text-center"><?php _e('Featured Products', 'pearlpool-woo'); ?></h2>
                <?php echo do_shortcode('[products limit="8" columns="4" visibility="featured"]'); ?>
            </div>
        </section>

        <!-- Product Categories -->
        <section class="categories-section">
            <div class="container">
                <h2 class="text-center"><?php _e('Shop by Category', 'pearlpool-woo'); ?></h2>
                <?php echo do_shortcode('[product_categories limit="8" columns="4"]'); ?>
            </div>
        </section>

        <!-- On Sale Products -->
        <section class="sale-products-section">
            <div class="container">
                <h2 class="text-center"><?php _e('Special Offers', 'pearlpool-woo'); ?></h2>
                <?php echo do_shortcode('[products limit="4" columns="4" on_sale="true"]'); ?>
            </div>
        </section>

        <!-- Content Area -->
        <section class="content-section">
            <div class="container">
                <?php the_content(); ?>
            </div>
        </section>

        <!-- Testimonials / Features -->
        <section class="features-section">
            <div class="container">
                <div class="features-grid">
                    <div class="feature-item">
                        <div class="feature-icon">🚚</div>
                        <h3><?php _e('Fast Delivery', 'pearlpool-woo'); ?></h3>
                        <p><?php _e('Quick shipping across Russia', 'pearlpool-woo'); ?></p>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">✓</div>
                        <h3><?php _e('Quality Guarantee', 'pearlpool-woo'); ?></h3>
                        <p><?php _e('All products with warranty', 'pearlpool-woo'); ?></p>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">💬</div>
                        <h3><?php _e('Expert Support', 'pearlpool-woo'); ?></h3>
                        <p><?php _e('Professional consultation', 'pearlpool-woo'); ?></p>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">🔒</div>
                        <h3><?php _e('Secure Payment', 'pearlpool-woo'); ?></h3>
                        <p><?php _e('Multiple payment options', 'pearlpool-woo'); ?></p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Newsletter -->
        <section class="newsletter-section">
            <div class="container">
                <div class="newsletter-content">
                    <h2><?php _e('Subscribe to Our Newsletter', 'pearlpool-woo'); ?></h2>
                    <p><?php _e('Get updates on new products and special offers', 'pearlpool-woo'); ?></p>
                    <form class="newsletter-form">
                        <input type="email" placeholder="<?php esc_attr_e('Your email address', 'pearlpool-woo'); ?>" required>
                        <button type="submit" class="button"><?php _e('Subscribe', 'pearlpool-woo'); ?></button>
                    </form>
                </div>
            </div>
        </section>

        <?php
    endwhile;
    ?>
</main>

<style>
.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    padding: 3rem 0;
}

.feature-item {
    text-align: center;
    padding: 2rem;
    background: #f5f5f5;
    border-radius: 8px;
    transition: transform 0.3s ease;
}

.feature-item:hover {
    transform: translateY(-5px);
}

.feature-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
}

.feature-item h3 {
    margin-bottom: 0.5rem;
    color: #0066cc;
}

.newsletter-section {
    background: linear-gradient(135deg, #0066cc 0%, #004c99 100%);
    color: white;
    padding: 4rem 0;
    margin-top: 3rem;
}

.newsletter-content {
    text-align: center;
    max-width: 600px;
    margin: 0 auto;
}

.newsletter-content h2 {
    color: white;
    margin-bottom: 1rem;
}

.newsletter-form {
    display: flex;
    gap: 1rem;
    justify-content: center;
    margin-top: 2rem;
    flex-wrap: wrap;
}

.newsletter-form input[type="email"] {
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    min-width: 300px;
    font-size: 1rem;
}

.newsletter-form button {
    background: white;
    color: #0066cc;
    border: none;
}

.newsletter-form button:hover {
    background: #f5f5f5;
}

section {
    padding: 4rem 0;
}

section h2 {
    margin-bottom: 3rem;
    font-size: 2rem;
}
</style>

<?php
get_footer();
