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
if (!class_exists ("c_ws_plugin__s2member_utils_conds"))
	{
		class c_ws_plugin__s2member_utils_conds
			{
				/*
				Determines whether or not this is a User Admin panel.
				*/
				public static function is_user_admin ()
					{
						if (version_compare (get_bloginfo ("version"), "3.1-RC", ">="))
							return is_user_admin ();
						/**/
						return is_admin ();
					}
				/*
				Determines whether or not this is a Blog Admin panel.
				*/
				public static function is_blog_admin ()
					{
						if (version_compare (get_bloginfo ("version"), "3.1-RC", ">="))
							return is_blog_admin ();
						/**/
						return is_admin ();
					}
				/*
				Determines whether or not this is the Network Admin panel.
				*/
				public static function is_network_admin ()
					{
						if (version_compare (get_bloginfo ("version"), "3.1-RC", ">="))
							return is_network_admin ();
						/**/
						return is_admin ();
					}
				/*
				Determines whether or not this is a Multisite Farm.
				With s2Member, this option may also indicate a Multisite Blog Farm.
				$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["mms_registration_file"] === "wp-signup"
				*/
				public static function is_multisite_farm ()
					{
						return (is_multisite () && ( (is_main_site () && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["mms_registration_file"] === "wp-signup") || (defined ("MULTISITE_FARM") && MULTISITE_FARM)));
					}
				/*
				Function checks if a post is in a child category.
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
			}
	}
?>