<?php
/**
 * The template for displaying tin tuc page
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package woafun
 */

get_header(); 
HBImporter::model('teacher');
$model = new HBModelTeacher();
$item = $model->getItem(HBFactory::getInput()->get('teacher_id'));
HBImporter::helper('params','currency');
$exp_type = HBParams::get_exp_type();

//echo "<pre>";
//print_r($item);
//die;

?>
	
<div id="primary" class="content-area bg-gray" style="margin-top: 30px;">
	<!-- Tin moi -->
	<div class="container">
		<div id="main" class="row" style="margin-bottom:10px;">
			<div class="col medium-4">
				<div class="">
                    <center><h2>Thông tin gia sư</h2></center>
                    <div class="clearfix"></div>
					<p><img width="100px" height="100px" class="img-circle" src="<?php echo $item->icon ? $item->icon :"https://upload.wikimedia.org/wikipedia/commons/1/1e/Default-avatar.jpg"?>"></p>
                    <p style="font-size: 20px">Họ tên: <?php echo $item->full_name?></p>
                    <?php echo HBHtml::star_rating($item->star_number)?>
                    <p> <?php echo $exp_type[$item->exp_type]?> </p>
                    <p>Ngày sinh: <?php echo (new DateTime($item->birthday))->format('d-m-Y')?></p>
                    <p><i class="fa fa-graduation-cap" aria-hidden="true"></i> Bằng cấp: <?php echo HBParams::get_degree_type()[$item->degree_type];?></p>
                    <p><i class="fa fa-location-arrow" aria-hidden="true"></i> Địa chỉ: <?php echo $item->address?></p>
                    <p><?php echo $item->excerpt?> </p>
					
					<div class="priceBox">
                            <p><i class="fa fa-money" aria-hidden="true"></i> Mức lương mong muốn: <?php echo HBCurrencyHelper::displayPrice($item->salary)?>/giờ</p>
                        </div>


                </div>
			</div>
			<div class="col medium-8">
				<center><h2>Đăng kí lớp học</h2></center>
				<form action="index.php?hbaction=order&task=register" method="post">
					<div class="">
						<div class="form-group row">
							<label class="col small-3 form-label" for="parent_name">Họ tên<span class="text-danger">*</span></label>
							<div class="col small-9">
								<input class="form-control input-medium required name" required type="text" id="parent_name"
									name="parent[name]" maxlength="150" />
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col small-3 form-label" for="mobile">Số điện thoại<span class="text-danger">*</span></label>
							<div class="col small-9">
								<input class="form-control input-medium required" type="text" required id="mobile"
									name="parent[mobile]"  />
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col small-3 form-label" for="parent_email">Email</label>
							<div class="col small-9">
								<input class="form-control input-medium" type="email" id="parent_email"
									name="parent[email]"  />
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col small-3 col form-label" for="parent_address">Địa chỉ<span class="text-danger">*</span></label>
							<div class="col small-9">
								<textarea class="form-control input-medium required" required type="text" id="parent_address" name="parent[address]" rows="6"></textarea>
							</div>
						</div>
						<div class="form-group row">
							<label class="col small-3 col form-label" for="parent_notes">Nội dung</label>
							<div class="col small-9">
								<textarea class="form-control input-medium" type="text" id="parent_notes" name="parent[notes]" rows="6"></textarea>
							</div>
						</div>
                        <input type="checkbox" id="term" required/> <label for="term">Tôi đã đọc tất cả <a target="_blank" href="<?php echo site_url('chinh-sach-va-dieu-khoan')?>">chính sách và điều khoản</a> Tôi cam kết sẽ tuân thủ và làm đúng.</label>
						<div class="clearfix"></div>

                        <input type="hidden" value="<?php echo $item->id; ?>" name="parent[teacher_id]">
						
					</div>
					
					<?php wp_nonce_field( 'hb_action', 'hb_meta_nonce' );?>
					<center><button type="submit" class="button">Đăng kí</button></center>
				</form>
			</div>
		</div>
		
	</div>
	
</div><!-- #primary -->
<?php
get_footer();
