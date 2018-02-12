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
?>
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
						</tr>
					<?php }?>
				</tbody>
			</table>

            <?php wp_nonce_field( 'hb_action', 'hb_meta_nonce' );?>

        </form>
	</div>
</div>

<script>
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