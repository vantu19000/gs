<div class="row resultItem">
		                    <div class="col medium-1">
		                        <img width="100px" height="100px" class="img-circle" src="<?php echo $displayData->icon?>">
		                    </div>
		                    <div class="col medium-7">
		                        <p style="font-size: 20px"><a href=""> <?php echo $displayData->full_name?> </a></p>
		                        <p><i class="fa fa-edge" aria-hidden="true"></i> <?php echo $exp_type[$displayData->exp_type]?> <span> <i class="fa fa-language" aria-hidden="true"></i> <?php echo $displayData->address?></span></p>
		                        <p>
		                            <?php echo $displayData->excerpt?>
		                        </p>
		                    </div>
		                    <div class="col medium-4">
		                        <div class="row lead evaluation">
		                           <div class="vers column-rating">
					<div class="star-rating"><span class="screen-reader-text">4,5 đánh giá dựa trên 150 đánh giá</span><div class="star star-full" aria-hidden="true"></div><div class="star star-full" aria-hidden="true"></div><div class="star star-full" aria-hidden="true"></div><div class="star star-full" aria-hidden="true"></div><div class="star star-half" aria-hidden="true"></div></div>					<span class="num-ratings" aria-hidden="true">(150)</span>
				</div>
		                            
		                            <div class="priceBox">
		                                <p><?php echo $displayData->salary?>vnd/giờ</p>
		                            </div>
		
		                        </div>
		                        <a href="<?php echo site_url().'?view=orderbook&teacher_id='.$displayData->id?>" class="btn btn-success">Đăng ký học</a>
		                    </div>
		                </div>