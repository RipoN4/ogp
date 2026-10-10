<?php
global $post, $wp_query;
$video_url = get_post_meta( get_the_ID(), 'video_url', true );
$video_duration = get_post_meta( get_the_ID(), 'duration', true );
$post_index = isset( $wp_query->current_post ) ? $wp_query->current_post : 0;
$is_lcp = ( $post_index < 2 );
?>
<a class="video" title="<?php echo esc_attr( get_the_title() ); ?>" href="<?php echo esc_url( get_permalink() ); ?>">
    <?php
    if ( has_post_thumbnail() ) {
        the_post_thumbnail(
            'medium_large',
            array(
                'class'         => 'vthumb',
                'loading'       => $is_lcp ? 'eager' : 'lazy',
                'fetchpriority' => $is_lcp ? 'high' : 'auto',
                'decoding'      => 'async',
                'alt'           => esc_attr( get_the_title() ),
            )
        );
    }
    ?>
    <span class="time licon">
        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6L12 12L17 12M12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2Z" />
        </svg>
        <?php echo $video_duration ? esc_html( $video_duration ) . ':00' : 'Unknown'; ?>
    </span>
    <span class="ago licon">
        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 5H18C19.6569 5 21 6.34315 21 8V18C21 19.6569 19.6569 21 18 21H6C4.34315 21 3 19.6569 3 18V8C3 6.34315 4.34315 5 6 5ZM7 11H17M8 3V7M16 3V7"/>
        </svg>
        <?php echo esc_html( meks_time_ago() ); ?>
    </span>
    <h2 class="vtitle"><?php echo esc_html( get_the_title() ); ?></h2>
</a>
