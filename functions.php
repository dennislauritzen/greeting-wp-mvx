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
			'main-menu'   => 'Main Navigation Menu',
			'footer-menu' => 'Footer Menu',
		)
	);
}

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
		'page_title' 	=> 'Theme Landingpage Settings',
		'menu_title'	=> 'Header',
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
				var val = jQuery("#datafetch_wrapper li.recomms:first-child a").prop('href');
				var postalcode = '';
				var city = '';

				window.localStorage.setItem('greeting_postalcode', text);

				if(val.length){
					window.location.href = val;
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
		LIMIT 5", '%'.$search_query.'%');
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
		<li class="list-group-item py-2 px-4 <?php echo ($key==0) ? 'active' : '';?>" aria-current="true">
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
 */
add_action( 'wp_footer', 'categoryActionJavascript' );

function categoryActionJavascript() { ?>

	<script type="text/javascript">
		// Set the slider.
		var slider = new Slider('#sliderPrice', {
			'tooltip_split': true
		});
		slider.on("slideStop", function(sliderValue){
			var val = slider.getValue();
			var min_val = val[0];
			var max_val = val[1];
			document.getElementById("slideStartPoint").value = min_val;
			document.getElementById("slideEndPoint").value = max_val;
		});
	</script>
	<script type="text/javascript">
		// Start the jQuery
		jQuery(document).ready(function($) {

			var ajaxurl = "<?php echo admin_url('admin-ajax.php');?>";
			var catOccaDeliveryIdArray = [];
			var inputPriceRangeArray = [];
			var deliveryIdArray = [];
			// $('#cityPageReset').hide();

			jQuery(".filter-on-city-page").click(function(){
				update();

				if(this.checked){
					setFilterBadgeCity(
						$('label[for='+this.id+']').text(),
						this.value,
						'filter_cat'+this.value
					);
				} else {
					removeFilterBadgeCity(
						$('label[for='+this.id+']').text(),
						this.value,
						'filter_cat'+this.value,
						false
					);
				}
			});
			slider.on("slideStop", function(sliderValue){
				update();
			});

			function update(){
				var cityName = $('#cityName').val();
				var postalCode = $('#postalCode').val();
				catOccaIdArray = [];
				deliveryIdArray = [];
				inputPriceRangeArray = [];

				$("input:checkbox[name=filter_catocca_city]:checked").each(function(){
					catOccaIdArray.push($(this).val());
				});
				deliveryIdArray = [];
				$("input:checkbox[name=filter_del_city]:checked").each(function(){
					deliveryIdArray.push($(this).val());
				});

				var sliderValMin = jQuery("#sliderPrice").data("slider-min");
				var sliderValMax = jQuery("#sliderPrice").data("slider-max");
				inputPriceRangeArray = [
					document.getElementById("slideStartPoint").value,
					document.getElementById("slideEndPoint").value
				];
				var priceChange = 0;
				if(sliderValMin < document.getElementById("slideStartPoint").value || sliderValMax > document.getElementById("slideEndPoint").value){
					priceChange = 1;
				}

				var data = {
					'action': 'catOccaDeliveryAction',
					cityDefaultUserIdAsString: jQuery("#cityDefaultUserIdAsString").val(),
					catOccaIdArray: catOccaIdArray,
					deliveryIdArray: deliveryIdArray,
					inputPriceRangeArray: inputPriceRangeArray,
					cityName: cityName,
					postalCode: postalCode
				};
				jQuery.post(ajaxurl, data, function(response) {
					jQuery('#defaultStore').hide();
					jQuery('.filteredStore').show();
					jQuery('.filteredStore').html(response);

					if(catOccaIdArray.length == 0 && deliveryIdArray.length == 0 && priceChange == 1){
						jQuery('#defaultStore').show();
						jQuery('.filteredStore').hide();
						jQuery('#noVendorFound').hide();
					}
				});
			}

			// Filter badges on the vendor page.
			function setFilterBadgeCity(label, id, dataRemove){
				var elm = document.createElement('div');
				elm.id = 'filter'+dataRemove;
				elm.classList.add('badge', 'rounded-pill', 'border-yellow', 'py-2', 'px-2', 'me-1', 'my-1', 'my-lg-0', 'my-xl-0', 'text-dark', 'dynamic-filters');
				elm.href = '#';
				elm.innerHTML = label;

				elmbtn = document.createElement('button');
				elmbtn.type = 'button';
				elmbtn.classList.add('btn-close', 'filter-btn-delete');
				elmbtn.dataset.filterId = id;
				elmbtn.dataset.label = label.replace(/ /g,'');
				elmbtn.onclick = function(){removeFilterBadgeCity('"'+label.replace(/ /g,'')+'"', id, dataRemove, true);};
				elmbtn.dataset.filterRemove = dataRemove;
				elm.appendChild(elmbtn);

				jQuery('div.filter-list').prepend(elm);
			}
			function removeFilterBadgeCity(label, id, dataRemove, updateVendors){
				if(updateVendors === true){
					var elmId = dataRemove;
					console.log(elmId+' '+dataRemove);
					document.getElementById(elmId).checked = false;
					update();
				}
				jQuery('#filter'+dataRemove).remove();
			}

			// reset filter
			$('#cityPageReset').click(function(){
				$("input:checkbox[name=filter_catocca_city], input:checkbox[name=filter_del_city]").removeAttr("checked");
				var val_max = $("input#sliderPrice").data('slider-max');

				slider.setValue([0,val_max]);
				$("input#sliderPrice").data('slider-value', '[0,'+val_max+']');
				$("input#sliderPrice").data('slider-max', val_max);

				$("input#slideEndPoint").val(val_max);
				$("input#slideStartPoint").val(0);

				catOccaDeliveryIdArray.length = 0;

				$('div.filter-list div.dynamic-filters').remove();

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
					'compare' => 'IN'
				)
		);
		$usersByFilter = new WP_User_Query( $args	);
		$deliveryArr = $usersByFilter->get_results($usersByFilter);

		foreach($deliveryArr as $v){
			$delivery_type = get_field('delivery_type','user_'.$v->ID);
			if(!empty($delivery_type)){
				if(in_array($delivery_type[0]['value'],$deliveryIdArray)){
					array_push($userIdArrayGetFromDelivery, $v->ID);
				}
			}
		}
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
		)
	);

	$productQuery = new WP_Query($query);
	$userIdArrayGetFromPriceFilter = wp_list_pluck( $productQuery->posts, 'post_author' );

	// three array is
	// $userIdArrayGetFromCatOcca
	// $userIdArrayGetFromDelivery
	// $userIdArrayGetFromPriceFilter

	// check condition
	$userIdArrayGetFromCatOccaDelivery = array();

	$full_arr = array_merge($userIdArrayGetFromCatOcca, $userIdArrayGetFromDelivery);
	$full_arr2 = array_merge($full_arr, $userIdArrayGetFromPriceFilter);

	$return_arr = array_unique($full_arr2);
	$return_arr = array_intersect($defaultUserArray, $return_arr);

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

add_action( 'wp_ajax_categoryPageFilterAction', 'categoryPageFilterAction' );
add_action( 'wp_ajax_nopriv_categoryPageFilterAction', 'categoryPageFilterAction' );


/**
 * Filter on vendor store page
 * @usedon /vendor/*
 * Updated 30/4 by Dennis Lauritzen
 */
add_action( 'wp_footer', 'vendStoreActionJavascript' );
function vendStoreActionJavascript() { ?>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			var ajaxurl = "<?php echo admin_url('admin-ajax.php');?>";
			var catIdArray = [];
			var occIdArray = [];
			var inputPriceRangeArray = [];

			$(".filter-on-vendor-page").click(function(){
				updateVendor();

				if(this.checked){
					setFilterBadge(
						$('label[for='+this.id+']').text(),
						this.value,
						'filter_catocca_'+this.value
					);
				} else {
					removeFilterBadge(
						$('label[for='+this.id+']').text(),
						this.value,
						'filter_catocca_'+this.value,
						false
					);
				}
			});
			slider.on("slideStop", function(sliderValue){
				updateVendor();
			});
			function updateVendor(){
				catIdArray = [];
				occIdArray = [];
				$("input:checkbox[name=filter_cat_vendor]:checked").each(function(){
					catIdArray.push($(this).val());
				});
				$("input:checkbox[name=filter_occ_vendor]:checked").each(function(){
					occIdArray.push($(this).val());
				});

				inputPriceRangeArray = [
					document.getElementById("slideStartPoint").value,
					document.getElementById("slideEndPoint").value
				];

				var data = {
					'action': 'productFilterAction',
					defaultProductIdAsString: jQuery("#defaultProductIdAsString").val(),
					nn: $("input[name=nn]").val(),
					gid: $("input[name=gid]").val(),
					guid: $("input[name=guid]").val(),
					catIds: catIdArray,
					occIds: occIdArray,
					inputPriceRangeArray: inputPriceRangeArray
				};
				jQuery.post(ajaxurl, data, function(response) {
					jQuery('#products').hide();
					jQuery('#filteredProduct').show();
					jQuery('#filteredProduct').html(response);
				});
			}


			// Filter badges on the vendor page.
			function setFilterBadge(label, id, dataRemove){
				var elm = document.createElement('div');
				elm.id = 'filter'+dataRemove;
				elm.classList.add('badge', 'rounded-pill', 'border-yellow', 'py-2', 'px-2', 'me-1', 'my-1', 'my-lg-0', 'my-xl-0', 'text-dark', 'dynamic-filters');
				elm.href = '#';
				elm.innerHTML = label;

				elmbtn = document.createElement('button');
				elmbtn.type = 'button';
				elmbtn.classList.add('btn-close', 'filter-btn-delete');
				elmbtn.dataset.filterId = id;
				elmbtn.dataset.label = label;
				elmbtn.onclick = function(){removeFilterBadge('"'+label+'"', id, dataRemove, true);};
				elmbtn.dataset.filterRemove = dataRemove;
				elm.appendChild(elmbtn);

				jQuery('div.filter-list').prepend(elm);
			}
			function removeFilterBadge(label, id, dataRemove, updateVendors){
				if(updateVendors === true){
					var elmId = dataRemove;
					console.log(elmId+' '+dataRemove);
					document.getElementById(elmId).checked = false;
					updateVendor();
				}
				jQuery('#filter'+dataRemove).remove();
			}


			// reset filter
			$('#vendorPageReset').click(function(){
				$("input:checkbox[name=filter_catocca_vendor]").removeAttr("checked");
				var val_max = $("input#sliderPrice").data('slider-max');

				slider.setValue([0,val_max]);
				$("input#sliderVendorPage").data('slider-value', '[0,'+val_max+']');
				$("input#sliderVendorPage").data('slider-max', val_max);

				$("input#slideEndPoint").val(val_max);
				$("input#slideStartPoint").val(0);

				$('div.filter-list div.dynamic-filters').remove();

				//catOccaDeliveryIdArray.length = 0;

				jQuery('#products').show();
				jQuery('#filteredProduct').hide();
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
add_action( 'woocommerce_thankyou', 'call_order_status_completed', 10, 1);
// define woocommerce_order_status_completed callback function
function call_order_status_completed( $array ) {

	$latestOrderId = getLastOrderId(); // Last order ID
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

	//$orderData = $order->get_data(); // Get the order data in an array

    // qr code begin
	include (get_template_directory() . '/phpqrcode/qrlib.php');
    // Save PNG codes to server
    $upload = wp_upload_dir();
    $upload_dir = $upload['basedir'] .'/qr-codes/';
    $permissions = 0755;
    $oldmask = umask(0);
    if (!is_dir($upload_dir)) mkdir($upload_dir, $permissions);
    $umask = umask($oldmask);
    $chmod = chmod($upload_dir, $permissions);
    $codeContents = site_url().'/index.php/shop-order-status/?order_id='.$latestOrderId;

    // we need to generate filename
    $fileName = $latestOrderId.'.png';
    $pngAbsoluteFilePath = $upload_dir.$fileName;

    // generating
    if (!file_exists($pngAbsoluteFilePath)) {
    	QRcode::png($codeContents, $pngAbsoluteFilePath);
    	//echo 'File generated!';
    } else {
    	echo 'File already generated! We can use this cached file to speed up site on common codes!';
    }
	// qr code end

    // $orderedStoreName = '';
	//$orderedStoreEmail = '';
	$orderedVendorStoreName = '';

	// Loop through order items
	foreach ( $order->get_items() as $itemId => $item ) {
		// Get the product object
		$product = $item->get_product();
		// Get the product Id
		$productId = $product->get_id();

		$orderProductVendor = get_wcmp_product_vendors($productId);
        if( $orderProductVendor ) {
            $term_vendor = wp_get_post_terms($productId, 'dc_vendor_shop');
			foreach($term_vendor as $ven){
				$orderedVendorStoreName = $ven->name;
			}
        }

	} // end foreach

		// send email
		$body = '<div id="main-wrapper" style="max-width: 600px;margin-left:auto;margin-right:auto;border:1px solid #ddd;color: #333;">
            <div id="top-header" style="background-color: purple;">
                <h2 style="color: white; margin: 0px 30px; padding: 20px 0px;">Thanks for shopping with us</h2>
            </div>
            <div id="body" style="background-color: white; padding: 30px;">
                <p>Hi, '.$orderedVendorStoreName.'</p>
                <p>We have finished your order</p>
                <p style="color: purple; font-size: 20px;">[Order #'.$latestOrderId.'] ('.$orderCreateDateFormat.')</p>
                <table id="table" style="width:100%;color:#333;">
                    <thead>
                      <tr>
                        <th style="border: 1px solid #ddd;text-align: center;">Product</th>
                        <th style="border: 1px solid #ddd;text-align: center;">Quantity</th>
                        <th style="border: 1px solid #ddd;text-align: center;">Price ('.$orderCurrency.')</th>
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
                <p style="color: purple; font-size: 20px;">Billing Address</p>
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
                <div style="margin-top: 20px;">
				<img src="'.site_url().'/wp-content/uploads/qr-codes/'.$latestOrderId.'.png " alt="qr code"/>
                </div>
                <a href="'.site_url().'/index.php/shop-order-status/?order_id='. $latestOrderId .'">Update Order Status</a>
                <div style="margin-top: 20px;">
                    <p>Thanks for shopping with us</p>
                </div>
            </div>;
        </div>';

    // dompdf begin
    require_once 'dompdf/autoload.inc.php'; // include autoloader
    $dompdf = new Dompdf(); // instantiate and use the dompdf class
    $dompdf->loadHtml($body);
	$dompdf->setPaper('A4', 'landscape'); // (Optional) Setup the paper size and orientation
	// Render the HTML as PDF
    $dompdf->render();
    // $dompdf->stream(); // Output the generated PDF to Browser
    //save the pdf file on the server
    $uploadpdf = wp_upload_dir();
    $uploadpdf_dir = $uploadpdf['basedir'] .'/pdf-files/';
    $permissions = 0755;
    $oldmask = umask(0);
    if (!is_dir($uploadpdf_dir)) mkdir($uploadpdf_dir, $permissions);
    $umask = umask($oldmask);
    $chmod = chmod($uploadpdf_dir, $permissions);
    file_put_contents($uploadpdf_dir.'/'.$latestOrderId.'.pdf', $dompdf->output());
	// dompdf end

	// attached pdf file begin
	// $filename = $latestOrderId.'.pdf';
    // $attachments = array( WP_CONTENT_DIR . '/uploads/pdf-files/'.$filename );
    // attach pdf file end

	// $headers = array('Content-Type: text/html; charset=UTF-8'); // To send HTML formatted mail, you also can specify the Content-Type HTTP header in the $headers parameter:

	// wp_mail( $to, $subject, $body, $headers, $attachments );

};


// vendor attachment begin

add_filter( 'woocommerce_email_attachments', 'attach_pdf_to_email', 10, 3);

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


function greeting_check_billing_postcode( $fields, $errors ){

	$storeProductId = '';
	// Get $product object from Cart object
	$cart = WC()->cart->get_cart();

	foreach( $cart as $cart_item_key => $cart_item ){
		$product = $cart_item['data'];
		$storeProductId = $product->get_id();
	}

	$vendor_id = get_post_field( 'post_author', $storeProductId );

	global $wpdb;

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

	$vendorRelatedPCBillingWithoutComma = str_replace(","," ",$vendorDeliveryZipsBilling);
	$vendorRelatedPCBillingWCArray = explode(" ", $vendorRelatedPCBillingWithoutComma);
	// push vendor postal code
	// $vendorRelatedPCBillingWCArray[] = $vendorPostalCodeBilling;
	$findPostCodeFromArray = in_array($fields[ 'billing_postcode' ], $vendorRelatedPCBillingWCArray);

		if ($findPostCodeFromArray){
		} else {
			$errors->add( 'validation', 'This store not deliver to postcode '.$fields[ 'billing_postcode' ].', Store only deliver to '.$vendorDeliveryZipsBilling.' these postcode.' );
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

add_action( 'woocommerce_checkout_process', 'greeting_validate_new_checkout_fields' );

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
	global $closed_days_date;?>

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
			var vendorClosedDayArray = <?php echo json_encode($closed_days_date); ?>;

			$('#datepicker').datepicker({
				dateFormat: 'dd-mm-yy',
				// minDate: -1,
				minDate: customMinDateVal,
				// maxDate: "+1M +10D"
				maxDate: "+10D",
				// closed on specific date
				beforeShowDay: function(date){
					var string = jQuery.datepicker.formatDate('dd-mm-yy', date);
					return [ vendorClosedDayArray.indexOf(string) == -1 ]
				}
			}).datepicker( "show" );
         });
      });
   </script>
   <?php
}

// Save & show date as order meta

add_action( 'woocommerce_checkout_update_order_meta', 'greeting_save_delivery_date_with_order' );

function greeting_save_delivery_date_with_order( $order_id ) {

    global $woocommerce;
    if ( $_POST['delivery_date'] ) update_post_meta( $order_id, '_delivery_date', esc_attr( $_POST['delivery_date'] ) );
}

add_action( 'woocommerce_admin_order_data_after_billing_address', 'greeting_delivery_date_display_admin_order_meta' );

function greeting_delivery_date_display_admin_order_meta( $order ) {

   echo '<p><strong>Delivery Date:</strong> ' . get_post_meta( $order->get_id(), '_delivery_date', true ) . '</p>';

}

// show order date in thank you page
add_action( 'woocommerce_thankyou', 'greeting_view_order_and_thankyou_page', 20 );

function greeting_view_order_and_thankyou_page( $order_id ){  ?>
    <?php echo '<p><strong>Delivery Date:</strong> ' . get_post_meta( $order_id, '_delivery_date', true ) . '</p>';
}

// Add custom order meta data to make it accessible in Order preview template
add_filter( 'woocommerce_admin_order_preview_get_order_details', 'admin_order_preview_add_custom_meta_data', 10, 2 );

function admin_order_preview_add_custom_meta_data( $data, $order ) {
    if( $delivery_date_value = $order->get_meta('_delivery_date') )
        $data['delivery_date_key'] = $delivery_date_value; // <= Store the value in the data array.
    return $data;
}

// Display order date in admin order preview
add_action( 'woocommerce_admin_order_preview_start', 'custom_display_order_data_in_admin' );

function custom_display_order_data_in_admin(){
    // Call the stored value and display it
    echo '<div style="margin:15px 0px 0px 15px;"><strong>Delivery Date:</strong> {{data.delivery_date_key}}</div>';
}


add_action( 'woocommerce_cart_calculate_fees', 'checkout_message_fee', 20, 1 );
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

add_action( 'woocommerce_checkout_process', 'greeting_validate_new_receiver_info_fields' );

function greeting_validate_new_receiver_info_fields() {

   if ( isset( $_POST['receiver_info'] ) && empty( $_POST['receiver_info'] ) ) wc_add_notice( __( 'Please enter receiver info' ), 'error' );
   if ( isset( $_POST['greeting_message'] ) && empty( $_POST['greeting_message'] ) ) wc_add_notice( __( 'Please enter greeting message' ), 'error' );

   if ( $_POST['message-pro'] == 0 && (strlen( $_POST['greeting_message'] ) > 150))  wc_add_notice( __( 'Standard package accept only 150 Character, Please choose premium package' ), 'error' );

}

//  Save & show date as order meta
add_action( 'woocommerce_checkout_update_order_meta', 'greeting_save_receiver_info_with_order' );

function greeting_save_receiver_info_with_order( $order_id ) {
    global $woocommerce;

    if ( $_POST['receiver_info'] ) update_post_meta( $order_id, 'receiver_info', esc_attr( $_POST['receiver_info'] ) );
}

add_action( 'woocommerce_admin_order_data_after_billing_address', 'greeting_receiver_info_display_admin_order_meta' );

function greeting_receiver_info_display_admin_order_meta( $order ) {

   echo '<p><strong>Receiver Info:</strong> ' . get_post_meta( $order->get_id(), 'receiver_info', true ) . '</p>';

}

// show order date in thank you page
add_action( 'woocommerce_thankyou', 'greeting_view_order_and_receiver_info_thankyou_page', 20 );

function greeting_view_order_and_receiver_info_thankyou_page( $order_id ){  ?>
    <?php echo '<p><strong>Receiver Info:</strong> ' . get_post_meta( $order_id, 'receiver_info', true ) . '</p>';
}

// Add custom order meta data to make it accessible in Order preview template
add_filter( 'woocommerce_admin_order_preview_get_order_details', 'admin_order_preview_add_receiver_info_custom_meta_data', 10, 2 );

function admin_order_preview_add_receiver_info_custom_meta_data( $data, $order ) {
    if( $receiver_info_value = $order->get_meta('receiver_info') )
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

add_action( 'woocommerce_review_order_before_order_total', 'checkout_packaging_radio_buttons' );

function checkout_packaging_radio_buttons() {

    echo '<tr class="packaging-radio">
        <th>'.__("Packaging Options").'</th><td>';

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

    echo '</td></tr>';
}

add_action( 'woocommerce_cart_calculate_fees', 'checkout_packaging_fee', 20, 1 );

function checkout_packaging_fee( $cart ) {
    if ( $radio = WC()->session->get( 'packaging' ) ) {
        $cart->add_fee( 'Packaging Fee', $radio );
    }
}

add_action( 'woocommerce_checkout_update_order_review', 'checkout_packaging_choice_to_session' );

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
			$i = 0;
			$cart_data = WC()->cart->get_cart();
			$length = count($cart_data);
			foreach ($cart_data as $cart_item_key => $cart_item) {
				$product_id = $cart_item['product_id'];
				$vendor_data = get_wcmp_product_vendors($product_id);
				if(is_object($vendor_data)){
					$vendor_id = $vendor_data->user_data->ID;
					$vendor_id_array[] = $vendor_id;
					if ($i == $length - 1) {
						$last_inserted_vendor_id = $vendor_id;
					}
				}
				$i++;
			}
		}
	} else {
		// WooCommerce is NOT enabled!
	}

	// check array is unique or not
	if(count($vendor_id_array) === 1 && end($vendor_id_array) === $last_inserted_vendor_id) {
	} else {
		$single_vendor = 1;
	}

	if(!empty($vendor_id_array) && $single_vendor === 1){
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
	wc_print_notice('You can not shopping from different STORE once!, Please go to CART and keep only one STORE item in cart. If you want to shopping from several item please you can place another order.', 'error');
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

    if ( empty( $term ) ) {
        return $term;
    }
    if ( empty( $product->id ) ) {
        return $term;
    }

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
  if ( is_cart() ) {
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

		$chosenMessage = WC()->session->get( 'message-pro' );
		$chosenMessage = empty( $chosenMessage ) ? WC()->checkout->get_value( 'message-pro' ) : $chosenMessage;
		$chosenMessage = empty( $chosenMessage ) ? '0' : $chosenMessage;

		woocommerce_form_field( 'message-pro',  array(
			'type'      => 'radio',
			'label'			=> 'Hvor lang er din hilsen?',
			'class'     => array( 'form-row-wide', 'update_totals_on_change' ),
			'label_class' =>	array('form-row-label'),
			'options'   => array(
				'0'				=> 'Standardhilsen, håndskrevet (op til 165 tegn)',
				'4'				=> 'Lang hilsen, håndkrevet (op til 400 tegn), +10 kr.'
			),
		), $chosenMessage );

		// @todo - If message-pro == 4, then this should be allowed to be 400 characters.
		woocommerce_form_field( 'greeting_message', array(
			'type'				=> 'textarea',
			'id'					=> 'greetingMessage',
			'class'				=> array('form-row-wide'),
			'required'		=> true,
			'label'				=> __('Din hilsen til modtager'),
			'placeholder'	=> __('Skriv din hilsen til din modtager her :)'),
			));

		woocommerce_form_field( 'receiver_info', array(
			'type'          => 'text',
			'class'         => array('form-row-wide', 'greeting-custom-input'),
			'required'      => true,
			'label'         => __('Receiver info'),
			'placeholder'       => __('Enter receiver info'),
			));
		#echo '<tr class="message-pro-radio"><td>';

	echo '<h3 class="pt-4">Leveringsdato</h3>';

	greeting_echo_date_picker();

	echo '</div>';
}

/**
 * @author amdad
 * Functions for setting the order delivery date.
 * On step 3 in checkout.
 *
 * order date begin
 */
# add_action( 'woocommerce_review_order_before_payment', 'greeting_echo_date_picker' );
$closed_days_date = array();
function greeting_echo_date_picker( ) {
	$storeProductId = '';
	// Get $product object from Cart object
	$cart = WC()->cart->get_cart();

	foreach( $cart as $cart_item_key => $cart_item ){
		$product = $cart_item['data'];
		$storeProductId = $product->get_id();
	}

	$vendor_id = get_post_field( 'post_author', $storeProductId );

	global $wpdb;

	// get vendor drop off time
	$vendorDropOffTimeRow = $wpdb->get_row( "
		SELECT * FROM {$wpdb->prefix}usermeta
		WHERE user_id = $vendor_id
		AND meta_key = 'vendor_drop_off_time'
	" );
	$vendorDropOffTime = $vendorDropOffTimeRow->meta_value;

	// get vendor closed day
	$vendorClosedDayRow = $wpdb->get_row( "
		SELECT * FROM {$wpdb->prefix}usermeta
		WHERE user_id = $vendor_id
		AND meta_key = 'vendor_closed_day'
	" );

	// get vendor delivery day
	$vendorDeliverDay = $wpdb->get_row( "
		SELECT * FROM {$wpdb->prefix}usermeta
		WHERE user_id = $vendor_id
		AND meta_key = 'vendor_require_delivery_day'
	" );
	$vendorDeliverDayReq = $vendorDeliverDay->meta_value;

	// open close days begin
	$default_days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
	$openning_days = get_user_meta($vendor_id, 'openning', true); // true for not array return
	$closed_days = array_diff($default_days, $openning_days);

	global $closed_days_date;
	foreach($closed_days as $closed){
		$today_day = date("l");
		$today_date = date_create($today_day);
		date_modify($today_date, $closed);
		$modified_date = date_format($today_date, "d-m-Y");
		$closed_days_date[] = $modified_date;
	}

	$closed_days_date[] = $vendorClosedDayRow->meta_value;

	$date_now = new dateTime();
	$closed_days_date_exist_check = array();

	foreach($closed_days_date as $ok_date){
		$date_time_object = new dateTime($ok_date);
		if($date_time_object > $date_now){
			$closed_days_date_exist_check[] = $ok_date;
		}
	}

	rsort($closed_days_date_exist_check); // reverse sort the array


	echo '<div id="show-if-shipping">';
	echo '<span>Butikken kan levere om ';
	echo $vendorDeliverDayReq. ' leveringsdage, hvis du ';
	echo 'bestiller inden kl.';
	echo $vendorDropOffTime;
	echo ':00</span>';


	woocommerce_form_field( 'delivery_date', array(
		'type'          => 'text',
		'class'         => array('form-row-wide'),
		'id'            => 'datepicker',
		'required'      => false,
		'label'         => __('Hvornår skal gaven leveres?'),
		'placeholder'   => __('Hurtigst muligt'),
	));


	$closed_days_date_iteration = count($closed_days_date_exist_check);
	$cdi = 0;
	foreach($closed_days_date_exist_check as $closed_date){
		if(++$cdi == $closed_days_date_iteration){
			echo $closed_date;
		} else {
			echo $closed_date.", ";
		}
	}
	// open close days end

	echo '</div>';?>

	<input type="hidden" id="vendorDeliverDay" value="<?php echo $vendorDeliverDayReq;?>"/>
	<input type="hidden" id="vendorDropOffTimeId" value="<?php echo $vendorDropOffTime;?>"/>
	<?php
}
add_action( 'woocommerce_after_checkout_validation', 'greeting_check_billing_postcode', 10, 2);

/**
 * Add Content to the Related Steps Created Above
 * @param string $step
 * return void
 */
function argmcAddStepsContent($step) {
	//First Step Content
  if ($step == 'step_6') {
		greeting_echo_receiver_info( );
	}
}
add_action('arg-mc-checkout-step', 'argmcAddStepsContent');

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
  unset($fields['billing']['billing_country']);
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
	unset($fields['shipping']['shipping_country']);
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
			'label'         => esc_html__('I confirm that I\'m 18+ years old.', 'woocommerce'),
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
