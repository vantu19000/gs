<h1>Đơn đăng kí học mới từ giasutriviet.edu.vn</h1>
Họ tên: <?php echo $displayData->full_name?>
Sđt: <?php echo $displayData->mobile?>
Email: <?php echo $displayData->email?>
Địa chỉ: <?php echo $displayData->address?>
Nội dung: <?php echo $displayData->notes?>
Link: <?php echo site_url('/wp-admin?page=orders&layout=edit&id='.$displayData->id)?>