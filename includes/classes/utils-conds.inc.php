<?php
/**
* Conditional utilities.
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
* @since 3.5
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_utils_conds"))
	{
		/**
		* Conditional utilities.
		*
		* @package s2Member\Utilities
		* @since 3.5
		*/
		class c_ws_plugin__s2member_utils_conds
			{
				/**
				* Determines whether or not BuddyPress is installed.
				*
				* @package s2Member\Utilities
				* @since 110720
				*
				* @return bool True if BuddyPress is installed, else false.
				*/
				public static function bp_is_installed ()
					{
						return defined ("BP_VERSION");
					}
				/**
				* Determines whether or not s2Member Pro is installed.
				*
				* @package s2Member\Utilities
				* @since 110720
				*
				* @return bool True if s2Member Pro is installed, else false.
				*/
				public static function pro_is_installed ()
					{
						return defined ("WS_PLUGIN__S2MEMBER_PRO_VERSION");
					}
				/**
				* Determines whether or not this is a Multisite Farm;
				* *( i.e. if ``MULTISITE_FARM == true`` inside `/wp-config.php` )*.
				*
				* With s2Member, this option may also indicate a Multisite Blog Farm.
				* ``$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["mms_registration_file"] === "wp-signup"``.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @return bool True if this is a Multisite Farm, else false.
				*/
				public static function is_multisite_farm ()
					{
						return (is_multisite () && ((is_main_site () && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["mms_registration_file"] === "wp-signup") || (defined ("MULTISITE_FARM") && MULTISITE_FARM)));
					}
				/**
				* Checks if a Post is in a child Category.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @param array $cats An array of Category IDs.
				* @param int|str $post_id A numeric WordPress® Post ID.
				* @return bool True if the Post is inside a desendant of at least one of the specified Categories; else false.
				*/
				public static function in_descendant_category ($cats = FALSE, $post_id = FALSE)
					{
						foreach ((array)$cats as $cat)
							{
								$descendants = get_term_children ((int)$cat, "category");
								if ($descendants && in_category ($descendants, $post_id))
									return true;
							}
						/**/
						return false;
					}
				/**
				* Checks to see if a URL/URI leads to the site root.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @param str $url_or_uri Either a full URL, or a URI to test against.
				* @return bool True if the URL or URI leads to the site root, else false.
				*/
				public static function is_site_root ($url_or_uri = FALSE)
					{
						if (($parse = @parse_url ($url_or_uri))) /* See: http://php.net/manual/en/function.parse-url.php. */
							{
								$parse["path"] = (!empty ($parse["path"])) ? ((strpos ($parse["path"], "/") === 0) ? $parse["path"] : "/" . $parse["path"]) : "/";
								$parse["path"] = preg_replace ("/\/+/", "/", $parse["path"]); /* Removes multi slashes. */
								/**/
								if (empty ($parse["host"]) || strcasecmp ($parse["host"], parse_url (site_url (), PHP_URL_HOST)) === 0)
									if ($parse["path"] === "/" || rtrim ($parse["path"], "/") === rtrim (parse_url (site_url (), PHP_URL_PATH), "/"))
										return true;
							}
						/**/
						return false;
					}
			}
	}
?>