<?php
/**
 * @version		$Id: default_navigation.php 20196 2011-01-09 02:40:25Z ian $
 * @package		Joomla.Administrator
 * @subpackage	com_config
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;
?>
<div id="submenu-box">
	<div class="t">
		<div class="t">
			<div class="t"></div>
		</div>
	</div>
	<div class="m">
		<div class="submenu-box">
			<div class="submenu-pad">
				<ul id="submenu" class="configuration">
					<li><a href="#" onclick="return false;" id="site" class="active"><?php echo JText::_('JSITE'); ?></a></li>
					<li><a href="#" onclick="return false;" id="system"><?php echo JText::_('COM_CONFIG_SYSTEM'); ?></a></li>
					<li><a href="#" onclick="return false;" id="server"><?php echo JText::_('COM_CONFIG_SERVER'); ?></a></li>
					<li><a href="#" onclick="return false;" id="permissions"><?php echo JText::_('COM_CONFIG_PERMISSIONS'); ?></a></li>
				</ul>
				<div class="clr"></div>
			</div>
		</div>
		<div class="clr"></div>
	</div>
	<div class="b">
		<div class="b">
			<div class="b"></div>
		</div>
	</div>
</div>