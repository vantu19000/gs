<?php 
if (! defined ( 'ABSPATH' )) {
	exit ();
}

class HbRegisterForm_Widget extends HB_Widget {
	public function __construct() {
	
		$widget_ops = array( 
			'classname' => 'HbRegisterForm_Widget',
			'description' => 'Form to client register email',
		);
		parent::__construct( 'HbRegisterForm_Widget', 'Register Email Form', $widget_ops );
	}
	public function output( $args, $instance ) {
		?>
		<div id="hbwidget-register-form" class="hidden-xs">
				<div class="bg-gradient heading">Liên hệ</div>
				<div class="bg-gray" style="padding:20px;">
					<div class="form-horizontal">	
						<div class="form-group">
							<input type="email" class="form-control" required id="hb_widget_register_email"  placeholder="Email của bạn">
						</div>
						<div class="form-group">
							<input type="text" class="form-control" required id="hb_widget_register_phone"  placeholder="Số điện thoại của bạn">
						</div>
						<div class="form-group">
							<textarea type="email" rows="5" class="form-control" required id="hb_widget_register_notes"  placeholder="Bạn có câu hỏi nào không, nếu không có vui lòng bỏ trống"></textarea>
						</div>
						
						<center><button type="button" id="hb_widget_register_confirm" class="btn btn-lg btn-primary">Đăng kí</button></center>
					</div>
				</div>
		</div>
		
			
		<script> 
			jQuery(document).ready(function($){
				
				$('#hb_widget_register_confirm').click(function(){
					var email = $('#hb_widget_register_email').val();
					var phone = $('#hb_widget_register_phone').val();
					var notes = $('#hb_widget_register_notes').val();
					var check=false;
					var valid = false;
					if(email.match(/^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i)){
						check = true;
					}else{
						valid = 'email';
					}		
					if(phone.match(/^[(]{0,1}[0-9]{3}[)]{0,1}[-\s\.]{0,1}[0-9]{3}[-\s\.]{0,1}[0-9]{3,6}$/)){
						check=true;
					}else{
						valid = 'số điện thoại';
					}
					
					if(check){
						$.ajax({
							url: '<?php echo site_url('index.php?hbaction=user&task=ajax_register&hb_meta_nonce='.wp_create_nonce( 'hb_meta_nonce' ));?>&email='+email+'&phone='+phone+'&notes='+notes,
							type: "GET",
							dataType: "json",
							beforeSend: function(){
								display_processing_form(1);
							},
							success : function(result) {
								jAlert('Cám ơn bạn đã đăng kí chúng tôi sẽ gọi cho bạn sớm nhất có thể!<br>Chúc bạn một ngày tốt lành!');
								display_processing_form(0);
							},
							error: function(jqXHR, textStatus, errorThrown) {
								jAlert('Xin lỗi bạn, đã có lỗi xảy ra vui lòng thử lại hoặc gọi cho chúng tôi để được tư vấn ngay!');
								display_processing_form(0);
							}
						});
					}else{
						$('#input_contact_phones').focus();
						if(phone == '' && email==''){
							jtrigger_error('Bạn vui lòng nhập số điện thoại hoặc email','');
						}else{
							jtrigger_error('Số điện thoại hoặc email không đúng. Bạn vui lòng nhập lại nhé!','');
						}
						
					}
				});
			});
		</script>
		<?php 
	}
	
}