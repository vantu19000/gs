<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );


//set the table structure version
$prowp_db_version = '1.0.0';//HBFactory::instance()->version;
//save the table structure version number
add_option( 'hb_db_version', $prowp_db_version );


$installed_ver = get_option( 'hb_db_version' );
if( $installed_ver != $prowp_db_version ) {
	$sql = file_get_contents(HB_PATH.'install/sql/install.sql');
	$sql = str_replace('#__', $wpdb->prefix, $sql);
	
	//execute the query creating our table
	$check = dbDelta( $sql );	
	update_option( 'hb_db_version', $prowp_db_version );
}



