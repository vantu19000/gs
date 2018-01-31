<?php 
wp_enqueue_script('jquery-ui-datepicker');
wp_enqueue_script('jquery-validate','http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js');
wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
HBImporter::js('jquery.magnific-popup.min','hb');
HBImporter::css('magnific-popup');
HBImporter::helper('date');
$config = HBFactory::getConfig();
$day_after = 60;

$default_price = false;
if($this->logs){
	$default_price = json_decode($this->logs[0]->content);
	//	debug($default_price);
}


?>
<script>
function fillDefault(){
	var price = <?php echo json_encode($default_price);?>;
	if(price){
		jQuery('input[name="weekday[]"]').val(price.week);
		jQuery.each(price.price, function(key, item) {
			key = key.toLowerCase();
			jQuery.each(item, function(name,val){
				jQuery('input[name="frate['+key+']['+name+']"]').val(val);
			});
		});
		if(price.params){
			jQuery.each(price.params, function(key, val) {
				jQuery('input[name="frateparams['+key+']"]').val(val);
			});
		}
		
	}
}
</script>

<script type="text/javascript">
	jQuery(document).ready(function($){
		jQuery("#adminForm").validate({
			
		    lang: '<?php echo 'EN' ?>',
			rules: {
			}
		});
		
	
		jQuery.validator.addMethod("time", function(time, element) {		
		    return this.optional(element) || (time.match(/([0-1][0-9]|2[0-3])[:]([0-5][0-9])/) && time.length == 5);
		}, "<?php echo __('Time format must is HH:ii')?>");
	});
	
	function changeroute(route_id){
		window.location.href= '<?php echo admin_url('admin.php?page=HB_rate&route_id=')?>'+route_id;
	}
</script>

<script type="text/javascript">
function submitform(task){
	if(task=="apply" || task=="save"){
		
	}else{
		jQuery("#adminForm")[0].submit();
	}
	HB_submit(task);
}
</script>

<script type="text/javascript">

jQuery( document ).ready(function($) {
	$(document).on('click', '.mgpopup', function (e) {

	    e.preventDefault();

	    $.magnificPopup.open({
	        items: {
	            src: $(this).attr('href')
	        },
	        type: 'ajax',
	        closeOnBgClick: false,
	        callbacks: {
	            close: function(){
	        		location.reload();
	            }
	              
	          }
	    });

	});

	
});

</script>

<div class="wrap">
	<h2><?php echo __( 'Route', 'hb'  ).' '.$this->route->post_title?>
	<a href="<?php echo admin_url('post.php?action=edit&post='.$this->route_id)?>" class="page-title-action"><?php echo __('Edit route')?></a>
	</h2>
	
	
	
	<form action="<?php echo admin_url('admin-post.php?action=HB_execute_action')?>" method="post" name="adminForm" id="adminForm"	class="form-validate adminForm">
		<!--  -->
		<div id="poststuff">
			<div class="metabox-holder columns-2" id="post-body">
				
				<div id="postbox-container-1" class="meta-box-sortables ui-sortable">
					<div class="postbox ">
						<h2>
						<span><?php echo __('Start date','hb'); ?></span>
						</h2>
						<hr>
						<div class="inside"><?php echo HBHtml::calendar(HBFactory::getDate()->format(HBDateHelper::getConvertDateFormat('P')), 'data[startdate]', 'startdate',HBDateHelper::getConvertDateFormat('J'),'readonly="readonly"') ?></div>
						
						<h2>
							<span><?php echo __('End date','hb'); ?></span>
						</h2>
						<hr>
						<div class="inside"><?php echo HBHtml::calendar(HBFactory::getDate()->add(new DateInterval('P'.$day_after.'D'))->format(HBDateHelper::getConvertDateFormat('P')), 'data[enddate]', 'enddate',HBDateHelper::getConvertDateFormat('J'),'readonly="readonly"') ?></div>
						
						<h2>
							<span><?php echo __('Week day','hb'); ?></span>
						</h2>
						<hr>
						<div class="inside"><?php echo $this->getDayWeek('weekday[]') ?></div>
						<div class="inside">
							<div class="pull-right">
								<button type="button" id="publish" class="button button-primary button-large" onclick="submitform('save');">Add Rate</button>
							</div>
						</div>
						
						
					</div>
					<div class="postbox ">
						<h2 class="">
							<span><?php echo __('Price','hb'); ?>
								<?php if($default_price){?><button type="button" class="button alignright " onclick="fillDefault();"><?php echo __('Fill in default price')?></button><?php }?>
							</span>
							
						</h2>
						<hr>
						<?php echo $this->loadTemplate('base'); ?>
						
						<?php if ($config->economy){?>							
						<?php echo $this->loadTemplate('eco'); ?>
						<?php }?>
						
						<?php if ($config->business){?>							
						<?php echo $this->loadTemplate('bus'); ?>
						<?php }?>
					</div>
					
					
					<div class="postbox ">
						<h2 class="hndle ui-sortable-handle">
							<span><?php echo __('Meta data','hb'); ?></span>
						</h2>
						<div class="inside"><?php echo HBHtml::booleanlist('frateparams[state]','class="radio btn"',1,__('Open'),__('Close'))?></div></div>					
					</div>
				
				<div id="post-body-content" style="position: relative;">
					<?php echo HBHtml::select($this->routes, 'route_id', 'onchange="changeroute(this.value)" class="inputbox select-2" ', 'ID', 'post_title', $this->route_id,'route_id') ;?>
					<?php echo $this->loadtemplate('calendar')?>
					<hr/>
					<?php echo $this->loadTemplate('logs')?>
				</div>
			</div>
		</div>
		<!--  -->
	
		<?php wp_nonce_field( 'hb_action', 'hb_meta_nonce' );?>
		<input type="hidden" name="hb_admin_action" value="rate" />
		<input type="hidden" id="task" name="task" value="save" />
	
	</form>
</div>