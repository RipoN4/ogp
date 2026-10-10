<?php get_header(); ?>

<main id="primary" class="site-main">

    <?php if (have_posts()) : ?>

        <header class="page-header">
            <h1 class="page-title">
                <?php
                if ( is_category() ) {
                    single_cat_title();
                    echo ' Web Series';
                } elseif ( is_tag() ) {
                    single_tag_title();
                } elseif ( is_tax() ) {
                    single_term_title();
                } else {
                    the_archive_title();
                }
                ?>
            </h1>
            <div class="archive-description"><?php the_archive_description(); ?></div>
        </header>
	<div class="videos">
        <?php while (have_posts()) : the_post(); ?>
            <?php get_template_part('template-parts/videos', get_post_type()); ?>
        <?php endwhile; ?>
    </div>
        <?php the_posts_navigation(); ?>

    <?php else : ?>
        <?php get_template_part('template-parts/content', 'none'); ?>
    <?php endif; ?>

</main>

<?php get_footer(); ?>
