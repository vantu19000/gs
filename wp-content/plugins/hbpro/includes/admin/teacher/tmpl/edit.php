<?php
$sub = explode(',',$this->item->subject_id);
$class = explode(",", $this->item->class_type);

require_once (get_home_path(). '/wp-content/plugins/hbpro/includes/helpers/params.php');
$param = new HBParams();

$subject = $param::get_subject_type();
$classtype = $param::get_class_type();

?>

<h1>Quản lí gia sư <a href="<?php echo admin_url('admin.php?page=teacher')?>" class="page-title-action" >Quay lại</a></h1>
<div id="primary" class="content-area wrap">
	<form action="<?php echo admin_url('admin-post.php?action=hbaction&hbaction=teacher&task=save')?>" method="post">
		<div class="">
			<div class="form-group row">
				<label class="col-xs-3 col-form-label">Họ tên<span class="text-danger">*</span></label>
				<div class="col-xs-9">
					<input class="regular-text code" required type="text" id="full_name"
						name="data[full_name]" maxlength="150" value="<?php echo $this->item ? $this->item->full_name : ''?>"/>
				</div>
			</div>
			
			<div class="form-group row">
				<label class="col-xs-3 col-form-label">Ngày sinh<span class="text-danger">*</span></label>
				<div class="col-xs-9">
					<?php echo HBHtml::calendar($this->item ? $this->item->birthday : '', 'data[birthday]','birthday','yy-mm-dd','readonly class="regular-text code" required',array('changeMonth'=>true,'changeYear'=>true))?>
				</div>
			</div>
			
			<div class="form-group row">
				<label class="col-xs-3 col-form-label">Giới tính<span class="text-danger">*</span></label>
				<div class="col-xs-9">
					<input class="required" required type="radio" id="gender_m"
						name="data[gender]" value="M" <?php if ($this->item->gender == "M") echo "checked"; ?> />Nam
						<input class="required" required type="radio" <?php if ($this->item->gender == "F") echo "checked"; ?> id="gender_f"
						name="data[gender]" value="F" />Nữ
				</div>
			</div>
			
			<div class="form-group row">
				<label class="col-xs-3 col-form-label">Số điện thoại<span class="text-danger">*</span></label>
				<div class="col-xs-9">
					<input class="regular-text code" type="mobile" required id="parent_mobile"
						name="data[mobile]" value="<?php echo $this->item->mobile?>"  />
				</div>
			</div>
			
			<div class="form-group row">
				<label class="col-xs-3 col-form-label">Email<span class="text-danger">*</span></label>
				<div class="col-xs-9">
					<input class="regular-text code" type="email" id="parent_email"
						name="data[email]"  value="<?php echo $this->item->email?>"/>
				</div>
			</div>
			
			<div class="form-group row">
				<label class="col-xs-3 col-form-label">Địa chỉ<span class="text-danger">*</span></label>
				<div class="col-xs-9">
					<input class="regular-text code" required value="<?php echo $this->item->address?>" type="text" id="parent_address" name="data[address]">
				</div>
			</div>

            <div class="form-group row">
                <label class="col-xs-3 col-form-label">Các môn<span class="text-danger">*</span></label>
                <div class="col-xs-9">
                    <?php
                    foreach ($sub AS $value){
                        echo $subject[$value] . ", ";
                    }
                    ?>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-xs-3 col-form-label">Các lớp<span class="text-danger">*</span></label>
                <div class="col-xs-9">
                    <?php
                    foreach ($class AS $value){
                        echo $classtype[$value] . ", ";
                    }
                    ?>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-xs-3 col-form-label">Tóm tắt<span class="text-danger">*</span></label>
                <div class="col-xs-9">
                    <?php
                        echo $this->item->excerpt;
                    ?>
                </div>
            </div>


            <div class="form-group row">
                <label class="col-xs-3 col-form-label">Giới thiệu thêm<span class="text-danger">*</span></label>
                <div class="col-xs-9">
                    <?php
                    echo $this->item->desc;
                    ?>
                </div>
            </div>
			
			<input type="hidden" value="<?php echo $this->input->get('id')?>" name="id"/>
			
			
		</div>
		<?php wp_nonce_field( 'hb_action', 'hb_meta_nonce' );?>
	</form>
	
</div><!-- #primary -->

<style>
    label{
        font-weight: bold;
    }
</style>