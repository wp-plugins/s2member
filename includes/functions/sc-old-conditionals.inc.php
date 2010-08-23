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
	exit("Do not access this file directly.");
/*
The following Shortcodes were deprecated in v3.2.2.
Going forward, use [s2If] instead ( it's more powerful ).
@NOTE: These Shortcodes were ONLY available in v3.2.1.
~ These WILL all be removed in the next release.

Function that handles the Shortcode for [s2All ... simple conditionals][/s2All].
Function that handles the Shortcode for [s2Any ... simple conditionals][/s2Any].

Attach to: add_shortcode("s2All"), add_shortcode("_s2All"), add_shortcode("__s2All"), add_shortcode("___s2All");
Attach to: add_shortcode("s2Any"), add_shortcode("_s2Any"), add_shortcode("__s2Any"), add_shortcode("___s2Any");

[s2All is_user_logged_in="yes" current_user_can="access_s2member_level1"]

	Content appears here for Members with access to Level #1.

	[_s2All current_user_can="access_s2member_ccap_free_gift"]
		Free gift here with nested Custom Capability check.
	[/_s2All]

[/s2All]


[s2Any current_user_is="s2member_level1" current_user_is="s2member_level2"]

	Content appears here for Members at Level #1 and Level #2.

	[_s2Any current_user_can="access_s2member_ccap_free_gift"]
		Free gift here with nested Custom Capability check.
	[/_s2Any]

[/s2Any]

*/
if (!function_exists ("ws_plugin__s2member_sc_old_conditionals"))
	{
		function ws_plugin__s2member_sc_old_conditionals ($attr = FALSE, $content = FALSE, $shortcode = FALSE)
			{
				eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_sc_old_conditionals", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				$attr = ws_plugin__s2member_trim_quot_deep ($attr); /* Fix &quot; in Shortcode attrs
				that have been corrupted by a non-default visual editor; ( i.e. CKEditor does this ). */
				/**/
				if (is_multisite () && ws_plugin__s2member_is_multisite_farm () && !is_main_site ()) /* Restrict to a subset of the most useful Conditionals on a Blog Farm. */
					$attr = shortcode_atts (array ("is_user_logged_in" => "", "is_user_not_logged_in" => "", "current_user_is" => "", "current_user_is_not" => "", "current_user_is_for_blog" => "", "current_user_is_not_for_blog" => "", "current_user_can" => "", "current_user_cannot" => "", "current_user_can_for_blog" => "", "current_user_cannot_for_blog" => "", "is_404" => "", "is_home" => "", "is_front_page" => "", "is_singular" => "", "is_single" => "", "is_page" => "", "is_page_template" => "", "is_attachment" => "", "is_feed" => "", "is_archive" => "", "is_search" => "", "is_category" => "", "is_tax" => "", "is_tag" => "", "has_tag" => "", "is_author" => "", "is_date" => "", "is_day" => "", "is_month" => "", "is_time" => "", "is_year" => "", "is_sticky" => "", "is_paged" => "", "is_preview" => "", "in_the_loop" => "", "comments_open" => "", "pings_open" => "", "has_excerpt" => "", "has_post_image" => ""), $attr);
				/**/
				eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_sc_old_conditionals_after_shortcode_atts", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if (preg_match ("/^(_*)s2All$/i", $shortcode)) /* This is the AND variation. This routine analyzes conditionals using AND logic, instead of OR. */
					{
						foreach ($attr as $conditional => $_args) /* All conditions must evaluate to true; except for basic yes|no argument values that are = "no". */
							{
								if (strlen ($_args) && strlen ($_args = preg_replace ("/^array\(/i", "(", $_args))) /* Remove array() prefixes and leave only the () indicator. */
									if (strlen ($_args = preg_replace ("/[\r\n\t\s ]/", "", $_args)) && is_array ($args = preg_split ("/[;,]+/", $_args, 0, PREG_SPLIT_NO_EMPTY)) && !empty ($args))
										{
											$args_are_yes_no = preg_match ("/^(true|yes|false|no)$/", $_args); /* Args can be passed as a simple yes|no. ( is_tag="yes" ). */
											$args_are_yes = ($args_are_yes_no && preg_match ("/^(true|yes)$/", $_args)); /* Passed as a simple yes|no. ( is_tag="yes" ). */
											$args_are_array = (!$args_are_yes_no && preg_match ("/^\((.+?)\)$/", $_args)); /* Example: has_tag="(cheese,butter,salt)" */
											/**/
											try /* Using try/catch here to protect this routine from errors due to invalid arguments passed through Shortcode attrs. */
												{
													if ($args_are_yes_no) /* No args. Only testing the return value. */
														{
															if ($args_are_yes && !call_user_func ($conditional))
																{
																	$condition_failed = true;
																	break;
																}
															/**/
															else if (call_user_func ($conditional))
																{
																	$condition_failed = true;
																	break;
																}
														}
													/**/
													else if ($args_are_array && !call_user_func ($conditional, $args))
														{
															$condition_failed = true;
															break;
														}
													/**/
													else if (!call_user_func_array ($conditional, $args))
														{
															$condition_failed = true;
															break;
														}
												}
											/**/
											catch (Exception $e) /* Catch errors silently. */
												{
													$condition_failed = true;
													break;
												}
										}
							}
						/* Supports nested Shortcodes. */
						return do_shortcode (apply_filters ("ws_plugin__s2member_sc_old_conditionals", (($condition_failed) ? "" : $content), get_defined_vars ()));
					}
				/**/
				else if (preg_match ("/^(_*)s2Any$/i", $shortcode)) /* This is the OR variation. This routine analyzes conditionals using OR logic, instead of AND. */
					{
						foreach ($attr as $conditional => $_args) /* Any condition can evaluate to true; except for basic yes|no argument values that are = "no". */
							{
								if (strlen ($_args) && strlen ($_args = preg_replace ("/^array\(/i", "(", $_args))) /* Remove array() prefixes and leave only the () indicator. */
									if (strlen ($_args = preg_replace ("/[\r\n\t\s ]/", "", $_args)) && is_array ($args = preg_split ("/[;,]+/", $_args, 0, PREG_SPLIT_NO_EMPTY)) && !empty ($args))
										{
											$args_are_yes_no = preg_match ("/^(true|yes|false|no)$/", $_args); /* Args can be passed as a simple yes|no. ( is_tag="yes" ). */
											$args_are_yes = ($args_are_yes_no && preg_match ("/^(true|yes)$/", $_args)); /* Passed as a simple yes|no. ( is_tag="yes" ). */
											$args_are_array = (!$args_are_yes_no && preg_match ("/^\((.+?)\)$/", $_args)); /* Example: has_tag="(cheese,butter,salt)" */
											/**/
											try /* Using try/catch here to protect this routine from errors due to invalid arguments passed through Shortcode attrs. */
												{
													if ($args_are_yes_no) /* No args. Only testing the return value. */
														{
															if ($args_are_yes && call_user_func ($conditional))
																{
																	$condition_succeeded = true;
																	break;
																}
															/**/
															else if (!call_user_func ($conditional))
																{
																	$condition_succeeded = true;
																	break;
																}
														}
													/**/
													else if ($args_are_array && call_user_func ($conditional, $args))
														{
															$condition_succeeded = true;
															break;
														}
													/**/
													else if (call_user_func_array ($conditional, $args))
														{
															$condition_succeeded = true;
															break;
														}
												}
											/**/
											catch (Exception $e) /* Catch errors silently. */
												{
													$condition_succeeded = false;
													break;
												}
										}
							}
						/* Supports nested Shortcodes. */
						return do_shortcode (apply_filters ("ws_plugin__s2member_sc_old_conditionals", (($condition_succeeded) ? $content : ""), get_defined_vars ()));
					}
			}
	}
?>