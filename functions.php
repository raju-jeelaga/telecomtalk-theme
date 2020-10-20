<?php
function telecomtalk_videos_page() {
   	add_menu_page( 
        __( 'Video Settings', 'textdomain' ),
        'Videos Option',
        'manage_options',
        'tctvideos_settings',
        'telecomtalk_videos_html',
        '',
        6
    );

    add_action( 'admin_init', 'telecomtalk_video_settings' );
}
add_action("admin_menu", "telecomtalk_videos_page");

function telecomtalk_video_settings() {
	for($i=1;$i<=3;$i++){
		$video_title = "video_title_".$i;
		$cover_image = "image_url_".$i;
		$video_link = "video_link_".$i;
		$attachment_id = "attachment_id_".$i;
		register_setting( 'tctvideo_settings', $video_title );
		register_setting( 'tctvideo_settings', $cover_image );
		register_setting( 'tctvideo_settings', $video_link );
		register_setting( 'tctvideo_settings', $attachment_id );
	}
}

function telecomtalk_videos_html(){
	?>
	<div class="wrap">
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form action="options.php" method="post" name="tctvideos" enctype="multipart/form-data" class="tctvideos" id="tctvideos">
			<?php 
			settings_fields( 'tctvideo_settings' );
			do_settings_sections( 'tctvideo_settings' );
			?>
			<table class="form-table">
				<?php
				for($i=1;$i<=3;$i++){
					$video_title = "video_title_".$i;
					$cover_image = "image_url_".$i;
					$video_link = "video_link_".$i;
					$attachment_id = "attachment_id_".$i;
					if(!empty(get_option($attachment_id)) ){
						$attachment = true;
					}else{
						$attachment = false;
					}
					?>
			    <tr valign="top">
			    <th scope="row">Video Title <?php echo $i;?></th>
			    <td><input type="text" name="<?php echo $video_title;?>" value="<?php echo esc_attr( get_option($video_title) ); ?>" size="50"/>
			    </td>
			    </tr>
			    <tr valign="top">
			    <th scope="row">Video Cover Image <?php echo $i;?></th>
			    <td>
			    	<div class="upload_file_data">
				    	<input type="text" class="image_path" name="<?php echo $cover_image;?>" value="<?php echo esc_attr( get_option($cover_image) ); ?>" size="50" readonly/>
				    	<input type="hidden" class="attachment_id" name="<?php echo $attachment_id;?>" value="<?php echo esc_attr( get_option($attachment_id) ); ?>" />
				    	<input type="button" value="Upload Image" class="upload_image button-primary" class="upload_image"/>
				    	<div class="show_upload_preview">
					        <?php if($attachment){
					        ?>
					        <img src="<?php echo esc_attr(get_option($cover_image)) ; ?>" width="300px" height="200px">
					        <input type="button" name="remove" value="Remove Image" class="button-primary remove_image"/>
					        <?php } ?>
					    </div>
				    </div>
			    </td>
			    </tr>
			    <tr valign="top">
			    <th scope="row">Video Link <?php echo $i;?></th>
			    <td><input type="text" name="<?php echo $video_link;?>" value="<?php echo esc_attr( get_option($video_link) ); ?>" size="50"/>
			    </td>
			    </tr>
			    <tr><td colspan="2"><hr></td></tr>
				<?php } ?>
			</table>
			<?php submit_button(); ?>
		</form>
	</div>

	<?php
}
function media_uploader_enqueue() {
    wp_enqueue_media();
    wp_enqueue_script('tct-media-uploader');
    //wp_enqueue_style( 'stylesheet', plugins_url( 'stylesheet.css', __FILE__ ));
}
add_action('admin_enqueue_scripts', 'media_uploader_enqueue');

add_filter('comment_form_default_fields', 'tct_unset_url_field');
function tct_unset_url_field($fields){
    if(isset($fields['url']))
       unset($fields['url']);
       return $fields;
}
add_filter('comment_form_default_fields', 'telecomtalk_comments_custom_fields');
function telecomtalk_comments_custom_fields($fields) {
	$fields[ 'city' ] = '<p class="comment-form-city">'.
      '<label for="city">' . __( 'City' ) . ' </label>'.
      '<input id="city" name="city" type="text" size="30"  tabindex="4" /></p>';
      return $fields;
}
add_action( 'comment_post', 'save_comment_meta_data' );
function save_comment_meta_data( $comment_id ) {
  	if ( ( isset( $_POST['city'] ) ) && ( $_POST['city'] != ’) )
  	$city = wp_filter_nohtml_kses($_POST['city']);
  	add_comment_meta( $comment_id, 'city', $city );
}
add_filter( 'comment_text', 'telecomtalk_modify_comment');
function telecomtalk_modify_comment( $text ){
	if( $commentcity = get_comment_meta( get_comment_ID(), 'city', true ) ) {
		$commentcity = '<strong>' . esc_attr( $commentcity ) . '</strong><br/>';
		$text = $commentcity . $text;
	}
	return $text;
}

// Add an edit option to comment editing screen  
add_action( 'add_meta_boxes_comment', 'telecomtalk_extend_comment_add_meta_box' );
function telecomtalk_extend_comment_add_meta_box() {
    add_meta_box( 'title', __( 'Comment Metadata - Extend Comment' ), 'telecomtalk_extend_comment_meta_box', 'comment', 'normal', 'high' );
}
function telecomtalk_extend_comment_meta_box($comment){
	$city = get_comment_meta( $comment->comment_ID, 'city', true );
	wp_nonce_field( 'extend_comment_update', 'extend_comment_update', false );
	?>
	 <table class="form-table">
    	<tr>
        	<td><label for="city"><?php _e( 'City' ); ?></label></td>
        	<td><input type="text" name="city" value="<?php echo esc_attr( $city ); ?>" class="widefat" /></td>
        </tr>
    </table>
	<?php 
}
add_action( 'edit_comment', 'telecomtalk_comment_edit_metafields' );

function telecomtalk_comment_edit_metafields( $comment_id ) {
    if( ! isset( $_POST['extend_comment_update'] ) || ! wp_verify_nonce( $_POST['extend_comment_update'], 'extend_comment_update' ) ) return;

	if ( ( isset( $_POST['city'] ) ) && ( $_POST['city'] != ’) ):
	$city = wp_filter_nohtml_kses($_POST['city']);
	update_comment_meta( $comment_id, 'city', $city );
	else :
	delete_comment_meta( $comment_id, 'city');
	endif;
}

function telecomtalk_add_custom_box()
{
    $screens = ['post'];
    foreach ($screens as $screen) {
        add_meta_box(
            'telecomtalk_box_id',           // Unique ID
            'Telecomtalk Custom Fields',  // Box title
            'telecomtalk_custom_box_html',  // Content callback, must be of type callable
            $screen                   // Post type
        );
    }
}
add_action('add_meta_boxes', 'telecomtalk_add_custom_box');
function telecomtalk_custom_box_html($post)
{
	$tct_fields = get_post_meta( $post->ID, 'telecomtalk_custom_fields', true );
	$sub_heading = 'none';
	if($tct_fields['enable_sub_heading']){
		$sub_heading = "table-row";
	}
	$heightlights = 'none';
	if($tct_fields['enable_hightlights']){
		$heightlights = "table-row";
	}
    ?>
    <style type="text/css">
    .switch { position: relative;  display: inline-block;  width: 54px;  height: 28px;}
	.switch input { opacity: 0; width: 0; height: 0;}
	.slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; -webkit-transition: .4s; transition: .4s;}
	.slider:before {  position: absolute;  content: "";  height: 20px;  width: 20px;  left: 4px;
  bottom: 4px;  background-color: white;  -webkit-transition: .4s;  transition: .4s;}
	input:checked + .slider {background-color: #2196F3;}
	input:focus + .slider {  box-shadow: 0 0 1px #2196F3;}
	input:checked + .slider:before {  -webkit-transform: translateX(26px);  -ms-transform: translateX(26px);  transform: translateX(26px);}
	/* Rounded sliders */
	.slider.round { border-radius: 34px;}
	.slider.round:before { border-radius: 50%;}
    </style>

    <table class="form-table">
    	<tr>
    		<td style="width:30%;"><label for="wporg_field">Enable Sub Heading</label></td>
    		<td style="width:70%;"><label class="switch"><input type="checkbox" id="enable_sub_heading" name="enable_sub_heading" value="<?php echo ($tct_fields['enable_sub_heading']) ? '1':'0';?>" <?php echo ($tct_fields['enable_sub_heading']) ? 'checked':'';?>><span class="slider round"></span></label></td>
    	</tr>
    	<tr class="sub_heading_field" style="display:<?php echo $sub_heading;?>">
    		<td style="width:30%;"><label for="wporg_field">Sub Heading</label></td>
    		<td style="width:70%;"><input type="text" name="sub_heading" class="sub_heading" value="<?php echo $tct_fields['sub_heading'];?>" style="width:100%"></td>
    	</tr>
    	<tr>
    		<td style="width:30%;"><label for="wporg_field">Enable Highlights</label></td>
    		<td style="width:70%;"><label class="switch"><input type="checkbox" id="enable_hightlights" name="enable_hightlights" value="<?php echo ($tct_fields['enable_hightlights']) ? '1':'0';?>" <?php echo ($tct_fields['enable_sub_heading']) ? 'checked':'';?>><span class="slider round"></span></label></td>
    	</tr>
    	<tr class="hightlight_fields" style="display:<?php echo $heightlights;?>;">
    		<td style="width:30%;"><label for="wporg_field">Highlights Heading</label></td>
    		<td style="width:70%;"><input type="text" name="highlights_heading" class="highlights_heading" value="<?php echo ($tct_fields['highlights_heading']?$tct_fields['highlights_heading']:'Highlights');?>" style="width:100%"></td>
    	</tr>
    	<tr class="hightlight_fields" style="display:<?php echo $heightlights;?>;">
    		<td style="width:30%;"><label for="wporg_field">Heading 1</label></td>
    		<td style="width:70%;"><input type="text" name="heading_1" class="heading_1" value="<?php echo $tct_fields['heading_1'];?>" style="width:100%"></td>
    	</tr>
    	<tr class="hightlight_fields" style="display:<?php echo $heightlights;?>;">
    		<td style="width:30%;"><label for="wporg_field">Heading 2</label></td>
    		<td style="width:70%;"><input type="text" name="heading_2" class="heading_2" value="<?php echo $tct_fields['heading_2'];?>" style="width:100%"></td>
    	</tr>
    	<tr class="hightlight_fields" style="display:<?php echo $heightlights;?>;">
    		<td style="width:30%;"><label for="wporg_field">Heading 3</label></td>
    		<td style="width:70%;"><input type="text" name="heading_3" class="heading_3" value="<?php echo $tct_fields['heading_3'];?>" style="width:100%"></td>
    	</tr>
    	<!-- <tr class="hightlight_fields" style="display:<?php echo $heightlights;?>;">
    		<td style="width:30%;"><label for="wporg_field">Heading 4</label></td>
    		<td style="width:70%;"><input type="text" name="heading_4" class="heading_4" value="<?php echo $tct_fields['heading_4'];?>" style="width:100%"></td>
    	</tr>
    	<tr class="hightlight_fields" style="display:<?php echo $heightlights;?>;">
    		<td style="width:30%;"><label for="wporg_field">Heading 5</label></td>
    		<td style="width:70%;"><input type="text" name="heading_5" class="heading_5" value="<?php echo $tct_fields['heading_5'];?>" style="width:100%"></td>
    	</tr>
    	<tr class="hightlight_fields" style="display:<?php echo $heightlights;?>;">
    		<td style="width:30%;"><label for="wporg_field">Heading 6</label></td>
    		<td style="width:70%;"><input type="text" name="heading_6" class="heading_6" value="<?php echo $tct_fields['heading_6'];?>" style="width:100%"></td>
    	</tr> -->
    </table>
    <script type="text/javascript">
    	jQuery(document).ready(function($){
	        $('#enable_sub_heading').click(function(){
	            if($(this).prop("checked") == true){
	                $(this).val("1");
	                $('.sub_heading_field').show();
	            }
	            else if($(this).prop("checked") == false){
	                $(this).val("0");
	                $('.sub_heading_field').hide();
	            }
	        });
	        $('#enable_hightlights').click(function(){
	            if($(this).prop("checked") == true){
	                $(this).val("1");
	                $('.hightlight_fields').show();
	            }
	            else if($(this).prop("checked") == false){
	                $(this).val("0");
	                $('.hightlight_fields').hide();
	            }
	        });
	    });
    </script>
    
    <?php
}
function telecomtalk_save_postdata($post_id)
{
	//enable_sub_heading,sub_heading,enable_hightlights,highlights_heading,heading_1
	$post_data['enable_sub_heading'] = isset($_POST['enable_sub_heading'])? $_POST['enable_sub_heading']:''; 
	$post_data['sub_heading'] = isset($_POST['sub_heading'])? $_POST['sub_heading']:''; 
	$post_data['enable_hightlights'] = isset($_POST['enable_hightlights'])? $_POST['enable_hightlights']:''; 
	$post_data['highlights_heading'] = isset($_POST['highlights_heading'])? $_POST['highlights_heading']:''; 
	$post_data['heading_1'] = isset($_POST['heading_1'])? $_POST['heading_1']:''; 
	$post_data['heading_2'] = isset($_POST['heading_2'])? $_POST['heading_2']:'';
	$post_data['heading_3'] = isset($_POST['heading_3'])? $_POST['heading_3']:''; 
	$post_data['heading_4'] = isset($_POST['heading_4'])? $_POST['heading_4']:''; 
	$post_data['heading_5'] = isset($_POST['heading_5'])? $_POST['heading_5']:''; 
	$post_data['heading_6'] = isset($_POST['heading_6'])? $_POST['heading_6']:'';
    //if (array_key_exists('sub_heading', $_POST)) {
    update_post_meta(
        $post_id,
        'telecomtalk_custom_fields',  $post_data
    );
    //}
}
add_action('save_post', 'telecomtalk_save_postdata');
function telecomtalk_widgets_init(){
	register_sidebar(
		array(
			'name'          => __( 'Blog Sidebar', 'telecomtalk' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'telecomtalk' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'telecomtalk_widgets_init' );

add_action('wp_ajax_commentsloadmore', 'tct_comments_loadmore_handler');
add_action('wp_ajax_nopriv_commentsloadmore', 'tct_comments_loadmore_handler'); 
 
function tct_comments_loadmore_handler(){
	global $post;
	$post_data = get_post( $_POST['post_id'] );
	setup_postdata( $post_data );
	
	$comments = get_comments(array(
            'post_id' => $_POST['post_id'],
            'status' => 'approve' //Change this to the type of comments to be displayed
        ));
 
    //Display the list of comments
    wp_list_comments(array(
        'walker' => new Telecomtalk_Walker_Comment(),
        'style' => 'div',
        'short_ping' => true,
        'avatar_size' => 120,
        'page' => $_POST['cpage'], // current comment page
		'per_page' => get_option('comments_per_page'),
        'reverse_top_level' => true //Show the oldest comments at the top of the list
    ), $comments);
	die;
}
if ( ! function_exists( 'telecom_talk_setup' ) ) :

	add_action('wp_enqueue_scripts', 'telecom_frontend_script');

	function telecom_frontend_script(){
		wp_enqueue_style('font-awesome.min', get_template_directory_uri() .'/css/all.css');
		wp_enqueue_style( 'telecom-style', get_stylesheet_uri() );
		wp_register_script( 'load_more_comments', get_template_directory_uri() . '/js/load-more-comments.js' );
		
		$local_array = array(
		    'ajax_url' => admin_url('admin-ajax.php'),
		    'post_id' => get_the_ID(),
		);

		wp_localize_script( 'load_more_comments', 'tctobj', $local_array );
		wp_enqueue_script( 'load_more_comments' );
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

	function telecom_talk_setup() {
		load_theme_textdomain( 'telecom-talk', get_template_directory() . '/languages' );
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		// This theme uses wp_nav_menu() in one location.

		register_nav_menus( array(
			'header-menu' => esc_html__( 'Header Menu', 'telecom-talk' ),
			'primary_nav' => esc_html__( 'Primary', 'telecom-talk' ),
			'footer-menu' => esc_html__( 'Footer', 'telecom-talk' ),
			'mobile-menu'   	=> esc_html__( 'Mobile Menu', 'telecom-talk' ),

		) );

		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );

		register_nav_menus( array(
			'primary_nav' => esc_html__( 'Primary', 'telecom-talk' ),
			'footer-menu' => esc_html__( 'Footer', 'telecom-talk' ),
			'mobile-menu' => esc_html__( 'Mobile Menu', 'telecom-talk' ),
		) );

	}

endif;

add_action( 'after_setup_theme', 'telecom_talk_setup' );

function telecomtalk_is_comment_by_post_author( $comment = null ) {

	if ( is_object( $comment ) && $comment->user_id > 0 ) {

		$user = get_userdata( $comment->user_id );
		$post = get_post( $comment->comment_post_ID );

		if ( ! empty( $user ) && ! empty( $post ) ) {

			return $comment->user_id === $post->post_author;

		}
	}
	return false;

}
function telecomtalk_theme_comment($comment, $args, $depth){
	 $GLOBALS['comment'] = $comment; 
	 //print_r($comment);
	 //die;
	 $city = get_comment_meta( $comment->comment_ID, 'city', true );
	 ?>
    <div class="cmts">
		<div class="cmts-athr-img">
			<?php echo get_avatar( $comment, 32 ); ?>
		</div>
		<div class="cmts-cntn">
			<h4>
				<?php  echo get_comment_author_link( $comment->comment_ID );?>
				<span class="city-name"><?php echo $city;?></span>
			</h4>
			<?php if ($comment->comment_approved == '0') : ?>
                <em><php _e('Your comment is awaiting moderation.') ?></em><br />
            <?php endif; ?>
			<p>
				<?php echo $comment->comment_content;?>
			</p>
			<div class="rght-prt">
				<a class="lk-dlk"href="#">Like</a>
				<!-- <a class="rply"href="#">Reply</a> -->
				<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
			</div>
		</div>
	</div>
<?php
}
require get_template_directory() . '/includes/class-telecomtalk-walker-comment.php';
// Google Fonts
add_filter('tct_like_dislike_html',"tct_add_like_dilike_text_after",10,1);
function tct_add_like_dilike_text_after($like_dislike_html){
	$like_dislike_html = preg_replace('/<a\shref="(.*?)"(.*?)>\s+<i(.*?)><\/i>\s+<\/a>/s', '<a href="$1"$2><i$3></i> Like</a>', $like_dislike_html);
	return $like_dislike_html;
}

function telecomtalk_google_fonts() {
	wp_enqueue_style('googleFonts',
		//'https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700,800,900');
		'https://fonts.googleapis.com/css2?family=Open+Sans+Condensed:ital,wght@0,300;0,700;1,300&display=swap');
	}
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
		wp_enqueue_script( 'tct-comments-script', get_theme_file_uri( '/assets/js/commnet-quote.js' ), array( 'jquery' ), '', true );
	}
add_action('wp_enqueue_scripts', 'telecomtalk_google_fonts');


/* Excerpt */
function telecom_talk_custom_excerpt_length( $length ) {
    return 40;
}
add_filter( 'excerpt_length', 'telecom_talk_custom_excerpt_length', 999 );

include( get_template_directory() . '/includes/aq_resizer.php' );

function telecomtalk_register_custom_options_page(){
    add_menu_page( 
        __( 'Custom Theme Settings', 'textdomain' ),
        'Custom Theme Options',
        'manage_options',
        'custom_theme_options',
        'telecomtalk_theme_options_page',
        '',
        6
    );

    add_action( 'admin_init', 'telecomtalk_custom_theme_settings' );
}

function telecomtalk_custom_theme_settings() {
	//register our settings
	register_setting( 'telecomtalk-settings-group', 'hbp_option' );
	register_setting( 'telecomtalk-settings-group', 'editors_pick_option' );
	register_setting( 'telecomtalk-settings-group', 'pan_india_option' );
	register_setting( 'telecomtalk-settings-group', 'frequency_band_option' );
	register_setting( 'telecomtalk-settings-group', 'dth_satellite_band_option' );
}

add_action( 'admin_menu', 'telecomtalk_register_custom_options_page' );

function telecomtalk_theme_options_page(){
    ?>
    <div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form action="options.php" method="post">
			<?php settings_fields( 'telecomtalk-settings-group' ); ?>
			<?php do_settings_sections( 'telecomtalk-settings-group' ); ?>
			<table class="form-table">
			    <tr valign="top">
			    <th scope="row">Head Blog Posts</th>
			    <td><input type="text" name="hbp_option" value="<?php echo esc_attr( get_option('hbp_option') ); ?>" size="50"/>
			    	<p class="description">Add post id's separated by comma(',')</p>
			    </td>
			    </tr>
			    <tr valign="top">
			    <th scope="row">Editors Pick</th>
			    <td><input type="text" name="editors_pick_option" value="<?php echo esc_attr( get_option('editors_pick_option') ); ?>" size="50"/>
			    	<p class="description">Enter the postID for editor pick section</p>
			    </td>
			    </tr>
			    <tr valign="top">
			    <th scope="row">Pan India Spectrum Details</th>
			    <td><input type="text" name="pan_india_option" value="<?php echo esc_attr( get_option('pan_india_option') ); ?>" size="50"/>
			    	<p class="description">Enter the pageID for editor spectrum details</p>
			    </td>
			    </tr>
			    <tr valign="top">
			    <th scope="row">Telecommunication Frequency Bands</th>
			    <td><input type="text" name="frequency_band_option" value="<?php echo esc_attr( get_option('frequency_band_option') ); ?>" size="50"/>
			    	<p class="description">Enter the pageID</p>
			    </td>
			    </tr>
			    <tr valign="top">
			    <th scope="row">DTH Satellites in India</th>
			    <td><input type="text" name="dth_satellite_band_option" value="<?php echo esc_attr( get_option('dth_satellite_band_option') ); ?>" size="50"/>
			    	<p class="description">Enter the postID</p>
			    </td>
			    </tr>
			</table>
			<?php submit_button(); ?>
		</form>
    </div>
    <?php  
}