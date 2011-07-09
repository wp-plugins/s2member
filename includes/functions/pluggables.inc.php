<?php
/**
* Pluggable functions within WordPress®.
*
* Copyright: © 2009-2011
* {@link http://www.websharks-inc.com/ WebSharks, Inc.}
* ( coded in the USA )
*
* Released under the terms of the GNU General Public License.
* You should have received a copy of the GNU General Public License,
* along with this software. In the main directory, see: /licensing/
* If not, see: {@link http://www.gnu.org/licenses/}.
*
* @package s2Member
* @since 110707
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit("Do not access this file directly.");
/**/
if (apply_filters ("ws_plugin__s2member_pluggable_wp_new_user_notification_ov", (!function_exists ("wp_new_user_notification"))))
	{
		/**
		* New User notifications.
		*
		* The arguments to this function are passed through the class method.
		*
		* @package s2Member
		* @since 110707
		*
		* @return null|class Return-value of class method.
		*/
		function wp_new_user_notification () /* Accepts any number of arguments. */
			{
				$args = func_get_args (); /* Pulls the arguments passed in to this function. */
				/**/
				return call_user_func_array ("c_ws_plugin__s2member_email_configs::new_user_notification", $args);
			}
		$GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["pluggables"]["wp_new_user_notification"] = true;
	}
?>