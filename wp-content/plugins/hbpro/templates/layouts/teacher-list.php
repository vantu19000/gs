<?php 
HBImporter::helper('currency');
$exp_type = HBParams::get_exp_type();
$order_link =site_url().'?view=orderbook&teacher_id='.$displayData->id;
?>
<div class="row resultItem" style="margin-top: 15px">
	<div class="col medium-2">
		<img width="150px" height="150px" class="img-circle"
			src="<?php echo $displayData->icon ? $displayData->icon : 'https://upload.wikimedia.org/wikipedia/commons/1/1e/Default-avatar.jpg'?>">
	</div>
	<div class="col medium-7">
		<p style="font-size: 20px">
			<a href="<?php echo $order_link?>"> <?php echo $displayData->full_name?> </a>
		</p>
		<p>
			<i class="fa fa-graduation-cap" aria-hidden="true"></i> <?php echo $exp_type[$displayData->exp_type]?> <span>
                &nbsp;
                &nbsp;
            <i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $displayData->address?></span>
		</p>
		<p><?php echo $displayData->excerpt?></p>
		<a target="_blank" href="<?php echo site_url('/?view=teacher&teacher_id='.$displayData->id)?>">Xem thêm</a>
	</div>
	<div class="col medium-3">
		<div class="row lead evaluation">
			<div class="vers column-rating">
				<?php echo HBHtml::star_rating($displayData->star_number)?>
				<span class="num-ratings" aria-hidden="true">(<?php echo $displayData->star_volume?>)</span>
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