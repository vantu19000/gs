<?php
    global $wpdb;
    get_header();

    $input= HBFactory::getInput();
    $id = $input->get('id');

    $query = "Select * from {$wpdb->prefix}hbpro_orders where id = $id";

    $item =  reset( $wpdb->get_results($query) );

//    echo "<pre>";
//    print_r($item);
//    die;
?>

<?php if (!$item): ?>
<div class="container" style="margin-top: 30px;">

</div>
<?php endif; ?>




<?php get_footer() ?>
