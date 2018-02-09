<?php
/**
 * The template for displaying tin tuc page
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package woafun
 */

get_header(); 
HBImporter::helper('params','html');
$input = HBFactory::getInput();
// HBImporter::model('teacher');
// $model = new HBModelTeacher();
// $items = $model->getItems();
global $wpdb;
$exp_type = HBParams::get_exp_type();
$query = "Select u.*,AVG(r.star_number) as star_number,count(r.id) as star_volume from {$wpdb->prefix}hbpro_users as u
LEFT JOIN {$wpdb->prefix}hbpro_rating as r ON r.teacher_id=u.id WHERE u.status=1";
$file_query = array('subject_id','exp_type','class_type','degree_type','district_id','province_id');
$where = array();
//foreach($file_query as $key){
    if ($input->getInt('province_id')){
        $where[] = 'u.province_id LIKE "%' .$input->get("province_id") .'%"';
    }
    if ($input->getInt('class_type')){
        $where[] = 'u.class_type LIKE "%' . $input->get("class_type") .'%"';
    }
    if ($input->getInt("subject_type")){
        $where[] = 'u.subject_id LIKE "%' . $input->get("subject_type") .'%"';
    }
    if ($input->getInt("district_id")){
        $where[] = 'u.district_id = ' . $input->get("district_id");
    }
    if ($input->getInt("degree_type")){
        $where[] = 'u.degree_type = ' . $input->get("degree_type");
    }
//	if($input->getInt($key)){
//		$where[] = 'u.'.$key.' ='.$input->getInt($key);
//	}
//}
//if ($input->get("province_id")){
//    $where[] = 'u.province_id LIKE `#' .$input->get("province_id") ."%`";
//}
if($input->get('gender')){
	$where[] = 'u.gender ="'.$input->get('gender').'"';
}
if(!empty($where)){
	$query.=' AND '.implode(' AND ', $where);
}
$query .= ' GROUP BY u.id';
//echo $query;
$items = $wpdb->get_results($query);

$total= count($items);
$number_result = array();
foreach($exp_type as $e=>$type){
	$number_result[$e] = array_filter($items,function($obj) use ($e) {return $obj->exp_type==$e;});
}
// debug($items);
?>

<div class="container">
	<?php include ABSPATH.'wp-content/themes/flatsome/module-search.php';?>
    <div class="row resultBox">
        <h2 class="text-center">Kết quả tìm kiếm</h2>
        <ul class="nav nav-tabs">
            <li class="active tab" data-item="home"><a href="javascript:void(0)">Tất cả (<?php echo $total?>)</a></li>
            <?php 
			foreach($exp_type as $e=>$type){?>
				<li class="tab" data-item="menu<?php echo $e?>"><a href="javascript:void(0)"><?php echo $type?> (<?php echo count($number_result[$e])?>)</a></li>				
			<?php }?>
        </ul>
		<?php if($total<1){?>
		Không tìm thấy gia sư phù hợp
		<?php }else{?>
        <div class="tab-content">        	
            <div id="home" class="tab-pane fade in active">
               <?php foreach($items as $item){?>
               		<?php echo HBHelper::renderLayout('teacher-list', $item)?>
               <?php }?>
            </div>

			<?php 
			foreach($exp_type as $e=>$type){?>
				<div id="menu<?php echo $e?>" class="tab-pane" style="display:none">
					<?php foreach($number_result[$e] as $item){?>
						 <?php echo HBHelper::renderLayout('teacher-list', $item)?>
					<?php }?>
				</div>
								
			<?php }?>

        </div>
        <?php }?>
    </div>
	
	<hr>

</div>



<style>
    .class{
        width: 100%;
    }
    .filterCss{
        margin-bottom: 10px;
    }
    .filterBox{
        margin-top: 30px;margin-bottom: 30px;
    }
    .resultBox{

    }
    .resultItem{
        margin-top: 20px;
    }
    ul li {
    }
    #colorstar { color: #ee8b2d;}
    .badForm {color: #FF0000;}
    .goodForm {color: #00FF00;}
    .evaluation { margin-left:0px;}
    .priceBox{
        margin-top: 10px;
    }

</style>
<script>
jQuery(document).ready(function($){
	$('.nav-tabs .tab').click(function(){
		$('.nav-tabs .tab').removeClass('active');
		$(this).addClass('active');
		$('.tab-pane').hide();
		$('#'+$(this).attr('data-item')).show();
		});
});
</script>

<?php
get_footer();
