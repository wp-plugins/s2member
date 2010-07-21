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
This forces a redirection to the Membership Options Page for s2Member.
This can be used by 3rd party applications that are not aware of which
Page is currently set as the Membership Options Page.
Attach to: add_action("template_redirect");
*/
if (!function_exists ("ws_plugin__s2member_membership_options_page"))
	{
		function ws_plugin__s2member_membership_options_page () /* Force a redirection. */
			{
				do_action ("ws_plugin__s2member_before_membership_options_page", get_defined_vars ());
				/**/
				if ($_GET["s2member_membership_options_page"] && !is_page ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))
					{
						$_GET["s2member_level_req"] = (strlen ($_GET["s2member_level_req"])) ? $_GET["s2member_level_req"] : "0";
						wp_redirect (add_query_arg ("s2member_level_req", $_GET["s2member_level_req"], get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])));
						exit ();
					}
				/**/
				do_action ("ws_plugin__s2member_after_membership_options_page", get_defined_vars ());
			}
	}
?>