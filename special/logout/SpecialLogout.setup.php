<?php
/*
 * This file is part of the MediaWiki MultiAuth extension.
 * Copyright 2009-2012, RRZE, and individual contributors
 * as indicated by the @author tags. See the copyright.txt file in the
 * distribution for a full listing of individual contributors.
 *
 * This is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This software is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this software.  If not, write to the Free Software 
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 
 * USA, or see the FSF site: http://www.fsf.org.
 */

// Check to make sure we're actually in MediaWiki.
if (!defined('MEDIAWIKI')) die('This file is part of MediaWiki. It is not a valid entry point.');

/* ********************************************
 *            LOAD SPECIAL PAGE             *
 ******************************************** */

require_once("SpecialLogout.body.php");


/* ********************************************
 *            SPECIAL PAGE SETUP            *
 ******************************************** */


// registering the id of the special page and the class to use
global $wgSpecialPages;
$wgSpecialPages['MultiAuthSpecialLogout'] = 'MultiAuthSpecialLogout';
// setting the special page group
global $wgSpecialPageGroups;
$wgSpecialPageGroups['MultiAuthSpecialLogout'] = 'login';


// localization
global $wgMessagesDirs;
$wgMessagesDirs['MultiAuthSpecialLogout'] = __DIR__ . '/i18n';

/* ********************************************
 *             DEFERRED SETUP               *
 ******************************************** */
/**
 * Setup function for the MultiAuth logout special page.
 * This is called via the $wgExtensionFunctions hook
 * @see http://www.mediawiki.org/wiki/Manual:$wgExtensionFunctions
 * @return boolean
 */
function multiAuthLogoutSetup() {
	global $wgExtensionMessagesFiles;
	global $wgExtensionCredits;
	global $wgMultiAuthPlugin;

	// aliases
	$wgExtensionMessagesFiles['MultiAuthSpecialLogoutAlias'] = __DIR__ . '/SpecialLogout.alias.php';
	
	// credits
	$wgExtensionCredits['specialpage']['MultiAuthSpecialLogout'] = array(
// 		'name' 			=> wfMessage('multiauthspeciallogout-credits_name')->text(),
// 		'author' 		=> wfMessage('multiauthspeciallogout-credits_author')->text(), 
// 		'description' 	=> wfMessage('multiauthspeciallogout-credits_description')->text(),
		'path' 			=> __FILE__,
		'version'		=> $wgMultiAuthPlugin->getVersion(),
		'url' 			=> $wgMultiAuthPlugin->getURL(), 
	);

	return true;
}

// register deferred setup functionn
global $wgExtensionFunctions;
$wgExtensionFunctions[] = 'multiAuthLogoutSetup';


?>
