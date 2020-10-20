<?php
/**
 * The template file for displaying the comments and comment form for the
 * Twenty Twenty theme.
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
*/
if ( post_password_required() ) {
	return;
}

//if ( have_comments() ) {
	?>

	<div class="comments" id="comments">

		<?php
		$comments_number = absint( get_comments_number() );
		?>

		<div class="comments-header section-inner small max-percentage">

			<h2 class="comment-reply-title">
			<?php
			if ( ! have_comments() ) {
				_e( 'Leave a comment', 'twentytwenty' );
			} elseif ( 1 === $comments_number ) {
				/* translators: %s: Post title. */
				printf( _x( 'One reply on &ldquo;%s&rdquo;', 'comments title', 'twentytwenty' ), get_the_title() );
			} else {
				printf(
					/* translators: 1: Number of comments, 2: Post title. */
					_nx(
						'%1$s reply on &ldquo;%2$s&rdquo;',
						'%1$s replies on &ldquo;%2$s&rdquo;',
						$comments_number,
						'comments title',
						'twentytwenty'
					),
					number_format_i18n( $comments_number ),
					get_the_title()
				);
			}

			?>
			</h2><!-- .comments-title -->

		</div><!-- .comments-header -->

		<div class="comments-inner section-inner thin max-percentage">
			<?php 
			$comment_form_display = 'block';
				if ( comments_open() || pings_open() ) {

					if ( $comments ) {
						echo '<hr class="styled-separator is-style-wide" aria-hidden="true" />';
					}
					if(get_comments_number()){
						$comment_form_display = 'none';
					}
					echo '<div class="tct-comment-form" style="display:'.$comment_form_display.';">';
					comment_form(
						array(
							'class_form'         => 'section-inner thin max-percentage',
							'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
							'title_reply_after'  => '</h2>',
						)
					);
					echo '</div>';
				} elseif ( is_single() ) {

					if ( $comments ) {
						echo '<hr class="styled-separator is-style-wide" aria-hidden="true" />';
					}

					?>
					<div class="comment-respond" id="respond">
						<p class="comments-closed"><?php _e( 'Comments are closed.', 'twentytwenty' ); ?></p>
					</div><!-- #respond -->
					<?php
				}
			?>
			<?php if ( have_comments() ) { ?>
			<div class="comment-list"></div>
			<?php
				// wp_list_comments(
				// 	array(
				// 		'walker'      => new Telecomtalk_Walker_Comment(),
				// 		'avatar_size' => 120,
				// 		'style'       => 'div',
				// 		'short_ping' => true,
				// 	)
				// );

				// $comment_pagination = paginate_comments_links(
				// 	array(
				// 		'echo'      => false,
				// 		'end_size'  => 0,
				// 		'mid_size'  => 0,
				// 		'next_text' => __( 'Newer Comments', 'twentytwenty' ) . ' <span aria-hidden="true">&rarr;</span>',
				// 		'prev_text' => '<span aria-hidden="true">&larr;</span> ' . __( 'Older Comments', 'twentytwenty' ),
				// 	)
				// );
				//echo get_query_var('cpage');
				$cpage = get_query_var('cpage') ? get_query_var('cpage') : 1;
 
				if( $cpage > 1 ) {
					?>
					<div style="text-align: center;">
						<button class="load-more-comments" id="load-more-comments">View Comments (<?php echo get_comments_number();?>)</button>
					</div>
					<script>
						var parent_post_id = <?php echo get_the_ID();?>;
						var cpage = <?php echo $cpage;?>;
					</script>
					<?php 
				}

				if ( $comment_pagination ) {
					$pagination_classes = '';

					// If we're only showing the "Next" link, add a class indicating so.
					if ( false === strpos( $comment_pagination, 'prev page-numbers' ) ) {
						$pagination_classes = ' only-next';
					}
					?>

					<nav class="comments-pagination pagination<?php echo $pagination_classes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output ?>" aria-label="<?php esc_attr_e( 'Comments', 'twentytwenty' ); ?>">
						<?php echo wp_kses_post( $comment_pagination ); ?>
					</nav>

				<?php
				}
			}
			?>

		</div><!-- .comments-inner -->

	</div><!-- comments -->

	<?php
//}
?>