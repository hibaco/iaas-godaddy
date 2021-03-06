<?php
/**
 * @package AkeebaBackup
 * @subpackage BackupIconModule
 * @copyright Copyright (c)2009-2011 Nicholas K. Dionysopoulos
 * @license GNU General Public License version 3, or later
 * @since 2.2
 * @version $Id: mod_akadmin.php 421 2011-01-31 09:31:43Z nikosdion $
 */

// Protect from unauthorized access
defined('_JEXEC') or die('Restricted Access');

// Check for PHP4
if(defined('PHP_VERSION')) {
	$version = PHP_VERSION;
} elseif(function_exists('phpversion')) {
	$version = phpversion();
} else {
	// No version info. I'll lie and hope for the best.
	$version = '5.0.0';
}

// Old PHP version detected. EJECT! EJECT! EJECT!
if(!version_compare($version, '5.0.0', '>=')) return;

// Timezone fix; avoids errors printed out by PHP 5.3.3+ (thanks Yannick!)
if(function_exists('date_default_timezone_get') && function_exists('date_default_timezone_set')) {
	if(function_exists('error_reporting')) {
		$oldLevel = error_reporting(0);
	}
	$serverTimezone = @date_default_timezone_get();
	if(empty($serverTimezone) || !is_string($serverTimezone)) $serverTimezone = 'UTC';
	if(function_exists('error_reporting')) {
		error_reporting($oldLevel);
	}
	@date_default_timezone_set( $serverTimezone);
}

/*
 * Hopefuly, if we are still here, the site is running on at least PHP5. This means that
 * including the Akeeba Backup factory class will not throw a White Screen of Death, locking
 * the administrator out of the back-end.
 */

// Make sure Akeeba Backup is installed, or quit
$akeeba_installed = @file_exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_akeeba'.DS.'akeeba'.DS.'factory.php');
if(!$akeeba_installed) return;

// Make sure Akeeba Backup is enabled
jimport('joomla.application.component.helper');
if (!JComponentHelper::isEnabled('com_akeeba', true))
{
	JError::raiseError('E_JPNOTENABLED', JText('AKEEBA_NOT_ENABLED'));
	return;
}

// Set default parameters
$params->def('enablewarnings', 0); // Enable warnings
$params->def('warnfailed', 0); // Warn if backup is failed
$params->def('maxbackupperiod', 24); // Maximum time between backups, in hours

// Load custom CSS
$document =& JFactory::getDocument();
$document->addStyleSheet(JURI::base().'modules/mod_akadmin/css/mod_akadmin.css');

// Load the language files
$jlang =& JFactory::getLanguage();
$jlang->load('mod_akadmin', JPATH_ADMINISTRATOR, 'en-GB', true);
$jlang->load('mod_akadmin', JPATH_ADMINISTRATOR, $jlang->getDefault(), true);
$jlang->load('mod_akadmin', JPATH_ADMINISTRATOR, null, true);

//var_dump($jlang);die();

// Initialize defaults
$image = "akeeba-48.png";
$label = JText::_('LBL_AKEEBA');

if( $params->get('enablewarnings', 0) == 0 )
{
	// Process warnings
	$warning = false;

	// Load necessary files
	if(!version_compare( JVERSION, '1.6.0', 'ge' )) {
		define('AKEEBA_JVERSION','15');
	} else {
		define('AKEEBA_JVERSION','16');
	}
	if(!defined('AKEEBAENGINE')) {
		define('AKEEBAENGINE', 1); // Required for accessing Akeeba Engine's factory class
		define('AKEEBAPLATFORM', 'joomla15'); // So that platform-specific stuff can get done!
	}
	require_once JPATH_ADMINISTRATOR.DS.'components/com_akeeba/akeeba/factory.php';
	$registry =& AEFactory::getConfiguration();
	AEPlatform::load_configuration();
	
	// Get latest non-SRP backup ID
	$filters = array(
		array(
			'field'			=> 'tag',
			'operand'		=> '<>',
			'value'			=> 'restorepoint'
		)
	);
	$ordering = array(
		'by'		=> 'backupstart',
		'order'		=> 'DESC'
	);
	require_once JPATH_ADMINISTRATOR.DS.'components/com_akeeba/models/statistics.php';
	$model = new AkeebaModelStatistics();
	$list =& $model->getStatisticsListWithMeta(false, $filters, $ordering);
	
	if(!empty($list)) {
		$record = (object)array_shift($list);
	} else {
		$record = null;
	}
	
	// Process "failed backup" warnings, if specified
	if( $params->get('warnfailed', 0) == 0 )
	{
		if(!is_null($record))
		{
			$warning = (($record->status == 'fail') || ($record->status == 'run'));
		}
	}

	// Process "stale backup" warnings, if specified
	if(is_null($record))
	{
		$warning = true;
	}
	else
	{
		$maxperiod = $params->get('maxbackupperiod', 24);
		jimport('joomla.utilities.date');
		$lastBackupRaw = $record->backupstart;
		$lastBackupObject = new JDate($lastBackupRaw);
		$lastBackup = $lastBackupObject->toUnix(false);
		$maxBackup = time() - $maxperiod * 3600;
		if(!$warning) $warning = ($lastBackup < $maxBackup);
	}

	if($warning)
	{
		$image = 'akeeba-warning-48.png';
		$label = JText::_('LBL_BACKUPREQUIRED');
	}
}

// Load the Akeeba Backup configuration and check user access permission
if(!defined('AKEEBAENGINE'))
{
	define('AKEEBAENGINE', 1); // Required for accessing Akeeba Engine's factory class
	define('AKEEBAPLATFORM', 'joomla15'); // So that platform-specific stuff can get done!
}
require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_akeeba'.DS.'akeeba'.DS.'factory.php';
$registry =& AEFactory::getConfiguration();
$user =& JFactory::getUser();
$showModule = true;
unset($registry);

// Administrator access allowed
$jversion = new JVersion();
if( version_compare( $jversion->getShortVersion(), '1.6', 'gt' ) )
{
	// Joomla! 1.6
	$extraclass = 'icon16';
}
else
{
	// Joomla! 1.5
	$gid = $user->gid;
	if( ($gid != 25) && ($gid != 24) )
	{
		$showModule = false;
	}

	$extraclass = 'icon15';
}

unset($user);

if($showModule):
?>
<div class="akcpanel">
<div style="float:<?php echo ($lang->isRTL()) ? 'right' : 'left'; ?>;">
<div class="icon <?php echo $extraclass ?>"><a href="index.php?option=com_akeeba&view=backup">
<img src="components/com_akeeba/assets/images/<?php echo $image ?>" />
<span><?php echo $label; ?></span> </a></div>
</div>
</div>
<?php endif; ?>
