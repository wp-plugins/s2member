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
Mangles internal translations.
Attach to: add_filter("gettext");
*/
function ws_plugin__s2member_translation_mangler ($translated = FALSE, $original = FALSE, $domain = FALSE)
	{
		static $is_admin_media_upload, $is_wp_login; /* Optimizes this routine. */
		/**/
		if (!isset ($is_admin_media_upload) || $is_admin_media_upload)
			{
				if ($is_admin_media_upload || (is_admin () && preg_match ("/\/(async-upload|media-upload)\.php/", $_SERVER["REQUEST_URI"])))
					{
						$is_admin_media_upload = true;
						/**/
						if ($translated === "Insert into Post")
							{
								$translated = "Insert";
							}
					}
				else
					{
						$is_admin_media_upload = false;
					}
			}
		/**/
		else if (!isset ($is_wp_login) || $is_wp_login)
			{
				if ($is_wp_login || preg_match ("/\/wp-login\.php/", $_SERVER["REQUEST_URI"]))
					{
						$is_wp_login = true;
						/**/
						if ($translated === "Username")
							{
								$translated = "Username *";
							}
						else if ($translated === "E-mail")
							{
								$translated = "Email Address *";
							}
					}
				else
					{
						$is_wp_login = false;
					}
			}
		/**/
		return $translated;
	}
?>