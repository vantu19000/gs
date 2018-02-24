<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id$
 **/
// die('ddfdf');
defined('ABSPATH') or die('Restricted access');

global $wpdb;
$resul = $wpdb->get_results("SELECT count(*) AS count FROM {$wpdb->prefix}hbpro_users WHERE status = 1");
$total = reset($resul)->count;

?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<div class="wrap">
	<h1>Quản lí gia sư <a href="https://giasutriviet.edu.vn/dang-ki-giang-vien" class="page-title-action" target="_blank" >Thêm gia sư</a></h1>

    <div class="tablenav top" style="margin-top: 20px; margin-bottom: 20px">

        <input class="button action" value="Xóa" type="button" onclick="return deleetes()">

            <input type="text" id="code" placeholder="Mã gia sư" value="<?php if ($_GET['code']) echo $_GET['code']; ?>">
            <input class="page-title-action" value="Lọc" type="button" onclick="return filtercode()">
            <input class="page-title-action" value="X" type="button" onclick="return clearCode()">

        <div class="tablenav-pages one-page">
            <span class="displaying-num"><?php echo count($this->items); ?> mục</span>
        </div>
    </div>

    <form id="filterGS" method="post">
        <input type="hidden" name="gs_code" id="gs_code">
    </form>

    <div>
		<form id="formteacher" method="post">
			<table class="wp-list-table widefat fixed striped posts">
				<thead>
					<tr>
						<th width="5%">#</th>
						<th>Họ tên</th>
						<th>Số điện thoại</th>
						<th>Email</th>
						<th>Địa chỉ</th>
						<th>Mã gia sư</th>
						<th>Ngày đăng kí</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($this->items as $item){?>
						<tr>
							<td><input type="checkbox" name="id[]"  value="<?php echo $item->id; ?>" /></td>
							<td><a href="admin.php?page=teacher&layout=edit&id=<?php echo $item->id; ?>"> <?php echo $item->full_name;?></a></td>
							<td><?php echo $item->mobile;?></td>
							<td><?php echo $item->email;?></td>
							<td><?php echo $item->address;?></td>
                            <td><?php echo $item->code; ?></td>
							<td><?php echo $item->created;?></td>
						</tr>
					<?php }?>
				</tbody>
			</table>

            <?php wp_nonce_field( 'hb_action', 'hb_meta_nonce' );?>

        </form>


        <div class="container">
            <ul class="pagination">
                <?php $recent = 1; if ($_GET['p']) $recent = $_GET['p']; ?>
                <?php HBHelper::renderPagination($recent, CEIL($total / 20)); ?>
            </ul>
        </div>

	</div>
</div>

<script>
    
    function goToPage(page) {
        var link = "<?php echo admin_url('admin.php?page=teacher&p=')?>"+page;
        window.location = link;
    }

    function deleetes(){
        if (confirm("Bạn chắc chắn muốn xóa?")){
            document.getElementById('formteacher').action = "<?php echo admin_url('admin-post.php?action=hbaction&hbaction=teacher&task=delete')?>";
            document.getElementById("formteacher").submit();
        }
    }
    
    function filtercode() {
        var val = document.getElementById("code").value;
        if (!val){
            alert("Vui lòng nhập mã gia sư");
            return false;
        }
        document.getElementById("gs_code").value = val;
        document.getElementById('filterGS').action = "<?php echo admin_url('admin.php?page=teacher&code=')?>"+val;
        document.getElementById("filterGS").submit();
    }

    function clearCode() {
        document.getElementById("code").value = "";
        document.getElementById('filterGS').action = "<?php echo admin_url('admin.php?page=teacher')?>";
        document.getElementById("filterGS").submit();
    }
</script>