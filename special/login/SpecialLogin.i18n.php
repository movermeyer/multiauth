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


/**
 * Internationalisation file for MultiAuthSpecial
 */
  
$messages = array();


$messages['de'] = array(
	// This is the page title (Note: The key has to be all lowercase and the same as the id of the special page)
	// see http://www.mediawiki.org/wiki/Manual:Special_pages#The_Messages_File
	'multiauthspeciallogin' => 'MultiAuth Anmeldeseite',  
	
	'multiauthspeciallogin-credits_name' => 'MultiAuth Anmeldeseite',
	'multiauthspeciallogin-credits_author' => 'Regionales Rechenzentrum Erlangen (RRZE), Florian Löffler',
	'multiauthspeciallogin-credits_description' => 'Login Spezialseite als Teil der Multi Authentifizierungserweiterung',

	'multiauthspeciallogin-msg_loginSuccess' => 'Erfolgreich eingeloggt!',
	'multiauthspeciallogin-msg_notAuthorized' => 'Erfolgreiche externe Authentifizierung.<br/>Sie besitzen jedoch leider keine Zugriffsberechtigung für dieses Wiki!'
);


$messages['en'] = array(
	// This is the page title (Note: The key has to be all lowercase and the same as the id of the special page)
	// see http://www.mediawiki.org/wiki/Manual:Special_pages#The_Messages_File
	'multiauthspeciallogin' => 'MultiAuth login page',  
	
	'multiauthspeciallogin-credits_name' => 'MultiAuth login page',
	'multiauthspeciallogin-credits_author' => 'Regional Computing Centre Erlangen (RRZE), Florian Löffler',
	'multiauthspeciallogin-credits_description' => 'Login special page as part of the Multi Authentication Plugin',

	'multiauthspeciallogin-msg_loginSuccess' => 'Successfully logged in!',
	'multiauthspeciallogin-msg_notAuthorized' => 'Successful external authentication.<br/>Unfortunately you do not have the necessary rights to access this wiki.'
);

if (MwFunctions::testVersionGEq(1,18))
	include(dirname(__FILE__) . '/SpecialLogin.alias.php'); // Hack for post 1.18.0


?>
