<?php
get_header();

while ( have_posts() ) :
    the_post();
    $video_url = get_post_meta( get_the_ID(), 'video_url', true );
    $video_duration = get_post_meta( get_the_ID(), 'duration', true );
    ?>

    <div class="content" id="post-<?php the_ID(); ?>">
        <h1 class="stitle"><?php the_title(); ?></h1>
        <?php if ( $video_url ) : ?>
            <div class="video-container">
                <video id="my-video" width="100%" poster="<?php echo esc_url( get_the_post_thumbnail_url() ); ?>" controls controlsList="nodownload" fetchpriority="high">
                    <source src="<?php echo esc_url( $video_url ); ?>" type="video/mp4">
                    <source src="<?php echo esc_url( $video_url ); ?>" type="video/ogg">
                    Your browser does not support HTML video.
                </video>
            </div>
        <?php endif; ?>
        <main id="primary" class="site-main">
            <?php display_breadcrumb(); ?>
            <div class="description"><?php the_content(); ?></div>
            <div class="taxonomy-meta">
                <?php
                // Display the "Series" taxonomy terms
                $series_terms = get_the_terms( get_the_ID(), 'series' );
                if ( $series_terms && ! is_wp_error( $series_terms ) ) {
                    echo '<div class="series-list"><strong>Series:</strong> ';
                    foreach ( $series_terms as $term ) {
                        echo '<a href="' . esc_url( get_term_link( $term->term_id ) ) . '">' . esc_html( $term->name ) . '</a> ';
                    }
                    echo '</div>';
                }

                // Display the "Model" taxonomy terms
                $model_terms = get_the_terms( get_the_ID(), 'model' );
                if ( $model_terms && ! is_wp_error( $model_terms ) ) {
                    echo '<div class="model-list"><strong>Model:</strong> ';
                    $i = 0;
                    $total_models = count( $model_terms );
                    foreach ( $model_terms as $term ) {
                        echo '<a href="' . esc_url( get_term_link( $term->term_id ) ) . '">' . esc_html( $term->name ) . '</a>';
                        if ( $i < $total_models - 1 ) {
                            echo ', ';
                        }
                        $i++;
                    }
                    echo '</div>';
                }
                ?>
            </div>

            <div class="taxonomy">
                <?php
                $categories = get_the_category();
                if ( ! empty( $categories ) ) {
                    foreach ( $categories as $category ) {
                        echo '<a class="cat" href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a> ';
                    }
                }

                $tags = get_the_tags();
                if ( $tags ) {
                    foreach ( $tags as $tag ) {
                        echo '<a class="tag" href="' . esc_url( get_tag_link( $tag->term_id ) ) . '">' . esc_html( $tag->name ) . '</a> ';
                    }
                }
                ?>
            </div>

            <?php get_template_part( 'template-parts/related', get_post_type() ); ?>

            <?php
            $first_category = get_the_category();
            if ( ! empty( $first_category ) ) :
                ?>
                <a class="btnx" href="<?php echo esc_url( get_category_link( $first_category[0]->term_id ) ); ?>">More Videos</a>
            <?php endif; ?>
        </main>
    </div>

    <?php
endwhile;

get_footer();
