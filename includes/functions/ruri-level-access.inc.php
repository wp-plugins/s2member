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
	exit;
/*
Function for handling Request URI Level Access permissions.
Attach to: add_action("template_redirect");
*/
function ws_plugin__s2member_check_ruri_level_access ()
	{
		do_action ("s2member_before_check_ruri_level_access");
		/**/
		$excluded = apply_filters ("s2member_check_ruri_level_access_excluded", false);
		/**/
		if (!$excluded && !ws_plugin__s2member_is_systematic_use_page ()) /* Never restrict systematic use pages. */
			{
				$current_user = (is_user_logged_in ()) ? wp_get_current_user () : false; /* Is a user logged in? */
				/**/
				foreach (preg_split ("/[\r\n\t]+/", ws_plugin__s2member_fill_ruri_level_access_rc_vars ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_ruris"], $current_user)) as $str)
					if ($str && preg_match ("/" . preg_quote ($str, "/") . "/", $_SERVER["REQUEST_URI"]) && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level1")) && wp_redirect (ws_plugin__s2member_append_query_var (get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]), "s2member_level_req=1")) !== "nill")
						exit;
				/**/
				foreach (preg_split ("/[\r\n\t]+/", ws_plugin__s2member_fill_ruri_level_access_rc_vars ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_ruris"], $current_user)) as $str)
					if ($str && preg_match ("/" . preg_quote ($str, "/") . "/", $_SERVER["REQUEST_URI"]) && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level2")) && wp_redirect (ws_plugin__s2member_append_query_var (get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]), "s2member_level_req=2")) !== "nill")
						exit;
				/**/
				foreach (preg_split ("/[\r\n\t]+/", ws_plugin__s2member_fill_ruri_level_access_rc_vars ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_ruris"], $current_user)) as $str)
					if ($str && preg_match ("/" . preg_quote ($str, "/") . "/", $_SERVER["REQUEST_URI"]) && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level3")) && wp_redirect (ws_plugin__s2member_append_query_var (get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]), "s2member_level_req=3")) !== "nill")
						exit;
				/**/
				foreach (preg_split ("/[\r\n\t]+/", ws_plugin__s2member_fill_ruri_level_access_rc_vars ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_ruris"], $current_user)) as $str)
					if ($str && preg_match ("/" . preg_quote ($str, "/") . "/", $_SERVER["REQUEST_URI"]) && ws_plugin__s2member_nocache_constants () !== "nill" && (!$current_user || !current_user_can ("access_s2member_level4")) && wp_redirect (ws_plugin__s2member_append_query_var (get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]), "s2member_level_req=4")) !== "nill")
						exit;
				/**/
				do_action ("s2member_during_check_ruri_level_access");
			}
		/**/
		do_action ("s2member_after_check_ruri_level_access");
		/**/
		return;
	}
/*
Function that fills replacement code variables in URIs; collectively.
*/
function ws_plugin__s2member_fill_ruri_level_access_rc_vars ($uris = FALSE, $current_user = FALSE)
	{
		do_action ("s2member_before_fill_ruri_level_access_rc_vars");
		/**/
		$current_user_login = (is_object ($current_user)) ? strtolower ($current_user->user_login) : "";
		$current_user_ID = (is_object ($current_user)) ? (string)$current_user->ID : "";
		/**/
		$uris = preg_replace ("/%%current_user_login%%/i", $current_user_login, $uris);
		$uris = preg_replace ("/%%current_user_ID%%/i", $current_user_ID, $uris);
		/**/
		return apply_filters ("s2member_fill_ruri_level_access_rc_vars", $uris);
	}
?>