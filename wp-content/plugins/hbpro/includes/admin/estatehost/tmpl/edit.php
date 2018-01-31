<?php
?>

<div id="primary" class="content-area wrap">
	<form action="<?php echo admin_url('admin-post.php?action=hb_execute_action&hb_admin_action=teacher&task=save')?>" method="post" style="width:70%;margin: 10px auto;">
		<div class="">
			<div class="form-group row">
				<label class="col-xs-3 col-form-label">Tên chủ đầu tư<span class="text-danger">*</span></label>
				<div class="col-xs-9">
					<input class="form-control input-medium required name" required type="text" id="name"
						name="data[name]" maxlength="150" value="<?php echo $this->item ? $this->item->name : ''?>"/>
				</div>
			</div>
						
			<div class="form-group row">
				<label class="col-xs-3 col-form-label">Số điện thoại<span class="text-danger">*</span></label>
				<div class="col-xs-9">
					<input class="form-control input-medium required" type="phone" required id="parent_phone"
						name="data[phone]" value="<?php echo $this->item->phone?>"  />
				</div>
			</div>
			
			<div class="form-group row">
				<label class="col-xs-3 col-form-label">Email<span class="text-danger">*</span></label>
				<div class="col-xs-9">
					<input class="form-control input-medium" type="email" id="parent_email"
						name="data[email]"  value="<?php echo $this->item->email?>"/>
				</div>
			</div>
			
			<div class="form-group row">
				<label class="col-xs-3 col-form-label">Giới thiệu<span class="text-danger">*</span></label>
				<div class="col-xs-9">
					<textarea class="form-control input-medium required" required value="<?php echo $this->item->description?>" type="text" id="parent_address" name="data[description]" rows="6"></textarea>
				</div>
			</div>
			
			<input type="hidden" value="<?php echo $this->input->get('id')?>" name="id"/>
			
			
		</div>
		<?php wp_nonce_field( 'hb_action', 'hb_meta_nonce' );?>
		<center><button type="submit" class="btn btn-primary btn-lg"><?php echo $this->item ? __('Save','hbpro') : __('Add new','hbpro')?></button></center>
	</form>
	
</div><!-- #primary -->
