<?php 
/**
 * @package 	Bookpro
 * @author 		Vuong Anh Duong
 * @link 		http://http://woafun.com/
 * @copyright 	Copyright (C) 2011 - 2012 Vuong Anh Duong
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: bookpro.php 80 2012-08-10 09:25:35Z quannv $
 **/

defined('ABSPATH') or die('Restricted access');
?>
	<h2>
		<span><?php echo __('Business price','hb'); ?></span>
	</h2>		
	<input type="hidden" name="frate[bus][pricetype]" value="BUS" />
	<div class="inside">
	<table style="width:300px">
				<tr>
				  <td></td>
				  <td><?php echo __('One way'); ?></td>		
				  <td><?php echo __('Roundtrip'); ?></td>
				</tr>
				<tr>
				  <td><?php echo __('Adult'); ?></td>
				  <td><input class="input-mini required" type="text" name="frate[bus][adult]" id="adult" maxlength="255" value="" placeholder="<?php echo __('Adult'); ?> " /></td>		
				  <td><input class="input-mini required" type="text" placeholder="<?php echo __('Adult roundtrip'); ?>" name="frate[bus][adult_roundtrip]" id="adult_roundtrip"  maxlength="255"
			value="" /></td>
				</tr>
				<tr>
				  <td><?php echo __('Child'); ?></td>
				  <td><input class="input-mini required" type="text" name="frate[bus][child]" placeholder="<?php echo __('Child'); ?>" id="child"  maxlength="255" value="" /></td>		
				  <td><input class="input-mini required" type="text" placeholder="<?php echo __('Child roundtrip'); ?>"
			name="frate[bus][child_roundtrip]" id="child_roundtrip" maxlength="255"
			value="" /></td>
				</tr>
				<tr>
				  <td><?php echo __('Infant') ?></td>
				  <td><input class="input-mini required" type="text" name="frate[bus][infant]" placeholder="<?php echo __('Infant') ?>"
			id="infant" maxlength="255" value="" /></td>		
				  <td><input class="input-mini required" type="text" placeholder="<?php echo __('Infant roundtrip'); ?>"
			name="frate[bus][infant_roundtrip]" id="infant_roundtrip"  maxlength="255"
			value="" /></td>
				</tr>
				<tr>
					<td><?php echo __('Seat')?></td>
					<td colspan="2"><input class="input-mini required" type="number" name="frate[bus][seat]" value="<?php echo $this->route->bus_seat ?>" /></td>
				</tr>
			</table>
	</div>