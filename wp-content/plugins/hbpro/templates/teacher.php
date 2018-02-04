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

?>
	
<div id="primary" class="content-area bg-gray">
	<div class="container">
		<div id="main" class="row" style="margin-bottom:10px;">
			
			<div class="col medium-8">
				<center><h2>Thông tin gia sư</h2></center>
				<div class="col medium-4">
				<div class="row resultItem">
                    <img width="100px" height="100px" class="img-circle" src="<?php echo $item->icon?>">
                    <p style="font-size: 20px"><a href=""> <?php echo $item->full_name?> </a></p>
                    <p><i class="fa fa-edge" aria-hidden="true"></i> <?php echo $exp_type[$item->exp_type]?> <span> <i class="fa fa-language" aria-hidden="true"></i> <?php echo $item->address?></span></p>
                    <p><?php echo $item->excerpt?> </p>
                    <div class="row lead evaluation">
                       <div id="colorstar" class="starrr ratable" ></div>
                            
                            <div class="priceBox">
                                <p><?php echo $item->salary?>vnd/giờ</p>
                            </div>

                   </div>
                </div>
			</div>
			</div>
		</div>
		
	</div>
	
</div><!-- #primary -->
<?php
get_footer();
