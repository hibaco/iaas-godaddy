<?php
/**
 * @version		$Id: login.php 20196 2011-01-09 02:40:25Z ian $
 * @package		Joomla.Administrator
 * @subpackage	com_login
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License, see LICENSE.php
 */

// No direct access.
defined('_JEXEC') or die;

// Require the base controller
jimport('joomla.application.component.controller');

$task = JRequest::getCmd('task');
if ($task != 'login' && $task != 'logout')
{
	JRequest::setVar('task', '');
	$task = '';
}

$controller	= JController::getInstance('Login');
$controller->execute($task);
$controller->redirect();