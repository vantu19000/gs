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
array_unshift($degree_types, (object)array('value'=>'','text'=>'------ Học vấn -----'));

$subject_types = HBParams::get('subject_type','arrayObject');
array_unshift($subject_types, (object)array('value'=>'','text'=>'------ Chọn môn học -----'));

$districts = HBParams::get_districts();
array_unshift($districts, (object)array('matp'=>'','name'=>'------ Chọn thành phố -----'));

$exp_type = HBParams::get_exp_type();
$exp_types = HBParams::get('exp_type','arrayObject');
array_unshift($exp_types, (object)array('value'=>'','text'=>'------ Trình độ -----'));

// debug($class_types);
?>

	

	<form method="get" class="searchform" action="<?php echo site_url('/danh-sach-gia-su/') ?>" role="search" style="margin-top:30px;">
	    <div class="row filterBox">
	        <div class="col medium-3">
	            <?php echo HBHtml::select($class_types, 'class_type', 'class="form-control filterCss"', 'value', 'text',$input->get('class_type'));?>
	            <?php echo HBHtml::select($exp_types, 'exp_type', 'class="form-control filterCss"', 'value', 'text',$input->get('exp_type'));?>
	        </div>
	        <div class="col medium-3">
	        	<?php echo HBHtml::select($subject_types, 'subject_type', 'class="form-control filterCss"', 'value', 'text',$input->get('subject_type'));?>
	        	<?php echo HBHtml::select($districts, 'district_id', 'class="form-control filterCss" id="district_id"', 'matp', 'name',$input->get('district_id'));?>
	        </div>
	        <div class="col medium-3">
	            <?php echo HBHtml::select(HBParams::get('gender','arrayObject'), 'gender', 'class="form-control filterCss"', 'value', 'text',$input->get('gender'),'gender','------ Chọn giới tính -----');?>
	            <?php echo HBHtml::select(HBParams::get_provinces(), 'province_id', 'class="form-control filterCss" id="province_id"', 'maqh', 'name',$input->get('province_id'),'province_id','------ Quận/Huyện -----');?>
	           
	        </div>
	        <div class="col medium-3">
	            <button type="submit" class="button  " >Tìm kiếm</button>
	        </div>
	    </div>
	</form>


<script>
    jQuery(document).ready(function($){

        $("#district_id").change(function () {

            tinh = $("#district_id").val();

            $.ajax({
                url: "<?php echo site_url('index.php?hbaction=order&task=provinceAjax')?>",
                data: {province: tinh},
                type: "POST",
                success: function(data, status){
                    console.log(data);
                    // $("body").html(data);
                    $("#province_id").html(data);
                },
            });

        });
    });
</script>