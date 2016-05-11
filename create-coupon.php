<?php 
/*
 * CREATE COUPON PROGRAMATICALLY 
 * create only when customer sees the woocommerce thankyou page
 * create only if there is no coupon with the same code
 */
 
add_action( 'woocommerce_thankyou', 'my_custom_coupon_creation');

function my_custom_coupon_creation(){
	
	// fetch all current coupons
	
	$args = array(
		'posts_per_page'   => -1,
		'orderby'          => 'title',
		'order'            => 'asc',
		'post_type'        => 'shop_coupon',
		'post_status'      => 'publish',
	);
	
	$coupons = get_posts( $args );
	
	// create a new array of only the coupon codes
	
	$coupon_names = array();
	
	foreach ( $coupons as $coupon ) {
		$coupon_name = $coupon->post_title;
		array_push( $coupon_names, $coupon_name );
		}	
	
	$coupon_code = 'YOUR_COUPON';	// your coupon code
	
	// check if there's already a coupon with that code
	if ( !in_array( $coupon_code , $coupon_names  ) ){
		
		// set up the basics for the coupon-to-be
		
		$coupon = array(
			'post_title' => $coupon_code,
			'post_excerpt' => 'Short desc for your auto-coupon',
			'post_status' => 'publish',
			'post_author' => 1,
			'post_type'		=> 'shop_coupon'
		);
		
		$new_coupon_id = wp_insert_post( $coupon ); // create the coupon and fetch it's ID
		
		// Set some coupon options here
	 
		update_post_meta( $new_coupon_id, 'coupon_amount', '10' );        // coupon will be for 10%
		update_post_meta( $new_coupon_id, 'discount_type', 'percent' );   // coupon will be for 10%
	
	}
	
}
?>
