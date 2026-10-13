<?php
/**
 * OGP functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package OGP
 */

if ( ! defined( 'OGP_VERSION' ) ) {
	define( 'OGP_VERSION', '5.0.0' );
}

if ( ! defined( '_S_VERSION' ) ) {
	define( '_S_VERSION', OGP_VERSION );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function ogp_setup() {
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// Register navigation menus.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'ogp' ),
			'footer' => esc_html__( 'Footer Menu', 'ogp' ),
		)
	);

	/*
		* Switch default core markup for search form, gallery, caption, style, script
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'ogp_custom_background_args',
			array(
				'default-color' => '0e1116',
				'default-image' => '',
			)
		)
	);

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'ogp_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ogp_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'ogp_content_width', 1100 );
}
add_action( 'after_setup_theme', 'ogp_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */
function ogp_scripts() {
	$css_version = file_exists( get_stylesheet_directory() . '/style.css' ) ? filemtime( get_stylesheet_directory() . '/style.css' ) : _S_VERSION;
	$js_version  = file_exists( get_template_directory() . '/main.js' ) ? filemtime( get_template_directory() . '/main.js' ) : _S_VERSION;

	wp_enqueue_style( 'ogp-style', get_stylesheet_uri(), array(), $css_version );
	wp_style_add_data( 'ogp-style', 'rtl', 'replace' );

	wp_enqueue_script( 'ogp-main', get_template_directory_uri() . '/main.js', array(), $js_version, true );
}
add_action( 'wp_enqueue_scripts', 'ogp_scripts' );

/**
 * Adds custom classes to the array of body classes.
 */
function ogp_body_classes( $classes ) {
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
	$classes[] = 'no-sidebar';
	return $classes;
}
add_filter( 'body_class', 'ogp_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function ogp_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'ogp_pingback_header' );

/**
 * Disable automatic display from Yet Another Related Posts Plugin (YARPP)
 * because the theme outputs its own custom related posts in template-parts/related.php.
 */
add_filter( 'yarpp_auto_display', '__return_false' );





// Add the Video Details meta box
function ogp_add_video_details_meta_box() {
    add_meta_box(
        'ogp_video_details_meta_box', // ID
        'Video Details',              // Title
        'ogp_video_details_meta_box_callback', // Callback function
        'post',                       // Post type
        'normal',                     // Context
        'default'                     // Priority
    );
}
add_action('add_meta_boxes', 'ogp_add_video_details_meta_box');

// Callback function to display fields in the Video Details meta box
function ogp_video_details_meta_box_callback($post) {
    // Add nonce field for security verification
    wp_nonce_field( 'ogp_save_video_details', 'ogp_video_details_nonce' );

    // Get existing values for the fields
    $video_url = get_post_meta($post->ID, 'video_url', true);
    $duration = get_post_meta($post->ID, 'duration', true);

    // Display the fields
    echo '<input type="text" id="ogp_video_url" placeholder="Video URL" name="ogp_video_url" value="' . esc_attr($video_url) . '" size="25" />';
    echo '<input type="text" id="ogp_video_duration" placeholder="Duration (in minutes)" name="ogp_video_duration" value="' . esc_attr($duration) . '" size="25" />';
}

// Save the meta box data
function ogp_save_video_details_meta_box_data($post_id) {
    // 1. Verify nonce
    if ( ! isset( $_POST['ogp_video_details_nonce'] ) || ! wp_verify_nonce( $_POST['ogp_video_details_nonce'], 'ogp_save_video_details' ) ) {
        return;
    }

    // 2. Prevent autosave from overwriting data
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // 3. Verify user permissions
    if ( isset( $_POST['post_type'] ) && 'page' === $_POST['post_type'] ) {
        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }
    } else {
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }

    // 4. Save fields without modification (preserve exact URLs with spaces, %20, etc.)
    if ( isset( $_POST['ogp_video_url'] ) ) {
        $video_url = trim( wp_unslash( $_POST['ogp_video_url'] ) );
        update_post_meta( $post_id, 'video_url', $video_url );
    }

    if ( isset( $_POST['ogp_video_duration'] ) ) {
        $duration = trim( wp_unslash( $_POST['ogp_video_duration'] ) );
        update_post_meta( $post_id, 'duration', $duration );
    }
}
add_action('save_post', 'ogp_save_video_details_meta_box_data');



/* Function which displays your post date in time ago format */
function meks_time_ago() {
    $time_diff = human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) );

    // Replace the words with your custom abbreviations
    $time_diff = str_replace(
        array('mins', 'min', 'hours', 'hour', 'days', 'day', 'weeks', 'week', 'months', 'month', 'years', 'year'),
        array('Min', 'Mn', 'Hr', 'Hr', 'Dy', 'Dy', 'Wk', 'Wk', 'Mo', 'Mo', 'YR', 'YR'),
        $time_diff
    );

    return $time_diff . ' ' . __( 'Ago' );
}



// Breadcrumb 

function display_breadcrumb() {
    // Step 1: Display the website title as the first level
    echo '<div class="breadcrumb">';
    echo '<a href="' . esc_url(home_url('/')) . '">' . get_bloginfo('name') . '</a> » ';

    // Step 2: Get the primary category
    $categories = get_the_category();
    if (!empty($categories)) {
        // Assume the first category is the primary category
        $primary_category = $categories[0];
        echo '<a href="' . esc_url(get_category_link($primary_category->term_id)) . '">' . esc_html($primary_category->name) . '</a> » ';
    }

    // Step 3: Display the post title
    echo '<span>' . get_the_title() . '</span>';

    echo '</div>';
}



// Custom Taxonomies


// Register the "Model" and "Series" taxonomies
function register_custom_taxonomies() {
    // Register "Model" taxonomy (non-hierarchical, like tags)
    register_taxonomy('model', 'post', array(
        'labels' => array(
            'name' => 'Models',
            'singular_name' => 'Model',
            'search_items' => 'Search Models',
            'all_items' => 'All Models',
            'edit_item' => 'Edit Model',
            'update_item' => 'Update Model',
            'add_new_item' => 'Add New Model',
            'new_item_name' => 'New Model Name',
            'menu_name' => 'Models',
        ),
        'public' => true,
        'hierarchical' => false, // Non-hierarchical (like tags)
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_rest' => true, // Enable Gutenberg support
        'rewrite' => array('slug' => 'model'),
    ));

    // Register "Series" taxonomy (hierarchical, like categories)
    register_taxonomy('series', 'post', array(
        'labels' => array(
            'name' => 'Series',
            'singular_name' => 'Series',
            'search_items' => 'Search Series',
            'all_items' => 'All Series',
            'parent_item' => 'Parent Series',
            'parent_item_colon' => 'Parent Series:',
            'edit_item' => 'Edit Series',
            'update_item' => 'Update Series',
            'add_new_item' => 'Add New Series',
            'new_item_name' => 'New Series Name',
            'menu_name' => 'Series',
        ),
        'public' => true,
        'hierarchical' => true, // Hierarchical (like categories)
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_rest' => true, // Enable Gutenberg support
        'rewrite' => array('slug' => 'series'),
    ));
}

// Hook into the 'init' action
add_action('init', 'register_custom_taxonomies');

/**
 * Helper function: Automatically migrate legacy 'actor' taxonomy to new 'model' taxonomy.
 * Runs once upon updating the theme. Safely transfers terms and post relationships to 'model'.
 */
function ogp_migrate_actor_to_model_taxonomy() {
	// Allow manual re-trigger by admin if needed: ?ogp_remigrate_taxonomies=1
	if ( isset( $_GET['ogp_remigrate_taxonomies'] ) && current_user_can( 'manage_options' ) ) {
		delete_option( 'ogp_migrated_actor_to_model' );
	}

	// Only run once automatically
	if ( get_option( 'ogp_migrated_actor_to_model' ) ) {
		return;
	}

	global $wpdb;

	// Check if any legacy terms exist in 'actor' taxonomy
	$actor_terms = $wpdb->get_results( "
		SELECT tt.term_taxonomy_id, tt.term_id, tt.description, tt.parent, tt.count, t.name, t.slug
		FROM {$wpdb->term_taxonomy} tt
		INNER JOIN {$wpdb->terms} t ON tt.term_id = t.term_id
		WHERE tt.taxonomy = 'actor'
	" );

	if ( ! empty( $actor_terms ) ) {
		foreach ( $actor_terms as $actor_term ) {
			// Check if a term with the same slug, name, or term_id already exists in 'model'
			$existing_model_term = $wpdb->get_row( $wpdb->prepare( "
				SELECT tt.term_taxonomy_id, tt.term_id
				FROM {$wpdb->term_taxonomy} tt
				INNER JOIN {$wpdb->terms} t ON tt.term_id = t.term_id
				WHERE tt.taxonomy = 'model' AND (t.slug = %s OR t.name = %s OR tt.term_id = %d)
				LIMIT 1
			", $actor_term->slug, $actor_term->name, $actor_term->term_id ) );

			if ( $existing_model_term ) {
				$old_tt_id = (int) $actor_term->term_taxonomy_id;
				$new_tt_id = (int) $existing_model_term->term_taxonomy_id;

				if ( $old_tt_id !== $new_tt_id ) {
					// Reassign post relationships from old actor term to existing model term
					$object_ids = $wpdb->get_col( $wpdb->prepare(
						"SELECT object_id FROM {$wpdb->term_relationships} WHERE term_taxonomy_id = %d",
						$old_tt_id
					) );

					if ( ! empty( $object_ids ) ) {
						foreach ( $object_ids as $object_id ) {
							$rel_exists = $wpdb->get_var( $wpdb->prepare(
								"SELECT COUNT(*) FROM {$wpdb->term_relationships} WHERE object_id = %d AND term_taxonomy_id = %d",
								$object_id,
								$new_tt_id
							) );

							if ( ! $rel_exists ) {
								$wpdb->insert(
									$wpdb->term_relationships,
									array(
										'object_id'        => (int) $object_id,
										'term_taxonomy_id' => $new_tt_id,
										'term_order'       => 0,
									),
									array( '%d', '%d', '%d' )
								);
							}
						}
					}

					// Clean up legacy actor relationships & term_taxonomy row
					$wpdb->delete( $wpdb->term_relationships, array( 'term_taxonomy_id' => $old_tt_id ), array( '%d' ) );
					$wpdb->delete( $wpdb->term_taxonomy, array( 'term_taxonomy_id' => $old_tt_id ), array( '%d' ) );
				}
			} else {
				// No duplicate: Directly reassign taxonomy from 'actor' to 'model'
				// All post relationships via term_taxonomy_id are preserved intact
				$wpdb->update(
					$wpdb->term_taxonomy,
					array( 'taxonomy' => 'model' ),
					array( 'term_taxonomy_id' => $actor_term->term_taxonomy_id ),
					array( '%s' ),
					array( '%d' )
				);
			}
		}

		// Clean cache and recalculate term counts
		clean_taxonomy_cache( 'model' );
		$all_model_terms = get_terms( array( 'taxonomy' => 'model', 'hide_empty' => false, 'fields' => 'ids' ) );
		if ( ! is_wp_error( $all_model_terms ) && ! empty( $all_model_terms ) ) {
			wp_update_term_count_now( $all_model_terms, 'model' );
		}
	}

	// Flush rewrite rules once so that /model/ permalinks work immediately
	flush_rewrite_rules( false );

	// Mark migration as completed
	update_option( 'ogp_migrated_actor_to_model', 1 );
}
add_action( 'init', 'ogp_migrate_actor_to_model_taxonomy', 20 );

/**
 * Register Widget Areas (Sidebars).
 */
function ogp_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Content', 'ogp' ),
			'id'            => 'footer-content',
			'description'   => esc_html__( 'Add widgets here to appear in the footer.', 'ogp' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<strong class="widget-title">',
			'after_title'   => '</strong>',
		)
	);
}
add_action( 'widgets_init', 'ogp_widgets_init' );

/**
 * Check if Yet Another Related Posts Plugin (YARPP) is installed/active,
 * and display a native admin notice with install/activate button if missing.
 */
function ogp_check_required_plugins() {
	if ( ! current_user_can( 'activate_plugins' ) ) {
		return;
	}

	// If YARPP is active, do not display notice
	if ( function_exists( 'yarpp_get_related' ) || class_exists( 'YARPP' ) ) {
		return;
	}

	$plugin_file = 'yet-another-related-posts-plugin/yarpp.php';
	$is_installed = file_exists( WP_PLUGIN_DIR . '/' . $plugin_file );

	if ( $is_installed ) {
		$action_url = wp_nonce_url(
			self_admin_url( 'plugins.php?action=activate&plugin=' . $plugin_file ),
			'activate-plugin_' . $plugin_file
		);
		$action_label = __( 'Activate YARPP', 'ogp' );
	} else {
		if ( ! current_user_can( 'install_plugins' ) ) {
			return;
		}
		$action_url = wp_nonce_url(
			self_admin_url( 'update.php?action=install-plugin&plugin=yet-another-related-posts-plugin' ),
			'install-plugin_yet-another-related-posts-plugin'
		);
		$action_label = __( 'Install & Activate YARPP', 'ogp' );
	}

	printf(
		'<div class="notice notice-warning is-dismissible"><p><strong>%1$s:</strong> %2$s <a href="%3$s" class="button button-primary" style="margin-left: 10px;">%4$s</a></p></div>',
		esc_html__( 'OGP Theme', 'ogp' ),
		esc_html__( 'This theme recommends Yet Another Related Posts Plugin (YARPP) to power related video recommendations.', 'ogp' ),
		esc_url( $action_url ),
		esc_html( $action_label )
	);
}
add_action( 'admin_notices', 'ogp_check_required_plugins' );

/**
 * Theme Update Checker via GitHub (PUC).
 * Supports public and private GitHub repositories.
 *
 * @link https://github.com/YahnisElsts/plugin-update-checker
 */
if ( file_exists( get_template_directory() . '/inc/plugin-update-checker/plugin-update-checker.php' ) ) {
	require_once get_template_directory() . '/inc/plugin-update-checker/plugin-update-checker.php';

	// GitHub Repository URL
	$ogp_repo_url = 'https://github.com/RipoN4/ogp/';

	$ogp_update_checker = YahnisElsts\PluginUpdateChecker\v5\PucFactory::buildUpdateChecker(
		$ogp_repo_url,
		get_template_directory() . '/style.css',
		'ogp'
	);

	// Optional: For private GitHub repositories, authenticate with a Personal Access Token (PAT).
	// Define in wp-config.php: define( 'OGP_GITHUB_TOKEN', 'your_personal_access_token' );
	// When the repository is made public, no token is needed at all.
	if ( defined( 'OGP_GITHUB_TOKEN' ) && OGP_GITHUB_TOKEN ) {
		$ogp_update_checker->setAuthentication( OGP_GITHUB_TOKEN );
	}

	// Set default release branch
	$ogp_update_checker->setBranch( 'main' );
}






