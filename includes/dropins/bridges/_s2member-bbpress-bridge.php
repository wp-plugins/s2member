<?php
/*
Version: 1.0.3
Stable tag: 1.0.3
Framework: WS-BB-DIP-1.0

Tested up to: 1.0.3
Requires at least: 1.0.3
Requires: s2Member 3.5.7+, bbPress® 1.0.3+

Copyright: © 2009 WebSharks, Inc.
License: GNU General Public License
Contributors: WebSharks, PriMoThemes
Author URI: http://www.primothemes.com/
Author: PriMoThemes.com / WebSharks, Inc.
Donate link: http://www.primothemes.com/donate/

Plugin Name: s2Member Bridge
Pro Module / Prices: http://www.s2member.com/prices/
Forum URI: http://www.primothemes.com/forums/viewforum.php?f=4
Professional Installation URI: http://www.s2member.com/professional-installation/
Plugin URI: http://www.primothemes.com/post/product/s2member-membership-plugin-with-paypal/
Description: Blocks all non-Member access to bbPress® forums. Only the login-page is available. Forum registration is redirected to your Membership Options Page for s2Member ( on your main WordPress® installation ). This way, a visitor can signup on your site, and gain Membership Access to your forums. This plugin will NOT work, until you've successfully integrated WordPress® into bbPress®. See: `bbPress® -> Settings -> WordPress® Integration`.
Tags: membership, members, member, register, signup, paypal, pay pal, s2member, subscriber, members only, bbpress, bb press, forums, forum, buddypress, buddy press, buddy press compatible, shopping cart, checkout, api, options panel included, websharks framework, w3c validated code, multi widget support, includes extensive documentation, highly extensible
*/
/*
Direct access denial.
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit ("Do not access this file directly.");
/*
These are filled by the s2Member installer. Or you can set these manually.
- Participation Level = Member Level # required for participation.
- Open Viewing = 1 ( on ) or 0 ( off ).
*/
define ("WS_PLUGIN__S2MEMBER_BRIDGE_BBPRESS_ALLOW_OPEN_VIEWING", "%%ovg%%");
define ("WS_PLUGIN__S2MEMBER_BRIDGE_BBPRESS_MIN_PARTICIPATION_LEVEL", "%%min%%");
/* -------------------------------------------------------------------------- */
/*
Convert s2Member Roles into bbPress® "Members" on-the-fly.
	- Only when no bbPress® Role has been assigned yet.
		- This way a site owner can still modify Roles.
*/
add_action ("bb_init", "ws_plugin__s2member_bridge_bbpress_roles", 1);
/**/
if (!function_exists ("ws_plugin__s2member_bridge_bbpress_roles"))
	{
		function ws_plugin__s2member_bridge_bbpress_roles () /* On-the-fly. */
			{
				if (is_object ($user = bb_get_current_user ()) && $user->ID) /* Logged in? */
					{
						if (empty ($user->roles)) /* Only if/when no bbPress® Role is assigned. */
							{
								bb_give_user_default_role($user); /* Assign default Role. */
							}
					}
				/**/
				return; /* Return for uniformity. */
			}
	}
/*
Deny all access to the bbPress® registration page.
This will leave the bbPress® login page available, as it should be.
- This is also the overall bbPress® security gate for s2Member.
*/
add_action ("bb_init", "ws_plugin__s2member_bridge_bbpress_access", 1);
/**/
if (!function_exists ("ws_plugin__s2member_bridge_bbpress_access"))
	{
		function ws_plugin__s2member_bridge_bbpress_access ()
			{
				$location = bb_get_location (); /* The current location. */
				/**/
				$wp_caps = bb_get_option ("wp_table_prefix") . "capabilities";
				/**/
				$ovg = (int)WS_PLUGIN__S2MEMBER_BRIDGE_BBPRESS_ALLOW_OPEN_VIEWING;
				$min = (int)WS_PLUGIN__S2MEMBER_BRIDGE_BBPRESS_MIN_PARTICIPATION_LEVEL;
				/**/
				$open_viewing_possible = $ovg; /* Use this for additional clarity. */
				/**/
				if (!in_array ($location, array ("login-page", "register-page")))
					{
						if ($url = bb_get_option ("wp_siteurl")) /* WordPress® integrated? */
							{
								if (!$open_viewing_possible) /* If Open Viewing is NOT possible. */
									{
										if (!bb_is_user_logged_in () || !bb_current_user_can ("participate"))
											{
												$bbPress = bb_get_option ("url"); /* bbPress® URL location. */
												/**/
												if (preg_match ("/^" . preg_quote ($bbPress, "/") . "/", $_SERVER["HTTP_REFERER"]))
													wp_redirect ($url, apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ()));
												/**/
												else /* Otherwise, trigger the Membership Options Page + s2member_level_req = $min. */
													wp_redirect ($url . "/?s2member_membership_options_page=1&s2member_seeking=bbpress&s2member_level_req=" . urlencode ($min), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ()));
												/**/
												exit (); /* Clean exit. */
											}
										else if (is_object ($user = bb_get_current_user ()) && $user->ID && isset ($user->$wp_caps) && is_array ($user->$wp_caps))
											{
												$wp_role = reset (array_keys ($user->$wp_caps)); /* Looking for ^(subscriber|s2member_level[0-9]+)$. */
												/**/
												if (preg_match ("/^(subscriber|s2member_level[0-9]+)$/", $wp_role)) /* Subscribers and/or s2 Roles. */
													{
														if (($wp_role === "subscriber" && $min > 0) || ($level = str_replace ("s2member_level", "", $wp_role)) < $min)
															{
																$bbPress = bb_get_option ("url"); /* bbPress® URL location. */
																/**/
																if (preg_match ("/^" . preg_quote ($bbPress, "/") . "/", $_SERVER["HTTP_REFERER"]))
																	wp_redirect ($url, apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ()));
																/**/
																else /* Otherwise, redirect this User to your Membership Options Page. */
																	wp_redirect ($url . "/?s2member_membership_options_page=1&s2member_seeking=bbpress&s2member_level_req=" . urlencode ($min), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ()));
																/**/
																exit (); /* Clean exit. */
															}
													}
											}
									}
								else if ($open_viewing_possible) /* Else, if Open Viewing IS possible. */
									{
										add_filter ("bb_current_user_can", "_ws_plugin__s2member_bridge_bbpress_access_caps", 10, 2);
										/**/
										if (!function_exists ("_ws_plugin__s2member_bridge_bbpress_access_caps"))
											{
												function _ws_plugin__s2member_bridge_bbpress_access_caps ($can = FALSE, $cap = FALSE)
													{
														$wp_caps = bb_get_option ("wp_table_prefix") . "capabilities";
														/**/
														$min = (int)WS_PLUGIN__S2MEMBER_BRIDGE_BBPRESS_MIN_PARTICIPATION_LEVEL;
														/**/
														if (!bb_is_user_logged_in ()) /* If/when they're NOT logged in; read-only. */
															{
																return ($cap === "read") ? true : false; /* Read-only access. */
															}
														else if (is_object ($user = bb_get_current_user ()) && $user->ID && isset ($user->$wp_caps) && is_array ($user->$wp_caps))
															{
																$wp_role = reset (array_keys ($user->$wp_caps)); /* Looking for ^(subscriber|s2member_level[0-9]+)$. */
																/**/
																if (preg_match ("/^(subscriber|s2member_level[0-9]+)$/", $wp_role)) /* Subscribers and/or s2 Roles. */
																	{
																		if (($wp_role === "subscriber" && $min > 0) || ($level = str_replace ("s2member_level", "", $wp_role)) < $min)
																			{
																				return ($cap === "read") ? true : false;
																			}
																	}
															}
														/* Whatever bbPress® says. */
														return $can; /* Default. */
													}
											}
										/**/
										add_action ("post_post_form", "_ws_plugin__s2member_bridge_bbpress_access_post_form");
										/**/
										if (!function_exists ("_ws_plugin__s2member_bridge_bbpress_access_post_form"))
											{
												function _ws_plugin__s2member_bridge_bbpress_access_post_form ()
													{
														$min = (int)WS_PLUGIN__S2MEMBER_BRIDGE_BBPRESS_MIN_PARTICIPATION_LEVEL;
														/**/
														if (bb_is_user_logged_in () && !bb_current_user_can ("participate")) /* Unable to participate? */
															{
																echo '<p class="upgrade-line">Your Membership needs to be <a href="' . esc_attr (bb_get_option ("wp_siteurl") . "/?s2member_membership_options_page=1&s2member_seeking=bbpress&s2member_level_req=" . urlencode ($min)) . '" class="upgrade-link">upgraded</a> before you can Post.</p>';
															}
													}
											}
									}
							}
					}
				else if (in_array ($location, array ("register-page"))) /* Send registration requests through WP. */
					{
						if ($url = bb_get_option ("wp_siteurl")) /* This will redirect registrants to your Membership Options Page. */
							{
								wp_redirect ($url . "/?s2member_membership_options_page=1&s2member_seeking=bbpress&s2member_level_req=" . urlencode ($min), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ()));
								/**/
								exit (); /* Clean exit. */
							}
					}
				/**/
				return; /* Return for uniformity. */
			}
	}
/* -------------------------------------------------------------------------- */
/*
API function for Role Conditionals in bbPress®.
*/
if (!function_exists ("current_wp_user_is"))
	{
		function current_wp_user_is ($role = FALSE)
			{
				$wp_caps = bb_get_option ("wp_table_prefix") . "capabilities";
				/**/
				if ($role && is_object ($user = bb_get_current_user ()) && $user->ID && isset ($user->$wp_caps) && is_array ($user->$wp_caps))
					{
						$wp_role = reset (array_keys ($user->$wp_caps));
						/**/
						return ($wp_role === $role);
					}
				else /* Nope. */
					return false;
			}
	}
?>