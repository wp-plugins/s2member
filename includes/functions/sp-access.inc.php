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
Generates Specific Post/Page Access links.
*/
function ws_plugin__s2member_sp_access_link_gen ($sp_IDs = FALSE, $hours = 72, $shrink = TRUE)
	{
		do_action ("s2member_before_sp_access_link_gen");
		/**/
		if (($sp_IDs = preg_replace ("/[^0-9;,]/", "", $sp_IDs)) && ($leading_ID = preg_replace ("/^([0-9]+)(.*?)$/", "$1", $sp_IDs)) && $hours)
			{
				$sp_access = ws_plugin__s2member_encrypt ("sp_time_hours:.:|:.:" . $sp_IDs . ":.:|:.:" . strtotime ("now") . ":.:|:.:" . $hours);
				$sp_access_link = add_query_arg ("s2member_sp_access", $sp_access, get_permalink ($leading_ID));
				/**/
				if ($shrink && ($tinyurl = @file_get_contents ("http://tinyurl.com/api-create.php?url=" . rawurlencode ($sp_access_link))))
					return apply_filters ("s2member_sp_access_link_gen", $tinyurl); /* tinyURL is easier to work with. */
				else /* Else use the long one; tinyURL fails if allow_url_fopen = no. */
					return apply_filters ("s2member_sp_access_link_gen", $sp_access_link);
			}
		/**/
		return false;
	}
/*
Generates Specific Post/Page Access links via ajax tools.
Attach to: add_action("wp_ajax_s2member_sp_access_link");
*/
function ws_plugin__s2member_sp_access_link ()
	{
		do_action ("s2member_before_sp_access_link");
		/**/
		if (current_user_can ("edit_plugins")) /* Check priveledges as well. */
			if (($nonce = $_POST["s2member_sp_access_link"]) && wp_verify_nonce ($nonce, "ws-plugin--s2member-sp-access-link"))
				echo apply_filters ("s2member_sp_access_link", ws_plugin__s2member_sp_access_link_gen ($_POST["s2member_sp_access_link_ids"], $_POST["s2member_sp_access_link_hours"]));
		/**/
		exit;
	}
/*
Handles Specific Post/Page Access authentication.
*/
function ws_plugin__s2member_sp_access ($sp_ID = FALSE)
	{
		do_action ("s2member_before_sp_access");
		/**/
		$excluded = apply_filters ("s2member_sp_access_excluded", false);
		/**/
		if ($excluded || current_user_can ("edit_posts"))
			return true; /* Excluded? Or editing? */
		/**/
		else if ($sp_ID /* Looking for either a _GET request, or a non-empty session. */
		&& (($_GET["s2member_sp_access"] && is_array ($sp_access_values = (array)$_GET["s2member_sp_access"]))/**/
		|| (is_array ($sp_access_values = ws_plugin__s2member_sp_access_session ()) && !empty ($sp_access_values))))
			{
				foreach ($sp_access_values as $sp_access_value) /* Supports multiple access values in a session. */
					{
						if (is_array ($sp_access = preg_split ("/\:\.\:\|\:\.\:/", ws_plugin__s2member_decrypt ($sp_access_value))))
							{
								if (count ($sp_access) === 4 && $sp_access[0] === "sp_time_hours" && in_array ($sp_ID, preg_split ("/[\r\n\t\s;,]+/", $sp_access[1])))
									{
										if ($sp_access[2] <= strtotime ("now") && ($sp_access[2] + ($sp_access[3] * 3600)) >= strtotime ("now"))
											{
												if ($_GET["s2member_sp_access"]) /* Store request in a session. */
													ws_plugin__s2member_sp_access_session ($_GET["s2member_sp_access"]);
												/**/
												if (ws_plugin__s2member_ip_restrictions_ok ($_SERVER["REMOTE_ADDR"], $sp_access_value))
													return apply_filters ("s2member_sp_access", true);
											}
									}
							}
					}
				/**/
				if ($_GET["s2member_sp_access"]) /* If this is a Specific Post/Page Link, fail with expiration. */
					{
						echo '<strong>Your Link Expired:</strong><br />Please contact Support if you need assistance.';
						/**/
						exit; /* $_GET["s2member_sp_access"] has expired. Or it is simply invalid. */
					}
				/**/
				return apply_filters ("s2member_sp_access", false);
			}
		/**/
		else /* Access is not possible. */
			return apply_filters ("s2member_sp_access", false);
	}
/*
Handles Specific Post/Page sessions, by writing access values into a cookie.
This function can be used to add a new value into the session, and/or to return the current set of values in the session.
*/
function ws_plugin__s2member_sp_access_session ($add_sp_access_value = FALSE)
	{
		do_action ("s2member_before_sp_access_session");
		/**/
		$sp_access_values = ($_COOKIE["s2member_sp_access"]) ? preg_split ("/\:\.\:\|\:\.\:/", $_COOKIE["s2member_sp_access"]) : array ();
		/**/
		if ($add_sp_access_value && !in_array ($add_sp_access_value, $sp_access_values)) /* If it's not in the session already. */
			{
				$sp_access_values[] = $add_sp_access_value; /* Add an access value, and update the delimited session cookie. */
				/**/
				$cookie = implode (":.:|:.:", $sp_access_values); /* Implode the access values into a delimited string. */
				$cookie = (strlen ($cookie) >= 4096) ? $add_sp_access_value : $cookie; /* Max cookie size is 4kbs. */
				setcookie ("s2member_sp_access", $cookie, time () + 31556926, "/");
			}
		/**/
		return apply_filters ("s2member_sp_access_session", $sp_access_values);
	}
?>