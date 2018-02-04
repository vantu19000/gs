<?php

wp_enqueue_script('jquery-ui-datepicker');
wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');

    global $wpdb;
    get_header();
    $user = wp_get_current_user();

//    if (in_array('subscriber', $user->roles)){
//        echo "ok";
//    }else{
//        echo "bạn không có quyền xem trang này";
//    }

    $meta = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}hbpro_users WHERE user_id = " . $user->id)[0];

HBImporter::helper('params','html');
$districts = HBParams::get_districts();

wp_create_nonce();

//    echo '<pre>';
//    print_r($districts);
//    die;
?>
<script src="http://127.0.0.1:9981/vanTU/01_2018_giasutriviet/wp-content/themes/flatsome/assets/tinymce/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>


    <div id="taikhoan">
        <nav id="nav-1">
            <a class="link-1" href="#">Cập nhật hồ sơ</a>
            <a class="link-1" href="#">Thay mật khẩu</a>
        </nav>

        <div class="container" id="updateprofile">
            <form action="?hbaction=user&task=updateProfile" method="POST">
                <div class="form-group row">
                    <label class="col-xs-3 col-form-label" for="username">Tên đăng nhập<span class="text-danger">*</span></label>
                    <div class="col-xs-9">
                        <input class="form-control input-medium required" required type="text" id="username"
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
                            <option value="0" <?php if ($meta->exp_type == 0) echo 'selected'; ?>>Giáo viên chuyên nghiệp</option>
                            <option value="1" <?php if ($meta->exp_type == 1) echo 'selected'; ?>>Gia sư cộng đồng</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-xs-3 col-form-label" for="degree_type">Học vấn<span class="text-danger">*</span></label>
                    <div class="col-xs-9">
                        <div class="form-group">
                            <select class="form-control" name="teacher[degree_type]" id="degree_type">
                                <option value="1">Đại học</option>
                                <option value="2">Sinh viên</option>
                                <option value="3">Cử nhân</option>
                                <option value="4">Kỹ sư</option>
                            </select>
                        </div>
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

                        <select class="form-control" id="subject_id">
                            <option value="1">Toán</option>
                            <option value="2">Lý</option>
                            <option value="3">Hóa</option>
                            <option value="4">Văn</option>
                        </select>

                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-xs-3 col-form-label" for="salary">Mức lương<span class="text-danger">*</span></label>
                    <div class="col-xs-9">
                        <input class="form-control input-medium required" type="text" required id="salary"
                               value="<?php echo $meta->salary ?>" name="teacher[salary]"  />
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-xs-3 col-form-label" for="province_id">Khu vực gia sư<span class="text-danger">*</span></label>
                    <div class="col-xs-9">
                        <select name="teacher[province_id]">
                            <?php
                            foreach ($districts AS $key => $value):
                                if ($value->matp == $meta->province_id):
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

                <button type="submit" class="btn btn-primary btn-lg">Đăng kí</button>

            </form>

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