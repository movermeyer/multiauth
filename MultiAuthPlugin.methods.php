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
global $authData; // make auth data available for the methodSetupFile

/*
 * GENERAL NOTES
 * =============
 * 
 * 
 * 
 * SIMPLE SAML PHP
 * ---------------
 * When using SimpleSamlPHP for authentication -- aside from other configuration --
 * you have to make sure to change the SimpleSamlPHP's session.phpsession.cookiename
 * parameter in config/config.php to match the cookiename of your MW installation.
 * Otherwise you will get problems with lost state information in SimpleSamlPHP.
 *
 * The necessary changes are around line 204 in the config/config.php file:
 * 
 *   'session.phpsession.cookiename'  => 'test_mw_1_18_0_session',      <-- this needs to be changed
 *   'session.phpsession.savepath'    => null,
 *   'session.phpsession.httponly'    => FALSE,
 * 
 */




/* ********************************************
   *                  METHODS                 *
   ******************************************** */

$config['methods'] = array(
	/*
	 * UPDATE NOTE: 
	 * 	'local' method is hardcoded and does not need to be configured!
	 */	
	
	'shibboleth-default' => array(
		'auth' => array(
				'lib' => 'shibboleth',
				//'mode' => 'lazy', // This is the default
				),
			
		'login' => array(
			'text' => 'Login (SSO)',
			'href' => WebFunctions::getBaseURL() .  '/Shibboleth.sso/Login?target={RETURN_URL}',
		),
	
		'logout' => array(
			'text' => 'Logout (SLO)',
			'href' => WebFunctions::getBaseURL() .  '/Shibboleth.sso/Logout?return={RETURN_URL}',
		),
		
		'attributes' => array(
			'username'	=> ucfirst($authData['uid']),
			'fullname'	=> $authData['cn'],
			'email'		=> $authData['mail'],
		),

		'requirements' => array(
			//'username' => '*',  	// this is always implied (hardcoded!)
			'email' => '*', 		// email is mandatory, but any value will be accepted 
		),
				
	),
	
	'simplesamlphp-default' => array(
			'auth' => array(
				'lib' => 'simplesamlphp',
// 				'spentityid' => 'default-sp',
				'idpentityid' => 'localhost-idp',
			), 
			
			'login' => array(
				'text' => 'Login (SSO)',
			),
	
			'logout' => array(
				'text' => 'Logout (SLO)',
			),
	
			'attributes' => array(
				'username'	=> ucfirst($authData['uid']),
				'fullname'	=> $authData['cn'],
				'email'	=> $authData['mail'],
			),
			
			'requirements' => array(
				//'username' => '*',  	// this is always implied (hardcoded!)
				'email' => '*', 		// email is mandatory, but any value will be accepted
			),
	),

	/**************************************************************************/
	/* SAMPLES TO BE COPIED AND MODIFIED                                      */
	/**************************************************************************/
	
	/*
	 * SAMPLE
	 * Shibboleth SP with some basic user mappings 
	 */
	'sample-shibboleth-default' => array(
		'config' => array(
				'lib' => 'shibboleth',
				//'mode' => 'lazy', // This is the default
				),
			
		'login' => array(
			'text' => 'SAMPLE - Login via Shibboleth SP default target',
			'href' => WebFunctions::getBaseURL() .  '/Shibboleth.sso/Login?target={RETURN_URL}',
		),
	
		'logout' => array(
			'text' => 'SAMPLE - Logout (SLO)',
			'href' => WebFunctions::getBaseURL() .  '/Shibboleth.sso/Logout?return={RETURN_URL}',
		),
		
		'attributes' => array(
			'username'	=> ucfirst($authData['uid']),
			'fullname'	=> $authData['cn'],
			'email'	=> $authData['mail'],
		),
		
	),
	
	/*
	 * SAMPLE
	 * Same as above but with some login requirements
	 */
	'sample-shibboleth-restricted' => array(
		'config' => array(
				'lib' => 'shibboleth',
				//'mode' => 'lazy', // This is the default
				),
			
		'login' => array(
			'text' => 'SAMPLE - Login via Shibboleth SP default target with requirements',
			//'text' => 'Login via Shibboleth SP (RRZE-SSO)',
			'href' => WebFunctions::getBaseURL() .  '/Shibboleth.sso/Login?target={RETURN_URL}',
		),
	
		'logout' => array(
			'text' => 'SAMPLE - Logout (SLO)',
			//'text' => 'Logout via Shibboleth SP (RRZE-SLO)',
			'href' => WebFunctions::getBaseURL() .  '/Shibboleth.sso/Logout?return={RETURN_URL}',
		),
		
		'attributes' => array(
			'username'	=> ucfirst($authData['uid']),
			'fullname'	=> $authData['cn'],
			'email'	=> $authData['mail'],
		),
		
		'requirements' => array(
			//'username' => '*',  // this is always implied (hardcoded!)
			'email' => '*', // email is mandatory, but any value will be accepted 
			'entitlement' => 'rrze_wiki', // entitlement has to be 'rrze_wiki'
		),
		
	),
	
	
	
	/*
	 * SAMPLE
	 * Shibboleth SP using a preconfigured application target 
	 * other than the default one 
	 */
	'sample-shibboleth-someApp' => array(
		'config' => array(
				'lib' => 'shibboleth',
				//'mode' => 'lazy', // This is the default
				),
		
		'login' => array(
			'text' => 'SAMPLE - Login via Shibboleth SP someApp target',
			'href' => WebFunctions::getBaseURL() .  '/Shibboleth.sso/Login/someApp?target={RETURN_URL}',
		),
	
		'logout' => array(
			'text' => 'SAMPLE - Logout (SLO)',
			'href' => WebFunctions::getBaseURL() .  '/Shibboleth.sso/Logout?return={RETURN_URL}',
		),

		'attributes' => array(
			'username'	=> ucfirst($authData['uid']),
			'fullname'	=> $authData['cn'],
			'email'	=> $authData['mail'],
		),
	),

    /*
	 * SAMPLE
	 * Shibboleth SP using a preconfigured application target
	 * other than the default one that is configured for Shibboleth
	 * using strict authentication via .htaccess and using an alternate logout
	 * target.
	 */
	'sample-shibboleth-someApp-strict' => array(
			'config' => array(
					'lib' => 'shibboleth',
					/*
					 * If Shibboleth is configured with strict authentication -- using
					 * .htaccess to secure the entire MW directory -- we cannot come back after
					 * logout without triggering an immediate login again.
					 * To avoid this set authMode to strict and configure an alternate logout target.
					 */
					'mode' => 'strict',
					'strictLogoutTarget' => 'https://www.sso.uni-erlangen.de/logout.html',
					),
	
			'login' => array(
					'text' => 'SAMPLE - Login via Shibboleth SP someApp target',
					'href' => WebFunctions::getBaseURL() .  '/Shibboleth.sso/Login/someApp?target={RETURN_URL}',
			),
	
			'logout' => array(
					'text' => 'SAMPLE - Logout (SLO)',
					'href' => WebFunctions::getBaseURL() .  '/Shibboleth.sso/Logout?return={RETURN_URL}',
			),
	
			'attributes' => array(
					'username'	=> ucfirst($authData['uid']),
					'fullname'	=> $authData['cn'],
					'email'	=> $authData['mail'],
			),
	),
	
		
	/*
	 * SAMPLE
	 * SimpleSamlPHP using the configured SP authsource and the given IdP.
	 * The default-sp authsource is configured by default, so no need to change that.
	 * 
	 * IMPORTANT: The idpentityid has to be configured or otherwise the user may
	 * choose one from the discovery service. Instead of doing this here you may also
	 * change the configuration for the default-sp authsource within the simplesamlphp
	 * config under config/authsources.php.
	 */
	'sample-simplesamlphp-default' => array(
			'config' => array(
					'lib' => 'simplesamlphp',
					//'spentityid' => 'default-sp', // This is the default
					),
			
			'login' => array(
					'text' => 'Login (SSO)',
			),
	
			'logout' => array(
					'text' => 'Logout (SLO)',
			),
	
			'attributes' => array(
					'username'	=> ucfirst($authData['uid']),
					'fullname'	=> $authData['cn'],
					'email'	=> $authData['mail'],
			),
	),
	
	/*
	 * SAMPLE
	 * SimpleSamlPHP using the configured SP authsource and the given IdP.
	 * The default-sp authsource is configured by default, so no need to change that.
	 * 
	 * IMPORTANT: The idpentityid has to be configured or otherwise the user may 
	 * choose one from the discovery service.Instead of doing this here you may also
	 * change the configuration for the default-sp authsource within the simplesamlphp
	 * config under config/authsources.php.
	 */
	'sample-simplesamlphp-someIdP' => array(
			'config' => array(
					'lib' => 'simplesamlphp',
					//'spentityid' => 'default-sp', // This is the default
					'idpentityid' => 'someIdP',
			),
	
			'login' => array(
					'text' => 'Login (SSO)',
			),
	
			'logout' => array(
					'text' => 'Logout (SLO)',
			),
	
			'attributes' => array(
					'username'	=> ucfirst($authData['uid']),
					'fullname'	=> $authData['cn'],
					'email'	=> $authData['mail'],
			),
	
			'requirements' => array(
				//'username' => '*',  	// this is always implied (hardcoded!)
				'email' => '*', 		// email is mandatory, but any value will be accepted
			),
	),
		
	
);

?>
