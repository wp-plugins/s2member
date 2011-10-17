<?php
/**
* Systematics *( for current page )*.
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
* @package s2Member\Systematics
* @since 3.5
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_systematics"))
	{
		/**
		* Systematics *( for current page )*.
		*
		* @package s2Member\Systematics
		* @since 3.5
		*/
		class c_ws_plugin__s2member_systematics
			{
				/**
				* Determines if the current page is Systematic.
				*
				* @package s2Member\Systematics
				* @since 3.5
				*
				* @return bool True if Systematic, else false.
				*/
				public static function is_systematic_use_page ()
					{
						static $is_systematic; /* For optimization. */
						/**/
						if (isset ($is_systematic)) /* Already cached? This saves time. */
							{
								return $is_systematic; /* Filters will have already been applied. */
							}
						else if (c_ws_plugin__s2member_systematics::is_wp_systematic_use_page ()) /* WordPress® Systematic? */
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
						else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_redirection_override"] && ($login_redirection_uri = c_ws_plugin__s2member_login_redirects::login_redirection_uri (false, "root-returns-false")) && preg_match ("/^" . preg_quote ($login_redirection_uri, "/") . "$/", $_SERVER["REQUEST_URI"]))
							{
								return ($is_systematic = apply_filters ("ws_plugin__s2member_is_systematic_use_page", true, get_defined_vars ()));
							}
						else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"] && is_page ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"]))
							{
								return ($is_systematic = apply_filters ("ws_plugin__s2member_is_systematic_use_page", true, get_defined_vars ()));
							}
						else if (!empty ($_SERVER["QUERY_STRING"]) && strpos ($_SERVER["QUERY_STRING"], "s2member") === 0 && c_ws_plugin__s2member_utils_conds::is_site_root ($_SERVER["REQUEST_URI"]))
							{
								return ($is_systematic = apply_filters ("ws_plugin__s2member_is_systematic_use_page", true, get_defined_vars ()));
							}
						else /* Otherwise, we return false ( it's NOT Systematic ). */
							return ($is_systematic = apply_filters ("ws_plugin__s2member_is_systematic_use_page", false, get_defined_vars ()));
					}
				/**
				* Determines if the current page is WordPress® Systematic.
				*
				* @package s2Member\Systematics
				* @since 111002
				*
				* @return bool True if WordPress® Systematic, else false.
				*/
				public static function is_wp_systematic_use_page ()
					{
						static $is_wp_systematic; /* For optimization. */
						/**/
						if (isset ($is_wp_systematic)) /* Already cached? This saves time. */
							{
								return $is_wp_systematic; /* Filters will have already been applied. */
							}
						else if (is_admin ()) /* In the admin area? All administrational pages are considered Systematic. */
							{
								return ($is_wp_systematic = apply_filters ("ws_plugin__s2member_is_wp_systematic_use_page", true, get_defined_vars ()));
							}
						else if (defined ("WP_INSTALLING") && WP_INSTALLING) /* Installing? All WordPress® installs are considered Systematic. */
							{
								return ($is_wp_systematic = apply_filters ("ws_plugin__s2member_is_wp_systematic_use_page", true, get_defined_vars ()));
							}
						else if (defined ("APP_REQUEST") && APP_REQUEST) /* App request? All WordPress® app requests are considered Systematic. */
							{
								return ($is_wp_systematic = apply_filters ("ws_plugin__s2member_is_wp_systematic_use_page", true, get_defined_vars ()));
							}
						else if (defined ("XMLRPC_REQUEST") && XMLRPC_REQUEST) /* An XML-RPC request? All of these are considered Systematic too. */
							{
								return ($is_wp_systematic = apply_filters ("ws_plugin__s2member_is_wp_systematic_use_page", true, get_defined_vars ()));
							}
						else if ((defined ("DOING_CRON") && DOING_CRON) || strcasecmp (PHP_SAPI, "CLI") === 0) /* CLI ( command line ) or CRON job. */
							{
								return ($is_wp_systematic = apply_filters ("ws_plugin__s2member_is_wp_systematic_use_page", true, get_defined_vars ()));
							}
						else if (preg_match ("/^\/(?:wp-.+?|xmlrpc)\.php$/", c_ws_plugin__s2member_utils_urls::parse_url ($_SERVER["REQUEST_URI"], PHP_URL_PATH)))
							{
								return ($is_wp_systematic = apply_filters ("ws_plugin__s2member_is_wp_systematic_use_page", true, get_defined_vars ()));
							}
						else if (c_ws_plugin__s2member_utils_conds::bp_is_installed () && (bp_is_register_page () || bp_is_activation_page ()))
							{
								return ($is_wp_systematic = apply_filters ("ws_plugin__s2member_is_wp_systematic_use_page", true, get_defined_vars ()));
							}
						else if ($_SERVER["REMOTE_ADDR"] === $_SERVER["SERVER_ADDR"] && stripos ($_SERVER["HTTP_HOST"], "localhost") === false && strpos ($_SERVER["HTTP_HOST"], "127.0.0.1") === false && (!defined ("LOCALHOST") || !LOCALHOST))
							{
								return ($is_wp_systematic = apply_filters ("ws_plugin__s2member_is_wp_systematic_use_page", true, get_defined_vars ()));
							}
						else /* Otherwise, we return false ( it's NOT WordPress® Systematic ). */
							return ($is_wp_systematic = apply_filters ("ws_plugin__s2member_is_wp_systematic_use_page", false, get_defined_vars ()));
					}
			}
	}
?>