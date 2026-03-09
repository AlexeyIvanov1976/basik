<?php
/**
 * The sidebar template file
 */

if (!is_active_sidebar('sidebar-main') && !is_active_sidebar('sidebar-shop')) {
    return;
}
?>

<aside id="secondary" class="widget-area">
    <?php if (is_shop() || is_product_category()) : ?>
        <?php if (is_active_sidebar('sidebar-shop')) : ?>
            <?php dynamic_sidebar('sidebar-shop'); ?>
        <?php endif; ?>
    <?php else : ?>
        <?php if (is_active_sidebar('sidebar-main')) : ?>
            <?php dynamic_sidebar('sidebar-main'); ?>
        <?php endif; ?>
    <?php endif; ?>
</aside>
