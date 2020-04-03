<?php

function theme_enqueue_styles() {
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style-min.css', array( 'avada-stylesheet' ) );
	wp_enqueue_style('child-custom-style', get_stylesheet_directory_uri() . '/custom-min.css', array('avada-stylesheet'));

}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );



function avada_lang_setup() {
	$lang = get_stylesheet_directory() . '/languages';
	load_child_theme_textdomain( 'Avada', $lang );
}
add_action( 'after_setup_theme', 'avada_lang_setup' );


function menu_after_before_slider( $atts )
{	ob_start();
    wp_nav_menu(array(      
	'menu' => 'secondary menu' ,
	'container' => false, 			
	'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',	
	) );
	return ob_get_clean();
}

	add_shortcode( 'menu_af_slider', 'menu_after_before_slider' );


	function remove_woo_commerce_hooks() {
	global $avada_woocommerce;
	remove_action( 'woocommerce_single_product_summary', array( $avada_woocommerce, 'add_product_border' ), 19 );
}
add_action( 'after_setup_theme', 'remove_woo_commerce_hooks' );

function cloudways_short_des_product() {
    the_content();
}
add_action( 'woocommerce_single_product_summary', 'cloudways_short_des_product', 20 );

function accordiontoggle() {
    ?>
	<button class="accordion">SHIPPING INFO</button>
	<div class="panel">
	<p><?php the_field('content'); ?></p>
	</div>
	
	<button class="accordion">RETURN & EXCHANGES</button>
	<div class="panel">
	<p><?php the_field('content 2'); ?></p>
	</div>
	<?php
}
add_action( 'woocommerce_single_product_summary', 'accordiontoggle', 30 );

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

add_action( 'user_register', 'myplugin_registration_save', 10, 1 );

function myplugin_registration_save( $user_id ) {

?>	
<script>
	
		jQuery('body').addClass('cuppan');
	

</script>
<?php

}

/* add theme option by acf */
add_action('acf/init', 'my_acf_init');

function my_acf_init() {

	if( function_exists('acf_add_options_page') ) {
		$option_page = acf_add_options_page(array(
			'page_title' => __('Subscribe Coupon code', 'pts'),
			'menu_title' => __('Subscribe Coupon code', 'pts'),
			'menu_slug' => 'subscribe-coupon-code',
		));
	}

}