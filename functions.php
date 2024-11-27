<?php

// Set the timezone to Copenhagen
#date_default_timezone_set('Europe/Copenhagen');

/**
 * Include Theme Customizer.
 *
 * @since v1.0
 */
$theme_customizer = get_template_directory() . '/inc/customizer.php';
if ( is_readable( $theme_customizer ) ) {
	require_once $theme_customizer;
}


/**
 * Include Support for wordpress.com-specific functions.
 *
 * @since v1.0
 */
$theme_wordpresscom = get_template_directory() . '/inc/wordpresscom.php';
if ( is_readable( $theme_wordpresscom ) ) {
	require_once $theme_wordpresscom;
}

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since v1.0
 */
if ( ! isset( $content_width ) ) {
	$content_width = 800;
}

/**
 * General Theme Settings.
 *
 * @since v1.0
 */
if ( ! function_exists( 'greeting3_setup_theme' ) ) :
	function greeting3_setup_theme() {
		// Make theme available for translation: Translations can be filed in the /languages/ directory.

        ## WE KEEP THE greeting2 text domain to avoid making a new translation
		load_theme_textdomain( 'greeting2', get_template_directory() . '/languages' );

		// Theme Support.
		add_theme_support( 'title-tag' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'script',
				'style',
				'navigation-widgets',
			)
		);

		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );
		// Add support for full and wide alignment.
		add_theme_support( 'align-wide' );
		// Add support for editor styles.
		add_theme_support( 'editor-styles' );
		// Enqueue editor styles.
		add_editor_style( 'style-editor.css' );

		// Default Attachment Display Settings.
		update_option( 'image_default_align', 'none' );
		update_option( 'image_default_link_type', 'none' );
		update_option( 'image_default_size', 'large' );

		// Custom CSS-Styles of Wordpress Gallery.
		add_filter( 'use_default_gallery_style', '__return_false' );
	}
	add_action( 'after_setup_theme', 'greeting3_setup_theme' );

	// Disable Block Directory: https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/filters/editor-filters.md#block-directory
	remove_action( 'enqueue_block_editor_assets', 'wp_enqueue_editor_block_directory_assets' );
	remove_action( 'enqueue_block_editor_assets', 'gutenberg_enqueue_block_editor_assets_block_directory' );
endif;


/**
/**
 * Fire the wp_body_open action.
 *
 * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
 *
 * @since v2.2
 */
if ( ! function_exists( 'wp_body_open' ) ) :
	function wp_body_open() {
		/**
		 * Triggered after the opening <body> tag.
		 *
		 * @since v2.2
		 */
		do_action( 'wp_body_open' );
	}
endif;


/**
 * Add new User fields to Userprofile.
 *
 * @since v1.0
 */
if ( ! function_exists( 'greeting2_add_user_fields' ) ) :
	function greeting2_add_user_fields( $fields ) {
		// Add new fields.
		$fields['facebook_profile'] = 'Facebook URL';
		$fields['twitter_profile']  = 'Twitter URL';
		$fields['linkedin_profile'] = 'LinkedIn URL';
		$fields['github_profile']   = 'GitHub URL';

		return $fields;
	}
	add_filter( 'user_contactmethods', 'greeting2_add_user_fields' ); // get_user_meta( $user->ID, 'facebook_profile', true );
endif;


/**
 * Test if a page is a blog page.
 * if ( is_blog() ) { ... }
 *
 * @since v1.0
 */
function is_blog() {
	global $post;
	$posttype = get_post_type( $post );

	return ( ( is_archive() || is_author() || is_category() || is_home() || is_single() || ( is_tag() && ( 'post' === $posttype ) ) ) ? true : false );
}


/**
 * Disable comments for Media (Image-Post, Jetpack-Carousel, etc.)
 *
 * @since v1.0
 */
function greeting2_filter_media_comment_status( $open, $post_id = null ) {
	$media_post = get_post( $post_id );
	if ( 'attachment' === $media_post->post_type ) {
		return false;
	}
	return $open;
}
add_filter( 'comments_open', 'greeting2_filter_media_comment_status', 10, 2 );


/**
 * Style Edit buttons as badges: https://getbootstrap.com/docs/5.0/components/badge
 *
 * @since v1.0
 */
function greeting2_custom_edit_post_link( $output ) {
	return str_replace( 'class="post-edit-link"', 'class="post-edit-link badge badge-secondary"', $output );
}
add_filter( 'edit_post_link', 'greeting2_custom_edit_post_link' );

function greeting2_custom_edit_comment_link( $output ) {
	return str_replace( 'class="comment-edit-link"', 'class="comment-edit-link badge badge-secondary"', $output );
}
add_filter( 'edit_comment_link', 'greeting2_custom_edit_comment_link' );


/**
 * Responsive oEmbed filter: https://getbootstrap.com/docs/5.0/helpers/ratio
 *
 * @since v1.0
 */
function greeting2_oembed_filter( $html ) {
	return '<div class="ratio ratio-16x9">' . $html . '</div>';
}
add_filter( 'embed_oembed_html', 'greeting2_oembed_filter', 10, 4 );


if ( ! function_exists( 'greeting2_content_nav' ) ) :
	/**
	 * Display a navigation to next/previous pages when applicable.
	 *
	 * @since v1.0
	 */
	function greeting2_content_nav( $nav_id ) {
		global $wp_query;

		if ( $wp_query->max_num_pages > 1 ) :
	?>
			<div id="<?php echo esc_attr( $nav_id ); ?>" class="d-flex mb-4 justify-content-between">
				<div><?php next_posts_link( '<span aria-hidden="true">&larr;</span> ' . esc_html__( 'Older posts', 'greeting2' ) ); ?></div>
				<div><?php previous_posts_link( esc_html__( 'Newer posts', 'greeting2' ) . ' <span aria-hidden="true">&rarr;</span>' ); ?></div>
			</div><!-- /.d-flex -->
	<?php
		else :
			echo '<div class="clearfix"></div>';
		endif;
	}

	// Add Class.
	function posts_link_attributes() {
		return 'class="btn btn-secondary btn-lg"';
	}
	add_filter( 'next_posts_link_attributes', 'posts_link_attributes' );
	add_filter( 'previous_posts_link_attributes', 'posts_link_attributes' );
endif;


/**
 * Init Widget areas in Sidebar.
 *
 * @since v1.0
 */
function greeting2_widgets_init() {
	// Area 1.
	register_sidebar(
		array(
			'name'          => 'Primary Widget Area (Sidebar)',
			'id'            => 'primary_widget_area',
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	// Area 2.
	register_sidebar(
		array(
			'name'          => 'Secondary Widget Area (Header Navigation)',
			'id'            => 'secondary_widget_area',
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	// Area 3.
	register_sidebar(
		array(
			'name'          => 'Third Widget Area (Footer)',
			'id'            => 'third_widget_area',
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'greeting2_widgets_init' );


if ( ! function_exists( 'greeting2_article_posted_on' ) ) :
	/**
	 * "Theme posted on" pattern.
	 *
	 * @since v1.0
	 */
	function greeting2_article_posted_on() {
		printf(
			wp_kses_post( __( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a><span class="by-author"> <span class="sep"> by </span> <span class="author-meta vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'greeting2' ) ),
			esc_url( get_the_permalink() ),
			esc_attr( get_the_date() . ' - ' . get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() . ' - ' . get_the_time() ),
			esc_url( get_author_posts_url( (int) get_the_author_meta( 'ID' ) ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'greeting2' ), get_the_author() ),
			get_the_author()
		);
	}
endif;


/**
 * Template for Password protected post form.
 *
 * @since v1.0
 */
function greeting2_password_form() {
	global $post;
	$label = 'pwbox-' . ( empty( $post->ID ) ? rand() : $post->ID );

	$output = '<div class="row">';
		$output .= '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">';
		$output .= '<h4 class="col-md-12 alert alert-warning">' . esc_html__( 'This content is password protected. To view it please enter your password below.', 'greeting2' ) . '</h4>';
			$output .= '<div class="col-md-6">';
				$output .= '<div class="input-group">';
					$output .= '<input type="password" name="post_password" id="' . esc_attr( $label ) . '" placeholder="' . esc_attr__( 'Password', 'greeting2' ) . '" class="form-control" />';
					$output .= '<div class="input-group-append"><input type="submit" name="submit" class="btn btn-primary" value="' . esc_attr__( 'Submit', 'greeting2' ) . '" /></div>';
				$output .= '</div><!-- /.input-group -->';
			$output .= '</div><!-- /.col -->';
		$output .= '</form>';
	$output .= '</div><!-- /.row -->';
	return $output;
}
add_filter( 'the_password_form', 'greeting2_password_form' );


if ( ! function_exists( 'greeting2_comment' ) ) :
	/**
	 * Style Reply link.
	 *
	 * @since v1.0
	 */
	function greeting2_replace_reply_link_class( $class ) {
		return str_replace( "class='comment-reply-link", "class='comment-reply-link btn btn-outline-secondary", $class );
	}
	add_filter( 'comment_reply_link', 'greeting2_replace_reply_link_class' );

	/**
	 * Template for comments and pingbacks:
	 * add function to comments.php ... wp_list_comments( array( 'callback' => 'greeting2_comment' ) );
	 *
	 * @since v1.0
	 */
	function greeting2_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case 'pingback':
			case 'trackback':
	?>
		<li class="post pingback">
			<p><?php esc_html_e( 'Pingback:', 'greeting2' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( esc_html__( 'Edit', 'greeting2' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
				break;
			default:
	?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<article id="comment-<?php comment_ID(); ?>" class="comment">
				<footer class="comment-meta">
					<div class="comment-author vcard">
						<?php
							$avatar_size = ( '0' !== $comment->comment_parent ? 68 : 136 );
							echo get_avatar( $comment, $avatar_size );

							/* translators: 1: comment author, 2: date and time */
							printf(
								wp_kses_post( __( '%1$s, %2$s', 'greeting2' ) ),
								sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
								sprintf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
									esc_url( get_comment_link( $comment->comment_ID ) ),
									get_comment_time( 'c' ),
									/* translators: 1: date, 2: time */
									sprintf( esc_html__( '%1$s ago', 'greeting2' ), human_time_diff( (int) get_comment_time( 'U' ), current_time( 'timestamp' ) ) )
								)
							);

							edit_comment_link( esc_html__( 'Edit', 'greeting2' ), '<span class="edit-link">', '</span>' );
						?>
					</div><!-- .comment-author .vcard -->

					<?php if ( '0' === $comment->comment_approved ) : ?>
						<em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'greeting2' ); ?></em>
						<br />
					<?php endif; ?>
				</footer>

				<div class="comment-content"><?php comment_text(); ?></div>

				<div class="reply">
					<?php
						comment_reply_link(
							array_merge(
								$args,
								array(
									'reply_text' => esc_html__( 'Reply', 'greeting2' ) . ' <span>&darr;</span>',
									'depth'      => $depth,
									'max_depth'  => $args['max_depth'],
								)
							)
						);
					?>
				</div><!-- /.reply -->
			</article><!-- /#comment-## -->
		<?php
				break;
		endswitch;
	}

	/**
	 * Custom Comment form.
	 *
	 * @since v1.0
	 * @since v1.1: Added 'submit_button' and 'submit_field'
	 * @since v2.0.2: Added '$consent' and 'cookies'
	 */
	function greeting2_custom_commentform( $args = array(), $post_id = null ) {
		if ( null === $post_id ) {
			$post_id = get_the_ID();
		}

		$commenter     = wp_get_current_commenter();
		$user          = wp_get_current_user();
		$user_identity = $user->exists() ? $user->display_name : '';

		$args = wp_parse_args( $args );

		$req      = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true' required" : '' );
		$consent  = ( empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"' );
		$fields   = array(
			'author'  => '<div class="form-floating mb-3">
							<input type="text" id="author" name="author" class="form-control" value="' . esc_attr( $commenter['comment_author'] ) . '" placeholder="' . esc_html__( 'Name', 'greeting2' ) . ( $req ? '*' : '' ) . '"' . $aria_req . ' />
							<label for="author">' . esc_html__( 'Name', 'greeting2' ) . ( $req ? '*' : '' ) . '</label>
						</div>',
			'email'   => '<div class="form-floating mb-3">
							<input type="email" id="email" name="email" class="form-control" value="' . esc_attr( $commenter['comment_author_email'] ) . '" placeholder="' . esc_html__( 'Email', 'greeting2' ) . ( $req ? '*' : '' ) . '"' . $aria_req . ' />
							<label for="email">' . esc_html__( 'Email', 'greeting2' ) . ( $req ? '*' : '' ) . '</label>
						</div>',
			'url'     => '',
			'cookies' => '<p class="form-check mb-3 comment-form-cookies-consent">
							<input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" class="form-check-input" type="checkbox" value="yes"' . $consent . ' />
							<label class="form-check-label" for="wp-comment-cookies-consent">' . esc_html__( 'Save my name, email, and website in this browser for the next time I comment.', 'greeting2' ) . '</label>
						</p>',
		);

		$defaults = array(
			'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
			'comment_field'        => '<div class="form-floating mb-3">
											<textarea id="comment" name="comment" class="form-control" aria-required="true" required placeholder="' . esc_attr__( 'Comment', 'greeting2' ) . ( $req ? '*' : '' ) . '"></textarea>
											<label for="comment">' . esc_html__( 'Comment', 'greeting2' ) . '</label>
										</div>',
			/** This filter is documented in wp-includes/link-template.php */
			'must_log_in'          => '<p class="must-log-in">' . sprintf( wp_kses_post( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'greeting2' ) ), wp_login_url( apply_filters( 'the_permalink', get_the_permalink( get_the_ID() ) ) ) ) . '</p>',
			/** This filter is documented in wp-includes/link-template.php */
			'logged_in_as'         => '<p class="logged-in-as">' . sprintf( wp_kses_post( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'greeting2' ) ), get_edit_user_link(), $user->display_name, wp_logout_url( apply_filters( 'the_permalink', get_the_permalink( get_the_ID() ) ) ) ) . '</p>',
			'comment_notes_before' => '<p class="small comment-notes">' . esc_html__( 'Your Email address will not be published.', 'greeting2' ) . '</p>',
			'comment_notes_after'  => '',
			'id_form'              => 'commentform',
			'id_submit'            => 'submit',
			'class_submit'         => 'btn btn-primary',
			'name_submit'          => 'submit',
			'title_reply'          => '',
			'title_reply_to'       => esc_html__( 'Leave a Reply to %s', 'greeting2' ),
			'cancel_reply_link'    => esc_html__( 'Cancel reply', 'greeting2' ),
			'label_submit'         => esc_html__( 'Post Comment', 'greeting2' ),
			'submit_button'        => '<input type="submit" id="%2$s" name="%1$s" class="%3$s" value="%4$s" />',
			'submit_field'         => '<div class="form-submit">%1$s %2$s</div>',
			'format'               => 'html5',
		);

		return $defaults;
	}
	add_filter( 'comment_form_defaults', 'greeting2_custom_commentform' );

endif;

/**
 * Deregister MultiVendorX MVX Boodstrap
 * Deregister Woocommerce styles
 */
function remove_plugin_bootstrap_styles() {
    $user = wp_get_current_user();
    ################
    # MVX STYLES
    ################
    ## --- JS
    wp_dequeue_script('frontend_js');
    wp_deregister_script('frontend_js');

    wp_dequeue_script('mvx_single_product_multiple_vendors');
    wp_deregister_script('mvx_single_product_multiple_vendors');

    wp_dequeue_script('mvx_customer_qna_js');
    wp_deregister_script('mvx_customer_qna_js');

    if ( !in_array('dc_vendor', $user->roles) ) {
        wp_dequeue_script('mvx-bootstrap-script');
        wp_deregister_script('mvx-bootstrap-script');
    }

    wp_dequeue_script('mvx_customer_qna_js');
    wp_deregister_script('mvx_customer_qna_js');

    ## --- CSS
    // MVX BOOTSTRAP: mvx-bootstrap-style
    if ( !in_array('dc_vendor', $user->roles) ) {
        wp_dequeue_style('mvx-bootstrap-style');
        wp_deregister_style('mvx-bootstrap-style');
    }

    // MVX SELLER SHOP PAGE: mvx_seller_shop_page_css
    # This was once commented out... Cant remember why?
    wp_dequeue_style('mvx_seller_shop_page_css');
    wp_deregister_style('mvx_seller_shop_page_css');

    wp_dequeue_style('my_account_css');
    wp_deregister_style('my_account_css');

    // MVX SELLER SHOP PAGE: frontend_css
    wp_dequeue_style('frontend_css');
    wp_deregister_style('frontend_css');

    // MVX SELLER SHOP PAGE: mvx_seller_shop_page_css
    wp_dequeue_style('multiple_vendor');
    wp_deregister_style('multiple_vendor');

    // MVX SELLER SHOP PAGE: mvx_seller_shop_page_css
    wp_dequeue_style('product_css');
    wp_deregister_style('product_css');

    // MVX SELLER SHOP PAGE: mvx_seller_shop_page_css
    wp_dequeue_style('multiple_vendor');
    wp_deregister_style('multiple_vendor');

    ################
    # WooCommerce STYLES & JAVASCIPT
    ################


    // --- CSS
    // MVX SELLER SHOP PAGE: mvx_seller_shop_page_css
    wp_dequeue_style('woocommerce-smallscreen');
    wp_deregister_style('woocommerce-smallscreen');

    // MVX SELLER SHOP PAGE: mvx_seller_shop_page_css
    wp_dequeue_style('woocommerce-inline');
    wp_deregister_style('woocommerce-inline');


    // MVX SELLER SHOP PAGE: mvx_seller_shop_page_css
    #wp_dequeue_style('woocommerce-general');
    #wp_deregister_style('woocommerce-general');
    // MVX SELLER SHOP PAGE: mvx_seller_shop_page_css
    #wp_dequeue_style('woocommerce-layout');
    #wp_deregister_style('woocommerce-layout');

    $pagespeed_debug_dl_set_global_var = 0;
    if($pagespeed_debug_dl_set_global_var === 1) {

        #### LIST ENQUEUED CSS

        // Get the list of enqueued stylesheets
        $enqueued_styles = wp_styles()->queue;

        // Output the list of enqueued stylesheets
        echo "<h2>Enqueued Stylesheets:</h2>";
        echo "<ul>";

        foreach ($enqueued_styles as $style) {
            // Get the details of the registered stylesheet
            $style_details = wp_styles()->registered[$style];

            // Check if the source of the stylesheet contains the plugin directory path
            if (strpos($style_details->src, '/wp-content/plugins/') !== false) {
                // Extract plugin name from the source URL
                $plugin_name = explode('/wp-content/plugins/', $style_details->src)[1];
                $plugin_name = explode('/', $plugin_name)[0];
                echo "<li><strong>$plugin_name:</strong> $style</li>";
            } else {
                // If it's not from a plugin, just display the stylesheet name
                echo "<li>$style</li>";
            }
        }

        echo "</ul>";

        #### LIST ENQUEUED JAVASCRIPT
        // Get the list of enqueued JavaScript files
        $enqueued_scripts = wp_scripts()->queue;

        // Output the list of enqueued JavaScript files
        echo "<h2>Enqueued JavaScript Files:</h2>";
        echo "<ul>";

        foreach ($enqueued_scripts as $script) {
            // Get the details of the registered JavaScript file
            $script_details = wp_scripts()->registered[$script];

            // Check if the source of the JavaScript file contains the plugin directory path
            if (strpos($script_details->src, '/wp-content/plugins/') !== false) {
                // Extract plugin name from the source URL
                $plugin_name = explode('/wp-content/plugins/', $script_details->src)[1];
                $plugin_name = explode('/', $plugin_name)[0];
                echo "<li><strong>$plugin_name:</strong> $script</li>";
            } else {
                // If it's not from a plugin, just display the JavaScript file name
                echo "<li>$script</li>";
            }
        }

        echo "</ul>";
    }
}
add_action('wp_enqueue_scripts', 'remove_plugin_bootstrap_styles', 99999);


/**
 * Nav menus.
 *
 * @since v1.0
 */
if ( function_exists( 'register_nav_menus' ) ) {
	register_nav_menus(
		array(
			'main-menu-mobile'   => 'Main Menu Mobile - Hamburger menu',
			'main-menu-desktop'   => 'Main Navigation Menu (Top)',
			'footer-menu' => 'Footer Menu',
            'footer-menu-occasions' => 'Footer Menu (Occasions)',
            'footer-menu-categories' => 'Footer Menu (Categories)'
		)
	);
}

/**
 * Function to add custom classes to li's in
 * nav_menus
 *
 * @since v1.0
 *
 */
function add_additional_class_on_li($classes, $item, $args) {
    if(isset($args->add_li_class)) {
        $classes[] = $args->add_li_class;
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'add_additional_class_on_li', 1, 3);

/**
 * Function to add custom classes to a's in
 * nav_menus
 *
 * @since v1.0
 *
 */
function add_additional_class_on_a($atts, $item, $args) {
	$classes = '';
	 if(isset($args->add_a_class)) {
       $classes = $args->add_a_class;
   }
	 $atts['class'] = $classes;
   return $atts;
}
add_filter( 'nav_menu_link_attributes', 'add_additional_class_on_a', 10, 3 );

// Custom Nav Walker: wp_bootstrap_navwalker().
$custom_walker = get_template_directory() . '/inc/wp_bootstrap_navwalker.php';
if ( is_readable( $custom_walker ) ) {
	require_once $custom_walker;
}

$custom_walker_footer = get_template_directory() . '/inc/wp_bootstrap_navwalker_footer.php';
if ( is_readable( $custom_walker_footer ) ) {
	require_once $custom_walker_footer;
}


/**
 * Loading All CSS Stylesheets and Javascript Files.
 *
 * @since v1.0
 */
function greeting3_scripts_loader() {
	$theme_version = wp_get_theme()->get( 'Version' );

    /** Dela gothic */
    wp_enqueue_style(
        'google-fonts-dela-gothic',
        'https://fonts.googleapis.com/css2?family=Dela+Gothic+One&display=swap',
        array(),
        $theme_version,
        'all'
    );
    /** Inter */
    wp_enqueue_style(
        'google-fonts-rubik',
        'https://fonts.googleapis.com/css2?family=Inter:wght@300;500;700&display=swap',
        array(),
        $theme_version,
        'all'
    );
    /** Rubik */
    wp_enqueue_style(
        'google-fonts-inter',
        'https://fonts.googleapis.com/css2?family=Rubik:wght@300;500;700&display=swap',
        array(),
        $theme_version,
        'all'
    );

	// 1. Styles.
	wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css', array(), $theme_version, 'all' );

    // 2. Main style.
	wp_enqueue_style(
            'main',
            get_template_directory_uri() . '/assets/css/main.css',
            array(),
            $theme_version,
            'all'
    ); // main.scss: Compiled Framework source + custom styles.


	if ( is_rtl() ) {
		wp_enqueue_style( 'rtl', get_template_directory_uri() . '/assets/css/rtl.css', array(), $theme_version, 'all' );
	}

	// 2. Scripts.
	wp_enqueue_script(
        'mainjs',
        get_template_directory_uri() . '/assets/js/main.bundle.js',
        array(),
        $theme_version,
        array(
            'strategy' => 'async',
            'in_footer' => false
        ));

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'greeting3_scripts_loader' );

function add_defer_attribute($tag, $handle) {
    // List of handles for scripts you want to defer
    $scripts_to_defer = array('mainjs', 'main', 'style', 'rtl'); // Replace with the handle(s) of the script(s) you want to defer

    if (in_array($handle, $scripts_to_defer)) {
        return str_replace('src', 'defer="defer" src', $tag);
    }

    return $tag;
}
#add_filter('script_loader_tag', 'add_defer_attribute', 10, 2);

/***************************************************
 * =================================================
 * Adding new code
 * =================================================
 ***************************************************/


/**
 * Function for getting IP details
 * from user.
 *
 * @access public
 * @author Dennis Lauritzen
 * @return string
 */
function get_client_ip() {
    $ipaddress = isset($_SERVER['HTTP_CF_CONNECTING_IP']) ? $_SERVER['HTTP_CF_CONNECTING_IP'] : $_SERVER['REMOTE_ADDR'];

    if(home_url() == 'http://greeting' || home_url() == 'http://greeting.local'){
        $ipaddress = '212.10.115.191';
    }
    return $ipaddress;
}

/**
 * Function for getting IP info from
 * service providers' API.
 *
 * @access public
 * @author Dennis Lauritzen
 * @return string
 */
function call_ip_apis($ip){
    $urls = array(
        '0' => 'https://ipapi.co/'.$ip.'/json/',
        '1' => 'http://ip-api.com/json/'.$ip,
        '2' => 'http://ipinfo.io/'.$ip.'/json' // return HTTP=429 if usage limit reached
    );


    $curl = curl_init();

    if ($curl === false) {
        die('Curl initialization failed. Please check your cURL installation.');
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    foreach ($urls as $url) {
        curl_setopt($curl, CURLOPT_URL, $url);
        $response = curl_exec($curl);

        if ($response === false) {
            continue;
        }

        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($http_code == 200) {
            $jsonData = json_decode($response);
            curl_close($curl);
            return $jsonData;
        }
    }

    curl_close($curl);
    return null; // Return null if all API calls fail
}


add_action('wp_ajax_get_close_stores' , 'get_close_stores');
add_action('wp_ajax_nopriv_get_close_stores','get_close_stores');
function get_close_stores(){
    $postal_code = esc_attr($_POST['postal_code'] );

    global $wpdb, $MVX;

    $uploadDir = wp_upload_dir();
    $uploadDirBaseUrl = $uploadDir['baseurl'];

    $args = array(
        'role' => 'dc_vendor',
        'orderby' => 'meta_value',
        'meta_key' => 'delivery_zips',
        'order' => 'DESC',
        'number' => 3,
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'delivery_zips',
                'value' => $postal_code,
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'delivery_type',
                'value' => array(0,1),
                'type' => 'numeric',
                'compare' => 'IN'
            )
        )
    );
    $query = new WP_User_Query($args);
    $results = $query->get_results();

    $store_arr = array();

    foreach($results as $k => $v){
        $vendor = get_user_meta($v->ID);
        $vendor_page_slug = get_mvx_vendor($v->ID);
        // call the template with pass $vendor variable
        get_template_part('template-parts/vendor-loop', null, array('vendor' => $vendor_page_slug, 'cityName' => '', 'postalCode' => $postal_code));
    }

    wp_die();
}

function get_user_area($user_postal = ''){
    $user_areas = array(
        'start' => 1000,
        'end' => 9999
    );
    if(!empty($user_postal)){
        if($user_postal >= 1000 && $user_postal < 3000){
            $user_areas['start'] = 1000;
            $user_areas['end'] = 3000;
        } else if($user_postal >= 3000 && $user_postal < 3700){
            $user_areas['start'] = 3000;
            $user_areas['end'] = 3700;
        } else if($user_postal >= 3700 && $user_postal < 4000){
            $user_areas['start'] = 3700;
            $user_areas['end'] = 4000;
        } else if($user_postal >= 4000 && $user_postal < 4800){
            $user_areas['start'] = 4000;
            $user_areas['end'] = 4800;
        } else if($user_postal >= 4800 && $user_postal < 5000){
            $user_areas['start'] = 4800;
            $user_areas['end'] = 5000;
        } else if($user_postal >= 5000 && $user_postal < 6000){
            $user_areas['start'] = 5000;
            $user_areas['end'] = 6000;
        } else if($user_postal >= 6000 && $user_postal < 6700){
            $user_areas['start'] = 6000;
            $user_areas['end'] = 6700;
        } else if($user_postal >= 6700 && $user_postal < 7000){
            $user_areas['start'] = 6700;
            $user_areas['end'] = 7000;
        } else if($user_postal >= 7000 && $user_postal < 7500){
            $user_areas['start'] = 7000;
            $user_areas['end'] = 7500;
        } else if($user_postal >= 7500 && $user_postal < 8000){
            $user_areas['start'] = 7500;
            $user_areas['end'] = 8000;
        } else if($user_postal >= 8000 && $user_postal < 9000){
            $user_areas['start'] = 8000;
            $user_areas['end'] = 9000;
        } else if($user_postal >= 9000 && $user_postal < 9500){
            $user_areas['start'] = 9000;
            $user_areas['end'] = 9500;
        } else if($user_postal >= 9500 && $user_postal < 9700){
            $user_areas['start'] = 9500;
            $user_areas['end'] = 9700;
        } else if($user_postal >= 9700 && $user_postal < 10000){
            $user_areas['start'] = 9700;
            $user_areas['end'] = 9999;
        }
    }

    return $user_areas;
}

add_action('wp_ajax_get_featured_postal_codes' , 'get_featured_postal_codes');
add_action('wp_ajax_nopriv_get_featured_postal_codes','get_featured_postal_codes');
function get_featured_postal_codes(){
    global $wpdb;

    $postal_code = $_POST['postal_code'];

    $user_areas = get_user_area($postal_code);

    // Postal code array to submit
    $postal_code_arr = array();

    // Get the actual postal code
    $postal_args2 = array(
        'post_type' => 'city',
        'posts_per_page' => '1',
        'meta_query' => array(
            array(
                'key' => 'postalcode',
                'value' => $postal_code,
                'compare' => '='
            )
        ),
        'no_found_rows' => true
    );
    $postal_query2 = new WP_Query($postal_args2);
    foreach($postal_query2->posts as $k => $postal){
        $postal_code_arr[] = array(
            'link' => get_permalink($postal->ID),
            'postal' =>  get_post_meta($postal->ID, 'postalcode', true),
            'city' => get_post_meta($postal->ID, 'city', true)
        );
    }

    // Get the close areas
    $postal_args = array(
        'post_type' => 'city',
        'posts_per_page' => '7',
        'orderby' => 'meta_value',
        'meta_key' => 'is_featured_city',
        'order' => 'DESC',
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'postalcode',
                'value' => array($user_areas['start'], $user_areas['end']),
                'compare' => 'BETWEEN',
                'type' => 'numeric'
            ),
            array(
                'key' => 'postalcode',
                'value' => (!empty($postal_code) ? $postal_code : (int) '0999'),
                'compare' => '!=',
                'type' => 'numeric'
            )
        ),
        'no_found_rows' => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false
    );
    $postal_query = new WP_Query($postal_args);
    foreach($postal_query->posts as $k => $postal){
        $postal_query->the_post();
        $postal_code_arr[] = array(
            'link' => get_permalink($postal->ID),
            'postal' =>  get_post_meta($postal->ID, 'postalcode', true),
            'city' => get_post_meta($postal->ID, 'city', true)
        );
    }
    print json_encode($postal_code_arr);
    wp_die();
}
## -- FRONTPAGE FUNCTIONS END
######


## Include the helper for checking for HPOS compatibility.
include('functions-parts/general.hpos.compatibility.functions.php');

## Include Greeting specific functions (also the dates).
include('functions-parts/greeting.functions.php');
include('functions-parts/greeting.mvx.functions.php');
include('functions-parts/date.functions.php');
include('functions-parts/vendor.delivery-days.functions.php');

## Include PageSpeed optimization functions
include('functions-parts/pagespeed.functions.php');

## Include general Order Functions e.g. the hashes for tracking url etc.
include('functions-parts/general.order.functions.php');

## Include the functions for sending SMS'es.
include('functions-parts/sms.functions.php');

## Include admin panel functions.
include('functions-parts/admin.general.functions.php');
include('functions-parts/admin.order.functions.php');
include('functions-parts/admin.product.functions.php');
include('functions-parts/admin.vendor.functions.php');
include('functions-parts/admin.vendor.invite.functions.php');
include('functions-parts/admin.vendor.affiliate.bonus.functions.php');
include('functions-parts/admin.acf.blocks.functions.php');

## Include functions regarding checkout.
include('functions-parts/checkout.functions.php');
include('functions-parts/checkout.funeral.functions.php');

## Include e-mail functions
include('functions-parts/email.order.functions.php');

## Include frontend functions.
include('functions-parts/frontend.general.functions.php');
include('functions-parts/frontend.category.functions.php');
include('functions-parts/frontend.city.functions.php');
include('functions-parts/frontend.product.functions.php');
include('functions-parts/frontend.landingpage.functions.php');
include('functions-parts/frontend.user.functions.php');
include('functions-parts/frontend.vendor.functions.php');

## Include SEO-functions
include('functions-parts/seo.functions.php');

## Include functions regarding vendor dashboard.
include('functions-parts/vendordash.functions.php');

## Include API & cron functions.
include('functions-parts/api.functions.php');
#include('functions-parts/api.economic.functions.php');
include('functions-parts/cron.order.functions.php');