<?php
/**
 * @version		$Id: default.php 20196 2011-01-09 02:40:25Z ian $
 * @package		Joomla.Site
 * @subpackage	mod_users_latest
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
// no direct access
defined('_JEXEC') or die;
?>
	<ul  class="latestusers<?php echo $moduleclass_sfx ?>" >
<?php foreach($names as $name) : ?>

		<li>
		<?php if ($linknames==1) { ?>
		<a href="index.php?option=com_users&view=profile&member_id=<?php echo (int) $name->id ?>">
		<?php } ?>
		<?php echo $name->username; ?>
			<?php if ($linknames==1) : ?>
				</a>
			<?php endif; ?>
		</li>
<?php endforeach;  ?>
	</ul>
