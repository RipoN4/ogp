<section class="no-results not-found">
    <header class="page-header">
        <h1 class="page-title">Nothing Found</h1>
    </header>

    <div class="page-content">
        <?php if (is_home() && current_user_can('publish_posts')) : ?>
            <p>
                <a href="<?php echo admin_url('post-new.php'); ?>">Ready to publish your first post? Get started here.</a>
            </p>
        <?php elseif (is_search()) : ?>
            <p>Sorry, but nothing matched your search terms. Please try again with different keywords.</p>
            <?php get_search_form(); ?>
        <?php else : ?>
            <p>It seems we can’t find what you’re looking for. Perhaps searching can help.</p>
            <?php get_search_form(); ?>
        <?php endif; ?>
    </div>
</section>
