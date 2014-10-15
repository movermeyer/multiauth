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
 * The login special page
 *
 * @author Florian Löffler <florian.loeffler@rrze.uni-erlangen.de>
 *
 */
class MultiAuthSpecialLogin extends SpecialPage {
	
	/**
	 * @var MultiAuthPlugin
	 * reference to the active instance of the MultiAuthPlugin
	 */
	var $multiAuthPlugin = null;

	/**
	 * @var array
	 * list of all the links to be displayed on this page
	 */
	var $linkList = null;


	/**
	 * Default constructor
	 * @see includes/SpecialPage.php
	 */
	function __construct() {
		// The name should be the same as the id of the special page
		parent::__construct('MultiAuthSpecialLogin', '', true, false, 'default', false);

		// get a reference to an instance of the multi auth plugin
		global $wgMultiAuthPlugin;
		$this->multiAuthPlugin =  &$wgMultiAuthPlugin;

		$linkList = array();
	}
	

	/**
	 * This function is called when the special page is accessed
	 * @param $par parameters
	 * @see includes/SpecialPage.php
	 */
	function execute($par) {
		global $wgRequest, $wgOut;

		$this->setHeaders();
		$param = $wgRequest->getText('param');
		wfDebugLog(basename(__FILE__,".php"), __METHOD__ . ': ' . "Parameters: ${param}");
		
		// build the page
		$html = "";

		if ($this->multiAuthPlugin->isLoggedIn()) {

			// login success
			$html .= "<p>" . wfMsg('multiauthspeciallogin-msg_loginSuccess') . "</p>\n";

		}
		else if (isset($_GET['method']) && $this->multiAuthPlugin->isValidMethod($_GET['method'])) {

			$this->initLogin($_GET['method']);
			// the above function will issue a redirect

		}
		else if (!is_null($this->multiAuthPlugin->getCurrentMethodName()) && $this->multiAuthPlugin->getCurrentMethodName() != 'local') {
				
			// external authentication success but not authorized
			$html .= "<p>" . wfMsg('multiauthspeciallogin-msg_notAuthorized') . "</p>\n";
			unset($_SESSION['MA_methodName']);
				
		}
		else {

			$this->addLoginLinks($html);

		}
		
				
		$wgOut->addHTML($html);
		$wgOut->returnToMain();
	}

	/**
	 * Saves the chosen method name in the session and initialises
	 * the external login process.
	 *
	 * @param $methodName
	 * Name of the chosen login method
	 */
	private function initLogin($methodName) {
		$method = $this->multiAuthPlugin->getMethod($methodName);
		if  (!empty($method)){

			// save selected method name
			$_SESSION['MA_methodName'] = $methodName;
			wfDebugLog('MultiAuthPlugin', __METHOD__ . ': '  . ': ' . "SESSION['MA_methodName'] = {$methodName}");

			$libName = $this->multiAuthPlugin->getAuthLib($methodName);
			wfDebugLog('MultiAuthPlugin', __METHOD__ . ': '  . ': ' . "Method auth settings: " . print_r($method['auth'], true));
			switch ($libName) {
				case 'simplesamlphp':
					// init the external login
					$ssphpPath = $this->multiAuthPlugin->config['paths']['libs']['simplesamlphp'];
					require_once($ssphpPath . "/lib/_autoload.php");
					
					$as = new SimpleSAML_Auth_Simple($method['auth']['spentityid']);

					$return_url = $this->buildReturnURL($methodName);
					wfDebugLog('MultiAuthPlugin', __METHOD__ . ': '  . ': ' . "Redirecting to SSO login process: [SimpleSamlPHP] ReturnTo = {$return_url}");
					if (isset($method['auth']['idpentityid'])) {
						$as->login(array('ReturnTo' => $return_url, 'saml:idp' => $method['auth']['idpentityid']));
					}
					else {
						$as->login(array('ReturnTo' => $return_url));
					}
					exit;
				break;

				default:
					$target = $this->buildLink($methodName);
					wfDebugLog('MultiAuthPlugin', __METHOD__ . ': '  . ': ' . "Redirecting to SSO login process: [URL] {$target}");
					header("Location: " . $target);
					exit;
				break;
			}
		}
	}


	/**
	 * Builds and adds the login links for all activated methods to the
	 * HTML code of the page.
	 * @param string $html
	 * reference to the HTML content string
	 * @return string
	 * the HTML content string
	 */
	private function addLoginLinks(&$html) {
		// build the linkList
		$this->buildLinkList();

		// add the html
		$html .= "<ul>\n";
		foreach($this->linkList as $link) {
			$html .= "\t<li><a href=\"" . $link['href'] . "\">" . $link['text'] . "</a></li>\n";
		}
		$html .= "</ul>\n";
		return $html;
	}

	/**
	 * Builds a list of all activated methods and their respective login
	 * links and texts.
	 * The list is stored within the object.
	 */
	private function buildLinkList() {
		// get a list of all the activated method names
		$activatedMethods = $this->multiAuthPlugin->getActivatedMethods();

		// walk all configured authentication methods
		foreach ($activatedMethods as $methodName => $method) {
			$link = $method['login'];
			$link_text = $link['text'];
			
			if (isset($_REQUEST['returnto'])) {
				$link_href = SpecialPage::getTitleFor('MultiAuthSpecialLogin')->escapeFullURL() . '?returnto=' . $_REQUEST['returnto']. '&method=' . $methodName;
			}
			else {
				$link_href = SpecialPage::getTitleFor('MultiAuthSpecialLogin')->escapeFullURL() . '?method=' . $methodName;
			}
				
			// configure the link
			$this->linkList['MA_' . $methodName . '_Login'] = array(
				'text' => $link_text,
				'href' => $link_href,
			);
		}
	}

	
	private function buildReturnURL($methodName) {
		if ($methodName == 'local') {
			$return_url = (isset($_REQUEST['returnto']))?$_REQUEST['returnto']:'';
		}
		else {
			$returnto = (isset($_REQUEST['returnto']))?'?returnto='.$_REQUEST['returnto']:'';
			$return_url = SpecialPage::getTitleFor('MultiAuthSpecialLogin')->escapeFullURL() . $returnto;
		}
		
		wfDebugLog('MultiAuthPlugin', __METHOD__ . ': '  . ': ' . "returnTo = " . $return_url);
		
		return $return_url;
	}
	
	
	/**
	 * Builds a proper login link for the given method object.
	 *
	 * @param $methodName
	 * the method name to use for login
	 * @return String
	 * properly built login link for the given method
	 */
	private function buildLink($methodName) {
		$method = $this->multiAuthPlugin->getMethod($methodName);
		$link = $method['login'];
		$link_href = $link['href'];

		if (strstr($link_href, '{RETURN_URL}')) {
			$return_url = $this->buildReturnURL($methodName);
			$link_href = str_replace('{RETURN_URL}', wfUrlencode($return_url), $link_href);
		}
		return $link_href;
	}

	
}

?>
