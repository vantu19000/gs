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
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<center><h2>Đăng kí làm giảng viên của WOAFUN</h2></center>
				<form action="index.php?hbaction=user&task=registerteacher" method="post" style="width:70%;margin: 10px auto;">
					<div class="">
						<div class="form-group row">
							<label class="col-xs-3 col-form-label">Họ tên<span class="text-danger">*</span></label>
							<div class="col-xs-9">
								<input class="form-control input-medium required name" required type="text" id="name"
									name="teacher[name]" maxlength="150" />
							</div>
						</div>
						
						
						<div class="form-group row">
							<label class="col-xs-3 col-form-label">Ngày sinh<span class="text-danger">*</span></label>
							<div class="col-xs-9">
								<?php echo HBHtml::calendar('', 'teacher[birthday]','birthday','yy-mm-dd','readonly class="form-control input-medium required name" required',array('changeMonth'=>true,'changeYear'=>true))?>
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-xs-3 col-form-label">Giới tính<span class="text-danger">*</span></label>
							<div class="col-xs-9">
								<input class="required" required type="radio" id="gender_m"
									name="teacher[gender]" value="M" />Nam
									<input class="required" required type="radio" id="gender_f"
									name="teacher[gender]" value="F" />Nữ
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-xs-3 col-form-label">Số điện thoại<span class="text-danger">*</span></label>
							<div class="col-xs-9">
								<input class="form-control input-medium required" type="phone" required id="parent_phone"
									name="teacher[phone]"  />
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-xs-3 col-form-label">Email<span class="text-danger">*</span></label>
							<div class="col-xs-9">
								<input class="form-control input-medium" type="email" id="parent_email"
									name="teacher[email]"  />
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-xs-3 col-form-label">Địa chỉ<span class="text-danger">*</span></label>
							<div class="col-xs-9">
								<textarea class="form-control input-medium required" required type="text" id="parent_address" name="teacher[address]" rows="6"></textarea>
							</div>
						</div>
						
						
						<input type="checkbox" id="term" required/> Tôi đã đọc tất cả <a targer="_blank" href="<?php echo site_url('dieu-khoan')?>">điều khoản</a> và chấp nhận nó.
						<div class="clearfix"></div>
						<p class="text-danger text-justify">Chú ý rằng hiện tại WOAFUN chỉ hoạt động ở khu vực Hà Nội vậy phụ huynh học sinh ở khu vực tỉnh khác vui lòng chờ khoảng vài tháng tiếp theo. Chúng tôi đang cố gắng phát triển dịch vụ để phục vụ con em học sinh tốt nhất có thể. Rất mong nhận được sự ủng hộ của các bạn!</p>
						<!-- 
						<div class="form-group row">
							<label class="col-xs-3 col-form-label">Tỉnh thành</label>
							<div class="col-xs-9">
								<input class="form-control input-medium required" type="text" id="parent_province" name="teacher[province]"  />
							</div>
						</div>
						 -->
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
