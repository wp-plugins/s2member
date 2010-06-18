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
	exit ("Do not access this file directly.");
/*
Function that forces SSL on specific Posts/Pages.
Attach to: add_action("template_redirect");

Triggered by Custom Field:
	s2member_force_ssl = 1
*/
if (!function_exists ("ws_plugin__s2member_check_force_ssl"))
	{
		function ws_plugin__s2member_check_force_ssl () /* Forces SSL. */
			{
				global $post; /* We need the global $post variable here. */
				/**/
				do_action ("ws_plugin__s2member_before_check_force_ssl", get_defined_vars ());
				/**/
				if (is_singular () && get_post_meta ($post->ID, "s2member_force_ssl", true))
					{
						if (!preg_match ("/^on$/i", $_SERVER["HTTPS"]))
							{
								wp_redirect ("https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
								exit (); /* Redirect to SSL enabled Post/Page. Site must have SSL cert. */
							}
						else /* Otherwise, we buffer the output, and switch everything to https. */
							{
								function _ws_plugin__s2member_force_ssl_buffer ($buffer = FALSE)
									{
										$o_pcre = ini_get ("pcre.backtrack_limit");
										/**/
										ini_set ("pcre.backtrack_limit", 10000000);
										/**/
										$tags = "script|style|link|img|input|iframe|object|embed"; /* Specific tags. */
										/**/
										$tags = apply_filters ("_ws_plugin__s2member_force_ssl_buffer_tags", $tags, get_defined_vars ());
										/**/
										$buffer = preg_replace_callback ("/\<(" . $tags . ")[^\>]+/i", "_ws_plugin__s2member_force_ssl_buffer_callback", $buffer);
										/**/
										ini_set ("pcre.backtrack_limit", $o_pcre);
										/**/
										return apply_filters ("_ws_plugin__s2member_force_ssl_buffer", $buffer, get_defined_vars ());
									}
								/**/
								function _ws_plugin__s2member_force_ssl_buffer_callback ($m = FALSE)
									{
										return preg_replace ("/http\:\/\//i", "https://", $m[0]);
									}
								/**/
								ob_start ("_ws_plugin__s2member_force_ssl_buffer");
							}
					}
				/**/
				do_action ("ws_plugin__s2member_after_check_force_ssl", get_defined_vars ());
				/**/
				return;
			}
	}
?>