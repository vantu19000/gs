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
<!--    <Button id="Edit" class="button action" value="Edit" onclick="return edit()">Edit</Button>-->
    <Button id="Edit" class="button action" value="Delete" onclick="return deletes()">Delete</Button>
</div>
	
	
<div>
    <form action="<?php echo admin_url('admin-post.php?action=hbaction&hbaction=orders&task=delete')?>" id="formsubmit" method="post">
        <table class="wp-list-table widefat fixed striped posts">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th>Họ tên</th>
                    <th>Số điện thoại</th>
                    <th>Email</th>
                    <th>Địa chỉ</th>
                    <th>Ngày đăng kí</th>
                    <th>Thông tin</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($this->items as $item){?>
                    <tr>
                        <td><input type="checkbox" name="id[]"  value="<?php echo $item->id; ?>" /></td>
                        <td><a href="<?php echo admin_url('admin.php?page=hb_dashboard&layout=edit&id='.$item->id)?>"><?php echo $item->name ?></a></a></td>
                        <td><?php echo $item->mobile;?></td>
                        <td><?php echo $item->email;?></td>
                        <td><?php echo $item->address;?></td>
                        <td><?php echo $item->created;?></td>
                        <td><?php
                            if ($item->order_status == 0){
                                echo "Chưa xử lý";
                            }else{
                                echo "Đã xử lý";
                            }
                            ?></td>
                    </tr>
                <?php }?>
            </tbody>
        </table>

        <?php wp_nonce_field( 'hb_action', 'hb_meta_nonce' );?>
    </form>
</div>

<script>
    function deletes() {
        document.getElementById("formsubmit").action = "<?php echo admin_url('admin-post.php?action=hbaction&hbaction=orders&task=delete')?>";
        document.getElementById("formsubmit").submit();
    }
    function edit() {
        document.getElementById("formsubmit").action = "<?php echo admin_url('admin-post.php?action=hbaction&hbaction=orders&task=edit')?>";
        document.getElementById("formsubmit").submit();
    }
</script>