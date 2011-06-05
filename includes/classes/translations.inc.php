<?php
/**
* Translations.
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
* @package s2Member\Translations
* @since 3.5
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit ("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_translations"))
	{
		/**
		* Translations.
		*
		* @package s2Member\Translations
		* @since 3.5
		*/
		class c_ws_plugin__s2member_translations
			{
				/**
				* Handles internal translations via `gettext` Filter.
				*
				* @package s2Member\Translations
				* @since 3.5
				*
				* @attaches-to: ``add_filter("gettext");``
				*
				* @param str $translated Expects already-translated string passed in by Filter.
				* @param str $original Expects original text string passed in by Filter.
				* @param str $domain Expects translation domain passed in by Filter.
				* @return str Translated string, possibly modified by this routine.
				*/
				public static function translation_mangler ($translated = FALSE, $original = FALSE, $domain = FALSE)
					{
						global $current_site, $current_blog; /* In support of Multisite Networking. */
						static $s = array (); /* This static array optimizes all of these routines. */
						/**/
						if ((isset ($s["is_wp_login"]) && $s["is_wp_login"]) || (!isset ($s["is_wp_login"]) && ($s["is_wp_login"] = (strpos ($_SERVER["REQUEST_URI"], "/wp-login.php") !== false) ? true : false)))
							{
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
						/**/
						else if ((isset ($s["is_user_new"]) && $s["is_user_new"]) || (!isset ($s["is_user_new"]) && ($s["is_user_new"] = (strpos ($_SERVER["REQUEST_URI"], "/wp-admin/user-new.php") !== false) ? true : false)))
							{
								if ($translated === "Hi,\n\nYou have been invited to join '%s' at\n%s as a %s.\nPlease click the following link to confirm the invite:\n%s\n" && !empty ($_REQUEST["role"]) && preg_match ("/^(subscriber|s2member_level[0-9]+)$/", $_REQUEST["role"]))
									{
										$translated = apply_filters ("ws_plugin__s2member_translation_mangler", 'You have been invited to join "%1$s" at' . "\n" . '%2$s as a Member.' . "\n" . 'Please click the following link to confirm the invite:' . "\n" . '%4$s' . "\n", get_defined_vars ());
									}
							}
						/**/
						else if ((isset ($s["is_wp_activate"]) && $s["is_wp_activate"]) || (!isset ($s["is_wp_activate"]) && ($s["is_wp_activate"] = (strpos ($_SERVER["REQUEST_URI"], "/wp-activate.php") !== false) ? true : false)))
							{
								if (strpos (">View your site<", $translated) !== false) /* Change the way this link reads. */
									{
										$translated = apply_filters ("ws_plugin__s2member_translation_mangler", str_replace (">View your site<", ">Visit site<", $translated), get_defined_vars ());
									}
							}
						/**/
						else if ((isset ($s["is_wp_signup"]) && $s["is_wp_signup"]) || (!isset ($s["is_wp_signup"]) && ($s["is_wp_signup"] = (strpos ($_SERVER["REQUEST_URI"], "/wp-signup.php") !== false) ? true : false)))
							{
								if ($translated === "If you&#8217;re not going to use a great site domain, leave it for a new user. Now have at it!")
									{
										$translated = apply_filters ("ws_plugin__s2member_translation_mangler", "", get_defined_vars ());
									}
								else if ($translated === "Welcome back, %s. By filling out the form below, you can <strong>add another site to your account</strong>. There is no limit to the number of sites you can have, so create to your heart&#8217;s content, but write responsibly!")
									{
										if (is_user_logged_in () && is_object ($user = wp_get_current_user ())) /* Must have a User obj. */
											{
												$blogs_allowed = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["mms_registration_blogs_level" . c_ws_plugin__s2member_user_access::user_access_level ($user)];
												$user_blogs = (is_array ($blogs = get_blogs_of_user ($user->ID))) ? count ($blogs) - 1 : 0;
												/**/
												$user_blogs = ($user_blogs >= 0) ? $user_blogs : 0; /* NOT less than zero. */
												$blogs_allowed = ($blogs_allowed >= 0) ? $blogs_allowed : 0;
												/**/
												$translated = apply_filters ("ws_plugin__s2member_translation_mangler", "By filling out the form below, you can <strong>" . (($user_blogs >= 1) ? "add another site" : "add a site") . " to your account</strong>." . (($blogs_allowed > 1) ? "<br />You may create up to " . esc_html ($blogs_allowed) . " site" . (($blogs_allowed <> 1) ? "s" : "") . "." : ""), get_defined_vars ());
											}
									}
							}
						/**/
						return $translated; /* No Filters. */
					}
			}
	}
?>