<?php
/* Template Name: All Series */
get_header();

$series_terms = get_terms( array(
    'taxonomy'   => 'series',
    'hide_empty' => true,
    'orderby'    => 'count',
    'order'      => 'DESC',
) );
?>

<main id="primary" class="site-main">
    <header class="page-header">
        <h1 class="page-title"><?php esc_html_e( 'All Series', 'ogp' ); ?></h1>
    </header>

    <div class="taxonomy-table-container">
        <div class="taxonomy-toolbar">
            <div class="taxonomy-search-wrap">
                <input type="search" class="taxonomy-search-input" placeholder="<?php esc_attr_e( 'Quick search series...', 'ogp' ); ?>" aria-label="<?php esc_attr_e( 'Search series', 'ogp' ); ?>" autocomplete="off">
            </div>

            <div class="taxonomy-sort-group">
                <button type="button" class="sort-btn active" data-sort="count" data-order="desc"><?php esc_html_e( 'Most Videos', 'ogp' ); ?></button>
                <button type="button" class="sort-btn" data-sort="name" data-order="asc">A &rarr; Z</button>
                <button type="button" class="sort-btn" data-sort="name" data-order="desc">Z &rarr; A</button>
            </div>

            <div class="taxonomy-count-summary">
                <span class="visible-count"><?php echo ! empty( $series_terms ) && ! is_wp_error( $series_terms ) ? esc_html( count( $series_terms ) ) : 0; ?></span> <?php esc_html_e( 'Series', 'ogp' ); ?>
            </div>
        </div>

        <div class="taxonomy-table-responsive">
            <table class="taxonomy-table" aria-label="<?php esc_attr_e( 'All Series', 'ogp' ); ?>">
                <thead>
                    <tr>
                        <th scope="col"  style="padding: 5px 10px;"><?php esc_html_e( 'Web Series', 'ogp' ); ?></th>
                        <th scope="col" class="col-count"><?php esc_html_e( 'Videos', 'ogp' ); ?></th>
                    </tr>
                </thead>
                <tbody class="taxonomy-table-body">
                    <?php
                    if ( ! empty( $series_terms ) && ! is_wp_error( $series_terms ) ) :
                        $idx = 1;
                        foreach ( $series_terms as $term ) :
                            $link = get_term_link( $term->term_id, 'series' );
                            if ( is_wp_error( $link ) ) continue;
                            ?>
                            <tr data-name="<?php echo esc_attr( strtolower( $term->name ) ); ?>" data-count="<?php echo esc_attr( $term->count ); ?>">
                                <td class="col-name">
                                    <a href="<?php echo esc_url( $link ); ?>" title="<?php echo esc_attr( sprintf( __( 'Browse %s series', 'ogp' ), $term->name ) ); ?>" rel="tag">
                                        <?php echo esc_html( $term->name ); ?>
                                    </a>
                                </td>
                                <td class="col-count">
                                    <span class="count-badge"><?php echo esc_html( number_format_i18n( $term->count ) ); ?></span>
                                </td>
                            </tr>
                            <?php
                        endforeach;
                    else :
                        ?>
                        <tr>
                            <td colspan="3" class="col-empty"><?php esc_html_e( 'No series found.', 'ogp' ); ?></td>
                        </tr>
                        <?php
                    endif;
                    ?>
                </tbody>
            </table>
            <div class="taxonomy-empty-message" style="display: none;">
                <p><?php esc_html_e( 'No matching series found.', 'ogp' ); ?></p>
            </div>
        </div>
    </div>
</main>

<?php
get_footer();
