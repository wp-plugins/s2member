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
Function for determing the access level of a user.
Returns 0-4 according to the current user's access level.
*/
function ws_plugin__s2member_user_access_level ()
	{
		if (!($current_user = (is_user_logged_in ()) ? wp_get_current_user () : false))
			{
				return -1; /* Return of -1, means not logged in. */
			}
		else if (current_user_can ("access_s2member_level4"))
			{
				return 4; /* User logged in with level 4 access. */
			}
		else if (current_user_can ("access_s2member_level3"))
			{
				return 3; /* User logged in with level 3 access. */
			}
		else if (current_user_can ("access_s2member_level2"))
			{
				return 2; /* User logged in with level 2 access. */
			}
		else if (current_user_can ("access_s2member_level1"))
			{
				return 1; /* User logged in with level 1 access. */
			}
		else /* If a user is logged in but has no access. */
			{
				return 0; /* User is logged in without access. */
			}
	}
?>