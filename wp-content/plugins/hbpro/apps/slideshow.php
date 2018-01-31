<?php
	add_action('hbpro_add_slide_show', 'hbpro_add_slide_show');
	wp_enqueue_script( 'owl_slideshow', site_url().'/wp-content/plugins/hbpro/assets/js/owl.carousel.min.js',array('jquery'),'1.2');
	wp_enqueue_style( 'owl_carousel',  site_url().'/wp-content/plugins/hbpro/assets/css/owl.carousel.min.css',array(),'1.1');
	function hbpro_add_slide_show(){
		
	$config = HBFactory::getConfig();?>
	<div id="hbpro_carousel" class="slideshow hidden-sm hidden-xs">
		<div class="slideshow_slide slideshow_slide_image">
			<img class="avatar" src="wp-content/themes//images/slide1.jpg" alt="Chỉ với 200 triệu" ></img>
			<div class="slideshow_description_box slideshow_transparent">
				<div class="slideshow_title">Chỉ với 200 triệu</div>						
				<div class="slideshow_description">Sở hữu ngay một chung cư cao cấp</div>					
			</div>
		</div>
		
		<div class="slideshow_slide slideshow_slide_image">
			<img class="avatar" src="wp-content/themes/estate/images/slide2.jpg" alt="Vị trí đẹp thuận lợi"></img>
			<div class="slideshow_description_box slideshow_transparent">
				<div class="slideshow_title">Vị trí đẹp thuận lợi</div>						
				<div class="slideshow_description">Gần cầu Đông Trù thuận tiện đi lại với trung tâm thủ đô mà vẫn đảm bảo cách xa sự ồn ào, ô nhiễm của thành phố</div>					
			</div>
		</div>
		
		<div class="slideshow_slide slideshow_slide_image">
			<img class="avatar" src="wp-content/themes/estate/images/slide3.jpg" alt="Đầy đủ tiện ích" ></img>
			<div class="slideshow_description_box slideshow_transparent">
				<div class="slideshow_title">Đầy đủ tiện ích</div>						
				<div class="slideshow_description">Chung cư Eurowindow Đông Hội là tổ hợp căn hộ cao cấp,mang lại cho bạn không gian khép kín, an toàn với chuỗi hệ thống tiện ích 5 sao như: Trung tâm thương mại, khu vườn cây,khu thể thao phức hợp, khu vui chơi trẻ em,câu lạc bộ sức khoẻ, phòng khám,vườn treo trên cao. Bạn sẽ yên tâm hưởng thụ cuộc sống phụ đầy đủ nhu cầu thiết yếu của bạn và gia đình ngay trong khu đô thị. </div>					
			</div>
		</div>
		
	</div>
	
	<script>
		jQuery(document).ready(function($){
			$('#hbpro_carousel').owlCarousel({
				slideSpeed : 300,
				autoPlay: 5000,
				lazyLoad: true,
				loop: true,
				paginationSpeed : 400,
				transitionStyle:'fade',
				autoHeight : '400px',
				autoWidth: false,
				navigation: false,
				pagination: true,
				navigationText: ['<','>'],
				itemsCustom : false,
		        itemsDesktop : [1400,1],
		        itemsDesktopSmall : [980,1],
		        itemsTablet: [768,1],
		        itemsTabletSmall: false,
		        itemsMobile : [479,1],
		        afterAction: function(el){
			       //remove class active
	        	   this.$owlItems.removeClass('active');	
	        	   this.$owlItems.eq(this.currentItem).addClass('active');    
        	    } 
			});
		});
		
	</script>
	<?php 
	}				