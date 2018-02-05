<?php $item = reset($this->items) ?>

<h1>Quản lí đơn <a href="<?php echo admin_url('admin.php?page=hb_dashboard')?>" class="page-title-action" >Quay lại</a></h1>

<div id="primary" class="container">
	<form action="<?php echo admin_url('admin-post.php?action=hbaction&hbaction=orders&task=save')?>" method="post">
        <input type="hidden" value="<?php echo $this->input->get('id')?>" name="id"/>

            <div class="row">
                <div class="col-md-12">
                    <input type="text" value="<?php echo $item->name ?>" name="data[name]" class="regular-text ltr">
                </div>
                <div class="col-md-12">
                    <input type="text" value="<?php echo $item->mobile ?>" name="data[mobile]" class="regular-text ltr">
                </div>
                <div class="col-md-12">
                    <input type="email" value="<?php echo $item->email ?>" name="data[email]" class="regular-text ltr">
                </div>
                <div class="col-md-12">
                    <textarea type="text" name="data[notes]" class="regular-text ltr"><?php echo $item->notes ?></textarea>
                </div>
                <div class="col-md-12">
                    <input id="rad1" type="radio" name="data[order_status]" value="0" <?php if ($item->order_status == 0) echo 'checked'; ?> > <label for="rad1">Chưa xử lý</label> <br>
                    <input id="rad2" type="radio" name="data[order_status]" value="1" <?php if ($item->order_status == 1) echo 'checked'; ?>> <label for="rad2">Đã xử lý</label> <br>
                </div>
                <br>
                <div class="col-md-12">
                    <Button id="Edit" class="button action">Lưu</Button>
                </div>
            </div>


		<?php wp_nonce_field( 'hb_action', 'hb_meta_nonce' );?>
		<center><button type="submit" class="btn btn-primary btn-lg">Lưu</button></center>
	</form>
	
</div><!-- #primary -->
