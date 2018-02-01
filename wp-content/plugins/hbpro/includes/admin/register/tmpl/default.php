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
$nonce = wp_create_nonce( 'hb_action' );
?>
<div class="wrap">
	<h1>Gia sư mới đăng kí</h1>
	
	<div class="tablenav top">
		<input class="button action" value="Xóa" type="button">
		<input class="button action" value="Chấp nhận" type="button">
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
							<td><?php echo $item->name;?></td>
							<td><?php echo $item->phone;?></td>
							<td><?php echo $item->email;?></td>
							<td><?php echo $item->address;?></td>
							<td><?php echo $item->created;?></td>
						</tr>
					<?php }?>
				</tbody>
			</table>
		</form>
	</div>
</div>