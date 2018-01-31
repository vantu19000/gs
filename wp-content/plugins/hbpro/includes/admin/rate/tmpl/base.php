<?php 
/**
 * @package 	Bookpro
 * @author 		Vuong Anh Duong
 * @link 		http://http://woafun.com/
 * @copyright 	Copyright (C) 2011 - 2012 Vuong Anh Duong
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: bookpro.php 80 2012-08-10 09:25:35Z quannv $
 **/

?>
	<h2 class="">
		<span><?php echo __('Base price','hb'); ?></span>
		
	</h2>
	<div class="inside">
	
	<input type="hidden" name="frate[base][pricetype]" value="BASE" />
	
	<table style="width:300px">
				<tr>
				  <td></td>
				  <td><?php echo __('One way'); ?></td>		
				  <td><?php echo __('Roundtrip'); ?></td>
				</tr>
				<tr>
				  <td><?php echo __('Adult'); ?></td>
				  <td><input class="input-mini required" type="text" placeholder="<?php echo __('Adult'); ?> " name="frate[base][adult]"
						id="adult" maxlength="255" value="" /></td>		
				  <td><input class="input-mini required" placeholder="<?php echo __('Adult roundtrip'); ?>" type="text"
			name="frate[base][adult_roundtrip]" id="adult_roundtrip"  maxlength="255"
			value="" /></td>
				</tr>
				<tr>
				  <td><?php echo __('Child'); ?></td>
				  <td><input class="input-mini required" type="text" name="frate[base][child]" placeholder="<?php echo __('Child'); ?>" id="child" 
				   maxlength="255" value="" /></td>		
				  <td><input class="input-mini required" type="text" placeholder="<?php echo __('Child roundtrip'); ?>"
				name="frate[base][child_roundtrip]" id="child_roundtrip" maxlength="255"
				value="" /></td>
				</tr>
				<tr>
				  <td><?php echo __('Infant') ?></td>
				  <td><input class="input-mini required" type="text" name="frate[base][infant]" placeholder="<?php echo __('Infant') ?>"
				id="infant" maxlength="255" value="" /></td>		
				  <td><input class="input-mini required" type="text" placeholder="<?php echo __('Infant roundtrip'); ?>"
				name="frate[base][infant_roundtrip]" id="infant_roundtrip"  maxlength="255"
				value="" /></td>
				</tr>
				<tr>
					<td><?php echo __('Seat')?></td>
					<td colspan="2"><input class="input-mini required" type="number" name="frate[base][seat]" value="<?php echo $this->route->base_seat ?>" /></td>
				</tr>
			</table>
	</div>
	