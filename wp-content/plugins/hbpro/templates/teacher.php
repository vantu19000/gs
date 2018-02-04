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
HBImporter::helper('params');
$model = new HBModelTeacher();
$item = $model->getItem(HBFactory::getInput()->get('teacher_id'));
$exp_type = HBParams::get_exp_type();
?>
	
<div id="primary" class="content-area bg-gray">
	<div class="container">
		<center><h2>Thông tin gia sư</h2></center>
		<div id="main" class="row" style="margin-bottom:10px;">
			<div class="col medium-6">
				<img class="img-circle" src="<?php echo $item->icon?>" style="width:100%" alt="<?php echo $item->full_name?>"/>
			</div>
			<div class="col medium-6">
				
				<p style="font-size: 20px">Họ tên: <?php echo $item->full_name?></p>
                    <p> <?php echo $exp_type[$item->exp_type]?> </p>
                    <p>Ngày sinh: <?php echo (new DateTime($item->birthday))->format('d-m-Y')?></p>
                    <p>Bằng cấp: <?php echo HBParams::get_degree_type()[$item->degree_type];?></p>
                    <p>Địa chỉ:<?php echo $item->address?></p>
                    <p><?php echo $item->excerpt?> </p>
                    <div class="priceBox">
                                <p>Mức lương mong muốn: <?php echo $item->salary?>vnd/giờ</p>
                            </div>
                    <a  href="<?php echo site_url('/?view=orderbook&teacher_id='.$item->id)?>" class="button">Gửi yêu cầu</a>
			</div>
			<div class="clearfix"></div>
			<h5>Giới thiệu</h5>
			<p><?php echo $item->desc?></p>
		</div>
		
	</div>
	
</div><!-- #primary -->
<?php
get_footer();
