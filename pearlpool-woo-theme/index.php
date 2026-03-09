<?php
/**
 * The main template file
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container">
        <?php pearlpool_woo_breadcrumb(); ?>
        
        <div class="site-main">
            <div class="content-area">
                <?php
                if (have_posts()) :
                    if (is_home() && !is_front_page()) :
                        ?>
                        <header>
                            <h1 class="page-title"><?php single_post_title(); ?></h1>
                        </header>
                        <?php
                    endif;

                    while (have_posts()) :
                        the_post();
                        ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <header class="entry-header">
                                <?php
                                if (is_singular()) :
                                    the_title('<h1 class="entry-title">', '</h1>');
                                else :
                                    the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
                                endif;
                                ?>
                            </header>

                            <?php if (has_post_thumbnail()) : ?>
                                <div class="post-thumbnail">
                                    <?php the_post_thumbnail('large'); ?>
                                </div>
                            <?php endif; ?>

                            <div class="entry-content">
                                <?php
                                if (is_singular()) :
                                    the_content();
                                else :
                                    the_excerpt();
                                endif;
                                ?>
                            </div>

                            <footer class="entry-footer">
                                <?php
                                $categories_list = get_the_category_list(', ');
                                if ($categories_list) {
                                    echo '<span class="cat-links">' . $categories_list . '</span>';
                                }

                                $tags_list = get_the_tag_list('', ', ');
                                if ($tags_list) {
                                    echo '<span class="tags-links">' . $tags_list . '</span>';
                                }
                                ?>
                            </footer>
                        </article>
                        <?php
                    endwhile;

                    the_posts_navigation();

                else :
                    ?>
                    <section class="no-results not-found">
                        <header class="page-header">
                            <h1 class="page-title"><?php _e('Nothing Found', 'pearlpool-woo'); ?></h1>
                        </header>
                        <div class="page-content">
                            <?php if (is_home() && current_user_can('publish_posts')) : ?>
                                <p><?php printf(wp_kses(__('Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'pearlpool-woo'), array('a' => array('href' => array()))), esc_url(admin_url('post-new.php'))); ?></p>
                            <?php elseif (is_search()) : ?>
                                <p><?php _e('Sorry, but nothing matched your search terms. Please try again with different keywords.', 'pearlpool-woo'); ?></p>
                                <?php get_search_form(); ?>
                            <?php else : ?>
                                <p><?php _e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'pearlpool-woo'); ?></p>
                                <?php get_search_form(); ?>
                            <?php endif; ?>
                        </div>
                    </section>
                    <?php
                endif;
                ?>
            </div>

            <?php get_sidebar(); ?>
        </div>
    </div>
</main>

<?php
get_footer();
