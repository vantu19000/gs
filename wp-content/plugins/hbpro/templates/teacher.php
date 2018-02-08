<?php
/**
 * The template for displaying tin tuc page
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package woafun
 */
global $current_user;
get_header(); 
HBImporter::model('teacher');
HBImporter::helper('params','currency');
$model = new HBModelTeacher();
$item = $model->getItem(HBFactory::getInput()->get('teacher_id'));
$exp_type = HBParams::get_exp_type();

?>
	
<div id="primary" class="content-area bg-gray">
	<div class="container">
		<?php if($item->id){?>
		<center><h2>Thông tin gia sư</h2></center>
		<div id="main" class="row" style="margin-bottom:10px;">
			<div class="col medium-6">
				<img class="img-circle" src="<?php echo $item->icon?$item->icon:'https://upload.wikimedia.org/wikipedia/commons/1/1e/Default-avatar.jpg'?>" style="width:100%" alt="<?php echo $item->full_name?>"/>
			</div>
			<div class="col medium-6">
				
				<p style="font-size: 20px">Họ tên: <?php echo $item->full_name?></p>
				<?php echo HBHtml::star_rating($item->star_number,$item->star_volume,false)?>
                    <p> <?php echo $exp_type[$item->exp_type]?> </p>
                    <p>Ngày sinh: <?php echo (new DateTime($item->birthday))->format('d-m-Y')?></p>
                    <p>Bằng cấp: <?php echo HBParams::get_degree_type()[$item->degree_type];?></p>
                    <p>Địa chỉ:<?php echo $item->address?></p>
                    <p><?php echo $item->excerpt?> </p>
                    <div class="priceBox">
                                <p>Mức lương mong muốn: <?php echo HBCurrencyHelper::displayPrice($item->salary)?>/giờ</p>
                            </div>
                    <a  href="<?php echo site_url('/?view=orderbook&teacher_id='.$item->id)?>" class="button">Gửi yêu cầu</a>
			</div>
			<div class="clearfix"></div>
			<h5>Giới thiệu</h5>
			<p><?php echo $item->desc?></p>
			<!-- Review -->
			<input type="hidden" id="notes"/>
		</div>
		<?php }else{?>
			<center>Không tìm thấy người phù hợp</center>
		<?php }?>
	</div>
	
</div><!-- #primary -->
<script>
	jQuery(document).ready(function($){
		$('.starrr').each(function(){
			$(this).starrr({			
				rating: $(this).attr("rating"),//$(this).attr("rating"),
				change: function(e, value){
					
					$.ajax({
						type: 'POST',
						url: '<?php echo site_url()?>/index.php?hbaction=user&task=ajax_voting&current_user=<?php echo $current_user->ID?>&'+ new Date().getTime(),					
						data: 'teacher_id=<?php echo $item->id?>&notes='+$('#notes').val()+'&star_number='+value,				 
						dataType: 'json',
						beforeSend: function() {						
						},
						success : function(result) {
							if(result.status==1){		
								return false;
							}else {
								alert(result.msg);
								return false;
							}
						}
					});
				}
			});
		});
	});
</script>
<?php
get_footer();
