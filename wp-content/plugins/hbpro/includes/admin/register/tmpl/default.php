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
$resul = $wpdb->get_results("SELECT count(*) AS count FROM {$wpdb->prefix}hbpro_users WHERE status != 1");
$total = reset($resul)->count;

?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<div class="wrap">
	<h1>Gia sư mới đăng kí</h1>
	
	<div class="tablenav top">
		<input class="button action" value="Xóa" type="button" onclick="return deleetes()">
		<input class="button action" value="Chấp nhận" type="button" onclick="return approve()">
	</div>
		
		
	<div>
		<form method="POST"
                action="<?php echo admin_url('admin-post.php?action=hbaction&hbaction=register&task=save')?>" id="formteacher">
			<table class="wp-list-table widefat fixed striped posts">
				<thead>
					<tr>
                        <th width="5%">#</th>
						<th>Họ tên</th>
						<th>Số điện thoại</th>
						<th>Email</th>
						<th>Địa chỉ</th>
						<th>Ngày đăng kí</th>
                        <th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($this->items as $item){?>
						<tr>
                            <td><input type="checkbox" value="<?php echo $item->id ?>" name="id[]"> </td>
                            <td><a target="_blank" href="admin.php?page=teacher&layout=edit&id=<?php echo $item->id; ?>"> <?php echo $item->full_name;?></a></td>
							<td><?php echo $item->mobile;?></td>
							<td><?php echo $item->email;?></td>
							<td><?php echo $item->address;?></td>
							<td><?php echo $item->created;?></td>
							<td><?php
                                if ($item->mobile &&
                                    $item->email && $item->class_type &&
                                    $item->subject_id && $item->icon && $item->province_id &&
                                    $item->district_id && $item->gender && $item->time &&
                                    $item->desc && $item->excerpt && $item->birthday &&
                                    $item->address && $item->salary
                                ){
                                    echo "<strong style='color: #0275D8'>Đã hoàn thành profile</strong>";
                                }
                            ?></td>
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
        var link = "<?php echo admin_url('admin.php?page=hb_register&p=')?>"+page;
        window.location = link;
    }

    function approve(){
        document.getElementById('formteacher').action = "<?php echo admin_url('admin-post.php?action=hbaction&hbaction=register&task=approve')?>";
        document.getElementById("formteacher").submit();
    }

    function deleetes(){
        if (confirm("Bạn chắc chắn muốn xóa?")){
            document.getElementById('formteacher').action = "<?php echo admin_url('admin-post.php?action=hbaction&hbaction=register&task=delete')?>";
            document.getElementById("formteacher").submit();
        }
    }
</script>