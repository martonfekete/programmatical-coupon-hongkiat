/*
 * CREATE COUPON PROGRAMATICALLY 
 * create only when customer sees the woocommerce thankyou page
 * create only if there is no coupon with the same code
 */
 
add_action( 'woocommerce_thankyou', 'my_custom_coupon_creation');

function my_custom_coupon_creation(){
	$args = array(
		'posts_per_page'   => -1,
		'orderby'          => 'title',
		'order'            => 'asc',
		'post_type'        => 'shop_coupon',
		'post_status'      => 'publish',
	);
	
	$coupons = get_posts( $args );
	
	$coupon_names = array();
	foreach ( $coupons as $coupon ) {
		$coupon_name = $coupon->post_title;
		array_push( $coupon_names, $coupon_name );
	}	
	
	$coupon_code = 'YOUR_COUPON';	
	
	if ( !in_array( $coupon_code , $coupon_names  ) ){
	
		$coupon = array(
			'post_title' => $coupon_code,
			'post_excerpt' => 'Order ID: ' . $order_id,
			'post_status' => 'publish',
			'post_author' => 1,
			'post_type'		=> 'shop_coupon'
		);
		
		$new_coupon_id = wp_insert_post( $coupon ); // create the coupon and also fetch it's ID
		
		// Set some coupon options here
	 
		update_post_meta( $new_coupon_id, 'coupon_amount', '10' );        // coupon will be for 10%
		update_post_meta( $new_coupon_id, 'discount_type', 'percent' );   // coupon will be for 10%
	
	}
	
}
