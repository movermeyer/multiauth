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

/**
 * Some mw-related convenience functions
 *
 * @author Florian Löffler <florian.loeffler@rrze.uni-erlangen.de>
 */
class MwFunctions {

	private static $chachedMwVersionParts = null;

	/**
	 * Detect requests to load.php
	 */
	static function isAsyncLoadRequest() {
		if (strstr($_SERVER['SCRIPT_NAME'], 'load.php'))
			return true; 
	}
	
	static function updateMessageCache() {
		if (MwFunctions::isAsyncLoadRequest())
			return false; // skip subsequent calls to load stuff
		
		global $wgLang;
		$langCode = $wgLang->getCode();
		wfDebugLog('MultiAuthPlugin', __METHOD__ . ': ' . "Detected lang: {$langCode}");
		
		Language::getLocalisationCache()->recache($langCode); // hack for post 1.18.0
		
		return true;
	}
	
	
	private static function getVersionParts() {
		if (is_null(self::$chachedMwVersionParts)) {
			global $wgVersion;
			// 		wfDebugLog('MultiAuthPlugin', __METHOD__ . ': ' . "Detected MW " . $wgVersion);

			$parts = explode('.', $wgVersion);
			$major = intval($parts[0]);
			$minor = intval($parts[1]);
			$patch = intval($parts[2]);

			wfDebugLog('MultiAuthPlugin', __METHOD__ . ': ' . "Detected MW version: major {$major}, minor {$minor}, patch {$patch}");



			self::$chachedMwVersionParts = array(
					'major' => $major,
					'minor' => $minor,
					'patch' => $patch
			);
		}
		
		return self::$chachedMwVersionParts;
	}

	static function testVersionEq($major, $minor = null, $patch = null) {
		$version = self::getVersionParts();
	
	
		if ($major != $version['major'])
			return false;
	
		if (!is_null($minor) && $minor != $version['minor'])
			return false;
	
		if (!is_null($patch) && $patch != $version['patch'])
			return false;
	
		return true;
	}

	
	static function testVersionGEq($major, $minor = null, $patch = null) {
		$version = self::getVersionParts();
	
		if ($major < $version['major'])
			return false;
	
		if (!is_null($minor) && $minor < $version['minor'])
			return false;
				
		if (!is_null($patch) && $patch < $version['patch'])
			return false;
				
		return true;
	}
	
	
}

?>