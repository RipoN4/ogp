<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package OGP
 */

?>
<footer id="colophon" class="site-footer">
    <?php if ( is_active_sidebar( 'footer-content' ) ) : ?>
        <div class="footer-content">
            <?php dynamic_sidebar( 'footer-content' ); ?>
        </div>
    <?php endif; ?>
    <div class="footer-bar">
        <div class="site-copyright">
            &copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a> 
        </div>
        <nav class="footer-navigation" aria-label="<?php esc_attr_e( 'Footer Menu', 'ogp' ); ?>">
            <?php
            if ( has_nav_menu( 'footer' ) ) :
                wp_nav_menu(
                    array(
                        'theme_location' => 'footer',
                        'menu_id'        => 'footer-menu',
                        'menu_class'     => 'footer-menu',
                        'container'      => false,
                        'depth'          => 1,
                    )
                );
            else :
                ?>
                <ul id="footer-menu" class="footer-menu">
                    <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'ogp' ); ?></a></li>
                    <li><a href="<?php echo esc_url( home_url( '/privacy-policy' ) ); ?>"><?php esc_html_e( 'Privacy Policy', 'ogp' ); ?></a></li>
                </ul>
                <?php
            endif;
            ?>
        </nav>
    </div>
</footer>
</div>

<?php wp_footer(); ?>

</body>
</html>

