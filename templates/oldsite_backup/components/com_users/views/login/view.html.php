<?php
/**
 * @version		$Id: view.html.php 20196 2011-01-09 02:40:25Z ian $
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * Login view class for Users.
 *
 * @package		Joomla.Site
 * @subpackage	com_users
 * @since		1.5
 */
class UsersViewLogin extends JView
{
	protected $form;
	protected $params;
	protected $state;
	protected $user;

	/**
	 * Method to display the view.
	 *
	 * @param	string	The template file to include
	 * @since	1.5
	 */
	public function display($tpl = null)
	{
		// Get the view data.
		$this->user		= JFactory::getUser();
		$this->form		= $this->get('Form');
		$this->state	= $this->get('State');
		$this->params	= $this->state->get('params');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		
		//Escape strings for HTML output
		$this->pageclass_sfx = htmlspecialchars($this->params->get('pageclass_sfx'));

		$this->prepareDocument();

		parent::display($tpl);
	}

	/**
	 * Prepares the document
	 * @since	1.6
	 */
	protected function prepareDocument()
	{
		$app		= JFactory::getApplication();
		$menus		= $app->getMenu();
		$user		= JFactory::getUser();
		$login		= $user->get('guest') ? true : false;
		$title 		= null;

		// Because the application sets a default page title,
		// we need to get it from the menu item itself
		$menu = $menus->getActive();
		if ($menu) {
			$this->params->def('page_heading', $this->params->get('page_title', $menu->title));
		} else {
			$this->params->def('page_heading', $login ? JText::_('JLOGIN') : JText::_('JLOGOUT'));
		}

		$title = $this->params->get('page_title', '');
		if (empty($title)) {
			$title = $app->getCfg('sitename');
		}
		elseif ($app->getCfg('sitename_pagetitles', 0)) {
			$title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
		}
		$this->document->setTitle($title);
	}
}
