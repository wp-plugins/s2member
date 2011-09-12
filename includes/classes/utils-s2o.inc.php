<?php
/**
* s2Member-only utilities.
*
* Copyright: © 2009-2011
* {@link http://www.websharks-inc.com/ WebSharks, Inc.}
* ( coded in the USA )
*
* Released under the terms of the GNU General Public License.
* You should have received a copy of the GNU General Public License,
* along with this software. In the main directory, see: /licensing/
* If not, see: {@link http://www.gnu.org/licenses/}.
*
* @package s2Member\Utilities
* @since 110912
*/
if (!class_exists ("c_ws_plugin__s2member_utils_s2o"))
	{
		/**
		* s2Member-only utilities.
		*
		* @package s2Member\Utilities
		* @since 110912
		*/
		class c_ws_plugin__s2member_utils_s2o
			{
				/*
				* WordPress® directory.
				*
				* @package s2Member\Utilities
				* @since 110912
				*
				* @return str|null WordPress® directory, else exits script execution on failure.
				*/
				public static function wp_dir ($starting_dir = FALSE)
					{
						if ($starting_dir && is_dir ($starting_dir))
							for ($i = 0, $dir = $starting_dir; $i <= 20; $i++)
								{
									for ($one_dir_up = 0; $one_dir_up < $i; $one_dir_up++)
										$dir = dirname ($dir);
									/**/
									if (file_exists ($dir . "/wp-settings.php"))
										return ($wp_dir = $dir);
								}
						/**/
						header("Content-Type: text/plain; charset=utf-8") . eval ('while (@ob_end_clean ());');
						header("HTTP/1.0 500 Error") . exit ("ERROR: s2Member® unable to locate WordPress® directory.");
					}
				/*
				* WordPress® settings, after ``SHORTINIT`` section.
				*
				* @package s2Member\Utilities
				* @since 110912
				*
				* @param str $wp_dir WordPress® directory path.
				* @param str $o_file Location of calling `*-o.php` file.
				* @return str|bool WordPress® settings, else false on failure.
				*/
				public static function wp_settings_as ($wp_dir = FALSE, $o_file = FALSE)
					{
						if ($wp_dir && is_dir ($wp_dir) && file_exists ($wp_dir . "/wp-settings.php") && $o_file && file_exists ($o_file))
							if (($wp_settings = $_wp_settings = trim (file_get_contents ($wp_dir . "/wp-settings.php"))))
								{
									$wp_shortinit_section = "/if *\( *SHORTINIT *\)[\r\n\t\s ]*\{?[\r\n\t\s ]*return false;[\r\n\t\s ]*\}?[\r\n\t\s ]*/";
									if (($_wp_settings_parts = preg_split ($wp_shortinit_section, $_wp_settings, 2)) && ($_wp_settings = trim ($_wp_settings_parts[1])) && ($_wp_settings = "<?php\n" . $_wp_settings))
										{
											if (($_wp_settings = str_replace ("__FILE__", "'" . str_replace ("'", "\'", $wp_dir) . "/wp-settings.php'", $_wp_settings))) /* Eval compatible. Hard-code `../wp-settings.php`. */
												{
													$mu_plugins_section = "/[\r\n\t\s ]+foreach *\( *wp_get_mu_plugins *\( *\) *as *\\\$mu_plugin *\)[\r\n\t\s ]*\{?[\r\n\t\s ]*include_once *\( *\\\$mu_plugin *\);[\r\n\t\s ]*\}?[\r\n\t\s ]*unset *\( *\\\$mu_plugin *\);/";
													$mu_plugins_replace = "\nif (file_exists (WPMU_PLUGIN_DIR . \"/s2member-o.php\"))\n\tinclude_once WPMU_PLUGIN_DIR . \"/s2member-o.php\";"; /* Supports special file: `s2member-o.php`. */
													if (($_wp_settings = preg_replace ($mu_plugins_section, $mu_plugins_replace, $_wp_settings, 1, $mu_plugins_replaced)) && $mu_plugins_replaced)
														{
															$nw_plugins_section = "/[\r\n\t\s ]+foreach *\( *wp_get_active_network_plugins *\( *\) *as *\\\$network_plugin *\)[\r\n\t\s ]*\{?[\r\n\t\s ]*include_once *\( *\\\$network_plugin *\);[\r\n\t\s ]*\}?[\r\n\t\s ]*unset *\( *\\\$network_plugin *\);/";
															$nw_plugins_replace = /* Not even in the plugins directory? » */ "\n\$ws_plugin__s2member_temp_s = preg_replace (\"/-o.php\$/\", \".php\", __FILE__);\n\nif (!file_exists (WP_PLUGIN_DIR . \"/\" . plugin_basename (\$ws_plugin__s2member_temp_s)) && file_exists (\$ws_plugin__s2member_temp_s))\n\tinclude_once \$ws_plugin__s2member_temp_s;\n";
															$nw_plugins_replace .= "\n\$ws_plugin__s2member_temp_s = plugin_basename (preg_replace (\"/-o.php\$/\", \".php\", __FILE__));\n\$ws_plugin__s2member_temp_a = is_multisite () ? wp_get_active_network_plugins () : array ();\n\nif (in_array (WP_PLUGIN_DIR . \"/\" . \$ws_plugin__s2member_temp_s, \$ws_plugin__s2member_temp_a))\n\tinclude_once WP_PLUGIN_DIR . \"/\" . \$ws_plugin__s2member_temp_s;\n\nunset (\$ws_plugin__s2member_temp_s, \$ws_plugin__s2member_temp_a);";
															if (($_wp_settings = preg_replace ($nw_plugins_section, $nw_plugins_replace, $_wp_settings, 1, $nw_plugins_replaced)) && $nw_plugins_replaced)
																{
																	$st_plugins_section = "/[\r\n\t\s ]+foreach *\( *wp_get_active_and_valid_plugins *\( *\) *as *\\\$plugin *\)[\r\n\t\s ]*\{?[\r\n\t\s ]*include_once *\( *\\\$plugin *\);[\r\n\t\s ]*\}?[\r\n\t\s ]*unset *\( *\\\$plugin *\);/";
																	$st_plugins_replace = /* Not even in the plugins directory? » */ "\n\$ws_plugin__s2member_temp_s = preg_replace (\"/-o.php\$/\", \".php\", __FILE__);\n\nif (!file_exists (WP_PLUGIN_DIR . \"/\" . plugin_basename (\$ws_plugin__s2member_temp_s)) && file_exists (\$ws_plugin__s2member_temp_s))\n\tinclude_once \$ws_plugin__s2member_temp_s;\n";
																	$st_plugins_replace .= "\n\$ws_plugin__s2member_temp_s = plugin_basename (preg_replace (\"/-o.php\$/\", \".php\", __FILE__));\n\$ws_plugin__s2member_temp_a = is_multisite () ? wp_get_active_and_valid_plugins () : array ();\n\nif (in_array (WP_PLUGIN_DIR . \"/\" . \$ws_plugin__s2member_temp_s, \$ws_plugin__s2member_temp_a))\n\tinclude_once WP_PLUGIN_DIR . \"/\" . \$ws_plugin__s2member_temp_s;\n\nunset (\$ws_plugin__s2member_temp_s, \$ws_plugin__s2member_temp_a);";
																	if (($_wp_settings = preg_replace ($st_plugins_section, $st_plugins_replace, $_wp_settings, 1, $st_plugins_replaced)) && $st_plugins_replaced)
																		{
																			$theme_funcs_section = "/(?:[\r\n\t\s ]+\/\/ Load the functions for the active theme, for both parent and child theme if applicable\.)?[\r\n\t\s ]+if *\( *\! *defined *\( *['\"]WP_INSTALLING['\"] *\) *\|\| *['\"]wp-activate.php['\"] *\=\=\= *\\\$pagenow *\)[\r\n\t\s ]*\{[\r\n\t\s ]*if *\( *TEMPLATEPATH *\!\=\= *STYLESHEETPATH *&& *file_exists *\( *STYLESHEETPATH *\. *['\"]\/functions\.php['\"] *\) *\)[\r\n\t\s ]*\{?[\r\n\t\s ]*include *\( *STYLESHEETPATH *\. *['\"]\/functions\.php['\"] *\);[\r\n\t\s ]*\}?[\r\n\t\s ]*if *\( *file_exists *\( *TEMPLATEPATH *\. *['\"]\/functions\.php['\"] *\) *\)[\r\n\t\s ]*\{?[\r\n\t\s ]*include *\( *TEMPLATEPATH *\. *['\"]\/functions\.php['\"] *\);[\r\n\t\s ]*\}?[\r\n\t\s ]*\}/";
																			if (($_wp_settings = preg_replace ($theme_funcs_section, "", $_wp_settings, 1, $theme_funcs_replaced)) && $theme_funcs_replaced)
																				{
																					if (($_wp_settings = str_replace ("__FILE__", '"' . str_replace ('"', '\"', $o_file) . '"', $_wp_settings)))
																						{
																							if (($_wp_settings = trim ($_wp_settings))) /* WordPress®, with s2Member only. */
																								return $_wp_settings;
																						}
																				}
																		}
																}
														}
												}
										}
								}
						/**/
						return false; /* Default return. */
					}
			}
	}
?>