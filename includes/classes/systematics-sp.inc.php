<?php
/**
* Systematics *( for a specific page )*.
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
	exit ("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_systematics_sp"))
	{
		/**
		* Systematics *( for a specific page )*.
		*
		* @package s2Member\Systematics
		* @since 3.5
		*/
		class c_ws_plugin__s2member_systematics_sp
			{
				/**
				* Determines if a specific Page ID, or URI, is Systematic.
				*
				* @package s2Member\Systematics
				* @since 3.5
				*
				* @param int|str $page_id Optional. A numeric Page ID in WordPress®.
				* @param str $uri Optional. A request URI to test against.
				* @return bool True if Systematic, else false.
				*
				* @todo Test URIs against formulated links for Systematic Pages like the Membership Options Page?
				* 	Don't think this is required though; as it's already handled in other areas, correct?
				*/
				public static function is_systematic_use_specific_page ($page_id = FALSE, $uri = FALSE)
					{
						if ($uri && strpos ($uri, "/wp-admin/") !== false) /* In the admin area? - All admin pages are considered Systematic. */
							{
								return ($is_systematic = apply_filters ("ws_plugin__s2member_is_systematic_use_specific_page", true, get_defined_vars ()));
							}
						else if ($uri && (preg_match ("/\/(wp-app|wp-signup|wp-register|wp-activate|wp-login|xmlrpc)\.php/", $uri) || (c_ws_plugin__s2member_utils_conds::bp_is_installed () && preg_match ("/\/(" . preg_quote (BP_REGISTER_SLUG, "/") . "|" . preg_quote (BP_ACTIVATION_SLUG, "/") . ")/", $uri))))
							{
								return ($is_systematic = apply_filters ("ws_plugin__s2member_is_systematic_use_specific_page", true, get_defined_vars ()));
							}
						else if ($page_id && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"] && $page_id == $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])
							{
								return ($is_systematic = apply_filters ("ws_plugin__s2member_is_systematic_use_specific_page", true, get_defined_vars ()));
							}
						else if ($page_id && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"] && $page_id == $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"])
							{
								return ($is_systematic = apply_filters ("ws_plugin__s2member_is_systematic_use_specific_page", true, get_defined_vars ()));
							}
						else if ($uri && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_redirection_override"] && ($login_redirection_uri = c_ws_plugin__s2member_login_redirects::login_redirection_uri (false, "root-returns-false")) && preg_match ("/^" . preg_quote ($login_redirection_uri, "/") . "$/", $uri))
							{
								return ($is_systematic = apply_filters ("ws_plugin__s2member_is_systematic_use_specific_page", true, get_defined_vars ()));
							}
						else if ($page_id && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"] && $page_id == $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"])
							{
								return ($is_systematic = apply_filters ("ws_plugin__s2member_is_systematic_use_specific_page", true, get_defined_vars ()));
							}
						else if ($uri && ($query = @parse_url ($uri, PHP_URL_QUERY)) && strpos ($query, "s2member") === 0 && c_ws_plugin__s2member_utils_conds::is_site_root ($uri))
							{
								return ($is_systematic = apply_filters ("ws_plugin__s2member_is_systematic_use_specific_page", true, get_defined_vars ()));
							}
						else /* Otherwise, we return false ( it's NOT a Systematic ). */
							return ($is_systematic = apply_filters ("ws_plugin__s2member_is_systematic_use_specific_page", false, get_defined_vars ()));
					}
			}
	}
?>