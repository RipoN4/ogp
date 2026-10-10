<?php get_header(); ?>

<main id="primary" class="site-main">

    <?php if (have_posts()) : ?>

        <header class="page-header">
            <h1 class="page-title">
                <?php echo 'Search Results for: <span>' . esc_html( get_search_query() ) . '</span>'; ?>
            </h1>
        </header>
        <div class="videos">
        <?php while (have_posts()) : the_post(); ?>
            <?php get_template_part('template-parts/videos', 'search'); ?>
        <?php endwhile; ?>
        </div>
        <?php the_posts_navigation(); ?>

    <?php else : ?>
        <?php get_template_part('template-parts/content', 'none'); ?>
    <?php endif; ?>

</main>

<?php
get_footer();
