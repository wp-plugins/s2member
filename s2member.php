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
Version: 3.0.1
Stable tag: 3.0.1
Framework: WS-P-2.2

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
		/*
		Record the location of this file.
		*/
		$GLOBALS["WS_PLUGIN__"]["s2member"]["l"] = __FILE__;
		/*
		Function includes.
		*/
		include_once dirname (__FILE__) . "/includes/funcs.inc.php";
		/*
		Syscon includes.
		*/
		include_once dirname (__FILE__) . "/includes/syscon.inc.php";
		/*
		Hook includes.
		*/
		include_once dirname (__FILE__) . "/includes/hooks.inc.php";
	}
/*
Else handle incompatibilities.
*/
else if (is_admin () || ($_GET["preview"] && $_GET["template"]))
	{
		if (!version_compare (PHP_VERSION, "5.2", ">="))
			{
				register_shutdown_function (create_function ('', 'echo \'<script type="text/javascript">alert(\\\'You need PHP version 5.2 or higher to use the s2Member plugin.\\\');</script>\';'));
			}
		else if (!version_compare (get_bloginfo ("version"), "2.9.2", ">="))
			{
				register_shutdown_function (create_function ('', 'echo \'<script type="text/javascript">alert(\\\'You need WordPress® 2.9.2 or higher to use the s2Member plugin.\\\');</script>\';'));
			}
	}
?>