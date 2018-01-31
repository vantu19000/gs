<?php

/**
 * Add Vietnam provinces and cities.
 */
add_filter( 'woocommerce_states', 'vietnam_cities_woocommerce' );
function vietnam_cities_woocommerce( $states ) {
  $states['VN'] = array(
    'CANTHO' => __('Cần Thơ', 'woocommerce') ,
    'HOCHIMINH' => __('Hồ Chí Minh', 'woocommerce') ,
    'HANOI' => __('Hà Nội', 'woocommerce') ,
    'HAIPHONG' => __('Hải Phòng', 'woocommerce') ,
    'DANANG' => __('Đà Nẵng', 'woocommerce') ,
    'ANGIANG' => __('An Giang', 'woocommerce') ,
    'BARIAVUNGTAU' => __('Bà Rịa - Vũng Tàu', 'woocommerce') ,
    'BACLIEU' => __('Bạc Liêu', 'woocommerce') ,
    'BACKAN' => __('Bắc Kạn', 'woocommerce') ,
    'BACNINH' => __('Bắc Ninh', 'woocommerce') ,
    'BACGIANG' => __('Bắc Giang', 'woocommerce') ,
    'BENTRE' => __('Bến Tre', 'woocommerce') ,
    'BINHDUONG' => __('Bình Dương', 'woocommerce') ,
    'BINHDINH' => __('Bình Định', 'woocommerce') ,
    'BINHPHUOC' => __('Bình Phước', 'woocommerce') ,
    'BINHTHUAN' => __('Bình Thuận', 'woocommerce'),
    'CAMAU' => __('Cà Mau', 'woocommerce'),
    'DAKLAK' => __('Đak Lak', 'woocommerce'),
    'DAKNONG' => __('Đak Nông', 'woocommerce'),
    'DIENBIEN' => __('Điện Biên', 'woocommerce'),
    'DONGNAI' => __('Đồng Nai', 'woocommerce'),
    'GIALAI' => __('Gia Lai', 'woocommerce'),
    'HAGIANG' => __('Hà Giang', 'woocommerce'),
    'HANAM' => __('Hà Nam', 'woocommerce'),
    'HATINH' => __('Hà Tĩnh', 'woocommerce'),
    'HAIDUONG' => __('Hải Dương', 'woocommerce'),
    'HAUGIANG' => __('Hậu Giang', 'woocommerce'),
    'HOABINH' => __('Hòa Bình', 'woocommerce'),
    'HUNGYEN' => __('Hưng Yên', 'woocommerce'),
    'KHANHHOA' => __('Khánh Hòa', 'woocommerce'),
    'KIENGIANG' => __('Kiên Giang', 'woocommerce'),
    'KOMTUM' => __('Kom Tum', 'woocommerce'),
    'LAICHAU' => __('Lai Châu', 'woocommerce'),
    'LAMDONG' => __('Lâm Đồng', 'woocommerce'),
    'LANGSON' => __('Lạng Sơn', 'woocommerce'),
    'LAOCAI' => __('Lào Cai', 'woocommerce'),
    'LONGAN' => __('Long An', 'woocommerce'),
    'NAMDINH' => __('Nam Định', 'woocommerce'),
    'NGHEAN' => __('Nghệ An', 'woocommerce'),
    'NINHBINH' => __('Ninh Bình', 'woocommerce'),
    'NINHTHUAN' => __('Ninh Thuận', 'woocommerce'),
    'PHUTHO' => __('Phú Thọ', 'woocommerce'),
    'PHUYEN' => __('Phú Yên', 'woocommerce'),
    'QUANGBINH' => __('Quảng Bình', 'woocommerce'),
    'QUANGNAM' => __('Quảng Nam', 'woocommerce'),
    'QUANGNGAI' => __('Quảng Ngãi', 'woocommerce'),
    'QUANGNINH' => __('Quảng Ninh', 'woocommerce'),
    'QUANGTRI' => __('Quảng Trị', 'woocommerce'),
    'SOCTRANG' => __('Sóc Trăng', 'woocommerce'),
    'SONLA' => __('Sơn La', 'woocommerce'),
    'TAYNINH' => __('Tây Ninh', 'woocommerce'),
    'THAIBINH' => __('Thái Bình', 'woocommerce'),
    'THAINGUYEN' => __('Thái Nguyên', 'woocommerce'),
    'THANHHOA' => __('Thanh Hóa', 'woocommerce'),
    'THUATHIENHUE' => __('Thừa Thiên - Huế', 'woocommerce'),
    'TIENGIANG' => __('Tiền Giang', 'woocommerce'),
    'TRAVINH' => __('Trà Vinh', 'woocommerce'),
    'TUYENQUANG' => __('Tuyên Quang', 'woocommerce'),
    'VINHLONG' => __('Vĩnh Long', 'woocommerce'),
    'VINHPHUC' => __('Vĩnh Phúc', 'woocommerce'),
    'YENBAI' => __('Yên Bái', 'woocommerce'),
  );
 
 
  return $states;
}

/**
* Add Vietnam currency (VND)
*/
add_filter( 'woocommerce_currencies', 'add_vnd_currency' );
function add_vnd_currency( $currencies ) {
 $currencies['VND'] = __( 'Việt Nam Đồng', 'woocommerce' );
 return $currencies;
}

add_filter('woocommerce_currency_symbol', 'add_vnd_currency_symbol', 10, 2);
function add_vnd_currency_symbol( $currency_symbol, $currency ) {
 switch( $currency ) {
 case 'VND': $currency_symbol = '₫'; break;
 }
 return $currency_symbol;
}


/**
* Convert VND to USD to use PayPal.
*/
add_filter('woocommerce_paypal_args', 'vnd_to_usd'); 
function vnd_to_usd($paypal_args){ 
	if ( $paypal_args['currency_code'] == 'VND'){
		$convert_rate = (get_option('vnd_convert_rate') == '') ? 21083.7 : get_option('vnd_convert_rate');
		$paypal_args['currency_code'] = 'USD'; // K� hi?u c?a lo?i ti?n c?n chuy?n ra.
		$i = 1; 

		while (isset($paypal_args['amount_' . $i])) { 
			$paypal_args['amount_' . $i] = round( $paypal_args['amount_' . $i] / $convert_rate, 2); 
			++$i; 
		}
		
		/* Fix VND for coupon usage. Thanks @Pham Duy Thanh 
		 */
		if(isset($paypal_args['discount_amount_cart']) && $paypal_args['discount_amount_cart'] > 0){

			$paypal_args['discount_amount_cart'] = round( $paypal_args['discount_amount_cart'] / $convert_rate, 2);

		}		

	} 
	return $paypal_args; 
}

/*
 * Fix 

/* Enable VND for PayPal */
add_filter( 'woocommerce_paypal_supported_currencies', 'add_bgn_paypal_valid_currency' );     
    function add_bgn_paypal_valid_currency( $currencies ) {  
    array_push ( $currencies , 'VND' );
    return $currencies;  
} 

add_action('admin_menu', 'wc_vnd_settings');
function wc_vnd_settings() {
    add_submenu_page('hb_dashboard','Woocommerce VND Settings', 'Woocommerce VNĐ', 'manage_options', 'wc_vn_currency_settings','wc_vn_currency_settings', 'wc_display_vn_currency_settings');
}
function wc_display_vn_currency_settings () {

    $vnd_convert_rate = (get_option('vnd_convert_rate') != '') ? get_option('vnd_convert_rate') : '21083.7';

    $html = '</pre>
<div class="wrap"><form action="options.php" method="post" name="options">
<h2>Woocommerce Vietnam Currency Settings</h2>
' . wp_nonce_field('update-options') . '
<table class="form-table" width="100%" cellpadding="10">
<tbody>
<tr>
<td scope="row" align="left">
 <label>Tỉ giá chuyển đổi</label></br><input type="text" name="vnd_convert_rate" value="' . $vnd_convert_rate . '" /></td>
</tr>
</tbody>
</table>
 <input type="hidden" name="action" value="update" />

 <input type="hidden" name="page_options" value="vnd_convert_rate" />

 <input type="submit" name="Submit" value="Update" /></form></div>
<pre>
';

    echo $html;

}

function wpse103469_wc_price_per_unit_mb() {

	$screens = array('product' );

	foreach ( $screens as $screen ) {

		add_meta_box(
				'wc_price_per_unit_mb',
				__( 'Price per Unit', 'myplugin_textdomain' ),
				'wpse103469_wc_price_per_unit_inner_mb',
				$screen,
				'advanced',
				'high'
				);
	}
}
add_action( 'add_meta_boxes', 'wpse103469_wc_price_per_unit_mb' );

/**
 * Prints the box content.
 *
 * @param WP_Post $post The object for the current post/page.
 */
function wpse103469_wc_price_per_unit_inner_mb( $post ) {

	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'wpse103469_wc_price_per_unit_inner_mb', 'wpse103469_wc_price_per_unit_inner_mb_nonce' );

	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
	$value = get_post_meta( $post->ID, 'wc_price_per_unit_key', true );

	echo '<label for="wc_price_per_unit_field">';
	_e( "Price per Unit", 'myplugin_textdomain' );
	echo '</label> ';
	echo '<input type="text" id="wc_price_per_unit_field" name="wc_price_per_unit_field" value="' . esc_attr( $value ) . '" size="25" />';

}

function wpse103469_wc_price_per_unit_save_postdata( $post_id ) {

	/*
	 * We need to verify this came from the our screen and with proper authorization,
	 * because save_post can be triggered at other times.
	 */

	// Check if our nonce is set.
	if ( ! isset( $_POST['wpse103469_wc_price_per_unit_inner_mb_nonce'] ) )
		return $post_id;

		$nonce = $_POST['wpse103469_wc_price_per_unit_inner_mb_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'wpse103469_wc_price_per_unit_inner_mb' ) )
			return $post_id;

			// If this is an autosave, our form has not been submitted, so we don't want to do anything.
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
				return $post_id;

				// Check the user's permissions.
				if ( 'page' == $_POST['post_type'] ) {

					if ( ! current_user_can( 'edit_page', $post_id ) )
						return $post_id;

				} else {

					if ( ! current_user_can( 'edit_post', $post_id ) )
						return $post_id;
				}

				/* OK, its safe for us to save the data now. */

				// Sanitize user input.
				$price_per_unit = sanitize_text_field( $_POST['wc_price_per_unit_field'] );

				// Update the meta field in the database.
				update_post_meta( $post_id, 'wc_price_per_unit_key', $price_per_unit );
}
add_action( 'save_post', 'wpse103469_wc_price_per_unit_save_postdata' );

add_filter('woocommerce_get_price_html','wpse103469_add_price_per_unit_meta_to_price');
function wpse103469_add_price_per_unit_meta_to_price( $price ) {
	$price .= '' . get_post_meta(get_the_ID(), 'wc_price_per_unit_key', true);
	return $price;
}


add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
  
function custom_override_checkout_fields( $fields ) {
    unset($fields['billing']['billing_postcode']);
    unset($fields['billing']['billing_city']);
    unset($fields['billing']['billing_company']);
	//unset($fields['billing']['billing_country']);
$fields['billing']['billing_state']['label'] = 'Tỉnh';
    return $fields;
}

