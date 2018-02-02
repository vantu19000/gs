<?php
/**
 * The template for displaying tin tuc page
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package woafun
 */

get_header(); 
?>
	
<div id="primary" class="content-area bg-gray">
	<!-- Tin moi -->
	<div class="container">
		<div id="main" class="row" style="margin-bottom:10px;">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<center><h2>Đăng kí lớp học</h2></center>
				<form action="index.php?hbaction=order&task=register" method="post">
					<div class="">
						<div class="form-group row">
							<label class="col-xs-3 col-form-label">Họ tên phụ huynh<span class="text-danger">*</span></label>
							<div class="col-xs-9">
								<input class="form-control input-medium required name" required type="text" id="parent_name"
									name="parent[name]" maxlength="150" />
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-xs-3 col-form-label">Số điện thoại phụ huynh<span class="text-danger">*</span></label>
							<div class="col-xs-9">
								<input class="form-control input-medium required" type="phone" required id="parent_phone"
									name="parent[phone]"  />
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-xs-3 col-form-label">Email phụ huynh</label>
							<div class="col-xs-9">
								<input class="form-control input-medium" type="email" id="parent_email"
									name="parent[email]"  />
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-xs-3 col-form-label">Địa chỉ<span class="text-danger">*</span></label>
							<div class="col-xs-9">
								<textarea class="form-control input-medium required" required type="text" id="parent_address" name="parent[address]" rows="6"></textarea>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-xs-3 col-form-label">Nội dung</label>
							<div class="col-xs-9">
								<textarea class="form-control input-medium" type="text" id="parent_note" name="parent[note]" rows="6"></textarea>
							</div>
						</div>
						<input type="checkbox" id="term" required/> Tôi đã đọc tất cả <a target="_blank" href="<?php echo site_url('chinh-sach-va-dieu-khoan')?>">chính sách và điều khoản</a> Tôi cam kết sẽ tuân thủ và làm đúng.
						<div class="clearfix"></div>
						
					</div>
					<?php wp_nonce_field( 'hb_action', 'hb_meta_nonce' );?>
					<center><button type="submit" class="btn btn-primary btn-lg">Đăng kí</button></center>
				</form>
			</div>
			<div class="col-md-2"></div>
		</div>
		
	</div>
	
</div><!-- #primary -->
<?php
get_footer();
