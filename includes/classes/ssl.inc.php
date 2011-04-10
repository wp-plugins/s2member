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
/**/
if (!class_exists ("c_ws_plugin__s2member_ssl"))
	{
		class c_ws_plugin__s2member_ssl
			{
				/*
				Forces SSL on specific Posts/Pages.
				Attach to: add_action("init");
				Attach to: add_action("template_redirect");
				
				Triggered by Custom Field:
					s2member_force_ssl = yes
						( i.e. https://www.example.com/ )
				
				Or with a specific port number:
					s2member_force_ssl = 443 ( or whatever port you require )
						( i.e. https://www.example.com:443/ )
				*/
				public static function check_force_ssl () /* Forces SSL. */
					{
						global $post; /* We need the global $post variable here. */
						static $forced = false; /* Only force SSL once. */
						/**/
						do_action ("ws_plugin__s2member_before_check_force_ssl", get_defined_vars ());
						/**/
						if (!$forced) /* Only once. This is required, because it's processed on multiple Hooks. */
							{
								$s2_ssl_gv = apply_filters ("ws_plugin__s2member_check_force_ssl_get_var_name", "s2-ssl", get_defined_vars ());
								$force_ssl = apply_filters ("ws_plugin__s2member_check_force_ssl", $_GET[$s2_ssl_gv], get_defined_vars ());
								/**/
								if ($force_ssl || (function_exists ("is_singular") && is_singular () && is_object ($post) && $post->ID && ($force_ssl = get_post_meta ($post->ID, "s2member_force_ssl", true))))
									/**/
									if (!preg_match ("/^(0|no|false)$/i", $force_ssl) && ($forced = true)) /* Make sure it's not a negative variation. */
										{
											c_ws_plugin__s2member_ssl_in::force_ssl (get_defined_vars ()); /* Call inner function now. */
										}
							}
						/**/
						do_action ("ws_plugin__s2member_after_check_force_ssl", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
			}
	}
?>