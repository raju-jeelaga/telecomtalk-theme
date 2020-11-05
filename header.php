<?php

/**

 * The header for our theme

 *

 * This is the template that displays all of the <head> section and everything up until <div id="content">

 *

 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials

 *

 * @package telecom-talk

 */

?>

<!doctype html> 

<html <?php language_attributes(); ?>>

<head>
	<?php echo get_theme_mod( 'adscripts'); ?>
	<meta charset="<?php bloginfo( 'charset' ); ?>">

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Chrome, Firefox OS and Opera -->
	<meta name="theme-color" content="#003f76">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php 
	if(is_page_template( 'templates/state-template.php' )){
		?>
		<title><?php wp_title(''); ?></title>
		<?php
	}
	?>
	
	<?php do_action("tt_show_metatags"); ?>	
	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">

	<header class="site-header header-navigation" id="header">
		<div class="h-m">

		</div>
		<?php 
		$myposts = get_posts( array(
	        'posts_per_page' => 5,
	        'category'       => 503,
	        'order'          => 'DESC',
	    ) );
		?>
		<div class="breaking-news">
			<h3>BREAKING</h3>
			<marquee class="mvt" onMouseOver="this.stop()" onMouseOut="this.start()">
				<?php if ( $myposts ) { ?>
					<ul>
						<?php 
						foreach ( $myposts as $post ) {
	            			setup_postdata( $post ); 
	            		?>
							<li><?php echo strip_tags(get_the_content());?></li>
						<?php 
						}
						wp_reset_postdata();
						?>
					</ul>
				<?php } ?>
			</marquee>
		</div>
		<div class="head-sec">
			<div class="container">
				<div class="h-s">
					<div class="lg">
						<a href="<?php echo esc_url( home_url() ); ?>">
		                <?php 
		                $custom_logo_id = esc_attr( get_theme_mod( 'custom_logo' ) );
		                if( $custom_logo_id ) {
		                	$logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
		                }
		                if ( has_custom_logo() ) {       	
		                    echo '<img src="'. esc_url( $logo[0] ) .'" alt="logo-2">';
		                } else {
		                    echo '<h1>'. esc_attr( get_bloginfo( 'name' ) ) .'</h1><span>'. esc_attr( get_bloginfo( 'description', 'display' ) ) .'</span>';
		                } ?>
		              </a>
					</div><!-- /.lg -->
					<div class="primary-menu">
						<?php if(has_nav_menu ('primary_nav'))
					    		wp_nav_menu( array( 
					    			'container' => '',
					    			'container_id' => '',
					    			'theme_location' => 'primary_nav',
					    			'sort_column' => 'menu_order',
					    			'menu_class' => 'menu',
					    			//'walker' => $m3walker  
					    		)
					    	);
					    ?>
					</div><!-- /. p-m -->

					<div class="srch">
						<?php get_search_form(); ?>
					</div>
				</div><!-- /.h2 -->
			</div><!-- /.container -->
		</div><!-- /. head-2 -->
	</header><!-- #masthead -->


<div id="content" class="site-content">