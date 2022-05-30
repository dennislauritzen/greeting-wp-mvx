<?php
/**
 * Template Name: Page (Default)
 * Description: Page template.
 *
 */

get_header();
get_header('green');

the_post();
?>
<div class="container">
	<div class="row">
		<div class="col-12">
			<div id="post-<?php the_ID(); ?>" <?php post_class( 'content' ); ?>>
	            <?php if(!is_front_page()): ?>
				<h1 class="entry-title"><?php the_title(); ?></h1>
	            <?php endif; ?>
				<?php
					the_content();

					wp_link_pages(
						array(
							'before' => '<div class="page-links">' . __( 'Pages:', 'greeting2' ),
							'after'  => '</div>',
						)
					);
					edit_post_link( esc_html__( 'Edit', 'greeting2' ), '<span class="edit-link">', '</span>' );
				?>
			</div><!-- /#post-<?php the_ID(); ?> -->
			<?php
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
			?>
		</div><!-- /.col -->
	</div><!-- /.row -->
</div>
<?php
get_footer();
