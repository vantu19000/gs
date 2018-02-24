<?php 
HBImporter::helper('currency');
$exp_type = HBParams::get_exp_type();
$order_link =site_url().'?view=orderbook&teacher_id='.$displayData->id;
global $current_user;

?>
<div class="row resultItem" style="margin-top: 15px">
	<div class="col medium-2">
		<img width="150px" height="150px" class="img-circle"
			src="<?php echo $displayData->icon ? $displayData->icon : 'https://upload.wikimedia.org/wikipedia/commons/1/1e/Default-avatar.jpg'?>">
	</div>
	<div class="col medium-7">
		<p style="font-size: 20px">
            <a target="_blank" href="<?php echo site_url('/gia-su/'.HBHelper::convert_to_alias($displayData->full_name).'-'.$displayData->id)?>"><?php echo $displayData->full_name?></a>

<!--            <a href="--><?php //echo $order_link?><!--"> --><?php //echo $displayData->full_name?><!-- </a>-->
		</p>
		<p>
			<i class="fa fa-graduation-cap" aria-hidden="true"></i> <?php echo $exp_type[$displayData->exp_type]?> <span>
                &nbsp;
                &nbsp;
            <i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $displayData->address?></span>
		</p>
		<p><?php echo $displayData->excerpt?></p>
<!--		<a target="_blank" href="--><?php //echo site_url('/?view=teacher&teacher_id='.$displayData->id)?><!--">Xem thêm</a>-->
        <a target="_blank" href="<?php echo site_url('/gia-su/'.HBHelper::convert_to_alias($displayData->full_name).'-'.$displayData->id)?>">Xem thêm</a>
	</div>
	<div class="col medium-3">
		<div class="row lead evaluation">
			<div class="vers column-rating">
				<?php echo HBHtml::star_rating($displayData->star_number, null, true, $displayData->id)?>
				<span class="num-ratings" id="starNum<?php echo $displayData->id; ?>" aria-hidden="true">(<?php echo $displayData->star_volume?>)</span>
			</div>

			<div class="priceBox">
				<p><?php echo HBCurrencyHelper::displayPrice($displayData->salary)?>/giờ</p>
			</div>

		</div>
		<a href="<?php echo $order_link?>"
			class="button">Đăng ký học</a>
	</div>
</div>

<style>
    .img-circle{
        width: 150px;
        height: 150px;
        border-radius: 50%;
    }
</style>


<script>
    jQuery(document).ready(function($){
        $('#star<?php echo $displayData->id; ?>').each(function(){
            $(this).starrr({
                rating: $(this).attr("rating"),//$(this).attr("rating"),
                change: function(e, value){

                    $.ajax({
                        type: 'POST',
                        url: '<?php echo site_url()?>/index.php?hbaction=user&task=ajax_voting&current_user=<?php echo $current_user->ID?>&'+ new Date().getTime(),
                        data: 'teacher_id=<?php echo $displayData->id?>&notes='+$('#notes').val()+'&star_number='+value,
                        dataType: 'json',
                        beforeSend: function() {
                        },
                        success : function(result) {
                            console.log(result);
                            if(result.status==1){
                                $('#starNum<?php echo $displayData->id; ?>').html('('+result.count+')')
                                return false;
                            }else {
                                alert(result.msg);
                                return false;
                            }
                        }
                    });
                }
            });
        });
    });
</script>