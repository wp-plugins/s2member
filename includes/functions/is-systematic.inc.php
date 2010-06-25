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
/*
Function that determines whether we are on a systematic use page.
*/
if (!function_exists ("ws_plugin__s2member_is_systematic_use_page"))
	{
		function ws_plugin__s2member_is_systematic_use_page ()
			{
				static $is_systematic; /* For optimization. */
				/**/
				if (isset ($is_systematic)) /* Already cached? This saves time. */
					{
						return $is_systematic; /* Filters will have already been applied. */
					}
				else if (is_admin ()) /* In the admin area? - All administrational pages are considered systematic. */
					{
						return ($is_systematic = apply_filters ("ws_plugin__s2member_is_systematic_use_page", true, get_defined_vars ()));
					}
				else if (preg_match ("/^cli$/i", PHP_SAPI))
					{
						return ($is_systematic = apply_filters ("ws_plugin__s2member_is_systematic_use_page", true, get_defined_vars ()));
					}
				else if ($_SERVER["REMOTE_ADDR"] === $_SERVER["SERVER_ADDR"])
					{
						return ($is_systematic = apply_filters ("ws_plugin__s2member_is_systematic_use_page", true, get_defined_vars ()));
					}
				else if (preg_match ("/\/wp-login\.php/", $_SERVER["REQUEST_URI"]))
					{
						return ($is_systematic = apply_filters ("ws_plugin__s2member_is_systematic_use_page", true, get_defined_vars ()));
					}
				else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"] && is_page ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))
					{
						return ($is_systematic = apply_filters ("ws_plugin__s2member_is_systematic_use_page", true, get_defined_vars ()));
					}
				else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"] && is_page ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"]))
					{
						return ($is_systematic = apply_filters ("ws_plugin__s2member_is_systematic_use_page", true, get_defined_vars ()));
					}
				else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_redirection_override"] /* Special login redirection URLs are also systematic. */
				&& ($login_redirection_override = ws_plugin__s2member_fill_login_redirect_rc_vars ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_redirection_override"]))/**/
				&& ($login_redirect_path = @parse_url ($login_redirection_override, PHP_URL_PATH)) && ($login_redirect_query = @parse_url ($login_redirection_override, PHP_URL_QUERY)) !== "nill"/**/
				&& ($login_redirect_uri = (($login_redirect_query) ? $login_redirect_path . "?" . $login_redirect_query : $login_redirect_path))/**/
				&& preg_match ("/^" . preg_quote ($login_redirect_uri, "/") . "$/", $_SERVER["REQUEST_URI"]))
					{
						return ($is_systematic = apply_filters ("ws_plugin__s2member_is_systematic_use_page", true, get_defined_vars ()));
					}
				else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"] && is_page ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"]))
					{
						return ($is_systematic = apply_filters ("ws_plugin__s2member_is_systematic_use_page", true, get_defined_vars ()));
					}
				else if (preg_match ("/^s2member/", $_SERVER["QUERY_STRING"]) && ($_SERVER["REQUEST_URI"] === "/" || strtolower (rtrim (get_bloginfo ("url"), "/")) === rtrim (strtolower ("http://" . $_SERVER["HTTP_HOST"]) . $_SERVER["REQUEST_URI"], "/")))
					{
						return ($is_systematic = apply_filters ("ws_plugin__s2member_is_systematic_use_page", true, get_defined_vars ())); /* Only true when the request starts with /?s2member from the root URL of the domain, or from the install. */
					}
				else /* Otherwise, we return false. */
					{
						return ($is_systematic = apply_filters ("ws_plugin__s2member_is_systematic_use_page", false, get_defined_vars ()));
					}
			}
	}
?>