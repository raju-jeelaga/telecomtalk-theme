<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Astra
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$sidebar = apply_filters( 'astra_get_sidebar', 'sidebar-1' );
?>

<?php //astra_sidebars_before(); ?>
	<div class="right-part">
        <?php if ( is_active_sidebar( $sidebar ) ) : ?>

            <?php dynamic_sidebar( $sidebar ); ?>

        <?php endif; ?>
        <div class="editors_picks">
            <div class="editors_title widget_title">
                <h3>Editors Pick</h3>
            </div>
            <?php 
            $post_id = get_option('editors_pick_option');
            $post_data   = get_post( $post_id );
            ?>
            <div class="editors">
                <?php if(!empty($post_id)){
                    $post_feat_image = wp_get_attachment_url( get_post_thumbnail_id($post_data->ID) );
                    $thumb_url = telecomtalk_aq_resize( $post_feat_image, 340, 180, true, false );
                    ?>
                    <?php if( $post_feat_image){?>
                    <div class="featured-image">
                        <a href="<?php echo get_permalink($post_data->ID);?>"><img src="<?php echo $thumb_url[0];?>"></a>
                    </div>
                    <?php } ?>
                <h4><a href="<?php echo get_permalink($post_data->ID);?>"><?php echo $post_data->post_title;?></a></h4>
                <?php  } ?>
                <ul id="accordion">
                    <li>
                        <input type="radio" name="accordion" id="first" checked="">
                        <label for="first">News Tip</label>
                        <div class="f_content">
                            <p>Have a breaking news, inside story, scoop?</p>
                            <p>Write to us, your anonymity is our priority at news [at] telecomtalk.info</p>
                        </div>
                    </li>
                    <li>
                        <input type="radio" name="accordion" id="second">
                        <label for="second">Submit Your Story</label>
                        <div class="f_content">
                            <p>Want to be featured on TelecomTalk?</p>
                            <p>Send us your articles, stories, suggestions, feedback at news [at] telecomtalk.info</p>            
                        </div>
                    </li>
                </ul>
            </div>
        </div><!-- /.editors_picks -->

        <div class="editors_picks">
            <div class="editors_title widget_title">
                <h3>Pan India Spectrum Details</h3>
            </div>
            <?php 
            $post_id = get_option('pan_india_option');
            $post_data   = get_post( $post_id );
            ?>
            <div class="editors">
                <?php if(!empty($post_id)){ 
                    $post_feat_image = wp_get_attachment_url( get_post_thumbnail_id($post_data->ID) );
                    $thumb_url = telecomtalk_aq_resize( $post_feat_image, 340, 180, true, false );
                ?>
                <?php if($post_feat_image){ ?>
                <div class="featured-image">
                    <a href="<?php echo get_permalink($post->ID);?>"><img src="<?php echo $thumb_url[0];?>"></a>
                </div>
                <?php } ?>
                <h4><a href="<?php echo get_permalink($post->ID);?>"><?php echo $post_data->post_title;?></a></h4>
                <?php } ?>
            </div>
        </div><!-- /.editors_picks -->

        <div class="editors_picks">
            <div class="editors_title widget_title">
                <h3>Telecommunication Frequency Bands</h3>
            </div>
            <?php 
            $post_id = get_option('frequency_band_option');
            $post_data   = get_post( $post_id );
            ?>
            <div class="editors">
                <?php if(!empty($post_id)){ 
                    $post_feat_image = wp_get_attachment_url( get_post_thumbnail_id($post_data->ID) );
                    $thumb_url = telecomtalk_aq_resize( $post_feat_image, 340, 180, true, false );
                ?>
                <?php if($post_feat_image){ ?>
                <div class="featured-image">
                    <a href="<?php echo get_permalink($post->ID);?>"><img src="<?php echo $thumb_url[0];?>"></a>
                </div>
                <?php } ?>
                <h4><a href="<?php echo get_permalink($post->ID);?>"><?php echo $post_data->post_title;?></a></h4>
                <?php } ?> 
            </div>
        </div><!-- /.editors_picks -->

        <div class="editors_picks">
            <div class="editors_title widget_title">
                <h3>DTH Satellites in India</h3>
            </div>
            <?php 
            $post_id = get_option('dth_satellite_band_option');
            $post_data   = get_post( $post_id );
            ?>
            <div class="editors">
                <?php if(!empty($post_id)){ 
                    $post_feat_image = wp_get_attachment_url( get_post_thumbnail_id($post_data->ID) );
                    $thumb_url = telecomtalk_aq_resize( $post_feat_image, 340, 180, true, false );
                ?>
                <?php if($post_feat_image){ ?>
                <div class="featured-image">
                    <a href="<?php echo get_permalink($post->ID);?>"><img src="<?php echo $thumb_url[0];?>"></a>
                </div>
                <?php } ?>
                <h4><a href="<?php echo get_permalink($post->ID);?>"><?php echo $post->post_title;?></a></h4>
                <?php } ?>
            </div>
        </div><!-- /.editors_picks -->

        <div class="tabs">
			<button class="tablink" onclick="openPage('Home', this, 'green')" id="defaultOpen"><b>Most Discussed</b></button>
			<button class="tablink" onclick="openPage('News', this, 'red')"><b>Trending</b></button>
            <?php
	            $most_discussed = get_option('mdcomments_interval','1 week ago');
	            $args = array(
				    'date_query' => array(
				        'after' => $most_discussed,
				        'before' => 'tomorrow',
				        'inclusive' => true,
				    ),
				);
	 			$most_discussed_posts = array(); 
	 			$comment_posts = array();
	 			$comment_count = $post_url = $tct_post_title = $ckey = '';
				$comments = get_comments( $args );
				foreach ( $comments as $comment ) {
					$most_discussed_posts[] = $comment->comment_post_ID;
				}
				$most_discussed_posts = array_unique($most_discussed_posts);
				//print_r($most_discussed);

				if(count($most_discussed_posts)>0){
					foreach ($most_discussed_posts as $pval) {
						$comment_posts[$pval] = get_comments_number($pval);
					}
				}
				if(!empty($comment_posts)){
					$most_comment = max($comment_posts);
					$ckey = array_search($most_comment,$comment_posts);
					$tct_post_title = get_the_title($ckey);
					$post_url = get_post_permalink($ckey);
					$comment_count = get_comments_number($ckey);
				}
            ?>
			<div id="Home" class="tabcontent most-discussed-post">
				<ul>
                    <?php if(!empty($comment_posts)){ ?>
				 	<li class="common">
				  		<span class="cmt-tlt">
				  			<a href="<?php echo $post_url; ?>"><?php echo $tct_post_title; ?></a></span>
				  		<span class="cmt-nmbr"><?php echo $comment_count;?></span>
				  	</li>
                    <?php }else{ ?>
                    <li class="common">
                        <span class="cmt-tlt">No Most discussed posts - <?php echo $most_discussed;?>....!</span>
                    </li>
                    <?php } ?>
			  	</ul>
			</div>
			<?php
		        $args = array(
		            'date_query' => array(
		                'after' => '1 weeks ago',
		                'before' => 'tomorrow',
		                'inclusive' => true,
		            ),
		        );
		        $commeted_posts = array();
		        $trending_posts = '';
		        $comments = get_comments( $args );
		        foreach ($comments as $key => $value) {
		           $commeted_posts[] = $value->comment_post_ID;
		        }
		        $trending_posts = array_unique($commeted_posts);
	        ?>
			<div id="News" class="tabcontent trending-posts">
			  <ul>
                <?php 
                if(count($trending_posts)>0){
                    for($i=0;$i<count($trending_posts);$i++){
                    ?>
			  	<li style="margin-bottom: 10px;">
			  		<span class="cmt-tlt">
			  			<a href="<?php echo get_post_permalink($trending_posts[$i]);?>"><?php echo get_the_title($trending_posts[$i]);?></a>
			  		</span>
			  	</li>
                <?php
                        if($i == 5){
                            break;
                        } 
                    } 
                }else{
                    ?>
                    <li style="margin-bottom: 10px;">
                        <span class="cmt-tlt">No Trending posts - 1 weeks ago....!</span>
                    </li>
                <?php } ?>
			  </ul>
			</div>
		</div><!-- /.tabs -->
		<!-- <div class="news-latter">
			<h1>News Letter</h1>
		</div> -->
        <div class="tech-news">
            <div class="editors_title widget_title">
                <h3>Tech News</h3>
            </div>
            <ul>
            	<?php
			    $recent_posts = wp_get_recent_posts(array(
			        'numberposts' => 5, // Number of recent posts thumbnails to display
			        'post_status' => 'publish', // Show only the published posts
                    'category__not_in' => 507
			    ));
			    foreach($recent_posts as $post) : 
			    	$post_feat_image = wp_get_attachment_url( get_post_thumbnail_id($post['ID']) );
                	$thumb_url = telecomtalk_aq_resize($post_feat_image, 340, 180, true, false);
			    ?>
                <li>
                    <a href="<?php echo get_permalink($post['ID']) ?>">
                    	<?php if($post_feat_image){ ?>
                        <div class="tn-img">
                        	<img src="<?php echo $thumb_url[0];?>">
                        </div>
                    	<?php } ?>
                        <h4><?php echo $post['post_title'] ?></h4>
                    </a>
                </li>
                <?php endforeach; wp_reset_query(); ?>
                <!-- <li>
                    <a href="#">
                        <div class="tn-img"><img src="https://vqz.telecomtalk.info/wp-content/uploads/2020/09/thequint_2020-09_b3407a6a-e339-466a-9ad2-f68887a0c9fa_DSC_2847-340x180.jpg"></div>
                        <h4>A handy guide to Satellites used for broadcasting DTH signals in India</h4>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="tn-img"><img src="https://vqz.telecomtalk.info/wp-content/uploads/2020/09/thequint_2020-09_b3407a6a-e339-466a-9ad2-f68887a0c9fa_DSC_2847-340x180.jpg"></div>
                        <h4>A handy guide to Satellites used for broadcasting DTH signals in India</h4>
                    </a>
                </li> -->
            </ul>
        </div>
    </div><!-- /.right-part -->
<?php //astra_sidebars_after(); ?>
<script>
function openPage(pageName, elmnt, color) {
  // Hide all elements with class="tabcontent" by default */
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Remove the background color of all tablinks/buttons
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < tablinks.length; i++) {
    //tablinks[i].style.backgroundColor = "";
  }
  document.getElementById(pageName).style.display = "block";
}
// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>

