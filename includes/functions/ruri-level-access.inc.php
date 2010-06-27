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
Function for handling Request URI Level Access permissions.
Attach to: add_action("template_redirect");
*/
if (!function_exists ("ws_plugin__s2member_check_ruri_level_access"))
	{
		function ws_plugin__s2member_check_ruri_level_access ()
			{
				do_action ("ws_plugin__s2member_before_check_ruri_level_access", get_defined_vars ());
				/**/
				$excluded = apply_filters ("ws_plugin__s2member_check_ruri_level_access_excluded", false, get_defined_vars ());
				/**/
				if (!$excluded && !ws_plugin__s2member_is_systematic_use_page () && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])
					{
						$current_user = (is_user_logged_in ()) ? wp_get_current_user () : false; /* Get the current User's object. */
						/**/
						if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_ruris"])
							foreach (preg_split ("/[\r\n\t]+/", ws_plugin__s2member_fill_ruri_level_access_rc_vars ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_ruris"], $current_user)) as $str)
								if ($str && preg_match ("/" . preg_quote ($str, "/") . "/", $_SERVER["REQUEST_URI"]) && ws_plugin__s2member_nocache_constants (true) !== "nill" && (!$current_user || !current_user_can ("access_s2member_level0")) && wp_redirect (add_query_arg ("s2member_level_req", "0", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
									exit ();
						/**/
						if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_ruris"])
							foreach (preg_split ("/[\r\n\t]+/", ws_plugin__s2member_fill_ruri_level_access_rc_vars ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_ruris"], $current_user)) as $str)
								if ($str && preg_match ("/" . preg_quote ($str, "/") . "/", $_SERVER["REQUEST_URI"]) && ws_plugin__s2member_nocache_constants (true) !== "nill" && (!$current_user || !current_user_can ("access_s2member_level1")) && wp_redirect (add_query_arg ("s2member_level_req", "1", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
									exit ();
						/**/
						if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_ruris"])
							foreach (preg_split ("/[\r\n\t]+/", ws_plugin__s2member_fill_ruri_level_access_rc_vars ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_ruris"], $current_user)) as $str)
								if ($str && preg_match ("/" . preg_quote ($str, "/") . "/", $_SERVER["REQUEST_URI"]) && ws_plugin__s2member_nocache_constants (true) !== "nill" && (!$current_user || !current_user_can ("access_s2member_level2")) && wp_redirect (add_query_arg ("s2member_level_req", "2", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
									exit ();
						/**/
						if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_ruris"])
							foreach (preg_split ("/[\r\n\t]+/", ws_plugin__s2member_fill_ruri_level_access_rc_vars ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_ruris"], $current_user)) as $str)
								if ($str && preg_match ("/" . preg_quote ($str, "/") . "/", $_SERVER["REQUEST_URI"]) && ws_plugin__s2member_nocache_constants (true) !== "nill" && (!$current_user || !current_user_can ("access_s2member_level3")) && wp_redirect (add_query_arg ("s2member_level_req", "3", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
									exit ();
						/**/
						if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_ruris"])
							foreach (preg_split ("/[\r\n\t]+/", ws_plugin__s2member_fill_ruri_level_access_rc_vars ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_ruris"], $current_user)) as $str)
								if ($str && preg_match ("/" . preg_quote ($str, "/") . "/", $_SERVER["REQUEST_URI"]) && ws_plugin__s2member_nocache_constants (true) !== "nill" && (!$current_user || !current_user_can ("access_s2member_level4")) && wp_redirect (add_query_arg ("s2member_level_req", "4", get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))) !== "nill")
									exit ();
						/**/
						do_action ("ws_plugin__s2member_during_check_ruri_level_access", get_defined_vars ());
					}
				/**/
				do_action ("ws_plugin__s2member_after_check_ruri_level_access", get_defined_vars ());
				/**/
				return;
			}
	}
/*
Function that fills replacement code variables in URIs; collectively.
*/
if (!function_exists ("ws_plugin__s2member_fill_ruri_level_access_rc_vars"))
	{
		function ws_plugin__s2member_fill_ruri_level_access_rc_vars ($uris = FALSE, $current_user = FALSE)
			{
				eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_fill_ruri_level_access_rc_vars", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				$current_user = (is_object ($current_user)) ? $current_user : wp_get_current_user ();
				$current_user_login = (is_object ($current_user)) ? strtolower ($current_user->user_login) : "";
				$current_user_ID = (is_object ($current_user)) ? (string)$current_user->ID : "";
				/**/
				$uris = preg_replace ("/%%current_user_login%%/i", ws_plugin__s2member_esc_ds ($current_user_login), $uris);
				$uris = preg_replace ("/%%current_user_ID%%/i", ws_plugin__s2member_esc_ds ($current_user_ID), $uris);
				$uris = preg_replace ("/%%current_user_level%%/i", (string)ws_plugin__s2member_user_access_level (), $uris);
				/**/
				return apply_filters ("ws_plugin__s2member_fill_ruri_level_access_rc_vars", $uris, get_defined_vars ());
			}
	}
?>