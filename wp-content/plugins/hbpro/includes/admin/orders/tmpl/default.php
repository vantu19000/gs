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
<h1>Đơn đăng kí học</h1>

<div class="tablenav top">
	<input id="Edit" class="button action" value="Edit" type="Button">
	<input id="Edit" class="button action" value="Delete" type="button">
</div>
	
	
<div>
	<form>
		<table class="wp-list-table widefat fixed striped posts">
			<thead>
				<tr>
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
						<td><a href="<?php echo admin_url('admin.php?page=hb_dashboard&layout=edit&id='.$item->id)?>"><?php echo $item->full_name ?></a></a></td>
						<td><?php echo $item->mobile;?></td>
						<td><?php echo $item->email;?></td>
						<td><?php echo $item->address;?></td>
						<td><?php echo $item->created;?></td>
					</tr>
				<?php }?>
			</tbody>
		</table>
	</form>
</div>