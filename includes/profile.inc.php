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
if (realpath(__FILE__) === realpath($_SERVER["SCRIPT_FILENAME"]))
	exit;
/*
Present an error with an explanation; then offer upgrade options.
*/
$current_user = wp_get_current_user(); /* Get the current user. */
/**/
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\n";
/**/
echo '<html xmlns="http://www.w3.org/1999/xhtml">' . "\n";
echo '<head>' . "\n";
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />' . "\n";
echo '<title>My Profile</title>' . "\n";
echo '</head>' . "\n";
/**/
echo '<body style="background:#EEEEEE; color:#333333; font-family:verdana; font-size:13px;">' . "\n";
/**/
echo '<form method="post" name="ws_plugin__s2member_profile" id="ws-plugin--s2member-profile">' . "\n";
/**/
echo '<input type="hidden" name="ws_plugin__s2member_profile_save" id="ws-plugin--s2member-profile-save" value="1" />' . "\n";
/**/
echo '<table cellpadding="5" cellspacing="5" style="width:100%; border:0;">' . "\n";
echo '<tbody>' . "\n";
/**/
echo '<tr><td>' . "\n";
echo '<strong>My Username:</strong> ( username cannot be changed )<br />' . "\n";
echo '<input type="text" maxlength="60" name="ws_plugin__s2member_profile_login" id="ws-plugin--s2member-profile-login" style="width:99%;" value="' . format_to_edit($current_user->user_login) . '" disabled="disabled" />' . "\n";
echo '</td></tr>' . "\n";
/**/
echo '<tr><td>' . "\n";
echo '<strong>My Email Address:</strong><br />' . "\n";
echo '<input type="text" maxlength="100" name="ws_plugin__s2member_profile_email" id="ws-plugin--s2member-profile-email" style="width:99%;" value="' . format_to_edit($current_user->user_email) . '" />' . "\n";
echo '</td></tr>' . "\n";
/**/
echo '<tr><td>' . "\n";
echo '<strong>My First Name:</strong><br />' . "\n";
echo '<input type="text" maxlength="100" name="ws_plugin__s2member_profile_first_name" id="ws-plugin--s2member-profile-first-name" style="width:99%;" value="' . format_to_edit($current_user->user_firstname) . '" />' . "\n";
echo '</td></tr>' . "\n";
/**/
echo '<tr><td>' . "\n";
echo '<strong>My Last Name:</strong><br />' . "\n";
echo '<input type="text" maxlength="100" name="ws_plugin__s2member_profile_last_name" id="ws-plugin--s2member-profile-last-name" style="width:99%;" value="' . format_to_edit($current_user->user_lastname) . '" />' . "\n";
echo '</td></tr>' . "\n";
/**/
echo '<tr><td>' . "\n";
echo '<strong>My Password:</strong> ( only if you want to change it )<br />' . "\n";
echo '<input type="text" maxlength="100" name="ws_plugin__s2member_profile_password" id="ws-plugin--s2member-profile-password" style="width:99%;" value="" />' . "\n";
echo '</td></tr>' . "\n";
/**/
echo '<tr><td>' . "\n";
echo '<input type="submit" value="Save Changes" />' . "\n";
echo '</td></tr>' . "\n";
/**/
echo '</tbody>' . "\n";
echo '</table>' . "\n";
/**/
echo '</form>' . "\n";
/**/
echo '</form>' . "\n";
/**/
echo '</body>' . "\n";
echo '</html>';
?>