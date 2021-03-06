<?php
/**
 * @version   $Id: base.php 201 2011-05-08 16:27:15Z happy_noodle_boy $
 * @package   	JCE
 * @copyright 	Copyright © 2009-2011 Ryan Demmer. All rights reserved.
 * @license   	GNU/GPL 2 or later
 * This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

// no direct access
defined('_JEXEC') or die('RESTRICTED');

// load constants
require_once(dirname(__FILE__) . DS . 'constants.php');
// load loader
require_once(dirname(__FILE__) . DS . 'loader.php');
// load text
require_once(dirname(dirname(__FILE__)) . DS . 'classes' . DS . 'text.php');
// load xml
require_once(dirname(dirname(__FILE__)) . DS . 'classes' . DS . 'xml.php');
// load parameter
require_once(dirname(dirname(__FILE__)) . DS . 'classes' . DS . 'parameter.php');
?>
