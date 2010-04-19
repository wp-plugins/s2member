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
function ws_plugin__s2member_login_redirect ()
	{
		/* Note that current_user_can() will not work here because the cookie was just set. */
		global $user; /* Available during the login routine just before wp_login is hooked in. */
		/**/
		$uzer = new WP_User ($user->ID); /* Now lets get a user object to check capabilities. */
		/**/
		if (!$uzer->has_cap ("edit_posts")) /* In other words, all subscribers & members. */
			{
				if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_redirection_override"])
					wp_redirect ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_redirection_override"]);
				/**/
				else /* Otherwise, use the Login Welcome Page. */
					wp_redirect (get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"]));
				/**/
				exit;
			}
		/**/
		return;
	}
?>