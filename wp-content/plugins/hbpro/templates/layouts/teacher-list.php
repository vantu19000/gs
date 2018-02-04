<?php $exp_type = HBParams::get_exp_type()?>
<div class="row resultItem">
	<div class="col medium-3">
		<img width="100px" height="100px" class="img-circle"
			src="<?php echo $displayData->icon?>">
	</div>
	<div class="col medium-6">
		<p style="font-size: 20px">
			<a href=""> <?php echo $displayData->full_name?> </a>
		</p>
		<p>
			<i class="fa fa-graduation-cap" aria-hidden="true"></i> <?php echo $exp_type[$displayData->exp_type]?> <span>
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
				<p><?php echo $displayData->salary?>vnd/giờ</p>
			</div>

		</div>
		<a href="<?php echo site_url().'?view=orderbook&teacher_id='.$displayData->id?>"
			class="button">Đăng ký học</a>
	</div>
</div>