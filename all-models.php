<?php
/* Template Name: All Models */
get_header();

$models = get_terms( array(
    'taxonomy'   => 'model',
    'hide_empty' => true,
    'orderby'    => 'count',
    'order'      => 'DESC',
) );
?>

<main id="primary" class="site-main">
    <header class="page-header">
        <h1 class="page-title"><?php the_title(); ?></h1>
    </header>

    <div class="taxonomy-table-container">
        <div class="taxonomy-toolbar">
            <div class="taxonomy-search-wrap">
                <input type="search" class="taxonomy-search-input" placeholder="<?php esc_attr_e( 'Quick search models...', 'ogp' ); ?>" aria-label="<?php esc_attr_e( 'Search models', 'ogp' ); ?>" autocomplete="off">
            </div>

            <div class="taxonomy-sort-group">
                <button type="button" class="sort-btn active" data-sort="count" data-order="desc"><?php esc_html_e( 'Most Videos', 'ogp' ); ?></button>
                <button type="button" class="sort-btn" data-sort="name" data-order="asc">A &rarr; Z</button>
                <button type="button" class="sort-btn" data-sort="name" data-order="desc">Z &rarr; A</button>
            </div>

            <div class="taxonomy-count-summary">
                <span class="visible-count"><?php echo ! empty( $models ) && ! is_wp_error( $models ) ? esc_html( count( $models ) ) : 0; ?></span> <?php esc_html_e( 'Models', 'ogp' ); ?>
            </div>
        </div>

        <div class="taxonomy-table-responsive">
            <table class="taxonomy-table" aria-label="<?php esc_attr_e( 'All Models', 'ogp' ); ?>">
                <thead>
                    <tr>
                        <th scope="col" style="padding: 5px 10px;"><?php esc_html_e( 'Models', 'ogp' ); ?></th>
                        <th scope="col" class="col-count"><?php esc_html_e( 'Videos', 'ogp' ); ?></th>
                    </tr>
                </thead>
                <tbody class="taxonomy-table-body">
                    <?php
                    if ( ! empty( $models ) && ! is_wp_error( $models ) ) :
                        $idx = 1;
                        foreach ( $models as $model ) :
                            $link = get_term_link( $model->term_id, 'model' );
                            if ( is_wp_error( $link ) ) continue;
                            ?>
                            <tr data-name="<?php echo esc_attr( strtolower( $model->name ) ); ?>" data-count="<?php echo esc_attr( $model->count ); ?>">
                                <td class="col-name">
                                    <a href="<?php echo esc_url( $link ); ?>" title="<?php echo esc_attr( sprintf( __( 'Browse videos featuring %s', 'ogp' ), $model->name ) ); ?>" rel="tag">
                                        <?php echo esc_html( $model->name ); ?>
                                    </a>
                                </td>
                                <td class="col-count">
                                    <span class="count-badge"><?php echo esc_html( number_format_i18n( $model->count ) ); ?></span>
                                </td>
                            </tr>
                            <?php
                        endforeach;
                    else :
                        ?>
                        <tr>
                            <td colspan="3" class="col-empty"><?php esc_html_e( 'No models found.', 'ogp' ); ?></td>
                        </tr>
                        <?php
                    endif;
                    ?>
                </tbody>
            </table>
            <div class="taxonomy-empty-message" style="display: none;">
                <p><?php esc_html_e( 'No matching models found.', 'ogp' ); ?></p>
            </div>
        </div>
    </div>
</main>

<?php
get_footer();
