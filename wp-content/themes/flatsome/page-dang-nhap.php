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
	
<div id="primary" class="content-area">
	<!-- Tin moi -->
	<div  class="container">
		<div id="main" class="row">
			<div class="col-md-3"></div>
			<div class="col-md-6">
					<center><h2>Đăng nhập</h2></center>
					<form action="<?php echo site_url('index.php?hbaction=user&task=login')?>" method="post" class="well well-small" >
						<div class="">
							<div class="form-group row">
								<label class="col-xs-3 col-form-label" for="name">Tên đăng nhập (*)</label>
								<div class="col-xs-9">
									<input class="form-control input-medium name" required type="text" id="name"
										name="user_login" oninvalid="this.setCustomValidity('Vui lòng điền tên đăng nhập của bạn')"/>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-xs-3 col-form-label" for="password">Mật khẩu (*)</label>
								<div class="col-xs-9">
									<input class="form-control input-medium required name" required type="password" id="password"
										name="user_pass" maxlength="150" oninvalid="this.setCustomValidity('Không có mật khẩu thì đăng nhập kiểu gì hả thánh')"/>
								</div>
							</div>
							<input type="checkbox" id="term" name="remember"/> <label for="term"> Ghi nhớ đăng nhập</label>
							<div class="clearfix"></div>
							<a href="<?php echo site_url('wp-login.php?action=lostpassword')?>">Quên mật khẩu</a>
							<div class="clearfix"></div>
							<a href="<?php echo site_url('dang-ki-tai-khoan')?>">Đăng kí tài khoản mới</a>
						</div>
						<?php wp_nonce_field( 'hb_action', 'hb_meta_nonce' );?>
						<center><button type="submit" class="btn btn-primary btn-lg">Đăng nhập</button></center>
					</form>
			</div>
			<div class="col-md-3"></div>
		
		</div>
		
	</div>
	
</div><!-- #primary -->
<?php
get_footer();
?>

<style>
    .content-area{
        margin-top: 30px;
    }
</style>
