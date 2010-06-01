<?php
/*
Copyright: © 2009 WebSharks, Inc. ( coded in the USA )
<mailto:support@websharks-inc.com> <http://www.websharks-inc.com/>

Released under the terms of the GNU General Public License.
You should have received a copy of the GNU General Public License,
along with this software. In the main directory, see: /licensing/
If not, see: <http://www.gnu.org/licenses/>.
*/
/*
Version: 3.0.4
Stable tag: 3.0.4
Framework: WS-P-3.0

WordPress Compatible: yes
BuddyPress Compatible: yes
WP Multisite Compatible: soon
Multisite Blog Farm Compatible: no

Tested up to: 3.0
Requires at least: 2.9.2
Requires: WordPress® 2.9.2+, PHP 5.2+

Copyright: © 2009 WebSharks, Inc.
License: GNU General Public License
Contributors: WebSharks, PriMoThemes
Author URI: http://www.primothemes.com/
Author: PriMoThemes.com / WebSharks, Inc.
Donate link: http://www.primothemes.com/donate/

Plugin Name: s2Member
Forum URI: http://www.primothemes.com/forums/viewforum.php?f=4
Professional Installation URI: http://www.primothemes.com/support/
Plugin URI: http://www.primothemes.com/post/s2member-membership-plugin-with-paypal/
Description: Empowers WordPress® with membership capabilities. Integrates seamlessly with PayPal®. Also compatible with the BuddyPress plugin for WP.
Tags: membership, members, member, register, signup, paypal, pay pal, s2member, subscriber, members only, buddypress, buddy press, buddy press compatible, shopping cart, checkout, api, options panel included, websharks framework, w3c validated code, multi widget support, includes extensive documentation, highly extensible
*/
/*
Direct access denial.
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit;
/*
Compatibility checks.
*/
if (version_compare (PHP_VERSION, "5.2", ">=") && version_compare (get_bloginfo ("version"), "2.9.2", ">=") && !isset ($GLOBALS["WS_PLUGIN__"]["s2member"]))
	{
		$GLOBALS["WS_PLUGIN__"]["s2member"]["l"] = __FILE__;
		/*
		Hook before loaded.
		*/
		do_action("ws_plugin__s2member_before_loaded");
		/*
		System configuraton.
		*/
		include_once dirname (__FILE__) . "/includes/syscon.inc.php";
		/*
		Hooks and filters.
		*/
		include_once dirname (__FILE__) . "/includes/hooks.inc.php";
		/*
		Hook after system config & hooks are loaded.
		*/
		do_action("ws_plugin__s2member_config_hooks_loaded");
		/*
		Function includes.
		*/
		include_once dirname (__FILE__) . "/includes/funcs.inc.php";
		/*
		Include shortcodes.
		*/
		include_once dirname (__FILE__) . "/includes/codes.inc.php";
	}
/*
Else handle incompatibilities.
*/
else if (is_admin ()) /* Admin compatibility errors. */
	{
		if (!version_compare (PHP_VERSION, "5.2", ">="))
			{
				add_action ("admin_notices", create_function ('', 'echo \'<div class="error fade"><p>You need PHP version 5.2 or higher to use the s2Member plugin.</p></div>\';'));
			}
		else if (!version_compare (get_bloginfo ("version"), "2.9.2", ">="))
			{
				add_action ("admin_notices", create_function ('', 'echo \'<div class="error fade"><p>You need WordPress® 2.9.2 or higher to use the s2Member plugin.</p></div>\';'));
			}
	}
?>