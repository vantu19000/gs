<?php
/**
 * The template for displaying search forms in flatsome
 *
 * @package flatsome
 */

$placeholder = __( 'Search', 'woocommerce' ).'&hellip;';
// if(get_theme_mod('search_placeholder')) $placeholder = get_theme_mod('search_placeholder');
HBImporter::helper('params','html');
$input = HBFactory::getInput();
$class_types = HBParams::get('class_type','arrayObject');
array_unshift($class_types, (object)array('value'=>'','text'=>'------ Chọn lớp -----'));

$degree_types = HBParams::get('degree_type','arrayObject');
array_unshift($degree_types, (object)array('value'=>'','text'=>'------ Trình độ chuyên môn -----'));

$subject_types = HBParams::get('subject_type','arrayObject');
array_unshift($subject_types, (object)array('value'=>'','text'=>'------ Chọn môn học -----'));

$districts = HBParams::get_districts();
array_unshift($districts, (object)array('matp'=>'','name'=>'------ Chọn thành phố -----'));


HBImporter::model('teacher');
$model = new HBModelTeacher();
$items = $model->getItems();

$exp_type = HBParams::get_exp_type();
$total= count($items);
$number_result = array();
// debug($items);die;
foreach($exp_type as $e=>$type){
	$number_result[$e] = array_filter($items,function($obj) use ($e) {return $obj->exp_type==$e;});
}
// debug($class_types);
?>


<div class="container">
<form method="get" class="searchform" action="<?php echo site_url('/ket-qua-tim-kiem/') ?>" role="search">
    <div class="row filterBox">
        <div class="col medium-3">
            <?php echo HBHtml::select($class_types, 'class_type', 'class="form-control filterCss"', 'value', 'text',$input->get('class_type'));?>
            <?php echo HBHtml::select($degree_types, 'degree_type', 'class="form-control filterCss"', 'value', 'text',$input->get('degree_type'));?>            
        </div>
        <div class="col medium-3">
        	<?php echo HBHtml::select($subject_types, 'subject_type', 'class="form-control filterCss"', 'value', 'text',$input->get('subject_type'));?>
        	<?php echo HBHtml::select($districts, 'district', 'class="form-control filterCss"', 'matp', 'name',$input->get('district_id'));?>
        </div>
        <div class="col medium-3">
            <?php echo HBHtml::select(HBParams::get('gender','arrayObject'), 'gender', 'class="form-control filterCss"', 'value', 'text',$input->get('gender'),'gender','------ Chọn giới tính -----');?>
            <?php echo HBHtml::select(HBParams::get_provinces(), 'province_id', 'class="form-control filterCss"', 'maqh', 'name',$input->get('province_id'),'province_id','------ Quận/Huyện -----');?>
           
        </div>
        <div class="col medium-3">
            <button type="submit" class="button  " >Tìm kiếm</button>
        </div>
    </div>
</form>
</div>