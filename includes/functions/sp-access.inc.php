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
Generates Single-Page Access links.
*/
function ws_plugin__s2member_sp_access_link_gen ($page_ID = FALSE, $shrink = TRUE)
	{
		if ($page_ID) /* Must have a page ID in order to create an access link. */
			{
				$sp_access = ws_plugin__s2member_xencrypt ("sp:.:|:.:" . $page_ID . ":.:|:.:" . strtotime ("now"));
				$sp_access_link = ws_plugin__s2member_append_query_var (get_page_link ($page_ID), "s2member_sp_access=" . urlencode ($sp_access));
				/**/
				if ($shrink && ($tinyurl = @file_get_contents ("http://tinyurl.com/api-create.php?url=" . rawurlencode ($sp_access_link))))
					return $tinyurl; /* tinyURL is easier to work with, but fails if allow_url_fopen = no. */
				else /* Else use the long one. */
					return $sp_access_link;
			}
		/**/
		return false;
	}
/*
Generates Single-Page Access links via ajax tools.
Attach to: add_action("wp_ajax_s2member_sp_access_link");
*/
function ws_plugin__s2member_sp_access_link ()
	{
		if (current_user_can ("edit_plugins")) /* Check priveledges as well. */
			if (($nonce = $_POST["s2member_sp_access_link"]) && wp_verify_nonce ($nonce, "ws-plugin--s2member-sp-access-link"))
				echo ws_plugin__s2member_sp_access_link_gen ($_POST["s2member_sp_access_link_page"]);
		/**/
		exit;
	}
/*
Handles Single-Page Access authentication.
*/
function ws_plugin__s2member_sp_access ($page_ID = FALSE)
	{
		if (current_user_can ("edit_posts"))
			return true; /* Edit access. */
		/**/
		else if ($_GET["s2member_sp_access"] && $page_ID)
			{
				if (is_array ($sp_access = preg_split ("/\:\.\:\|\:\.\:/", ws_plugin__s2member_xdecrypt ($_GET["s2member_sp_access"]))))
					{
						if (count ($sp_access) === 3 && $sp_access[0] === "sp" && $sp_access[1] == $page_ID && $sp_access[2] >= strtotime ("-72 hours"))
							{
								if ($sp_access[2] <= strtotime ("now")) /* Prevent arbitrarily long times from hacking in. */
									return true; /* Looks good! Single-Page Access granted. */
							}
					}
				/**/
				echo '<strong>Your Link Expired:</strong><br />Please contact Support if you need assistance.';
				/**/
				exit; /* $_GET["s2member_sp_access"] has expired, or is invalid. */
			}
		/**/
		else /* No access. */
			return false;
	}
?>