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
Referenced by: /?s2member_profile=1
See: s2Member -> API Scripting -> PHP Constants
	S2MEMBER_CURRENT_USER_PROFILE_MODIFICATION_PAGE_URL
*/
$current_user = wp_get_current_user (); /* Current user. */
/**/
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\n";
/**/
echo '<html xmlns="http://www.w3.org/1999/xhtml">' . "\n";
echo '<head>' . "\n";
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />' . "\n";
echo '<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"></script>' . "\n";
echo '<script type="text/javascript" src="' . get_bloginfo ("url") . '/?ws_plugin__s2member_js_w_globals=1&amp;no-cache=' . urlencode (md5 (mt_rand ())) . '"></script>' . "\n";
/**/
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
echo '<tr>' . "\n";
echo '<td>' . "\n";
echo '<label>' . "\n";
echo '<strong>Username *</strong> ( cannot be changed )<br />' . "\n";
echo '<input aria-required="true" type="text" maxlength="60" name="ws_plugin__s2member_profile_login" id="ws-plugin--s2member-profile-login" style="width:99%;" value="' . format_to_edit ($current_user->user_login) . '" disabled="disabled" />' . "\n";
echo '</label>' . "\n";
echo '</td>' . "\n";
echo '</tr>' . "\n";
/**/
echo '<tr>' . "\n";
echo '<td>' . "\n";
echo '<label>' . "\n";
echo '<strong>Email Address *</strong><br />' . "\n";
echo '<input aria-required="true" type="text" maxlength="100" name="ws_plugin__s2member_profile_email" id="ws-plugin--s2member-profile-email" style="width:99%;" value="' . format_to_edit ($current_user->user_email) . '" />' . "\n";
echo '</label>' . "\n";
echo '</td>' . "\n";
echo '</tr>' . "\n";
/**/
echo '<tr>' . "\n";
echo '<td>' . "\n";
echo '<label>' . "\n";
echo '<strong>First Name *</strong><br />' . "\n";
echo '<input aria-required="true" type="text" maxlength="100" name="ws_plugin__s2member_profile_first_name" id="ws-plugin--s2member-profile-first-name" style="width:99%;" value="' . format_to_edit ($current_user->user_firstname) . '" />' . "\n";
echo '</label>' . "\n";
echo '</td>' . "\n";
echo '</tr>' . "\n";
/**/
echo '<tr>' . "\n";
echo '<td>' . "\n";
echo '<label>' . "\n";
echo '<strong>Last Name *</strong><br />' . "\n";
echo '<input aria-required="true" type="text" maxlength="100" name="ws_plugin__s2member_profile_last_name" id="ws-plugin--s2member-profile-last-name" style="width:99%;" value="' . format_to_edit ($current_user->user_lastname) . '" />' . "\n";
echo '</label>' . "\n";
echo '</td>' . "\n";
echo '</tr>' . "\n";
/**/
$fields = get_usermeta ($current_user->ID, "s2member_custom_fields");
/**/
foreach (preg_split ("/[\r\n\t,;]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"]) as $field)
	{
		$req = preg_match ("/\*/", $field); /* Required fields should be wrapped inside asterisks. */
		$req = ($req) ? ' aria-required="true"' : ''; /* Has JavaScript validation applied. */
		/**/
		if ($field = trim ($field, "* \t\n\r\0\x0B")) /* Don't process empty fields. */
			{
				echo '<tr>' . "\n";
				echo '<td>' . "\n";
				echo '<label>' . "\n";
				echo '<strong>' . esc_html ($field) . (($req) ? " *" : "") . '</strong><br />' . "\n";
				$field = preg_replace ("/[^a-z0-9]/i", "_", strtolower ($field));
				echo '<input' . $req . ' type="text" maxlength="100" name="ws_plugin__s2member_profile_' . esc_attr ($field) . '" id="ws-plugin--s2member-profile-' . esc_attr (preg_replace ("/_/", "-", $field)) . '" style="width:99%;" value="' . format_to_edit ($fields[$field]) . '" />' . "\n";
				echo '</label>' . "\n";
				echo '</td>' . "\n";
				echo '</tr>' . "\n";
			}
	}
/**/
echo '<tr>' . "\n";
echo '<td>' . "\n";
echo '<label>' . "\n";
echo '<strong>New Password</strong> ( only if you want to change it )<br />' . "\n";
echo '<input type="password" maxlength="100" autocomplete="off" name="ws_plugin__s2member_profile_password" id="ws-plugin--s2member-profile-password" style="width:99%;" value="" />' . "\n";
echo '</label>' . "\n";
echo '</td>' . "\n";
echo '</tr>' . "\n";
/**/
echo '<tr>' . "\n";
echo '<td>' . "\n";
echo '<input type="submit" value="Save Changes" />' . "\n";
echo '</td>' . "\n";
echo '</tr>' . "\n";
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