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
	<h1>Quản lí gia sư <a href="<?php echo admin_url('admin.php?page=teacher&layout=edit')?>" class="page-title-action" >Thêm giáo viên</a></h1>
	
	<div class="tablenav top">
		<div class="alignleft actions bulkactions">
					<label for="bulk-action-selector-top" class="screen-reader-text">Lựa chọn thao tác hàng loạt</label><select name="action" id="bulk-action-selector-top">
		<option value="-1">Tác vụ</option>
			<option value="edit" class="hide-if-no-js">Chỉnh sửa</option>
			<option value="trash">Bỏ vào thùng rác</option>
		</select>
		<input id="doaction" class="button action" value="Áp dụng" type="submit">
				</div>
		<div class="tablenav-pages one-page"><span class="displaying-num"><?php echo count($this->items) ?> mục</span>
		<span class="pagination-links"><span class="tablenav-pages-navspan" aria-hidden="true">«</span>
		<span class="tablenav-pages-navspan" aria-hidden="true">‹</span>
		<span class="paging-input"><label for="current-page-selector" class="screen-reader-text">Trang hiện tại</label><input class="current-page" id="current-page-selector" name="paged" value="1" size="1" aria-describedby="table-paging" type="text"><span class="tablenav-paging-text"> trên <span class="total-pages">1</span></span></span>
		<span class="tablenav-pages-navspan" aria-hidden="true">›</span>
		<span class="tablenav-pages-navspan" aria-hidden="true">»</span></span></div>

			<br class="clear">
	</div>
		
		
	<div>
		<form>
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
							<td><input type="checkbox" name="id"  value="<?php echo $item->id; ?>" /></td>
							<td><?php echo $item->full_name;?></td>
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
</div>