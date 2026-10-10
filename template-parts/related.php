<!-- Related Posts Section (YARPP integration with fallback) -->
<div class="related-posts">
    <h2 class="h"><?php esc_html_e( 'Related Videos', 'ogp' ); ?></h2>
    <div class="videos">
        <?php
        $rendered_any = false;

        // 1. Try YARPP plugin if installed and active
        if ( function_exists( 'yarpp_get_related' ) ) {
            // Uses YARPP plugin settings
            $yarpp_posts = yarpp_get_related( array(), get_the_ID() );

            if ( ! empty( $yarpp_posts ) ) {
                global $post;
                foreach ( $yarpp_posts as $post ) {
                    setup_postdata( $post );
                    get_template_part( 'template-parts/videos', get_post_type() );
                }
                wp_reset_postdata();
                $rendered_any = true;
            }
        }

        // 2. Fallback to category-based query if YARPP is inactive or found no posts
        if ( ! $rendered_any ) {
            $categories = wp_get_post_categories( get_the_ID() );

            if ( ! empty( $categories ) ) {
                $related_args = array(
                    'category__in'        => $categories,
                    'post__not_in'        => array( get_the_ID() ),
                    'posts_per_page'      => 9,
                    'orderby'             => 'rand',
                    'ignore_sticky_posts' => 1,
                );

                $related_query = new WP_Query( $related_args );

                if ( $related_query->have_posts() ) {
                    while ( $related_query->have_posts() ) {
                        $related_query->the_post();
                        get_template_part( 'template-parts/videos', get_post_type() );
                    }
                    wp_reset_postdata();
                    $rendered_any = true;
                }
            }
        }

        if ( ! $rendered_any ) {
            echo '<p>' . esc_html__( 'No related posts found.', 'ogp' ) . '</p>';
        }
        ?>
    </div>
</div>