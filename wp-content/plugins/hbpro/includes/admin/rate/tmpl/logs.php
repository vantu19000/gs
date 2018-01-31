<?php

/**
 * @package 	Bookpro
 * @author 		Vuong Anh Duong
 * @link 		http://http://woafun.com/
 * @copyright 	Copyright (C) 2011 - 2012 Vuong Anh Duong
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: default.php 26 2012-07-08 16:07:54Z quannv $
 **/
defined('ABSPATH') or die('Restricted access');
$logsCount = count($this->logs);
$days= HBDateHelper::dayofweek();
?>
<button class="button" type="button" onclick="if (jQuery('#adminForm .logscheck:checked').length ==0){alert('Choose logs to delete!');}else{submitform('deleteratelogs');}"><?php echo __('Delete logs')?></button>
		<table class="table">
			<thead>
				<tr>
					<th scope="row" class="check-column"><?php $this->table->column_cb()?>			
					<th style="width:200px;"><?php echo __("End date");?></th>
					<th><?php echo __("Summary");?>
					</th>
				</tr>
			</thead>

			<?php 

			if($logsCount)
			for ($i = 0; $i < $logsCount; $i++)
			{				
				$item = $this->logs[$i];
				$content = json_decode($item->content);
				?>
			<tbody>
				<tr class="record">
					<td><input type="checkbox" class="logscheck" name="log[]" value="<?php echo $item->id?>" /></td>
					<td><?php echo HBFactory::getDate($item->startdate)->format('d-m-Y').' '.__('To').' '. HBFactory::getDate($item->enddate)->format('d-m-Y'); ?>
					</td>
					<td>
						<?php if($content){ 
							$week='';							
							foreach ($content->week as $w){
								$week.= $days[$w].', ';
							}	
						?>
						<div style="display:table;width:100%;font-size:80%">							
							<div style="display:table-cell;width:25%">
								<span class="clearfix"><?php echo __('Day').':<br>'.$week?></span>
								<?php if(isset($content->params)){?><span><?php foreach($content->params as $key=>$val){echo $key.': '.$val." ";}?></span><?php }?>
							</div>
							<div style="display:table-cell;width:75%">
								<?php foreach ($content->price as $t=>$val){?>
									<span class="clearfix"><?php echo $t?>:
										<?php foreach ($val as $k=>$v){
											echo $k.': '.$v.', ';
										}?>
									</span><br>
								<?php }?>
							</div>
						</div>
						
						<?php }else{
							echo $item->content;
						}?>
					</td>

				</tr>
			</tbody>
			<?php 
			}
			?>
		</table>