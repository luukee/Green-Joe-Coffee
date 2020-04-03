<?php
/**
 * Header template.
 *
 * @package Avada
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<!DOCTYPE html>
<html class="<?php echo ( Avada()->settings->get( 'smooth_scrolling' ) ) ? 'no-overflow-y' : ''; ?>" <?php language_attributes(); ?>>

<head>
<!-- Font-Awesome Start-->
   <!-- <link rel="stylesheet" href="css/font-awesome.css"> -->
<!-- Font-Awesome End-->
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<?php Avada()->head->the_viewport(); ?>

	<?php wp_head(); ?>

	<?php $object_id = get_queried_object_id(); ?>
	<?php $c_page_id = Avada()->fusion_library->get_page_id(); ?>

	<script type="text/javascript">
		var doc = document.documentElement;
		doc.setAttribute('data-useragent', navigator.userAgent);
	</script>

	<?php
	/**
	 *
	 * The settings below are not sanitized.
	 * In order to be able to take advantage of this,
	 * a user would have to gain access to the database
	 * in which case this is the least on your worries.
	 */
	echo Avada()->settings->get( 'google_analytics' ); // WPCS: XSS ok.
	echo Avada()->settings->get( 'space_head' ); // WPCS: XSS ok.
	?>
	
</head>
<?php 
$coupon_code = get_field('coupon_code','option');
if(!is_user_logged_in() && is_shop())
{
$sucess_msg = 0;
if (isset($_POST["join"])) {

	
	
$sb_email =	$_POST["sb_email"];
$sb_fname =	$_POST["sb_fname"];
$sb_lname =	$_POST["sb_lname"];
$sb_month =	$_POST["sb_month"];
$sb_day =	$_POST["sb_day"];
$sb_year =	$_POST["sb_year"];

$post_title = $sb_fname.'-'.$sb_lname;
$postStatus = "publish";
$postType = "subscriber_list";
$my_post = array(
				 'post_title' => $post_title,					
				 'post_status' => $postStatus,
				 'post_type' => $postType,
				 );

	$post_id = wp_insert_post($my_post);
	add_post_meta($post_id, 'subscribe_email', $sb_email, true);
	add_post_meta($post_id, 'first_name', $sb_fname, true);
	add_post_meta($post_id, 'last_name', $sb_lname, true);
	add_post_meta($post_id, 'day', $sb_day, true);
	add_post_meta($post_id, 'month', $sb_month, true);
	add_post_meta($post_id, 'year', $sb_year, true);
	
	$sucess_msg = 1;

	
/* admin mail */
$mail_headers ='';
$message ='';
$mail_headers .= 'Content-Type: text/html; charset=UTF-8';
$mail_headers .= 'From: greenjoecoffee<info@greenjoecoffee.com> ' . "\r\n";

$to = get_option('admin_email');
$subject = 'New Subscriber Information';
$message .= '<table border="1">';
$message .= '<th colspan="2">Subscriber Details </th>';
$message .= '<tr><th>Email </td><td>'.$sb_email.'</td></tr>';
$message .= '<tr><th>First name</td><td>'.$sb_fname.'</td></tr>';
$message .= '<tr><th>Last name</th><td>'.$sb_lname.'</td></tr>';
$message .= '<tr><th>DOB</th><td>'.$sb_month.'-'.$sb_day.'-'.$sb_year.'</td></tr>';

$message .= '</table>';
wp_mail( $to, $subject, $message, $mail_headers);

/* user mail */
$mail_headers2 ='';
$message2 ='';
$mail_headers2 .= 'Content-Type: text/html; charset=UTF-8';
$mail_headers2 .= 'From: greenjoecoffee<info@greenjoecoffee.com> ' . "\r\n";
$to2 = $sb_email;
$subject2 = 'Thank you For Subcribe';

$message2 .= '<h3>Your offer code is : '.$coupon_code.'</h3>';


wp_mail( $to2, $subject2, $message2, $mail_headers2);


	
}
if($sucess_msg==1)
{
?>
<div id="mycuppon" class="modal fade mycuppon" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>        
      </div>
      <div class="modal-body">

     <div class="modal_contant">
	 <div class="top_contant">
	 <h1><?php echo esc_html__('THANKS,','Avada'); ?></h1>
     <h4><?php echo esc_html__("you're officially on our list!","Avada"); ?></h4>	 
	 </div> 
	 
	 <div class="bottom_contant">
	 
	 <h1> <?php echo esc_html__('YOUR OFFER CODE IS','Avada'); ?> <b><?php echo $coupon_code; ?></b></h1>
      <span><?php echo esc_html__('Cheers!','Avada'); ?></span>	
      
	<p><?php echo esc_html__('Exclusions Apply: Applicable to first purchase only.','Avada'); ?> <br><?php echo esc_html__("Excludes S'ip by S'well products, gift sets, Cocktail Kit and sale items.","Avada"); ?></p>
	   
	 </div>
	 </div>
	
		
      </div>
     
    </div>

  </div>
</div>
<script>
jQuery(window).load(function(){        
   jQuery('#mycuppon').modal('show');
    }); 
</script>
<?php	
}
else
{
?>	
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>        
      </div>
      <div class="modal-body">
	  <h4 class="modal-title"><?php echo esc_html__('Sign Up + Get 10% Off','Avada'); ?></h4>
        <p><?php echo esc_html__('Your First Purchase','Avada'); ?></p>
		<form  class="rs-subscribe-form" id="rs-subscribe-form" method="POST">
			<div class="req-fields">
			<input type="email" name="sb_email" placeholder="<?php echo esc_html__('ENTER EMAIL ADDRESS','Avada'); ?>" required/>
			</div>
			<div class="name_fild">
			<input type="text" name="sb_fname" placeholder="<?php echo esc_html__('FIRST NAME','Avada'); ?>" required>
			<input type="text" name="sb_lname" placeholder="<?php echo esc_html__('LAST NAME','Avada'); ?>" required>
			</div>
			<span class="popup-title-2"><?php echo esc_html__('Share your birthday with us!','Avada'); ?></span>
			 <div class="sl-box-dob">
			 
			  
			 
			<select name="sb_month">
				<option value="Month">Month</option>
				<option value="Jan">Jan</option>
				<option value="Fab">Fab</option>
				<option value="Mar">Mar</option>
				<option value="Apr">Apr</option>
				<option value="May">May</option>
				<option value="Jun">Jun</option>
				<option value="Jul">Jul</option>
				<option value="Aug">Aug</option>
				<option value="Sep">Sep</option>
				<option value="Oct">Oct</option>
				<option value="Nov">Nov</option>
				<option value="Dec">Dec</option>
			</select>
			<select name="sb_day">
				<option value="Day">Day</option>
				<?php
				 for($i=1;$i<32;$i++)
				 {
				 ?>
				<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php	
				 }
				?>
			</select>
				<select name="sb_year">
				<option value="Year">Year</option>
				<?php
				 for($y=2004;$y>1919;$y--)
				 {
				 ?>
				<option value="<?php echo $y; ?>"><?php echo $y; ?></option>
				<?php	
				 }
				?>
			</select>
			</div>
			<br>
			<input class="join" type="submit" name="join" value="<?php echo esc_html__('Join','Avada'); ?>"/>
		</form>
      </div>     
    </div>

  </div>
</div>
<script>
jQuery(window).load(function(){        
   jQuery('#myModal').modal('show');
    }); 
</script>
<?php
}
}

?>
<?php
$wrapper_class = ( is_page_template( 'blank.php' ) ) ? 'wrapper_blank' : '';

if ( 'modern' === Avada()->settings->get( 'mobile_menu_design' ) ) {
	$mobile_logo_pos = strtolower( Avada()->settings->get( 'logo_alignment' ) );
	if ( 'center' === strtolower( Avada()->settings->get( 'logo_alignment' ) ) ) {
		$mobile_logo_pos = 'left';
	}
}

?>
<body <?php body_class(); ?>>
	<?php
	do_action( 'avada_before_body_content' );

	$boxed_side_header_right = false;
	$page_bg_layout = ( $c_page_id ) ? get_post_meta( $c_page_id, 'pyre_page_bg_layout', true ) : 'default';
	?>
	<?php if ( ( ( 'Boxed' === Avada()->settings->get( 'layout' ) && ( 'default' === $page_bg_layout || '' == $page_bg_layout ) ) || 'boxed' === $page_bg_layout ) && 'Top' != Avada()->settings->get( 'header_position' ) ) : ?>
		<div id="boxed-wrapper">
	<?php endif; ?>
	<?php if ( ( ( 'Boxed' === Avada()->settings->get( 'layout' ) && 'default' === $page_bg_layout ) || 'boxed' === $page_bg_layout ) && 'framed' === Avada()->settings->get( 'scroll_offset' ) ) : ?>
		<div class="fusion-sides-frame"></div>
	<?php endif; ?>
	<div id="wrapper" class="<?php echo esc_attr( $wrapper_class ); ?>">
		<div id="home" style="position:relative;top:-1px;"></div>
		<?php avada_header_template( 'Below', is_archive() || Avada_Helper::bbp_is_topic_tag() ); ?>
		<?php if ( 'Left' === Avada()->settings->get( 'header_position' ) || 'Right' === Avada()->settings->get( 'header_position' ) ) : ?>
			<?php avada_side_header(); ?>
		<?php endif; ?>

		<div id="sliders-container">
			<?php
			$slider_page_id = '';
			if ( ! is_search() ) {
				$slider_page_id = '';
				if ( ( ! is_home() && ! is_front_page() && ! is_archive() && isset( $object_id ) ) || ( ! is_home() && is_front_page() && isset( $object_id ) ) ) {
					$slider_page_id = $object_id;
				}
				if ( is_home() && ! is_front_page() ) {
					$slider_page_id = get_option( 'page_for_posts' );
				}
				if ( class_exists( 'WooCommerce' ) && is_shop() ) {
					$slider_page_id = get_option( 'woocommerce_shop_page_id' );
				}
				if ( ! is_home() && ! is_front_page() && ( is_archive() || Avada_Helper::bbp_is_topic_tag() ) && isset( $object_id ) && ( ! ( class_exists( 'WooCommerce' ) && is_shop() ) ) ) {
					$slider_page_id = $object_id;
					avada_slider( $slider_page_id, true );
				}
				if ( ( 'publish' === get_post_status( $slider_page_id ) && ! post_password_required() && ! is_archive() && ! Avada_Helper::bbp_is_topic_tag() ) || ( 'publish' === get_post_status( $slider_page_id ) && ! post_password_required() && ( class_exists( 'WooCommerce' ) && is_shop() ) ) || ( current_user_can( 'read_private_pages' ) && in_array( get_post_status( $slider_page_id ), array( 'private', 'draft', 'pending', 'future' ) ) ) ) {
					avada_slider( $slider_page_id, ( is_archive() || Avada_Helper::bbp_is_topic_tag() ) && ! ( class_exists( 'WooCommerce' ) && is_shop() ) );
				}
			}
			?>
		</div>
		<?php
		$slider_fallback = get_post_meta( $slider_page_id, 'pyre_fallback', true );
		?>
		
		<?php if ( $slider_fallback ) : ?>
			<div id="fallback-slide">
				<img src="<?php echo esc_url_raw( $slider_fallback ); ?>" alt="" />
			</div>
		<?php endif; ?>
		
		<?php avada_header_template( 'Above', is_archive() || Avada_Helper::bbp_is_topic_tag() ); ?>
	
		<?php if ( has_action( 'avada_override_current_page_title_bar' ) ) : ?>
			<?php do_action( 'avada_override_current_page_title_bar', $c_page_id ); ?>
		<?php else : ?>
			<?php avada_current_page_title_bar( $c_page_id ); ?>
		<?php endif; ?>
		
		<?php if ( is_page_template( 'contact.php' ) && Avada()->settings->get( 'recaptcha_public' ) && Avada()->settings->get( 'recaptcha_private' ) ) : ?>
			<script type="text/javascript">var RecaptchaOptions = { theme : '<?php echo esc_attr( Avada()->settings->get( 'recaptcha_color_scheme' ) ); ?>' };</script>
		<?php endif; ?>
		<?php if ( is_page_template( 'contact.php' ) && Avada()->settings->get( 'gmap_address' ) && Avada()->settings->get( 'status_gmap' ) ) : ?>
			
			<?php
			$map_popup             = ( ! Avada()->settings->get( 'map_popup' ) ) ? 'yes' : 'no';
			$map_scrollwheel       = ( Avada()->settings->get( 'map_scrollwheel' ) ) ? 'yes' : 'no';
			$map_scale             = ( Avada()->settings->get( 'map_scale' ) ) ? 'yes' : 'no';
			$map_zoomcontrol       = ( Avada()->settings->get( 'map_zoomcontrol' ) ) ? 'yes' : 'no';
			$address_pin           = ( Avada()->settings->get( 'map_pin' ) ) ? 'yes' : 'no';
			$address_pin_animation = ( Avada()->settings->get( 'gmap_pin_animation' ) ) ? 'yes' : 'no';
			?>
			<div id="fusion-gmap-container">
				<?php
				echo Avada()->google_map->render_map( // WPCS: XSS ok.
					array(
						'address'                  => esc_html( Avada()->settings->get( 'gmap_address' ) ),
						'type'                     => esc_attr( Avada()->settings->get( 'gmap_type' ) ),
						'address_pin'              => esc_attr( $address_pin ),
						'animation'                => esc_attr( $address_pin_animation ),
						'map_style'                => esc_attr( Avada()->settings->get( 'map_styling' ) ),
						'overlay_color'            => esc_attr( Avada()->settings->get( 'map_overlay_color' ) ),
						'infobox'                  => esc_attr( Avada()->settings->get( 'map_infobox_styling' ) ),
						'infobox_background_color' => esc_attr( Avada()->settings->get( 'map_infobox_bg_color' ) ),
						'infobox_text_color'       => esc_attr( Avada()->settings->get( 'map_infobox_text_color' ) ),
						'infobox_content'          => htmlentities( Avada()->settings->get( 'map_infobox_content' ) ),
						'icon'                     => esc_attr( Avada()->settings->get( 'map_custom_marker_icon' ) ),
						'width'                    => esc_attr( Avada()->settings->get( 'gmap_dimensions', 'width' ) ),
						'height'                   => esc_attr( Avada()->settings->get( 'gmap_dimensions', 'height' ) ),
						'zoom'                     => esc_attr( Avada()->settings->get( 'map_zoom_level' ) ),
						'scrollwheel'              => esc_attr( $map_scrollwheel ),
						'scale'                    => esc_attr( $map_scale ),
						'zoom_pancontrol'          => esc_attr( $map_zoomcontrol ),
						'popup'                    => esc_attr( $map_popup ),
					)
				);
				?>
			</div>
		<?php endif; ?>
		<?php
		$main_css   = '';
		$row_css    = '';
		$main_class = '';

		if ( apply_filters( 'fusion_is_hundred_percent_template', $c_page_id, false ) ) {
			$main_css = 'padding-left:0px;padding-right:0px;';
			$hundredp_padding = get_post_meta( $c_page_id, 'pyre_hundredp_padding', true );
			if ( Avada()->settings->get( 'hundredp_padding' ) && ! $hundredp_padding ) {
				$main_css = 'padding-left:' . Avada()->settings->get( 'hundredp_padding' ) . ';padding-right:' . Avada()->settings->get( 'hundredp_padding' );
			}
			if ( $hundredp_padding ) {
				$main_css = 'padding-left:' . $hundredp_padding . ';padding-right:' . $hundredp_padding;
			}
			$row_css    = 'max-width:100%;';
			$main_class = 'width-100';
		}
		do_action( 'avada_before_main_container' );
		?>
		<main id="main" role="main" class="clearfix <?php echo esc_attr( $main_class ); ?>" style="<?php echo esc_attr( $main_css ); ?>">
			<div class="fusion-row" style="<?php echo esc_attr( $row_css ); ?>">
