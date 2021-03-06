<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Astra
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); 

?>

<div class="wrap">
	<div id="primary" class="content-area grt">
		<div class="container">
			<main id="main" class="site-main" role="main">
				<div class="main-cnt">
					<div class="left-part">
			<?php
			// Start the Loop.
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
			?>
			</main><!-- #main -->
		</div>
	</div><!-- #primary -->
	
</div><!-- .wrap -->
<?php get_footer(); ?>
