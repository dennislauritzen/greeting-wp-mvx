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
		$fields['xing_profile']     = 'Xing URL';
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
                'name'          => __('Landing Pages', 'rigid'),
                'singular_name' => __('Landing Page', 'rigid'),
            ),
            'menu_icon' => 'dashicons-flag',
            'public'      => true,
            'has_archive' => true,
            'supports' => array('title')
        )
	);

	// city
	register_post_type('city',
        array(
            'labels' => array(
                'name'          => __('City', 'rigid'),
                'singular_name' => __('Cities', 'rigid'),
            ),
            'menu_icon' => 'dashicons-location-alt',
            'public'      => true,
            'has_archive' => true,
            'supports' => array('title')
        )
	);
}

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
	);
	register_taxonomy( 'occasion', 'product', $args );


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
			jQuery(document).ready(function(){
				var currentRequest = null;

				/*Do the search with delay 500ms*/
				jQuery('#front_Search-new_ucsa').keyup(delay(function (e) {
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
					}, 500)
				);
			});

			/** function for delaying ajax input**/
			function delay(callback, ms) {
			  var timer = 0;
			  return function() {
			    var context = this, args = arguments;
			    clearTimeout(timer);
			    timer = setTimeout(function () {
			      callback.apply(context, args);
			    }, ms || 0);
			  };
			}
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
				foreach ($landing_page_query as $key => $landing_page) {?>
					<li class="list-group-item py-2 px-4 <?php echo ($key==0) ? 'active' : '';?>" aria-current="true">
						<a href="<?php echo site_url() . '/city/' . $landing_page->post_name;?>" class="text-teal stretched-link"><?php echo ucfirst($landing_page->post_title);?></a>
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

	// $labels2 = array(
	// 	'name'                       => 'Delivery Type',
	// 	'singular_name'              => 'DeliveryType',
	// 	'menu_name'                  => 'Delivery Type',
	// 	'all_delivery_type'                  => 'All Delivery Type',
	// 	'new_delivery_type_name'              => 'New Delivery Type',
	// 	'add_new_delivery_type'               => 'Add New Delivery Type',
	// 	'edit_delivery_type'                  => 'Edit Delivery Type',
	// 	'update_delivery_type'                => 'Update Delivery Type',
	// 	'separate_delivery_type_with_commas' => 'Separate delivery type with commas',
	// 	'search_delivery_type'               => 'Search Delivery Type',
	// 	'add_or_remove_delivery_type'        => 'Add or remove Delivery Type',
	// 	'choose_from_most_used'      => 'Choose from the most used Delivery Type',
	// );
	// $args2 = array(
	// 	'labels'                     => $labels2,
	// 	'public'                     => true,
	// 	'show_ui'                    => true,
	// 	'show_admin_column'          => true,
	// 	'show_in_nav_menus'          => true,
	// 	'show_tagcloud'              => true,
	// );
	// register_taxonomy( 'deliv_type', 'product', $args2 );
}
