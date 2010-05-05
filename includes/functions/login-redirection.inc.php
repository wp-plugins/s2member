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
Function for handling login redirections.
Attach to: add_action("wp_login");
*/
function ws_plugin__s2member_login_redirect ($username = FALSE)
	{
		do_action ("s2member_before_login_redirect");
		/**/
		$user = new WP_User ($username); /* Get user object reference. */
		/**/
		if (!$user->has_cap ("edit_posts")) /* In other words, all Subscribers & Members. */
			{
				do_action ("s2member_during_login_redirect");
				/**/
				if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_redirection_override"])
					wp_redirect ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_redirection_override"]);
				/**/
				else /* Otherwise, use the Login Welcome Page. */
					wp_redirect (get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"]));
				/**/
				exit;
			}
		/**/
		do_action ("s2member_after_login_redirect");
		/**/
		return;
	}
?>