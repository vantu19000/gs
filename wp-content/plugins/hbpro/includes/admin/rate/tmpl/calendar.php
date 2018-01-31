<?php

/**
 * @package 	Bookpro
 * @author 		Vuong Anh Duong
 * @link 		http://http://woafun.com/
 * @copyright 	Copyright (C) 2011 - 2012 Vuong Anh Duong
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: default.php 26 2012-07-08 16:07:54Z quannv $
 **/
defined('ABSPATH') or die('Restricted access');
HBImporter::css('calendar');
HBImporter::js('pncalendar');
HBImporter::classes('calendar/calendar');
?>
<script type="text/javascript">

var ajaxurl = "<?php echo wp_nonce_url(admin_url('admin-post.php?action=HB_execute_action&hb_admin_action=rate&task=new_calendar&route_id='.$this->route_id),'hb_action','hb_meta_nonce')?>";
var pn_appointments_calendar = null;
jQuery(function() {
    pn_appointments_calendar = new PN_CALENDAR();
    pn_appointments_calendar.init();
});

</script>

	<?php 
	       $calendar = new PN_Calendar();
	       echo $calendar->draw();
	        
	 ?>
	
<script type="text/javascript">
jQuery(document).ready(function($){
	jQuery("#SubmintFormPackagerates").live('click',function(){
		var checked = false;
		jQuery(".checkboxCell").each(function(){
				if(jQuery(this).is(':checked'))
				{
					checked=true;
				}
			});
			if(checked){
				submitform('delete');
			}else{
				alert('Please first make a selection from the list');
			}
	});

});		
</script>

