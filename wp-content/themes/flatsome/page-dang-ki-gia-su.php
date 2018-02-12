<?php
/**
 * The template for displaying tin tuc page
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package woafun
 */
wp_enqueue_script('jquery-ui-datepicker');
wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
get_header();
?>

<div id="dangkygiasu" class="content-area">
    <!-- Tin moi -->
    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <center><h2>Đăng ký làm gia sư</h2></center>
                <form action="index.php?hbaction=user&task=registerteacher" method="post" style="width:70%;margin: 10px auto;">
                    <div class="">

                        <div class="form-group row">
                            <label class="col-xs-3 col-form-label" for="username">Tên đăng nhập<span class="text-danger">*</span></label>
                            <div class="col-xs-9">
                                <input class="form-control input-medium required" required type="text" id="username"
                                       name="username" maxlength="150" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-xs-3 col-form-label" for="email">Email<span class="text-danger">*</span></label>
                            <div class="col-xs-9">
                                <input class="form-control input-medium" type="email" id="email"
                                       name="teacher[email]"  />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-xs-3 col-form-label" for="password">Mật khẩu<span class="text-danger">*</span></label>
                            <div class="col-xs-9">
                                <input class="form-control input-medium" type="password" id="password"
                                       name="password"  />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-xs-3 col-form-label" for="re_password">Nhập lại Mật khẩu<span class="text-danger">*</span></label>
                            <div class="col-xs-9">
                                <input class="form-control input-medium" type="password" id="re_password"
                                       name="re_password"  />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-xs-3 col-form-label" for="full_name">Họ tên<span class="text-danger">*</span></label>
                            <div class="col-xs-9">
                                <input class="form-control input-medium required name" required type="text" id="full_name"
                                       name="teacher[full_name]" maxlength="150" />
                            </div>
                        </div>

                        <!--
                            <div class="form-group row">
                                <label class="col-xs-3 col-form-label" for="birthday">Ngày sinh<span class="text-danger">*</span></label>
                                <div class="col-xs-9">
                                    <?php echo HBHtml::calendar('', 'teacher[birthday]','birthday','yy-mm-dd','readonly class="form-control input-medium required name" required',array('changeMonth'=>true,'changeYear'=>true))?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-xs-3 col-form-label">Giới tính<span class="text-danger">*</span></label>
                                <div class="col-xs-9">
                                    <input class="required" required type="radio" id="gender_m"
                                           name="teacher[gender]" value="M" /><label for="gender_m"> Nam</label>
                                    <input class="required" required type="radio" id="gender_f"
                                           name="teacher[gender]" value="F" /><label for="gender_f"> Nữ</label>
                                </div>
                            </div>
-->

                        <div class="form-group row">
                            <label class="col-xs-3 col-form-label" for="mobile">Số điện thoại<span class="text-danger">*</span></label>
                            <div class="col-xs-9">
                                <input class="form-control input-medium required" type="text" required id="mobile"
                                       name="teacher[mobile]"  />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-xs-3 col-form-label" for="full_name">Trình độ<span class="text-danger">*</span></label>
                            <div class="col-xs-9">
                                <select name="teacher[exp_type]">

                                    <option value="0">Giáo viên</option>
                                    <option value="1">Sinh viên</option>
                                    <option value="2">Khác</option>
                                </select>
                            </div>
                        </div>

                        <input type="checkbox" id="term" required/> <label for="term"> Tôi đã đọc và chấp nhận tất cả <a targer="_blank" href="<?php echo site_url('dieu-khoan')?>">điều khoản</a>.</label>

                        <div class="clearfix"></div>

                    </div>
                    <?php wp_nonce_field( 'hb_action', 'hb_meta_nonce' );?>
                    <center>
                        <button type="submit" class="button">Đăng kí</button>
                    </center>
                </form>
            </div>
            <div class="col-md-2"></div>

        </div>

    </div>

</div><!-- #primary -->
<?php
get_footer();
?>

<style>
    #dangkygiasu{
        margin-top: 30px;
    }
</style>
