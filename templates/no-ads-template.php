<?php
/*
 * Template Name: No ads Template
 * Template Post Type: post
 */
get_header();
// Start the Loop.
?>
		<div class="main-cnt">
			<div class="left-part">
<?php
	while ( have_posts() ) :
		the_post();

		get_template_part( 'template-parts/content/content', get_post_type() );
		?>
			</div><!-- /.left-part -->
			<?php get_sidebar();?>
		</div>
		<div class="comment-wrap">
			<h2>Leave a Comment</h2>
			<?php 
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
			?>
		</div>
		<?php
		the_post_navigation(
			array(
				'prev_text' => '<span class="screen-reader-text">' . __( 'Previous Post', 'twentyseventeen' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Previous', 'twentyseventeen' ) . '</span> <span class="nav-title"><span class="nav-title-icon-wrapper">' . twentyseventeen_get_svg( array( 'icon' => 'arrow-left' ) ) . '</span>%title</span>',
				'next_text' => '<span class="screen-reader-text">' . __( 'Next Post', 'twentyseventeen' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Next', 'twentyseventeen' ) . '</span> <span class="nav-title">%title<span class="nav-title-icon-wrapper">' . twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) ) . '</span></span>',
			)
		);

	endwhile; // End the loop.
get_footer();
?>
