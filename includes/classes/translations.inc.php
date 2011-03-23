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
if (!class_exists ("c_ws_plugin__s2member_translations"))
	{
		class c_ws_plugin__s2member_translations
			{
				/*
				Mangles internal translations.
				Attach to: add_filter("gettext");
				*/
				public static function translation_mangler ($translated = FALSE, $original = FALSE, $domain = FALSE)
					{
						global $current_site, $current_blog; /* In support of Multisite Networking. */
						static $translations = array (); /* This static array optimizes this routine. */
						/**/
						if (!isset ($translations["is_wp_login"]) || $translations["is_wp_login"])
							{
								if ($translations["is_wp_login"] || preg_match ("/\/wp-login\.php/", $_SERVER["REQUEST_URI"]))
									{
										$translations["is_wp_login"] = true; /* Yes, we are in this area. */
										/**/
										if ($translated === "Username" || $translated === "Password") /* Give Filters a chance here. */
											{
												$translated = apply_filters ("ws_plugin__s2member_translation_mangler", $translated . " *", get_defined_vars ());
											}
										else if ($translated === "E-mail") /* Give Filters a chance here. */
											{
												$translated = apply_filters ("ws_plugin__s2member_translation_mangler", "Email Address *", get_defined_vars ());
											}
										else if ($translated === "Registration complete. Please check your e-mail." && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_password"])
											{
												$translated = apply_filters ("ws_plugin__s2member_translation_mangler", "Registration complete. Please log in.", get_defined_vars ());
											}
									}
								else /* Otherwise, false. */
									$translations["is_wp_login"] = false;
							}
						/**/
						if (!isset ($translations["is_wp_activate"]) || $translations["is_wp_activate"])
							{
								if ($translations["is_wp_activate"] || (is_multisite () && preg_match ("/\/wp-activate\.php/", $_SERVER["REQUEST_URI"])))
									{
										$translations["is_wp_activate"] = true; /* Yes, we are in this area. */
										/**/
										if (preg_match ("/\>View your site\</", $translated)) /* Change the way this link reads. */
											{
												$translated = apply_filters ("ws_plugin__s2member_translation_mangler", preg_replace ("/\>View your site\</", ">Visit site<", $translated), get_defined_vars ());
											}
									}
								else /* Otherwise, false. */
									$translations["is_wp_activate"] = false;
							}
						/**/
						if (!isset ($translations["is_wp_signup"]) || $translations["is_wp_signup"])
							{
								if ($translations["is_wp_signup"] || (is_multisite () && is_main_site () && preg_match ("/\/wp-signup\.php/", $_SERVER["REQUEST_URI"])))
									{
										$translations["is_wp_signup"] = true; /* Yes, we are in this area. */
										/**/
										if ($translated === "If you&#8217;re not going to use a great site domain, leave it for a new user. Now have at it!")
											{
												$translated = apply_filters ("ws_plugin__s2member_translation_mangler", "", get_defined_vars ());
											}
										else if ($translated === "Welcome back, %s. By filling out the form below, you can <strong>add another site to your account</strong>. There is no limit to the number of sites you can have, so create to your heart&#8217;s content, but write responsibly!")
											{
												if (is_user_logged_in () && is_object ($current_user = wp_get_current_user ())) /* Must have a User obj. */
													{
														$blogs_allowed = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["mms_registration_blogs_level" . c_ws_plugin__s2member_user_access::user_access_level ()];
														$current_user_blogs = (is_array ($blogs = get_blogs_of_user ($current_user->ID))) ? count ($blogs) - 1 : 0;
														$current_user_blogs = ($current_user_blogs >= 0) ? $current_user_blogs : 0;
														/**/
														if ($current_user_blogs >= 1) /* So here they already have at least 1 Blog. This message works fine. */
															$translated = apply_filters ("ws_plugin__s2member_translation_mangler", "By filling out the form below, you can <strong>add another site to your account</strong>." . ( ($blogs_allowed > 1) ? "<br />You may create up to " . esc_html ($blogs_allowed) . " site" . ( ($blogs_allowed < 1 || $blogs_allowed > 1) ? "s" : "") . "." : ""), get_defined_vars ());
														/**/
														else /* Otherwise, we need a different message. One that is NOT confusing to a new Customer. */
															$translated = apply_filters ("ws_plugin__s2member_translation_mangler", "By filling out the form below, you can <strong>add a site to your account</strong>." . ( ($blogs_allowed > 1) ? "<br />You may create up to " . esc_html ($blogs_allowed) . " site" . ( ($blogs_allowed < 1 || $blogs_allowed > 1) ? "s" : "") . "." : ""), get_defined_vars ());
													}
											}
									}
								else /* Otherwise, false. */
									$translations["is_wp_signup"] = false;
							}
						/**/
						return $translated; /* No Filters / conserve resources. */
					}
			}
	}
?>