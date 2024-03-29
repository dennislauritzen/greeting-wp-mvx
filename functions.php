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
function greeting3_scripts_loader() {
	$theme_version = wp_get_theme()->get( 'Version' );

	// 1. Styles.
	wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css', array(), $theme_version, 'all' );

    // 2. Main style.
	wp_enqueue_style( 'main', get_template_directory_uri() . '/assets/css/main.css', array(), $theme_version, 'all' ); // main.scss: Compiled Framework source + custom styles.

	if ( is_rtl() ) {
		wp_enqueue_style( 'rtl', get_template_directory_uri() . '/assets/css/rtl.css', array(), $theme_version, 'all' );
	}

	// 2. Scripts.
	wp_enqueue_script( 'mainjs', get_template_directory_uri() . '/assets/js/main.bundle.js', array(), $theme_version, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'greeting3_scripts_loader' );



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
            'has_archive' => false,
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
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Block: City Page',
		'menu_title'	=> 'City Page',
		'parent_slug'	=> 'theme-general-settings',
	));
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Block: Did You Know',
		'menu_title'	=> 'Vidste Du At-block',
		'parent_slug'	=> 'theme-general-settings',
	));
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Block: Customer Care',
		'menu_title'	=> 'Kundeservice-block',
		'parent_slug'	=> 'theme-general-settings',
	));
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Header: USPs',
		'menu_title'	=> 'Header: USPer',
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
		'hierarchical'               => true,
		'public'                     => true,
		'rewrite'										 => array('slug' => 'anledning'),
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

#add_action( 'generate_rewrite_rules', 'register_product_rewrite_rules' );
function register_product_rewrite_rules( $wp_rewrite ) {
    $new_rules = array(
        'products/([^/]+)/?$' => 'index.php?product-category=' . $wp_rewrite->preg_index( 1 ), // 'products/any-character/'
        'products/([^/]+)/([^/]+)/?$' => 'index.php?post_type=sps-product&product-category=' . $wp_rewrite->preg_index( 1 ) . '&sps-product=' . $wp_rewrite->preg_index( 2 ), // 'products/any-character/post-slug/'
        'products/([^/]+)/([^/]+)/page/(\d{1,})/?$' => 'index.php?post_type=sps-product&product-category=' . $wp_rewrite->preg_index( 1 ) . '&paged=' . $wp_rewrite->preg_index( 3 ), // match paginated results for a sub-category archive
        'products/([^/]+)/([^/]+)/([^/]+)/?$' => 'index.php?post_type=sps-product&product-category=' . $wp_rewrite->preg_index( 2 ) . '&sps-product=' . $wp_rewrite->preg_index( 3 ), // 'products/any-character/sub-category/post-slug/'
        'products/([^/]+)/([^/]+)/([^/]+)/([^/]+)/?$' => 'index.php?post_type=sps-product&product-category=' . $wp_rewrite->preg_index( 3 ) . '&sps-product=' . $wp_rewrite->preg_index( 4 ), // 'products/any-character/sub-category/sub-sub-category/post-slug/'
    );
    $wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
}
//add_filter( 'wpseo_primary_term_taxonomies', '__return_false' );

/**
 *
 * Remove the pagination for product category pages and custom taxonomy 'Occasions'.
 *
 */
add_filter( 'loop_shop_per_page', 'greeting_remove_pagination', 20 );
function greeting_remove_pagination( $cols ) {
	$cols = 1;
	return $cols;
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

			function doSearch($searchInput, $dataFetchWrapper, url, action) {
			  var xhr; // declare the xhr variable outside the AJAX function

			  $searchInput.keyup(delay(400, function (e) {
			    var text = jQuery(this).val();

			    if (xhr) {
			      xhr.abort(); // abort the previous request if it's still in progress
			    }

			    xhr = jQuery.ajax({
			      url: url,
			      type: 'post',
			      data: { action: action, keyword: text },
			      beforeSend: function(){
			        if(currentRequest != null){

			          currentRequest.abort();
			        }
			      },
			      success: function(data) {

			        $dataFetchWrapper.data('loading','0');

			        $dataFetchWrapper.html(data);

			        if(text !== '' || !text){
			          $dataFetchWrapper.removeClass('d-none').addClass('d-inline');
			        } else {
			          $dataFetchWrapper.addClass('d-none').removeClass('d-inline');
			        }

			      }
			    }).fail(function(){
				    $dataFetchWrapper.addClass('d-none').removeClass('d-inline');
				  });
			  }));

			  $searchInput.on("input", function(){
			    var text = jQuery(this).val();
			    var str_text = "Søger efter by/postnummer der matcher '"+text+"'...";
			    var loading = $dataFetchWrapper.data('loading');

			    if (xhr) {
			      xhr.abort(); // abort the previous request if it's still in progress
			    }

			    if(loading !== '1'){
			      if(text.length > 0){
			        $dataFetchWrapper.html('');
			        var $loadingElm = jQuery("<li>", {"class": "recomms list-group-item py-2 px-1 bg-white"});
			        var $div = jQuery('<div/>');
			        var $loader = jQuery('<div/>').addClass('greeting-loader float-start d-block pe-1 align-middle').removeClass('d-none');
			        var $loaderDiv = $div.clone().addClass('ms-2 align-middle').html($loader);
			        var $textElm = jQuery('<span/>').addClass('loadingText').text(str_text);
			        var $textDiv = $div.clone().addClass('loaderText').html($textElm);

			        $dataFetchWrapper.removeClass('d-none').addClass('d-inline');
			        $dataFetchWrapper.html($loadingElm.append($loaderDiv, $textDiv));
			      }
			    } else {
			      $dataFetchWrapper.find('span.loadingText').text(str_text);
			    }

			    search_input_val = text;
			    $dataFetchWrapper.data('loading', '1');
			  });
			}

			// Call the function for the first search input
			doSearch(jQuery('#front_Search-new_ucsa'), jQuery('#datafetch_wrapper'), '<?php echo admin_url('admin-ajax.php'); ?>', 'data_fetch');

			// Call the function for the second search input
			doSearch(jQuery('.pc-form-content #front_Search-new_ucsa2'), jQuery('.pc-form-content #lp-datafetch_wrapper'), '<?php echo admin_url('admin-ajax.php'); ?>', 'catocca_landing_data_fetch');

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

	if (!empty($landing_page_query)) {
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


/**
 * Function for getting the postal codes on Category and Occasion landing pages
 * Only for getting the postal codes.
 *
 * @author Dennis Lauritzen
 */
 add_action('wp_ajax_catocca_landing_data_fetch' , 'catocca_landing_data_fetch');
 add_action('wp_ajax_nopriv_catocca_landing_data_fetch','catocca_landing_data_fetch');

function catocca_landing_data_fetch(){
	$search_query = esc_attr( $_POST['keyword'] );

	global $wpdb;

	$prepared_statement_cat_occa = $wpdb->prepare("
		SELECT *
		FROM {$wpdb->prefix}posts
		WHERE post_title LIKE %s
		AND post_type = 'city'
		LIMIT 5", '%'.trim($search_query).'%');
	$query_cat_occa = $wpdb->get_results($prepared_statement_cat_occa, OBJECT);

	if (!empty($query_cat_occa)) {
    $array_count = count($query_cat_occa);
    $i = 0;

    foreach ($query_cat_occa as $key => $cat_occa) {
			$postal = get_post_meta($cat_occa->ID, 'postalcode', true);
			$city = get_post_meta($cat_occa->ID, 'city', true);
			$pc_link = get_permalink($cat_occa->ID);

			//get_permalink( $landing_page->ID
        ?>
        <li class="lp-recomms list-group-item py-2 px-4 <?php echo ($key==0) ? 'active' : '';?>" aria-current="true">
            <a
							href="<?php echo $pc_link; ?>"
							data-postal="<?php echo $postal; ?>"
							data-city="<?php echo $city; ?>"
							data-city-link="<?php echo $pc_link; ?>"
							class="lp-recomms-link text-teal stretched-link">
								<?php echo ucfirst($cat_occa->post_title);?>
						</a>
        </li>
    <?php }

	// If there is no match for the city, then do this...
	} else {?>
		<li class="list-group-item py-2 px-4" aria-current="true">
			Der blev desværre ikke fundet nogle byer, der matcher søgekriterierne
		</li>
	<?php }
	die();
}

/**
 * Vendor filter on Category and Occasion landing pages
 * Only for these 2 page types.
 *
 * @usedon archive-product.php and
 * @author Dennis Lauritzen
 */
 /**
  * Vendor filter on City Page
  * city filter
  */
function categoryAndOccasionVendorFilterAction() {
    global $wpdb;

    // default user array come from front end
    $cityDefaultUserIdAsString = $_POST['cityDefaultUserIdAsString'];
    $defaultUserArray = explode(",", $cityDefaultUserIdAsString);

    // category & occasion filter data
    $catOccaArray = array();
    if(isset($_POST['catOccaIdArray']) && !empty($_POST['catOccaIdArray'])){
        $catOccaArray = $_POST['catOccaIdArray'];
    }
    $catOccaDeliveryIdArray = is_array($catOccaArray) ? $catOccaArray : array();

    // The default ID from the category / occasion (the "base" landing page cat / occa)
    $idCatOccaArray = array();
    if(isset($_POST['defaultIdCatOcca']) && !empty($_POST['defaultIdCatOcca'])){
        $idCatOccaArray = $_POST['defaultIdCatOcca'];
    }
    $defaultIdCatOcca = is_array($idCatOccaArray) ? $idCatOccaArray : array();

    // delivery date
    $deliveryDate = empty($_POST['delDate']) ? (int) $_POST['delDate'] : 8;
    if(empty($deliveryDate) && $deliveryDate != 0){
        $deliveryDate = 8;
    } else if(!is_numeric($deliveryDate) || $deliveryDate < 0){
        $deliveryDate = 0;
    }

 	// Calculate Selected Date
 	$filteredDate = new DateTime();
 	$filteredDate->modify('+'.$deliveryDate.' days');
 	$selectedDate = $filteredDate->format('d-m-Y');
 	$selectedDay = $filteredDate->format('N');

 	// delivery filter data
 	$deliveryIdArray = $_POST['deliveryIdArray'];

 	$postal_code = $_POST['postalCode'];

	// declare array for store user ID get from occasion
	$userIdArrayGetFromPostalCode = array();

 	// declare array for store user ID get from occasion
 	$userIdArrayGetFromDelDate = array();

 	// declare array for store user ID get from occasion
 	$userIdArrayGetFromCatOcca = array();

 	// declare array for store user ID got from delivery type
 	$userIdArrayGetFromDelivery = array();

	////////////////////////
	// FILTER: Category & Occasion
 	// Prepare the where and where-placeholders for term_id (cat and occassion ID's).
 	$where = array();
 	$placeholder_arr = (is_countable($catOccaDeliveryIdArray) ? array_fill(0, count($catOccaDeliveryIdArray), '%s') : array());

    #### TEST INITIAL ARRAY
    #highlight_string("\n\$defaultUserArrayInit =\n" . var_export($defaultUserArray, true) . ";\n");

 	if(!empty($catOccaDeliveryIdArray) && is_array($placeholder_arr) && !empty($placeholder_arr)){
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
 	// FILTER: Delivery DATE
 	// Prepare the statement for delivery array
 	if($deliveryDate >= 0 && $deliveryDate < 8){
 		$args = array(
 			'role' => 'dc_vendor',
 			'meta_query' => array(
 						'key' => 'vendor_require_delivery_day',
 						'value' => $deliveryDate,
 						'compare' => '<=',
 						'type' => 'NUMERIC'
 				)
 		);

 		// (v) @todo: Move cut-off time out of the query and into PHP.
 		// (v) @todo: Make sure the store is not closed on the given date!!!! Make a PHP check.

 		$usersByDelDateFilter = new WP_User_Query( $args	);
 		$delDateArr = $usersByDelDateFilter->get_results();

 		foreach($delDateArr as $v){
 			$dropoff_time 		= get_field('vendor_drop_off_time','user_'.$v->ID);
 			$delDate 			= get_field('vendor_require_delivery_day','user_'.$v->ID);
 			$closedDatesArr		= get_vendor_closed_dates($v->ID);
 			$delWeekDays	    = get_field('openning','user_'.$v->ID);

 			$open_iso_days = array();
 			foreach($delWeekDays as $key => $val){
 				$open_iso_days[] = $val['value'];
 			}

 			$open_this_day = (in_array($selectedDay, $open_iso_days) ? 1 : 0);
 			#var_dump($open_this_day);

 			// Check if the store is closed this specific date.
 			$closedThisDate 	= 0;
 			if(in_array($selectedDate, $closedDatesArr)){
 				$closedThisDate = 1;
 			}

 			if($deliveryDate < $delDate){
 				// Can't delivery on selected date.
 			} else if($deliveryDate == $delDate && $dropoff_time < date("H")){
 				// Can't deliver on selected date because time has passed cutoff.
 			} else {
 				// Can deliver, woohoo.
 				if($closedThisDate == 0 && $open_this_day == 1){
 					array_push($userIdArrayGetFromDelDate, (string) $v->ID);
 				}
 			}
 		}


 		// Remove all the stores that doesnt match from default array
 		// Normally we would check if the userIdArray is empty, but not here,
 		// instead we check if the date-filter is set - if it is and the userID-array
 		// is empty, then there is no stores left.
 		// if(!empty($userIdArrayGetFromDelDate)){
 		$userIdArrayGetFromDelDate = array_intersect($defaultUserArray, $userIdArrayGetFromDelDate);
 		$defaultUserArray = $userIdArrayGetFromDelDate;
 	}

	////////////////////////
	// Filter Postal Code
	//
	$sql = "SELECT u.ID, umm1.meta_value AS dropoff_time, umm2.meta_value AS require_delivery_day, umm3.meta_value AS delivery_type
	          FROM {$wpdb->prefix}users u
	          LEFT JOIN {$wpdb->prefix}usermeta umm1 ON u.ID = umm1.user_id AND umm1.meta_key = 'vendor_drop_off_time'
	          LEFT JOIN {$wpdb->prefix}usermeta umm2 ON u.ID = umm2.user_id AND umm2.meta_key = 'vendor_require_delivery_day'
	          LEFT JOIN {$wpdb->prefix}usermeta umm3 ON u.ID = umm3.user_id AND umm3.meta_key = 'delivery_type'
	          WHERE EXISTS (
	              SELECT 1
	              FROM {$wpdb->prefix}usermeta um
	              WHERE um.user_id = u.ID AND um.meta_key = 'delivery_zips' AND um.meta_value LIKE %s
	          )
	          AND NOT EXISTS (
	              SELECT 1
	              FROM {$wpdb->prefix}usermeta um2
	              WHERE um2.user_id = u.ID AND um2.meta_key = 'vendor_turn_off'
	          )
	          AND EXISTS (
	              SELECT 1
	              FROM {$wpdb->prefix}usermeta um5
	              WHERE um5.user_id = u.ID AND um5.meta_key = 'wp_capabilities' AND um5.meta_value LIKE %s
	          )
	          ORDER BY
	          umm3.meta_value DESC,
	          CASE u.ID
	              WHEN 38 THEN 0
	              WHEN 76 THEN 0
	              ELSE 1
	          END DESC,
	          umm2.meta_value ASC,
	          umm2.meta_value DESC
	        	";
	$vendor_query = $wpdb->prepare($sql, '%'.$postal_code.'%', '%dc_vendor%');
	$vendor_arr = $wpdb->get_results($vendor_query);

	foreach($vendor_arr as $k => $v){
		array_push($userIdArrayGetFromPostalCode, (string) $v->ID);
	}

	// Remove all the stores that doesnt match from default array
 	if(!empty($userIdArrayGetFromPostalCode)){
 		$userIdArrayGetFromPostalCode = array_intersect($defaultUserArray, $userIdArrayGetFromPostalCode);
 		$defaultUserArray = $userIdArrayGetFromPostalCode;
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

   $author_ids = $wpdb->get_col(
 	    $wpdb->prepare(
 	        "
 	        SELECT DISTINCT(p.post_author)
 	        FROM {$wpdb->prefix}posts p
 	        INNER JOIN {$wpdb->prefix}postmeta pm ON p.ID = pm.post_id
 	        WHERE (p.post_type = 'product' OR p.post_type = 'product_variation')
 	        AND p.post_status = 'publish'
 	        AND pm.meta_key = '_price'
 	        AND pm.meta_value BETWEEN %d AND %d
 	        ",
 	        $inputMinPrice,
 	        $inputMaxPrice
 	    )
 	);

 	$userIdArrayGetFromPriceFilter = array_unique($author_ids);

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

 	//Variable holding the boolean controlling if it is the first freight store.
 	$first = 0;
 	if(!empty($return_arr)){
 		foreach ($return_arr as $filteredUser) {
 			$vendor_int = (int) $filteredUser;

 			$vendor = get_mvx_vendor($vendor_int);
 			$cityName = $_POST['cityName'];

 			// Get the delivery type for the vendor so we know if it is local or freight.
 			// The delivery type of the store
 		    $delivery_type = get_field('delivery_type','user_'.$vendor->id);

            $delivery_type = (!empty($delivery_type['0']['value']) ? $delivery_type['0']['value'] : 0);

 			if($delivery_type == 0 && $first == 0){
 				get_template_part('template-parts/vendor-freight-heading', null, array('cityName' => $cityName));
 				$first = 1;
 			}
 			// call the template with pass $vendor variable
 			get_template_part('template-parts/vendor-loop', null, array('vendor' => $vendor, 'cityName' => $cityName));
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
 add_action( 'wp_ajax_categoryAndOccasionVendorFilterAction', 'categoryAndOccasionVendorFilterAction' );
 add_action( 'wp_ajax_nopriv_categoryAndOccasionVendorFilterAction', 'categoryAndOccasionVendorFilterAction' );



/**
 * Vendor filter on City Page
 * city filter
 */
function catOccaDeliveryAction() {
	global $wpdb;

	// default user array come from front end
	$cityDefaultUserIdAsString = $_POST['cityDefaultUserIdAsString'];
	$defaultUserArray = explode(",", $cityDefaultUserIdAsString);

	// category & occasion filter data
    $catOccaArray = array();
    if(isset($_POST['catOccaIdArray']) && !empty($_POST['catOccaIdArray'])){
        $catOccaArray = $_POST['catOccaIdArray'];
    }
	$catOccaDeliveryIdArray = is_array($catOccaArray) ? $catOccaArray : array();

	// delivery date
	$deliveryDate = (int) $_POST['delDate'];
	if(empty($deliveryDate) && $deliveryDate !== 0){
		$deliveryDate = 8;
	} else if(!is_numeric($deliveryDate) || $deliveryDate < 0){
		$deliveryDate = 0;
	}

	// Calculate Selected Date
	$filteredDate = new DateTime();
	$filteredDate->modify('+'.$deliveryDate.' days');
	$selectedDate = $filteredDate->format('d-m-Y');
	$selectedDay = $filteredDate->format('N');

	// delivery filter data
	$deliveryIdArray = $_POST['deliveryIdArray'];

	$postal_code = $_POST['postalCode'];

	// declare array for store user ID get from occasion
	$userIdArrayGetFromDelDate = array();

	// declare array for store user ID get from occasion
	$userIdArrayGetFromCatOcca = array();

	// declare array for store user ID got from delivery type
	$userIdArrayGetFromDelivery = array();

	// Prepare the where and where-placeholders for term_id (cat and occassion ID's).
	$where = array();
	$placeholder_arr = (is_countable($catOccaDeliveryIdArray) ? array_fill(0, count($catOccaDeliveryIdArray), '%s') : array());

	if(!empty($catOccaDeliveryIdArray) && is_array($placeholder_arr) && !empty($placeholder_arr)){
		foreach($catOccaDeliveryIdArray as $catOccaDeliveryId){
			if(is_numeric($catOccaDeliveryId)){
				$where[] = $catOccaDeliveryId;
			}
		}

		$args = array(
	    'post_type' => 'product',
	    'post_status' => 'publish',
	    'fields' => 'all',
	    'tax_query' => array(
	        'relation' => 'OR',
	        array(
	            'taxonomy' => 'occasion',
	            'field' => 'term_id',
	            'terms' => $where,
	            'operator' => 'IN'
	        ),
	        array(
	            'taxonomy' => 'product_cat',
	            'field' => 'term_id',
	            'terms' => $where,
	            'operator' => 'IN'
	        )
	    ),
	    'author__not_in' => array(0),
	    'orderby' => 'author',
	    'order' => 'ASC',
	    'posts_per_page' => -1,
		);
		#$query = new WP_Query($args);
		#$authors = array_unique(wp_list_pluck($query->posts, 'post_author'));


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
	// FILTER: Delivery DATE
	// Prepare the statement for delivery array
	if($deliveryDate >= 0 && $deliveryDate < 8){
		$args = array(
			'role' => 'dc_vendor',
			'meta_query' => array(
						'key' => 'vendor_require_delivery_day',
						'value' => $deliveryDate,
						'compare' => '<=',
						'type' => 'NUMERIC'
				)
		);

		// (v) @todo: Move cut-off time out of the query and into PHP.
		// (v) @todo: Make sure the store is not closed on the given date!!!! Make a PHP check.

		$usersByDelDateFilter = new WP_User_Query( $args	);
		$delDateArr = $usersByDelDateFilter->get_results();

		foreach($delDateArr as $v){
			$dropoff_time 		= get_field('vendor_drop_off_time','user_'.$v->ID);
			$delDate 			= get_field('vendor_require_delivery_day','user_'.$v->ID);
            $closedDatesArr		= get_vendor_closed_dates($v->ID);

			$delWeekDays	    = get_field('openning','user_'.$v->ID);

			$open_iso_days = array();
			foreach($delWeekDays as $key => $val){
				$open_iso_days[] = $val['value'];
			}

			$open_this_day = (in_array($selectedDay, $open_iso_days) ? 1 : 0);

            // Check for closed dates
			$closedThisDate 	= 0;
			if(in_array($selectedDate, $closedDatesArr)){
				$closedThisDate = 1;
			}

			if($deliveryDate < $delDate){
				// Can't delivery on selected date.
			} else if($deliveryDate == $delDate && $dropoff_time < date("H")){
				// Can't deliver on selected date because time has passed cutoff.
			} else {
				// Can deliver, woohoo.
				if($closedThisDate == 0 && $open_this_day == 1){
					array_push($userIdArrayGetFromDelDate, (string) $v->ID);
				}
			}
		}

		// Remove all the stores that doesnt match from default array
		// Normally we would check if the userIdArray is empty, but not here,
		// instead we check if the date-filter is set - if it is and the userID-array
		// is empty, then there is no stores left.
		// if(!empty($userIdArrayGetFromDelDate)){
		$userIdArrayGetFromDelDate = array_intersect($defaultUserArray, $userIdArrayGetFromDelDate);
		$defaultUserArray = $userIdArrayGetFromDelDate;
	}

	////////////////////////
	// FILTER: Delivery
	// Prepare the statement for delivery array
	$where = array();
    $placeholder_arr = (is_countable($deliveryIdArray) ? array_fill(0, count($deliveryIdArray), '%s') : array());

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

	$author_ids = $wpdb->get_col(
	    $wpdb->prepare(
	        "
	        SELECT DISTINCT p.post_author
	        FROM {$wpdb->prefix}posts p
	        INNER JOIN {$wpdb->prefix}postmeta pm ON p.ID = pm.post_id
	        WHERE p.post_type = 'product'
	        AND p.post_status = 'publish'
	        AND pm.meta_key = '_price'
	        AND pm.meta_value BETWEEN %d AND %d
	        ",
	        $inputMinPrice,
	        $inputMaxPrice
	    )
	);

	$userIdArrayGetFromPriceFilter = array_unique($author_ids);

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

	//Variable holding the boolean controlling if it is the first freight store.
	$first = 0;
	if(!empty($return_arr)){
		foreach ($return_arr as $filteredUser) {
			$vendor_int = (int) $filteredUser;

			$vendor = get_mvx_vendor($vendor_int);
			$cityName = $_POST['cityName'];

			// Get the delivery type for the vendor so we know if it is local or freight.
			// The delivery type of the store
		  $delivery_type = get_field('delivery_type','user_'.$vendor->id);
		  $delivery_type = (!empty($delivery_type['0']['value']) ? $delivery_type['0']['value'] : 0);

			if($delivery_type == 0 && $first == 0){
				get_template_part('template-parts/vendor-freight-heading', null, array('cityName' => $cityName));
				$first = 1;
			}
			// call the template with pass $vendor variable
			get_template_part('template-parts/vendor-loop', null, array('vendor' => $vendor, 'cityName' => $cityName));
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
function lpFilterAction() {
	// default user array come from front end
	$cityDefaultUserIdAsString = $_POST['landingPageDefaultUserIdAsString'];
	$defaultUserArray = explode(",", $cityDefaultUserIdAsString);

	// category & occasion filter data
    $catOccaArray = array();
    if(isset($_POST['catOccaIdArray']) && !empty($_POST['catOccaIdArray'])){
        $catOccaArray = $_POST['catOccaIdArray'];
    }
    $catOccaDeliveryIdArray = is_array($catOccaArray) ? $catOccaArray : array();

	// delivery filter data
	$deliveryIdArray = empty($_POST['deliveryIdArray']) ? array() : $_POST['deliveryIdArray'];

	// get the postal code array from post.
	$postal_code = empty($_POST['postalArray']) ? array() : $_POST['postalArray'];

	// get the delivery date from post
	// delivery date
	$deliveryDate = (int) $_POST['delDate'];
	if(empty($deliveryDate) && $deliveryDate !== 0){
		$deliveryDate = 8;
	} else if(!is_numeric($deliveryDate) || $deliveryDate < 0){
		$deliveryDate = 0;
	}

	// Calculate Selected Date
	$filteredDate = new DateTime();
	$filteredDate->modify('+'.$deliveryDate.' days');
	$selectedDate = $filteredDate->format('d-m-Y');
	$selectedDay = $filteredDate->format('N');


	// declare array for store user ID get from occasion
	$userIdArrayGetFromCatOcca = array();

	// declare array holding store IDs that match delivery date.
	$userIdArrayGetFromDelDate = array();

	// declare array for store user ID got from delivery type
	$userIdArrayGetFromDelivery = array();

	global $wpdb;
	// Prepare the where and where-placeholders for term_id (cat and occassion ID's).
	$where = array();
	$placeholder_arr = (is_countable($catOccaDeliveryIdArray) ? array_fill(0, count($catOccaDeliveryIdArray), '%s') : array());

	if(!empty($catOccaDeliveryIdArray) && is_array($placeholder_arr) && !empty($placeholder_arr)){
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

	//////////////////////////
	// FILTER: Postal Codes
	// Prepare the statement for postal code array
	if(!empty($postal_code)){
		$where = array();
		$placeholder_arr = array_fill(0, count($postal_code), 'um.meta_value LIKE %s');
		foreach($postal_code as $postcode){
		  $where[] = '%'.$postcode.'%';
		}

		// Add the user role to the where array:
		$where[] = '%dc_vendor%';

		$sql = "SELECT u.ID, umm1.meta_value AS dropoff_time, umm2.meta_value AS require_delivery_day, umm3.meta_value AS delivery_type
		          FROM {$wpdb->prefix}users u
		          LEFT JOIN {$wpdb->prefix}usermeta umm1 ON u.ID = umm1.user_id AND umm1.meta_key = 'vendor_drop_off_time'
		          LEFT JOIN {$wpdb->prefix}usermeta umm2 ON u.ID = umm2.user_id AND umm2.meta_key = 'vendor_require_delivery_day'
		          LEFT JOIN {$wpdb->prefix}usermeta umm3 ON u.ID = umm3.user_id AND umm3.meta_key = 'delivery_type'
		          WHERE EXISTS (
		              SELECT 1
		              FROM {$wpdb->prefix}usermeta um
		              WHERE um.user_id = u.ID AND um.meta_key = 'delivery_zips' AND (".implode(" OR ",$placeholder_arr).")
		          )
		          AND NOT EXISTS (
		              SELECT 1
		              FROM {$wpdb->prefix}usermeta um2
		              WHERE um2.user_id = u.ID AND um2.meta_key = 'vendor_turn_off'
		          )
		          AND EXISTS (
		              SELECT 1
		              FROM {$wpdb->prefix}usermeta um5
		              WHERE um5.user_id = u.ID AND um5.meta_key = 'wp_capabilities' AND um5.meta_value LIKE %s
		          )
		          ORDER BY
		          umm3.meta_value DESC,
		          CASE u.ID
		              WHEN 38 THEN 0
		              WHEN 76 THEN 0
		              ELSE 1
		          END DESC,
		          umm2.meta_value ASC,
		          umm2.meta_value DESC
		";

		$sql_prepare = $wpdb->prepare($sql, $where);
		$users_from_postcode = wp_list_pluck( $wpdb->get_results($sql_prepare), 'ID' );

		// Remove all the stores that doesnt match from default array
		if(!empty($users_from_postcode)){
			$userIdArrayGetFromPostal = array_intersect($defaultUserArray, $users_from_postcode);
			$defaultUserArray = $userIdArrayGetFromPostal;
		}
	}
	// --
	//////////////////////////


	////////////////////////
	// FILTER: Delivery DATE
	// Prepare the statement for delivery array
	if($deliveryDate >= 0 && $deliveryDate < 8){
		$args = array(
			'role' => 'dc_vendor',
			'meta_query' => array(
						'key' => 'vendor_require_delivery_day',
						'value' => $deliveryDate,
						'compare' => '<=',
						'type' => 'NUMERIC'
				)
		);

		// (v) @todo: Move cut-off time out of the query and into PHP.
		// (v) @todo: Make sure the store is not closed on the given date!!!! Make a PHP check.

		$usersByDelDateFilter = new WP_User_Query( $args	);
		$delDateArr = $usersByDelDateFilter->get_results();

		foreach($delDateArr as $v){
			$dropoff_time 		= get_field('vendor_drop_off_time','user_'.$v->ID);
			$delDate 			= (int) get_field('vendor_require_delivery_day','user_'.$v->ID);
            $closedDatesArr		= get_vendor_closed_dates('user_'.$v->ID);
			$delWeekDays	    = get_field('openning','user_'.$v->ID);

			$open_iso_days = array();
			foreach($delWeekDays as $key => $val){
				$open_iso_days[] = $val['value'];
			}

			$open_this_day = (in_array($selectedDay, $open_iso_days) ? 1 : 0);

			// Check if the store is closed this specific date.
			$closedThisDate 	= 0;
			if(in_array($selectedDate, $closedDatesArr)){
				$closedThisDate = 1;
			}

			#var_dump($delDate);

			if($deliveryDate < $delDate){
				// Can't delivery on selected date.
				print "Vi er her";
			} else if($deliveryDate == $delDate && $dropoff_time < date("H")){
				// Can't deliver on selected date because time has passed cutoff.
				print "Nej, vi er her";
			} else {
				// Can deliver, woohoo.
				if($closedThisDate == 0 && $open_this_day == 1){
					array_push($userIdArrayGetFromDelDate, (string) $v->ID);
				}
			}
		}

		#var_dump($userIdArrayGetFromDelDate);

		// Remove all the stores that doesnt match from default array
		// Normally we would check if the userIdArray is empty, but not here,
		// instead we check if the date-filter is set - if it is and the userID-array
		// is empty, then there is no stores left.
		// if(!empty($userIdArrayGetFromDelDate)){
		$userIdArrayGetFromDelDate = array_intersect($defaultUserArray, $userIdArrayGetFromDelDate);
		$defaultUserArray = $userIdArrayGetFromDelDate;
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

	$author_ids = $wpdb->get_col(
	    $wpdb->prepare(
	        "
	        SELECT DISTINCT p.post_author
	        FROM {$wpdb->prefix}posts p
	        INNER JOIN {$wpdb->prefix}postmeta pm ON p.ID = pm.post_id
	        WHERE p.post_type = 'product'
	        AND p.post_status = 'publish'
	        AND pm.meta_key = '_price'
	        AND pm.meta_value BETWEEN %d AND %d
	        ",
	        $inputMinPrice,
	        $inputMaxPrice
	    )
	);

	$userIdArrayGetFromPriceFilter = array_unique($author_ids);

	// Remove all the stores that doesnt match from default array
	if(!empty($userIdArrayGetFromPriceFilter)){
		$userIdArrayGetFromPriceFilter = array_intersect($defaultUserArray, $userIdArrayGetFromPriceFilter);

		$defaultUserArray = $userIdArrayGetFromPriceFilter;
	}



	////////////////
	// Filter: Price
	// Location: City Page
	// input price filter data come from front end


	$userIdArrayGetFromPriceFilter = array_unique($author_ids);




	// three array is
	// $userIdArrayGetFromPostal
	// $userIdArrayGetFromCatOcca
	// $userIdArrayGetFromDelivery
	// $userIdArrayGetFromPriceFilter

	$return_arr = $defaultUserArray;

    $first = 0;
	if(!empty($return_arr)){
		foreach ($return_arr as $filteredUser) {
			$vendor_int = (int) $filteredUser;

			$vendor = get_mvx_vendor($vendor_int);
			$cityName = $_POST['cityName'];

			// Get the delivery type for the vendor so we know if it is local or freight.
			// The delivery type of the store
		  $delivery_type = get_field('delivery_type','user_'.$vendor->id);
		  $delivery_type = (!empty($delivery_type['0']['value']) ? $delivery_type['0']['value'] : 0);

			if($delivery_type == 0 && $first == 0){
				get_template_part('template-parts/vendor-freight-heading', null, array('cityName' => $cityName));
				$first = 1;
			}
			// call the template with pass $vendor variable
			get_template_part('template-parts/vendor-loop', null, array('vendor' => $vendor, 'cityName' => $cityName));
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
add_action( 'wp_ajax_lpFilterAction', 'lpFilterAction' );
add_action( 'wp_ajax_nopriv_lpFilterAction', 'lpFilterAction' );


/**
 * Filtering on the category pages.
 *
 * @access public
 * @author Dennis Lauritzen
 */

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


	if(count($filteredCatOccaDeliveryArrayUnique) > 0 ){
		foreach ($filteredCatOccaDeliveryArrayUnique as $filteredUser) {
			$vendor = get_mvx_vendor($filteredUser);

			// call the template with pass $vendor variable
			get_template_part('template-parts/vendor-loop', null, array('vendor' => $vendor));
		}
	} else { ?>
	<div>
		<p id="noVendorFound" style="margin-top: 50px; margin-bottom: 35px; padding: 15px 10px; background-color: #f8f8f8;">No vendors were found matching your selection.</p>
	</div>
	<?php
	}

	wp_die();
}
if ( !is_cart() && !is_checkout() ) {
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
function vendStoreActionJavascript() {

}

function productFilterAction() {

	// default product id array come from front end
	$defaultProductIdAsString = $_POST['defaultProductIdAsString'];
	$defaultProductIdArray = explode(",", $defaultProductIdAsString);
	$default_placeholder = array_fill(0, count($defaultProductIdArray), '%d');

	// Get secrets & info
	$nn = $_POST['nn'];
	$gid = (int) $_POST['gid'];
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

    #var_dump($inputPriceRangeArray);

	// after click filter data keep on this array
	$catIDs = !empty($_POST['catIds']) ? $_POST['catIds'] : array();

    $occIDs = !empty($_POST['occIds']) ? $_POST['occIds'] : array();

#	$query = array(
#        'post_type' => 'product',
#        'post_status' => 'publish',
#        'author' => $gid,
#        'meta_query' => array(
#            array(
#                'key' => '_price',
#                // 'value' => array(50, 100),
#                'value' => array($inputMinPrice, $inputMaxPrice),
#                'compare' => 'BETWEEN',
#                'type' => 'NUMERIC'
#            )
#        )
#	);

    $query = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'author' => $gid,
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => '_price',
                'value' => array($inputMinPrice, $inputMaxPrice),
                'compare' => 'BETWEEN',
                'type' => 'NUMERIC',
            ),
            array(
                'key' => '_price',
                'compare' => 'NOT EXISTS', // Exclude products with no specific price
            ),
            array(
                'relation' => 'AND',
                array(
                    'key' => '_price',
                    'compare' => 'EXISTS', // Include products with price
                ),
                array(
                    'key' => '_price',
                    'value' => array($inputMinPrice, $inputMaxPrice),
                    'compare' => 'BETWEEN',
                    'type' => 'NUMERIC',
                ),
            ),
        ),
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
	$loop = new WP_Query($query);
    #var_dump($loop->have_posts());

	if ( $loop->have_posts() ) {
		while ( $loop->have_posts() ) {
            $loop->the_post();
            wc_get_template_part( 'content', 'product' );
        }
	} else { ?>

	<div>
		<p id="noProductFound" style="margin-top: 50px; margin-bottom: 35px; padding: 15px 10px; background-color: #f8f8f8;">
			Der blev desværre ikke fundet nogle produkter, der matchede dine filtre.
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
					$new_order_statuses['wc-order-mail-open'] = 'Vendor Opened Mail';
					$new_order_statuses['wc-order-seen'] = 'Order Seen by Vendor';
					$new_order_statuses['wc-order-forwarded'] = 'Order Forwarded to Vendor';
					$new_order_statuses['wc-order-accepted'] = 'Vendor Accepted';
          $new_order_statuses['wc-delivered'] = 'Leveret';
        }
				if( 'wc-on-hold' === $key ){
					unset( $new_order_statuses['wc-on-hold'] );
				}
    }

    return $new_order_statuses;
}

function get_order_hashes($order_id){
	$oh = hash('md4','gree_ting_dk#!4r1242142fgriejgfto'.$order_id.$order_id);
	$sshh = hash('md4', 'vvkrne12onrtnFG_:____'.$order_id);

	return array(
		'oh' => $oh,
		'sshh' => $sshh
	);
}

// Add your custom order status action button (for orders with "processing" status)
add_filter( 'woocommerce_admin_order_actions', 'add_custom_order_status_actions_button', 100, 2 );
function add_custom_order_status_actions_button( $actions, $order ) {
    // Get Order ID (compatibility all WC versions)
    $order_id = method_exists( $order, 'get_id' ) ? $order->get_id() : $order->id;

    // Display the button for all orders that have a 'processing' status
    if ( $order->has_status( array( 'processing', 'order-mail-open', 'order-seen', 'order-forwarded', 'order-accepted' ) ) ) {
        // Set the action button
        $actions['delivered'] = array(
            'url'       => wp_nonce_url( admin_url( 'admin-ajax.php?action=woocommerce_mark_order_status&status=delivered&order_id=' . $order_id ), 'woocommerce-mark-order-status' ),
            'name'      => __( 'Order Delivered', 'woocommerce' ),
            'action'    => "view delivered", // keep "view" class for a clean button CSS
        );
    }

		if ( $order->has_status( array( 'completed', 'delivered', 'processing', 'order-mail-open', 'order-seen', 'order-forwarded', 'order-accepted' ) ) ) {
			$oh = hash('md4','gree_ting_dk#!4r1242142fgriejgfto'.$order_id.$order_id);
			$sshh = hash('md4', 'vvkrne12onrtnFG_:____'.$order_id);

			// Set the action button
			$actions['open_tracking_link'] = array(
					'url'       => '/shop-order-status/?order_id=' . $order_id .'&oh=' . $oh . '&sshh=' . $sshh,
					'name'      => __( 'Open tracking link', 'woocommerce' ),
					'action'    => "tracking link", // keep "view" class for a clean button CSS
			);
		}

    return $actions;
}

// Set Here the WooCommerce icon for your action button
add_action( 'admin_head', 'add_custom_order_status_actions_button_css' );
function add_custom_order_status_actions_button_css() {
    echo '<style>
		.view.delivered::after { font-family: woocommerce; content: "\1F69A" !important; }
		.tracking.link::after { font-family: woocommerce; content: "\1F6E0" !important; }
		</style>';
}

/**
 * Email send to store owner
 *
 * @todo check for possible injection
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
 */
add_action( 'woocommerce_after_checkout_validation', 'greeting_check_delivery_postcode', 10, 2);
function greeting_check_delivery_postcode( $fields, $errors ){
	global $wpdb, $WCMp;

	$storeProductId = 0;
	// Get $product object from Cart object
	$cart = WC()->cart->get_cart();

	foreach( $cart as $cart_item_key => $cart_item ){
		$product = $cart_item['data'];
		$storeProductId = (!empty($product->get_parent_id()) ? (($product->get_parent_id() == 0) ? $product->get_id() : $product->get_parent_id()) : $product->get_id());
		#print "<p>Store ID: ";var_dump($storeProductId);print "</p>";
	}

	$vendor_id = get_post_field( 'post_author', $storeProductId );
	#print "<p>Vendor ID: ";var_dump($vendor_id);print "</p>";
	$vendor = get_mvx_vendor($vendor_id);

	// get vendor delivery zips
	$vendorDeliveryZipsRow = $wpdb->get_row( "
		SELECT * FROM {$wpdb->prefix}usermeta
		WHERE user_id = {$vendor_id}
		AND meta_key = 'delivery_zips'
	" );
	$vendorDeliveryZipsBilling = $vendorDeliveryZipsRow->meta_value;

	$vendorRelatedPCBillingWithoutComma = str_replace(" ","",$vendorDeliveryZipsBilling);
	$vendorRelatedPCBillingWCArray = explode(",", $vendorRelatedPCBillingWithoutComma);

	$ship_postcode = (int) trim($fields['shipping_postcode']);
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

		if($city && $city->posts && count($city->posts) > 0 && is_object($vendor)){
			$errors->add( 'validation', '<p style="line-height:150%;">Beklager - den valgte butik kan ikke levere til '.$city->posts[0]->post_title.'. Du kan <a href="'.$vendor->get_permalink().'">gå til butikkens side</a> og se hvilke postnumre de leverer til eller <a href="'.get_permalink($city->posts[0]->ID).'">klikke her og se butikker der leverer i postnummer '.$city->posts[0]->post_title.'</a></p>' );
		} else {
			$errors->add( 'validation', 'Beklager - butikken kan desværre ikke levere til det postnummer, du har indtastet under levering. Du bedes enten ændre leveringens postnummer eller gå til <a href="'.home_url().'">forsiden</a> for at finde en butik i det ønskede postnummer.' );
		}
	}
}



#add_action( 'woocommerce_after_checkout_form', 'greeting_show_hide_calendar' );
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
	$dates = get_vendor_dates_new($vendor_id, 'd-m-Y', 'close');
    $dates_values_only = array_values($dates);
    $dates_json = json_encode($dates_values_only);
?>

   <script type="text/javascript">
	 // Validates that the input string is a valid date formatted as "mm/dd/yyyy"
		 function isValidDate(dateString)
		 {
				// First check for the pattern
				if(!/^\d{1,2}\-\d{1,2}\-\d{4}$/.test(dateString))
						return false;

				// Parse the date parts to integers
				var parts = dateString.split("-");
				var day = parseInt(parts[0], 10);
				var month = parseInt(parts[1], 10);
				var year = parseInt(parts[2], 10);

				// Check the ranges of month and year
				if(year < 1000 || year > 3000 || month == 0 || month > 12)
						return false;

				var monthLength = [ 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ];

				// Adjust for leap years
				if(year % 400 == 0 || (year % 100 != 0 && year % 4 == 0))
						monthLength[1] = 29;

				// Check the range of the day
				return day > 0 && day <= monthLength[month - 1];
		 };

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

                    jQuery('#datepicker').datepicker({
                        dateFormat: 'dd-mm-yy',
                        // minDate: -1,
                        minDate: new Date(),
                        // maxDate: "+1M +10D"
                        maxDate: "+58D",
                        // closed on specific date
                        beforeShowDay: function(date){
                            var string = jQuery.datepicker.formatDate('dd-mm-yy', date);
                            return [ vendorClosedDayArray.indexOf(string) == -1 ];
                        },
                        onClose: function(date, datepicker){
                            const par_elm = jQuery(this).closest('.form-row');

                            if (!isValidDate(date) || date == '') {
                                par_elm.addClass('has-error');
                            } else {
                                par_elm.removeClass('has-error').addClass('woocommerce-validated');
                                jQuery("#datepicker_field label.error").css('display','none');
                            }
                        },
                        errorPlacement: function(error, element) { }
                    }).datepicker( "show" );
                    jQuery(".ui-datepicker").addClass('notranslate');
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

		// -----------------------
		// Get data from child order.
		$order = wc_get_order( $order_id );
		$vendor_id = 0;
		foreach ($order->get_items() as $item_key => $item) {
			$product = get_post($item['product_id']);
			$vendor_id = $product->post_author;

			$vendor_name = get_user_meta($vendor_id, '_vendor_page_title', 1);

			if(!empty($vendor_id)){
				update_post_meta($order_id, '_vendor_id', $vendor_id);
				update_post_meta($order_id, '_vendor_name', $vendor_name);
				break;
			}
		}

    if ( $_POST['delivery_date'] ) update_post_meta( $order_id, '_delivery_date', esc_attr( $_POST['delivery_date'] ) );
		if ( $_POST['delivery_date'] ){
			$post_date = $_POST['delivery_date'];
			$d_date = substr($post_date, 0, 2);
			$d_month = substr($post_date, 3, 2);
			$d_year = substr($post_date, 6, 4);
			$unix_date = date("U", strtotime($d_year.'-'.$d_month.'-'.$d_date));
			update_post_meta( $order_id, '_delivery_unixdate', esc_attr( $unix_date ) );
            update_post_meta( $order_id, '_delivery_date', esc_attr( $post_date )  );
		} else {
			$vendor_del_days = (int) get_field('vendor_require_delivery_day', 'user_'.$vendor_id);
			$vendor_drop_off = (int) get_field('vendor_drop_off_time', 'user_'.$vendor_id);
			$vendor_opening_days = get_field('openning', 'user_'.$vendor_id);
			$delivery_date = estimateDeliveryDate($vendor_del_days, $vendor_drop_off, $vendor_opening_days, 'U');

			update_post_meta( $order_id, '_delivery_unixdate', esc_attr( $delivery_date ) );
		}
		if ( $_POST['greeting_message'] ) update_post_meta( $order_id, '_greeting_message', esc_attr( $_POST['greeting_message'] ) );
		if ( $_POST['receiver_phone'] ) update_post_meta( $order_id, '_receiver_phone', esc_attr( $_POST['receiver_phone'] ) );

		if ( $_POST['delivery_instructions'] ) update_post_meta( $order_id, '_delivery_instructions', esc_attr( $_POST['delivery_instructions'] ) );

		if ( $_POST['leave_gift_address'] ) update_post_meta( $order_id, '_leave_gift_address', esc_attr( $_POST['leave_gift_address'] ) );
		if ( $_POST['leave_gift_neighbour'] ) update_post_meta( $order_id, '_leave_gift_neighbour', esc_attr( $_POST['leave_gift_neighbour'] ) );




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

#add_action( 'mvx_checkout_vendor_order_processed' , 'update_sub_order_meta' ,10 , 3);
function update_sub_order_meta($vendor_order_id, $posted_data, $order){
	global $WCMp;

	$vendor_order = wc_get_order($vendor_order_id);
	$vendor_id = get_post_meta($vendor_order_id, '_vendor_id', true);

	#$vendor_id = get_post_meta($vendor_order_id, '_vendor_id', true);
}



add_action( 'woocommerce_admin_order_data_after_billing_address', 'greeting_delivery_date_display_admin_order_meta' );
function greeting_delivery_date_display_admin_order_meta( $order ) {
   $str = '<p><strong>Leveringsdato:</strong> ';
	 if ( !empty(get_post_meta( $order->get_id(), '_delivery_date', true )) ) {
		 $str .= get_post_meta( $order->get_id(), '_delivery_date', true );
	 } else {
		 $str .= 'Hurtigst muligt ('. get_post_meta( $order->get_id(), '_delivery_unixdate', true ).')';
	 }
	 //$str .= '('.get_post_meta( $order->get_id(), '_delivery_unixdate', true ).')';
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
 * Add a custom field (in an order) to the emails-old
 *
 * @since v1.0
 * @author Dennis
 */
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
add_filter( 'woocommerce_email_order_meta_fields', 'custom_woocommerce_email_order_meta_fields', 10, 3 );
#do_action('mvx_checkout_vendor_order_processed', $vendor_order_id, $posted_data, $order);



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


/**
 * @param $posted_data
 * @return void
 */
function checkout_message_choice_to_session( $posted_data ) {
    parse_str( $posted_data, $output );
    if ( isset( $output['message-pro'] ) ){
        WC()->session->set( 'message-pro', $output['message-pro'] );
    }
}
add_action( 'woocommerce_checkout_update_order_review', 'checkout_message_choice_to_session' );

/**
 * Function for the greeting text / greeting message
 * #greeting_text #greeting_meesage
 *
 * @author Dennis Lauritzen
 * @return void
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
	if(mb_strlen(trim($_POST['greeting_message']),'UTF-8') > 165){
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


function admin_order_preview_add_receiver_info_custom_meta_data( $data, $order ) {
    if( $receiver_info_value = $order->get_meta('receiver_phone') )
        $data['receiver_info_key'] = $receiver_info_value; // <= Store the value in the data array.
    	return $data;
}
// Add custom order meta data to make it accessible in Order preview template
add_filter( 'woocommerce_admin_order_preview_get_order_details', 'admin_order_preview_add_receiver_info_custom_meta_data', 10, 2 );


function custom_display_order_receiver_info_data_in_admin(){
    // Call the stored value and display it
    echo '<div style="margin:5px 0px 0px 15px;"><strong>Receiver Info:</strong> {{data.receiver_info_key}}</div>';
}
// Display order date in admin order preview
add_action( 'woocommerce_admin_order_preview_start', 'custom_display_order_receiver_info_data_in_admin' );

// Display receiver info in vendor dashboard  order preview
// add_action( 'mvx_vendor_dashboard_content', 'vendor_custom_display_order_receiver_info_data_in_admin' );
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

/**
 * redirect pages for restricted page
 *
 * @return void
 */
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
 * Only show one store at a time
 *
 * @author Dennis Lauritzen
 * @return void
 */
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
				$vendor_data = get_mvx_product_vendors($product_id);
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
		add_action( 'after_mvx_vendor_description', 'show_shop_only_one_store_same_time_notice', 5 );
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
//  add_action('init', 'greeting_shop_only_one_store_same_time');
add_action('wp_loaded', 'greeting_shop_only_one_store_same_time');


/**
 *
 * The notice when someone shops in more than one store.
 * Should be localized and danish
 *
 * @todo Dennis - translate
 * @todo Dennis - set up with localization.
 *
 * @author Dennis Lauritzen
 * @return void
 */
// show shop only one store same time notice
function show_shop_only_one_store_same_time_notice(){
	$notice = 'Øv - vi kan se, du har produkter fra flere butikker i kurven. Du kan på nuværende tidspunkt kun handle i én butik ad gangen. Gå til kurven og sørg for, der kun er produkter fra én butik i kurven, før du kan gennemføre';
	wc_print_notice($notice, 'error');
}

/**
 * Remove report abuse link
 *
 * @author Dennis Lauritzen
 */
add_filter('mvx_show_report_abuse_link', '__return_false');

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
    wc_print_notice( 'Greeting.dk er lukket ned pga. vedligehold netop nu, desværre :)', 'error');
}


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
add_action( 'woocommerce_single_product_summary', 'reorder_product_page_hooks', 1 );


function reorder_product_page_after_product_hooks(){
	remove_action('woocommerce_after_single_product_summary','woocommerce_output_product_data_tabs', 10);
	remove_action('woocommerce_after_single_product_summary','woocommerce_upsell_display', 15);
	remove_action('woocommerce_after_single_product_summary','woocommerce_output_related_products', 20);

	add_action('woocommerce_after_single_product_summary','add_vendor_info_to_product_page', 5);
	add_action('woocommerce_after_single_product_summary','woocommerce_output_related_products', 10);
}
add_action( 'woocommerce_after_single_product_summary', 'reorder_product_page_after_product_hooks', 1 );

/**
 * Add the vendor information block to the product page
 *
 * @author Dennis Lauritzen
 * @return void
 */
function add_vendor_info_to_product_page(){
    wc_get_template( 'single-product/vendor-information.php' );
}


/**
 * Change the way the price is shown for variable products
 *
 * @param $price
 * @param $product
 * @return mixed|null
 */
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
add_filter( 'woocommerce_get_price_html', 'change_variable_products_price_display', 10, 2 );

/**
 * Change currency symbol for danish goods.
 *
 * @param $currency_symbol
 * @param $currency
 * @return mixed|string
 */
function greeting_change_dk_currency_symbol( $currency_symbol, $currency ) {
    switch( $currency ) {
        // DKK til kr
        case 'DKK': $currency_symbol = 'kr.'; break;
    }
    return $currency_symbol;
}
add_filter('woocommerce_currency_symbol', 'greeting_change_dk_currency_symbol', 10, 2);


// Utility function to get the price of a variation from it's attribute value

// Add a filter for always showing the variation price - the default settings is, that if
// the variations have same price, it is not shown.
add_filter( 'woocommerce_show_variation_price', '__return_true');

// Function for getting the price for the current variation for the select dropdown
function get_the_variation_price_html( $product, $name, $term_slug ){
    foreach ( $product->get_available_variations() as $variation ){
        if($variation['attributes'][$name] == $term_slug ){
            $price = empty($variation['price_html']) ? $variation['display_regular_price'] : $variation['price_html'];
            return strip_tags( $price );
        }
    }
}

function get_the_variation_price( $product, $name, $term_slug ){
    foreach ( $product->get_available_variations() as $variation ){
        if($variation['attributes'][$name] == $term_slug ){
            $price = $variation['display_price'];
            return strip_tags( $price );
        }
    }
}

/**
 * Function for showing the price in the attribute dropdown on product pages
 *
 * @param $html
 * @param $args
 * @return mixed|string
 */
function show_price_in_attribute_dropdown( $html, $args ) {
    // Only if there is a unique variation attribute (one dropdown)
    if( sizeof($args['product']->get_variation_attributes()) == 1 ) :

        $options               = $args['options'];
        $product               = $args['product'];
        $attribute             = $args['attribute'];
        $name                  = $args['name'] ? $args['name'] : 'attribute_' . sanitize_title( $attribute );
        $id                    = $args['id'] ? $args['id'] : sanitize_title( $attribute );
        $class                 = $args['class'];
        $show_option_none      = (bool) $args['show_option_none'];
        $show_option_none_text = $args['show_option_none'] ? $args['show_option_none'] : __( 'Choose an option', 'woocommerce' );

        if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute ) ) {
            $attributes = $product->get_variation_attributes();
            $options    = $attributes[ $attribute ];
        }

        $html = '<select id="' . esc_attr( $id ) . '" class="' . esc_attr( $class ) . '" name="' . esc_attr( $name ) . '" data-attribute_name="attribute_' . esc_attr( sanitize_title( $attribute ) ) . '" data-show_option_none="' . ( $show_option_none ? 'yes' : 'no' ) . '">';
        $html .= '<option value="">' . esc_html( $show_option_none_text ) . '</option>';

        if ( ! empty( $options ) ) {
            $option_value_arr = array();

            if ( $product && taxonomy_exists( $attribute ) ) {
                $terms = wc_get_product_terms( $product->get_id(), $attribute, array( 'fields' => 'all' ) );

                foreach ( $terms as $term ) {
                    if ( in_array( $term->slug, $options ) ) {
                        // Get and inserting the price
                        $price_html = get_the_variation_price_html( $product, $name, $term->slug );
                        $price_raw = get_the_variation_price($product, $name, $term->slug);

                        $price_title_text = (empty($price_html) ? esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name ) ) : esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name ) . ' (' . $price_html . ')' ) );
                        $content = '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $args['selected'] ), $term->slug, false ) . '>' . $price_title_text  . '</option>';
                        $option_value_arr[$term->slug] = array('price' => $price_raw, 'title_text' => $price_title_text, 'html' => $content);
                    }
                }
            } else {
                foreach ( $options as $option ) {
                    $selected = sanitize_title( $args['selected'] ) === $args['selected'] ? selected( $args['selected'], sanitize_title( $option ), false ) : selected( $args['selected'], $option, false );
                    // Get and inserting the price
                    $price_html = get_the_variation_price_html( $product, $name, $option->slug );
                    $price_raw = get_the_variation_price($product, $name, $option->slug);

                    $option_title_text = ( empty($price_html) ? esc_html(apply_filters( 'woocommerce_variation_option_name', $option )) : esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) . ' (' . $price_html . ')' ) );
                    $content = '<option value="' . esc_attr( $option ) . '" ' . $selected . '>' . $option_title_text . '</option>';

                    $option_value_arr[$option->slug] = array('price' => $price_raw, 'title_text' => $option_title_text, 'html' => $content);
                }
            }

            // Sort the array by price using an anonymous function
            usort($option_value_arr, function($a, $b) {
                if ($a['price'] == $b['price']) {
                    return 0;
                }
                return ($a['price'] < $b['price']) ? -1 : 1;
            });

            foreach($option_value_arr as $k => $v){
                $html .= $v['html'];
            }

        }

        $html .= '</select>';

    endif;

    return $html;
}
add_filter( 'woocommerce_dropdown_variation_attribute_options_html', 'show_price_in_attribute_dropdown', 10, 2);


/**
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

		jQuery('.plus-qty').click(function(e) {
				incrementValue(e);
		});

		jQuery('.minus-qty').click(function(e) {
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
			'input_class'	=> 'validate[required]',
			'label'				=> __('Din hilsen til modtager (max 160 tegn)', 'greeting2'),
			'placeholder'	=> __('Skriv din hilsen til din modtager her :)', 'greeting2'),
			'maxlength' 	=> 160
		), WC()->checkout->get_value( 'greeting_message' ) );

        echo '
        <div style="padding: 6px 10px; font-size: 12px; font-family: Inter,sans-serif; margin-top: -5px;  margin-bottom: 10px; background: #fafafa; color: #666666;">
            Da vores kort med hilsener er håndskrevne, kan vi ikke indsætte emojis, men vi forsøger at gengive dem på bedst mulig vis.   
        </div>
        ';

		woocommerce_form_field( 'receiver_phone', array(
			'type'          => 'tel',
			'class'         => array('form-row-wide', 'greeting-custom-input'),
			'input_class'		=> array('input-text validate[required] validate[custom[phone]'),
			'required'      => true,
			'label'         => __('Modtagerens telefonnr.', 'greeting2'),
			'placeholder'       => __('Indtast modtagerens telefonnummer.', 'greeting2'),
			), WC()->checkout->get_value( 'receiver_phone' ));
		#echo '<tr class="message-pro-radio"><td>';

        echo '
        <div style="padding: 6px 10px; font-size: 12px; font-family: Inter,sans-serif; margin-top: -5px; margin-bottom: 10px; background: #fafafa; color: #666666;">
            Telefonnummeret bruges <b>kun</b> i forbindelse med selve leveringen, hvis vi modtageren eks. ikke åbner, eller vi skal bruge deres hjælp til at finde indgangen.<br>
            Vi sender ikke nogen information om bestillingen - hverken før, under eller efter levering.
        </div>
        ';

		echo '<h3>Leveringsinstruktioner</h3>
		<style type="text/css">
			input#deliveryLeaveGiftAddress,
			input#deliveryLeaveGiftNeighbour {
				width: 18px;
				height: 18px;
			}
		</style>
		';

		woocommerce_form_field( 'leave_gift_address', array(
			'type'				=> 'checkbox',
			'id'					=> 'deliveryLeaveGiftAddress',
			'class'				=> array('form-row-wide'),
			'label_class' => array(''),
			'input_class' => array('input-checkbox'),
			'label'				=> __('Ja, gaven må efterlades på adressen', 'greeting2'),
			'placeholder'	=> '',
			'required' 		=> false,
			'default' 		=> 1
		), 1 );

		woocommerce_form_field( 'leave_gift_neighbour', array(
			'type'				=> 'checkbox',
			'id'					=> 'deliveryLeaveGiftNeighbour',
			'class'				=> array('form-row-wide'),
			'input_class' => array('input-checkbox'),
			'label'				=> __('Ja, gaven må afleveres til/hos naboen', 'greeting2'),
			'placeholder'	=> '',
			'required' 		=> false,
			'default' 		=> 1
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

function get_vendor_delivery_days_required($vendor_id, $type = 'weekday'){
    $get_deliveryday_required_repeater = get_field('vendor_require_order_days_before', 'user_'.$vendor_id);

    if(empty($get_deliveryday_required_repeater)){
        $delday_req = get_field('vendor_require_delivery_day', 'user_'.$vendor_id);
        return $delday_req;
    } else {
        if($type == 'holiday'){
            return (!empty($get_deliveryday_required_repeater['order_days_before_holiday']) ? $get_deliveryday_required_repeater['order_days_before_holiday'] : 0);
        } else if($type == 'weekend') {
            return (!empty($get_deliveryday_required_repeater['order_days_before_weekend']) ? $get_deliveryday_required_repeater['order_days_before_weekend'] : 0);
        } else {
            return (!empty($get_deliveryday_required_repeater['order_days_before_weekday']) ? $get_deliveryday_required_repeater['order_days_before_weekday'] : 0);
        }
    }
}

/**
 * Function for getting the closed dates from the Vendor.
 * Either from the text field - or from the repeater field
 *
 * @author Dennis Lauritzen <dl@dvlp-consult.dk
 * @param $vendor_id integer
 * @return array
 */
function get_vendor_closed_dates($vendor_id){
    // Get the closed days / dates for the vendor.

    // TEXT FIELD
    // Get the closed dates from the text field
    $vendorClosedDay = get_user_meta($vendor_id, 'vendor_closed_day', true);
    $meta_closed_days = empty($vendorClosedDay) ? get_field('vendor_closed_day', 'user_'.$vendor_id) : $vendorClosedDay;

    // Split the closed dates
    $vendor_closed_days_text = (!empty($meta_closed_days) ? preg_split('/[, ]+/', $meta_closed_days, -1, PREG_SPLIT_NO_EMPTY) : array());

    // REPEATER FIELD
    // If the closed dates from the text field is empty, get it from
    $vendor_closed_days_repeater = get_field('vendor_closed_dates', 'user_'.$vendor_id);

    // Set the array
    $closed_dates_array = array();

    # We could think about merging the two arrays (TEXT & REPEATER) if both are set:
    #return array_merge($vendor_closed_days_text, $vendor_closed_days_repeater);

    if(!empty($vendor_closed_days_repeater)
    && is_array($vendor_closed_days_repeater)
    && $vendor_closed_days_text != $vendor_closed_days_repeater){
        return array_map(function($item) {
            if(empty($item) || empty($item['closing_dates'])){
                return;
            }

            $closingDate = DateTime::createFromFormat('d/m/Y', $item['closing_dates']);
            return $closingDate->format('d-m-Y');
        }, $vendor_closed_days_repeater);
    } else {
        return array_filter($vendor_closed_days_text, function ($element) {
            return is_string($element) && '' !== trim($element);
        });
        // Old days this was done this way: $closedDatesArr		= array_map('trim', explode(",",$delClosedDates));
        #$closed_dates_array = $vendor_closed_days_text;
    }
}

/**
 * Function for getting the dropoff time for a specific vendor.
 *
 * @param $vendor_id
 * @param $type weekday|weekend|holiday
 * @return string
 */
function get_vendor_dropoff_time($vendor_id, $type = 'weekday'){
    // Get the vendor dropoff time the old way
    // Get the dropoff time metavalue for the vendor.
    #$vendorDropOffTime = ($type == 'weekend' ? get_user_meta($vendor_id, 'vendor_drop_off_time_weekend', true) : get_user_meta($vendor_id, 'vendor_drop_off_time', true));
    $vendor_dropoff_time = get_field('vendor_drop_off_time', 'user_'.$vendor_id);
    $vendor_dropoff_time = empty($vendor_dropoff_time)?: get_user_meta($vendor_id, 'vendor_drop_off_time', true);

    $vendor_cutoff_times = get_field('vendor_cutoff_times', 'user_'.$vendor_id);

    // Get the new vendor dropoff time.
    if(!empty($vendor_cutoff_times) && count($vendor_cutoff_times) > 0){
        if($type == 'weekend' && !empty($vendor_cutoff_times['cutoff_time_weekend'])) {
            $vendor_dropoff_time = $vendor_cutoff_times['cutoff_time_weekend'];
        } else if($type == 'holiday' && !empty($vendor_cutoff_times['cutoff_time_holiday'])) {
            $vendor_dropoff_time = $vendor_cutoff_times['cutoff_time_holiday'];
        } else if($type == 'weekday'  && !empty($vendor_cutoff_times['cutoff_time_weekday'])) {
            $vendor_dropoff_time = $vendor_cutoff_times['cutoff_time_weekday'];
        }
    }

    if(strpos($vendor_dropoff_time,':') === false && strpos($vendor_dropoff_time,'.') === false){
        $vendor_dropoff_time = $vendor_dropoff_time.':00';
    } else {
        $vendor_dropoff_time = str_replace(array(':','.'),array(':',':'),$vendor_dropoff_time);
    }

    return $vendor_dropoff_time;
}

function get_vendor_name($vendor_id){
    if(empty($vendor_id) || !is_numeric($vendor_id)){
        return;
    }

    global $WCMp;

    $vendor = get_mvx_vendor($vendor_id);

    return ucfirst(esc_html($vendor->page_title));
}


/**
 * Function for getting text for delivery days until the vendor can delivery
 *
 * @param $vendor_id
 * @param $prepend_text
 * @param $html_container the HTML container to have around the delivery text. Placeholder is {placeholder}
 * @return array|mixed|string|string[]
 */
function get_vendor_delivery_date_text($vendor_id, $prepend_text = '', $html_container = ''){
    ///////////////////////////
    // Days until delivery
    $delivery_days 		= get_vendor_days_until_delivery($vendor_id);

    switch($delivery_days) {
        case 0:
            $text = 'i dag';
            break;
        case 1:
            $text = 'i morgen';
            break;
        case 2:
            $text = 'i overmorgen';
            break;
        default:
            $text = 'om '.$delivery_days.' dage';
            break;
    }

    if(!empty($html_container)) {
        $text = str_replace('{placeholder}', $text, $html_container);
    }

    $text = (empty($prepent_text) ? $text : $prepend_text.$text);
    return $text;
}

/**
 * @param $vendor_id
 * @param $return_type
 * @return string|array
 */
function get_vendor_delivery_type($vendor_id, $return_type = 'type'){
    // Get delivery type.
    $del_type = '';
    $del_value = '';

    $delivery = get_field('delivery_type', 'user_'.$vendor_id);

    if(!empty($delivery)){
        $delivery_type = $delivery[0];

        if(empty($delivery_type['label'])){
            $del_value = $delivery_type;
            $del_type = $delivery_type;
        } else {
            $del_value = $delivery_type['value'];
            $del_type = $delivery_type['label'];
        }
    }

    if($return_type == 'type'){
        return $del_type;
    } else if($return_type == 'value'){
        return $del_value;
    } else {
        return array('value' => $del_value, 'type' => $del_type);
    }
}

function get_vendor_delivery_dates_extraordinary($vendor_id){
    $extraordinary_dates = get_field('vendor_open_dates_extraordinary', 'user_'.$vendor_id);

    // Check if $extraordinary_dates is empty, and return an empty array if true
    if (empty($extraordinary_dates)) {
        return array();
    }

    return array_map(function ($item) {
        if(empty($item) || empty($item['opening_date'])){
            return;
        }

        $openingDate = DateTime::createFromFormat('d/m/Y', $item['opening_date']);
        return $openingDate ? $openingDate->format('d-m-Y') : null;
    }, $extraordinary_dates);
}

function get_global_days($type = 'closed') {
    $result = [];

    if ($type != 'closed' && $type != 'holidays') {
        return $result;
    }

    if ($type == 'holidays') {
        $holidays = get_field('global_holidays', 'option');

        // Check if $closed_dates is empty
        if (empty($holidays)) {
            return []; // Return an empty array
        }

        return array_map(function ($item) {
            $closingDate = DateTime::createFromFormat('d/m/Y', $item['holiday_date']);
            return $closingDate ? $closingDate->format('d-m-Y') : null;
        }, $holidays);
    } else {
        $closed_dates = get_field('global_closed_dates', 'option');

        // Check if $closed_dates is empty
        if (empty($closed_dates)) {
            return []; // Return an empty array
        }

        return array_map(function ($item) {
            if(empty($item) || empty($item['closed_date'])){
                return;
            }

            $closingDate = DateTime::createFromFormat('d-m-Y', $item['closed_date']);
            return $closingDate ? $closingDate->format('d-m-Y') : null;
        }, $closed_dates);
    }
}


/**
 * Function to get all closed dates calculated
 * from opening days, closed dates etc.
 *
 * @author Dennis
 */
function get_vendor_dates($vendor_id, $date_format = 'd-m-Y', $open_close = 'close'){
	global $wpdb;

    #var_dump(get_field('vendor_require_order_days_before','user_'.$vendor_id));
    #var_dump(get_vendor_dates_new($vendor_id, $date_format, $open_close, 60));

	// Explicitly set arrays used in the formula.
	$open_days = array();
    $closed_days = array();
	$dates = array();

	// Get the time the store has chosen as their "cut-off" / drop-off for next order.
	$vendorDropOffTime = get_vendor_dropoff_time($vendor_id);
    #$vendorDropOffTimeWeekend = get_vendor_dropoff_time($vendor_id, 'weekend');

    // Get the number of days required for delivery by the vendor
    $vendorDeliveryDayReq = get_vendor_delivery_days_required($vendor_id);

	// @todo - Dennis update according to latest updates in closing day-field.
	// open close days begin. Generate an array of all days ISO.
	$default_days = ['1','2','3','4','5','6','7'];

	// Get the opening days string/array from the database and handle it.
	$opening_days = get_user_meta($vendor_id, 'openning', true); // true for not array return
    $closed_days = (is_array($opening_days) ? array_diff($default_days, $opening_days) : $closed_days);

	// Global closed dates (when Greeting.dk is totally closed).
	$global_closed_dates = array( '24-12-2023', '25-12-2023', '31-12-2022', '01-01-2023', '05-05-2023', '18-05-2023', '29-05-2023');

	// Explicitly set todays timezone and date, since there is some problems with this if not set explicitly.
	// Define today's timezone and date.
	$timezone = new DateTimeZone('Europe/Copenhagen');
	$today = new DateTime('now', $timezone); # $today is used for incrementing in the for loop.
	$now = new DateTime('now', $timezone); # $now is used for getting the time right now.

	// Get the explicitly defined closed DATES from admin (e.g. if one store is closed on a specific date)
	// Loop through the closed dates from admin.
    // The $closed_days_date array gets exploded, and then array_filter applied to make sure no empty items is left in the array.
    $closed_days_date = get_vendor_closed_dates($vendor_id);
	$closed_dates_arr = array();

	// Loop through the closed dates string from admin (exploded above)
	// Check if it is larger than today, if so then add to array of closed dates.
	if(!empty($closed_days_date)){
		foreach($closed_days_date as $ok_date){
            $the_date = trim($ok_date);
            $the_date = (strpos($the_date, ' ') == true) ? strstr($the_date, ' ', true) : $the_date;
            $date_time_object = new DateTime($the_date);
			if($date_time_object > $today){
				$closed_dates_arr[] = $date_time_object->format($date_format);
			}
		}
	}

	// Generate array of all open days for the next 60 days.
    ## Todo here: We need to make this so it can handle the weekend days.
	$vendorDeliveryDayRequiredCalculated = ($now->format('H:i') > $vendorDropOffTime) ? $vendorDeliveryDayReq+1 : $vendorDeliveryDayReq;
	$closed_num = 0;

	for($i=0;$i<60;$i++){
		if(in_array($today->format('N'), $closed_days)){
			// If the date is a day of the week, where the store is not opened, then...
			// @todo eliminate deliveryday requirement.
			$closed_days_date[] = $today->format($date_format);
			$closed_num++;
		} else if(in_array($today->format($date_format), $closed_dates_arr)){
			// If the date is explicitly closed in the admin closed dates array
			$closed_days_date[] = $today->format($date_format);
			$closed_num++;
		} else if(in_array($today->format($date_format), $global_closed_dates)) {
			// If the date is one of the globally closed dates, then...
			$closed_days_date[] = $today->format($date_format);
			$closed_num++;
		} else {
			if($i >= $vendorDeliveryDayRequiredCalculated){
                // The date is open, since it is later than the required dates.
				$dates[] = $today->format($date_format);
			} else {
				$closed_days_date[] = $today->format($date_format);
			}
		}

		$today->modify('+1 day');
	}

	// Return either the closed days or the open days, depending on the $open_close parameter.
	return $open_close == 'close' ? $closed_days_date : $dates;
}

function get_vendor_dates_new($vendor_id, $date_format = 'd-m-Y', $open_close = 'close', $num_dates = 60)
{
    if(empty($vendor_id)){
        return false;
    }

    global $wpdb;


    // Explicitly set arrays used in the formula.
    $open_days_arr = array();
    $closed_days_arr = array();
    $dates = array();

    // Get the number of days required for delivery by the vendor
    // Days before, that an order should be places for the date types.
    $vendor_order_delivery_days_before = get_vendor_delivery_days_required($vendor_id);
    $vendor_order_delivery_days_before_weekend = get_vendor_delivery_days_required($vendor_id, 'weekend');
    $vendor_order_delivery_days_before_holiday = get_vendor_delivery_days_required($vendor_id, 'holiday');
    ## Todo here: We need to make this so it can handle the weekend days.
    // Get the number of days required for delivery by the vendor
    #$vendorDeliveryDayReq = get_vendor_delivery_days_required($vendor_id);
    #$vendorDeliveryDayRequiredCalculated = ($now->format('H:i') > $vendorDropOffTime) ? $vendorDeliveryDayReq+1 : $vendorDeliveryDayReq;
    #$closed_num = 0;

    // Get the time the store has chosen as their "cut-off" / drop-off for next order.
    $vendor_dropoff_time = get_vendor_dropoff_time($vendor_id);
    $vendor_dropoff_time_weekend = get_vendor_dropoff_time($vendor_id, 'weekend');
    $vendor_dropoff_time_holiday = get_vendor_dropoff_time($vendor_id, 'holiday');

    // @todo - Dennis update according to latest updates in closing day-field.
    // open close days begin. Generate an array of all days ISO.
    $default_days = ['1','2','3','4','5','6','7'];

    // Get the opening days string/array from the database and handle it.
    $opening_days = !empty(get_user_meta($vendor_id, 'openning')) ? get_user_meta($vendor_id, 'openning', true) : get_field('openning', 'user_'.$vendor_id); // true for not array return
    $closed_days = (is_array($opening_days) ? array_diff($default_days, $opening_days) : array());

    // Get the global dates.
    // Global dates is defined by Greeting - and it is defining close days and "holidays"
    $global_closed_dates = get_global_days('closed');//array( '24-12-2023', '25-12-2023', '31-12-2022', '01-01-2023', '05-05-2023', '18-05-2023', '29-05-2023');
    $global_holidays = get_global_days('holidays');

    // Explicitly set todays timezone and date, since there is some problems with this if not set explicitly.
    // Define today's timezone and date.
    $timezone = new DateTimeZone('Europe/Copenhagen');
    $today = new DateTime('now', $timezone); # $today is used for incrementing in the for loop.
    $now = new DateTime('now', $timezone); # $now is used for getting the time right now.

    // Get the explicitly defined closed DATES from admin (e.g. if one store is closed on a specific date)
    // Loop through the closed dates from admin.
    // The $closed_days_date array gets exploded, and then array_filter applied to make sure no empty items is left in the array.
    $closed_dates_arr = get_vendor_closed_dates($vendor_id);

    // Get the explicitly set opening days.
    $open_days_extraordinary = get_vendor_delivery_dates_extraordinary($vendor_id);

    // If $num_dates is greater than 180, then we set it to 180 due to minimizing the load.
    $num_dates = ($num_dates > 180) ? 180 : $num_dates;

    for($i=0;$i<$num_dates;$i++){
        $datekey = $today->format('dmY');
        $date = $today->format($date_format);
        $date_weekday = $today->format('N');

        $is_open = true; // true or false - is this date open at the time?
        $is_closed = !$is_open; // true or false - is this date closed at the time? Will always be the opposite of $is_open
        $is_open_extraordinary_day = in_array($today->format('d-m-Y'), $open_days_extraordinary) ? true : false; // true or false
        $is_closed_date = in_array($today->format('d-m-Y'), $closed_dates_arr);
        $is_open_day_weekdays = in_array($today->format('N'), $opening_days) ? true : false;
        $is_holiday = in_array($date, $global_holidays) ? true : false;
        $is_global_closed_date = in_array($date, $global_closed_dates) ? true : false;

        $type = 'weekday';
        if ($date_weekday >= 1 && $date_weekday <= 5) {
            $type = 'weekday';
        } elseif ($date_weekday >= 6 && $date_weekday <= 7) {
            $type = 'weekend';
        }
        $type = in_array($today->format('d-m-Y'), $global_holidays) ? 'holiday' : $type;

        switch ($type) {
            case 'weekend':
                $cutoff = $vendor_dropoff_time_weekend;
                break;
            case 'holiday':
                $cutoff = $vendor_dropoff_time_holiday;
                break;
            default:
                $cutoff = $vendor_dropoff_time;
                break;
        }

        // Calculation of the specific cutoff time for this date.
        # @todo - Make the calculation
        $cutoff_datetime = new DateTime($today->format('d-m-Y '.$cutoff), $timezone);
        if($type == 'weekday'){
            $cutoff_datetime->modify('-'.$vendor_order_delivery_days_before.' day');
        } else if($type == 'weekend'){
            $cutoff_datetime->modify('-'.$vendor_order_delivery_days_before_weekend.' day');
        } else if($type == 'holiday'){
            $cutoff_datetime->modify('-'.$vendor_order_delivery_days_before_holiday.' day');
        }

        if($now->format('H:i') > $cutoff
        && $now->format('d-m-Y') == $today->format('d-m-Y')){
            $cutoff_datetime->modify('-1 day');
        }

        if(
            (!in_array($date_weekday, $opening_days)
            && !in_array($today->format('d-m-Y'), $open_days_extraordinary))
            ||
            (in_array($today->format('d-m-Y'), $closed_dates_arr)
            && !in_array($today->format('d-m-Y'), $open_days_extraordinary))
        ){

            $cutoff_datetime_val = false;
            $is_open = false;
        } else {
            $cutoff_datetime_val = $cutoff_datetime->format('d-m-Y H:i:s');
        }

        $dates[$datekey] = array(
            'date' => $date,
            'cutoff_datetime' => $cutoff_datetime_val, // the exact time you can order for this date.
            'cutoff_time' => $cutoff, // the value from the cutoff field based on the type of the date
            'is_open' => $is_open, // true or false - is this date closed at the time?
            'is_closed' => !$is_open, // true or false - is this date open at the time?
            'is_open_day_weekdays' => $is_open_day_weekdays,
            'is_closed_date' => $is_closed_date,
            'type' => $type,
            'is_extraordinary_date' => $is_open_extraordinary_day,
            'is_global_closed_date' => $is_global_closed_date,
            'is_holiday' => $is_holiday
        );

        // Last action, add 1 day.
        $today->modify('+1 day');
    }

    if($open_close === "all"){
        return $dates;
    }

    foreach ($dates as $key => $value) {
        $cutoffDatetime_static = $value['cutoff_datetime'];
        $date = DateTime::createFromFormat('d-m-Y', $value['date']);

        if($value['is_global_closed_date'] === true){
            $closed_days_arr[$key] = $date->format('d-m-Y');
            continue;
        }

        if ($cutoffDatetime_static) {

            $cutoffDatetime = DateTime::createFromFormat('d-m-Y H:i:s', $cutoffDatetime_static);

            if ($cutoffDatetime >= $now) {
                $open_days_arr[$key] = $date->format('d-m-Y');
            } else {
                $closed_days_arr[$key] = $date->format('d-m-Y');
            }
        } else {
            $closed_days_arr[$key] = $date->format('d-m-Y');
        }
    }

    #return $dates;
    // Return either the closed days or the open days, depending on the $open_close parameter.
    return $open_close == 'close' ? $closed_days_arr : $open_days_arr;
}

function estimateDeliveryDate($days = 1, $cut_off = 15, $iso_opening_days = array(1,2,3,4,5,6,7), $format = 'U')
{
	$iso_days = array(1,2,3,4,5,6,7);
	$iso_open_days = array();
	foreach($iso_opening_days as $k => $v){
		$iso_open_days[] = (int) $v['value'];
	}
	$close_days = array_diff($iso_days, $iso_open_days);

	$calc_days = 0;
	if(strpos($cut_off, '.') === false || strpos($cut_off,':') === false){
		if (date("H") <= $cut_off) {
			$calc_days = $days;
	  } else {
			$calc_days = $days+1;
	  }
	} else {
		if (date("H:i") <= $cut_off) {
			$calc_days = $days;
	  } else {
			$calc_days = $days+1;
	  }
	}

	$date_iso = date("N");

	$z = 0;
	for($i=$date_iso;$z<count($iso_days);$i++){
		if(in_array($i, $close_days)){
			$calc_days+=1;
		}

		if($i==7){
			$i = 1;
		}
		$z++;
	}

	$deliveryDate = new \DateTime("+".$calc_days." days");

  return $deliveryDate->format($format);
}

/**
 * @author Dennis
 * Functions for setting the order delivery date.
 * On step 3 in checkout.
 *
 * order date begin
 */
# add_action( 'woocommerce_review_order_before_payment', 'greeting_echo_date_picker' );
function greeting_echo_date_picker( ) {
	$storeProductId = '';
	// Get $product object from Cart object
	$cart = WC()->cart->get_cart();

	foreach( $cart as $cart_item_key => $cart_item ){
		$product = $cart_item['data'];
		$storeProductId = $product->get_id();
	}

	// Get vendor ID.
	$product = get_post($storeProductId);
	$vendor_id = (!empty($product->post_author) ? $product->post_author : get_post_field('post_author', $storeProductId));

	// Get delivery type.
    $del_value = get_vendor_delivery_type($vendor_id, 'value');

	// Get delivery day requirement, cut-off-time for orders and the closed dates.
	$vendorDeliverDayReq = get_vendor_delivery_days_required($vendor_id);
	$vendorDropOffTime = get_vendor_dropoff_time($vendor_id);

	$closed_dates_arr = get_vendor_closed_dates($vendor_id);

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
			'class'         => array('form-row-wide', 'notranslate'),
			'id'            => 'datepicker',
			'required'			=> true,
			'label'         => __('Hvornår skal gaven leveres?'),
			'placeholder'   => __('Vælg dato hvor gaven skal leveres'),
			'custom_attributes' => array('readonly' => 'readonly', 'translate' => 'no')
		), WC()->checkout->get_value( 'delivery_date' ) );


		// Build intervals & delivery days.
		$opening = get_field('openning', 'user_'.$vendor_id);
		$del_days = get_del_days_text($opening, $del_value, 2);
		//echo $del_days;
		//echo '.</p>';

        // @todo - get the days. "I dag", "I morgen" etc. - must be a function from the overviews.
        $delivery_text = get_vendor_delivery_date_text($vendor_id);
        echo '
        <div style="padding: 6px 10px; font-size: 12px; font-family: Inter,sans-serif; background: #fafafa; color: #666666;">
            <b>Info om butikken, der leverer din gavehilsen</b><br>
            Du er i gang med at bestille en gavehilsen hos '.get_vendor_name($vendor_id).', der har åbent og kan levere din gave '.$del_days.'.<br><br>
        
            Hvis du bestiller nu, kan butikken levere <b>'.$delivery_text.'</b>. (Butikken kan levere inden for '.$vendorDeliverDayReq.' åbningsdag(e), hvis du bestiller inden kl. '.$vendorDropOffTime.').
        </div>
        ';
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

	$disable_autocomplete = false;
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
        $product_alchohol = (is_array($product_alchohol)) ? $product_alchohol[0] : $product_alchohol;

        $product_alcohol_acf = get_field('alcholic_content', 'product_'.$cart_item['product_id']);


        // value: 0 or 1
        $product_alcohol = 0;
        if($product_alchohol == 1){
            $product_alcohol = 1;
        } else if($product_alcohol_acf == 1){
            $product_alcohol = 1;
        }

		if($product_alcohol == 1){
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
		$ipaddress = isset($_SERVER['HTTP_CF_CONNECTING_IP']) ? $_SERVER['HTTP_CF_CONNECTING_IP'] : $_SERVER['REMOTE_ADDR'];

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

/**
 * Removing vendors ability to set some of the
 * order statuses on orders.
 *
 * @author Dennis Lauritzen
 * @since v0.1
 *
 */

add_filter( 'mvx_vendor_order_statuses', 'mvx_change_default_status', 10, 2);
function mvx_change_default_status( $order_status, $order ){
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
apply_filters('mvx_is_disable_store_visitors_stats', '__return_false');


add_action( 'init', 'register_order_seen_order_status' );
function register_order_seen_order_status() {
    register_post_status( 'wc-order-seen', array(
        'label'                     => 'Order Seen by Vendor',
        'public'                    => true,
        'show_in_admin_status_list' => true,
        'show_in_admin_all_list'    => true,
        'exclude_from_search'       => false,
        'label_count'               => _n_noop( 'Order Seen by Vendor <span class="count">(%s)</span>', 'Order Seen by Vendor <span class="count">(%s)</span>' )
    ) );

		register_post_status( 'wc-order-mail-open', array(
				'label'                     => 'Vendor Opened Mail',
				'public'                    => true,
				'show_in_admin_status_list' => true,
				'show_in_admin_all_list'    => true,
				'exclude_from_search'       => false,
				'label_count'               => _n_noop( 'Vendor Opened Mail <span class="count">(%s)</span>', 'Vendor opened Mail <span class="count">(%s)</span>' )
		) );

		register_post_status( 'wc-order-forwarded', array(
        'label'                     => 'Order Sent to Vendor',
        'public'                    => true,
        'show_in_admin_status_list' => true,
        'show_in_admin_all_list'    => true,
        'exclude_from_search'       => false,
        'label_count'               => _n_noop( 'Order Forwarded to Vendor <span class="count">(%s)</span>', 'Order Forwarded to Vendor <span class="count">(%s)</span>' )
    ) );

		register_post_status( 'wc-order-accepted', array(
        'label'                     => 'Vendor Accepted',
        'public'                    => true,
        'show_in_admin_status_list' => true,
        'show_in_admin_all_list'    => true,
        'exclude_from_search'       => false,
        'label_count'               => _n_noop( 'Vendor Marked Order Received <span class="count">(%s)</span>', 'Vendor Marked Order Received <span class="count">(%s)</span>' )
    ) );
}


add_action('admin_head', 'styling_admin_order_list' );
function styling_admin_order_list() {
    global $pagenow, $post;

    if( $pagenow != 'edit.php') return; // Exit
    if( is_object($post) && get_post_type($post->ID) != 'shop_order' ) return; // Exit

		// HERE we set your custom status
    $order_status = 'Order Mail Open'; // <==== HERE
		echo '<style>
      .order-status.status-'.sanitize_title( $order_status ).'{
          background: #f2e59d;
          color: #a39443;
      }
    </style>';

		$order_status = 'Order Seen'; // <==== HERE
		echo '<style>
			.order-status.status-'.sanitize_title( $order_status ).'{
					background: #d7f8a7;
					color: #0c942b;
			}
		</style>';

    $order_status = 'Delivered'; // <==== HERE
		echo '<style>
      .order-status.status-'.sanitize_title( $order_status ).'{
          background: #0c942b;
          color: #d7f8a7;
      }
    </style>';

		$order_status = 'Order Forwarded'; // <==== HERE
		echo '<style>
      .order-status.status-'.sanitize_title( $order_status ).'{
          background: #98d8ed;
          color: #3d7d91;
      }
    </style>';

		$order_status = 'Order Seen'; // <==== HERE
		echo '<style>
			.order-status.status-'.sanitize_title( $order_status ).'{
					background: #d7f8a7;
					color: #0c942b;
			}
		</style>';
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
add_filter( 'woocommerce_display_item_meta','mvx_email_change_sold_by_text', 10, 3 );
function mvx_email_change_sold_by_text($html, $item, $args ){
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
add_filter ( 'mvx_display_vendor_message_to_buyer','__return_false');

/**
 * Add product image heading to e-mail new vendor order #mails #transactional
 *
 * @access public
 * @author Dennis Lauritzen
 * @return void
 */
add_action('mvx_before_vendor_order_table_header', 'add_prod_img_heading_to_vendor_email', 10, 4);
function add_prod_img_heading_to_vendor_email() {
		$str = '<th scope="col" style="text-align: left; width: 10%; border: 1px solid #eee;">';
		$str .= '';
		$str .= '</th>';

		echo wp_kses_post( $str  );
}

/**
 * Add product image to e-mail new vendor order #mails #transactional
 *
 * @access public
 * @author Dennis Lauritzen
 * @return void
 */
add_action('mvx_before_vendor_order_item_table', 'add_prod_img_to_vendor_email', 10, 4);
function add_prod_img_to_vendor_email($item, $order, $vendor_id, $is_ship) {
		$product = wc_get_product( $item['product_id'] );
		$mvx_product_img = $product->get_image( array( 100, 100 ));
		$str = '<td scope="col" style="width: 20%; text-align:left; border: 1px solid #eee;">';
		$str .= $mvx_product_img;
		$str .= '</td>';

		echo wp_kses_post( $str  );
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
add_filter('mvx_datatable_order_list_table_headers', 'mvx_add_order_table_column_callback', 10, 2);
function mvx_add_order_table_column_callback($orders_list_table_headers, $current_user_id) {
	$mvx_custom_columns = array(
		'order_p_id'    => array('label' => __( 'Hoved ordre nr.', 'dc-woocommerce-multi-vendor' ))
	);

	return (array_slice($orders_list_table_headers, 0, 2) + $mvx_custom_columns + array_slice($orders_list_table_headers, 2));
}

/**
 * Add the data to new column the order table on WCMP frontend order table
 * This is the Parent Order ID / Hoved ordre nr.
 *
 * @author Dennis Lauritzen
 */
add_filter('mvx_datatable_order_list_row_data', 'mvx_add_order_table_row_data', 10, 2);
function mvx_add_order_table_row_data($vendor_rows, $order) {
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

/**
 * Function for validation a date has the correct format
 *
 * @param $date
 * @param $format
 * @return bool
 */
function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    return $d && $d->format($format) === $date;
}

// Make custom column sortable
function filter_manage_edit_shop_order_sortable_columns( $sortable_columns ) {
    return wp_parse_args( array( 'delivery-date' => '_delivery_unixdate' ), $sortable_columns );
}
add_filter( 'manage_edit-shop_order_sortable_columns', 'filter_manage_edit_shop_order_sortable_columns', 10, 1 );

// Orderby for custom column
function action_pre_get_posts( $query ) {
    // If it is not admin area, exit
    if ( ! is_admin() ) return;

    global $pagenow;

    // Compare
    if ( $pagenow === 'edit.php' && isset( $_GET['post_type'] ) && $_GET['post_type'] === 'shop_order' ) {
        // Get orderby
        $orderby = $query->get( 'orderby' );

        // Set query
        if ( $orderby == '_delivery_unixdate' ) {
            $query->set( 'meta_key', '_delivery_unixdate' );
            $query->set( 'orderby', 'meta_value' );
        }
    }
}
add_action( 'pre_get_posts', 'action_pre_get_posts', 10, 1 );


/**
 * function to handling filtering vendor in admin
 *
 * @return void
 */
function mvx_admin_filter_by_vendor() {
	global $typenow;
	if ($typenow == 'shop_order') {
		$admin_dd_html = '<select name="admin_order_vendor" id="dropdown_admin_order_vendor"><option value="">'.__("Show All Vendors", "dc-woocommerce-multi-vendor").'</option>';
		$vendors = get_mvx_vendors();

		if($vendors){
			$vendor_arr = array();
			foreach ($vendors as $vendor) {
				$vendor_arr[$vendor->term_id] = $vendor->page_title;
			}

		 	asort($vendor_arr);
			foreach($vendor_arr as $vendor => $value){
				$checked = isset($_REQUEST['admin_order_vendor']) ? sanitize_text_field($_REQUEST['admin_order_vendor']) : '';
				$checked = ($checked == $vendor) ? ' selected="selected"' : '';
				$admin_dd_html .= '<option value="'.$vendor.'"'.$checked.'>'.$value.'</option>';
			}
		}

		$admin_dd_html .= '</select>';
		echo $admin_dd_html;
	}
}
add_action( 'restrict_manage_posts', 'mvx_admin_filter_by_vendor');


/**
 * Filtering action for the admin order page, to filter vendors
 *
 * @param $query
 * @return mixed
 */
function filter_orders_by_vendor_in_admin_dashboard( $query ) {
    if (current_user_can('administrator') && !empty($_REQUEST['admin_order_vendor'])) {
        $vendor_term_id = isset($_GET['admin_order_vendor']) ? $_GET['admin_order_vendor'] : '';
        $vendor =  get_mvx_vendor_by_term($vendor_term_id);
        #var_dump($vendor);

        $parent_orders = get_vendor_parent_order($vendor->id);
        $query['post__in'] = $parent_orders;
        return $query;
    }
    return $query;
}
add_filter( 'mvx_shop_order_query_request', 'filter_orders_by_vendor_in_admin_dashboard');


function get_vendor_parent_order($id) {
    $return_orders = array();

    $vendor_orders = get_posts( array(
        'fields'      => 'all',          // Retrieve only post IDs
        'numberposts' => -1,
        'meta_key'    => '_vendor_id',
        'meta_value'  => $id,
        'post_type'   => 'shop_order',
        'post_status' => 'any',
    ) );

    foreach( $vendor_orders as $vendor_order ) {
        if ( wc_get_order( $vendor_order->ID )->get_parent_id() === 0 ) {
            // This is a parent order
            $return_orders[] = $vendor_order->ID;
        }
    }
#print "<div>";var_dump($return_orders);print "</div>";
	return $return_orders;
}


/**
 * ADDING 2 NEW COLUMNS WITH THEIR TITLES (keeping "Total" and "Actions" columns at the end)
 * Possible values: cborder_number, mvx_suborder, order_date, order_status, billing_address, shipping_address, pensopay_transaction_info, order_total, woe_export_status,
 * wc_actions, store_own_order_reference
 *
 * Also - Removing the suborder column and the export column.
 *
 * @param $columns
 * @return array
 */
function custom_shop_order_column($columns)
{
    $reordered_columns = array();

    // Inserting columns to a specific location
    foreach( $columns as $key => $column){
        $reordered_columns[$key] = $column;
        if( $key == 'mvx_suborder' || $key == 'woe_export_status'){
            unset($reordered_columns['mvx_suborder']);
            unset($reordered_columns['woe_export_status']);
        }
        if( $key ==  'order_status' ){
            // Inserting after "Status" column
            $reordered_columns['delivery-date'] = __( 'Leveringsdato','greeting2');
        }
        if( $key == 'order_number'){
            $reordered_columns['store_vendor_id_name'] = __( 'Butik', 'greeting2' );
        }
        if( $key == 'wc_actions'){
            $reordered_columns['store_own_order_reference'] = __( 'Butikkens egen ref. for ordre', 'greeting2' );
        }
    }
    return $reordered_columns;
}
add_filter( 'manage_edit-shop_order_columns', 'custom_shop_order_column', 20 );

// Adding custom fields meta data for each new column (example)
/**
 * Adding column for admin order view
 *
 * @param $column String
 * @param $post_id int
 */
add_action( 'manage_shop_order_posts_custom_column' , 'custom_orders_list_column_content', 20, 2 );
function custom_orders_list_column_content( $column, $post_id )
{
    $vendor_id = get_post_meta( $post_id, '_vendor_id', true);
    $vendor_name = get_vendor_name_by_id($vendor_id);
    $order = wc_get_order( $post_id );

    switch ( $column )
    {
        case 'store_vendor_id_name' :
            print $vendor_name.' (#'.$vendor_id.')';

            // Check if it's a parent order with suborders
            if ($order && $order->get_id() > 0 && $order->get_type() === 'shop_order') {
                // Get the first suborder (assuming there is always only one suborder)
                $suborders = wc_get_orders(array('post_parent' => $post_id, 'post_status' => 'any'));;
                $suborder_id = !empty($suborders) ? current($suborders)->get_id() : 0;

                if ($suborder_id) {
                    $suborder = wc_get_order($suborder_id);
                    // Get the vendor ID from the suborder's metadata
                    $suborder_vendor_id = $suborder->get_meta('_vendor_id', true);
                    $suborder_vendor_name = get_vendor_name_by_id($suborder_vendor_id);

                    // Check if the vendor ID of the suborder is different from the parent order's vendor ID
                    if ($suborder_vendor_id && $suborder_vendor_id != $vendor_id) {
                        echo '<ul class="wcmp-order-vendor" style="margin:0px;"><li>';
                        echo '<small class="wcmp-order-for-vendor"> – tidl.: ' . $suborder_vendor_name . '</small>';
                        echo '</li></ul>';
                    }
                }
            }

            break;
        case 'delivery-date' :
            // Get custom post meta data
            $post_id = has_post_parent($post_id) ? get_post_parent($post_id) : $post_id;

            $del_date_unix = get_post_meta( $post_id, '_delivery_unixdate', true );
            $del_date = get_post_meta( $post_id, '_delivery_date', true );

            if(!$vendor_id){

                foreach ( $order->get_items() as $itemId => $item ){
                    if(!empty($product_meta->post_author)){
                        $vendor_id = $product_meta->post_author;
                        break;
                    }
                }
            }

            $del_type = (get_field('delivery_type', 'user_'.$vendor_id) != '' ? get_field('delivery_type', 'user_'.$vendor_id) : array());
            $del_type_value = is_array($del_type) && isset($del_type[0]['value']) ? $del_type[0]['value'] : '';

            // Generate Delivery icons
            $personal_icon_path = 'M4 4.5a.5.5 0 0 1 .5-.5H6a.5.5 0 0 1 0 1v.5h4.14l.386-1.158A.5.5 0 0 1 11 4h1a.5.5 0 0 1 0 1h-.64l-.311.935.807 1.29a3 3 0 1 1-.848.53l-.508-.812-2.076 3.322A.5.5 0 0 1 8 10.5H5.959a3 3 0 1 1-1.815-3.274L5 5.856V5h-.5a.5.5 0 0 1-.5-.5zm1.5 2.443-.508.814c.5.444.85 1.054.967 1.743h1.139L5.5 6.943zM8 9.057 9.598 6.5H6.402L8 9.057zM4.937 9.5a1.997 1.997 0 0 0-.487-.877l-.548.877h1.035zM3.603 8.092A2 2 0 1 0 4.937 10.5H3a.5.5 0 0 1-.424-.765l1.027-1.643zm7.947.53a2 2 0 1 0 .848-.53l1.026 1.643a.5.5 0 1 1-.848.53L11.55 8.623z';
            $freight_icon_path = 'M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z';
            $delivery_icon_path = ($del_type_value == 0) ? $freight_icon_path : $personal_icon_path;
            // Output delivery type icon
            echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi ';
            echo $del_type_value == '0' ? 'bi-truck' : 'bi-bicycle';
            echo '" viewBox="0 0 16 16"><path d="'.$delivery_icon_path.'"></path></svg> ';

            if(!empty($del_date_unix)){
                // The user didnt choose "delivery date", but it was calculated
                $dateobj = new DateTime();
                $dateobj->setTimestamp($del_date_unix);
                $date_format = $dateobj->format('D, j. M \'y');

                echo (empty($del_date) ? '<small><em>Hurtigst muligt (senest '.$date_format.')</em></small>' : $date_format);
            } else if(!empty($del_date)){
                $date_d = substr($del_date, 0, 2);
                $month_d = substr($del_date, 3, 2);
                $year_d = substr($del_date, 6, 4);

                $old_date = DateTime::createFromFormat('d-m-Y', $del_date);

                echo ($old_date instanceof DateTime ? $old_date->format('D, j. M \'y') : '<small>(Hurtigst muligt - <em>'.$del_date.'</em>)</small>');
            } else {
                // The user chose a delivery date.
                echo '<small>(<em>Hurtigst muligt</em>)</small>';
            }
            break;
    }
}

/**
 * For display and saving in order details page.
 *
 * @return void
 */
function add_shop_order_meta_box() {

    add_meta_box(
      'delivery_date',
      __( 'Leveringsdato', 'greeting2' ),
			'shop_order_display_callback',
			'shop_order',
			'side',
			'core'
    );

    add_meta_box(
        'store_own_order_reference',
        __( 'Butikkens egen ref. for ordre', 'greeting2' ),
        'shop_order_store_own_ref_callback',
        'shop_order',
        'side',
        'core'
    );

}
add_action( 'add_meta_boxes', 'add_shop_order_meta_box' );

// For displaying the delivery date edit field
function shop_order_display_callback( $post ) {
        $value = get_post_meta( $post->ID, '_delivery_date', true );

		$order = wc_get_order($post->ID);

		$vendor_id = 0;
		$storeProductId = 0;
		foreach ( $order->get_items() as $itemId => $item ) {
			// Get the product object
			$product = $item->get_product();

			// Get the product Id
			$productId = $product->get_id();
			$product_meta = get_post($productId);

			$vendor_id = $product_meta->post_author;

			if(!empty($orderedVendorStoreName)){
				break;
			}
		} // end foreach

		$vendor_delivery_day_required = get_field('vendor_require_delivery_day', 'user_'.$vendor_id);
		$vendor_drop_off_time = get_field('vendor_drop_off_time', 'user_'.$vendor_id);
		if(strpos($vendor_drop_off_time,':') === false && strpos($vendor_drop_off_time,'.')){
			$vendor_drop_off_time = $vendor_drop_off_time.':00';
		} else {
			$vendor_drop_off_time = str_replace(array(':','.'),array(':',':'),$vendor_drop_off_time);
		}

		if($vendor_drop_off_time < date('H:i')){
			$vendor_delivery_day_required = $vendor_delivery_day_required+1;
		}

		// BEWARE: Not used because then we cant change date according to our needs
		$dates = get_vendor_dates_new($vendor_id);
		$dates_json = json_encode($dates);
		?>

		 <script type="text/javascript">
				jQuery(document).ready(function($) {
					jQuery('#datepicker').click(function() {
						var customMinDateVal = <?php echo $vendor_delivery_day_required; ?>;
						var customMinDateValInt = parseInt(customMinDateVal);
						var today = '';
						var vendorDropOffTimeVal = '<?php echo $vendor_drop_off_time; ?>';
						let d = new Date();
						var hour = d.getHours()+':'+d.getMinutes();
						// var vendorClosedDayArray = $('#vendorClosedDayId').val();
						//var vendorClosedDayArray = '<?php echo $dates_json; ?>';
						var vendorClosedDayArray = '';

						jQuery('#datepicker').datepicker({
							dateFormat: 'dd-mm-yy',
							// minDate: -1,
							minDate: new Date(),
							// maxDate: "+1M +10D"
							maxDate: "+58D",
							firstDay: 1,
							// closed on specific date
							beforeShowDay: function(date){
								var string = jQuery.datepicker.formatDate('dd-mm-yy', date);
								return [ vendorClosedDayArray.indexOf(string) == -1 ];
							}
						}).datepicker( "show" );
                        jQuery('.ui-datepicker').addClass('notranslate');
					});
				});
		 </script>
		 <?php
        #print $post->ID;
		woocommerce_form_field( 'delivery_date', array(
			'type'          => 'text',
			'class'         => array(),
			'id'            => 'datepicker',
			'required'      => true,
			'label'         => __('Hvornår skal gaven leveres?'),
			'placeholder'   => __('Vælg dato hvor gaven skal leveres'),
			'custom_attributes' => array('readonly' => 'readonly')
		), esc_attr( $value ) );
}

/**
 * @param $post WP_Post
 * @return void
 */
function shop_order_store_own_ref_callback( $post ){
    $value = get_post_meta( $post->ID, '_store_own_order_reference', true );

    woocommerce_form_field( 'store_own_order_reference', array(
        'type'          => 'text',
        'class'         => array(),
        'id'            => 'store_own_ref',
        'required'      => true,
        'label'         => __('Indtast butikkens egen referencenr.'),
        'placeholder'   => __('Indtast butikkens egen referencenr.')
    ), esc_attr( $value ) );
}

// For saving.
function save_shop_order_meta_box_data( $post_id, $post ) {
    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
      return;
    }

    // Check the user's permissions.
    if ( isset( $post->post_type ) && 'shop_order' == $post->post_type ) {
      if ( ! current_user_can( 'edit_shop_order', $post_id ) ) {
        return;
      }
    }

    // Make sure that it is set.
    if ( !isset($_POST['delivery_date']) ){
      return;
    }

    // Sanitize user input.
    $my_data = sanitize_text_field( $_POST['delivery_date'] );

    # SET THE POST PARENT ID FOR DELIVERY DATE
    if (get_post_parent($post_id) !== null){
        $post = get_post_parent($post_id);
        $post_id = $post->ID;
    }
    #print $post_id; exit;

    // Update the meta field in the database.
    $post_date = $my_data;
    $d_date = substr($post_date, 0, 2);
    $d_month = substr($post_date, 3, 2);
    $d_year = substr($post_date, 6, 4);
    $unix_date = date("U", strtotime($d_year.'-'.$d_month.'-'.$d_date));
    update_post_meta( $post_id, '_delivery_unixdate', $unix_date );
    update_post_meta( $post_id, '_delivery_date', $my_data );
}
add_action( 'save_post', 'save_shop_order_meta_box_data', 20, 2 );


/**
 * For saving the data of the "Store own ref" meta box on order page.
 *
 * @param $post_id
 * @param $post
 * @return void
 */
function save_shop_order_meta_box_store_own_ref_data( $post_id, $post ) {
    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check the user's permissions.
    if ( isset( $post->post_type ) && 'shop_order' == $post->post_type ) {
        if ( ! current_user_can( 'edit_shop_order', $post_id ) ) {
            return;
        }
    }

    // Make sure that it is set.
    if ( !isset($_POST['store_own_order_reference']) ){
        return;
    }

    // Sanitize user input.
    $my_data = sanitize_text_field( $_POST['store_own_order_reference'] );

    # SET THE POST PARENT ID FOR DELIVERY DATE
    if (get_post_parent($post_id) !== null){
        $post = get_post_parent($post_id);
        // Before changing the post_id variable, lets update the child order value too.
        update_post_meta( $post_id, '_store_own_order_reference', $my_data );
        $post_id = $post->ID;
    }
    #print $post_id; exit;

    // Update the meta field in the database.
    update_post_meta( $post_id, '_store_own_order_reference', $my_data );
}
add_action( 'save_post', 'save_shop_order_meta_box_store_own_ref_data', 20, 2 );

function shapeSpace_customize_image_sizes($sizes) {
	unset($sizes['medium_large']); // 768px
	return $sizes;
}
add_filter('intermediate_image_sizes_advanced', 'shapeSpace_customize_image_sizes');

// disable srcset on frontend
function disable_wp_responsive_images() {
	return 1;
}
add_filter('max_srcset_image_width', 'disable_wp_responsive_images');

/**
 * Creating custom sizing for the images in the store view box.
 */
add_image_size( 'vendor-product-box-size', 240, 240 );

/**
 * Creating custom sizing for the images in the store view box.
 */
add_image_size( 'vendor-topbanner-size', 400, 200 );

/**
 * Remove the JetPack admin header notice.
 */
add_action('admin_head', 'custom_admin_head');
function custom_admin_head() {
	?><style>.notice.wcs-nux__notice{display:none;}</style><?php
}

function login_failed() {
  $login_page  = home_url( '/log-ind/' );
  wp_redirect( $login_page . '?login=failed' );
  exit;
}
add_action( 'wp_login_failed', 'login_failed' );

function wpcc_front_end_login_fail( $username ) {
      $referrer = $_SERVER['HTTP_REFERER'];
      if ( !empty( $referrer ) && !strstr( $referrer,'wp-login' ) && !strstr( $referrer,'wp-admin' ) ) {
        $referrer = esc_url( remove_query_arg( 'login', $referrer ) );
        wp_redirect( $referrer . '?login=failed' );
        exit;
      }
    }
add_action( 'wp_login_failed', 'wpcc_front_end_login_fail' );

function custom_authenticate_wpcc( $user, $username, $password ) {
      if ( is_wp_error( $user ) && isset( $_SERVER[ 'HTTP_REFERER' ] ) && !strpos( $_SERVER[ 'HTTP_REFERER' ], 'wp-admin' ) && !strpos( $_SERVER[ 'HTTP_REFERER' ], 'wp-login.php' ) ) {
        $referrer = $_SERVER[ 'HTTP_REFERER' ];
        foreach ( $user->errors as $key => $error ) {
            if ( in_array( $key, array( 'empty_password', 'empty_username') ) ) {
              unset( $user->errors[ $key ] );
              $user->errors[ 'custom_'.$key ] = $error;
            }
          }
      }

    return $user;
}
add_filter( 'authenticate', 'custom_authenticate_wpcc', 31, 3);

function logout_page() {
  $login_page  = home_url( '/log-ind/' );
  wp_redirect( $login_page . "?login=false" );
  exit;
}
add_action('wp_logout','logout_page');

add_filter('woocommerce_form_field_args',  'wc_form_field_args',10,3);
function wc_form_field_args($args, $key, $value) {
	if($args['type'] !== 'checkbox'){
  	$args['input_class'] = array( 'form-control' );
	}
  return $args;
}

function get_vendor_days_until_delivery($vendor_id){
	if(empty($vendor_id)){
		return;
	}

	$dropoff_time 		= get_field('vendor_drop_off_time','user_'.$vendor_id);
	$dropoff_time		= (int) substr($dropoff_time, 0, 2);
	$delDate 			= get_field('vendor_require_delivery_day','user_'.$vendor_id);
	$closedDatesArr		= get_vendor_closed_dates($vendor_id);
	$delWeekDays		= get_field('openning','user_'.$vendor_id);

	// Check if the store is closed this specific date.
	$closedThisDate 	= (in_array(date('d-m-Y'), $closedDatesArr)) ? 1 : 0;

	// Start calculation from 0 (= today)
	$days_until_delivery = $delDate;

	$open_iso_days = array();
	foreach($delWeekDays as $key => $val){
		$open_iso_days[] = $val['value'];
	}

	$open_this_day = (in_array(date('N'), $open_iso_days) ? 1 : 0);

	if($open_this_day == 0){
		$days_until_delivery++;
	} else {
		if($closedThisDate == 1){
			$days_until_delivery++;
		} else {
			if($dropoff_time < date('H')){
				$days_until_delivery++;
			}
		}
	}

	return $days_until_delivery;
}

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

/**
 * Function for calculating how many days from now until next time the store can deliver.
 * Implements the array from the get_vendor_dates_new() function.
 *
 * @uses get_vendor_dates_new()
 * @param $days_array
 * @param $today
 * @return String
 */
function get_vendor_delivery_days_from_today($vendor_id, $prepend_text = '', $del_type = "1", $long_or_short_text = 0)
{
    #if(!($comparison_date instanceof DateTime)){
     #   $comparison_date = DateTime::createFromFormat('d-m-Y', now());
    #}

    $vendor_days = get_vendor_dates_new($vendor_id, 'd-m-Y', 'all', 60);
    #var_dump($vendor_days);
    $result = [];

    $now = new DateTime();
    #var_dump($now);

    foreach ($vendor_days as $p => $c) {
        if(isset($c['cutoff_datetime'])
        && $c['cutoff_datetime'] !== false){
            $cutofftime = $c['cutoff_datetime'];
            $cutoff_time = DateTime::createFromFormat('d-m-Y H:i:s', $cutofftime);

            if($cutoff_time > $now){
                $result = array(
                    'date' => $c['date'],
                    'cutoff_datetime' => $c['cutoff_datetime'],
                    'cutoff_time' => $c['cutoff_time'],
                    'type' => $c['type']
                );
                break; // Break out of the inner loop once a non-false 'cutoff_time' is found
            }
        }
    }

    $date = '';
    $text = '';
    if(empty($result)){
        return;
    } else {
        $date_str = $result['date'];
        $date_obj =  DateTime::createFromFormat('d-m-Y', $date_str);
        $date = $date_obj->format('d-m-Y'); // Construct from the date.

        $str = '';
        if($del_type == "1"){
            $str .= 'Levere ';
        } else if($del_type == "0"){
            $str .= 'Afsende ';
        }
        if($long_or_short_text == 1){
            $str = "Butikken kan ".strtolower($str);
        } else if($long_or_short_text == 2){
            $str = '';
        }

        return $prepend_text . ' ' . strtolower($str . get_date_diff_text($date_obj));
        // There is a date. Let's populate the variables for the calculation.
    }
}

function get_date_diff_text($date){
    if(!($date instanceof DateTime)){
        return;
    }


    $today = new DateTime();
    $date_diff = $today->diff($date);

    #echo "DATOEN=>".var_dump($date);
    #echo "I DAG=>".var_dump($today);
    #echo "DIFF=>".var_dump($date_diff);

    if($date_diff->format('%R%a') == '0'){
        return 'i dag';
    } else if($date_diff->format('%R%a') == '+1'){
        return 'i morgen';
    } else if($date_diff->format('%R%a') == '+2'){
        return 'i overmorgen';
    } else {
        return 'om '.$date_diff->format('%a').' dage';
    }
}

function get_del_days_text($opening, $del_type = '1', $long_or_short_text = 0){
	$open_iso_days = array();
	$open_label_days = array();
	foreach($opening as $k => $v){
		$open_iso_days[] = (int) $v['value'];
		$open_label_days[$v['value']] = $v['label'];
	}

	$str = '';
	$interv = array();
	if(!empty($open_iso_days) && is_array($open_iso_days)){
		$interv = build_intervals($open_iso_days, function($a, $b) { return ($b - $a) <= 1; }, function($a, $b) { return $a."..".$b; });
	} else {
		$str .= 'Leveringsdage er ukendte';
		if($long_or_short_text == 1){
			$str .= 'Butikkens '.strtolower($str);
		}
	}
	$i = 1;

	if(!empty($opening) && !empty($interv) && count($interv) > 0){
		if($del_type == "1"){
			$str .= 'Leverer ';
		} else if($del_type == "0"){
			$str .= 'Afsender ';
		}
		if($long_or_short_text == 1){
			$str = "Butikken ".strtolower($str);
		} else if($long_or_short_text == 2){
            $str = '';
        }

		foreach($interv as $v){
			$val = explode('..',$v);
			if(!empty($val)){
				$start = isset($open_label_days[$val[0]])? $open_label_days[$val[0]] : '';
				if($val[0] != $val[1])
				{
					$end = isset($open_label_days[$val[1]]) ? $open_label_days[$val[1]] : '';
					if(!empty($start) && !empty($end)){
						$str .=  strtolower($start."-".$end);
					}
				} else {
					$str .=  strtolower($start);
				}
				if(count($interv) > 1){
					if(count($interv)-1 == $i){ $str .=  " og "; }
					else if(count($interv) > $i) { $str .=  ', ';}
				}
			}
			$i++;
		}
	}

	return $str;
}

function groupDates($input) {
	$arr = explode(",", $input);
	foreach($arr as $k => $v){
		$arr[$k] = strtotime(trim($v));
	}
	sort($arr);
	$expected = -1;
	foreach ($arr as $date) {
		if ($date == $expected) {
			array_splice($range, 1, 1, date("d-m-Y",$date));
		} else {
			unset($range);
			$range = [date("d-m-Y",$date)];
			$ranges[] = &$range;
		}
		$expected = strtotime(date("d-m-Y",$date) . ' + 1 day');
	}

	foreach ($ranges as $entry) {
		$result[] = $entry;
	}
	return $result;
}

function rephraseMonth($month){
    $months = ['januar', 'februar', 'marts', 'april', 'maj', 'juni', 'juli', 'august', 'september', 'oktober', 'november', 'december'];

    return $months[$month-1];
}

function rephraseDate($weekday, $date, $month, $year) {
	$weekdays = ['mandag', 'tirsdag', 'onsdag', 'torsdag', 'fredag', 'lørdag', 'søndag'];
	$months = ['januar', 'februar', 'marts', 'april', 'maj', 'juni', 'juli', 'august', 'september', 'oktober', 'november', 'december'];

	$weekday_str = $weekdays[$weekday - 1];
	$month_str = $months[$month - 1];
	$year_str = ($year != date("Y") ? $year : '');

	return $weekday_str." d. ".$date.". ".$month_str. " ". $year_str;
}

/**
 * Turn off the xmlRPC
 *
 * @author Dennis Lauritzen
 */
add_filter( 'xmlrpc_enabled', '__return_false' );



/**
 * Register meta box(es).
 * This is for changing vendor data on an order
 *
 * @author Dennis Lauritzen
 */
function greeting_change_vendor_show_meta() {
	add_meta_box( 'meta-change-vendor', __( 'Change Vendor', 'textdomain' ), 'greeting_change_vendor_show_meta_callback', 'shop_order' );
}
add_action( 'add_meta_boxes', 'greeting_change_vendor_show_meta' );

/**
 * Meta box display callback.
 * This is for changing vendor data on an order
 *
 * @author Dennis Lauritzen
 * @param WP_Post $post Current post object.
 */
function greeting_change_vendor_show_meta_callback( $post ) {
	// Display code/markup goes here. Don't forget to include nonces!
	global $wpdb;

	$args = array(
		'fields' => 'all_with_meta',
		'role' => 'dc_vendor'
	);
	$query = new WP_User_Query($args);
	$stores = $query->get_results();
	$current_store = get_post_meta($post->ID, '_vendor_id', true);

	wp_nonce_field( 'greeting_vendor_change_metabox_action', 'greeting_vendor_change' );
	echo '<select name="vendor_meta_name">';
	foreach($stores as $k => $v){
		$selected = ($current_store == $v->ID ? ' selected="selected"' : '');
		$name = get_user_meta( $v->ID, '_vendor_page_title', true );
		echo '<option value="'.$v->ID.'"'.$selected.'>'.$name.'</option>';
	}
	echo '</select>';
}

/**
 * Function for changing an order to another vendor
 *
 * @author Dennis Lauritzen
 * @param Integer $post_id
 * @return void
 */
function greeting_change_vendor_show_meta_action( $post_id ) {
  if( !isset( $_POST['vendor_meta_name'] ) || !wp_verify_nonce( $_POST['greeting_vendor_change'],'greeting_vendor_change_metabox_action') )
		return;

  if ( !current_user_can( 'manage_options', $post_id ))
    return;

  if ( isset($_POST['vendor_meta_name']) ) {
      $vendor_id = sanitize_text_field( $_POST['vendor_meta_name']);
      update_post_meta($post_id, '_vendor_id', $vendor_id);
      #// Assuming the vendor name is stored in another custom field, adjust the field name accordingly
      $vendor_name = get_vendor_name_by_id( $vendor_id ); // Replace with your actual function to get vendor name
      update_post_meta( $post_id, '_vendor_name', sanitize_text_field( $vendor_name ) );
  }

}
add_action('save_post', 'greeting_change_vendor_show_meta_action');

/**
 * Function for getting the vendor name from a vendor ID.
 *
 * @param $vendor_id
 * @return string
 */
function get_vendor_name_by_id($vendor_id) {
    $vendor_user = get_userdata($vendor_id);
    return $vendor_user ? $vendor_user->display_name : '';
}

/**
 * Add a custom action to order actions select box on edit order page.
 * Only added for paid orders that haven't fired this action yet
 *
 * @author Dennis Lauritzen
 * @param array $actions order actions array to display
 * @return array - updated actions
 */
function greeting_wc_add_order_meta_box_action( $actions ) {
	#global $theorder;

	// bail if the order has been paid for or this action has been run
	#if ( ! $theorder->is_paid() ) {
	#	return $actions;
	#}

	// add "mark printed" custom action
	$actions['wc_custom_order_action'] = __( 'Gensend mail til butikken', 'greeting2' );
    $actions['wc_custom_order_action_test_mail'] = __( 'SEND TEST MAIL', 'greeting2' );
	return $actions;
}
add_action( 'woocommerce_order_actions', 'greeting_wc_add_order_meta_box_action' );

/**
 * Add an order note when custom action is clicked
 * Add a flag on the order to show it's been run
 *
 * @author Dennis Lauritzen
 * @param \WC_Order $order
 */
function greeting_wc_process_order_meta_box_action( $order ) {
	$mailer = WC()->mailer();
	$mails = $mailer->get_emails();

	if ( !empty( $mails ) ) {
	    foreach ( $mails as $mail ) {
	        if ( $mail->id == 'vendor_new_order' ) {
	           $mail->trigger( $order->get_id() );
	        }
	     }
	}
}
add_action( 'woocommerce_order_action_wc_custom_order_action', 'greeting_wc_process_order_meta_box_action' );

/**
 * Add an order note when custom action is clicked
 * Add a flag on the order to show it's been run
 *
 * @author Dennis Lauritzen
 * @param \WC_Order $order
 */
function greeting_wc_process_order_meta_box_action_test_mail( $order ) {
		# Possible mail values:
		# ----
		# ARRAY: new_order, cancelled_order, failed_order, customer_on_hold_order, customer_processing_order, customer_completed_order, customer_refunded_order,
		# customer_invoice, customer_note, customer_reset_password, customer_new_account, woocommerce_pensopay_payment_link, vendor_new_account, admin_new_vendor,
		# approved_vendor_new_account, rejected_vendor_new_account, vendor_new_order, notify_shipped, admin_new_vendor_product, vendor_new_question, admin_new_question,
		# customer_answer, admin_added_new_product_to_vendor, vendor_commissions_transaction, vendor_direct_bank, admin_widthdrawal_request, vendor_orders_stats_report,
		# vendor_contact_widget_email, mvx_send_report_abuse, vendor_new_announcement, customer_order_refund_request, admin_vendor_product_rejected,
		# suspend_vendor_new_account, review_vendor_alert, vendor_followed, admin_change_order_status, admin_new_vendor_coupon

		$mailer = WC()->mailer();
		$mails = $mailer->get_emails();

		if ( !empty( $mails ) ) {
				foreach ( $mails as $mail ) {
						if ( $mail->id == 'customer_completed_order' ) {
							add_filter('woocommerce_new_order_email_allows_resend', '__return_true' );
							$mail->trigger( $order->get_id() );
						}
				 }
		}

		#$user_id = (empty(get_current_user_id()) ? wp_get_current_user()->ID : get_current_user_id() );
		#$mailer->customer_new_account($user_id);
		#exit;
}
add_action( 'woocommerce_order_action_wc_custom_order_action_test_mail', 'greeting_wc_process_order_meta_box_action_test_mail' );


/**
 * Function for duplicating taxonomies when duplicating a product.
 *
 * @author Dennis Lauritzen
 * @param \WC_Product $duplicate The new product, that is the receiver of the copied stuff
 * @param \WC_Product $product The original product, that we are copying from
 * @return void
*/
add_action( 'woocommerce_product_duplicate', 'greeting_duplicate_custom_taxonomies', 999, 2);
function greeting_duplicate_custom_taxonomies( WC_Product $duplicate, WC_Product $product ) {
    foreach ( [ 'occasion' ] as $taxonomy ) {
        $terms = get_the_terms( $product->get_id(), $taxonomy );
        if ( ! is_wp_error( $terms ) ) {
            wp_set_object_terms( $duplicate->get_id(), wp_list_pluck( $terms, 'term_id' ), $taxonomy );
        }
    }
}

/**
 * Function for using order object to get Vendor ID.
 *
 * @author Dennis Lauritzen
 * @param \WC_Order $order
 * @return Integer $vendor_id
 */
function greeting_get_vendor_id_from_order( $order ){
	$vendor_id = 0;
	foreach ($order->get_items() as $item_key => $item) {
		$product = get_post($item['product_id']);
		$vendor_id = $product->post_author;
	}

	return $vendor_id;
}


/**
 * CRONJOB
 * Function for using order object to get Vendor ID.
 *
 * @author Dennis Lauritzen
 * @param array $schedules
 * @return array
 */
// Define a custom 15-minute interval
function greeting_custom_15_minute_interval($schedules) {
    $schedules['every_15_minutes'] = array(
        'interval' => 900, // 15 minutes in seconds
        'display'  => __('Every 15 Minutes', 'textdomain')
    );
    return $schedules;
}
add_filter('cron_schedules', 'greeting_custom_15_minute_interval');

/**
 * Function for updatering via cronjob all orders from delivered status to completed every 15 minutes.
 *
 * @author Dennis Lauritzen
 * @return void
 */
function greeting_update_wc_delivered_orders_to_completed() {
    // Get orders with "wc-delivered" status
    $delivered_orders = wc_get_orders(array(
        'status' => 'wc-delivered',
        'limit' => -1, // Retrieve all orders with "wc-delivered" status
    ));

    // Loop through the delivered orders and update their status to "completed"
    foreach ($delivered_orders as $order) {
        if($order->get_status() == 'delivered'){
            $date = date_i18n( 'l \\d\\e\\n d. F Y \\k\\l\\. H:i:s');
            $order->update_status('completed', 'Ordre er automatisk opdateret til Gennemført '.$date);
        }
    }
}
add_action('update_completed_orders_event', 'greeting_update_wc_delivered_orders_to_completed');

// Schedule the event to run every 15 minutes using the custom interval
if (!wp_next_scheduled('update_completed_orders_event')) {
    wp_schedule_event(current_time('timestamp'), 'every_15_minutes', 'update_completed_orders_event');
}



/**
* Format WordPress User's "Display Name" to Full Name on Login
* ------------------------------------------------------------------------------
 *
 * @author Dennis Lauritzen
 * @param String $username
 * @return void
*/

add_action( 'wp_login', 'greeting_r19029_format_user_display_name_on_login' );
function greeting_r19029_format_user_display_name_on_login( $username ) {
    $user = get_user_by( 'login', $username );

    $first_name = get_user_meta( $user->ID, 'first_name', true );
    $last_name = get_user_meta( $user->ID, 'last_name', true );

    $full_name = trim( $first_name . ' ' . $last_name );

    if ( ! empty( $full_name ) && ( $user->data->display_name != $full_name ) ) {
        $userdata = array(
            'ID' => $user->ID,
            'display_name' => $full_name,
        );

        wp_update_user( $userdata );
    }
}

/**
 * @param $query
 * @return array
 */
function custom_wp_link_query_args($query)
{
    $pt_new = array();

    $exclude_types = array('landingpage','product');

    foreach ($query['post_type'] as $pt)
    {
        if (in_array($pt, $exclude_types)) continue;
        $pt_new[] = $pt;
    }

    $query['post_type'] = $pt_new;
    return $query;
}
add_filter('wp_link_query_args', 'custom_wp_link_query_args');

/**
 * Function to look through a text for links to specified taxonomies.
 *
 * @param String $content
 * @param Array|Object $taxonomies
 * @param Boolean $city_search
 * @param Array $cities An array of the Cities that needs to be searched for. The Array can contain WP_Post
 * @param Boolean $no_headings Do you want the search to look for the keywords in <h1>, <h2>, <h3> etc.? True/false
 * @return mixed|string
 */
function add_links_to_keywords($content, $taxonomies, $city_search = false, $cities = array(), $no_headings = true) {
    // Check if ACF is active
    if (!function_exists('get_field')) {
        return $content;
    }

    $all_keywords = array();

    // Initialize array to store linked phrases
    $linkedPhrases = array();

    // Process taxonomies
    foreach ($taxonomies as $taxonomy) {
        $terms = get_terms(array('taxonomy' => $taxonomy, 'hide_empty' => false));

        foreach ($terms as $term) {
            $seo_keyword = get_field('seo_keywords', $taxonomy . '_' . $term->term_id);
            $term_link = get_term_link($term->term_id, $taxonomy);

            if ($seo_keyword && $term_link) {
                $keywords = array_filter(explode(',', $seo_keyword), 'strlen');

                // Sort keywords by length in descending order
                usort($keywords, function ($a, $b) {
                    return strlen($b) - strlen($a);
                });

                foreach ($keywords as $value) {
                    if (!empty($value)) {
                        $escaped_value = preg_quote(trim($value), '/');
                        if($no_headings === true){
                            $pattern = '/(?<!<\/a>)\b' . preg_quote($escaped_value, '/') . '\b(?![^<]*<\/(?:h1|h2|h3|h4|h5|h6)>)(?![^<]*["\'])/i';
                        } else {
                            $pattern = '/(?<!<\/a>)\b' . preg_quote($escaped_value, '/') . '\b(?![^<]*>)/i';
                        }

                        // Perform the replacement only if the word or phrase doesn't have a link
                        $content = preg_replace_callback($pattern, function ($matches) use ($term_link, &$linkedPhrases) {
                            $phrase = $matches[0];
                            if (!in_array($phrase, $linkedPhrases)) {
                                $linkedPhrases[] = $phrase;
                                return '<a href="' . esc_url($term_link) . '">' . $phrase . '</a>';
                            }
                            return $phrase;
                        }, $content);
                    }
                }
            }
        }
    }

    if($city_search === true
    && is_array($cities)
    && !empty($cities)){
        // Make links for citi names too.
        $city_posts = $cities;
        $city_names = array_map(function ($city_post) {
            $title = (strpos($city_post->post_title, ' ') == true ? substr($city_post->post_title, strpos($city_post->post_title, ' ') + 1) : $city_post->post_title );
            return array(
                'title' => $title,
                'link' => get_permalink($city_post->ID),
            );
        }, $city_posts);

        $linked_cities = array();

        foreach ($city_names as $value) {
            if (!empty($value)) {
                // Regular expression pattern to find the first occurrence of "Beder" outside heading tags
                if($no_headings === true){
                    $pattern = '/<(h[1-6])[^>]*>.*?<\/\1>(*SKIP)(*FAIL)|\b'.$value['title'].'\b/i';
                } else {
                    $pattern = '/\b' . preg_quote($value['title'], '/') . '\b/i';
                }

                // Link to be added
                $link = $value['link'];

                // Replace the first occurrence of "Beder" outside heading tags with a link
                $content = preg_replace($pattern, '<a href="' . esc_url($link) . '">$0</a>', $content, 1);
            }
        }

        #foreach ($city_posts as $city_post) {
        #    echo $city_post->post_title . '<br>';
        #}
    }

    // Apply wpautop to preserve line breaks
    $content = wpautop($content);

    return $content;
}


/**
 * Register vendor ID in Rest API.
 * Make sure to use PHP >= 5.4
 *
 * @author Dennis Lauritzen
 */
add_action(
    'rest_api_init',
    function () {
        // Field name to register.
        $field = '_vendor_id';
        register_rest_field(
            'shop_order',
            $field,
            array(
                'get_callback'    => function ( $object ) use ( $field ) {
                    // Get field as single value from post meta.
                    return get_post_meta( $object['id'], $field, true );
                },
                'update_callback' => function ( $value, $object ) use ( $field ) {
                    // Update the field/meta value.
                    update_post_meta( $object->ID, $field, $value );
                },
                'schema'          => array(
                    'type'        => 'string',
                    'arg_options' => array(
                        'sanitize_callback' => function ( $value ) {
                            // Make the value safe for storage.
                            return sanitize_text_field( $value );
                        },
                        'validate_callback' => function ( $value ) {
                            // Valid if it contains exactly 10 English letters.
                            return (bool) preg_match( '/\A[a-z]{10}\Z/', $value );
                        },
                    ),
                ),
            )
        );
    }
);

/**
 * Register vendor name in Rest API.
 * Make sure to use PHP >= 5.4
 *
 * @author Dennis Lauritzen
 */
add_action(
    'rest_api_init',
    function () {
        // Field name to register.
        $field = '_vendor_name';
        register_rest_field(
            'shop_order',
            $field,
            array(
                'get_callback'    => function ( $object ) use ( $field ) {
                    // Get field as single value from post meta.
                    return get_post_meta( $object['id'], $field, true );
                },
                'schema'          => array(
                    'type'        => 'string',
                    'arg_options' => array(
                        'sanitize_callback' => function ( $value ) {
                            // Make the value safe for storage.
                            return sanitize_text_field( $value );
                        },
                        'validate_callback' => function ( $value ) {
                            // Valid if it contains exactly 10 English letters.
                            return (bool) preg_match( '/\A[a-z]{10}\Z/', $value );
                        },
                    ),
                ),
            )
        );
    }
);

/**
 * Register a users first order date in Rest API.
 * Make sure to use PHP >= 5.4
 *
 * @author Dennis Lauritzen
 */
add_action(
    'rest_api_init',
    function () {
        // Field name to register.
        $field = '_first_order_date';
        $order_meta = array();
        $meta_key = "";
        $meta_value = "";

        register_rest_field(
            'shop_order',
            $field,
            array(
                'get_callback'    => function ( $object ) use ( $field ) {
                    // Get the customer ID if logged in.
                    $order_id = $object['id'];

                    $customer_id = get_post_meta( $order_id, '_customer_user', true );
                    $billing_email = '';

                    // If not logged in, try to get customer ID using email.
                    if ( empty( $customer_id ) ) {
                        $billing_email = get_post_meta( $order_id, '_billing_email', true );
                        $customer_id = email_exists( $billing_email );
                    }

                    $order = get_customer_order($customer_id, $billing_email, 'first');

                    $first_order_date = $order ? ( $order->get_date_created() ? gmdate( 'Y-m-d H:i:s',
                        $order->get_date_created()->getOffsetTimestamp() ) : '' ) : '';

                    if(!empty($first_order_date)){
                        return $first_order_date;
                    }

                    return null;
                },
                'update_callback' => function ( $value, $object ) use ( $field ) {
                    // This field is read-only, so no need for an update callback.
                    return;
                },
                'schema'          => array(
                    'type' => 'string',
                ),
            )
        );
    }
);

/**
 * Get a users order based on either customer ID or billing e-mail
 *
 * @param $customer_id integer
 * @param $billing_email object
 * @param $first_or_last string #Values: 'first' or 'last'
 * @return bool|WC_Order|WC_Order_Refund
 */
function get_customer_order( $customer_id, $billing_email, $first_or_last )
{
    global $wpdb;

    if (!empty($customer_id)) {
        $meta_key = "_customer_user";
        $meta_value = $customer_id;
    } elseif (!empty($billing_email)) {
        $meta_key = "_billing_email";
        $meta_value = $billing_email;
    } else {
        return false;
    }

    if ('first' === $first_or_last) {
        $direction = 'ASC';
    } else if ('last' === $first_or_last) {
        $direction = 'DESC';
    } else {
        return false;
    }


    #$order = $wpdb->get_var(
    #// phpcs:disable WordPress.DB.PreparedSQL.NotPrepared
    #    "SELECT posts.ID
    #		FROM $wpdb->posts AS posts
	#		LEFT JOIN {$wpdb->postmeta} AS meta on posts.ID = meta.post_id
	#		WHERE meta.meta_key = '" . $meta_key . "'
	#		AND   meta.meta_value = '" . esc_sql($meta_value) . "'
	#		AND   posts.post_type = 'shop_order'
	#		AND   posts.post_status IN ( '" . implode("','", array_map('esc_sql', array_keys(wc_get_order_statuses()))) . "' )
	#		ORDER BY posts.ID {$direction}"
    #// phpcs:enable
    #);

    $prepared_query = $wpdb->prepare(
        "SELECT posts.ID
    FROM $wpdb->posts AS posts
    LEFT JOIN {$wpdb->postmeta} AS meta on posts.ID = meta.post_id
    WHERE meta.meta_key = %s
    AND meta.meta_value = %s
    AND posts.post_type = 'shop_order'
    AND posts.post_status IN ( '" . implode("','", array_map('esc_sql', array_keys(wc_get_order_statuses()))) . "' )
    ORDER BY posts.ID {$direction}",
        $meta_key,
        $meta_value
    );

    $order = $wpdb->get_var($prepared_query);

    if (!$order) {
        return false;
    }

    return wc_get_order(absint($order));
}

/**
 * Removing unnecessary fields from vendor admin
 *
 * @param $contactmethods
 * @param $user
 * @return mixed
 */
function vendor_remove_fields_from_admin($contactmethods, $user) {
    // Check if the current user is an administrator and if the user being edited has the 'dc_vendor' role
    $current_user = wp_get_current_user();

    if (current_user_can('administrator') && is_array($contactmethods) && $user && is_object($user)) {
        // Check if the user has roles and if 'dc_vendor' is among them
        $user_roles = $user->roles;
        if (is_array($user_roles) && in_array('dc_vendor', $user_roles)) {
            // Replace 'field-id' with the actual ID or name of the field you want to unset
            $fields_to_unset = array(
                'facebook',
                'instagram',
                'linkedin',
                'twitter',
                'youtube',
                'wikipedia',
                'myspace',
                'pinterest',
                'soundcloud',
                'tumblr',
                'facebook_profile',
                'twitter_profile',
                'linkedin_profile',
                'github_profile',
                'vendor_csd_return_address1',
                'vendor_csd_return_address2'
            );

            // Unset each shipping address field
            foreach ($fields_to_unset as $field) {
                unset($contactmethods[$field]);
            }
        }
    }

    return $contactmethods;
}
add_filter('user_contactmethods', 'vendor_remove_fields_from_admin', 10, 2);


/**
 * Remove unneccessary shipping fields from admin
 *
 * @author Dennis Lauritzen
 * @param Array $show_fields
 * @return Array
 */
function vendor_remove_shipping_fields($show_fields) {
    // Get the ID of the user currently being edited
    $edited_user_id = isset($_REQUEST['user_id']) ? absint($_REQUEST['user_id']) : 0;

    // Check if the current user is an administrator and if the user being edited has the 'dc_vendor' role
    if ($edited_user_id > 0
    && current_user_can('administrator')
    && in_array('dc_vendor', get_userdata($edited_user_id)->roles)) {
        // Check if $show_fields is an array before attempting to loop through it

        if (is_array($show_fields)) {
            unset($show_fields['billing']);
            unset($show_fields['shipping']);
        }
    }

    return $show_fields;
}
add_filter( 'woocommerce_customer_meta_fields', 'vendor_remove_shipping_fields' );

/**
 * Hide fields through CSS in the vendor user admin
 *
 * @author Dennis Lauritzen
 * @return void
 */
function vendor_hide_fields_css() {
    $edited_user_id = isset($_REQUEST['user_id']) ? absint($_REQUEST['user_id']) : 0;

    // Check if the current user has the 'dc_vendor' role
    if ($edited_user_id > 0
        && current_user_can('administrator')
        && in_array('dc_vendor', get_userdata($edited_user_id)->roles)) {
        // Hide specific fields or sections by their IDs or names
        ?>
        <style type="text/css">
            /* Replace 'field-id' with the actual ID or name of the field you want to hide */
            .vendor_fb_profile_wrapper,
            .vendor_instagram_wrapper,
            .vendor_twitter_profile_wrapper,
            .vendor_linkdin_profile_wrapper,
            .vendor_pinterest_profile_wrapper,
            .vendor_youtube_wrapper,
            .vendor_csd_return_address1_wrapper,
            .vendor_csd_return_address2_wrapper,
            .vendor_csd_return_country_wrapper,
            .vendor_csd_return_state_wrapper,
            .vendor_csd_return_city_wrapper,
            .vendor_csd_return_zip_wrapper,
            .vendor_customer_phone_wrapper,
            .vendor_customer_email_wrapper,
            .vendor_paypal_email_wrapper,
            .vendor_give_tax_wrapper,
            .vendor_give_shipping_wrapper,
            .vendor_hide_address_wrapper,
            .vendor_hide_phone_wrapper,
            .vendor_hide_email_wrapper,
            .vendor_hide_description_wrapper,
            .vendor_message_to_buyers_wrapper
            {
                display: none;
            }
        </style>
        <?php
    }
}
add_action('admin_head', 'vendor_hide_fields_css');

/**
 * Function to redirect a vendors products to frontpage if the vendor is not active
 *
 * @return void
 */
function redirect_deactivated_vendor_product() {
    // Check if it's a single product page
    if (is_product()) {
        global $post, $product;

        // Get the product ID
        $product_id = $post->ID;

        // Get the vendor ID associated with the product
        $vendor_id = get_post_field('post_author', $product_id);

        // Get the user object for the vendor
        $vendor_user = get_user_by('ID', $vendor_id);

        // Check if the user is a vendor
        if ($vendor_user && !in_array('dc_vendor', $vendor_user->roles, true)) {
            // Redirect to the front page
            wp_redirect(home_url());
            exit;
        }
    }
}
add_action('template_redirect', 'redirect_deactivated_vendor_product');

/**
 * Function for updating the "Clear transients" in the Vendor Dashboard on MultiVendorX.
 *
 * @param $vendor_nav
 * @return mixed
 */
function remove_mvx_vendor_dashboard_nav($vendor_nav){
    unset($vendor_nav['vendor-tools']);
    #unset($vendor_nav['store-settings']['submenu']['vendor-billing']);
    unset($vendor_nav['vendor-payments']);
    unset($vendor_nav['vendor-report']['submenu']['banking-overview']);
    #echo'<pre>';print_r($vendor_nav);echo'</pre>';
    return $vendor_nav;
}
add_filter('woocommerce_should_load_paypal_standard', '__return_true' );
add_filter('mvx_vendor_dashboard_nav', 'remove_mvx_vendor_dashboard_nav', 99);

/**
 * Function to add Custom menu to Vendor Dashboard
 * This adds the endpoint and gives the page a name (also the H1 name on the page)
 *
 * @param $endpoints
 * @return mixed
 */
function add_mvx_endpoints_query_vars_new($endpoints) {
    $endpoints['custom-mvx-menu'] = array(
        'label' => __('Greeting.dk Opgørelser', 'multivendorx'),
        'endpoint' => get_mvx_vendor_settings('mvx_custom_endpoint', 'seller_dashboard', 'custom-mvx-menu')
    );
    return $endpoints;
}
// add custom endpoint
add_filter('mvx_endpoints_query_vars', 'add_mvx_endpoints_query_vars_new');

/**
 * Function to add Custom menu to Vendor Dashboard
 * This adds a tab to the dashboard.
 *
 * @param $nav
 * @return mixed
 */
function add_tab_to_vendor_dashboard($nav) {
    $nav['custom_mvx_menu'] = array(
        'label' => __('Opgørelser', 'multivendorx'), // menu label
        'url' => mvx_get_vendor_dashboard_endpoint_url( get_mvx_vendor_settings( 'mvx_custom_endpoint', 'seller_dashboard', 'custom-mvx-menu' ) ), // menu url
        'capability' => true, // capability if any
        'position' => 75, // position of the menu
        'submenu' => array(), // submenu if any
        'link_target' => '_self',
        'nav_icon' => 'mvx-font ico-tools-icon', // menu icon
    );
    return $nav;
}
// add custom menu to vendor dashboard
add_filter('mvx_vendor_dashboard_nav', 'add_tab_to_vendor_dashboard');

/**
 * Function to add Custom menu to Vendor Dashboard
 * This adds content to the custom menu point
 *
 * @return void
 */
function custom_menu_endpoint_content(){
    echo '<div class="col-md-12 all-products-wrapper">
    <div class="panel panel-default panel-pading">
        <div class="product-list-filter-wrap">';
    echo '<table style="width: 350px;">';
    echo '<tr><th style="width: 250px;">Periode</th><th style="width: 100px;">Link</th></th>';
    echo '<tr><td>Periode</td><td>Link</td></tr>';
    echo '</table>';
    echo '</div></div></div>';
}
// display content of custom endpoint
add_action('mvx_vendor_dashboard_custom-mvx-menu_endpoint', 'custom_menu_endpoint_content');