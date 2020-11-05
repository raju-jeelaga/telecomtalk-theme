<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Astra
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>

<main id="content-area">
    <div class="container">
        <div class="hbp">
            <?php
            $post_ids = get_option('hbp_option');
            $posts_arr = explode(',', $post_ids);
            if(!empty($posts_arr)){
                for($i=0;$i<count($posts_arr);$i++){
                    $post = get_post( $posts_arr[$i] );
                    $post_content = $post->post_content;
                    $post_title = $post->post_title;
                    $post_feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
                    $thumb_url = telecomtalk_aq_resize( $post_feat_image, 115, 75, true, false );
                    ?>
                    <div class="hbp-list">
                        <div class="hbp-img">
                            <a href="<?php echo get_permalink($post->ID);?>"><img src="<?php echo $thumb_url[0];?>">
                            </a>
                            <span><?php echo $post_title;?></span>
                        </div>
                        <h4><a href="<?php echo get_permalink($post->ID);?>"><?php echo wp_trim_words( $post_content, 10, '...' );?></a></h4>
                    </div>
                    <?php
                }
            }   
            ?>
        </div>
        <div class="main-cnt">
            <div class="left-part">
                <div class="blog-posts">
                    <div class="lnbp">
                	<?php
				    $recent_posts = wp_get_recent_posts(array(
				        'numberposts' => 1, // Number of recent posts thumbnails to display
				        'post_status' => 'publish' // Show only the published posts
				    ));
				    foreach($recent_posts as $post) : 
				    	$post_feat_image = wp_get_attachment_url( get_post_thumbnail_id($post['ID']) );
                    	$thumb_url = telecomtalk_aq_resize($post_feat_image, 468, 240, true, false);
				    	?>
				    	<?php if($post_feat_image){?>
			    		<div class="lnbp-img">
                            <a href="<?php echo get_permalink($post['ID']) ?>"><img src="<?php echo $thumb_url[0];?>"></a>
                        </div>
				    	<?php }	?>
                        <div class="lnbp-cnt">
                            <h2>
                                <span>Just in</span>
                                <a href="<?php echo get_permalink($post['ID']) ?>"><?php echo $post['post_title'] ?></a>
                            </h2>
                            <p><?php echo wp_trim_words($post['post_content'],50,'....') ?> <a href="<?php echo get_permalink($post['ID']) ?>">Continue Reading</a></p>
                            <div class="authr-info">
                                <h5 class="authr-left">By
                                    <span class="athr-nm">Zari Ali</span>
                                    <span class="athr-dt">March 13th, 2016</span>
                                    <a class="athr-cmts" href="<?php echo get_comments_link( $post['ID'] );?>" target="_blank"><?php echo get_comments_number($post['ID']);?></a>
                                </h5>
                                <ul class="authr-rght">
                                    <li class="st"><a href="#"><i class="fab fa-twitter"></i></a></li>
                                    <li class="sf"><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                    <li class="sw"><a href="#"><i class="fab fa-whatsapp"></i></a></li>
                                    <li class="stg"><a href="#"><i class="fab fa-telegram-plane"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <?php endforeach; wp_reset_query(); ?>
                        <?php 
                        $myposts = get_posts( array(
					        'posts_per_page' => 2,
					        'category'       => 504,
					        'order'          => 'DESC',
					    ) );
                        ?>
                        <div class="category-posts c-1">
                            <div class="category t_c">
                            	<?php $category_link = get_category_link( 504 );?>
                                <a title="Editorial" href="<?php echo $category_link;?>">Editorial</a>
                            </div>
                            <div class="cat-pst">
                                <div class="left-cp">
                                    <ul class="l-big-post">
                                    	<?php
                                    	if ( $myposts ) { 
											foreach ( $myposts as $post ) {
						            			setup_postdata( $post );
						            			$post_feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
                    							$thumb_url = telecomtalk_aq_resize( $post_feat_image, 216, 140, true, false ); 
						            		?>
											<li>
												<?php if($post_feat_image){ ?>
	                                            <a href="<?php echo get_permalink($post->ID);?>">
	                                                <img src="<?php echo $thumb_url[0];?>">
	                                            </a>
	                                        	<?php } ?>
	                                            <h3>
	                                                <a href="<?php echo get_permalink($post->ID);?>"><?php echo $post->post_title;?></a>
	                                            </h3>
	                                        </li>
											<?php 
											}
											wp_reset_postdata();
										}
										?>
                                    </ul>
                                </div><!-- /.left-cp -->
                                <div class="right-cp">
                                    <ul class="r-small-posts">
                                    	<?php
                                    	$myposts_list = get_posts( array(
									        'posts_per_page' => 5,
									        'category'       => 504,
									        'offset'         => 2,
									        'order'          => 'DESC',
									    ) );
                                    	$category_link = get_category_link( 504 );
                                    	if ( $myposts_list ) { 
	                                    	foreach ( $myposts_list as $post ) {
							            			setup_postdata( $post );
							            			$post_feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
	                    							$thumb_url = telecomtalk_aq_resize( $post_feat_image, 80, 52, true, false );
							            	?>
	                                        <li>
	                                            <div class="sp-f-m">
		                                            <?php if($post_feat_image){ ?>
			                                            <a class="f-m" href="<?php echo get_permalink($post->ID);?>">
			                                                <img src="<?php echo $thumb_url[0];?>">
			                                            </a>
		                                        	<?php } ?>
	                                            </div>
	                                            <h3>
	                                                <a href="<?php echo get_permalink($post->ID);?>"><?php echo $post->post_title;?></a>
	                                            </h3>
	                                        </li>
                                    	<?php }
                                    		wp_reset_postdata();
                                    	}
                                    	?>
                                    </ul>
                                </div><!-- /.right-cp -->
                            </div><!-- /.cat-pst -->
                            <div class="viewmore">
                                <a href="<?php echo $category_link;?>">View More...</a>
                            </div>
                        </div><!-- /.category-posts -->

                        <div class="category-postsc-2">
                            <div class="category t_c int">
                            	<?php $category_link = get_category_link( 505 );?>
                                <a title="Editorial" href="<?php echo $category_link;?>">Interview</a>
                            </div>
                            <div class="cat-pst">
                                <div class="left-cp">
                                	<?php 
			                        $myposts = get_posts( array(
								        'posts_per_page' => 2,
								        'category'       => 505,
								        'order'          => 'DESC',
								    ) );
			                        ?>
                                    <ul class="l-big-post">
                                    	<?php
                                    	if ( $myposts ) { 
											foreach ( $myposts as $post ) {
						            			setup_postdata( $post );
						            			$post_feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
                    							$thumb_url = telecomtalk_aq_resize( $post_feat_image, 216, 140, true, false ); 
						            		?>
                                        <li>
                                        	<?php if($post_feat_image){ ?>
	                                            <a href="<?php echo get_permalink($post->ID);?>">
	                                                <img src="<?php echo $thumb_url[0];?>">
	                                            </a>
                                        	<?php } ?>
                                            <h3>
                                                <a href="<?php echo get_permalink($post->ID);?>"><?php echo $post->post_title;?></a>
                                            </h3>
                                        </li>
                                        <?php 
											}
											wp_reset_postdata();
										}
										?>
                                    </ul>
                                </div><!-- /.left-cp -->
                                <div class="right-cp">
                                    <ul class="r-small-posts">
                                    	<?php
                                    	$myposts_list = get_posts( array(
									        'posts_per_page' => 5,
									        'category'       => 505,
									        'offset'         => 2,
									        'order'          => 'DESC',
									    ) );
                                    	$category_link = get_category_link( 505 );
                                    	if ( $myposts_list ) { 
	                                    	foreach ( $myposts_list as $post ) {
							            			setup_postdata( $post );
							            			$post_feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
	                    							$thumb_url = telecomtalk_aq_resize( $post_feat_image, 80, 52, true, false );
							            	?>
                                        <li>
                                            <h3>
                                            	<?php if($post_feat_image){ ?>
                                                	<a href="<?php echo get_permalink($post->ID);?>"><?php echo $post->post_title;?></a>
                                            	<?php } ?>
                                            </h3>
                                        </li>
                                        <?php 
											}
											wp_reset_postdata();
										}
										?>
                                    </ul>
                                </div><!-- /.right-cp -->
                            </div><!-- /.cat-pst -->
                            <div class="viewmore">
                                <a href="<?php echo $category_link;?>">View More...</a>
                            </div>
                        </div><!-- /.category-posts -->

                        <div class="category-posts c-3">
                            <div class="category f_c">
                            	<?php $category_link = get_category_link( 506 );?>
                                <a title="Editorial" href="<?php echo $category_link;?>">Analysis</a>
                            </div>
                            <div class="cat-pst">
                                <div class="left-cp">
                                    <ul class="l-big-post">
                                    	<?php 
				                        $myposts = get_posts( array(
									        'posts_per_page' => 2,
									        'category'       => 506,
									        'order'          => 'DESC',
									    ) );
				                        ?>
				                        <?php
                                    	if ( $myposts ) { 
											foreach ( $myposts as $post ) {
						            			setup_postdata( $post );
						            			$post_feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
                    							$thumb_url = telecomtalk_aq_resize( $post_feat_image, 216, 140, true, false ); 
						            		?>
                                        <li>
                                        	<?php if($post_feat_image){ ?>
                                            <a href="<?php echo get_permalink($post->ID);?>">
                                                <img src="<?php echo $thumb_url[0];?>">
                                            </a>
                                        	<?php } ?>
                                            <h3>
                                                <a href="<?php echo get_permalink($post->ID);?>"><?php echo $post->post_title;?></a>
                                            </h3>
                                        </li>
                                        <?php 
											}
											wp_reset_postdata();
										}
										?>
                                    </ul>
                                </div><!-- /.left-cp -->
                                <div class="right-cp">
                                    <ul class="r-small-posts">
                                    	<?php
                                    	$myposts_list = get_posts( array(
									        'posts_per_page' => 5,
									        'category'       => 506,
									        'offset'         => 2,
									        'order'          => 'DESC',
									    ) );
                                    	$category_link = get_category_link( 505 );
                                    	if ( $myposts_list ) { 
	                                    	foreach ( $myposts_list as $post ) {
							            			setup_postdata( $post );
							            			$post_feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
	                    							$thumb_url = telecomtalk_aq_resize( $post_feat_image, 80, 52, true, false );
							            	?>
                                        <li>
                                        	<?php if($post_feat_image){ ?>
                                            <div class="sp-f-m">
	                                            <a class="f-m" href="<?php echo get_permalink($post->ID);?>">
	                                                <img src="<?php echo $thumb_url[0];?>">
	                                            </a>
                                            </div>
                                        	<?php } ?>
                                            <h3>
                                                <a href="<?php echo get_permalink($post->ID);?>"><?php echo $post->post_title;?></a>
                                            </h3>
                                        </li>
                                        <?php 
											}
											wp_reset_postdata();
										}
										?>
                                    </ul>
                                </div><!-- /.right-cp -->
                            </div><!-- /.cat-pst -->
                            <div class="viewmore">
                                <a href="<?php echo $category_link;?>">View More...</a>
                            </div>
                        </div><!-- /.category-posts -->

                        <div class="category-posts c-4">
                            <div class="category s_c">
                            	<?php $category_link = get_category_link( 118 );?>
                                <a title="Editorial" href="<?php echo $category_link;?>">Voice & Data</a>
                            </div>
                            <div class="cat-pst vd-pst">
                                <div class="left-cp">
                                    <div class="vd-big-post">
                                    	<?php 
				                        $myposts = get_posts( array(
									        'posts_per_page' => 1,
									        'category'       => 118,
									        'order'          => 'DESC',
									    ) );
				                        ?>
				                        <?php
                                    	if ( $myposts ) { 
											foreach ( $myposts as $post ) {
						            			setup_postdata( $post );
						            			$post_feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
                    							$thumb_url = telecomtalk_aq_resize( $post_feat_image, 216, 140, true, false );

						            		?>
						            	<?php if($post_feat_image){ ?>
						            		<div class="vd-fm">
	                                            <a href="<?php echo get_permalink($post->ID); ?>">
	                                                <img src="<?php echo $thumb_url[0];?>">
	                                            </a>
	                                        </div>
						            	<?php  } ?>
                                        <h3>
                                            <a href="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title;?></a>
                                        </h3>
                                        <?php 
											}
											wp_reset_postdata();
										}
										?>
                                    </div><!-- /.vd-fm -->
                                </div><!-- /.left-cp -->
                                <div class="right-cp">
                                    <ul class="vd r-small-posts">
                                    	<?php 
                                    	$myposts_list = get_posts( array(
									        'posts_per_page' => 4,
									        'category'       => 118,
									        'offset'         => 2,
									        'order'          => 'DESC',
									    ) );
                                    	$category_link = get_category_link( 118 );
                                    	if ( $myposts_list ) { 
	                                    	foreach ( $myposts_list as $post ) {
							            			setup_postdata( $post );
							            			$post_feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
	                    							$thumb_url = telecomtalk_aq_resize( $post_feat_image, 80, 52, true, false );
	                    							
							            	?>
                                        <li>
                                        	<?php if($post_feat_image){ ?>
                                            <div class="sp-f-m">
	                                            <a class="f-m" href="<?php echo get_permalink($post->ID); ?>">
	                                                <img src="<?php echo $thumb_url[0];?>">
	                                            </a>
                                            </div>
                                        	<?php } ?>
                                            <h3>
                                                <a href="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title;?></a>
                                            </h3>
                                        </li>
                                        <?php 
											}
											wp_reset_postdata();
										}
										?>
                                    </ul>
                                </div><!-- /.right-cp -->
                            </div><!-- /.cat-pst -->
                            <div class="viewmore">
                                <a href="<?php echo $category_link;?>">View More...</a>
                            </div>
                        </div><!-- /.category-posts -->

                        <div class="category-posts c-5">
                            <div class="category for_c">
                            	<?php $category_link = get_category_link( 15 );?>
                                <a title="Editorial" href="<?php echo $category_link;?>">Mobiles & Tablets</a>
                            </div>
                            <div class="cat-pst vd-pst">
                                <div class="left-cp m-t">
                                	<?php 
			                        $myposts = get_posts( array(
								        'posts_per_page' => 2,
								        'category'       => 15,
								        'order'          => 'DESC',
								    ) );
			                        ?>
			                        <?php
                                	if ( $myposts ) { 
										foreach ( $myposts as $post ) {
					            			setup_postdata( $post );
					            			$post_feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
                							$thumb_url = telecomtalk_aq_resize( $post_feat_image, 216, 140, true, false );

					            		?>
                                    <div class="vd-big-post mt">
                                    	<?php if($post_feat_image){ ?>
                                        <div class="vd-fm">
                                            <a href="<?php echo get_permalink($post->ID); ?>">
                                                <img src="<?php echo $thumb_url[0];?>">
                                            </a>
                                        </div>
                                    	<?php } ?>
                                        <h3>
                                            <a href="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title;?></a>
                                        </h3>
                                    </div><!-- /.vd-fm -->
                                    <?php 
										}
										wp_reset_postdata();
									}
									?>
                                </div><!-- /.left-cp -->
                                <div class="right-cp">
                                    <ul class="vd r-small-posts">
                                    	<?php 
                                    	$myposts_list = get_posts( array(
									        'posts_per_page' => 4,
									        'category'       => 15,
									        'offset'         => 2,
									        'order'          => 'DESC',
									    ) );
                                    	$category_link = get_category_link( 15 );
                                    	if ( $myposts_list ) { 
	                                    	foreach ( $myposts_list as $post ) {
							            			setup_postdata( $post );
							            			$post_feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
	                    							$thumb_url = telecomtalk_aq_resize( $post_feat_image, 80, 52, true, false );
	                    							
							            	?>
                                        <li>
                                        	<?php if($post_feat_image){ ?>
                                            <div class="sp-f-m">
                                            <a class="f-m" href="#">
                                                <img src="<?php echo $thumb_url[0];?>">
                                            </a>
                                            </div>
                                        	<?php } ?>
                                            <h3>
                                                <a href="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title;?></a>
                                            </h3>
                                        </li>
                                        <?php 
											}
											wp_reset_postdata();
										}
										?>
                                    </ul>
                                </div><!-- /.right-cp -->
                            </div><!-- /.cat-pst -->
                            <div class="viewmore">
                            	<?php $category_link = get_category_link( 15 );?>
                                <a href="<?php echo $category_link;?>">View More...</a>
                            </div>
                        </div><!-- /.category-posts -->

                        <div class="category-posts c-6">
                            <div class="category s_c">
                            	<?php $category_link = get_category_link( 8 );?>
                                <a title="Editorial" href="<?php echo $category_link;?>">Broadband</a>
                            </div>
                            <div class="cat-pst vd-pst">
                            	
                                <div class="left-cp">
                                    <div class="vd-big-post">
                                    	<?php 
				                        $myposts = get_posts( array(
									        'posts_per_page' => 1,
									        'category'       => 8,
									        'order'          => 'DESC',
									    ) );
				                        ?>
				                        <?php
	                                	if ( $myposts ) { 
											foreach ( $myposts as $post ) {
						            			setup_postdata( $post );
						            			$post_feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
	                							$thumb_url = telecomtalk_aq_resize( $post_feat_image, 216, 140, true, false );

						            	?>
						            	<?php if($post_feat_image){ ?>
                                        <div class="vd-fm">
                                            <a href="<?php echo get_permalink($post->ID); ?>">
                                                <img src="<?php echo $thumb_url[0];?>">
                                            </a>
                                        </div>
                                    	<?php } ?>
                                        <h3>
                                            <a href="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title;?></a>
                                        </h3>
                                        <?php 
											}
											wp_reset_postdata();
										}
										?>
                                    </div><!-- /.vd-fm -->
                                </div><!-- /.left-cp -->
                                <div class="right-cp">
                                    <ul class="vd r-small-posts">
                                    	<?php 
                                    	$myposts_list = get_posts( array(
									        'posts_per_page' => 4,
									        'category'       => 8,
									        'offset'         => 2,
									        'order'          => 'DESC',
									    ) );
                                    	$category_link = get_category_link( 8 );
                                    	if ( $myposts_list ) { 
	                                    	foreach ( $myposts_list as $post ) {
							            			setup_postdata( $post );
							            			$post_feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
	                    							$thumb_url = telecomtalk_aq_resize( $post_feat_image, 80, 52, true, false );
	                    							
							            	?>
                                        <li>
                                        	<?php if($post_feat_image){ ?>
                                            <div class="sp-f-m">
                                            <a class="f-m" href="<?php echo get_permalink($post->ID); ?>">
                                                <img src="<?php echo $thumb_url[0];?>">
                                            </a>
                                            </div>
                                        	<?php } ?>
                                            <h3>
                                                <a href="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title;?></a>
                                            </h3>
                                        </li>
                                        <?php 
											}
											wp_reset_postdata();
										}
										?>
                                        
                                    </ul>
                                </div><!-- /.right-cp -->
                            </div><!-- /.cat-pst -->
                            <div class="viewmore">
                            	<?php $category_link = get_category_link( 8 );?>
                                <a href="<?php echo $category_link;?>">View More...</a>
                            </div>
                        </div><!-- /.category-posts -->
                    </div><!-- /.lnbp -->

                    <div class="lnsp">
                        <div class="lat_title">
                            <h3>Latest News</h3><span>Last Updated 3 hours ago</span>
                        </div>
                        <?php
                        $paged = max(1, get_query_var('paged'));

						$args = array(
						   'posts_per_page' => 10,
						   'paged' => $paged,
						   'post_type' => 'post',
                           'category__not_in' => 507
						);
                        if($paged == 1){
                            $args['offset'] = 1;
                        }
                        
						$custom_query = new WP_Query( $args );
						while($custom_query->have_posts()) : 
						   	$custom_query->the_post();
						   	$featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full');
						   	$thumb_url = telecomtalk_aq_resize( $featured_img_url, 120, 85, true, false );
						?>
                        <div class="lat-news-sp">
                            <h2><a href="<?php the_permalink(); ?>"><?php echo get_the_title();?></a></h2>
                            <div class="lat-news-cnt">
                                <div class="featured-image">
                                    <img src="<?php echo $thumb_url[0];?>">
                                </div>
                                <div class="sp-cnt">
                                    <p><?php echo wp_trim_words(get_the_content(),31,'....');?><a href="<?php the_permalink(); ?>">Read more</a></p>
                                    <div class="authr-info">
                                        <h5 class="authr-left">By
                                            <span class="athr-nm"><?php the_author(); ?></span>
                                            <span class="athr-dt"><?php echo get_the_date( 'M dS Y', get_the_ID() ); ?></span>
                                            <a class="athr-cmts" href="<?php echo get_comments_link();?>" target="_blank"><?php echo get_comments_number();?></a>
                                        </h5>
                                        <ul class="authr-rght">
                                            <li class="st"><a href="#"><i class="fab fa-twitter"></i></a></li>
                                            <li class="sf"><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                            <li class="sw"><a href="#"><i class="fab fa-whatsapp"></i></a></li>
                                            <li class="stg"><a href="#"><i class="fab fa-telegram-plane"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    	<?php endwhile; wp_reset_query();?>
                        <div class="pagination">
                            <?php
                                $total_pages = $custom_query->max_num_pages;
                                if ($total_pages > 1){

                                    $current_page = max(1, get_query_var('paged'));

                                    echo paginate_links(array(
                                        'base' => get_pagenum_link(1) . '%_%',
                                        'format' => '/page/%#%',
                                        'current' => $current_page,
                                        'total' => $total_pages,
                                        'prev_text'    => __('« Prev Page'),
                                        'next_text'    => __('Next Page »'),
                                        'type'  => 'list',
                                        'add_args'  => array()
                                    ));
                                }
                            ?>
                        </div>
                        <!-- <div class="pagination">
                            <ul>
                                <li class="active"><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li>…</li>
                                <li><a href="#">840</a></li>
                                <li class="next-page"><a href="#">Next Page »</a></li>
                            </ul>
                        </div> -->
                    </div> <!-- /.lnsp -->

                </div>
            </div><!-- /.left-part -->
            <?php get_sidebar();?>
        </div><!-- /.main-cnt -->
    </div><!-- /.container -->     
</main>
<?php get_footer(); ?>

