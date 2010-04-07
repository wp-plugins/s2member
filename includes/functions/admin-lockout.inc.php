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
Function for handling admin lockouts.
Attach to: add_action("admin_init");
*/
function ws_plugin__s2member_admin_lockout ()
	{
		/* This prevents users ( who cannot edit ) from gaining any access to the admin area. */
		/* WordPress® handles most of this on its own, but this prevents profile access also. */
		if (!current_user_can ("edit_posts") /* In other words, if they are a subscriber or a member. */
		&& wp_redirect (get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"])) !== "nill")
			exit;
		/**/
		return;
	}
?>