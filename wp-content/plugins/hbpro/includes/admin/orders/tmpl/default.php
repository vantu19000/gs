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
<h1>Đơn đặt hàng</h1>

<div class="tablenav top">
	<div class="alignleft actions bulkactions">
				<label for="bulk-action-selector-top" class="screen-reader-text">Lựa chọn thao tác hàng loạt</label><select name="action" id="bulk-action-selector-top">
	<option value="-1">Tác vụ</option>
		<option value="edit" class="hide-if-no-js">Chỉnh sửa</option>
		<option value="trash">Bỏ vào thùng rác</option>
	</select>
	<input id="doaction" class="button action" value="Áp dụng" type="submit">
			</div>
					<div class="alignleft actions">
			<label for="filter-by-date" class="screen-reader-text">Lọc theo ngày</label>
			<select name="m" id="filter-by-date">
				<option selected="selected" value="0">Tất cả các ngày</option>
	<option value="201609">Tháng Chín 2016</option>
			</select>
	<label class="screen-reader-text" for="cat">Lọc theo danh mục</label><select name="cat" id="cat" class="postform">
		<option value="0">Tất cả chuyên mục</option>
		<option class="level-0" value="4">Giảng viên</option>
		<option class="level-0" value="5">Học sinh</option>
		<option class="level-0" value="1">Tin tức chung</option>
	</select>
	<input name="filter_action" id="post-query-submit" class="button" value="Lọc" type="submit">		</div>
	<div class="tablenav-pages one-page"><span class="displaying-num">5 mục</span>
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
					<th>Số đơn đặt hàng</th>
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
						<td><a href="#"><?php echo sprintf('%010d', $item->id); ?></a></a></td>
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