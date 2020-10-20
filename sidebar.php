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

			<div id="Home" class="tabcontent">
			  <ul>
			  	<li class="common">
			  		<span class="cmt-tlt">
			  			<a href="#">Consumer Experience : Can you really rely on Telenor Internet – let’s check !</a></span>
			  		<span class="cmt-nmbr">54</span>
			  	</li>
			  </ul>
			</div>

			<div id="News" class="tabcontent">
			  <ul>
			  	<li>
			  		<span class="cmt-tlt">
			  			<a href="#">Consumer Experience : Can you really rely on Telenor Internet – let’s check !</a>
			  		</span>
			  	</li>
			  </ul>
			</div>
		</div><!-- /.tabs -->
		<div class="news-latter">
			<h1>News Letter</h1>
		</div>

		<div class="editors_picks">
            <div class="editors_title widget_title">
                <h3>DTH Satellites in India</h3>
            </div>
            <div class="editors">
                <div class="featured-image">
                    <a href="#"><img src="https://web.archive.org/web/20160313060842im_/http://telecomtalk.info/wp-content/uploads/2015/08/Satellites-dth-india-340x175.png"></a>
                </div>
                <h4><a href="#">A handy guide to Satellites used for broadcasting DTH signals in India</a></h4>
            </div>
        </div><!-- /.editors_picks -->
    </div><!-- /.right-part -->
<?php //astra_sidebars_after(); ?>


