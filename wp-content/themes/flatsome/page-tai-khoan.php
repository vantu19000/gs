<?php

wp_enqueue_script('jquery-ui-datepicker');
wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
HBImporter::helper('params','html');
$districts = HBParams::get_districts();
global $wpdb;

$user = wp_get_current_user();

    if (!in_array('subscriber', $user->roles)){
        return wp_redirect(site_url());
    }

get_header();

$meta = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}hbpro_users WHERE user_id = " . $user->ID)[0];
$recent_subject = explode(",", $meta->subject_id);
wp_create_nonce();
$subject = HBParams::get_subject_type();
$recent_province_id = explode(",", $meta->province_id);
$class = explode(",", $meta->class_type);

$quanhuyen = $wpdb->get_results("SELECT * FROM devvn_quanhuyen WHERE matp = " . $meta->district_id);

$degree = HBParams::get_degree_type();
$expertype = HBParams::get_exp_type();

//echo "<pre>";
//print_r($quanhuyen);
//die;

?>

<script src="https://giasutriviet.edu.vn/wp-content/themes/flatsome/assets/tinymce/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>


    <div id="taikhoan" style="margin: 20px">

        <nav id="nav-1">
            <a class="link-1" href="#">Cập nhật hồ sơ</a>
            <a class="link-1" href="#" id="myBtn">Thay đổi hình đại diện</a>
        </nav>

        <div class="container" id="updateprofile">
            <form action="?hbaction=user&task=updateProfile" method="POST">
                <div class="form-group row">
                    <label class="col-xs-3 col-form-label" for="username">Tên đăng nhập<span class="text-danger">*</span></label>
                    <div class="col-xs-9">
                        <input class="form-control input-medium required" readonly required type="text" id="username"
                               value="<?php echo $user->user_login  ?>" name="teacher[username]" maxlength="150" />
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-xs-3 col-form-label" for="email">Email<span class="text-danger">*</span></label>
                    <div class="col-xs-9">
                        <input class="form-control input-medium" type="email" id="email"
                               value="<?php echo $meta->email  ?>" name="teacher[email]"  />
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-xs-3 col-form-label" for="full_name">Họ tên<span class="text-danger">*</span></label>
                    <div class="col-xs-9">
                        <input class="form-control input-medium required name" required type="text" id="full_name"
                               value="<?php echo $meta->full_name  ?>" name="teacher[full_name]" maxlength="150" />
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-xs-3 col-form-label" for="birthday">Ngày sinh<span class="text-danger">*</span></label>
                    <div class="col-xs-9">
                        <?php echo HBHtml::calendar($meta->birthday, 'teacher[birthday]','birthday','yy-mm-dd','readonly class="form-control input-medium required name" required',array('changeMonth'=>true,'changeYear'=>true))?>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-xs-3 col-form-label">Giới tính<span class="text-danger">*</span></label>
                    <div class="col-xs-9">
                        <input class="required" required type="radio" id="gender_m"
                               <?php if ($meta->gender == 'M') echo 'checked';  ?> name="teacher[gender]" value="M" /><label for="gender_m"> Nam</label>
                        <input class="required" required type="radio" id="gender_f"
                               <?php if ($meta->gender == 'F') echo 'checked'; ?> name="teacher[gender]" value="F" /><label for="gender_f"> Nữ</label>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-xs-3 col-form-label" for="mobile">Số điện thoại<span class="text-danger">*</span></label>
                    <div class="col-xs-9">
                        <input class="form-control input-medium required" type="text" required id="mobile"
                               value="<?php echo $meta->mobile; ?>" name="teacher[mobile]"  />
                    </div>
                </div>


                <div class="form-group row">
                    <label class="col-xs-3 col-form-label" for="address">Địa chỉ<span class="text-danger">*</span></label>
                    <div class="col-xs-9">
                        <input class="form-control input-medium required" type="text" required id="address"
                               value="<?php echo $meta->address ?>" name="teacher[address]"  />
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-xs-3 col-form-label" for="full_name">Trình độ<span class="text-danger">*</span></label>
                    <div class="col-xs-9">
                        <select name="teacher[exp_type]">

                            <?php foreach ($expertype AS $key => $value): ?>
                                <option value="<?php echo $key ?>" <?php if ($meta->exp_type == $key) echo 'selected'; ?>><?php echo $value; ?></option>
                            <?php endforeach; ?>

                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-xs-3 col-form-label" for="degree_type">Học vấn<span class="text-danger">*</span></label>
                    <div class="col-xs-9">
                        <div class="form-group">
                            <select class="form-control" name="teacher[degree_type]" id="degree_type">
                                <?php foreach ($degree AS $key => $value): ?>
                                <option value="<?php echo $key ?>"><?php echo $value ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-xs-3 col-form-label" for="time">Các lớp<span class="text-danger">*</span></label>
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
                                name="teacher[class_type][]"
                                id="class<?php echo $i ?>">
                        <label for="class<?php echo $i ?>"><?php echo "Lớp ". $i; ?></label>
                        <?php endfor; ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-xs-3 col-form-label" for="time">Thời gian dạy<span class="text-danger">*</span></label>
                    <div class="col-xs-9">
                        <input class="form-control input-medium required" type="text" required id="time"
                               value="<?php echo $meta->time; ?>" name="teacher[time]"  />
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-xs-3 col-form-label" for="subject_id">Các môn dạy<span class="text-danger">*</span></label>
                    <div class="col-xs-9">

                        <?php foreach ($subject AS $key => $value):?>
                            <input
                                    type="checkbox"
                                    name="teacher[subject_id][]"
                                    <?php
                                        if (in_array($key, $recent_subject)){
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
                    <label class="col-xs-3 col-form-label" for="salary">Mức lương / Tháng<span class="text-danger">*</span></label>
                    <div class="col-xs-9">
                        <input class="form-control input-medium required" type="text" required id="salary"
                               value="<?php echo $meta->salary ?>" name="teacher[salary]"  />
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-xs-3 col-form-label" for="district_id">Khu vực gia sư<span class="text-danger">*</span></label>
                    <div class="col-xs-9">
                        <select name="teacher[district_id]" id="district_id">
                            <?php
                            foreach ($districts AS $key => $value):
                                if ($value->matp == $meta->district_id):
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
                                name="teacher[province_id][]"
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
                    <label class="col-xs-3 col-form-label" for="excerpt">Sơ lược về bạn<span class="text-danger">*</span></label>
                    <div class="col-xs-9">
                        <textarea rows="4" cols="50" name="teacher[excerpt]" id="excerpt"><?php echo $wpdb->excerpt ?>
                            <?php echo $meta->excerpt ?>
                        </textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-xs-3 col-form-label" for="desc">Giới thiệu thêm<span class="text-danger">*</span></label>
                    <div class="col-xs-9">
                        <textarea rows="4" cols="50" name="teacher[desc]" id="desc">
                            <?php echo $meta->desc ?>
                        </textarea>
                    </div>
                </div>
<br>
                <div class="form-group row">
                    <label>ⓘ Vui Lòng điền đầy đủ thông tin và ảnh đại diện</label>
                </div>

                <center><button type="submit" class="button">CẬP NHẬT</button></center>

            </form>

        </div>

    </div>



<div id="myModal" class="modal">

    <div class="modal-content">
        <div class="modal-header">
            <span class="close">&times;</span>
            <h4>Cập nhật avatar</h4>
        </div>
        <div class="modal-body" style="margin: 20px">


            <div class="form-group row">

                <div class="col medium-6">
                    <form action="?hbaction=user&task=avatar" id="formavatar" method="POST" enctype="multipart/form-data">
                        <input type="hidden" value="<?php echo $meta->id; ?>" name="userid">
                        <input type="file" name="fileToUpload" id="fileToUpload">
                        <br>
                        <input class="button" type="submit" value="Upload" name="submit">
                    </form>
                </div>
                <div class="col medium-6">
                    <img src="<?php echo site_url().$meta->icon ?>" width="150px" height="150px">
                </div>
            </div>

        </div>
        <div class="modal-footer" style="height: 10px">

        </div>
    </div>

</div>



<?php get_footer(); ?>


<style>
    nav {
        margin-top: 40px;
        padding: 24px;
        text-align: center;
        font-family: Raleway;
        box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
    }
    #nav-1 {
        background: #3fa46a;
    }
    .link-1 {
        transition: 0.3s ease;
        background: #3fa46a;
        color: #ffffff;
        font-size: 20px;
        text-decoration: none;
        border-top: 4px solid #3fa46a;
        border-bottom: 4px solid #3fa46a;
        padding: 20px 0;
        margin: 0 20px;
    }
    .link-1:hover {
        border-top: 4px solid #ffffff;
        border-bottom: 4px solid #ffffff;
        padding: 6px 0;
    }
    #updateprofile{
        margin-top: 30px;
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
    // Get the modal
    var modal = document.getElementById('myModal');

    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");

    // Get the <span> element that closes the modal
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

<style>
    #ui-datepicker-div{
        background-color: #3FA46A;
    }
</style>