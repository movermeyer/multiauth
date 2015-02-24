##Disclaimer (08.02.2015)

This repository was set up to try to save the source code of the [Mediawiki MultiAuthPlugin extension](https://www.mediawiki.org/wiki/Extension:MultiAuthPlugin).

Since the original source code repository was already offline before I created this repo, I pulled the code from a copy I happened to have in production.
Unfortunately, I had modified the code somewhat to serve my needs in production (Nothing serious, just some customization.) 

I tried to revert the code to the way it was before my changes. However, I can't guarantee that I have found and reverted all of my changes. If you're curious about what sort of changes I did, you can check out the first few commits of this repo to see what I reverted.

This version has been imortalized in the [v1.4 branch](https://github.com/movermeyer/multiauth/tree/v1.4).

I have since made some changes to the code to allow it to work on modern Mediawiki versions. With these changes, I have targetted Mediawiki 1.24. In doing so, I have broken compatibility with some older versions of Mediawiki.

This extension should still be considered unmaintained. I have no intention to become the maintainer of this extension, and I'm not even sure that the extension should be used or considered secure in modern versions of Mediawiki. I just thought it was a shame that the original SVN repo went offline.


MediaWiki MultiAuthPlugin v1.4.0 (05.01.2012)
--------------------------------

0. Quick usage
--------------
The 'MultiAuthPlugin/' folder should be placed under the 'wiki/extensions/' directory.

The plugin can be activated by putting the following lines at the _end_ 
of the 'wiki/LocalSettings.php'

	if (!$wgCommandLineMode) {
	    require_once("extensions/MultiAuthPlugin/MultiAuthPlugin.php");
	}

To activate the debug log capability you have to make the 'log/' directory 
writeable by the web server and create a 'log/debug.log' file - also writeable 
by the web server.




1. Introduction
---------------
At the Regional Computing Centre Erlangen (RRZE) we use the popular MediaWiki
software (http://www.mediawiki.org/) in many projects for documentation and
publication purposes.

With the development of a Single Sign On infrastructure based on SimpleSAMLphp
and Shibboleth we needed to make MediaWiki SSO capable in a flexible and easily
configurable way. We are aware that there are already extensions out there
providing simple SSO capabilities, but we wanted more.

So we started developing the MediaWiki MultiAuthPlugin with the goal to provide
a single plugin to manage all possible authentication scenarios with one
single extension -- for example local authentication via original 
MediaWiki login dialog (as fallback), SSO via Shibboleth, SSO via
SimpleSAMLphp, and so on.




2. Requirements
---------------
The MediaWiki MultiAuthPlugin v1.4.0 was developed and tested using MediaWiki v1.18.0
and SimpleSamlPHP v1.8.0. 
So it should be working flawlessly with these versions. 




3. Features
-----------
The MultiAuthPlugin hacks into MW's UserLoadFromSession Hook and replaces the
global $wgAuth authentication instance to take complete control of the user
authentication.

In addition the extension also installs two new special pages to replace the 
original login/logout special pages. This way the user can choose how he would
like to authenticate from the configured methods.

The plugin allows you to 
	- use local MW authentication in parallel with external authentication
	- completely forbid local authentication - if desired
	- configure an external authentication library for SSO
		Currently one of {Shibboleth, SimpleSAMLphp} or both is possible
	- auto-create local user accounts if authenticated externally
	- auto-update changed user preferences in local user accounts if 
		authenticated externally
	- send e-mail notification about auto-created users to a configurable e-mail 
		address


If you make the log/ directory writeable the extension also provides a 
debug.log file to help you identify possible errors.


4. Notes
--------
There are some localisation issues known. At the moment the MultiAuthPlugin
calls MessageCache->recache() once per call which is less than ideal for
performance reasons.
If someone can provide a fix for this you would be very welcome to let me know ;) 


