<?php
/**
 * sh404SEF support for WordPress Component.
 * @copyright	Copyright (C) 2009-2010 'corePHP' / corephp.com. All rights reserved.
 * @version		$Id: com_wordpress.php 1 2008-14 00:14 rafael $
 * @license		GNU/GPL
 * 
 * Version 1.1.1
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

// ------------------  standard plugin initialize function - don't change ---------------------------
global $sh_LANG, $sefConfig;
$shLangName = '';
$shLangIso = '';
$title = array();
$shItemidString = '';
$dosef = shInitializePlugin( $lang, $shLangName, $shLangIso, $option);
if ( $dosef == false ) return;
// ------------------  standard plugin initialize function - don't change ---------------------------

// ------------------  load language file - adjust as needed ----------------------------------------
//$shLangIso = shLoadPluginLanguage( 'com_wordpress', $shLangIso, '_SH404SEF_WORDPRESS_w00t');
// ------------------  load language file - adjust as needed ----------------------------------------

if ( !function_exists( 'getWPTitleAlias' ) ) {
	function getWPTitleAlias()
	{
		static $slug;
		global $mainframe;

		if ( $slug ) { return $slug; }

		$menu = $mainframe->getMenu();
		if ( is_object( $menu ) ) {
			foreach ( $menu->getMenu() as $item ) {
				if ( $item->component == 'com_wordpress' ) {
					$slug = $item->alias;
					break;
				}
			}
		}
		if ( !$slug ) {
			$slug = 'blog';
		}
		return $slug;
	}
}

$title[] = getWPTitleAlias();

/* sh404SEF extension plugin : remove vars we have used, adjust as needed --*/
shRemoveFromGETVarsList('option');
shRemoveFromGETVarsList('lang');
if (isset($Itemid))
shRemoveFromGETVarsList('Itemid');
if (isset($task) && !empty($task))
shRemoveFromGETVarsList('task');
/* sh404SEF extension plugin : end of remove vars we have used -------------*/

// ------------------  standard plugin finalize function - don't change ---------------------------
if ($dosef){
  $string = shFinalizePlugin( $string, $title, $shAppendString, $shItemidString,
  (isset($limit) ? @$limit : null), (isset($limitstart) ? @$limitstart : null),
  (isset($shLangName) ? @$shLangName : null));
}
// ------------------  standard plugin finalize function - don't change ---------------------------

?>