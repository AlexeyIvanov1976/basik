<?php
/**
 * Search Results Template
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container">
        <?php pearlpool_woo_breadcrumb(); ?>
        
        <header class="page-header">
            <h1 class="page-title">
                <?php printf(__('Search Results for: %s', 'pearlpool-woo'), '<span>' . get_search_query() . '</span>'); ?>
            </h1>
        </header>

        <?php if (have_posts()) : ?>
            <div class="search-results-count">
                <?php printf(_n('%d result found', '%d results found', $wp_query->found_posts, 'pearlpool-woo'), $wp_query->found_posts); ?>
            </div>

            <div class="products">
                <?php
                while (have_posts()) :
                    the_post();

                    if (function_exists('wc_get_template_part') && get_post_type() === 'product') {
                        wc_get_template_part('content', 'product');
                    } else {
                        get_template_part('template-parts/content', 'search');
                    }
                endwhile;
                ?>
            </div>

            <?php the_posts_pagination(); ?>

        <?php else : ?>
            <section class="no-results not-found">
                <header class="page-header">
                    <h1 class="page-title"><?php _e('Nothing Found', 'pearlpool-woo'); ?></h1>
                </header>
                <div class="page-content">
                    <p><?php _e('Sorry, but nothing matched your search terms. Please try again with different keywords.', 'pearlpool-woo'); ?></p>
                    <?php get_search_form(); ?>
                    
                    <div class="search-suggestions">
                        <h3><?php _e('Search Tips:', 'pearlpool-woo'); ?></h3>
                        <ul>
                            <li><?php _e('Make sure all words are spelled correctly.', 'pearlpool-woo'); ?></li>
                            <li><?php _e('Try different keywords.', 'pearlpool-woo'); ?></li>
                            <li><?php _e('Try more general keywords.', 'pearlpool-woo'); ?></li>
                            <li><?php _e('Try fewer keywords.', 'pearlpool-woo'); ?></li>
                        </ul>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    </div>
</main>

<style>
.page-header {
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #e0e0e0;
}

.search-results-count {
    margin-bottom: 2rem;
    color: #666;
    font-size: 0.95rem;
}

.search-suggestions {
    margin-top: 2rem;
    padding: 1.5rem;
    background: #f5f5f5;
    border-radius: 8px;
}

.search-suggestions h3 {
    margin-bottom: 1rem;
    color: #0066cc;
}

.search-suggestions ul {
    list-style: disc;
    padding-left: 20px;
}

.search-suggestions li {
    margin-bottom: 0.5rem;
}
</style>

<?php
get_footer();
