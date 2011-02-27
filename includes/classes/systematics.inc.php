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
if (!class_exists ("c_ws_plugin__s2member_systematics"))
	{
		class c_ws_plugin__s2member_systematics
			{
				/*
				Function that determines whether we are on a Systematic Use Page.
				*/
				public static function is_systematic_use_page ()
					{
						static $is_systematic; /* For optimization. */
						/**/
						if (isset ($is_systematic)) /* Already cached? This saves time. */
							{
								return $is_systematic; /* Filters will have already been applied. */
							}
						else if (is_admin ()) /* In the admin area? - All administrational pages are considered Systematic. */
							{
								return ($is_systematic = apply_filters ("ws_plugin__s2member_is_systematic_use_page", true, get_defined_vars ()));
							}
						else if (preg_match ("/^CLI$/i", PHP_SAPI)) /* CLI = Command Line. Normally indicates a running cron job. */
							{
								return ($is_systematic = apply_filters ("ws_plugin__s2member_is_systematic_use_page", true, get_defined_vars ()));
							}
						else if ($_SERVER["REMOTE_ADDR"] === $_SERVER["SERVER_ADDR"] && !preg_match ("/^localhost(\:[0-9]+)?$/i", $_SERVER["HTTP_HOST"]) && (!defined ("LOCALHOST") || !LOCALHOST))
							{
								return ($is_systematic = apply_filters ("ws_plugin__s2member_is_systematic_use_page", true, get_defined_vars ()));
							}
						else if (preg_match ("/\/(wp-app|wp-signup|wp-register|wp-activate|wp-login|xmlrpc)\.php/", $_SERVER["REQUEST_URI"]) || (defined ("BP_VERSION") && preg_match ("/\/(" . preg_quote (BP_REGISTER_SLUG, "/") . "|" . preg_quote (BP_ACTIVATION_SLUG, "/") . ")/", $_SERVER["REQUEST_URI"])))
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
						else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_redirection_override"] && ($login_redirection_uri = c_ws_plugin__s2member_login_redirects::login_redirection_uri ()) && preg_match ("/^" . preg_quote ($login_redirection_uri, "/") . "$/", $_SERVER["REQUEST_URI"]))
							{
								return ($is_systematic = apply_filters ("ws_plugin__s2member_is_systematic_use_page", true, get_defined_vars ()));
							}
						else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"] && is_page ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"]))
							{
								return ($is_systematic = apply_filters ("ws_plugin__s2member_is_systematic_use_page", true, get_defined_vars ()));
							}
						else if (preg_match ("/^s2member/", $_SERVER["QUERY_STRING"]) && (parse_url ($_SERVER["REQUEST_URI"], PHP_URL_PATH) === "/" || parse_url (rtrim ($_SERVER["REQUEST_URI"], "/"), PHP_URL_PATH) === parse_url (rtrim (site_url (), "/"), PHP_URL_PATH)))
							{
								return ($is_systematic = apply_filters ("ws_plugin__s2member_is_systematic_use_page", true, get_defined_vars ()));
							}
						else /* Otherwise, we return false. */
							{
								return ($is_systematic = apply_filters ("ws_plugin__s2member_is_systematic_use_page", false, get_defined_vars ()));
							}
					}
			}
	}
?>