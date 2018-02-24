<?php
global $wpdb;

wp_enqueue_script('jquery-ui-datepicker');
wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
$sub = explode(',',$this->item->subject_id);
$class = explode(",", $this->item->class_type);

require_once (get_home_path(). '/wp-content/plugins/hbpro/includes/helpers/params.php');
$param = new HBParams();

$subject = $param::get_subject_type();
$classtype = $param::get_class_type();
$expertype = HBParams::get_exp_type();
$degree = HBParams::get_degree_type();
$districts = HBParams::get_districts();
try{
    $quanhuyen = $wpdb->get_results("SELECT * FROM devvn_quanhuyen WHERE matp = " . $this->item->district_id);
}catch (Exception $ee){

}
$recent_province_id = explode(",", $this->item->province_id);
?>

<script src="https://giasutriviet.edu.vn/wp-includes/js/jquery/jquery.js"></script>

<script src="https://giasutriviet.edu.vn/wp-content/themes/flatsome/assets/tinymce/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>

<h1>Quản lí gia sư <a href="<?php echo admin_url('admin.php?page=teacher')?>" class="page-title-action" >Quay lại</a></h1>

<div id="primary" class="content-area wrap">
	<form action="<?php echo admin_url('admin-post.php?action=hbaction&hbaction=teacher&task=save')?>" method="post">
		<div class="">


            <div class="form-group row">
                <label class="col-xs-3 col-form-label">Ảnh đại diện<span class="text-danger"></span></label>
                <div class="col-xs-9">
                    <?php if ($this->item->icon): ?>
                    <img src="<?php echo $this->item->icon . '?' . rand(1000,99999); ?>" height="100px" width="100px">
                    <?php else: ?>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/1/1e/Default-avatar.jpg" height="100px" width="100px">
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-group row">
                <a class="link-1" href="#" id="myBtn">Thay đổi hình đại diện</a>
                <br>
                <br>
            </div>


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
                <label class="col-xs-3 col-form-label" for="full_name">Trình độ<span class="text-danger">*</span></label>
                <div class="col-xs-9">
                    <select name="data[exp_type]">

                        <?php foreach ($expertype AS $key => $value): ?>
                            <option value="<?php echo $key ?>" <?php if ($this->item->exp_type == $key) echo 'selected'; ?>><?php echo $value; ?></option>
                        <?php endforeach; ?>

                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-xs-3 col-form-label" for="degree_type">Học vấn<span class="text-danger">*</span></label>
                <div class="col-xs-9">
                    <div class="form-group">
                        <select class="form-control" name="data[degree_type]" id="degree_type">
                            <?php foreach ($degree AS $key => $value): ?>
                                <option value="<?php echo $key ?>"><?php echo $value ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-xs-3 col-form-label">Các môn<span class="text-danger">*</span></label>
                <div class="col-xs-9">

                    <?php foreach ($subject AS $key => $value):?>
                        <input
                                type="checkbox"
                                name="data[subject_id][]"
                            <?php
                            if (in_array($key, $sub)){
                                echo "checked";
                            }
                            ?>
                                id="subject<?php echo $key ?>"
                                value="<?php echo $key ?>">
                        <label for="subject<?php echo $key ?>" style="margin-right: 10px;"><?php echo $value; ?></label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-xs-3 col-form-label">Các lớp<span class="text-danger">*</span></label>
                <div class="col-xs-9">

                    <?php for ($i = 1; $i < 13; $i ++): ?>
                        <input
                            <?php
                            if (in_array($i, $class)){
                                echo "checked";
                            }
                            ?>
                                type="checkbox"
                                value="<?php echo $i; ?>"
                                name="data[class_type][]"
                                id="class<?php echo $i ?>">
                        <label for="class<?php echo $i ?>"><?php echo "Lớp ". $i; ?></label>
                    <?php endfor; ?>

                </div>
            </div>

            <div class="form-group row">
                <label class="col-xs-3 col-form-label" for="district_id">Khu vực gia sư<span class="text-danger">*</span></label>
                <div class="col-xs-9">
                    <select name="data[district_id]" id="district_id">
                        <?php
                        foreach ($districts AS $key => $value):
                            if ($value->matp == $this->item->district_id):
                                ?>
                                <option value="<?php echo $value->matp; ?>" selected><?php echo $value->name ?></option>
                            <?php
                            else:?>
                                <option value="<?php echo $value->matp; ?>"><?php echo $value->name ?></option>

                            <?php endif; endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-xs-3 col-form-label" for="khuvuc">Khu vực gia sư (quận/huyện)<span class="text-danger"></span></label>
                <div class="col-xs-9" id="khuvuc">
                    <?php foreach ($quanhuyen AS $value): ?>

                        <input
                                name="data[province_id][]"
                            <?php
                            if (in_array($value->maqh, $recent_province_id)){
                                echo "checked";
                            }
                            ?>
                                id="khuvuc<?php echo $value->maqh; ?>"
                                type="checkbox"
                                value="<?php echo $value->maqh ?>">
                        <label for="khuvuc<?php echo $value->maqh; ?>"><?php echo $value->name; ?></label>

                    <?php endforeach; ?>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-xs-3 col-form-label" for="salary">Mức lương/Tháng<span class="text-danger">*</span></label>
                <div class="col-xs-9">
                    <input class="form-control input-medium required" type="text" required id="salary"
                           value="<?php echo $this->item->salary ?>" name="data[salary]"  />
                </div>
            </div>

            <div class="form-group row">
                <label class="col-xs-3 col-form-label">Tóm tắt<span class="text-danger">*</span></label>
                <div class="col-xs-9">
                    <textarea rows="4" cols="50" name="data[excerpt]" id="excerpt">
                        <?php echo $this->item->excerpt; ?>
                    </textarea>
                </div>
            </div>


            <div class="form-group row">
                <label class="col-xs-3 col-form-label">Giới thiệu thêm<span class="text-danger">*</span></label>
                <div class="col-xs-9">
                    <textarea rows="4" cols="50" name="data[desc]" id="desc">
                            <?php echo $this->item->desc ?>
                    </textarea>
                </div>
            </div>
			
			<input type="hidden" value="<?php echo $this->input->get('id')?>" name="id"/>

		</div>

		<?php wp_nonce_field( 'hb_action', 'hb_meta_nonce' );?>

        <input type="submit" class="dops-button" value="Save">

	</form>
	
</div><!-- #primary -->


<div id="myModal" class="modal">

    <div class="modal-content">
        <div class="modal-header">
            <span class="close">&times;</span>
            <h4>Cập nhật avatar</h4>
        </div>
        <div class="modal-body" style="margin: 20px">


            <div class="form-group row">

                <div class="col medium-6">
                    <form action="<?php echo admin_url('admin-post.php?action=hbaction&hbaction=teacher&task=avatar')?>" id="formavatar" method="POST" enctype="multipart/form-data">
                        <input type="hidden" value="<?php echo $this->item->id; ?>" name="userid">
                        <input type="file" name="fileToUpload" id="fileToUpload">
                        <br>
                        <?php wp_nonce_field( 'hb_action', 'hb_meta_nonce' );?>
                        <input class="button" type="submit" value="Upload" name="submit">
                    </form>
                </div>
            </div>

        </div>
        <div class="modal-footer" style="height: 10px">

        </div>
    </div>

</div>



<style>
    label{
        font-weight: bold;
    }
    #ui-datepicker-div{
        background-color: white;
    }
</style>

<style>
    /* The Modal (background) */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 100px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        z-index: 998110100;
    }

    /* Modal Content */
    .modal-content {
        position: relative;
        background-color: #fefefe;
        margin: auto;
        padding: 0;
        border: 1px solid #888;
        width: 80%;
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
        -webkit-animation-name: animatetop;
        -webkit-animation-duration: 0.4s;
        animation-name: animatetop;
        animation-duration: 0.4s
    }

    /* Add Animation */
    @-webkit-keyframes animatetop {
        from {top:-300px; opacity:0}
        to {top:0; opacity:1}
    }

    @keyframes animatetop {
        from {top:-300px; opacity:0}
        to {top:0; opacity:1}
    }

    /* The Close Button */
    .close {
        color: white;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }

    .modal-header {
        padding: 2px 16px;
        background-color: #5cb85c;
        color: white;
    }

    .modal-body {padding: 2px 16px;}

    .modal-footer {
        padding: 2px 16px;
        background-color: #5cb85c;
        color: white;
    }
    label {
        font-weight: normal;
    }
</style>


<script>
    jQuery(document).ready(function($){

        $("#district_id").change(function () {

            tinh = $("#district_id").val();
            huyen = "<?php echo $meta->province_id; ?>";

            $.ajax({
                url: "<?php echo site_url('index.php?hbaction=order&task=provinceAjaxCheckbox')?>",
                data: {province: tinh, recent: huyen},
                type: "POST",
                success: function(data, status){
                    $("#khuvuc").html(data);
                },
            });

        });
    });
</script>

<script>
    // Get the modal
    var modal = document.getElementById('myModal');

    var btn = document.getElementById("myBtn");

    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>