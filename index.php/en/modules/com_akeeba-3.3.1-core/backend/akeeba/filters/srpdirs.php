<?php
/**
 * Akeeba Engine
 * The modular PHP5 site backup engine
 * @copyright Copyright (c)2009-2011 Nicholas K. Dionysopoulos
 * @license GNU GPL version 3 or, at your option, any later version
 * @package akeebaengine
 * @version $Id: srpdirs.php 641 2011-05-23 17:23:38Z nikosdion $
 */

// Protection against direct access
defined('AKEEBAENGINE') or die('Restricted access');

/**
 * System Restore Point - Directories
 */
class AEFilterSrpdirs extends AEAbstractFilter
{
	protected $params = array();
	
	protected $alloweddirs = array();
	
	protected $strictalloweddirs = array();
	
	function __construct()
	{
		$this->object	= 'dir';
		$this->subtype	= 'all';
		$this->method	= 'api';
		
		if(AEFactory::getKettenrad()->getTag() != 'restorepoint') {
			$this->enabled = false;
		} else {
			$this->init();
		}
	}
	
	protected function init()
	{
		// Fetch the configuration
		$config = AEFactory::getConfiguration();
		$this->params = (object)array(
			'type'			=> $config->get('core.filters.srp.type',		'component'),
			'group'			=> $config->get('core.filters.srp.group',		'group'),
			'name'			=> $config->get('core.filters.srp.name',		'name'),
			'customdirs'	=> $config->get('core.filters.srp.customdirs',	array()),
			'customfiles'	=> $config->get('core.filters.srp.customfiles',	array()),
			'langfiles'		=> $config->get('core.filters.srp.langfiles',	array())
		);
		
		$this->alloweddirs = array();

		// Process custom directories
		if(is_array($this->params->customdirs)) {
			foreach($this->params->customdirs as $dir) {
				$dir = $this->treatDirectory($dir);
				$this->alloweddirs[] = $dir;
			}
		}
		
		// Process custom files
		if(is_array($this->params->customfiles)) {
			foreach($this->params->customfiles as $file) {
				$dir = dirname($file);
				$dir = $this->treatDirectory($dir);
				if(!in_array($dir,$this->strictalloweddirs)) $this->strictalloweddirs[] = $dir;
				if(!in_array($dir,$this->alloweddirs)) $this->alloweddirs[] = $dir;
			}
		}
		
		$this->alloweddirs[] = 'language';
		$this->alloweddirs[] = 'administrator/language';
		
		// Process core directorires
		switch($this->params->type) {
			case 'component':
				$this->alloweddirs[] = 'components/com_'.$this->params->name;
				$this->alloweddirs[] = 'administrator/components/com_'.$this->params->name;
				$this->alloweddirs[] = 'media/com_'.$this->params->name;
				$this->alloweddirs[] = 'media/'.$this->params->name;
				break;
			
			case 'plugin':
				// This is required for Joomla! 1.5 compatibility
				$this->alloweddirs[] = 'plugins/'.$this->params->group;
				// This is required for Joomla! 1.6 compatibility
				$this->alloweddirs[] = 'plugins/'.$this->params->group.'/'.$this->params->name;
				break;
			
			case 'module':
				if($this->params->group == 'admin') {
					$this->alloweddirs[] = 'administrator/modules/mod_'.$this->params->name;
				} else {
					$this->alloweddirs[] = 'modules/mod_'.$this->params->name;
				}
				
				break;
			
			case 'template':
				if($this->params->group == 'admin') {
					$this->alloweddirs[] = 'administrator/templates/'.$this->params->name;
				} else {
					$this->alloweddirs[] = 'templates/'.$this->params->name;
				}
				break;
				
			default:
				$this->alloweddirs = array();
		}
	}
	
	protected function is_excluded_by_api($test, $root)
	{
		// Allow scanning the root
		if(empty($test)) return false;
		
		// If the directory is a subdirectory of a strictly allowed path, exclude it
		if(!empty($this->strictalloweddirs)) foreach($this->strictalloweddirs as $dir) {
			$len = strlen($dir);
			if(strlen($test) > $len) {
				if($test == $dir) return false;
				if(substr($test, 0, $len+1) == $dir.'/') return true;
			}
		}
		
		// Look if the directory is within the allowed paths
		foreach($this->alloweddirs as $dir) {
			$len = strlen($dir);
			if(strlen($test) < $len) {
				// We have to allow scanning parent directories
				$len = strlen($test);
				if(substr($dir,0,$len) == $test) {
					// We need a different slash count. If the slash count is the same
					// we have a border case, e.g. administrator/com_admin is perceived
					// as the parent to administrator/com_adminTOOLS which is, of course,
					// false!
					
					$stringStatsTest = count_chars($test,1);
					$stringStatsDir = count_chars($dir,1);
					if(!array_key_exists(47, $stringStatsTest) || !array_key_exists(47, $stringStatsDir)) return false;
					if($stringStatsTest[47] == $stringStatsDir[47]) {
						// Border case!
						continue;
					} else {
						return false;
					}
				}
			} else {
				// We have to fully allow explicitly allowed directories
				if(substr($test, 0, $len) == $dir) return false;
			}
		}

		// Exclude directories by default
		return true;
	}
	
	private static function treatDirectory($directory)
	{
		static $site_root = null;

		if(is_null($site_root)) {
			$site_root = AEUtilFilesystem::TrimTrailingSlash(AEUtilFilesystem::TranslateWinPath(JPATH_ROOT));
		}

		$directory = AEUtilFilesystem::TrimTrailingSlash(AEUtilFilesystem::TranslateWinPath($directory));

		// Trim site root from beginning of directory
		if( substr($directory, 0, strlen($site_root)) == $site_root )
		{
			$directory = substr($directory, strlen($site_root));
			if( substr($directory,0,1) == '/' ) $directory = substr($directory,1);
		}

		return $directory;
	}
}