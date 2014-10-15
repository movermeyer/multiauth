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

require_once("SpecialLogin.body.php");


/* ********************************************
 *            SPECIAL PAGE SETUP            *
******************************************** */

// registering the id of the special page and the class to use
global $wgSpecialPages;
$wgSpecialPages['MultiAuthSpecialLogin'] = 'MultiAuthSpecialLogin';
// setting the special page group
global $wgSpecialPageGroups;
$wgSpecialPageGroups['MultiAuthSpecialLogin'] = 'login';



/* ********************************************
 *             DEFERRED SETUP               *
******************************************** */

function multiAuthLoginSetup() {
	global $wgExtensionMessagesFiles;
	global $wgExtensionCredits;
	global $wgExtensionAliasesFiles;
	global $wgMultiAuthPlugin;

	// localization
	$wgExtensionMessagesFiles['MultiAuthSpecialLogin'] = dirname(__FILE__) . '/SpecialLogin.i18n.php';
	if ( function_exists( 'wfLoadExtensionMessages' ) )
		wfLoadExtensionMessages('MultiAuthSpecialLogin'); // pre 1.18.0

// 	if (MwFunctions::testVersionGEq(1,18))
// 		MwFunctions::updateMessageCache(); // Hack for post 1.18.0
	
	
	// aliases
	if (!MwFunctions::testVersionGEq(1,18))
		$wgExtensionAliasesFiles['MultiAuthSpecialLogin'] = dirname(__FILE__) . '/SpecialLogin.alias.php';

	$wgExtensionCredits['specialpage']['MultiAuthSpecialLogin'] = array(
// 			'name' 			=> wfMsg('multiauthspeciallogin-credits_name'),
// 			'author' 		=> wfMsg('multiauthspeciallogin-credits_author'),
// 			'description' 	=> wfMsg('multiauthspeciallogin-credits_description'),
			'path' 			=> __FILE__,
			'version'		=> $wgMultiAuthPlugin->getVersion(),
			'url' 			=> $wgMultiAuthPlugin->getURL(),
	);
}

// register deferred setup functionn
global $wgExtensionFunctions;
$wgExtensionFunctions[] = 'multiAuthLoginSetup';


?>
