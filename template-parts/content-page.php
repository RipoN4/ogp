<article id="post-<?php echo get_the_ID(); ?>" class="<?php echo join(' ', get_post_class()); ?>">
    <header class="entry-header">
        <h1 class="entry-title"><?php the_title(); ?></h1>
    </header>
    <?php if ( has_post_thumbnail() ) : ?>
        <div class="post-thumbnail">
            <?php the_post_thumbnail(); ?>
        </div>
    <?php endif; ?>
    <div class="entry-content">
        <?php the_content(); ?>

        <?php wp_link_pages(array(
            'before' => '<div class="page-links">Pages:',
            'after' => '</div>'
        )); ?>
    </div>

    <?php if (get_edit_post_link()) : ?>
        <footer class="entry-footer">
            <span class="edit-link">
                <a href="<?php echo get_edit_post_link(); ?>">Edit <?php the_title(); ?></a>
            </span>
        </footer>
    <?php endif; ?>
</article>
