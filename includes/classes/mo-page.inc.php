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
if (!class_exists ("c_ws_plugin__s2member_mo_page"))
	{
		class c_ws_plugin__s2member_mo_page
			{
				/*
				This forces a redirection to the Membership Options Page for s2Member.
				This can be used by 3rd party applications that are not aware of which Page is currently set as the Membership Options Page.
				
				This is used by s2Member's bbPress Bridge integration.
				
				Attach to: add_action("init");
				Example usage: http://example.com/?s2member_membership_options_page=1
				*/
				public static function membership_options_page () /* Force a redirection. */
					{
						if ($_GET["s2member_membership_options_page"]) /* Call inner function? */
							{
								return c_ws_plugin__s2member_mo_page_in::membership_options_page ();
							}
					}
			}
	}
?>