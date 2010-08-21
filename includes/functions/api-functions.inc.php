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
Direct access denial.
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit("Do not access this file directly.");
/*
API function for Conditionals.
This matches up with a Simple Conditional made available through a Shortcode.
Function `is_user_logged_in()` already exists in WordPress® core.
*/
if (!function_exists ("is_user_not_logged_in"))
	{
		function is_user_not_logged_in ()
			{
				return (!is_user_logged_in ());
			}
	}
/*
API function for Conditionals.
This matches up with a Simple Conditional made available through a Shortcode.
Function `current_user_can()` already exists in WordPress® core.
*/
if (!function_exists ("current_user_is"))
	{
		function current_user_is ($role = FALSE)
			{
				$role = ($role === "s2member_level0") ? "subscriber" : $role;
				return current_user_can (preg_replace ("/^access_/i", "", $role));
			}
	}
/*
API function for Conditionals.
This matches up with a Simple Conditional made available through a Shortcode.
Function `current_user_can()` already exists in WordPress® core.
*/
if (!function_exists ("current_user_is_not"))
	{
		function current_user_is_not ($role = FALSE)
			{
				$role = ($role === "s2member_level0") ? "subscriber" : $role;
				return (!current_user_can (preg_replace ("/^access_/i", "", $role)));
			}
	}
/*
API function for Conditionals.
This matches up with a Simple Conditional made available through a Shortcode.
Function `current_user_can_for_blog()` already exists in WordPress® core.
*/
if (!function_exists ("current_user_is_for_blog"))
	{
		function current_user_is_for_blog ($blog_id = FALSE, $role = FALSE)
			{
				$role = ($role === "s2member_level0") ? "subscriber" : $role;
				return current_user_can_for_blog ($blog_id, preg_replace ("/^access_/i", "", $role));
			}
	}
/*
API function for Conditionals.
This matches up with a Simple Conditional made available through a Shortcode.
Function `current_user_can_for_blog()` already exists in WordPress® core.
*/
if (!function_exists ("current_user_is_not_for_blog"))
	{
		function current_user_is_not_for_blog ($blog_id = FALSE, $role = FALSE)
			{
				$role = ($role === "s2member_level0") ? "subscriber" : $role;
				return (!current_user_can_for_blog ($blog_id, preg_replace ("/^access_/i", "", $role)));
			}
	}
/*
API function for Conditionals.
This matches up with a Simple Conditional made available through a Shortcode.
Function `current_user_can()` already exists in WordPress® core.
*/
if (!function_exists ("current_user_cannot"))
	{
		function current_user_cannot ($capability = FALSE)
			{
				return (!current_user_can ($capability));
			}
	}
/*
API function for Conditionals.
This matches up with a Simple Conditional made available through a Shortcode.
Function `current_user_can_for_blog()` already exists in WordPress® core.
*/
if (!function_exists ("current_user_cannot_for_blog"))
	{
		function current_user_cannot_for_blog ($blog_id = FALSE, $capability = FALSE)
			{
				return (!current_user_can_for_blog ($blog_id, $capability));
			}
	}
/*
Alias function for API Scripting usage.
Deprecated in v3.0.5. This will be removed in a future release.
Alias to: `ws_plugin__s2member_encrypt()`.
*/
if (!function_exists ("s2member_encrypt"))
	{
		function s2member_encrypt ($string = FALSE, $key = FALSE)
			{
				return ws_plugin__s2member_encrypt ($string, $key);
			}
	}
/*
Alias function for API Scripting usage.
Deprecated in v3.0.5. This will be removed in a future release.
Alias to: `ws_plugin__s2member_decrypt()`.
*/
if (!function_exists ("s2member_decrypt"))
	{
		function s2member_decrypt ($base64 = FALSE, $key = FALSE)
			{
				return ws_plugin__s2member_decrypt ($base64, $key);
			}
	}
/*
Alias function for API Scripting usage.
Deprecated in v3.0.5. This will be removed in a future release.
Alias to: `ws_plugin__s2member_xencrypt()`.
*/
if (!function_exists ("s2member_xencrypt"))
	{
		function s2member_xencrypt ($string = FALSE, $key = FALSE)
			{
				return ws_plugin__s2member_xencrypt ($string, $key);
			}
	}
/*
Alias function for API Scripting usage.
Deprecated in v3.0.5. This will be removed in a future release.
Alias to: `ws_plugin__s2member_xdecrypt()`.
*/
if (!function_exists ("s2member_xdecrypt"))
	{
		function s2member_xdecrypt ($base64 = FALSE, $key = FALSE)
			{
				return ws_plugin__s2member_xdecrypt ($base64, $key);
			}
	}
?>