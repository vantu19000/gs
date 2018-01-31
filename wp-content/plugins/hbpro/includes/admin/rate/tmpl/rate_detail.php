<?php 
/**
 * @package 	Bookpro
 * @author 		Vuong Anh Duong
 * @link 		http://http://woafun.com/
 * @copyright 	Copyright (C) 2011 - 2012 Vuong Anh Duong
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: bookpro.php 80 2012-08-10 09:25:35Z quannv $
 **/
HBImporter::helper('date','route','math');

$this->date = $_REQUEST['date'];
$this->config_rate = array('BASE');
$config = HBFactory::getConfig();
if($config->business){
	$this->config_rate[] = 'BUS';
}
if($config->economy){
	$this->config_rate[] = 'ECO';
}
$this->rates = HBHelperRoute::getRouteRate($this->route_id, $this->date);
// debug($this->rates);
?>

<style>

.white-popup {
  position: relative;
  background: #FFF;
  padding: 20px;
  width: auto;
  max-width: 500px;
  margin: 20px auto;
}

</style>


<script type="text/javascript">
jQuery(document).ready(function($) {
	
	$('#savedaterate').on("click",function(e){
		var checked = true;
		var input 	= null; 
		jQuery('#rate_detail_form .required').each(function(){
			if(!jQuery(this).val()){
					jQuery(this).focus();
					input = jQuery(this).attr('placeholder');
					checked = false; 
					return false; 		
				}
			});
		if(checked){
			var url = "<?php echo wp_nonce_url(admin_url('admin-post.php?action=HB_execute_action&hb_admin_action=rate&task=ajaxSavedayrate'),'hb_action','hb_meta_nonce')?>"; // the script where you handle the form input.
			
		    $.ajax({
		           type: "POST",
		           url: url,
		           data: $("#rate_detail_form").serialize(), // serializes the form's elements.
		           success: function(data)
		           {
		           		alert(data);
		           }
		         });
	         
			}else{
				alert(input+' is required');
			}	

	    e.preventDefault(); // avoid to execute the actual submit of the form.
	});


});
</script>
<div class="white-popup">
<h2><?php echo $this->route->post_title ?>&nbsp-&nbsp<?php echo HBFactory::getDate($this->date)->format(HBDateHelper::getConvertDateFormat('P')) ?></h2>

<form action="index.php" method="post" name="adminForm" id='rate_detail_form'	class="form-validate">
<?php foreach ($this->config_rate as $i=>$key){
	$rate = HBHelperMath::filterArrayObject($this->rates, 'pricetype', $key);
	if(!$rate){
		$rate = (object)array('state'=>1,'seat'=>'','adult'=>'','child'=>'','infant'=>'','adult_roundtrip'=>'','child_roundtrip'=>'','infant_roundtrip'=>'');
	}
	$state = $rate->state; 
?>
	
	<fieldset>
	<legend><?php echo __($key.' price') ?></legend>
	
	<input type="hidden" name="frate[<?php echo $i?>][pricetype]" value="<?php echo $key ?>" />
	
	<table style="width:300px" id="formvalidate">
				<tr>
				  <td></td>
				  <td><?php echo __('One way'); ?></td>		
				  <td><?php echo __('Roundtrip'); ?></td>
				</tr>
				<tr>
				  <td><?php echo __('Adult price'); ?></td>
				  <td><input class="input-small required" required type="text" placeholder="<?php echo __('Adult'); ?> " 

				  id="adult" name="frate[<?php echo $i?>][adult]" value="<?php echo $rate->adult?>" /></td>		

				  <td><input class="input-small required" required placeholder="<?php echo __('Adult roundtrip'); ?>" type="text"
			name="frate[<?php echo $i?>][adult_roundtrip]" value="<?php echo $rate->adult_roundtrip?>" /></td>
				</tr>
				<tr>
				  <td><?php echo __('Child price'); ?></td>
				  <td><input class="input-small required" required type="text" name="frate[<?php echo $i?>][child]" placeholder="<?php echo __('Child'); ?>" value="<?php echo $rate->child ?>" /></td>		
				  <td><input class="input-small required" required type="text" placeholder="<?php echo __('Child roundtrip'); ?>"
				name="frate[<?php echo $i?>][child_roundtrip]" value="<?php echo $rate->child_roundtrip ?>" /></td>
				</tr>
				<tr>
				  <td><?php echo __('Infant price') ?></td>
				  <td><input class="input-small required" required type="text" name="frate[<?php echo $i?>][infant]]" placeholder="<?php echo __('Infant') ?>"
				id="infant" value="<?php echo $rate->infant ?>" /></td>		
				  <td><input class="input-small required" required type="text" placeholder="<?php echo __('Infant Roundtrip'); ?>"
				name="frate[<?php echo $i?>][infant_roundtrip]" 	value="<?php echo $rate->infant_roundtrip ?>" /></td>
				</tr>

			
				<tr>
					<td><?php echo __('Seat')?></td>
					<td colspan="2"><input class="input-mini required" required type="number" name="frate[<?php echo $i?>][seat]" value="<?php echo $rate->seat ?>" placeholder="<?php echo __('Seat')?>"/></td>
				</tr>

			</table>
			
			

			
	
</fieldset>	
	

<?php } ?>
<hr>
<?php echo HBHtml::booleanlist('frateparams[state]','class="radio btn"',is_null($state) ? 1 : $state,__('Open'),__('Close'))?>
<input type="hidden" name="frateparams[date]" value="<?php echo $this->date; ?>" />
<input type="hidden" name="frateparams[route_id]" value="<?php echo $this->route_id; ?>" />
<input type="button"	class="button button-primary" value="Save" id="savedaterate" />
</form>
</div>