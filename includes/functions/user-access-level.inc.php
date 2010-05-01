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
Function for determing the Access Level of a User/Member.
Returns 0-4 according to the current User/Member's Access Level.
*/
function ws_plugin__s2member_user_access_level ()
	{
		do_action ("s2member_before_user_access_level");
		/**/
		if (!($current_user = (is_user_logged_in ()) ? wp_get_current_user () : false))
			{
				return apply_filters ("s2member_user_access_level", -1);
			/* Return of -1, means a User is not logged in. */
			}
		else if (current_user_can ("access_s2member_level4"))
			{
				return apply_filters ("s2member_user_access_level", 4);
			/* Member logged in with Level 4 Access. */
			}
		else if (current_user_can ("access_s2member_level3"))
			{
				return apply_filters ("s2member_user_access_level", 3);
			/* Member logged in with Level 3 Access. */
			}
		else if (current_user_can ("access_s2member_level2"))
			{
				return apply_filters ("s2member_user_access_level", 2);
			/* Member logged in with Level 2 Access. */
			}
		else if (current_user_can ("access_s2member_level1"))
			{
				return apply_filters ("s2member_user_access_level", 1);
			/* Member logged in with Level 1 Access. */
			}
		else /* Else if a User ( Free Subscriber ) is logged in. */
			{
				return apply_filters ("s2member_user_access_level", 0);
			/* User is logged in without Access. A Free Subscriber. */
			}
	}
?>