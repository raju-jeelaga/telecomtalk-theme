<?php
/**
 * Custom comment walker for this theme.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

if ( ! class_exists( 'Telecomtalk_Walker_Comment' ) ) {
	/**
	 * CUSTOM COMMENT WALKER
	 * A custom walker for comments, based on the walker in Twenty Nineteen.
	 */
	class Telecomtalk_Walker_Comment extends Walker_Comment {

		
		protected function html5_comment( $comment, $depth, $args ) {

			$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
			$city = get_comment_meta( $comment->comment_ID, 'city', true );
			?>
			<<?php echo $tag; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $this->has_children ? 'parent' : '', $comment ); ?>>
				<article id="div-comment-<?php comment_ID(); ?>" class="comment-body cmnts-sec">
					
					<div class="comment-author vcard">
						<?php
						$comment_author_url = get_comment_author_url( $comment );
						$comment_author     = get_comment_author( $comment );
						$avatar             = get_avatar( $comment, $args['avatar_size'] );
						if ( 0 !== $args['avatar_size'] ) {
							if ( empty( $comment_author_url ) ) {
								echo wp_kses_post( $avatar );
							} else {
								printf( '<a href="%s" rel="external nofollow" class="url">', $comment_author_url );
								echo wp_kses_post( $avatar );
							}
						}
						if ( ! empty( $comment_author_url ) ) {
							echo '</a>';
						}
						?>
					</div><!-- .comment-author -->

					<div class="cmts-cntn ">
						<div class="cmts-top">
							<div class="athr-city">
								<?php
								printf( '<a href="%s" rel="external nofollow" class="url">', $comment_author_url );
								printf(
									'<span class="fn">%1$s </span>',
									esc_html( $comment_author )
								);
								echo '</a>';
								if(!empty($city)){ ?>
									<span class="city-name"><?php echo esc_html($city);?></span>
								<?php } ?>
							</div>
							
							<?php 
							$comment_reply_link = get_comment_reply_link(
							array_merge(
								$args,
									array(
										'add_below' => 'div-comment',
										'depth'     => $depth,
										'max_depth' => $args['max_depth'],
										'before'    => '<span class="comment-reply">',
										'after'     => '</span>',
									)
								)
							);

							$comment_quote_link = get_comment_reply_link(
							array_merge(
								$args,
									array(
										'add_below' => 'div-comment',
										'depth'     => $depth,
										'max_depth' => $args['max_depth'],
										'before'    => '<span class="comment-quote">',
										'after'     => '</span>',
										'reply_text' => 'Quote'
									)
								)
							);
									
							$by_post_author = telecomtalk_is_comment_by_post_author( $comment );
							if ( $comment_reply_link || $by_post_author ) { ?>
							<div class="cmts-rght">
								<?php
									if ( $comment_reply_link ) {
										echo $comment_reply_link .'|'. $comment_quote_link ; 
									}
									if ( $by_post_author ) {
										//echo '<span class="by-post-author">' . __( 'By Post Author', 'twentytwenty' ) . '</span>';
									}
								?>
							</div>
							<?php
							} // comments
							?>
						</div>
						<?php
						echo '<p class="comment-txt">'.$comment->comment_content.'</p>';
						if ( '0' === $comment->comment_approved ) {
							?>
							<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'twentytwenty' ); ?></p>
							<?php
						}
						?>
						<div class="like-dslike">
							<?php
								ob_start();
					            do_action('cld_like_dislike_output', $comment, get_the_ID());
					            $like_dislike_html = ob_get_contents();
					            ob_end_clean();
					            $like_dislike_html = apply_filters('tct_like_dislike_html', $like_dislike_html);
					            echo $like_dislike_html; 
				            ?>
						</div>							
					</div><!-- .comment-content -->

				</article><!-- .comment-body -->

			<?php
		}
	}
}
