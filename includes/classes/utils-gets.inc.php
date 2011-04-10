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
if (!class_exists ("c_ws_plugin__s2member_utils_gets"))
	{
		class c_ws_plugin__s2member_utils_gets
			{
				/*
				Function retrieves a list of all Category IDs from the database.
				*/
				public static function get_all_category_ids ()
					{
						$ids = get_all_category_ids ();
						/**/
						return (array)$ids;
					}
				/*
				Function retrieves a list of all child Category IDs from the database.
				*/
				public static function get_all_child_category_ids ($parent = FALSE)
					{
						if (is_numeric ($parent) && is_array ($categories = get_categories ("child_of=" . $parent)))
							foreach ($categories as $child_category)
								$child_ids[] = $child_category->term_id;
						/**/
						return (array)$child_ids;
					}
				/*
				Function retrieves a list of all Tag IDs from the database.
				*/
				public static function get_all_tag_ids ()
					{
						global $wpdb; /* Need global DB obj. */
						/**/
						foreach ((array)get_tags () as $tag)
							$ids[] = $tag->term_id;
						/**/
						return (array)$ids;
					}
				/*
				Function retrieves a list of all Post IDs from the database.
					- Includes Custom Post Types.
				*/
				public static function get_all_post_ids ()
					{
						global $wpdb; /* Need global DB obj. */
						/**/
						$ids = $wpdb->get_col ("SELECT `ID` FROM `" . $wpdb->posts . "` WHERE `post_status` = 'publish' AND `post_type` NOT IN('page','attachment','revision')");
						/**/
						return (array)$ids;
					}
				/*
				Function retrieves a list of all Page IDs from the database.
				*/
				public static function get_all_page_ids ()
					{
						global $wpdb; /* Need global DB obj. */
						/**/
						$ids = $wpdb->get_col ("SELECT `ID` FROM `" . $wpdb->posts . "` WHERE `post_status` = 'publish' AND `post_type` = 'page'");
						/**/
						return (array)$ids;
					}
				/*
				Function converts a comma-delimited list of:
					Tag slugs/names/ids - into all IDs.
				*/
				public static function convert_tags_2_ids ($tags = FALSE)
					{
						foreach (preg_split ("/[\r\n\t;,]+/", $tags) as $tag)
							{
								if (($tag = trim ($tag)) && is_numeric ($tag))
									{
										$ids[] = $tag;
									}
								else if ($tag && is_string ($tag))
									{
										if (is_object ($term = get_term_by ("name", $tag, "post_tag")))
											{
												$ids[] = $term->term_id;
											}
										else if (is_object ($term = get_term_by ("slug", $tag, "post_tag")))
											{
												$ids[] = $term->term_id;
											}
									}
							}
						/**/
						return (array)$ids;
					}
				/*
				Function retrieves a list of singular IDs from the database.
				- Only returns Posts that require Custom Capabilities.
				and ONLY those which are NOT satisfied by $user.
				*/
				public static function get_singular_ids_with_ccaps_req ($user = FALSE)
					{
						global $wpdb; /* Need global DB obj. */
						/**/
						if (is_array ($results = $wpdb->get_results ("SELECT `post_id`, `meta_value` FROM `" . $wpdb->postmeta . "` WHERE `meta_key` = 's2member_ccaps_req' AND `meta_value` != ''")))
							{
								foreach ($results as $result) /* Now we need to check Custom Capabilities against $user. */
									{
										if (!is_object ($user) || !$user->ID) /* No $user? / not logged-in?. */
											$ids[] = $result->post_id; /* There's no way to satisfy anything here. */
										/**/
										else if (is_array ($ccaps = @unserialize ($result->meta_value)))
											/**/
											foreach ($ccaps as $ccap) /* Test all Custom Capability requirements. */
												if (strlen ($ccap)) /* Quick (empty) check here. */
													if (!$user->has_cap ("access_s2member_ccap_" . $ccap))
														{
															$ids[] = $result->post_id;
															break;
														}
									}
							}
						/**/
						return (array)$ids;
					}
				/*
				Function retrieves a list of singular IDs from the database.
				- Only returns Posts that require Specific Post/Page Access.
				& ONLY those which are NOT satisfied by the current Visitor.
				*/
				public static function get_singular_ids_with_sp_req ()
					{
						global $wpdb; /* Need global DB obj. */
						/**/
						if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["specific_ids"] && is_array ($sps = preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["specific_ids"])))
							{
								foreach ($sps as $sp) /* Now we need to check access against the current Visitor. */
									{
										if ($sp && !c_ws_plugin__s2member_sp_access::sp_access ($sp, "read-only"))
											$ids[] = $sp;
									}
							}
						/**/
						return (array)$ids;
					}
			}
	}
?>