<?php
/**
 * The template for displaying tin tuc page
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package woafun
 */

get_header(); 
?>
	
<div id="primary" class="content-area container">
	<!-- Tin moi -->
	<div class="row">
		<div class="col-md-9">
			<h2>Các giảng viên</h2>
			<div class="row" style="margin:10px 0;">
			
			<?php
			global $post;
			$args = array( 'numberposts' => 12, 'category_name' => 'giang-vien' );
			$posts = get_posts( $args );
// 			debug($posts);die;
			if($posts){
				foreach( $posts as $i=>$post ){
					$link = wp_get_canonical_url($post);
					?>
					<div class="col-sm-4">
						<div class="item-news">
							<div class="avatar-item-news" ><a href="<?php echo $link?>"><?php echo get_the_post_thumbnail($post,'medium')?></a></div>
							<div class="tags-item"></div>
							<div class="title-item-news"><a href="<?php echo $link?>"><?php echo ($post->post_title)?></a></div>
							<div class="summary-item-news"><?php echo $post->post_excerpt?></div>
						</div>						
					</div>
					<?php 
					
					
				}
			}else{
				echo "<h3>Tạm thời chưa có học sinh nào trong mục này</h3>";
			}		
			?>
			</div>
		</div>
		<div class="col-md-3">
			<?php get_sidebar();?>
		</div>
	</div>
	
</div><!-- #primary -->
<?php
get_footer();
