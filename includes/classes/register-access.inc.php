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
	exit ("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_register_access"))
	{
		class c_ws_plugin__s2member_register_access
			{
				/*
				Generates registration links.
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
				/*
				Generates Registration Access links via ajax tools.
				Attach to: add_action("wp_ajax_ws_plugin__s2member_reg_access_link_via_ajax");
				*/
				public static function reg_access_link_via_ajax ()
					{
						do_action ("ws_plugin__s2member_before_reg_access_link_via_ajax", get_defined_vars ());
						/**/
						if (current_user_can ("create_users")) /* Check priveledges as well. */
							if (($nonce = $_POST["ws_plugin__s2member_reg_access_link_via_ajax"]) && wp_verify_nonce ($nonce, "ws-plugin--s2member-reg-access-link-via-ajax") && ($_p = c_ws_plugin__s2member_utils_strings::trim_deep (stripslashes_deep ($_POST))))
								echo apply_filters ("ws_plugin__s2member_reg_access_link_via_ajax", c_ws_plugin__s2member_register_access::register_link_gen ($_p["s2member_reg_access_link_subscr_gateway"],$_p["s2member_reg_access_link_subscr_id"],$_p["s2member_reg_access_link_custom"],$_p["s2member_reg_access_link_item_number"]), get_defined_vars ());
						/**/
						exit (); /* Clean exit. */
					}
			}
	}
?>