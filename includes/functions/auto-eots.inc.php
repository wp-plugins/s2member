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
	exit;
/*
Function processed by WP-Cron. This handles Auto-EOTs.
If you have a HUGE user-base, increase the max eots per process.
To increase, use: add_filter ("ws_plugin__s2member_auto_eot_system_per_process");
*/
if (!function_exists ("ws_plugin__s2member_auto_eot_system"))
	{
		function ws_plugin__s2member_auto_eot_system ($per_process = 10)
			{
				global $wpdb; /* Need global DB obj. */
				/**/
				include_once ABSPATH . "wp-admin/includes/admin.php";
				/**/
				do_action ("ws_plugin__s2member_before_auto_eot_system", get_defined_vars ());
				/**/
				if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["auto_eot_system_enabled"]) /* Enabled? */
					{
						$per_process = apply_filters ("ws_plugin__s2member_auto_eot_system_per_process", $per_process, get_defined_vars ());
						/**/
						if ($eots = $wpdb->get_results ("SELECT `user_id` FROM `" . $wpdb->usermeta . "` WHERE `meta_key` = 's2member_auto_eot_time' AND `meta_value` <= '" . $wpdb->escape (strtotime ("now")) . "' LIMIT " . $per_process))
							{
								foreach ($eots as $eot) /* Go through the array of eots. We need to (demote|delete) each of them. */
									{
										$user_id = $eot->user_id; /* Grab the user ID value from the query. */
										/**/
										$user = new WP_User ($user_id); /* Acquire user object. */
										/**/
										delete_usermeta ($user_id, "s2member_auto_eot_time"); /* Always delete this. */
										/* Removing this prevents re-runs on non WP Roles. Which are scanned for next. */
										/**/
										if (!ws_plugin__s2member_user_has_wp_role ($user)) /* Non WP Roles. */
											{
												if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_eot_behavior"] === "demote")
													{
														$user->set_role ("subscriber");
														/**/
														$subscr_id = get_usermeta ($user_id, "s2member_subscr_id");
														$custom = get_usermeta ($user_id, "s2member_custom");
														/**/
														delete_usermeta ($user_id, "s2member_custom");
														delete_usermeta ($user_id, "s2member_subscr_id");
														delete_usermeta ($user_id, "s2member_last_payment_time");
														delete_usermeta ($user_id, "s2member_auto_eot_time");
														/**/
														foreach ($user->allcaps as $cap => $cap_enabled)
															if (preg_match ("/^access_s2member_ccap_/", $cap))
																$user->remove_cap ($ccap = $cap);
														/**/
														delete_usermeta ($user_id, "s2member_file_download_access_arc");
														delete_usermeta ($user_id, "s2member_file_download_access_log");
														/**/
														ws_plugin__s2member_append_user_notes ($user_id, "Demoted by s2Member: " . date ("D M j, Y g:i a T"));
														/**/
														if ($subscr_id && $custom && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["eot_del_notification_urls"] && is_array ($cv = preg_split ("/\|/", $custom)))
															{
																foreach (preg_split ("/[\r\n\t]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["eot_del_notification_urls"]) as $url) /* Handle EOT Notifications. */
																	/**/
																	if (($url = preg_replace ("/%%cv([0-9]+)%%/ei", 'urlencode(trim($cv[$1]))', $url)) && ($url = preg_replace ("/%%subscr_id%%/i", urlencode ($subscr_id), $url)))
																		if (($url = preg_replace ("/%%user_first_name%%/i", urlencode ($user->first_name), $url)) && ($url = preg_replace ("/%%user_last_name%%/i", urlencode ($user->last_name), $url)))
																			if (($url = preg_replace ("/%%user_full_name%%/i", urlencode (trim ($user->first_name . " " . $user->last_name)), $url)))
																				if (($url = preg_replace ("/%%user_email%%/i", urlencode ($user->user_email), $url)))
																					/**/
																					if (($url = trim ($url))) /* Empty? */
																						ws_plugin__s2member_remote ($url);
															}
														/**/
														eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
														do_action ("ws_plugin__s2member_during_auto_eot_system_during_demote", get_defined_vars ());
														unset ($__refs, $__v); /* Unset defined __refs, __v. */
													}
												else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_eot_behavior"] === "delete")
													{
														wp_delete_user ($user_id); /* Triggers: `ws_plugin__s2member_handle_user_deletions()` */
														/* `ws_plugin__s2member_handle_user_deletions()` triggers `eot_del_notification_urls` */
														/**/
														eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
														do_action ("ws_plugin__s2member_during_auto_eot_system_during_delete", get_defined_vars ());
														unset ($__refs, $__v); /* Unset defined __refs, __v. */
													}
												/**/
												eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
												do_action ("ws_plugin__s2member_during_auto_eot_system", get_defined_vars ());
												unset ($__refs, $__v); /* Unset defined __refs, __v. */
											}
									}
							}
					}
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_after_auto_eot_system", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				return;
			}
	}
/*
This function allows the Auto-EOT Sytem to be
processed through a server-side Cron Job.
Attach to: add_action("init");
*/
if (!function_exists ("ws_plugin__s2member_auto_eot_system_via_cron"))
	{
		function ws_plugin__s2member_auto_eot_system_via_cron ()
			{
				do_action ("ws_plugin__s2member_before_auto_eot_system_via_cron", get_defined_vars ());
				/**/
				if ($_GET["s2member_auto_eot_system_via_cron"]) /* Being called through HTTP? */
					{
						if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["auto_eot_system_enabled"])
							{
								ws_plugin__s2member_auto_eot_system ();
								/**/
								do_action ("ws_plugin__s2member_during_auto_eot_system_via_cron", get_defined_vars ());
							}
						/**/
						exit; /* Exit. */
					}
				/**/
				do_action ("ws_plugin__s2member_after_auto_eot_system_via_cron", get_defined_vars ());
			}
	}
/*
Extends the WP-Cron schedules to support 10 minute intervals.
Attach to: add_filter("cron_schedules");
*/
if (!function_exists ("ws_plugin__s2member_extend_cron_schedules"))
	{
		function ws_plugin__s2member_extend_cron_schedules ($schedules = array ())
			{
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_extend_cron_schedules", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				$array = array ("every10m" => array ("interval" => 600, "display" => "Every 10 Minutes"));
				/**/
				return apply_filters ("ws_plugin__s2member_extend_cron_schedules", array_merge ($array, $schedules), get_defined_vars ());
			}
	}
/*
Adds a scheduled task for s2Member's Auto-EOT System.
*/
if (!function_exists ("ws_plugin__s2member_add_auto_eot_system"))
	{
		function ws_plugin__s2member_add_auto_eot_system ()
			{
				do_action ("ws_plugin__s2member_before_add_auto_eot_system", get_defined_vars ());
				/**/
				if (!ws_plugin__s2member_delete_auto_eot_system ())
					{
						return apply_filters ("ws_plugin__s2member_add_auto_eot_system", false, get_defined_vars ());
					}
				else if (function_exists ("wp_cron")) /* Otherwise, we can schedule. */
					{
						wp_schedule_event (time (), "every10m", "ws_plugin__s2member_auto_eot_system__schedule");
						/**/
						return apply_filters ("ws_plugin__s2member_add_auto_eot_system", true, get_defined_vars ());
					}
				else /* Otherwise, it would appear that WP-Cron is not available. */
					{
						return apply_filters ("ws_plugin__s2member_add_auto_eot_system", false, get_defined_vars ());
					}
			}
	}
/*
Delete scheduled tasks for s2Member's Auto-EOT System.
*/
if (!function_exists ("ws_plugin__s2member_delete_auto_eot_system"))
	{
		function ws_plugin__s2member_delete_auto_eot_system ()
			{
				do_action ("ws_plugin__s2member_before_delete_auto_eot_system", get_defined_vars ());
				/**/
				if (function_exists ("wp_cron"))
					{
						wp_clear_scheduled_hook ("s2member_auto_eot_system"); /* This is for backward compatibility. */
						wp_clear_scheduled_hook ("ws_plugin__s2member_auto_eot_system__schedule"); /* Since v3.0.3. */
						/**/
						return apply_filters ("ws_plugin__s2member_delete_auto_eot_system", true, get_defined_vars ());
					}
				else /* Otherwise, it would appear that WP-Cron is not available. */
					{
						return apply_filters ("ws_plugin__s2member_delete_auto_eot_system", false, get_defined_vars ());
					}
			}
	}
?>