<?php
/**
 * @version		$Id: index.php 19070 2011-10-09 13:59:50Z chdemko $
 * @package		Joomla.Site
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
<jdoc:include type="head" />
		
		<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/template.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/top-menu.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/general.css" type="text/css" />

		<!--[if lte IE 7]>
		<link href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/ie7.css" rel="stylesheet" type="text/css" />
		<![endif]-->	

   </head>
	<body id="body"> 

	  <div id="wrapper" style="z-index:1"> 
	  
	    <div id="headerLogo" style="z-index:1">
		 <!-- TOP DROP MENU-->
		<jdoc:include type="modules" name="dropmenu" style="xhtml" />
		<!--END TOP DROP MENU-->
		<div id="search"><jdoc:include type="modules" name="position-0" /></div> <!--search module-->
		
		<div class="clear"></div> 
		
     <div id="logo"><a href="index.php">
	 <img src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/images/blank-lg.gif" alt="Home Page" /></a>
	 </div> 	
		
		
       <?php if ($this->countModules ('sidebar-1')) { ?> 
        <div id="mainLeft">
		<!--HOME PAGE SLIDESHOW MODULE-->
		<jdoc:include type="modules" name="slideshow-images" style="xhtml" />
        <div class="clear"></div>
		<jdoc:include type="modules" name="user1" style="xhtml" />
		<div class="clear"></div>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td><jdoc:include type="message" /><jdoc:include type="component" /></td>
		  </tr>
		</table>

		</div>
        <div id="sidebar1"><jdoc:include type="modules" name="sidebar-1" style="fx" /></div>
		<div class="clear"></div>	
		<div id="footer-1"></div><!--END FOOTER 1-->	
  
	    <?php }else{ ?>	
        <div id="mainFull">
		<div id="mainFullTop"></div>
		<div id="mainFullMid">
		<!--HOME PAGE SLIDESHOW MODULE-->
		<jdoc:include type="modules" name="slideshow-images" style="xhtml" />
         <div class="clear"></div>
		<jdoc:include type="modules" name="user1" style="xhtml" />
		<div class="clear"></div>
		<jdoc:include type="message" /><jdoc:include type="component" />
		</div>
		</div><!--END MAIN FULL-->
		<div id="footer-2"></div><!--END FOOTER 1-->	
        <?php } ?>		
	
	
	<div class="clear"></div>	
 
	 </div><!--END HEADER LOGO-->
	 </div><!--END TEMPLATE WRAPPER-->
	 
	 <div id="login">
	  <div id="copyright">
     &copy; 2011 IAAS. All Rights Reserved. <br />
300 High Street Closter, NJ 07624 <br />
Tel  201-767-1144 <br />
Fax  201-767-3733 <br />
<a href="mailto:iaasnj@gmail.com">iaasnj@gmail.com</a>  <br />

     Webmaster <a href="http://www.goodymedia.com" target="new">Goodymedia</a><br />

	 </div><!--END COPYRIGHT --> 
  
	 <jdoc:include type="modules" name="bottom" style="fx" /><!--LOGIN MODULE-->
    </div><!--END LOGIN MODULE-->
	
	<jdoc:include type="modules" name="debug" />
			

	</body>
</html>