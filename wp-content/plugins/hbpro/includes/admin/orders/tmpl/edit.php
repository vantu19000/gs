<?php
?>
<h1>Quản lí đơn <a href="<?php echo admin_url('admin.php?page=hb_dashboard')?>" class="page-title-action" >Quay lại</a></h1>
<div id="primary" class="content-area wrap">
	<form action="<?php echo admin_url('admin-post.php?action=hbaction&hbaction=order&task=save')?>" method="post" style="width:70%;margin: 10px auto;">
		<div class="">
			<div class="form-group row">
				<label class="col-xs-3 col-form-label">Họ tên<span class="text-danger">*</span></label>
				<div class="col-xs-9">
					<input class="form-control input-medium required name" required type="text" id="name"
						name="data[name]" maxlength="150" value="<?php echo $this->item ? $this->item->name : ''?>"/>
				</div>
			</div>
			
			<div class="form-group row">
				<label class="col-xs-3 col-form-label">Trạng thái<span class="text-danger"></span></label>
				<div class="col-xs-9">
					<input class="required" required type="radio" name="data[order_status]" value="M" />Chưa xử lí
						<input class="required" required type="radio" name="data[order_status]" value="F" />Đã xử lí
				</div>
			</div>
						
			<div class="form-group row">
				<label class="col-xs-3 col-form-label">Giới tính<span class="text-danger">*</span></label>
				<div class="col-xs-9">
					<input class="required" required type="radio" id="gender_m"
						name="data[gender]" value="M" />Nam
						<input class="required" required type="radio" id="gender_f"
						name="data[gender]" value="F" />Nữ
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
				<label class="col-xs-3 col-form-label">Địa chỉ<span class="text-danger">*</span></label>
				<div class="col-xs-9">
					<textarea class="form-control input-medium required" required value="<?php echo $this->item->address?>" type="text" id="parent_address" name="data[address]" rows="6"></textarea>
				</div>
			</div>
			
			<div class="form-group row">
				<label class="col-xs-3 col-form-label">Nội dung</label>
				<div class="col-xs-9">
					<textarea class="form-control" required value="<?php echo $this->item->notes?>" type="text" id="" name="data[notes]" rows="6"></textarea>
				</div>
			</div>
			
			<input type="hidden" value="<?php echo $this->input->get('id')?>" name="id"/>
			
			
		</div>
		<?php wp_nonce_field( 'hb_action', 'hb_meta_nonce' );?>
		<center><button type="submit" class="btn btn-primary btn-lg">Lưu</button></center>
	</form>
	
</div><!-- #primary -->