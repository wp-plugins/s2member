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
Function for handling profile modifications.
Attach to: add_action("init");
*/
function ws_plugin__s2member_handle_profile_modifications ()
	{
		if ($_GET["s2member_profile"] && ($current_user = (is_user_logged_in ()) ? wp_get_current_user () : false))
			{
				if ($_POST["ws_plugin__s2member_profile_save"])
					{
						$userdata["ID"] = $current_user->ID;
						/**/
						include_once (ABSPATH . WPINC . "/registration.php");
						/**/
						$_POST = stripslashes_deep ($_POST); /* Clean post data. */
						/**/
						if (trim ($_POST["ws_plugin__s2member_profile_email"]) && is_email (trim ($_POST["ws_plugin__s2member_profile_email"])) && !email_exists (trim ($_POST["ws_plugin__s2member_profile_email"])) && strlen (trim ($_POST["ws_plugin__s2member_profile_email"])) <= 100)
							$userdata["user_email"] = trim ($_POST["ws_plugin__s2member_profile_email"]);
						/**/
						if (trim ($_POST["ws_plugin__s2member_profile_first_name"]) && strlen (trim ($_POST["ws_plugin__s2member_profile_first_name"]) . " ( " . $current_user->user_login . " )") <= 250 && !current_user_can ("edit_posts"))
							$userdata["display_name"] = trim ($_POST["ws_plugin__s2member_profile_first_name"]) . " ( " . $current_user->user_login . " )";
						/**/
						if (trim ($_POST["ws_plugin__s2member_profile_password"]) && strlen (trim ($_POST["ws_plugin__s2member_profile_password"])) <= 100)
							$userdata["user_pass"] = trim ($_POST["ws_plugin__s2member_profile_password"]);
						/**/
						if (strlen (trim ($_POST["ws_plugin__s2member_profile_first_name"])) <= 100)
							$userdata["first_name"] = trim ($_POST["ws_plugin__s2member_profile_first_name"]);
						/**/
						if (strlen (trim ($_POST["ws_plugin__s2member_profile_last_name"])) <= 100)
							$userdata["last_name"] = trim ($_POST["ws_plugin__s2member_profile_last_name"]);
						/**/
						wp_update_user ($userdata); /* Send this array for an update. */
						/**/
						echo '<script type="text/javascript">' . "\n";
						echo "if(window.parent && window.parent != window && window.parent.name !== window.name) { try{ window.parent.Shadowbox.close(); } catch(e){} try{ window.parent.tb_remove(); } catch(e){} window.parent.alert('Profile updated successfully!'); window.parent.location = window.parent.location; }";
						echo "else if(window.opener) { window.close(); window.opener.alert('Profile updated successfully!'); window.opener.location = window.opener.location; }";
						echo "else { alert('Profile updated successfully!'); window.location = '" . esc_js (get_bloginfo ("url")) . "/?s2member_profile=1'; }";
						echo '</script>' . "\n";
						/**/
						exit;
					}
				/* Display the profile editing panel. */
				include_once dirname (dirname (__FILE__)) . "/profile.inc.php";
				/**/
				exit;
			}
		/**/
		return;
	}
?>