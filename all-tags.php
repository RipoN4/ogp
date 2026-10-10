<?php
/* Template Name: All Tags */
get_header();

$tags = get_terms( array(
    'taxonomy'   => 'post_tag',
    'hide_empty' => true,
    'orderby'    => 'count',
    'order'      => 'DESC',
) );
?>

<main id="primary" class="site-main">
    <header class="page-header">
        <h1 class="page-title"><?php esc_html_e( 'All Tags', 'ogp' ); ?></h1>
    </header>

    <div class="taxonomy-table-container">
        <div class="taxonomy-toolbar">
            <div class="taxonomy-search-wrap">
                <input type="search" class="taxonomy-search-input" placeholder="<?php esc_attr_e( 'Quick search tags...', 'ogp' ); ?>" aria-label="<?php esc_attr_e( 'Search tags', 'ogp' ); ?>" autocomplete="off">
            </div>

            <div class="taxonomy-sort-group">
                <button type="button" class="sort-btn active" data-sort="count" data-order="desc"><?php esc_html_e( 'Most Videos', 'ogp' ); ?></button>
                <button type="button" class="sort-btn" data-sort="name" data-order="asc">A &rarr; Z</button>
                <button type="button" class="sort-btn" data-sort="name" data-order="desc">Z &rarr; A</button>
            </div>

            <div class="taxonomy-count-summary">
                <span class="visible-count"><?php echo ! empty( $tags ) && ! is_wp_error( $tags ) ? esc_html( count( $tags ) ) : 0; ?></span> <?php esc_html_e( 'Tags', 'ogp' ); ?>
            </div>
        </div>

        <div class="taxonomy-table-responsive">
            <table class="taxonomy-table" aria-label="<?php esc_attr_e( 'All Tags', 'ogp' ); ?>">
                <thead>
                    <tr>
                        <th scope="col" style="padding: 5px 10px;"><?php esc_html_e( 'Tag', 'ogp' ); ?></th>
                        <th scope="col" class="col-count"><?php esc_html_e( 'Videos', 'ogp' ); ?></th>
                    </tr>
                </thead>
                <tbody class="taxonomy-table-body">
                    <?php
                    if ( ! empty( $tags ) && ! is_wp_error( $tags ) ) :
                        $idx = 1;
                        foreach ( $tags as $tag ) :
                            $link = get_tag_link( $tag->term_id );
                            if ( is_wp_error( $link ) ) continue;
                            ?>
                            <tr data-name="<?php echo esc_attr( strtolower( $tag->name ) ); ?>" data-count="<?php echo esc_attr( $tag->count ); ?>">
                                <td class="col-name">
                                    <a href="<?php echo esc_url( $link ); ?>" title="<?php echo esc_attr( sprintf( __( 'Browse videos tagged %s', 'ogp' ), $tag->name ) ); ?>" rel="tag">
                                        #<?php echo esc_html( $tag->name ); ?>
                                    </a>
                                </td>
                                <td class="col-count">
                                    <span class="count-badge"><?php echo esc_html( number_format_i18n( $tag->count ) ); ?></span>
                                </td>
                            </tr>
                            <?php
                        endforeach;
                    else :
                        ?>
                        <tr>
                            <td colspan="3" class="col-empty"><?php esc_html_e( 'No tags found.', 'ogp' ); ?></td>
                        </tr>
                        <?php
                    endif;
                    ?>
                </tbody>
            </table>
            <div class="taxonomy-empty-message" style="display: none;">
                <p><?php esc_html_e( 'No matching tags found.', 'ogp' ); ?></p>
            </div>
        </div>
    </div>
</main>

<?php
get_footer();
