<?php
/**
* Membership Options Page ( inner processing routines ).
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
* @package s2Member\Membership_Options_Page
* @since 3.5
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit ("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_mo_page_in"))
	{
		/**
		* Membership Options Page ( inner processing routines ).
		*
		* @package s2Member\Membership_Options_Page
		* @since 3.5
		*/
		class c_ws_plugin__s2member_mo_page_in
			{
				/**
				* Forces a redirection to the Membership Options Page for s2Member.
				*
				* This can be used by 3rd party apps that are not aware of which Page is currently set as the Membership Options Page.
				* Example usage: `http://example.com/?s2member_membership_options_page=1`
				*
				* @package s2Member\Membership_Options_Page
				* @since 3.5
				*
				* @attaches-to: ``add_action("init");``
				*
				* @return null Or exits script execution after redirection.
				*/
				public static function membership_options_page ()
					{
						do_action ("ws_plugin__s2member_before_membership_options_page", get_defined_vars ());
						/**/
						if (!empty ($_GET["s2member_membership_options_page"])) /* An incoming request? */
							{
								$query_args = array (); /* Initialize array. */
								foreach ($_GET as $var => $val) /* Include any s2member_ vars. */
									if (preg_match ("/^s2member_/", $var) && $var !== "s2member_membership_options_page")
										$query_args[$var] = $val;
								/* Do NOT include `s2member_membership_options_page` as that could create a redirect loop. */
								/**/
								wp_redirect (add_query_arg (urlencode_deep ($query_args), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])), 301);
								/**/
								exit (); /* Clean exit. */
							}
						/**/
						do_action ("ws_plugin__s2member_after_membership_options_page", get_defined_vars ());
					}
			}
	}
?>