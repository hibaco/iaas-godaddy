<?php
/**
 * @version		$Id: default_debug.php 20196 2011-01-09 02:40:25Z ian $
 * @package		Joomla.Administrator
 * @subpackage	com_config
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;
?>
<div class="width-100">
<fieldset class="adminform">
	<legend><?php echo JText::_('COM_CONFIG_DEBUG_SETTINGS'); ?></legend>
		<ul class="adminformlist">
			<?php
			foreach ($this->form->getFieldset('debug') as $field):
			?>
					<li><?php echo $field->label; ?>
					<?php echo $field->input; ?></li>
			<?php
			endforeach;
			?>
		</ul>
</fieldset>
</div>