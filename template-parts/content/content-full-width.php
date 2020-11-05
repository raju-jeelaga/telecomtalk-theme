
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
if(isset($tct_fields['enable_sub_heading']) && !empty($tct_fields['enable_sub_heading']) ){ ?>
	<h3 class="sub-title"><?php echo $tct_fields['sub_heading'];?></h3>
<?php } ?>
<?php
	$author_id = get_post_field( 'post_author', get_the_ID() );
	$author_name = get_the_author_meta('user_nicename', $author_id);
?>
<div class="byline">
	<span class="post_author_intro">Reported by</span> 
	<span class="post_author" itemprop="author"><?php echo $author_name;?></span>
	<?php 
	$total_count = '';
	
	if(!empty($categories) && $categories[0]->term_id != 1){ ?>
		<span class="post_cats" itemprop="keywords">
			<?php
			$total_count = count($categories);
			$i = 1;
			//print_r($categories);
			foreach ($categories as $key => $catobj) {
				if( $catobj->term_id == 1 ){
					continue;
				}
			?>
				<a href="<?php echo esc_url( get_category_link( $catobj->term_id ) );?>" rel="category tag"><?php echo esc_html( $catobj->name );?></a>
			<?php 
				if($i < 2 && $total_count > 2){
					echo ", ";
				}
				if($i == 2){
					break;
				}
				$i++;
			} 
			?>	
		</span>
	<?php 
	}
	$u_time = get_the_time('U'); 
	$u_modified_time = get_the_modified_time('U');
	$published_time = get_post_time('h:i a');
	$published_date = get_the_date( 'F jS, Y' );
	$updated_date = '';
	$updated_time = '';
	if ($u_modified_time >= $u_time + 86400) { 
	$updated_date = get_the_modified_time('F jS, Y');
	$updated_time = get_the_modified_time('h:i a'); }
	if(!empty($updated_date)){
	?>
	<span class="post_date">Last Updated: 
		<time class="entry-date updated" itemprop="dateModified" datetime="2016-03-13"><?php echo $updated_date;?> at <?php echo $updated_time; ?></time>
	</span>
	<?php }else{ ?>
	<span class="post_date">Last Updated: 
		<time class="entry-date updated" itemprop="dateModified" datetime="2016-03-13"><?php echo $published_date;?> at <?php echo $published_time; ?></time>
	</span>
	<?php } ?>
	<meta itemprop="interactionCount" content="UserComments:20">
	<a class="num_comments_link" href="#comments" rel="nofollow">
		<span class="num_comments"><?php echo get_comments_number(get_the_ID());?></span>
	</a>
</div><!-- /.byline -->
<?php 
$featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
if($featured_img_url){?>
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

<div class="highlights-content-wrap">
	<?php
	if(isset($tct_fields['enable_hightlights']) && $tct_fields['enable_hightlights'] ){
	?>
	<div class="sp-highlights">
		<h3><?php echo $tct_fields['highlights_heading'];?></h3>
		<ul>
			<?php 
				for($i=1;$i<=3;$i++){ 
					if(!empty($tct_fields['heading_'.$i])){?>
						<li><?php echo $tct_fields['heading_'.$i];?></li>
			<?php 	} 
				}
			?>
		</ul>
	</div>
	<?php } ?>
	<div class="post_content">
		<?php echo get_the_content();?>
    </div>
    <div class="authr-pagi">
	    <div class="author-meta">
	    	<?php 
	    	$user = wp_get_current_user();
	    	$designation = get_the_author_meta('designation');
	    	$photo_url = get_the_author_meta('photo_url');
	    	$twitterprofilelink = get_user_meta($post_author_id, 'twitterprofilelink', true);
			$linkedusername = get_user_meta($post_author_id, 'linkedusername', true);
	    	?>
	    	<h2>Reported By</h2>
	    	<div class="repr-by">
	    		<div class="auth-img">
	    			<?php 
	    			if(!empty($photo_url)){
	    				echo '<img src="'.$photo_url.'" width="100px" height="100px" />';
	    			}else{
	    				echo get_avatar( get_the_author_meta( 'ID' ), 100 ); 
	    			}
	    			?>
	    		</div>
	    		<div class="auth-info">
	    			<h4><?php echo get_the_author_meta( 'display_name');?>
	    				<span class="desig"><?php echo $designation; ?></span>
	    			</h4>
	    			<p><?php echo get_the_author_meta( 'description' );?></p>
	    			<div class="share-icons">
						<ul>
							<li><a target="_blank" class="fa-twitt" href="https://twitter.com/intent/user?screen_name=<?php echo $twitterprofilelink;?>"><span class="icon-twitter"><i class="fab fa-twitter"></i></span></a></li>
								<li><a target="_blank" class="fa-linkd" href="https://www.linkedin.com/in/<?php echo $linkedusername;?>"><span class="icon-linkedin2"><i class="fab fa-linkedin-in"></i></span></a></li>
						</ul>
					</div><!-- /.share-icons -->
	    		</div>
	    	</div>
	    </div>
	    <div class="nav-next-post">
			<?php $next_post = get_next_post();
			    the_post_navigation( array(
			        'next_text' =>
			            '<span class="nxt-img">' . get_the_post_thumbnail($next_post->ID,'thumbnail'). '</span><span class="post-title">%title</span>',
			        'prev_text' => '',
			) ); ?>
		</div>
	    
	</div><!-- /.authr-pagi -->

</div><!-- /.highlights-wrap -->
<div class="videos-section">
	<h2>Videos</h2>
	<ul>
		<?php 
		for($i=1;$i<=3;$i++){
			$video_title = "video_title_".$i;
			$cover_image = "image_url_".$i;
			$video_link = "video_link_".$i;
			$image_path = get_option($cover_image);
			$thumb_url = telecomtalk_aq_resize( $image_path, 260, 150, true, false );
			if(!empty(get_option($video_link))){
		?>
			<li>
				<div class="video-<?php echo $i;?>">
					<?php if(!empty(get_option($cover_image))){ ?>
					<a class="ov" href="<?php echo get_option($video_link);?>" target="_blank">
						<img src="<?php echo $thumb_url[0];?>"/>
						<span class="v-oy"></span>
						<span class="v-icon"><i class="far fa-play-circle"></i></span>
					</a>
					<?php } ?>
					<h3><a href="<?php echo get_option($video_link);?>" target="_blank"><?php echo get_option($video_title);?></a></h3>
				</div>
			</li>
		<?php
			}
		}
		?>
	</ul>
</div><!-- /.videos-section -->
<?php
$post_cats = wp_get_post_categories( get_the_ID() );
$cats = array();
if($post_cats){
	foreach ($post_cats as $c) {
		$cat = get_category( $c );
		$cats[] = $cat->cat_ID;
		$args=array(
			'category__in' => $cats,
			'post__not_in' => array(get_the_ID()),
			'posts_per_page'=>4, // Number of related posts that will be shown.
			'ignore_sticky_posts'=>1
		);
		$my_query = new wp_query( $args );
		if( $my_query->have_posts() ) {
			?>
		<div class="related-posts">
			<h2>Related Posts</h2>
			<ul>
			<?php $i = 1; 
			while( $my_query->have_posts() ) {
				$my_query->the_post(); 
				$post_feat_image = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
				$thumb_url = telecomtalk_aq_resize( $post_feat_image, 108, 80, true, false );
				?>
				<li>
					<div class="rp-sec">
						<div class="rp-tlt">
							<span><?php echo $i; ?></span>
							<h3><a href="<?php the_permalink()?>"><?php the_title(); ?></a></h3>
						</div>
						<?php if($post_feat_image){ ?>
						<div class="rp-img">
							<a href="<?php the_permalink()?>"><img src="<?php echo $thumb_url[0];?>"></a>
						</div>
						<?php } ?>
					</div>
				</li>
			<?php $i++; }  
			wp_reset_postdata();
			?>
			</ul>
		</div>
			<?php
		}
		break;
	}
} // Releated posts  ends here
?>
