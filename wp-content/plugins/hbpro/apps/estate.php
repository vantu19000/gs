<?php 
defined ( 'ABSPATH' ) or die ();

add_action( 'admin_menu', 'hbpro_add_estate_menu');
function hbpro_add_estate_menu() {
	add_menu_page( __("Estate",'hbpro'), __("Estate",'hbpro'), 'delete_posts', 'hb_estate',  function(){HBImporter::includes('admin/estate/view');}, site_url().'/wp-content/plugins/hbpro/assets/images/logo.png', 5 );
	add_submenu_page( 'hb_estate', __("Estate host",'hbpro'), __("Estate host",'hbpro'), 'delete_posts', 'hb_estate_host', function(){HBImporter::includes('admin/estatehost/view');} );
}
