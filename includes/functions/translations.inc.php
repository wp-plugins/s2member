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
if (!function_exists ("ws_plugin__s2member_translation_mangler"))
	{
		function ws_plugin__s2member_translation_mangler ($translated = FALSE, $original = FALSE, $domain = FALSE)
			{
				static $is_admin_media_upload, $is_wp_login; /* Optimizes this routine. */
				/**/
				if (!isset ($is_admin_media_upload) || $is_admin_media_upload)
					{
						if ($is_admin_media_upload || (is_admin () && preg_match ("/\/(async-upload|media-upload)\.php/", $_SERVER["REQUEST_URI"])))
							{
								$is_admin_media_upload = true; /* Yes, we are in this area. */
								/**/
								if ($translated === "Insert into Post") /* Give filters a chance here. */
									{
										$translated = apply_filters ("ws_plugin__s2member_translation_mangler", "Insert", get_defined_vars ());
									}
							}
						else /* Otherwise, false. */
							$is_admin_media_upload = false;
					}
				/**/
				else if (!isset ($is_wp_login) || $is_wp_login)
					{
						if ($is_wp_login || preg_match ("/\/wp-login\.php/", $_SERVER["REQUEST_URI"]))
							{
								$is_wp_login = true; /* Yes, we are in this area. */
								/**/
								if ($translated === "Username") /* Give filters a chance here. */
									{
										$translated = apply_filters ("ws_plugin__s2member_translation_mangler", "Username *", get_defined_vars ());
									}
								else if ($translated === "E-mail") /* Give filters a chance here. */
									{
										$translated = apply_filters ("ws_plugin__s2member_translation_mangler", "Email Address *", get_defined_vars ());
									}
							}
						else /* Otherwise, false. */
							$is_wp_login = false;
					}
				/**/
				return $translated;
			}
	}
?>