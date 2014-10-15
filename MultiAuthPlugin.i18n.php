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
 * Internationalisation file for MultiAuthPlugin
 */
  
$messages = array();


$messages['de'] = array(
	'multiauth-credits_name' => 'MultiAuth Erweiterung',
	'multiauth-credits_author' => 'Regionales Rechenzentrum Erlangen (RRZE), Florian Löffler',
	'multiauth-credits_description' => 'Flexibel konfigurierbare Authentifizierungserweiterung',
	'multiauth-special_login_link' => 'Anmelden',
	'multiauth-special_logout_link' => 'Abmelden',
);


$messages['en'] = array(
	'multiauth-credits_name' => 'MultiAuth Plugin',
	'multiauth-credits_author' => 'Regional Computing Centre Erlangen (RRZE), Florian Löffler',
	'multiauth-credits_description' => 'Highly configurable authentication plugin',
	'multiauth-special_login_link' => 'Login to edit content',
	'multiauth-special_logout_link' => 'Logout',
);


?>
