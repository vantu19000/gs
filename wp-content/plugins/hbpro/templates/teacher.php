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
$degree_type = HBParams::get_degree_type();

global $wpdb;

$quanhuyen = explode(",", $item->province_id);
//$quanhuyen = HBParams::get_provinces_by_id($item->district_id)

$quanhuyen2 = '';
foreach ($quanhuyen AS $value){
    $quanhuyen2 .= HBParams::get_provinces_by_id($value)[0]->name . ", ";
}

?>

<script>
    document.title = '<?php echo $item->full_name . " - Trung tâm gia sư trí việt" ?>';
</script>

    <div id="primary" class="content-area bg-gray" style="margin-top: 30px;">
	<div class="container">
		<center><h2>Thông tin gia sư</h2></center>
		<div id="main" class="row" style="margin-bottom:10px;">

			<div class="col medium-12">

                <div class="row">
                    <div class="col medium-6">
                        <p style="font-size: 20px">Họ tên: <?php echo $item->full_name?></p>
                        <p>Ngày sinh: <?php echo (new DateTime($item->birthday))->format('d-m-Y')?></p>
                        <p>Giới tính: <?php if($item->gender == 'M'){echo "nam";}else{echo "Nữ";} ?></p>
                        <p>Điện thoại: <?php echo $item->mobile; ?></p>
                        <p>Email: <?php echo $item->email; ?></p>
<!--                        <p>--><?php //echo $exp_type[$item->exp_type]?><!-- </p>-->
                        <p>Học vấn: <?php echo HBParams::get_degree_type()[$item->degree_type];?></p>
                        <p>Địa chỉ: <?php echo $item->address?></p>
<!--                        --><?php //echo HBHtml::star_rating($item->star_number,$item->star_volume,false)?>

                        <h5>Nhận gia sư</h5>

                        <p>Các lớp: <?php echo $item->class_type ?></p>
                        <p>Các môn: <?php
                            $subject = explode(",", $item->subject_id);
                            foreach ($subject AS $value){
                                echo HBParams::get_subject_type()[$value]. ", ";
                            }
                        ?></p>
                        <p>Khu vực có thể gia sư: <?php
                            $tinh = reset(HBParams::get_districts_by_id($item->district_id));
                            echo $tinh->name. ": " . $quanhuyen2;
                        ?></p>
                        <p>Thời gian dạy: <?php echo $item->time ?></p>
                        <p>Mức lương: <?php echo $item->salary ?></p>
                    </div>
                    <div class="col medium-6">
                        <img class="img-circle" width="200px" height="200px" src="<?php echo $item->icon?$item->icon:'https://upload.wikimedia.org/wikipedia/commons/1/1e/Default-avatar.jpg'?>" alt="<?php echo $item->full_name?>"/>
                    </div>
                </div>

                <h5>Tóm tắt</h5>
                <p><?php echo $item->excerpt?> </p>
                <h5>Giới thiệu thêm</h5>
                <p><?php echo $item->desc?></p>
                <div class="priceBox">
                            <p>Mức lương mong muốn: <?php echo HBCurrencyHelper::displayPrice($item->salary)?>/giờ</p>
                        </div>
                <a  href="<?php echo site_url('/?view=orderbook&teacher_id='.$item->id)?>" class="button">Gửi yêu cầu</a>
			</div>
			<div class="clearfix"></div>

			<!-- Review -->
			<input type="hidden" id="notes"/>
		</div>
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
