<?php
/**
* Registration Links ( inner processing routines ).
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
* @package s2Member\Registrations
* @since 3.5
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_register_in"))
	{
		/**
		* Registration Links ( inner processing routines ).
		*
		* @package s2Member\Registrations
		* @since 3.5
		*/
		class c_ws_plugin__s2member_register_in
			{
				/**
				* Handles Registration Links.
				*
				* @package s2Member\Registrations
				* @since 3.5
				*
				* @attaches-to: ``add_action("init");``
				*
				* @return null Or exits script execution after redirection.
				*/
				public static function register ()
					{
						do_action ("ws_plugin__s2member_before_register", get_defined_vars ());
						/**/
						if (!empty ($_GET["s2member_register"])) /* If they're attempting to access the registration system. */
							{
								if (is_array ($register = preg_split ("/\:\.\:\|\:\.\:/", c_ws_plugin__s2member_utils_encryption::decrypt (trim (stripslashes ($_GET["s2member_register"]))))))
									{
										if (count ($register) === 6 && $register[0] === "subscr_gateway_subscr_id_custom_item_number_time" && $register[1] && $register[2] && $register[3] && $register[4] && $register[5])
											{
												if ($register[5] <= strtotime ("now") && $register[5] >= strtotime ("-" . apply_filters ("ws_plugin__s2member_register_link_exp_time", "2 days", get_defined_vars ())))
													{
														setcookie ("s2member_subscr_gateway", c_ws_plugin__s2member_utils_encryption::encrypt ($register[1]), time () + 31556926, "/");
														setcookie ("s2member_subscr_id", c_ws_plugin__s2member_utils_encryption::encrypt ($register[2]), time () + 31556926, "/");
														setcookie ("s2member_custom", c_ws_plugin__s2member_utils_encryption::encrypt ($register[3]), time () + 31556926, "/");
														setcookie ("s2member_level", c_ws_plugin__s2member_utils_encryption::encrypt ($register[4]), time () + 31556926, "/");
														/**/
														do_action ("ws_plugin__s2member_during_register", get_defined_vars ());
														/**/
														if (is_multisite () && c_ws_plugin__s2member_utils_conds::is_multisite_farm () && is_main_site ())
															{
																echo '<script type="text/javascript">' . "\n";
																echo "window.location = '" . esc_js (c_ws_plugin__s2member_utils_urls::wp_signup_url ()) . "';";
																echo '</script>' . "\n";
															}
														else /* Otherwise, this is NOT a Multisite install. Or it is, but the Super Admin is NOT selling Blogs. */
															{
																echo '<script type="text/javascript">' . "\n";
																echo "window.location = '" . esc_js (c_ws_plugin__s2member_utils_urls::wp_register_url ()) . "';";
																echo '</script>' . "\n";
															}
													}
											}
									}
								/**/
								echo '<strong>Your Link Expired:</strong><br />Please contact Support if you need assistance.';
								/**/
								exit (); /* $_GET["s2member_register"] has expired. Or simply invalid. */
							}
						/**/
						do_action ("ws_plugin__s2member_after_register", get_defined_vars ());
					}
			}
	}
?>