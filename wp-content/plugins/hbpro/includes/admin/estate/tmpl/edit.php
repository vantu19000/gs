<?php
	HBImporter::helper('estate');
	HBHtml::add_datepicker_lib();
	if($this->item){
		$images = HBEstateHelper::get_estate_images($this->item->id);
	}
?>

<div id="poststuff" class="">
	<div id="post-body" class="metabox-holder columns-2">
		<div class="post-body-content" style="position: relative;">
			<form action="<?php echo admin_url('admin-post.php?action=hbaction&hbaction=estate&task=save')?>" method="post" style="width:70%;margin: 10px auto;">
				<div class="">
					<div class="form-group row">
						<label class="col-xs-3 col-form-label"><?php echo __('Name','hbpro')?><span class="text-danger">*</span></label>
						<div class="col-xs-9">
							<input class="form-control input-medium required name" required type="text" id="name"
								name="data[name]" maxlength="150" value="<?php echo $this->item ? $this->item->name : ''?>"/>
						</div>
					</div>			
					
					<div class="form-group row">
						<label class="col-xs-3 col-form-label">Chi tiết<span class="text-danger">*</span></label>
						<div class="col-xs-9">
							<textarea class="form-control input-medium required" required  type="text" id="parent_address" name="data[description]" rows="6"><?php echo $this->item ? $this->item->description : ''?></textarea>
						</div>
					</div>
				
					<div class="form-group row">
						<label class="col-xs-3 col-form-label">Địa chỉ<span class="text-danger">*</span></label>
						<div class="col-xs-9">
							<textarea class="form-control input-medium required" required  type="text" id="parent_address" name="data[address]" rows="6"><?php echo $this->item ? $this->item->address : ''?></textarea>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-xs-3 col-form-label"><?php echo __('Tọa độ','hbpro')?><span class="text-danger">*</span></label>
						<div class="col-xs-9">
							Longtitude<input class="form-control input-medium required name" required type="text" id="name"
								name="data[longitude]" maxlength="150" value="<?php echo $this->item ? $this->item->longitude : ''?>"/>
							latitude<input class="form-control input-medium required name" required type="text" id="name"
								name="data[latitude]" maxlength="150" value="<?php echo $this->item ? $this->item->latitude : ''?>"/>
						</div>
					</div>	
					
					<div class="form-group row">
						<label class="col-xs-3 col-form-label">Ngày khởi công<span class="text-danger">*</span></label>
						<div class="col-xs-9">
							<?php echo HBHtml::calendar($this->item ? $this->item->date_start : '', 'data[date_start]','date_start','yy-mm-dd','readonly class="form-control input-medium required name" required',array('changeMonth'=>true,'changeYear'=>true))?>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-xs-3 col-form-label">Ngày hoàn thiện<span class="text-danger">*</span></label>
						<div class="col-xs-9">
							<?php echo HBHtml::calendar($this->item ? $this->item->deadline : '', 'data[deadline]','deadline','yy-mm-dd','readonly class="form-control input-medium required name" required',array('changeMonth'=>true,'changeYear'=>true))?>
						</div>
					</div>
					
					<input type="hidden" value="<?php echo $this->input->get('id')?>" name="id"/>
					
					
				</div>
				<?php wp_nonce_field( 'hb_action', 'hb_meta_nonce' );?>
				<center><button type="submit" class="btn btn-primary btn-lg"><?php echo $this->item ? __('Save','hbpro') : __('Add new','hbpro')?></button></center>
				<div id="postbox-container-1" class="postbox-container">
					<?php HBHtml::media_select('image','upload_image')?>
				</div>
			</form>
		</div>
		
	</div>
	
	
	
	
</div><!-- #primary -->
