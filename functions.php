<?php

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
if ( ! function_exists( 'greeting2_setup_theme' ) ) :
	function greeting2_setup_theme() {
		// Make theme available for translation: Translations can be filed in the /languages/ directory.
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
	add_action( 'after_setup_theme', 'greeting2_setup_theme' );

	// Disable Block Directory: https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/filters/editor-filters.md#block-directory
	remove_action( 'enqueue_block_editor_assets', 'wp_enqueue_editor_block_directory_assets' );
	remove_action( 'enqueue_block_editor_assets', 'gutenberg_enqueue_block_editor_assets_block_directory' );
endif;


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
function greeting2_scripts_loader() {
	$theme_version = wp_get_theme()->get( 'Version' );

	// 1. Styles.
	wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css', array(), $theme_version, 'all' );
	//wp_enqueue_style( 'main', get_template_directory_uri() . '/assets/css/main.css', array(), $theme_version, 'all' ); // main.scss: Compiled Framework source + custom styles.

	if ( is_rtl() ) {
		wp_enqueue_style( 'rtl', get_template_directory_uri() . '/assets/css/rtl.css', array(), $theme_version, 'all' );
	}

	// 2. Scripts.
	wp_enqueue_script( 'mainjs', get_template_directory_uri() . '/assets/js/main.bundle.js', array(), $theme_version, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'greeting2_scripts_loader' );



//begin

/***************************************************
 * =================================================
 * Adding new code
 * =================================================
 ***************************************************/
/**
 * Custom post
 */
add_action('init', 'greeting_custom_post_type');
function greeting_custom_post_type() {

	// landing page
	register_post_type('landingpage',
        array(
            'labels' => array(
                'name'          => __('Landing Pages', 'woocommerce'),
                'singular_name' => __('Landing Page', 'woocommerce'),
            ),
            'menu_icon' => 'dashicons-flag',
            'public'      => true,
            'has_archive' => true,
						'rewrite' => array('slug' => 'l'),
            'supports' => array('title','editor'),
						'capabilities' => array(
								'publish_posts' => 'publish_wcmppages',
				        'edit_posts' => 'edit_wcmppages',
				        'edit_others_posts' => 'edit_other_wcmppages',
				        'delete_posts' => 'delete_wcmppages',
				        'delete_others_posts' => 'delete_other_wcmppages',
				        'read_private_posts' => 'read_private_wcmppages',
				        'edit_post' => 'edit_wcmppage',
				        'delete_post' => 'delete_wcmppage' )
        )
	);

	// city
	register_post_type('city',
        array(
            'labels' => array(
                'name'          => __('City', 'woocommerce'),
                'singular_name' => __('Cities', 'woocommerce'),
            ),
						'rewrite' => array('slug' => 'c'),
            'menu_icon' => 'dashicons-location-alt',
            'public'      => true,
            'has_archive' => true,
            'supports' => array('title'),
						'capabilities' => array(
							'publish_posts' => 'publish_wcmppages',
							'edit_posts' => 'edit_wcmppages',
							'edit_others_posts' => 'edit_other_wcmppages',
							'delete_posts' => 'delete_wcmppages',
							'delete_others_posts' => 'delete_other_wcmppages',
							'read_private_posts' => 'read_private_wcmppages',
							'edit_post' => 'edit_wcmppage',
							'delete_post' => 'delete_wcmppage' )
        )
	);
}

/**
 * Add settings pages to ACF.
 *
 */
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> 'Theme General Settings',
		'menu_title'	=> 'Theme Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Header Settings',
		'menu_title'	=> 'Header',
		'parent_slug'	=> 'theme-general-settings',
	));
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Footer Settings',
		'menu_title'	=> 'Footer',
		'parent_slug'	=> 'theme-general-settings',
	));
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Block: Howdy Settings',
		'menu_title'	=> 'Howdy-block',
		'parent_slug'	=> 'theme-general-settings',
	));
}



function add_theme_caps() {
    // gets the administrator role
    $admins = get_role( 'administrator' );

    $admins->add_cap( 'publish_wcmppages' );
    $admins->add_cap( 'edit_wcmppages' );
    $admins->add_cap( 'edit_other_wcmppages' );
    $admins->add_cap( 'delete_wcmppages' );
    $admins->add_cap( 'delete_other_wcmppages' );
    $admins->add_cap( 'read_private_wcmppages' );
    $admins->add_cap( 'edit_wcmppage' );
    $admins->add_cap( 'delete_wcmppage' );
}
add_action( 'admin_init', 'add_theme_caps');



/**
*
* Custom taxonomy for Greeting
*
**/
add_action( 'init', 'greeting_custom_taxonomy_occasion', 0 );

function greeting_custom_taxonomy_occasion()  {
	$labels = array(
		'name'                       => 'Occasions',
		'singular_name'              => 'Occasion',
		'menu_name'                  => 'Occasions',
		'all_occasions'                  => 'All Occasions',
		'parent_occasion'                => 'Parent Occasion',
		'parent_occasion_colon'          => 'Parent Occasion:',
		'new_occasion_name'              => 'New Occasion Name',
		'add_new_occasion'               => 'Add New Occasion',
		'edit_occasion'                  => 'Edit Occasion',
		'update_occasion'                => 'Update Occasion',
		'separate_occasions_with_commas' => 'Separate Occasion with commas',
		'search_occasions'               => 'Search Occasions',
		'add_or_remove_occasions'        => 'Add or remove Occasions',
		'choose_from_most_used'      => 'Choose from the most used Occasions',
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'capabilities' 							 => array(
				'publish_posts' => 'edit_posts',
        'edit_posts' => 'edit_posts',
        'edit_others_posts' => 'edit_posts',
        'delete_posts' => 'edit_posts',
        'delete_others_posts' => 'edit_posts',
        'read_private_posts' => 'edit_posts',
        'edit_post' => 'edit_posts',
        'delete_post' => 'edit_posts',
        'read_post' => 'edit_posts' )
	);
	register_taxonomy( 'occasion', 'product', $args );

}

/**
 *
 *
 *
 *
 */
function removeAdminVisibilityForSomeUSers(){
	$user = wp_get_current_user();

	if ( in_array( 'editor', (array) $user->roles ) ) {
      global $wp_admin_bar;
      $wp_admin_bar->remove_menu('new-content');
  }

	//remove_submenu_page( 'index.php', 'update-core.php');  // Update

		/* REMOVE DEFAULT MENUS */
	if (!in_array( 'administrator', (array) $user->roles )){
		remove_menu_page('edit.php?post_type=landingpage');
		remove_menu_page('edit.php?post_type=city');
		remove_menu_page('acoplw_badges_ui');
		remove_menu_page('upload.php');
	}
}
add_action( 'admin_head', 'removeAdminVisibilityForSomeUSers' );

/**
*
* Added functions for theme.
* @author Dennis
*
*/
// add the ajax fetch
// ** Custom formula for ajax fetch
add_action( 'wp_footer', 'ajax_fetch' );
function ajax_fetch() { ?>
	<script type="text/javascript">
		/** function for delaying ajax input**/
		function delay(ms, callback) {
			var timer = 0;
			return function() {
				var context = this, args = arguments;
				clearTimeout(timer);
				timer = setTimeout(function () {
					callback.apply(context, args);
				}, ms || 0);
			};
		}

		jQuery(document).ready(function(){
			var currentRequest = null;

			jQuery("#searchform").submit(function(event){
				event.preventDefault();
				var hid_pc_link = '';
				if(document.getElementById('hidden__s_link')){
					hid_pc_link = document.getElementById('hidden__s_link').value;
				}
				var val = jQuery("#datafetch_wrapper li.recomms:first-child a").prop('href');
				var location;

				if(hid_pc_link) {
					location = hid_pc_link;
				}
				if(val){
					location = val;
				}
				if(location.length){
					window.location.href = location;
				}
				return false;
			});

			/*Do the search with delay 500ms*/
			jQuery('#front_Search-new_ucsa').keyup(delay(500, function (e) {
				var text = jQuery(this).val();

				jQuery.ajax({
					url: '<?php echo admin_url('admin-ajax.php'); ?>',
					type: 'post',
					data: { action: 'data_fetch', keyword: text },
					beforeSend: function(){
						if(currentRequest != null){
							currentRequest.abort();
						}
					},
					success: function(data) {
						jQuery('#datafetch_wrapper').html( data );
						if(jQuery('input[name="keyword"]').val().length > 0){
							jQuery('#datafetch_wrapper').removeClass('d-none').addClass('d-inline');
						} else {
							jQuery('#datafetch_wrapper').addClass('d-none').removeClass('d-inline');
						}
					}
				});
			})); // keyup + delay
	}); // jquery ready
	</script>
<?php
}

// the ajax function
add_action('wp_ajax_data_fetch' , 'data_fetch');
add_action('wp_ajax_nopriv_data_fetch','data_fetch');

function data_fetch(){
	$search_query = esc_attr( $_POST['keyword'] );
	global $wpdb;

	$prepared_statement = $wpdb->prepare("
		SELECT *
		FROM {$wpdb->prefix}posts
		WHERE post_title LIKE %s
		AND post_type = 'city'
		LIMIT 5", '%'.trim($search_query).'%');
	$landing_page_query = $wpdb->get_results($prepared_statement, OBJECT);

	if (!empty($landing_page_query)) {?>
        <?php
        $array_count = count($landing_page_query);
        $i = 0;

        foreach ($landing_page_query as $key => $landing_page) {
            ?>
            <li class="recomms list-group-item py-2 px-4 <?php echo ($key==0) ? 'active' : '';?>" aria-current="true">
                <a href="<?php print get_permalink( $landing_page->ID ) ;?>" class="recomms-link text-teal stretched-link"><?php echo ucfirst($landing_page->post_title);?></a>
            </li>
        <?php } ?>
	<?php
	// If there is no match for the city, then do this...
	} else {?>
		<li class="list-group-item py-2 px-4" aria-current="true">
			Der blev desværre ikke fundet nogle byer, der matcher søgekriterierne
		</li>
	<?php }
	die();
}

//// amdad added


/**
 * Add product category meta to landing page
 */


add_action( 'admin_menu', 'greeting_add_product_cat_metabox' );

function greeting_add_product_cat_metabox() {

	add_meta_box(
		'greeting_product_cat_metabox', // metabox ID
		'Product Meta Box', // title
		'greeting_product_cat_metabox_callback', // callback function
		'landingpage', // post type or post types in array
		'normal', // position (normal, side, advanced)
		'default' // priority (default, low, high, core)
	);

}

function greeting_product_cat_metabox_callback( $post ) {

	$vendor_category_id = get_post_meta( $post->ID, 'landingpage_category', true );
	if($vendor_category_id){
		$vendor_category_name = get_term( $vendor_category_id )->name;
	}

	wp_nonce_field( 'somerandomstr', '_greetingcatnonce' );?>
	<table class="form-table">
		<tbody>
			<tr>
				<th><label for="landingpage_category">Landing Page Category</label></th>
				<td>
					<select id="landingpage_category" name="landingpage_category">
						<?php if($vendor_category_name != '') { ?>
						<option value="<?php echo $vendor_category_id;?>" selected><?php echo $vendor_category_name;?></option>
						<?php }
						else { ?>
						<option value="" selected disabled>Select Category</option>
						<?php }

							$args = array(
								'taxonomy'     => 'product_cat',
								'orderby'      => 'name',
								'show_count'   => 1, // 1 for yes, 0 for no
								'pad_counts'   => 1, // 1 for yes, 0 for no
								'title_li'     => '',
								'hide_empty'   => 0
						 );
						$all_categories = get_categories( $args );
						$all_categories_unique = array_unique( $all_categories, SORT_REGULAR );
						foreach ($all_categories_unique as $cat) {
							if($cat->name != $vendor_category_name) {?>
								<option value="<?php echo $cat->term_id;?>"><?php echo $cat->name;?></option>
						<?php } }?>
					</select>
				</td>
			</tr>
		</tbody>
	</table>
<?php
}
// save meta
add_action( 'save_post', 'greeting_save_product_cat_meta', 10, 2 );

function greeting_save_product_cat_meta( $post_id ) {

	global $post;
    if ( is_object( $post ) && isset( $post->post_type ) && $post->post_type != 'landingpage'){
        return;
    }
    //if you get here then it's your post type so do your thing....

	// nonce check
	if ( ! isset( $_POST[ '_greetingcatnonce' ] ) || ! wp_verify_nonce( $_POST[ '_greetingcatnonce' ], 'somerandomstr' ) ) {
		return $post_id;
	}

	// check current use permissions
	$post_type = get_post_type_object( $post->post_type );

	if ( ! current_user_can( $post_type->cap->edit_post, $post_id ) ) {
		return $post_id;
	}

	// Do not save the data if autosave
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
		return $post_id;
	}

	// define your own post type here
	if( $post->post_type != 'landingpage' ) {
		return $post_id;
	}


	if( isset( $_POST[ 'landingpage_category' ] ) ) {
		update_post_meta( $post_id, 'landingpage_category', sanitize_text_field( $_POST[ 'landingpage_category' ] ) );
	} else {
		delete_post_meta( $post_id, 'landingpage_category' );
	}

	return $post_id;

}


/**
 * Vendor filter on City Page
 * city filter
 */
function catOccaDeliveryAction() {
	// default user array come from front end
	$cityDefaultUserIdAsString = $_POST['cityDefaultUserIdAsString'];
	$defaultUserArray = explode(",", $cityDefaultUserIdAsString);

	// category & occasion filter data
	$catOccaDeliveryIdArray = $_POST['catOccaIdArray'];
	// delivery filter data
	$deliveryIdArray = $_POST['deliveryIdArray'];

	$postal_code = $_POST['postalCode'];

	// declare array for store user ID get from occasion
	$userIdArrayGetFromCatOcca = array();

	// declare array for store user ID got from delivery type
	$userIdArrayGetFromDelivery = array();


	global $wpdb;
	// Prepare the where and where-placeholders for term_id (cat and occassion ID's).
	$where = array();
	$placeholder_arr = array_fill(0, count($catOccaDeliveryIdArray), '%s');

	if(!empty($catOccaDeliveryIdArray)){
		foreach($catOccaDeliveryIdArray as $catOccaDeliveryId){
			if(is_numeric($catOccaDeliveryId)){
				$where[] = $catOccaDeliveryId;
			}
		}

		$sql = "SELECT
			p.post_author
		FROM ".$wpdb->prefix."posts p
		WHERE
			p.ID IN (
				SELECT
					tm.object_id
				FROM ".$wpdb->prefix."term_relationships tm
				WHERE tm.term_taxonomy_id IN (".implode(", ",$placeholder_arr).")
		  )
			AND p.post_status = 'publish'
		GROUP BY p.post_author";

		$getStoreUserDataBasedOnProduct = $wpdb->prepare($sql, $where);
		$storeUserCatOccaResults = $wpdb->get_results($getStoreUserDataBasedOnProduct);

		foreach($storeUserCatOccaResults as $product){
			array_push($userIdArrayGetFromCatOcca, $product->post_author);
		}
	}
	// Remove all the stores that doesnt match from default array
	if(!empty($userIdArrayGetFromCatOcca)){
		$userIdArrayGetFromCatOcca = array_intersect($defaultUserArray, $userIdArrayGetFromCatOcca);
		$defaultUserArray = $userIdArrayGetFromCatOcca;
	}
	////////////////////////
	// FILTER: Delivery
	// Prepare the statement for delivery array
	$where = array();
	$placeholder_arr = array_fill(0, count($deliveryIdArray), '%s');

	if(!empty($deliveryIdArray)){
		$args = array(
			'role' => 'dc_vendor',
			'meta_query' => array(
					'key' => 'delivery_type',
					'value' => $deliveryIdArray,
					'compare' => 'IN',
					'type' => 'NUMERIC'
				)
		);
		$usersByFilter = new WP_User_Query( $args	);
		$deliveryArr = $usersByFilter->get_results($usersByFilter);

		foreach($deliveryArr as $v){
			$delivery_type = get_field('delivery_type','user_'.$v->ID);

			if(!empty($delivery_type)){
				if(in_array($delivery_type[0]['value'],$deliveryIdArray) || (isset($delivery_type[1]['value']) && in_array($delivery_type[1]['value'],$deliveryIdArray) )  ){
					array_push($userIdArrayGetFromDelivery, (string) $v->ID);
				}
			}
		}
	}
	// Remove all the stores that doesnt match from default array
	if(!empty($userIdArrayGetFromDelivery)){
		$userIdArrayGetFromDelivery = array_intersect($defaultUserArray, $userIdArrayGetFromDelivery);
		$defaultUserArray = $userIdArrayGetFromDelivery;
	}

	////////////////
	// Filter: Price
	// Location: City Page
	// input price filter data come from front end
	$userIdArrayGetFromPriceFilter = array();
	$inputPriceRangeArray = $_POST['inputPriceRangeArray'];
	$inputMinPrice = (int) $inputPriceRangeArray[0];
	$inputMaxPrice = (int) $inputPriceRangeArray[1];
	$query = array(
		'post_status' => 'publish',
		'post_type' => 'product',
		'meta_query' => array(
			array(
				'key' => '_price',
				// 'value' => array(302, 380),
				'value' => array($inputMinPrice, $inputMaxPrice),
				// 'value' => $inputPriceRangeArray,
				'compare' => 'BETWEEN',
				'type' => 'NUMERIC'
			)
		),
		'posts_per_page' => -1
	);

	$productQuery = new WP_Query($query);
	$userIdArrayGetFromPriceFilter = array_unique(wp_list_pluck( $productQuery->posts, 'post_author' ));

	// Remove all the stores that doesnt match from default array
	if(!empty($userIdArrayGetFromPriceFilter)){
		$userIdArrayGetFromPriceFilter = array_intersect($defaultUserArray, $userIdArrayGetFromPriceFilter);

		$defaultUserArray = $userIdArrayGetFromPriceFilter;
	}

	// three array is
	// $userIdArrayGetFromCatOcca
	// $userIdArrayGetFromDelivery
	// $userIdArrayGetFromPriceFilter


	$return_arr = $defaultUserArray;

	if(!empty($return_arr)){
		foreach ($return_arr as $filteredUser) {
			$vendor_int = (int) $filteredUser;

			$vendor = get_wcmp_vendor($vendor_int);

			$cityName = $_POST['cityName'];
			// call the template with pass $vendor variable
			get_template_part('dc-product-vendor/vendor-loop', null, array('vendor' => $vendor, 'cityName' => $cityName));
		}
	} else { ?>
		<div>
			<p id="noVendorFound" style="margin-top: 50px; margin-bottom: 35px; padding: 15px 10px; background-color: #f8f8f8;">
				Der blev desværre ikke fundet nogle butikker, der matcher dine søgekriterier.
			</p>
		</div>
	<?php
	}
	wp_die();
}
add_action( 'wp_ajax_catOccaDeliveryAction', 'catOccaDeliveryAction' );
add_action( 'wp_ajax_nopriv_catOccaDeliveryAction', 'catOccaDeliveryAction' );


/**
 * Vendor filter on Landing Page
 */

//add_action( 'wp_footer', 'landpageActionJavascript' );
function landpageActionJavascript() { ?>
	<script type="text/javascript">

		jQuery(document).ready(function($) {

			var ajaxurl = "<?php echo admin_url('admin-ajax.php');?>";
			var occaDeliveryIdArray = [];
			var inputPriceRangeArray = [];
			// $('#landingPageReset').hide();

			jQuery('.filter-on-landing-page, .slider').click(function(){
				// alert("from landing page");
				// inputPriceRangeArray = jQuery('#priceSlider').slider("option", "values");
				inputPriceRangeArray = slider.getValue();
				occaDeliveryIdArray = [];
				$("input:checkbox[name=filter_landing_page]:checked").each(function(){
					occaDeliveryIdArray.push($(this).val());
				});

				var cityName = $('#cityName').val();
				var data = {'action': 'landpageAction', landingPageDefaultUserIdAsString: jQuery("#landingPageDefaultUserIdAsString").val(), occaDeliveryIdArray: occaDeliveryIdArray, inputPriceRangeArray: inputPriceRangeArray, cityName: cityName};
				jQuery.post(ajaxurl, data, function(response) {
					jQuery('.store').hide();
					jQuery('.filteredStore').show();
					jQuery('.filteredStore').html(response);
					if(occaDeliveryIdArray.length == 0){
						jQuery('.store').show();
						jQuery('#noVendorFound').hide();
					}
				});
			});

			// reset filter
			$('#landingPageReset').click(function(){
				$("input:checkbox[name=filter_landing_page]").removeAttr("checked");
				occaDeliveryIdArray.length = 0;
				jQuery('.store').show();
				jQuery('.filteredStore').hide();
			});
		});

		// Add remove loading class on body element based on Ajax request status
		jQuery(document).on({
			ajaxStart: function(){
				jQuery("div").addClass("loading");
			},
			ajaxStop: function(){
				jQuery("div").removeClass("loading");
			}
		});

	</script><?php
}

function landpageAction() {

	global $wpdb;

	// default user array come from front end
	$landingPageDefaultUserIdAsString = $_POST['landingPageDefaultUserIdAsString'];
	$defaultUserArray = explode(",", $landingPageDefaultUserIdAsString);

	// Occasion and Delivery type  filter data
	$occaDeliveryIdArray = $_POST['occaDeliveryIdArray'];

	// declare array for store user ID get from occasion
	$userIdArrayGetFromOcca = array();

	// declare array for store user ID got from delivery type
	$userIdArrayGetFromDelivery = array();

	foreach($occaDeliveryIdArray as $occaDeliveryId){
        # @todo make sure there is no chance of injection.
		if(is_numeric($occaDeliveryId)){
			$productData = $wpdb->get_results(
				"
					SELECT *
					FROM {$wpdb->prefix}term_relationships
					WHERE term_taxonomy_id = $occaDeliveryId
				"
			);
			foreach($productData as $product){
				$singleProductId = $product->object_id;
				$postAuthor = $wpdb->get_row(
					"
						SELECT *
						FROM {$wpdb->prefix}posts
						WHERE ID = $singleProductId
					"
				);

				$postAuthorId = $postAuthor->post_author;

				array_push($userIdArrayGetFromOcca, $postAuthorId);
			}
		} else {
			foreach($defaultUserArray as $defaultUserId){
				$userMetas = get_user_meta($defaultUserId, 'delivery_type', true);

				foreach($userMetas as $deliveryType){
					if($deliveryType == $occaDeliveryId){
						array_push($userIdArrayGetFromDelivery, $defaultUserId);
					}
				}
			}
		}
	}


	// input price filter data come from front end
	$inputPriceRangeArray = $_POST['inputPriceRangeArray'];
	$inputMinPrice = $inputPriceRangeArray[0];
	$inputMaxPrice = $inputPriceRangeArray[1];

	$query = array(
		'post_status' => 'publish',
		'post_type' => 'product',
		'meta_query' => array(
			array(
				'key' => '_price',
				// 'value' => array(302, 380),
				'value' => array($inputMinPrice, $inputMaxPrice),
				// 'value' => $inputPriceRangeArray,
				'compare' => 'BETWEEN',
				'type' => 'NUMERIC'
			)
		)
	);

	$productQuery = new WP_Query($query);
	$userIdArrayGetFromPriceFilter = wp_list_pluck( $productQuery->posts, 'post_author' );


	// three array is
	// $userIdArrayGetFromOcca
	// $userIdArrayGetFromDelivery
	// $userIdArrayGetFromPriceFilter

	// check condition
	$userIdArrayGetFromCatOccaDelivery = array();

	if(!empty($userIdArrayGetFromOcca) && !empty($userIdArrayGetFromDelivery) && !empty($userIdArrayGetFromPriceFilter)){
		$arrOfArrs = [$userIdArrayGetFromOcca, $userIdArrayGetFromDelivery, $userIdArrayGetFromPriceFilter];
		$userIdArrayGetFromCatOccaDelivery = array_intersect(...$arrOfArrs);
	}

	elseif(!empty($userIdArrayGetFromOcca) && !empty($userIdArrayGetFromDelivery) && empty($userIdArrayGetFromPriceFilter)){
		$userIdArrayGetFromCatOccaDelivery = array_intersect($userIdArrayGetFromOcca, $userIdArrayGetFromDelivery);
	}
	elseif(!empty($userIdArrayGetFromOcca) && empty($userIdArrayGetFromDelivery) && !empty($userIdArrayGetFromPriceFilter)){
		$userIdArrayGetFromCatOccaDelivery = array_intersect($userIdArrayGetFromOcca, $userIdArrayGetFromPriceFilter);
	}
	elseif(empty($userIdArrayGetFromOcca) && !empty($userIdArrayGetFromDelivery) && !empty($userIdArrayGetFromPriceFilter)){
		$userIdArrayGetFromCatOccaDelivery = array_intersect($userIdArrayGetFromDelivery, $userIdArrayGetFromPriceFilter);
	}


	elseif(!empty($userIdArrayGetFromOcca) && empty($userIdArrayGetFromDelivery) && empty($userIdArrayGetFromPriceFilter)){
		$userIdArrayGetFromCatOccaDelivery = $userIdArrayGetFromOcca;
	}
	elseif(empty($userIdArrayGetFromOcca) && empty($userIdArrayGetFromDelivery) && !empty($userIdArrayGetFromPriceFilter)){
		$userIdArrayGetFromCatOccaDelivery = $userIdArrayGetFromPriceFilter;
		//
	}
	elseif(empty($userIdArrayGetFromOcca) && !empty($userIdArrayGetFromDelivery) && empty($userIdArrayGetFromPriceFilter)){
		$userIdArrayGetFromCatOccaDelivery = $userIdArrayGetFromDelivery;
	}

	else {

	}

	$filteredCatOccaDeliveryArray = array_intersect($defaultUserArray, $userIdArrayGetFromCatOccaDelivery);
	$filteredOccaDeliveryArrayUnique = array_unique($filteredCatOccaDeliveryArray);


	if(count($filteredOccaDeliveryArrayUnique) > 0 ){ ?>
		<?php
		foreach ($filteredOccaDeliveryArrayUnique as $filteredUser) {

			$vendor = get_wcmp_vendor($filteredUser);
			$cityName = $_POST['cityName'];

			// call the template with pass $vendor variable
			get_template_part('template-parts/vendor-loop', null, array('vendor' => $vendor, 'cityName' => $cityName));
			?>

		<?php
		}
		?>

	<?php } else { ?>

	<div>
		<p id="noVendorFound" style="margin-top: 50px; margin-bottom: 35px; padding: 15px 10px; background-color: #f8f8f8;">No vendors were found matching your selection.</p>
	</div>

	<?php }

	wp_die();
}

add_action( 'wp_ajax_landpageAction', 'landpageAction' );
add_action( 'wp_ajax_nopriv_landpageAction', 'landpageAction' );


/**
 * Vendor filter on Product Category Page
 */
//add_action( 'wp_footer', 'categoryPageActionJavascript' );
function categoryPageActionJavascript() { ?>
	<script type="text/javascript">

		jQuery(document).ready(function($) {

			var ajaxurl = "<?php echo admin_url('admin-ajax.php');?>";
			var itemArrayForStoreFilter = [];
			$('#resetAllCategoryPage').hide();

			jQuery('.vendor_sort_categorypage_item').click(function(){
				itemArrayForStoreFilter = [];
				$("input:checkbox[name=type_categorypage]:checked").each(function(){
					itemArrayForStoreFilter.push($(this).val());
				});

				var data = {'action': 'categoryPageFilterAction', categoryPageDefaultUserIdAsString: jQuery("#categoryPageDefaultUserIdAsString").val(), itemArrayForStoreFilter: itemArrayForStoreFilter};
				jQuery.post(ajaxurl, data, function(response) {
					jQuery('#vendorByDeliveryZipCategory').hide();
					jQuery('#vendorAfterFilter').show();
					$('#resetAllCategoryPage').show();
					jQuery('#vendorAfterFilter').html(response);
					if(itemArrayForStoreFilter.length == 0){
						jQuery('#vendorByDeliveryZipCategory').show();
						jQuery('#noVendorFound').hide();
					}
				});
			});

			// reset filter
			$('#resetAllCategoryPage').click(function(){
				var inputVal = $("input:checkbox[name=type_categorypage]").val();
				// $("input:checkbox[name=type_categorypage]").removeAttr("checked");
				$("input:checkbox[name=type_categorypage]").prop("checked", false)
				itemArrayForStoreFilter.length = 0;
				jQuery('#vendorByDeliveryZipCategory').show();
				jQuery('#vendorAfterFilter').hide();
				$('#resetAllCategoryPage').hide();
			});
		});

		// Add remove loading class on body element based on Ajax request status
		jQuery(document).on({
			ajaxStart: function(){
				jQuery("div").addClass("loading-custom");
			},
			ajaxStop: function(){
				jQuery("div").removeClass("loading-custom");
			}
		});

	</script><?php
}

function categoryPageFilterAction() {

	// default user array come from front end
	$categoryPageDefaultUserIdAsString = $_POST['categoryPageDefaultUserIdAsString'];
	$defaultUserArray = explode(",", $categoryPageDefaultUserIdAsString);

	// category, occasion and delivery  filter data
	$itemArrayForStoreFilter = $_POST['itemArrayForStoreFilter'];

	// declare array for store user ID get from occasion
	$userIdArrayGetFromCatOcca = array();

	// declare array for store user ID got from delivery type
	$userIdArrayGetFromDelivery = array();

	global $wpdb;

	foreach($itemArrayForStoreFilter as $frontendFilterItem){

		if(is_numeric($frontendFilterItem)){
			$productData = $wpdb->get_results(
				"
					SELECT *
					FROM {$wpdb->prefix}term_relationships
					WHERE term_taxonomy_id = $frontendFilterItem
				"
			);
			foreach($productData as $product){
				$singleProductId = $product->object_id;
				$postAuthor = $wpdb->get_row(
					"
						SELECT *
						FROM {$wpdb->prefix}posts
						WHERE ID = $singleProductId
					"
				);

				$postAuthorId = $postAuthor->post_author;

				array_push($userIdArrayGetFromCatOcca, $postAuthorId);
			}
		} else {

			foreach($defaultUserArray as $defaultUserId){

				$userMetas = get_user_meta($defaultUserId, 'delivery_type', true);

				foreach($userMetas as $deliveryType){
					if($deliveryType == $frontendFilterItem){
						array_push($userIdArrayGetFromDelivery, $defaultUserId);
					}
				}
			}
		}
	}

	// check condition
	$userIdArrayGetFromCatOccaDelivery = array();
	if(count($userIdArrayGetFromCatOcca) > 0 && count($userIdArrayGetFromDelivery) > 0){
		$userIdArrayGetFromCatOccaDelivery = array_intersect($userIdArrayGetFromCatOcca, $userIdArrayGetFromDelivery);
	}
	elseif(count($userIdArrayGetFromCatOcca) > 0 && count($userIdArrayGetFromDelivery) == 0){
		$userIdArrayGetFromCatOccaDelivery = $userIdArrayGetFromCatOcca;
	}
	elseif(count($userIdArrayGetFromCatOcca) == 0 && count($userIdArrayGetFromDelivery) > 0){
		$userIdArrayGetFromCatOccaDelivery = $userIdArrayGetFromDelivery;
	}
	else {
		//echo "No filter applicable!";
	}

	$filteredCatOccaDeliveryArray = array_intersect($defaultUserArray, $userIdArrayGetFromCatOccaDelivery);
	$filteredCatOccaDeliveryArrayUnique = array_unique($filteredCatOccaDeliveryArray);


	if(count($filteredCatOccaDeliveryArrayUnique) > 0 ){ ?>

		<?php
		foreach ($filteredCatOccaDeliveryArrayUnique as $filteredUser) {

			$vendor = get_wcmp_vendor($filteredUser);

			// call the template with pass $vendor variable
			get_template_part('template-parts/vendor-loop', null, array('vendor' => $vendor));

			?>

		<?php
		}
		?>

	<?php }  { ?>

	<div>
		<p id="noVendorFound" style="margin-top: 50px; margin-bottom: 35px; padding: 15px 10px; background-color: #f8f8f8;">No vendors were found matching your selection.</p>
	</div>

	<?php }

	wp_die();
}
if(!is_cart() && !is_checkout()){
	add_action( 'wp_ajax_categoryPageFilterAction', 'categoryPageFilterAction' );
	add_action( 'wp_ajax_nopriv_categoryPageFilterAction', 'categoryPageFilterAction' );
}

/**
 * Filter on vendor store page
 * @usedon /vendor/*
 * Updated 30/4 by Dennis Lauritzen
 */
if(!is_cart() && !is_checkout()){
	add_action( 'wp_footer', 'vendStoreActionJavascript' );
}
function vendStoreActionJavascript() { ?>
	<?php
}

function productFilterAction() {

	// default product id array come from front end
	$defaultProductIdAsString = $_POST['defaultProductIdAsString'];
	$defaultProductIdArray = explode(",", $defaultProductIdAsString);
	$default_placeholder = array_fill(0, count($defaultProductIdArray), '%d');

	// Get secrets & info
	$nn = $_POST['nn'];
	$gid = $_POST['gid'];
	$guid = $_POST['guid'];

	// Check (best we can) if the data has been changed before post.
	if($guid != hash('crc32c', $gid.'-_-'.$nn)){
		return;
	}


	global $wpdb;

	// input price filter data come from front end
	$inputPriceRangeArray = $_POST['inputPriceRangeArray'];
	$inputMinPrice = (int) $inputPriceRangeArray[0];
	$inputMaxPrice = (int) $inputPriceRangeArray[1];

	// after click filter data keep on this array
	$catIDs = $_POST['catIds'];
	$occIDs = $_POST['occIds'];

	$query = array(
		'post_status' => 'publish',
		'post_type' => 'product',
		'author' => $gid,
		'meta_query' => array(
			array(
				'key' => '_price',
				// 'value' => array(50, 100),
				'value' => array($inputMinPrice, $inputMaxPrice),
				'compare' => 'BETWEEN',
				'type' => 'NUMERIC'
			)
		)
	);
	// Loop category IDs for where
	$cat_arr = array();
	foreach($catIDs as $k => $v){
		$cat_arr[] = $v;
	}
	// Loop occassion IDs for where
	$occ_arr = array();
	foreach($occIDs as $k => $v){
		$occ_arr[] = $v;
	}

	if(!empty($cat_arr) && !empty($occ_arr)){
		$query['tax_query']['relation'] = 'AND';
	}
	if(!empty($cat_arr)){
		$query['tax_query'][] = array(
			'taxonomy' => 'product_cat',
			'field' => 'term_id',
			'terms' => $cat_arr
		);
	}

	if(!empty($occ_arr)){
		$query['tax_query'][] = array(
			'taxonomy' => 'occasion',
			'field' => 'term_id',
			'terms' => $occ_arr
		);
	}

	$loop  = new WP_Query($query);

	if ( $loop ->have_posts() ) {

		while ( $loop ->have_posts() ) : $loop ->the_post();
        wc_get_template_part( 'content', 'product' );
    endwhile;

	} else { ?>

	<div>
		<p id="noProductFound" style="margin-top: 50px; margin-bottom: 35px; padding: 15px 10px; background-color: #f8f8f8;">
			No products were found matching your selection.
		</p>
	</div>

	<?php }

	wp_die();
}

add_action( 'wp_ajax_productFilterAction', 'productFilterAction' );
add_action( 'wp_ajax_nopriv_productFilterAction', 'productFilterAction' );

/**
 * Custom order status
 */
add_action( 'init', 'register_delivered_order_status' );
function register_delivered_order_status() {
    register_post_status( 'wc-delivered', array(
        'label'                     => 'Delivered',
        'public'                    => true,
        'show_in_admin_status_list' => true,
        'show_in_admin_all_list'    => true,
        'exclude_from_search'       => false,
        'label_count'               => _n_noop( 'Delivered <span class="count">(%s)</span>', 'Delivered <span class="count">(%s)</span>' )
    ) );
}

add_filter( 'wc_order_statuses', 'add_awaiting_delivered_to_order_statuses' );

function add_awaiting_delivered_to_order_statuses( $order_statuses ) {

    $new_order_statuses = array();

    foreach ( $order_statuses as $key => $status ) {

        $new_order_statuses[ $key ] = $status;

        if ( 'wc-processing' === $key ) {
            $new_order_statuses['wc-delivered'] = 'Delivered';
        }
    }

    return $new_order_statuses;
}

/**
 * Email send to store owner
 */

// get last order id
function getLastOrderId(){
    global $wpdb;
    $statuses = array_keys(wc_get_order_statuses());
    $statuses = implode( "','", $statuses );

    // @todo make sure no chanc of injection
    // Getting last Order ID (max value)
    $results = $wpdb->get_col( "
        SELECT MAX(ID) FROM {$wpdb->prefix}posts
        WHERE post_type LIKE 'shop_order'
        AND post_status IN ('$statuses')
    " );
    return reset($results);
}

// Action based on last order
use Dompdf\Dompdf; // reference the Dompdf namespace
// add the action
# add_action( 'woocommerce_thankyou', 'call_order_status_completed', 10, 1);
// define woocommerce_order_status_completed callback function
function call_order_status_completed( $array ) {

	$latestOrderId = getLastOrderId(); // Last order ID
	$order_hash = hash('md4','gree_ting_dk#!4r1242142fgriejgfto'.$latestOrderId.$latestOrderId);
	$order_hash2 = hash('md4', 'vvkrne12onrtnFG_:____'.$latestOrderId);

	$order = wc_get_order( $latestOrderId ); // Get an instance of the WC_Order oject

	$orderCreatedDate =  $order->get_date_created();
	$orderCreateDateFormat = date_format($orderCreatedDate ,"M d, Y");
	$orderCurrency = $order->get_currency();
	$orderSubTotal =  $order->get_subtotal();
	$orderTotal =  $order->get_total();
	$orderPaymentMethod =  $order->get_payment_method();
	// billing details
	$billingFirstName = $order->get_billing_first_name();
	$billingLastName = $order->get_billing_last_name();
	$billingCompany = $order->get_billing_company();
	$billingAddress1 = $order->get_billing_address_1();
	$billingAddress2 = $order->get_billing_address_2();
	$billingCity = $order->get_billing_city();
	$billingState = $order->get_billing_state();
	$billingPostCode = $order->get_billing_postcode();
	$billingCountry = $order->get_billing_country();
	$billingEmail = $order->get_billing_email();
	$billingPhone = $order->get_billing_phone();
	// shipping details
	$shippingFirstName = $order->get_shipping_first_name();
	$shippingLastName = $order->get_shipping_last_name();
	$shippingCompany = $order->get_shipping_company();
	$shippingAddress1 = $order->get_shipping_address_1();
	$shippingAddress2 = $order->get_shipping_address_2();
	$shippingCity = $order->get_shipping_city();
	$shippingState = $order->get_shipping_state();
	$shippingPostCode = $order->get_shipping_postcode();
	$shippingCountry = $order->get_shipping_country();
	$shippingEmail = $order->get_shipping_email();
	$shippingPhone = $order->get_shipping_phone();

	//$orderData = $order->get_data(); // Get the order data in an array

  // qr code begin
  $codeContents = site_url().'/shop-order-status/?order_id='.$latestOrderId.'&oh='.$order_hash.'&sshh='.$order_hash2;
	$qrcode = 'https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl='.$codeContents;
	// qr code end

	$orderedStoreEmail = '';
	$orderedVendorStoreName = '';
	// Loop through order items
	foreach ( $order->get_items() as $itemId => $item ) {
		// Get the product object
		$product = $item->get_product();
		// Get the product Id
		$productId = $product->get_id();

		$product_meta = get_post($product_id);
		$vendor_id = $product_meta->post_author;
		$orderProductVendor = get_wcmp_vendor($vendor_id);
		$orderedVendorStoreName = (is_object($orderProductVendor) ? ucfirst(esc_html($orderProductVendor->user_data->data->display_name)) : '');
		$orderedVendorStoreEmail = (is_object($orderProductVendor) ? ucfirst(esc_html($orderProductVendor->user_data->data->user_email)) : '');

		if(!empty($orderedVendorStoreName)){
			break;
		}
	} // end foreach

		// send email
	$body = '<div id="main-wrapper" style="max-width: 600px;margin-left:auto;margin-right:auto;border:1px solid #ddd;color: #333;">
      <div id="top-header" style="background-color: purple;">
          <h2 style="color: white; margin: 0px 30px; padding: 20px 0px;">Ny ordre fra Greeting.dk :)</h2>
      </div>
      <div id="body" style="background-color: white; padding: 30px;">
					<a href="'.$codeContents.'">
						<img src="'.$qrcode.'" alt=""/>
						Markér ordre som leveret
					</a>
					<div style="margin-top: 20px;">

					</div>
          <p>Hej, '.$orderedVendorStoreName.'</p>
          <p>Der er gået en ordre i gennem</p>
          <p style="color: purple; font-size: 20px;">[Order #'.$latestOrderId.'] ('.$orderCreateDateFormat.')</p>
          <table id="table" style="width:100%;color:#333;">
              <thead>
                <tr>
                  <th style="border: 1px solid #ddd;text-align: center;">Produkt</th>
                  <th style="border: 1px solid #ddd;text-align: center;">Antal</th>
                  <th style="border: 1px solid #ddd;text-align: center;">Pris ('.$orderCurrency.')</th>
                </tr>
              </thead>
              <tbody>';
              foreach ( $order->get_items() as $item_id => $item ){
                $body.='<tr>
                  <td style="border: 1px solid #ddd;text-align: center;">'.$item->get_name().'</td>
                  <td style="border: 1px solid #ddd;text-align: center;">'.$item->get_quantity().'</td>
                  <td style="border: 1px solid #ddd;text-align: center;">'.$item->get_subtotal().'</td>
                </tr>';
              }
               $body.='<tr>
                  <td colspan="2" style="border: 1px solid #ddd;text-align: center;"><b>Subtotal</b></td>
                  <td style="border: 1px solid #ddd;text-align: center;">'.$orderSubTotal.'</td>
                </tr>
                <tr>
                  <td colspan="2" style="border: 1px solid #ddd;text-align: center;"><b>Total</b></td>
                  <td style="border: 1px solid #ddd;text-align: center;">'.$orderTotal.'</td>
                </tr>
              </tbody>
          </table>
          <p style="color: purple; font-size: 20px;">Faktureringsadresse</p>
          <div style="border: 1px solid #ddd; padding: 15px;">
              <address>'
                  .$billingFirstName.' '.$billingLastName.'<br>'
                  .$billingCompany.'<br>'
                  .$billingAddress1.'<br>'
                  .$billingAddress2.'<br>'
                  .$billingState.'<br>'
                  .$billingCity.'<br>'
                  .$billingCountry.'<br>'
                  .$billingPhone.'<br>'
                  .$billingEmail.'
              </address>
          </div>
        <p style="color: purple; font-size: 20px;">Leveringsadresse</p>
        <div style="border: 1px solid #ddd; padding: 15px;">
            <address>'
                .$shippingFirstName.' '.$shippingLastName.'<br>'
                .$shippingCompany.'<br>'
                .$shippingAddress1.'<br>'
                .$shippingAddress2.'<br>'
                .$shippingState.'<br>'
                .$shippingCity.'<br>'
                .$shippingCountry.'<br>'
                .$shippingPhone.'<br>'
                .$shippingEmail.'
            </address>
        </div>
      </div>;
  </div>';

  // dompdf begin
  #require_once 'dompdf/autoload.inc.php'; // include autoloader
  #$dompdf = new Dompdf(); // instantiate and use the dompdf class
#  $dompdf->loadHtml($body);
	#$dompdf->setPaper('A4', 'landscape'); // (Optional) Setup the paper size and orientation
	// Render the HTML as PDF
  #$dompdf->render();
  // $dompdf->stream(); // Output the generated PDF to Browser
  //save the pdf file on the server
  #$uploadpdf = wp_upload_dir();
  #	$uploadpdf_dir = $uploadpdf['basedir'] .'/pdf-files/';
		#  $permissions = 0755;
  #$oldmask = umask(0);
  #if (!is_dir($uploadpdf_dir)) mkdir($uploadpdf_dir, $permissions);
  #$umask = umask($oldmask);
  #$chmod = chmod($uploadpdf_dir, $permissions);
  #file_put_contents($uploadpdf_dir.'/'.$latestOrderId.'.pdf', $dompdf->output());
	// dompdf end

	// attached pdf file begin
	// $filename = $latestOrderId.'.pdf';
  // $attachments = array( WP_CONTENT_DIR . '/uploads/pdf-files/'.$filename );
  // attach pdf file end

	$to = $orderedStoreEmail;
	$subject = '👋🎁 Ny bestilling på Greeting.dk';
	$attachments = '';
	$headers = array('Content-Type: text/html; charset=UTF-8'); // To send HTML formatted mail, you also can specify the Content-Type HTTP header in the $headers parameter:
	#wp_mail( $to, $subject, $body, $headers, $attachments );
};


// vendor attachment begin
#add_filter( 'woocommerce_email_attachments', 'attach_pdf_to_email', 10, 3);
function attach_pdf_to_email ( $attachments, $email_id , $order ) {

    // Avoiding errors and problems
    if ( ! is_a( $order, 'WC_Order' ) || ! isset( $email_id ) ) {
        return $attachments;
    }
	// $order_id = getLastOrderId(); // Last order ID;
    // $file_path = ABSPATH . "wp-content/uploads/pdf-files/" . $order_id . ".pdf";
    $file_path = ABSPATH . "wp-content/uploads/pdf-files/" . $order->get_id() . ".pdf";

    $attachments[] = $file_path;

    return $attachments;

}
// vendor attachment end




/**
 * Check if store delivers in the postal code
 *
 *
 *
 *
 */
add_action( 'woocommerce_after_checkout_validation', 'greeting_check_delivery_postcode', 10, 2);
function greeting_check_delivery_postcode( $fields, $errors ){
	global $wpdb, $wcmp;

	$storeProductId = 0;
	// Get $product object from Cart object
	$cart = WC()->cart->get_cart();

	foreach( $cart as $cart_item_key => $cart_item ){
		$product = $cart_item['data'];
		$storeProductId = $product->get_id();
	}

	$vendor_id = get_post_field( 'post_author', $storeProductId );
	$vendor = get_wcmp_vendor($vendor_id);

	// get vendor postal code
	// $vendorPostalCodeRow = $wpdb->get_row( "
	// 	SELECT * FROM {$wpdb->prefix}usermeta
	// 	WHERE user_id = $vendor_id
	// 	AND meta_key = '_vendor_postcode'
	// " );
	// $vendorPostalCodeBilling = $vendorPostalCodeRow->meta_value;

	// get vendor delivery zips
	$vendorDeliveryZipsRow = $wpdb->get_row( "
		SELECT * FROM {$wpdb->prefix}usermeta
		WHERE user_id = $vendor_id
		AND meta_key = 'delivery_zips'
	" );
	$vendorDeliveryZipsBilling = $vendorDeliveryZipsRow->meta_value;

	$vendorRelatedPCBillingWithoutComma = str_replace(" ","",$vendorDeliveryZipsBilling);
	$vendorRelatedPCBillingWCArray = explode(",", $vendorRelatedPCBillingWithoutComma);
	// push vendor postal code
	// $vendorRelatedPCBillingWCArray[] = $vendorPostalCodeBilling;

	$ship_postcode = $fields['shipping_postcode'];
	$findPostCodeFromArray = in_array($ship_postcode, $vendorRelatedPCBillingWCArray);

	if (!in_array($ship_postcode, $vendorRelatedPCBillingWCArray)){
		$args = array(
			'post_type' => 'city',
			'meta_query'=> array(
				array(
						'key' => 'postalcode',
						'compare' => '=',
						'value' => $ship_postcode,
						'type' => 'numeric'
				 )
			),
			'post_status' => 'publish',
			'posts_per_page' => '1'
		);
		$city = new WP_Query( $args );
		var_dump($city->posts[0]->post_title);

		if($city && $city->posts && count($city->posts) > 0){
			$errors->add( 'validation', var_dump($city).'<p style="line-height:150%;">Beklager - den valgte butik kan ikke levere til '.$city->posts[0]->post_title.'. Du kan <a href="'.$vendor->get_permalink().'">gå til butikkens side</a> og se hvilke postnumre de leverer til eller <a href="'.get_permalink($city->posts[0]->ID).'">klikke her og se butikker der leverer i postnummer '.$city->posts[0]->post_title.'</a></p>' );
		} else {
			$errors->add( 'validation', var_dump($city).'Beklager - butikken kan desværre ikke levere til det postnummer, du har indtastet under levering. Du bedes enten ændre leveringens postnummer eller gå til <a href="'.home_url().'">forsiden</a> for at finde en butik i det ønskede postnummer.' );
		}
	}
}



add_action( 'woocommerce_after_checkout_form', 'greeting_show_hide_calendar' );
function greeting_show_hide_calendar( $available_gateways ) {?>
<script type="text/javascript">

   function show_calendar( val ) {
      if ( val.match("^flat_rate") || val.match("^free_shipping") ) {
         jQuery('#show-if-shipping').fadeIn();
      } else {
         jQuery('#show-if-shipping').fadeOut();
      }
   }

   jQuery(document).ajaxComplete(function() {
       var val = jQuery('input[name^="shipping_method"]:checked').val();
      show_calendar( val );
   });

</script>

<?php
}

#add_action( 'woocommerce_checkout_process', 'greeting_validate_new_checkout_fields' );
function greeting_validate_new_checkout_fields() {
   if ( isset( $_POST['delivery_date'] ) && empty( $_POST['delivery_date'] ) ) wc_add_notice( __( 'Please select the Delivery Date' ), 'error' );
}

// Load JQuery Datepicker

add_action( 'woocommerce_after_checkout_form', 'greeting_enable_datepicker', 10 );

function greeting_enable_datepicker() { ?>
   <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
   <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
  <?php
}

// Load Calendar Dates

add_action( 'woocommerce_after_checkout_form', 'greeting_load_calendar_dates', 20 );

function greeting_load_calendar_dates( $available_gateways ) {
	// Get $product object from Cart object
	$cart = WC()->cart->get_cart();

	foreach( $cart as $cart_item_key => $cart_item ){
		$product = $cart_item['data'];
		$storeProductId = $product->get_id();
	}

	$vendor_id = get_post_field( 'post_author', $storeProductId );
	$dates = get_vendor_dates($vendor_id);
	$dates_json = json_encode($dates);
?>

   <script type="text/javascript">
      jQuery(document).ready(function($) {
         $('#datepicker').click(function() {
		  	var customMinDateVal = $('#vendorDeliverDay').val();
		  	var customMinDateValInt = parseInt(customMinDateVal);
		  	let vendorDropOffTimeVal = $('#vendorDropOffTimeId').val();
		  	let d = new Date();
		  	let hour = d.getHours();
			if(hour > vendorDropOffTimeVal){
				var customMinDateVal = customMinDateValInt+1;
			} else {
				customMinDateVal = $('#vendorDeliverDay').val();
			}
			// var vendorClosedDayArray = $('#vendorClosedDayId').val();
			var vendorClosedDayArray = <?php echo $dates_json; ?>;

			$('#datepicker').datepicker({
				dateFormat: 'dd-mm-yy',
				// minDate: -1,
				minDate: customMinDateVal,
				// maxDate: "+1M +10D"
				maxDate: "+58D",
				// closed on specific date
				beforeShowDay: function(date){
					var string = jQuery.datepicker.formatDate('dd-mm-yy', date);
					return [ vendorClosedDayArray.indexOf(string) == -1 ];
				}
			}).datepicker( "show" );
         });
      });
   </script>
   <?php
}


// Save & show date as order meta
/**
 * function to add order meta in admin
 * #add delivery_date
 *
 * @todo: Remember to add the redirect for order pages again!!!! (@line 3095)
 */
add_action( 'woocommerce_checkout_update_order_meta', 'greeting_save_custom_fields_with_order' );
function greeting_save_custom_fields_with_order( $order_id ) {
    global $woocommerce;
    if ( $_POST['delivery_date'] ) update_post_meta( $order_id, '_delivery_date', esc_attr( $_POST['delivery_date'] ) );
		if ( $_POST['greeting_message'] ) update_post_meta( $order_id, '_greeting_message', esc_attr( $_POST['greeting_message'] ) );
		if ( $_POST['receiver_phone'] ) update_post_meta( $order_id, '_receiver_phone', esc_attr( $_POST['receiver_phone'] ) );

		if ( $_POST['delivery_instructions'] ) update_post_meta( $order_id, '_delivery_instructions', esc_attr( $_POST['delivery_instructions'] ) );

		if ( $_POST['leave_gift_address'] ) update_post_meta( $order_id, '_leave_gift_address', esc_attr( $_POST['leave_gift_address'] ) );
		if ( $_POST['leave_gift_neighbour'] ) update_post_meta( $order_id, '_leave_gift_neighbour', esc_attr( $_POST['leave_gift_neighbour'] ) );


		// -----------------------
		// Get data from child order.
		$order = wc_get_order( $order_id );
		foreach ($order->get_items() as $item_key => $item) {
			$product = get_post($item['product_id']);
			$vendor_id = $product->post_author;

			if(!empty($vendor_id)){
				update_post_meta($order_id, '_vendor_id', $vendor_id);
				break;
			}
		}

		#$child_order = new WP_Query(array('post_parent' => $order_id));
		#while($child_order->have_posts()){
		#	$child_order->the_post();
		#	$child_order_id = get_the_ID();

		#	$vendor_id = get_post_meta($child_order_id, '_vendor_id', true);
			// Add vendor ID to the main order.
		#	if ( $vendor_id ) update_post_meta( $order_id, '_vendor_id', $vendor_id );


			// -----------------------
			// Add data to the child order, so meta data is visible.
		#	if ( $_POST['delivery_date'] ) update_post_meta( $child_order_id, '_delivery_date', esc_attr( $_POST['delivery_date'] ) );
		#	if ( $_POST['greeting_message'] ) update_post_meta( $child_order_id, '_greeting_message', esc_attr( $_POST['greeting_message'] ) );
		#	if ( $_POST['receiver_phone'] ) update_post_meta( $child_order_id, '_receiver_phone', esc_attr( $_POST['receiver_phone'] ) );

		#	if ( $_POST['delivery_instructions'] ) update_post_meta( $child_order_id, '_delivery_instructions', esc_attr( $_POST['delivery_instructions'] ) );

		#	if ( $_POST['leave_gift_address'] ) update_post_meta( $child_order_id, '_leave_gift_address', esc_attr( $_POST['leave_gift_address'] ) );
		#	if ( $_POST['leave_gift_neighbour'] ) update_post_meta( $child_order_id, '_leave_gift_neighbour', esc_attr( $_POST['leave_gift_neighbour'] ) );
	#	}
}

add_action( 'wcmp_checkout_vendor_order_processed' , 'update_sub_order_meta' ,10 , 3);
function update_sub_order_meta($vendor_order_id, $posted_data, $order){
	global $WCMp;

	$vendor_order = wc_get_order($vendor_order_id);
	$vendor_id = get_post_meta($vendor_order_id, '_vendor_id', true);
}

/* replace suborder id with parent order id in email */
#add_filter('wcmp_vendor_new_order_email_subject', 'change_order_number', 10, 2);
function change_order_number($subject, $order) {
#$order_id = wp_get_post_parent_id($order->get_id());
#return __(‘[{site_title}] New vendor order (‘.$order_id.’) – {order_date}’, ‘dc-woocommerce-multi-vendor’);
}
/* replace suborder id with parent order id in vendor dashboard */
#add_filter('wcmp_datatable_order_list_row_data', 'change_order_number_dashboard');
function change_order_number_dashboard($data) {
  #$order_id = wp_get_post_parent_id($data['order_id']);
  #$data['order_id'] = $order_id;
  #return $data;
}



add_action( 'woocommerce_admin_order_data_after_billing_address', 'greeting_delivery_date_display_admin_order_meta' );
function greeting_delivery_date_display_admin_order_meta( $order ) {
   $str = '<p><strong>Leveringsdato:</strong> ';
	 if ( !empty(get_post_meta( $order->get_id(), '_delivery_date', true )) ) { $str .= get_post_meta( $order->get_id(), '_delivery_date', true ); } else { $str .= 'Hurtigst muligt'; }
	 $str .= '</p>';
	 $str .= '<p><strong>Modtagers telefonnr.:</strong> ' . get_post_meta( $order->get_id(), '_receiver_phone', true ) . '</p>';
	 $str .= '<p><strong>Besked til modtager:</strong> ' . get_post_meta( $order->get_id(), '_greeting_message', true ) . '</p>';


	 $str .= '<p><strong>Leveringsinstruktioner:</strong> ' . get_post_meta( $order->get_id(), '_delivery_instructions', true ) . '</p>';
	 $leave_gift_at_address = (get_post_meta( $order->get_id(), '_leave_gift_address', true ) == "1" ? 'Ja' : 'Nej');
	 $str .= '<p><strong>Må gaven stilles på adressen:</strong> ' . $leave_gift_at_address . '</p>';
	 $leave_gift_at_neighbour = (get_post_meta( $order->get_id(), '_leave_gift_neighbour', true ) == "1" ? 'Ja' : 'Nej');
	 $str .= '<p><strong>Må gaven afleveres hos naboen:</strong> ' . $leave_gift_at_neighbour . '</p>';

	 echo $str;
}

// show order date in thank you page
// @todo - $order is not defined. Therefore we should not try to access object, just use function variable.
add_action( 'woocommerce_thankyou', 'greeting_view_order_and_thankyou_page', 20 );
function greeting_view_order_and_thankyou_page( $order_id ){
    global $order;

    if( empty($order_id) || !is_numeric($order_id)){
        $order_id = $order->get_id();
    }

	$str = '<p><strong>Leveringsdato:</strong> ';
	if ( $_POST['delivery_date'] ) { $str .= get_post_meta( $order_id, '_delivery_date', true ); } else { $str .= 'Hurtigst muligt'; }
	$str .= '</p>';
	$str .= '<p><strong>Modtagers telefonnr.:</strong> ' . get_post_meta( $order_id, '_receiver_phone', true ) . '</p>';
	$str .= '<p><strong>Besked til modtager:</strong> ' . get_post_meta( $order_id, '_greeting_message', true ) . '</p>';
	$str .= '<p><strong>Leveringsinstruktioner:</strong> ' . get_post_meta( $order_id, '_delivery_instructions', true ) . '</p>';

	$leave_gift_at_address = (get_post_meta( $order_id, '_leave_gift_address', true ) == "1" ? 'Ja' : 'Nej');
	$str .= '<p><strong>Må gaven stilles på adressen:</strong> ' . $leave_gift_at_address . '</p>';
	$leave_gift_at_neighbour = (get_post_meta( $order_id, '_leave_gift_neighbour', true ) == "1" ? 'Ja' : 'Nej');
	$str .= '<p><strong>Må gaven afleveres hos naboen:</strong> ' . $leave_gift_at_neighbour . '</p>';

	echo $str;
}

// Add custom order meta data to make it accessible in Order preview template
add_filter( 'woocommerce_admin_order_preview_get_order_details', 'admin_order_preview_add_custom_meta_data', 10, 2 );
function admin_order_preview_add_custom_meta_data( $data, $order ) {
    if( $delivery_date_value = $order->get_meta('_delivery_date') ){
        $data['delivery_date_key'] = $delivery_date_value; // <= Store the value in the data array.
		}
		if( $receiver_phone = $order->get_meta('_receiver_phone') ){
        $data['receiver_phone_key'] = $receiver_phone; // <= Store the value in the data array.
		}

		if( $greeting_message = $order->get_meta('_greeting_message') ){
        $data['greeting_message_key'] = $greeting_message; // <= Store the value in the data array.
		}

		if( $leave_gift_address = $order->get_meta('_leave_gift_address') ){
				$leave_gift_address = ($leave_gift_address == "1" ? 'Ja' : 'Nej');
        $data['leave_gift_address_key'] = $leave_gift_address; // <= Store the value in the data array.
		}
		if( $leave_gift_neighbour = $order->get_meta('_leave_gift_neighbour') ){
				$leave_gift_neighbour = ($leave_gift_neighbour == "1" ? 'Ja' : 'Nej');
        $data['leave_gift_neighbour_key'] = $leave_gift_neighbour; // <= Store the value in the data array.
		}

		if( $delivery_instructions = $order->get_meta('_delivery_instructions') ){
        $data['delivery_instructions_key'] = $delivery_instructions; // <= Store the value in the data array.
		}
    return $data;
}

// Display order date in admin order preview
add_action( 'woocommerce_admin_order_preview_start', 'custom_display_order_data_in_admin' );
function custom_display_order_data_in_admin(){
    // Call the stored value and display it
    $str = '<div style="margin:15px 0px 0px 15px;"><strong>Leveringsdato:</strong> {{data.delivery_date_key}}</div>';
		$str .= '<div style="margin:15px 0px 0px 15px;"><strong>Modtagers telefonnr.:</strong> {{data.receiver_phone_key}}</div>';

		$str .= '<div style="margin:15px 0px 0px 15px;"><strong>Besked til modtager:</strong> {{data.greeting_message_key}}</div>';
		$str .= '<div style="margin:15px 0px 0px 15px;"><strong>Leveringsinstruktioner:</strong> {{data.delivery_instructions_key}}</div>';


		$str .= '<div style="margin:15px 0px 0px 15px;"><strong>Gaven må efterlades på adressen:</strong> {{data.leave_gift_address_key}}</div>';

		$str .= '<div style="margin:15px 0px 0px 15px;"><strong>Gaven må afleveres til naboen:</strong> {{data.leave_gift_neighbour_key}}</div>';
}


/**
 * Add a custom field (in an order) to the emails
 *
 * @since v1.0
 * @author Dennis
 */
add_filter( 'woocommerce_email_order_meta_fields', 'custom_woocommerce_email_order_meta_fields', 10, 3 );

function custom_woocommerce_email_order_meta_fields( $fields, $sent_to_admin, $order ) {
		$del_date = get_post_meta( $order->get_id(), '_delivery_date', true );
    $delivery_date = (!empty($del_date) ? $del_date : 'Hurtigst muligt');
    $fields['delivery_date'] = array(
        'label' => __( 'Leveringsdato' ),
        'value' => $delivery_date,
    );
		$fields['billing_phone'] = array(
        'label' => __( 'Afsenders telefonnr.' ),
        'value' => get_post_meta( $order->get_id(), '_billing_phone', true ),
    );


    $fields['greeting_message'] = array(
        'label' => __( 'Besked til modtager' ),
        'value' => get_post_meta( $order->get_id(), '_greeting_message', true ),
    );


    $leave_gift_at_address = (get_post_meta( $order->get_id(), '_leave_gift_address', true ) == "1" ? 'Ja' : 'Nej');
    $fields['leave_gift_address'] = array(
        'label' => __( 'Efterlad gaven på adressen' ),
        'value' => $leave_gift_at_address
    );
		$leave_gift_at_neighbour = (get_post_meta( $order->get_id(), '_leave_gift_neighbour', true ) == "1" ? 'Ja' : 'Nej');
		$fields['leave_gift_neighbour'] = array(
        'label' => __( 'Gaven må afleveres til naboen' ),
        'value' => $leave_gift_at_neighbour
    );
		$fields['delivery_instructions'] = array(
        'label' => __( 'Leveringsinstruktioner' ),
        'value' => get_post_meta( $order->get_id(), '_delivery_instructions', true ),
    );
		$fields['receiver_phone'] = array(
        'label' => __( 'Modtagers telefonnr.' ),
        'value' => get_post_meta( $order->get_id(), '_receiver_phone', true ),
    );

    return $fields;
}

#do_action('wcmp_checkout_vendor_order_processed', $vendor_order_id, $posted_data, $order);



/**
 * Function for adding extra fee in checkout.
 * if e.g. there is a larger message available.
 *
 * @author Dennis
 * @since v1.0
 */
#add_action( 'woocommerce_cart_calculate_fees', 'checkout_message_fee', 20, 1 );
function checkout_message_fee( $cart ) {
    if ( $radio2 = WC()->session->get( 'message-pro' ) ) {
        $cart->add_fee( 'Message Fee', $radio2 );
    }
}

add_action( 'woocommerce_checkout_update_order_review', 'checkout_message_choice_to_session' );
function checkout_message_choice_to_session( $posted_data ) {
    parse_str( $posted_data, $output );
    if ( isset( $output['message-pro'] ) ){
        WC()->session->set( 'message-pro', $output['message-pro'] );
    }
}

/**
*
* Function for the greeting text / greeting message
* #greeting_text #greeting_meesage
*
*
*/
add_action( 'woocommerce_after_checkout_validation', 'greeting_validate_new_receiver_info_fields', 10, 2 );
function greeting_validate_new_receiver_info_fields($fields, $errors) {
	global $woocommerce;

	#if ( isset($_POST['receiver_phone']) && (empty($_POST['receiver_phone']) || !preg_match('/^[0-9\s\+]{8,15}$/', trim($_POST['receiver_phone']))) ){
	#	$errors->add(
	#		'validation',
	#		__('Indtast et gyldigt telefonnummer til modtager i step 3  (8 cifre, uden mellemrum og landekode), så vi kan kontakte vedkommende ved evt. spørgsmål om levering. Klik på "Gennmfør bestilling" når du har rettet telefonnummeret.','greeting2')
	#	);
	#}
	if ( isset($_POST['greeting_message']) && empty($_POST['greeting_message']) ){
		$errors->add(
			'validation',
			__( 'Please enter greeting message', 'greeting2')
		);
	}
	//if ($_POST['message-pro'] == "0" && (strlen($_POST['greeting_message']) > 165)){
	if(strlen($_POST['greeting_message']) > 165){
		$errors->add(
			'validation',
			__( 'Standard package accept only 165 Character', 'greeting2')
		);
	}

	$cart = WC()->cart->get_cart();

	$age_restricted_items_in_cart = false;
	foreach( $cart as $cart_item_key => $cart_item ){
		$product = $cart_item['data'];
		$storeProductId = $product->get_id();

		$product_id = $cart_item['product_id'];
		$shop_id = get_post_meta($product_id, 'shop', true);

		$product_alchohol = get_post_meta($product_id, 'alcohol', true);
		if($product_alchohol){
			$age_restricted_items_in_cart = true;
		}
	}

	if($age_restricted_items_in_cart){
		if(!isset($_POST['age_restriction'])) {
			$errors->add('age-restriction', esc_html__('Please confirm that you\'re 18+ years old.', 'greeting-marketplace'));
		}
	}

}


//  Save & show date as order meta
add_action( 'woocommerce_checkout_update_order_meta', 'greeting_save_receiver_info_with_order' );

function greeting_save_receiver_info_with_order( $order_id ) {
    global $woocommerce;

    if ( $_POST['receiver_phone'] ) update_post_meta( $order_id, 'receiver_phone', esc_attr( $_POST['receiver_phone'] ) );
}

add_action( 'woocommerce_admin_order_data_after_billing_address', 'greeting_receiver_info_display_admin_order_meta' );

function greeting_receiver_info_display_admin_order_meta( $order ) {

   echo '<p><strong>Receiver Phone:</strong> ' . get_post_meta( $order->get_id(), 'receiver_phone', true ) . '</p>';

}

// show order date in thank you page
add_action( 'woocommerce_thankyou', 'greeting_view_order_and_receiver_info_thankyou_page', 20 );

function greeting_view_order_and_receiver_info_thankyou_page( $order_id ){  ?>
    <?php echo '<p><strong>'.__('Receiver phone','greeting2').':</strong> ' . get_post_meta( $order_id, 'receiver_phone', true ) . '</p>';
}

// Add custom order meta data to make it accessible in Order preview template
add_filter( 'woocommerce_admin_order_preview_get_order_details', 'admin_order_preview_add_receiver_info_custom_meta_data', 10, 2 );

function admin_order_preview_add_receiver_info_custom_meta_data( $data, $order ) {
    if( $receiver_info_value = $order->get_meta('receiver_phone') )
        $data['receiver_info_key'] = $receiver_info_value; // <= Store the value in the data array.
    	return $data;
}

// Display order date in admin order preview
add_action( 'woocommerce_admin_order_preview_start', 'custom_display_order_receiver_info_data_in_admin' );

function custom_display_order_receiver_info_data_in_admin(){
    // Call the stored value and display it
    echo '<div style="margin:5px 0px 0px 15px;"><strong>Receiver Info:</strong> {{data.receiver_info_key}}</div>';
}

// Display receiver info in vendor dashboard  order preview
// add_action( 'wcmp_vendor_dashboard_content', 'vendor_custom_display_order_receiver_info_data_in_admin' );
// function vendor_custom_display_order_receiver_info_data_in_admin(){
//     echo '<p style="text-align:center"><strong>Receiver Info:</strong> test action hook</p>';
// }


/** packaging fee begin */

#add_action( 'woocommerce_review_order_before_order_total', 'checkout_packaging_radio_buttons' );

function checkout_packaging_radio_buttons() {

    echo '<div class="packaging-radio">
        <div>'.__("Packaging Options").'</div><div>';

	$chosen = WC()->session->get( 'packaging' );
    $chosen = empty( $chosen ) ? WC()->checkout->get_value( 'packaging' ) : $chosen;
    $chosen = empty( $chosen ) ? '0' : $chosen;

    woocommerce_form_field( 'packaging',  array(
        'type'      => 'radio',
        'class'     => array( 'form-row-wide', 'update_totals_on_change' ),
        'options'   => array(
            '5'  => 'Premium Packaging: (+5 kr.)',
            '0'     => 'Standard Packaging',
        ),
    ), $chosen );

    echo '</div></div>';
}

#add_action( 'woocommerce_cart_calculate_fees', 'checkout_packaging_fee', 20, 1 );
function checkout_packaging_fee( $cart ) {
    if ( $radio = WC()->session->get( 'packaging' ) ) {
        $cart->add_fee( 'Packaging Fee', $radio );
    }
}


#add_action( 'woocommerce_checkout_update_order_review', 'checkout_packaging_choice_to_session' );
function checkout_packaging_choice_to_session( $posted_data ) {
    parse_str( $posted_data, $output );
    if ( isset( $output['packaging'] ) ){
        WC()->session->set( 'packaging', $output['packaging'] );
    }
}

/** redirect pages for restricted page */
function redirect_direct_access( ) {
    $currentUrl = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    if ( $currentUrl == home_url().'/dashboard/transaction-details/' ) {
        $redirectUrl = home_url().'/'.'dashboard/';
        wp_redirect($redirectUrl);
        exit();
    }
}

add_action( 'template_redirect', 'redirect_direct_access' );


/**
 * Shop only one store same time
 */

//  add_action('init', 'greeting_shop_only_one_store_same_time');
add_action('wp_loaded', 'greeting_shop_only_one_store_same_time');

function greeting_shop_only_one_store_same_time() {
	$single_vendor = 0;
	$last_inserted_vendor_id = null;
	$vendor_id_array = array();

	// check is woocommerce installed and active?
	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		// Yes, WooCommerce is enabled
		if(!empty(WC()->cart) && !is_admin()){
			$cart_data = WC()->cart->get_cart();
			$length = count($cart_data);
			foreach ($cart_data as $cart_item_key => $cart_item) {
				$product_id = $cart_item['product_id'];
				$vendor_data = get_wcmp_product_vendors($product_id);
				if(is_object($vendor_data)){
					$vendor_id = $vendor_data->user_data->ID;
					$vendor_id_array[] = $vendor_id;
				}
			}
		}
	} else {
		// WooCommerce is NOT enabled!
		return;
	}

	// check array is unique or not
	if(!empty($vendor_id_array) && count(array_unique($vendor_id_array)) > 1) {
		// remove actions
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
		remove_action('woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20);
		// add actions
		add_action( 'after_wcmp_vendor_description', 'show_shop_only_one_store_same_time_notice', 5 );
		add_action( 'woocommerce_before_single_product', 'show_shop_only_one_store_same_time_notice', 5 );
		add_action('woocommerce_before_cart', 'show_shop_only_one_store_same_time_notice', 5);
		add_action('woocommerce_before_checkout_form', 'show_shop_only_one_store_same_time_notice', 5);
		// add filter for hide 'place order' button
		add_filter( 'woocommerce_order_button_html', 'greeting_custom_button_html' );
		function greeting_custom_button_html( $button_html ) {
			$button_html = '';
			return $button_html;
		}
	}
}

/**
 *
 * The notice when someone shops in more than one store.
 * Should be localized and danish
 * @todo Dennis - translate
 * @todo Dennis - set up with localization.
 */
// show shop only one store same time notice
function show_shop_only_one_store_same_time_notice(){
	$notice = 'Øv - vi kan se, du har produkter fra flere butikker i kurven. Du kan på nuværende tidspunkt kun handle i én butik ad gangen. Gå til kurven og sørg for, der kun er produkter fra én butik i kurven, før du kan gennemføre';
	wc_print_notice($notice, 'error');
}

/**
* @author Dennis Lauritzen
* Remove report abuse link
*
*/
add_filter('wcmp_show_report_abuse_link', '__return_false');

/**
 * Trigger Holiday Mode
 */
// add_action ('init', 'greeting_woocommerce_holiday_mode');
function greeting_woocommerce_holiday_mode() {

	// $get_option = get_option( 'mb-bhi-settings' );
	// $open_status = $get_option['openline'];
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
	remove_action( 'woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20 );
	remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
	add_action( 'woocommerce_before_main_content', 'greeting_wc_shop_disabled', 5 );
	add_action( 'woocommerce_before_cart', 'greeting_wc_shop_disabled', 5 );
	add_action( 'woocommerce_before_checkout_form', 'greeting_wc_shop_disabled', 5 );
}

// Show Holiday Notice
function greeting_wc_shop_disabled() {
    wc_print_notice( 'Our Online Shop is Closed Today :)', 'error');
}

add_action( 'woocommerce_single_product_summary', 'reorder_product_page_hooks', 1 );
function reorder_product_page_hooks(){
	remove_action('woocommerce_single_product_summary','woocommerce_template_single_rating', 10);
	remove_action('woocommerce_single_product_summary','woocommerce_template_single_excerpt', 20);
	remove_action('woocommerce_single_product_summary','woocommerce_template_single_price', 10);
	remove_action('woocommerce_single_product_summary','woocommerce_template_single_add_to_cart', 30);
	remove_action('woocommerce_single_product_summary','woocommerce_template_single_meta', 40);
	remove_action('woocommerce_single_product_summary','woocommerce_template_single_sharing', 50);

	add_action('woocommerce_single_product_summary','woocommerce_template_single_title', 5);
	add_action('woocommerce_single_product_summary','woocommerce_template_single_price', 10);
	add_action('woocommerce_single_product_summary','woocommerce_template_single_excerpt', 15);
	add_action('woocommerce_single_product_summary','woocommerce_template_single_add_to_cart', 20);
}


add_action( 'woocommerce_after_single_product_summary', 'reorder_product_page_after_product_hooks', 1 );
function reorder_product_page_after_product_hooks(){
	remove_action('woocommerce_after_single_product_summary','woocommerce_output_product_data_tabs', 10);
	remove_action('woocommerce_after_single_product_summary','woocommerce_upsell_display', 15);
	remove_action('woocommerce_after_single_product_summary','woocommerce_output_related_products', 20);

	add_action('woocommerce_after_single_product_summary','add_vendor_info_to_product_page', 5);
	add_action('woocommerce_after_single_product_summary','woocommerce_output_related_products', 10);
}
function add_vendor_info_to_product_page(){
		wc_get_template( 'single-product/vendor-information.php' );
}

add_filter( 'woocommerce_get_price_html', 'change_variable_products_price_display', 10, 2 );
function change_variable_products_price_display( $price, $product ) {
    // Only for variable products type
    if( ! $product->is_type('variable') ) return $price;

    $prices = $product->get_variation_prices( true );

    if ( empty( $prices['price'] ) )
        return apply_filters( 'woocommerce_variable_empty_price_html', '', $product );

    $min_price = current( $prices['price'] );
    $max_price = end( $prices['price'] );
    $prefix_html = '<span class="price-prefix">' . __('Fra ') . '</span>';

    $prefix = $min_price !== $max_price ? $prefix_html : ''; // HERE the prefix

    return apply_filters( 'woocommerce_variable_price_html', $prefix . wc_price( $min_price ) . $product->get_price_suffix(), $product );
}

/**
 *
 *	Change currency symbol for danish goods.
 *
 */
function greeting_change_dk_currency_symbol( $currency_symbol, $currency ) {
    switch( $currency ) {
        // DKK til kr
        case 'DKK': $currency_symbol = 'kr.'; break;
    }
    return $currency_symbol;
}
add_filter('woocommerce_currency_symbol', 'greeting_change_dk_currency_symbol', 10, 2);


add_filter( 'woocommerce_variation_option_name','display_price_in_variation_option_name');
function display_price_in_variation_option_name( $term ) {
    global $product;

    if(empty($term)){ return $term;  }
		if(empty($product->id)){ return $term; }

    $product_id = (!empty($product->id) ? $product->id : '');
    if ( empty( $product_id ) ) { return $term; }

    $variation_id = $product->get_children();

    foreach ( $variation_id as $id ) {
        $_product       = new WC_Product_Variation( $id );
        $variation_data = $_product->get_variation_attributes();

        foreach ( $variation_data as $key => $data ) {
            if ( $data == $term ) {
							$html = ( $_product->get_stock_quantity() ) ? ' - ' . $_product->get_stock_quantity() : '';
							$html .= $term . ' - ';
              $html .= wp_kses( woocommerce_price( $_product->get_price() ), array() );

              return $html;
            }
        }
    }

    return $term;
}

/**
 *
 * Add javascript and some styles to header only on cart page
 * for qty updates
 *
 * @author Dennis Lauritzen
 */

add_action( 'wp_footer', 'add_javascript_on_cart_page', 9999 );
function add_javascript_on_cart_page() {
?>
		 <style type="text/css">
		 .woocommerce button[name="update_cart"],
		 .woocommerce input[name="update_cart"] {
			 display: none;
		 }
		 </style>
		 <script type="text/javascript">
		 var timeout;
		 jQuery('.woocommerce').on('change', 'input.input-qty', function(){
				 if ( timeout !== undefined ) {
						 clearTimeout( timeout );
				 }
				 timeout = setTimeout(function() {
						 jQuery("[name='update_cart']").removeAttr("disabled");
						 jQuery("[name='update_cart']").trigger("click");
				 }, 1000 ); // 1 second delay, half a second (500) seems comfortable too
		 });

		 jQuery('.woocommerce').on('click', 'button.plus-qty', function(){
				 if ( timeout !== undefined ) {
						 clearTimeout( timeout );
				 }
				 timeout = setTimeout(function() {
						 jQuery("[name='update_cart']").removeAttr("disabled");
						 jQuery("[name='update_cart']").trigger("click");
				 }, 1000 ); // 1 second delay, half a second (500) seems comfortable too
		 });

		 jQuery('.woocommerce').on('click', 'button.minus-qty', function(){
				 if ( timeout !== undefined ) {
						 clearTimeout( timeout );
				 }
				 timeout = setTimeout(function() {
						 jQuery("[name='update_cart']").removeAttr("disabled");
						 jQuery("[name='update_cart']").trigger("click");
				 }, 1000 ); // 1 second delay, half a second (500) seems comfortable too
		 });
		 </script>
<?php
}

/**
 *
 * Add update javascript for quantity buttons in footer.
 *
 * @author Dennis Lauritzen
 */
 add_action( 'wp_footer', 'add_quantity_plus_and_minus_in_footer', 9999 );
function add_quantity_plus_and_minus_in_footer(){
	?>
	<script type="text/javascript">
		function incrementValue(e) {
			e.preventDefault();
			var fieldName = jQuery(e.target).data('field');
			var parent = jQuery(e.target).closest('div');
			var currentVal = parseInt(parent.find('input#' + fieldName).val(), 10);

			if (!isNaN(currentVal)) {
					parent.find('input#' + fieldName).val(currentVal + 1);
			} else {
					parent.find('input#' + fieldName).val(0);
			}
		}

		function decrementValue(e) {
				e.preventDefault();
				var fieldName = jQuery(e.target).data('field');
				var parent = jQuery(e.target).closest('div');
				var currentVal = parseInt(parent.find('input#' + fieldName).val(), 10);

				if (!isNaN(currentVal) && currentVal > 0) {
						parent.find('input#' + fieldName).val(currentVal - 1);
				} else {
						parent.find('input#' + fieldName).val(0);
				}
		}

		jQuery('.woocommerce').on('click', '.plus-qty', function(e) {
				incrementValue(e);
		});

		jQuery('.woocommerce').on('click', '.minus-qty', function(e) {
				decrementValue(e);
		});
	</script>
	<?php
}

/**
 * Add New Custom Step
 * @param array $fields
 * return array
 */

function argmcAddNewSteps($fields) {
	//Add First Step
	$position = 6;     //Set Step Position
	$fields['steps'] = array_slice($fields['steps'] , 0, $position - 1, true) +
            array(
                'step_6' => array(
                    'text'  => __('Hilsen & leveringsdato', 'argMC'),     //"Tab Name" - Set First Tab Name
                    'class' => 'greeting-message'             //'my-custom-step' - Set First Tab Class Name
                ),
            ) +
            array_slice($fields['steps'], $position - 1, count($fields['steps']) - 1, true);



	return $fields;

}
add_filter('arg-mc-init-options', 'argmcAddNewSteps');



/** Receiver info and message begin */
#add_action( 'woocommerce_before_order_notes', 'greeting_echo_receiver_info' );
function greeting_echo_receiver_info( ) {

	echo '<div>';

		echo '<h3>Din hilsen til modtager</h3>';

		#$chosenMessage = WC()->session->get( 'message-pro' );
		#$chosenMessage = empty( $chosenMessage ) ? WC()->checkout->get_value( 'message-pro' ) : $chosenMessage;
		#$chosenMessage = empty( $chosenMessage ) ? '0' : $chosenMessage;

		#woocommerce_form_field( 'message-pro',  array(
		#	'type'      => 'radio',
		#	'label'			=> 'Hvor lang er din hilsen?',
		#	'class'     => array( 'form-row-wide', 'update_totals_on_change' ),
		#	'label_class' =>	array('form-row-label'),
		#	'options'   => array(
		#		'0'				=> 'Standardhilsen, håndskrevet (op til 165 tegn)',
		#		'4'				=> 'Lang hilsen, håndkrevet (op til 400 tegn), +10 kr.'
		#	),
		#), $chosenMessage );

		// @todo - If message-pro == 4, then this should be allowed to be 400 characters.
		woocommerce_form_field( 'greeting_message', array(
			'type'				=> 'textarea',
			'id'					=> 'greetingMessage',
			'class'				=> array('form-row-wide'),
			'required'		=> true,
			'label'				=> __('Din hilsen til modtager (max 160 tegn)', 'greeting2'),
			'placeholder'	=> __('Skriv din hilsen til din modtager her :)', 'greeting2'),
			'maxlength' 	=> 160
		), WC()->checkout->get_value( 'greeting_message' ) );

		woocommerce_form_field( 'receiver_phone', array(
			'type'          => 'tel',
			'class'         => array('form-row-wide', 'greeting-custom-input'),
			'input_class'		=> array('input-text validate[required] validate[custom[phone]'),
			'required'      => true,
			'label'         => __('Modtagerens telefonnr.', 'greeting2'),
			'placeholder'       => __('Indtast modtagerens telefonnummer.', 'greeting2'),
			), WC()->checkout->get_value( 'receiver_phone' ));
		#echo '<tr class="message-pro-radio"><td>';

		echo '<h3>Leveringsinstruktioner</h3>';


		woocommerce_form_field( 'leave_gift_address', array(
			'type'				=> 'checkbox',
			'id'					=> 'deliveryLeaveGiftAddress',
			'class'				=> array('form-row-wide'),
			'label'				=> __('Ja, gaven må efterlades på adressen', 'greeting2'),
			'placeholder'	=> ''
		),  1 );


		woocommerce_form_field( 'leave_gift_neighbour', array(
			'type'				=> 'checkbox',
			'id'					=> 'deliveryLeaveGiftNeighbour',
			'class'				=> array('form-row-wide'),
			'label'				=> __('Ja, gaven må afleveres til/hos naboen', 'greeting2'),
			'placeholder'	=> ''
		), 0 );

		woocommerce_form_field( 'delivery_instructions', array(
			'type'				=> 'textarea',
			'id'					=> 'deliveryInstructions',
			'class'				=> array('form-row-wide'),
			'label'				=> __('Leveringsinstruktioner', 'greeting2'),
			'placeholder'	=> __('Har du særlige instruktioner til leveringen? Eks. en dørkode, særlige forhold på leveringsadressen, en dato hvor gaven må åbnes eller lignende? Notér dem her :)', 'greeting2')
		), WC()->checkout->get_value( 'delivery_instructions' ) );

	// Insert the delivery date area
	greeting_echo_date_picker();

	echo '</div>';
}

function get_vendor_delivery_days_required($vendor_id){
	global $wpdb;

	// get vendor delivery day
	$vendorDeliveryDay = $wpdb->get_row( "
		SELECT * FROM {$wpdb->prefix}usermeta
		WHERE user_id = $vendor_id
		AND meta_key = 'vendor_require_delivery_day'
	" );
	return $vendorDeliveryDay->meta_value;
}

function get_vendor_closed_dates($vendor_id){
	global $wpdb;
	// get vendor closed day
	$vendorClosedDayRow = $wpdb->get_row( "
		SELECT * FROM {$wpdb->prefix}usermeta
		WHERE user_id = $vendor_id
		AND meta_key = 'vendor_closed_day'
	" );

	return $vendorClosedDayRow->meta_value;
}

function get_vendor_dropoff_time($vendor_id){
	global $wpdb;
	// get vendor drop off time
	$vendorDropOffTimeRow = $wpdb->get_row( "
		SELECT * FROM {$wpdb->prefix}usermeta
		WHERE user_id = $vendor_id
		AND meta_key = 'vendor_drop_off_time'
	" );

	return $vendorDropOffTimeRow->meta_value;
}


/**
 * Function to get all closed dates calculated
 * from opening days, closed dates etc.
 *
 * @author Dennis
 */
function get_vendor_dates($vendor_id, $date_format = 'd-m-Y', $open_close = 'close'){
	global $wpdb;

	$closed_days_date = array();

	$vendorDropOffTime = get_vendor_dropoff_time($vendor_id);
	$vendorDeliverDayReq = get_vendor_delivery_days_required($vendor_id);

	// @todo - Dennis update according to latest updates in closing day-field.
	// open close days begin
	$default_days = ['1','2','3','4','5','6','7'];
	$openning_days = get_user_meta($vendor_id, 'openning', true); // true for not array return
	if(is_array($openning_days)){
		$closed_days = array_diff($default_days, $openning_days);
	} else {
		$closed_days = $default_days;
	}

	$open_days = array();
	$dates = array();
	$today = new DateTime('now');

	// Loop through the closed dates from admin.
	$meta_closed_days = get_user_meta($vendor_id, 'vendor_closed_day', true);
	$closed_days_date = (!empty($meta_closed_days) ? explode(",",$meta_closed_days) : array());
	$closed_dates_arr = array();

	if(!empty($closed_days_date)){
		foreach($closed_days_date as $ok_date){
			$date_time_object = new DateTime(trim($ok_date));
			if($date_time_object > $today){
				$closed_dates_arr[] = $date_time_object->format($date_format);
			}
		}
	}

	// Generate array of all open days next 60 days.
	$open_num = 0;
	$closed_num = 0;
	for($i=0;$i<60;$i++){
		$now = new DateTime('now');
		$now->modify('+'.$vendorDeliverDayReq.' days');
		if(!in_array($today->format('N'), $closed_days) && !in_array($today->format($date_format),$closed_dates_arr)){

			if($now->format('H') > $vendorDropOffTime && $i == 0){
				$open_num--;
			} else {
				$open_num++;
			}

			if($open_num >= $vendorDeliverDayReq){
				$dates[] = $today->format($date_format);
			} else {
				$closed_days_date[] = $today->format($date_format);
			}
		} else {
			$closed_num++;
			$closed_days_date[] = $today->format($date_format);
		}
		$today->modify('+1 day');
	}

	if($open_close == 'close'){
		return $closed_days_date;
	} else {
		return $dates;
	}
}

/**
 * @author amdad
 * Functions for setting the order delivery date.
 * On step 3 in checkout.
 *
 * order date begin
 */
# add_action( 'woocommerce_review_order_before_payment', 'greeting_echo_date_picker' );
function greeting_echo_date_picker(  ) {
	$storeProductId = '';
	// Get $product object from Cart object
	$cart = WC()->cart->get_cart();

	foreach( $cart as $cart_item_key => $cart_item ){
		$product = $cart_item['data'];
		$storeProductId = $product->get_id();
	}

	// Get vendor ID.
	$vendor_id = get_post_field( 'post_author', $storeProductId );

	// Get delivery type.
	$del_type = '';
	$del_value = '';
	if(!empty(get_field('delivery_type', 'user_'.$vendor_id))){
	  $delivery_type = get_field('delivery_type', 'user_'.$vendor_id)[0];

	  if(empty($delivery_type['label'])){
	    $del_value = $delivery_type;
	    $del_type = $delivery_type;
	  } else {
	    $del_value = $delivery_type['value'];
	    $del_type = $delivery_type['label'];
	  }
	}

	// Get delivery day requirement, cut-off-time for orders and the closed dates.
	$vendorDeliverDayReq = get_vendor_delivery_days_required($vendor_id);
	$vendorDropOffTime = get_vendor_dropoff_time($vendor_id);
	$closed_dates_arr = explode(",",get_vendor_closed_dates($vendor_id));



	if($del_value == '0'){
		echo '<h3 class="pt-4">Leveringsdato</h3>';
		echo '<p>';
		echo 'Da du bestiller fra en butik, der sender varerne med fragtfirma, kan du ikke vælge en leveringsdato. ';
		echo 'Varen sendes hurtigst muligt - og hvis gaven først må åbnes på en bestemt dag, så kan du notere det oven for i leveringsintruktionerne';
		echo '</p>';
	} else {
		echo '<h3 class="pt-4">Leveringsdato</h3>';
		echo '<script>';
		echo 'jQuery("#datepicker").prop("readonly", true).prop("disabled","disabled");';
		echo '</script>';
		woocommerce_form_field( 'delivery_date', array(
			'type'          => 'text',
			'class'         => array('form-row-wide'),
			'id'            => 'datepicker',
			'required'      => false,
			'label'         => __('Hvornår skal gaven leveres?'),
			'placeholder'   => __('Vælg dato hvor gaven skal leveres'),
			'read_only' 		=> true
		), WC()->checkout->get_value( 'delivery_date' ) );


		function build_intervals($items, $is_contiguous, $make_interval) {
				$intervals = array();
				$end   = false;
				if(is_array($items) || is_object($items)){
					foreach ($items as $item) {
							if (false === $end) {
									$begin = (int) $item;
									$end   = (int) $item;
									continue;
							}
							if ($is_contiguous($end, $item)) {
									$end = (int) $item;
									continue;
							}
							$intervals[] = $make_interval($begin, $end);
							$begin = (int) $item;
							$end   = (int) $item;
					}
				}
				if (false !== $end) {
						$intervals[] = $make_interval($begin, $end);
				}
				return $intervals;
		}

		$opening = get_field('openning', 'user_'.$vendor_id);
		$open_iso_days = array();
		$open_label_days = array();
		foreach($opening as $k => $v){
			$open_iso_days[] = (int) $v['value'];
			$open_label_days[$v['value']] = $v['label'];
		}

		$interv = array();
		if(!empty($open_iso_days) && is_array($open_iso_days)){
			$interv = build_intervals($open_iso_days, function($a, $b) { return ($b - $a) <= 1; }, function($a, $b) { return $a."..".$b; });
		} else {
			print 'Butikkens leveringsdage er ukendte';
		}
		$i = 1;

		if(!empty($opening) && !empty($interv) && count($interv) > 0){

			if($del_value == "1"){
				echo '<p>Butikken kan levere gaver ';
			} else if($del_value == "0"){
				echo '<p>Butikken afsender gaver ';
			}

			foreach($interv as $v){
				$val = explode('..',$v);
				if(!empty($val)){
					$start = isset($open_label_days[$val[0]])? $open_label_days[$val[0]] : '';
					if($val[0] != $val[1]){
						$end = isset($open_label_days[$val[1]]) ? $open_label_days[$val[1]] : '';
						if(!empty($start) && !empty($end)){
							print strtolower($start."-".$end);
						}
					} else {
						print strtolower($start);
					}
					if(count($interv) > 1){
						if(count($interv)-1 == $i){ print " og "; }
						else if(count($interv) > $i) { print ', ';}
					}
				}
				$i++;
			}
		}
		echo '.</p>';


		echo '<div id="show-if-shipping">';
		echo '<span>Ved bestillingen inden klokken ';
		echo $vendorDropOffTime.':00</span>';
		echo ' kan butikken levere om  '.$vendorDeliverDayReq;
		echo ' leveringsdage.';

		#$closed_days_date_iteration = count($closed_dates_arr);
		#$cdi = 0;
		#if(!empty($closed_dates_arr)){
		#	echo '<p>Butikken holder lukket på flg. datoer: ';
		#	foreach($closed_dates_arr as $closed_date){
		#		if(++$cdi == $closed_days_date_iteration){
		#			echo $closed_date;
		#		} else {
		#			echo $closed_date.", ";
		#		}
		#	}
		#	echo '</p>';
		#	// open close days end
		#}

		echo '</div>';
	}


	?>

	<input type="hidden" id="vendorDeliverDay" value="<?php echo $vendorDeliverDayReq;?>"/>
	<input type="hidden" id="vendorDropOffTimeId" value="<?php echo $vendorDropOffTime;?>"/>
	<?php
}

/**
 * Add Content to the Related Steps Created Above
 * @param string $step
 * return void
 */
function argmcAddStepsContent($step) {
	//First Step Content
  if ($step == 'step_6') {
		greeting_echo_receiver_info();
	}
}
add_action('arg-mc-checkout-step', 'argmcAddStepsContent');



/**
 * Make ship to different address checkbox checked by default
 * @since 1.0.1
 * @author Dennis Lauritzen
 */
add_filter('woocommerce_ship_to_different_address_checked', '__return_true');
add_filter('woocommerce_order_needs_shipping_address', '__return_true');

/**
 * Disable order shipping options
 * @since 1.0.1
 * @author Dennis Lauritzen
 */
add_filter('woocommerce_checkout_fields' , 'greeting_marketplace_checkout_fields', 10, 1);
function greeting_marketplace_checkout_fields($fields) {
  // Remove billing fields
  //unset($fields['billing']['billing_first_name']);
  //unset($fields['billing']['billing_last_name']);
  unset($fields['billing']['billing_company']);
  // unset($fields['billing']['billing_address_1']);
  unset($fields['billing']['billing_address_2']);
  // unset($fields['billing']['billing_city']);
  // unset($fields['billing']['billing_postcode']);
  # unset($fields['billing']['billing_country']);
  unset($fields['billing']['billing_state']);
  //unset($fields['billing']['billing_phone']);
  //unset($fields['billing']['billing_email']);

  // Remove shipping fields
  //unset($fields['shipping']['shipping_first_name']);
  //unset($fields['shipping']['shipping_last_name']);
  //unset($fields['shipping']['shipping_company']);
  //unset($fields['shipping']['shipping_address_1']);
  unset($fields['shipping']['shipping_address_2']);
  //unset($fields['shipping']['shipping_city']);
  //unset($fields['shipping']['shipping_postcode']);
	# unset($fields['shipping']['shipping_country']);
	unset($fields['shipping']['shipping_state']);

    // Remove order comment fields
	unset($fields['order']['order_comments']);

	$disable_autocomplete = 'nope';
	$fields['shipping']['shipping_address_1']['autocomplete'] = $disable_autocomplete;
	$fields['shipping']['shipping_postcode']['autocomplete'] = $disable_autocomplete;
	$fields['shipping']['shipping_city']['autocomplete'] = $disable_autocomplete;

  return $fields;
}

/**
 * Change the default state and country on the checkout page
 */
add_filter( 'default_checkout_billing_country', 'change_default_checkout_country' );
add_filter( 'default_checkout_shipping_country', 'change_default_checkout_country' );
function change_default_checkout_country() {
  return 'DK'; // country code
}
function change_default_checkout_state() {
  return ''; // state code
}

/**
 * Add additional terms to checkout if cart contains product that has an age restriction of 18+
 * @since 1.0.1
 * @author Dennis
 */
add_action('woocommerce_review_order_before_submit', 'greeting_marketplace_checkout_age_restriction');
function greeting_marketplace_checkout_age_restriction() {
	$age_restricted_items_in_cart = false;
	foreach(WC()->cart->get_cart() as $cart_item_key => $cart_item) {
		$product_alchohol = get_post_meta($cart_item['product_id'], 'alcholic_content', true);
		if($product_alchohol){
			$age_restricted_items_in_cart = true;
			break;
		}
	}
	if($age_restricted_items_in_cart){
		woocommerce_form_field('age_restriction', array(
			'type'          => 'checkbox',
			'class'         => array('form-row mycheckbox'),
			'label_class'   => array('woocommerce-form__label woocommerce-form__label-for-checkbox checkbox'),
			'input_class'   => array('woocommerce-form__input woocommerce-form__input-checkbox input-checkbox'),
			'required'      => true,
			'label'         => esc_html__('I confirm that I\'m 18+ years old.', 'greeting2'),
		));
	}
}

/**
 * Function for redirecting to a new receipt page, that has custom theme.
 *
 * @author Dennis Lauritzen
 * @return void
 */
add_action( 'woocommerce_thankyou', 'woocommerce_thankyou_redirect', 4 );
function woocommerce_thankyou_redirect( $order_id ) {
     //$order_id. // This contains the specific ID of the order
     $order       = wc_get_order( $order_id );
     $order_key   = $order->get_order_key();
		 if(empty($order) || (!is_object($order) && !is_array($order) && count($order) == 0)){
			 wp_redirect( site_url() .'/' );
		 }
		 global $wp;
		 if ( is_checkout() && !empty( $wp->query_vars['order-received'] ) ) {
     wp_redirect( site_url() . '/order-received?o='.$order->ID.'&key='.$order_key );
     exit;
	 }
}

/**
 * Function for generating breadcrumbs.
 * Has to be called on the template pages (not called automatically).
 * @used on landing pages
 *
 * @author Dennis Lauritzen
 */
 /**
  * Generate breadcrumbs
  * @author CodexWorld
  * @authorURL www.codexworld.com
  */
function get_breadcrumb() {
   echo '<a href="'.home_url().'" rel="nofollow" style="color: #777777;">Forside</a>';
   if (is_category() || is_single()) {
       echo "&nbsp;/&nbsp;";
       the_category(' &bull; ');
           if (is_single()) {
               echo " &nbsp;/&nbsp; ";
               the_title();
           }
   } elseif (is_page()) {
       echo "&nbsp;/&nbsp;";
       echo the_title();
   } elseif (is_search()) {
       echo "&nbsp;/&nbsp; Search Results for... ";
       echo '"<em>';
       echo the_search_query();
       echo '</em>"';
   }
}

/**
 * Function for handling price ranges.
 * Added by Dennis Lauritzen
 *
 * @source https://stackoverflow.com/questions/66072017/filter-products-by-price-range-using-woocommerce-wc-get-products
 */
add_filter( 'woocommerce_product_data_store_cpt_get_products_query', 'handle_price_range_query_var', 10, 2 );
function handle_price_range_query_var( $query, $query_vars ) {
    if ( ! empty( $query_vars['price_range'] ) ) {
        $price_range = explode( '|', esc_attr($query_vars['price_range']) );

        if ( is_array($price_range) && count($price_range) == 2 ) {
						$query['meta_query'][] = array(
							'key' => '_price',
							// 'value' => array(50, 100),
							'value' => $price_range,
							'compare' => 'BETWEEN',
							'type' => 'NUMERIC'
						);

            $query['orderby'] = 'meta_value_num'; // sort by price
            $query['order'] = 'ASC'; // In ascending order
        }
    }
    return $query;
}

/**
 * Function for getting IP details
 * from user.
 *
 * @access public
 * @author Dennis Lauritzen
 * @return string
 */
function get_client_ip() {
		$ipaddress = $_SERVER['HTTP_CF_CONNECTING_IP'] ?: $_SERVER['REMOTE_ADDR'];

		if(home_url() == 'http://greeting'){
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
  curl_setopt($curl, CURLOPT_URL, $urls['0']);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  $jsonData = json_decode(curl_exec($curl));

		# If error, try no. 2
  if(curl_getinfo($curl, CURLINFO_RESPONSE_CODE) != '200'){
    curl_setopt($curl, CURLOPT_URL, $urls['1']);
  }
  #curl_setopt($curl, CURLOPT_GET, true);
  $jsonData = json_decode(curl_exec($curl));

	# If error, try no. 3
	if(curl_getinfo($curl, CURLINFO_RESPONSE_CODE) != '200'){
    curl_setopt($curl, CURLOPT_URL, $urls['2']);
  }
	$jsonData = json_decode(curl_exec($curl));
  curl_close($curl);

  return $jsonData;
}

add_action('wp_ajax_get_close_stores' , 'get_close_stores');
add_action('wp_ajax_nopriv_get_close_stores','get_close_stores');
function get_close_stores(){
	$postal_code = esc_attr($_POST['postal_code'] );

	global $wpdb, $WCMp;

	$uploadDir = wp_upload_dir();
	$uploadDirBaseUrl = $uploadDir['baseurl'];

	$args = array(
    'role' => 'dc_vendor',
    'orderby' => 'meta_value',
    'meta_key' => 'delivery_zips',
    'order' => 'DESC',
    'number' => 4,
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
		$vendor_page_slug = get_wcmp_vendor($v->ID);

		$image = (!empty($vendor['_vendor_profile_image'])? $vendor['_vendor_profile_image'][0] : '');
		$banner = (!empty($vendor['_vendor_banner'])? $vendor['_vendor_banner'][0] : '');

		$vendor_banner = (!empty(wp_get_attachment_image_src($banner)) ? wp_get_attachment_image_src($banner, 'medium')[0] : $uploadDirBaseUrl.'/woocommerce-placeholder-300x300.png');
		$vendor_picture = (!empty(wp_get_attachment_image_src($image)) ? wp_get_attachment_image_src($image, 'medium')[0] : $uploadDirBaseUrl.'/woocommerce-placeholder-300x300.png');
		#$vendor_url = get_permalink();
		#$vendor_desc = get_user_meta();

		$description2 = (!empty($vendor['_vendor_description'][0]) ? $vendor['_vendor_description'][0] : '');

		if(strlen(wp_strip_all_tags($description2)) >= '98'){
			$description = substr(wp_strip_all_tags($description2), 0, 95).'...';
		} else {
			$description = $description2;
		}

		$store = array(
			'store_name' => $vendor['nickname']['0'],
			'description' => $description,
			'link' => $vendor_page_slug->get_permalink(),
			'image' => $vendor_picture,
			'banner' => $vendor_banner
		);

		$store_arr[] = $store;
	}

	print json_encode($store_arr);

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

/**
 * Removing vendors ability to set some of the
 * order statuses on orders.
 *
 * @author Dennis Lauritzen
 * @since v0.1
 *
 */

add_filter( 'wcmp_vendor_order_statuses', 'wcmp_change_default_status', 10, 2);
function wcmp_change_default_status( $order_status, $order ){
	unset($order_status['wc-pending']);
	unset($order_status['wc-on-hold']);
	unset($order_status['wc-cancelled']);
	unset($order_status['wc-refunded']);
	unset($order_status['wc-failed']);
	return $order_status;
}

/**
 *
 * Add photos to order e-mails
 *
 * @author Dennis Lauritzen
 * @since v1.0
 */
function greeting_modify_wc_order_emails( $args ) {

    // bail if this is sent to the admin
    #if ( $args['sent_to_admin'] ) {
    #    return $args;
    #}
    $args['show_sku'] = false;
    $args['show_image'] = true;
    $args['image_size'] = array( 100, 100 );

    return $args;
}
add_filter( 'woocommerce_email_order_items_args', 'greeting_modify_wc_order_emails' );

/**
 * Function for removing visitor stats in wcmp.
 * for performance reasons.
 *
 * @since v1.0
 * @author Dennis Lauritzen
 */
apply_filters('wcmp_is_disable_store_visitors_stats', '__return_false');


add_action( 'init', 'register_order_seen_order_status' );
function register_order_seen_order_status() {
    register_post_status( 'wc-order-seen', array(
        'label'                     => 'Order Seen by Vendor',
        'public'                    => true,
        'show_in_admin_status_list' => true,
        'show_in_admin_all_list'    => true,
        'exclude_from_search'       => false,
        'label_count'               => _n_noop( 'Order Seen by Vendor <span class="count">(%s)</span>', 'Shipment Arrival <span class="count">(%s)</span>' )
    ) );
}


add_filter( 'wc_order_statuses', 'add_order_seen_to_order_statuses' );
function add_order_seen_to_order_statuses( $order_statuses ) {
    $new_order_statuses = array();
    foreach ( $order_statuses as $key => $status ) {
        $new_order_statuses[ $key ] = $status;
        if ( 'wc-processing' === $key ) {
            $new_order_statuses['wc-order-seen'] = 'Order Seen by Vendor';
        }
    }
    return $new_order_statuses;
}


add_action('admin_head', 'styling_admin_order_list' );
function styling_admin_order_list() {
    global $pagenow, $post;

    if( $pagenow != 'edit.php') return; // Exit
    if( get_post_type($post->ID) != 'shop_order' ) return; // Exit

    // HERE we set your custom status
    $order_status = 'Order Seen'; // <==== HERE
    ?>
    <style>
        .order-status.status-<?php echo sanitize_title( $order_status ); ?> {
            background: #d7f8a7;
            color: #0c942b;
        }
    </style>
    <?php
}



/**
 * Function for customizing subject of Order Completed mail
 *
 * @since 1.0.1
 * @author Dennis Lauritzen
 *
 */
add_filter( 'woocommerce_email_subject_customer_completed_order', 'custom_email_subject_completed', 20, 2 );
function custom_email_subject_completed( $formated_subject, $order ){
    $data = $order->get_data();

    # $inv_name = $data['billing']['first_name'];
    $delivery_name = $data['shipping']['first_name'];
    $shop_id = get_field('greeting_marketplace_order_shop_id', $data['id']);
    $delivery_type = get_field('delivery_type','user'.$shop_id);
    # $greeting_store_name = get_field('company_name', 'options');

    # 0 = delivery with post, 1 = personal delivery
    $del_value = '';
    $del_type = '';
    if(empty($delivery_type['label'])){
        $del_value = $delivery_type;
        $del_type = $delivery_type;
    } else {
        $del_value = $delivery_type['value'];
        $del_type = $delivery_type['label'];
    }

    if($del_value == "1")
    {
        // Personal delivery
        return __( 'Din gave til '.$delivery_name.' er nu leveret 🎁', 'woocommerce' );
    } else {
        // Delivery by courier
        return __( 'Din gave til '.$delivery_name.' 🎁', 'woocommerce' );
    }
}

/**
 * Remove sold by from vendor mails and admin mails
 *
 *
 *
 */
add_filter( 'woocommerce_display_item_meta','wcmp_email_change_sold_by_text', 10, 3 );
function wcmp_email_change_sold_by_text($html, $item, $args ){
    $strings = array();
    $html    = '';
    foreach ( $item->get_formatted_meta_data() as $meta_id => $meta ) {
        $value = $args['autop'] ? wp_kses_post( $meta->display_value ) : wp_kses_post( make_clickable( trim( $meta->display_value ) ) );
        if (0 !== strcasecmp( $meta->display_key, 'Sold By' ) ) {
            $strings[] = $args['label_before'] . wp_kses_post( $meta->display_key ) . $args['label_after'] . $value;
        }
    }

    if ( $strings ) {
        $html = $args['before'] . implode( $args['separator'], $strings ) . $args['after'];
    }

    return $html;
}


/**
*
* Remove vendor details / information in mails
*
*/
add_filter ( 'wcmp_display_vendor_message_to_buyer','__return_false');

/**
 * Add product image to e-mail new vendor order #mails #transactional
 *
 * @access public
 * @author Dennis Lauritzen
 * @return void
 */
add_action('wcmp_before_vendor_order_item_table', 'add_prod_img_to_vendor_email', 10, 4);
function add_prod_img_to_vendor_email($item, $order, $vendor_id, $is_ship) {
		$product = wc_get_product( $item['product_id'] );
		$wcmp_product_img = $product->get_image( array( 100, 100 ));
		echo wp_kses_post( $wcmp_product_img  );
}

/**
 * Minimum order value required for shopping
 * @since 1.0.3
 * @author Dennis Lauritzen
 *
 * @todo Make sure this is based on settings for the store.
 * @todo Make sure there is put a warning if the cart doesn't meet requirements.
 */
# add_action('wp', 'greeting_marketplace_min_order_value');
function greeting_marketplace_min_order_value(){
    $min_order_value = get_option('greeting_marketplace_min_order_value');
    if($min_order_value){
        if(WC()->cart->subtotal < $min_order_value){
            remove_action('woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20);
            remove_action('woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20);
        }
    }
}


/**
 * Function for vendor new order template
 *
 * @author Dennis Lauritzen
 * @paused by Dennis 25/06-22
 */

function restrict_vendor_new_order_mail($recipient, $order) {
   $order_status = $order == NULL ? "cancelled": $order->get_status();
    if ( $order_status == 'processing') {
       return $recipient ;
    } else {
       return;
    }
}
#add_filter('woocommerce_email_recipient_vendor_new_order', 'restrict_vendor_new_order_mail', 1, 2);

/**
 * Function for vendor new order template
 *
 * @author Dennis Lauritzen
 * @paused by Dennis 25/06-22
 */
#add_action('woocommerce_order_status_changed', 'woo_order_status_change_custom', 100, 3);
function woo_order_status_change_custom( $order_id, $from_status, $to_status ) {
    if( !$order_id ) return;
    if( !wp_get_post_parent_id( $order_id )) return;
    if($to_status == 'processing'){
        $emails = WC()->mailer()->emails;
        $email_vendor = $emails['WC_Email_Vendor_New_Order']->trigger( $order_id );
    }
}

/**
 * Add new column to the order table on WCMP frontend order table
 * This is the Parent Order ID / Hoved ordre nr.
 *
 * @author Dennis Lauritzen
 */
add_filter('wcmp_datatable_order_list_table_headers', 'wcmp_add_order_table_column_callback', 10, 2);
function wcmp_add_order_table_column_callback($orders_list_table_headers, $current_user_id) {
	$wcmp_custom_columns = array(
		'order_p_id'    => array('label' => __( 'Hoved ordre nr.', 'dc-woocommerce-multi-vendor' ))
	);

	return (array_slice($orders_list_table_headers, 0, 2) + $wcmp_custom_columns + array_slice($orders_list_table_headers, 2));
}

/**
 * Add the data to new column the order table on WCMP frontend order table
 * This is the Parent Order ID / Hoved ordre nr.
 *
 * @author Dennis Lauritzen
 */
add_filter('wcmp_datatable_order_list_row_data', 'wcmp_add_order_table_row_data', 10, 2);
function wcmp_add_order_table_row_data($vendor_rows, $order) {
	$item_sku = array();
	$vendor = get_current_vendor();
	if($vendor){
		$vendor_items = $vendor->get_vendor_items_from_order($order, $vendor->term_id);
		if($vendor_items){
			foreach ($vendor_items as $item) {
		           $product = wc_get_product( $item['product_id'] );
	    }
		}
	}
	$parents_order_id = wp_get_post_parent_id($order->id);
	$vendor_rows['order_p_id'] = isset( $parents_order_id ) ? $parents_order_id : '-';
	return $vendor_rows;
}


function vendor_redirect_to_home( $query ){
	$page_slug = $query->dc_vendor_shop;
	global $wpdb;

	#var_dump(get_query_var());

	if( is_tax('dc_vendor_shop') ) {
		$sql = "SELECT
				u.id
			FROM  wp_users u
			INNER JOIN wp_usermeta um
			ON um.user_id = u.id
			WHERE um.meta_key = '_vendor_page_slug' AND um.meta_value LIKE %s";

		$sql_query = $wpdb->prepare( $sql, $query->query['dc_vendor_shop'] );
		$results = $wpdb->get_results($sql_query);

		$vendor_id = $results['0']->id;
		if( isset($vendor_id) && !empty($vendor_id) ){
			$user_meta = get_userdata($vendor_id);
			$user_roles = $user_meta->roles;

			if(in_array('dc_rejected_vendor', $user_roles) || in_array('dc_pending_vendor', $user_roles)){

			}
		}
		#wp_redirect( home_url() );
	  #exit;
  }
}
#add_action( 'parse_query', 'vendor_redirect_to_home' );


// ADDING 2 NEW COLUMNS WITH THEIR TITLES (keeping "Total" and "Actions" columns at the end)
add_filter( 'manage_edit-shop_order_columns', 'custom_shop_order_column', 20 );
function custom_shop_order_column($columns)
{
    $reordered_columns = array();

    // Inserting columns to a specific location
    foreach( $columns as $key => $column){
        $reordered_columns[$key] = $column;
        if( $key ==  'order_status' ){
            // Inserting after "Status" column
            $reordered_columns['my-column-delivery-date'] = __( 'Leveringsdato','greeting2');
        }
    }
    return $reordered_columns;
}

// Adding custom fields meta data for each new column (example)
add_action( 'manage_shop_order_posts_custom_column' , 'custom_orders_list_column_content', 20, 2 );
function custom_orders_list_column_content( $column, $post_id )
{
    switch ( $column )
    {
        case 'my-column-delivery-date' :
            // Get custom post meta data
            $my_var_one = get_post_meta( $post_id, '_delivery_date', true );
						$date = new DateTime($my_var_one);
						$date_format = $date->format('D, j. M \'y');
            if(!empty($date_format))
                echo $date_format;

            // Testing (to be removed) - Empty value case
            else
                echo '<small>(<em>Hurtigst muligt</em>)</small>';

            break;
    }
}
