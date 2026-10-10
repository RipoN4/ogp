<?php
/* Template Name: All OTT */
get_header();

$categories = get_terms( array(
    'taxonomy'   => 'category',
    'hide_empty' => true,
    'orderby'    => 'count',
    'order'      => 'DESC',
) );
?>

<main id="primary" class="site-main">
    <header class="page-header">
        <h1 class="page-title"><?php esc_html_e( 'All OTT', 'ogp' ); ?></h1>
    </header>

    <div class="taxonomy-table-container">
        <div class="taxonomy-toolbar">
            <div class="taxonomy-search-wrap">
                <input type="search" class="taxonomy-search-input" placeholder="<?php esc_attr_e( 'Quick search OTT...', 'ogp' ); ?>" aria-label="<?php esc_attr_e( 'Search categories', 'ogp' ); ?>" autocomplete="off">
            </div>

            <div class="taxonomy-sort-group">
                <button type="button" class="sort-btn active" data-sort="count" data-order="desc"><?php esc_html_e( 'Most Videos', 'ogp' ); ?></button>
                <button type="button" class="sort-btn" data-sort="name" data-order="asc">A &rarr; Z</button>
                <button type="button" class="sort-btn" data-sort="name" data-order="desc">Z &rarr; A</button>
            </div>

            <div class="taxonomy-count-summary">
                <span class="visible-count"><?php echo ! empty( $categories ) && ! is_wp_error( $categories ) ? esc_html( count( $categories ) ) : 0; ?></span> <?php esc_html_e( 'OTT', 'ogp' ); ?>
            </div>
        </div>

        <div class="taxonomy-table-responsive">
            <table class="taxonomy-table" aria-label="<?php esc_attr_e( 'All OTT', 'ogp' ); ?>">
                <thead>
                    <tr>
                        <th scope="col" style="padding: 5px 10px;"><?php esc_html_e( 'Category', 'ogp' ); ?></th>
                        <th scope="col" class="col-count"><?php esc_html_e( 'Videos', 'ogp' ); ?></th>
                    </tr>
                </thead>
                <tbody class="taxonomy-table-body">
                    <?php
                    if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) :
                        $idx = 1;
                        foreach ( $categories as $cat ) :
                            $link = get_category_link( $cat->term_id );
                            if ( is_wp_error( $link ) ) continue;
                            ?>
                            <tr data-name="<?php echo esc_attr( strtolower( $cat->name ) ); ?>" data-count="<?php echo esc_attr( $cat->count ); ?>">
                                <td class="col-name">
                                    <a href="<?php echo esc_url( $link ); ?>" title="<?php echo esc_attr( sprintf( __( 'Browse videos in %s', 'ogp' ), $cat->name ) ); ?>" rel="category tag">
                                        <?php echo esc_html( $cat->name ); ?>
                                    </a>
                                </td>
                                <td class="col-count">
                                    <span class="count-badge"><?php echo esc_html( number_format_i18n( $cat->count ) ); ?></span>
                                </td>
                            </tr>
                            <?php
                        endforeach;
                    else :
                        ?>
                        <tr>
                            <td colspan="3" class="col-empty"><?php esc_html_e( 'No OTT found.', 'ogp' ); ?></td>
                        </tr>
                        <?php
                    endif;
                    ?>
                </tbody>
            </table>
            <div class="taxonomy-empty-message" style="display: none;">
                <p><?php esc_html_e( 'No matching OTT found.', 'ogp' ); ?></p>
            </div>
        </div>
    </div>
</main>

<?php
get_footer();
