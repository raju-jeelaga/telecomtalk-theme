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

get_header(); ?>

<div id="primary" class="content-area grt">
	<div class="container">
		<main id="main" class="site-main">
			<?php 
			$featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
			?>
			<div class="main-cnt">
				<div class="left-part">
					<div class="breadcrumbs">
						<?php
						$category = "";
						$categories = get_the_category();
						if ( ! empty( $categories ) ) {
							for($i=0;$i<count($categories);$i++){
						    	$category = esc_html( $categories[0]->name );   
							}
						}
						?>
						<ul>
							<li><a href="<?php echo home_url();?>">Home</a></li>
							<?php if(!empty($category)){?>
							<li><a href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) );?>"><?php echo $category;?></a></li>
							<?php } ?>
							<li><?php echo get_the_title();?></li>
						</ul>
					</div>
					<h1 class="headline">
						<?php echo get_the_title();?>
					</h1>
					<?php 
					$tct_fields = get_post_meta( get_the_ID(), 'telecomtalk_custom_fields', true );
					if($tct_fields['enable_sub_heading']){ ?>
						<h3 class="sub-title"><?php echo $tct_fields['sub_heading'];?></h3>
					<?php } ?>
					<div class="byline">
						<span class="post_author_intro">Reported by</span> 
						<span class="post_author" itemprop="author"><?php echo $author_name;?></span>
						<span class="post_cats" itemprop="keywords">
							<?php 
								$total_count = '';
								if(!empty($categories)){
									$total_count = count($categories);
									$i = 1;
									foreach ($categories as $key => $catobj) {
							?>

							<a href="<?php echo esc_url( get_category_link( $catobj->term_id ) );?>" rel="category tag"><?php echo esc_html( $catobj->name );?></a>
							<?php 
								if($i < $total_count){
									echo ", ";
								}
									$i++;
									} 
								}
							?>
							
						</span>
						<?php 
						$u_time = get_the_time('U'); 
						$u_modified_time = get_the_modified_time('U'); 
						if ($u_modified_time >= $u_time + 86400) { 
						$updated_date = get_the_modified_time('F jS, Y');
						$updated_time = get_the_modified_time('h:i a'); }
						?>
						<span class="post_date">Last Updated: 
							<time class="entry-date updated" itemprop="dateModified" datetime="2016-03-13"><?php echo $updated_date;?> at <?php echo $updated_time; ?></time>
						</span>
						<meta itemprop="interactionCount" content="UserComments:20">
						<a class="num_comments_link" href="#" rel="nofollow">
							<span class="num_comments"><?php echo get_comments_number(get_the_ID());?></span>
						</a>
					</div><!-- /.byline -->
					<?php if($featured_img_url){?>
					<div class="featured-image">
						<img src="<?php echo $featured_img_url;?>">
					</div>
					<?php } ?>
					<div class="social-icons">
				    	<ul>
							<li><a target="_blank" class="facebook" href="https://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>">
								<i class="fab fa-facebook-f"></i></a>
							</li>
							<li><a target="_blank" class="twitter" href="https://twitter.com/intent/tweet?url=<?php the_permalink(); ?>&text=<?php the_title(); ?>">
								<i class="fab fa-twitter"></i></a>
							</li>
							<li><a target="_blank" class="linkedin" href="https://www.linkedin.com/shareArticle?mini=true&url=&title=&summary=&source=<?php the_permalink(); ?>"><i class="fab fa-linkedin-in"></i></a>
							</li>
							<li><a target="_blank" class="gplus" href="https://plus.google.com/share?url=<?php the_permalink(); ?>">
								<i class="fab fa-google-plus-g"></i></a>
			                </li>
							<li><a target="_blank" class="whatsapp" href="whatsapp://send?text=<?php the_permalink(); ?>"><i class="fab fa-whatsapp"></i></a>
			                </li>
			                <li><a target="_blank" class="telegram" href="https://telegram.me/share/url?url=<?php the_permalink(); ?>&text=<?php the_title(); ?>">
								<i class="fab fa-telegram-plane"></i></a>
							</li>
							<li class="subscribe-image">
								<span>Subscribe</span>
								<a href="https://news.google.com/publications/CAAqBwgKMIGRjQswq7KeAw?hl=en-IN&gl=IN&ceid=IN%3Aen">
									<img src="<?php echo get_template_directory_uri() . '/images/google-news.svg'; ?>"/>
								</a>
							</li>
						</ul>
				    </div>
					<?php
						$author_id = get_post_field( 'post_author', $post_id );
						$author_name = get_the_author_meta('user_nicename', $author_id);
					?>
					
					<div class="highlights-content-wrap">
						<?php
						if($tct_fields['enable_hightlights']){
						?>
						<div class="sp-highlights">
							<h3><?php echo $tct_fields['highlights_heading'];?></h3>
							<ul>
								<li><?php echo $tct_fields['heading_1'];?></li>
								<li><?php echo $tct_fields['heading_2'];?></li>
								<li><?php echo $tct_fields['heading_3'];?></li>
								<li><?php echo $tct_fields['heading_4'];?></li>
								<li><?php echo $tct_fields['heading_5'];?></li>
								<li><?php echo $tct_fields['heading_6'];?></li>
							</ul>
						</div>
						<?php } ?>
						<div class="post_content">
							<?php echo get_the_content();?>
					    </div>
					</div>
					
				    <div class="small bylinetwo">
						<span class="post_date">Story first published on: 
							<time datetime="2016-03-13" itemprop="datePublished"><?php echo the_date('F jS, Y');?> at <?php echo get_the_time();?></time>
						</span>
					</div>
					<?php 
					$post_tags = get_the_tags( get_the_ID() );
					if(!empty($post_tags)){
					?>
					<p class="post_tags" itemprop="keywords">
						<?php
						$i = 1;
						foreach ($post_tags as $tkey => $tagobj) {?>
							<a href="<?php echo get_tag_link($tagobj->term_id);?>" rel="tag"><?php echo $tagobj->name;?></a>
						<?php 
							if($i<count($post_tags)){
								echo ", ";
							}
							$i++;
						} 
						?>
					</p>
					<?php } ?>

					<div class="related-posts">
						<h2>Related Posts</h2>
						<ul>
							<li>
								<div class="rp-sec">
									<div class="rp-tlt">
										<h3><a href="#">Sunday View: The Best Weekend Opinion Reads, Curated Just For You</a></h3>
									</div>
									<div class="rp-img">
										<a href="#"><img src="https://images.thequint.com/thequint%2F2018-02%2Fba090bff-7342-4b81-86aa-3815c76755b6%2Fedd3b43b-fda6-4111-9145-5b776c5cfc2f.jpg?auto=format%2Ccompress&fmt=webp&format=webp&w=120&dpr=1.3"></a>
									</div>
								</div>
							</li>
							<li>
								<div class="rp-sec">
									<div class="rp-tlt">
										<h3><a href="#">Sunday View: The Best Weekend Opinion Reads, Curated Just For You</a></h3>
									</div>
									<div class="rp-img">
										<a href="#"><img src="https://images.thequint.com/thequint%2F2018-02%2Fba090bff-7342-4b81-86aa-3815c76755b6%2Fedd3b43b-fda6-4111-9145-5b776c5cfc2f.jpg?auto=format%2Ccompress&fmt=webp&format=webp&w=120&dpr=1.3"></a>
									</div>
								</div>
							</li>
							<li>
								<div class="rp-sec">
									<div class="rp-tlt">
										<h3><a href="#">Sunday View: The Best Weekend Opinion Reads, Curated Just For You</a></h3>
									</div>
									<div class="rp-img">
										<a href="#"><img src="https://images.thequint.com/thequint%2F2018-02%2Fba090bff-7342-4b81-86aa-3815c76755b6%2Fedd3b43b-fda6-4111-9145-5b776c5cfc2f.jpg?auto=format%2Ccompress&fmt=webp&format=webp&w=120&dpr=1.3"></a>
									</div>
								</div>
							</li>
							<li>
								<div class="rp-sec">
									<div class="rp-tlt">
										<h3><a href="#">Sunday View: The Best Weekend Opinion Reads, Curated Just For You</a></h3>
									</div>
									<div class="rp-img">
										<a href="#"><img src="https://images.thequint.com/thequint%2F2018-02%2Fba090bff-7342-4b81-86aa-3815c76755b6%2Fedd3b43b-fda6-4111-9145-5b776c5cfc2f.jpg?auto=format%2Ccompress&fmt=webp&format=webp&w=120&dpr=1.3"></a>
									</div>
								</div>
							</li>
						</ul>
					</div>
				</div><!-- /.left-part -->

				<?php get_sidebar(); ?>
			</div>
			<?php
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
			?>
		</main><!-- #main -->
	</div><!-- /.container -->
</div><!-- #primary -->

<?php get_footer(); ?>
