<?php
/**
 * The template for displaying tin tuc page
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package woafun
 */

wp_enqueue_script('jquery-ui-datepicker');
wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
get_header();

?>
	
<div id="primary" class="content-area bg-gray">
	<!-- Tin moi -->
	<div class="container">
		<div class="row" >
			<div class="col-md-2"></div>
			<div class="col-md-8" id="main">
				<center><h2>Đăng kí tài khoản</h2></center>
				<form action="index.php?hbaction=user&task=register" method="post">
					<div class="">
						<div class="form-group row">
							<label class="col-xs-3 col-form-label">Tên<span class="text-danger">*</span></label>
							<div class="col-xs-9">
								<input class="form-control input-medium required name" required type="text"
									name="user[first_name]" maxlength="150" />
							</div>
						</div>
						<div class="form-group row">
							<label class="col-xs-3 col-form-label">Họ và tên đệm<span class="text-danger">*</span></label>
							<div class="col-xs-9">
								<input class="form-control input-medium required name" required type="text" 
									name="user[last_name]" maxlength="150" />
							</div>
						</div>
						<div class="form-group row">
							<label class="col-xs-3 col-form-label">Tên tài khoản<span class="text-danger">*</span></label>
							<div class="col-xs-9">
								<input class="form-control input-medium required name" required type="text" id="username"
									name="user[user_login]" maxlength="150" />
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-xs-3 col-form-label">Ngày sinh<span class="text-danger">*</span></label>
							<div class="col-xs-9">
									<?php echo HBHtml::calendar('', 'user[birthday]','birthday','yy-mm-dd','readonly class="form-control input-medium required name" required',array('changeMonth'=>true,'changeYear'=>true))?>
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-xs-3 col-form-label">Giới tính<span class="text-danger">*</span></label>
							<div class="col-xs-9">
								<input class="required" required type="radio" id="gender_m"
									name="user[gender]" value="M" />Nam
								<input class="required" required type="radio" id="gender_f"
									name="user[gender]" value="F" />Nữ
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-xs-3 col-form-label">Số điện thoại<span class="text-danger">*</span></label>
							<div class="col-xs-9">
								<input class="form-control input-medium required" type="tel" maxlength="14" required id="user_phone"
									name="user[phone]" oninvalid="this.setCustomValidity('Số điện thoại định dạng không đúng')" />
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-xs-3 col-form-label">Email<span class="text-danger">*</span></label>
							<div class="col-xs-9">
								<input class="form-control input-medium" type="email" id="user_email"
									name="user[user_email]"  />
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-xs-3 col-form-label">Địa chỉ<span class="text-danger">*</span></label>
							<div class="col-xs-9">
								<textarea class="form-control input-medium required" required type="text" id="user_address" name="user[address]" rows="6"></textarea>
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-xs-3 col-form-label">Mật khẩu<span class="text-danger">*</span></label>
							<div class="col-xs-9">
								<input class="form-control input-medium" type="password" id="user_password"
									name="user[user_pass]"  />
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-xs-3 col-form-label">Nhập lại mật khẩu<span class="text-danger">*</span></label>
							<div class="col-xs-9">
								<input class="form-control input-medium" type="password" id="passwordconfirm"/>
							</div>
						</div>
						<input type="checkbox" id="term" required oninvalid="this.setCustomValidity('Vui lòng đọc và chấp nhận các điều khoản của WOAFUN')"/> Tôi đã đọc và chập nhận tất cả <a targer="_blank" href="<?php echo site_url('dieu-khoan')?>">chính sách và điều khoản</a> của woafun.
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
