<?php
/**
* Registration Access Links.
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
	exit ("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_register_access"))
	{
		/**
		* Registration Access Links.
		*
		* @package s2Member\Registrations
		* @since 3.5
		*/
		class c_ws_plugin__s2member_register_access
			{
				/**
				* Generates Registration Access Links.
				*
				* @package s2Member\Registrations
				* @since 3.5
				*
				* @param str $subscr_gateway Payment Gateway associated with a Customer.
				* @param str $subscr_id Unique Subscr. ID associated with Payment Gateway; associated with a Customer.
				* @param str $custom Custom String value *( as supplied in Shortcode )*; must start with installation domain name.
				* @param int|str $item_number An s2Member-generated `item_number` *( i.e. `1` for Level 1, or `level|ccaps|fixed-term`, or `sp|ids|expiration` )*.
				* @param bool $shrink Optional. Defaults to true. If false, the raw registration link will NOT be reduced in size through the tinyURL API.
				* @return str|bool A Registration Access Link on success, else false on failure.
				*/
				public static function register_link_gen ($subscr_gateway = FALSE, $subscr_id = FALSE, $custom = FALSE, $item_number = FALSE, $shrink = TRUE)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_register_link_gen", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if ($subscr_gateway && $subscr_id && $custom && $item_number) /* Must have all of these. */
							{
								$register = c_ws_plugin__s2member_utils_encryption::encrypt ("subscr_gateway_subscr_id_custom_item_number_time:.:|:.:" . $subscr_gateway . ":.:|:.:" . $subscr_id . ":.:|:.:" . $custom . ":.:|:.:" . $item_number . ":.:|:.:" . strtotime ("now"));
								$register_link = site_url ("/?s2member_register=" . urlencode ($register));
								/**/
								if ($shrink && ($_alternative = apply_filters ("ws_plugin__s2member_register_link_gen_alternative", $register_link, get_defined_vars ())) && strlen ($_alternative) < strlen ($register_link))
									return apply_filters ("ws_plugin__s2member_register_link_gen", $_alternative, get_defined_vars ());
								/**/
								else if ($shrink && ($tinyurl = c_ws_plugin__s2member_utils_urls::remote ("http://tinyurl.com/api-create.php?url=" . rawurlencode ($register_link))))
									return apply_filters ("ws_plugin__s2member_register_link_gen", $tinyurl . "#" . $_SERVER["HTTP_HOST"], get_defined_vars ());
								/**/
								else /* Else use the long one; tinyURL will fail when/if their server is down periodically. */
									return apply_filters ("ws_plugin__s2member_register_link_gen", $register_link, get_defined_vars ());
							}
						/**/
						return false;
					}
				/**
				* Generates Registration Access Links via AJAX.
				*
				* @package s2Member\Registrations
				* @since 3.5
				*
				* @attaches-to: ``add_action("wp_ajax_ws_plugin__s2member_reg_access_link_via_ajax");``
				*
				* @return null Exits script execution after output is generated for AJAX caller.
				*/
				public static function reg_access_link_via_ajax ()
					{
						do_action ("ws_plugin__s2member_before_reg_access_link_via_ajax", get_defined_vars ());
						/**/
						if (current_user_can ("create_users")) /* Check priveledges as well. */
							if (!empty ($_POST["ws_plugin__s2member_reg_access_link_via_ajax"]) && ($nonce = $_POST["ws_plugin__s2member_reg_access_link_via_ajax"]) && wp_verify_nonce ($nonce, "ws-plugin--s2member-reg-access-link-via-ajax") && ($_p = c_ws_plugin__s2member_utils_strings::trim_deep (stripslashes_deep ($_POST))) && isset ($_p["s2member_reg_access_link_subscr_gateway"], $_p["s2member_reg_access_link_subscr_id"], $_p["s2member_reg_access_link_custom"], $_p["s2member_reg_access_link_item_number"]))
								echo apply_filters ("ws_plugin__s2member_reg_access_link_via_ajax", c_ws_plugin__s2member_register_access::register_link_gen ($_p["s2member_reg_access_link_subscr_gateway"], $_p["s2member_reg_access_link_subscr_id"], $_p["s2member_reg_access_link_custom"], $_p["s2member_reg_access_link_item_number"]), get_defined_vars ());
						/**/
						exit (); /* Clean exit. */
					}
				/**
				* Checks registration cookies.
				*
				* @package s2Member\Registrations
				* @since 110707
				*
				* @return array|bool An array of cookies if they're OK, else false.
				*/
				public static function reg_cookies_ok ()
					{
						global $wpdb; /* Global database object reference. */
						/**/
						do_action ("ws_plugin__s2member_before_reg_cookies_ok", get_defined_vars ());
						/**/
						if (isset ($_COOKIE["s2member_subscr_gateway"], $_COOKIE["s2member_subscr_id"], $_COOKIE["s2member_custom"], $_COOKIE["s2member_item_number"]) && ($subscr_gateway = c_ws_plugin__s2member_utils_encryption::decrypt ($_COOKIE["s2member_subscr_gateway"])) && ($subscr_id = c_ws_plugin__s2member_utils_encryption::decrypt ($_COOKIE["s2member_subscr_id"])) && preg_match ("/^" . preg_quote (preg_replace ("/\:([0-9]+)$/", "", $_SERVER["HTTP_HOST"]), "/") . "/i", ($custom = c_ws_plugin__s2member_utils_encryption::decrypt ($_COOKIE["s2member_custom"]))) && preg_match ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["membership_item_number_regex"], ($item_number = c_ws_plugin__s2member_utils_encryption::decrypt ($_COOKIE["s2member_item_number"]))) && !$wpdb->get_row ("SELECT `user_id` FROM `" . $wpdb->usermeta . "` WHERE `meta_key` = '" . $wpdb->prefix . "s2member_subscr_id' AND `meta_value` = '" . $wpdb->escape ($subscr_id) . "' LIMIT 1"))
							$reg_cookies = array ("subscr_gateway" => $subscr_gateway, "subscr_id" => $subscr_id, "custom" => $custom, "item_number" => $item_number);
						/**/
						return apply_filters ("ws_plugin__s2member_reg_cookies_ok", ((isset ($reg_cookies) && is_array ($reg_cookies)) ? $reg_cookies : false), get_defined_vars ());
					}
			}
	}
?>