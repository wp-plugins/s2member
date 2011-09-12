<?php
/**
* Specific Post/Page Access routines.
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
* @package s2Member\SP_Access
* @since 3.5
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_sp_access"))
	{
		/**
		* Specific Post/Page Access routines.
		*
		* @package s2Member\SP_Access
		* @since 3.5
		*/
		class c_ws_plugin__s2member_sp_access
			{
				/**
				* Generates Specific Post/Page Access links.
				*
				* @package s2Member\SP_Access
				* @since 3.5
				*
				* @param str $sp_ids Comma-delimited list of Specific Post/Page IDs *( numerical )*.
				* @param int $hours Optional. An expiration time for this link, in hours. Defaults to `72`.
				* @param bool $shrink Optional. Defaults to true. If false, the raw link will NOT be processed by the tinyURL API.
				* @return str|bool A Specific Post/Page Access Link, or false on failure.
				*/
				public static function sp_access_link_gen ($sp_ids = FALSE, $hours = 72, $shrink = TRUE)
					{
						eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_sp_access_link_gen", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if (($sp_ids = preg_replace ("/[^0-9;,]/", "", $sp_ids)) && ($leading_id = preg_replace ("/^([0-9]+)(.*?)$/", "$1", $sp_ids)) && $hours)
							{
								$sp_access = c_ws_plugin__s2member_utils_encryption::encrypt ("sp_time_hours:.:|:.:" . $sp_ids . ":.:|:.:" . strtotime ("now") . ":.:|:.:" . $hours);
								$sp_access_link = add_query_arg ("s2member_sp_access", urlencode ($sp_access), get_permalink ($leading_id));
								/**/
								if ($shrink && ($_alternative = apply_filters ("ws_plugin__s2member_sp_access_link_gen_alternative", $sp_access_link, get_defined_vars ())) && strlen ($_alternative) < strlen ($sp_access_link))
									return apply_filters ("ws_plugin__s2member_sp_access_link_gen", $_alternative, get_defined_vars ());
								/**/
								else if ($shrink && ($tinyurl = c_ws_plugin__s2member_utils_urls::remote ("http://tinyurl.com/api-create.php?url=" . rawurlencode ($sp_access_link))))
									return apply_filters ("ws_plugin__s2member_sp_access_link_gen", $tinyurl . "#" . $_SERVER["HTTP_HOST"], get_defined_vars ());
								/**/
								else /* Else use the long one; tinyURL will fail when/if their server is down periodically. */
									return apply_filters ("ws_plugin__s2member_sp_access_link_gen", $sp_access_link, get_defined_vars ());
							}
						/**/
						return false;
					}
				/**
				* Generates Specific Post/Page Access links via AJAX.
				*
				* @package s2Member\SP_Access
				* @since 3.5
				*
				* @attaches-to: ``add_action("wp_ajax_ws_plugin__s2member_sp_access_link_via_ajax");``
				*
				* @return null Exits script execution after returning data for AJAX caller.
				*/
				public static function sp_access_link_via_ajax ()
					{
						do_action ("ws_plugin__s2member_before_sp_access_link_via_ajax", get_defined_vars ());
						/**/
						if (current_user_can ("create_users")) /* Check priveledges as well. */
							if (!empty ($_POST["ws_plugin__s2member_sp_access_link_via_ajax"]) && ($nonce = $_POST["ws_plugin__s2member_sp_access_link_via_ajax"]) && wp_verify_nonce ($nonce, "ws-plugin--s2member-sp-access-link-via-ajax") && ($_p = c_ws_plugin__s2member_utils_strings::trim_deep (stripslashes_deep ($_POST))) && isset ($_p["s2member_sp_access_link_ids"], $_p["s2member_sp_access_link_hours"]))
								echo apply_filters ("ws_plugin__s2member_sp_access_link_via_ajax", c_ws_plugin__s2member_sp_access::sp_access_link_gen ($_p["s2member_sp_access_link_ids"], $_p["s2member_sp_access_link_hours"]), get_defined_vars ());
						/**/
						exit (); /* Clean exit. */
					}
				/**
				* Handles Specific Post/Page Access authentication.
				*
				* @package s2Member\SP_Access
				* @since 3.5
				*
				* @param int|str $sp_id Numeric Post/Page ID in WordPress®.
				* @param bool $read_only Optional. Defaults to false. If ``$read_only = true``,
				* 	no session cookies are set, no IP Restrictions are checked, and script execution is not exited on Link failure.
				* 	In other words, with ``$read_only = true``, this function will simply return true or false.
				* @return null|bool Always returns true if access is indeed allowed in one way or another.
				* 	If access is denied with ``$read_only = true`` simply return false.
				* 	If access is denied with ``$read_only = false``, return false;
				* 	but if a Specific Post/Page Access Link is currently being used,
				* 	we exit with a warning about Access Link expiration instead.
				*/
				public static function sp_access ($sp_id = FALSE, $read_only = FALSE)
					{
						do_action ("ws_plugin__s2member_before_sp_access", get_defined_vars ());
						/**/
						$excluded = apply_filters ("ws_plugin__s2member_sp_access_excluded", false, get_defined_vars ());
						/**/
						if ($excluded || current_user_can (apply_filters ("ws_plugin__s2member_sp_access_excluded_cap", "edit_posts", get_defined_vars ())))
							return apply_filters ("ws_plugin__s2member_sp_access", true, get_defined_vars ());
						/**/
						else if ($sp_id && ((!empty ($_GET["s2member_sp_access"]) && is_array ($sp_access_values = (array)trim (stripslashes ($_GET["s2member_sp_access"])))) || (is_array ($sp_access_values = c_ws_plugin__s2member_sp_access::sp_access_session ()) && !empty ($sp_access_values))))
							{
								foreach ($sp_access_values as $sp_access_value) /* Supports multiple access values in a session. */
									{
										if (is_array ($sp_access = preg_split ("/\:\.\:\|\:\.\:/", c_ws_plugin__s2member_utils_encryption::decrypt ($sp_access_value))))
											{
												if (count ($sp_access) === 4 && $sp_access[0] === "sp_time_hours" && in_array ($sp_id, preg_split ("/[\r\n\t\s;,]+/", $sp_access[1])))
													{
														if ($sp_access[2] <= strtotime ("now") && ($sp_access[2] + ($sp_access[3] * 3600)) >= strtotime ("now"))
															{
																if (!$read_only && !empty ($_GET["s2member_sp_access"])) /* Cookie session. */
																	c_ws_plugin__s2member_sp_access::sp_access_session ($_GET["s2member_sp_access"]);
																/**/
																if ($read_only || c_ws_plugin__s2member_ip_restrictions::ip_restrictions_ok ($_SERVER["REMOTE_ADDR"], $sp_access_value))
																	return apply_filters ("ws_plugin__s2member_sp_access", true, get_defined_vars ());
															}
													}
											}
									}
								/**/
								if (!$read_only && !empty ($_GET["s2member_sp_access"])) /* If this is a Specific Post/Page Link? */
									{
										echo _x ('<strong>Your Link Expired:</strong><br />Please contact Support if you need assistance.', "s2member-front", "s2member");
										/**/
										exit (); /* $_GET["s2member_sp_access"] has expired. Or it is simply invalid. */
									}
								/**/
								return apply_filters ("ws_plugin__s2member_sp_access", false, get_defined_vars ());
							}
						/**/
						else
							return apply_filters ("ws_plugin__s2member_sp_access", false, get_defined_vars ());
					}
				/**
				* Handles Specific Post/Page sessions, by writing access values into a cookie.
				*
				* Can be used to add a new value to the session, and/or to return the current set of values in the session.
				*
				* @package s2Member\SP_Access
				* @since 3.5
				*
				* @param str $add_sp_access_value Encrypted Specific Post/Page Access value.
				* @return array Array of Specific Post/Page Access values.
				*/
				public static function sp_access_session ($add_sp_access_value = FALSE)
					{
						eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_sp_access_session", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						$sp_access_values = (!empty ($_COOKIE["s2member_sp_access"])) ? preg_split ("/\:\.\:\|\:\.\:/", $_COOKIE["s2member_sp_access"]) : array ();
						/**/
						if ($add_sp_access_value && !in_array ($add_sp_access_value, $sp_access_values)) /* If it's not in the session already. */
							{
								$sp_access_values[] = $add_sp_access_value; /* Add an access value, and update the delimited session cookie. */
								$sp_access_values = array_unique ($sp_access_values); /* Keep this array unique; disallow double-stacking. */
								/**/
								$cookie = implode (":.:|:.:", $sp_access_values); /* Implode the access values into a delimited string. */
								$cookie = (strlen ($cookie) >= 4096) ? $add_sp_access_value : $cookie; /* Max cookie size is 4kbs. */
								/**/
								setcookie ("s2member_sp_access", $cookie, time () + 31556926, COOKIEPATH, COOKIE_DOMAIN) . setcookie ("s2member_sp_access", $cookie, time () + 31556926, SITECOOKIEPATH, COOKIE_DOMAIN) . ($_COOKIE["s2member_sp_access"] = $cookie);
								/**/
								eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_sp_access_session", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
							}
						/**/
						return apply_filters ("ws_plugin__s2member_sp_access_session", $sp_access_values, get_defined_vars ());
					}
			}
	}
?>