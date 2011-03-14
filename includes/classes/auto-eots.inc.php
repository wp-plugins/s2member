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
if (!class_exists ("c_ws_plugin__s2member_auto_eots"))
	{
		class c_ws_plugin__s2member_auto_eots
			{
				/*
				Adds a scheduled task for s2Member's Auto-EOT System.
				*/
				public static function add_auto_eot_system ()
					{
						do_action ("ws_plugin__s2member_before_add_auto_eot_system", get_defined_vars ());
						/**/
						if (!c_ws_plugin__s2member_auto_eots::delete_auto_eot_system ())
							{
								return apply_filters ("ws_plugin__s2member_add_auto_eot_system", false, get_defined_vars ());
							}
						else if (function_exists ("wp_cron")) /* Otherwise, we can schedule? */
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
				/*
				Delete scheduled tasks for s2Member's Auto-EOT System.
				*/
				public static function delete_auto_eot_system ()
					{
						do_action ("ws_plugin__s2member_before_delete_auto_eot_system", get_defined_vars ());
						/**/
						if (function_exists ("wp_cron")) /* Is `wp_cron()` even available? */
							{
								wp_clear_scheduled_hook ("ws_plugin__s2member_auto_eot_system__schedule"); /* Since v3.0.3. */
								/**/
								return apply_filters ("ws_plugin__s2member_delete_auto_eot_system", true, get_defined_vars ());
							}
						else /* Otherwise, it would appear that WP-Cron is not available. */
							{
								return apply_filters ("ws_plugin__s2member_delete_auto_eot_system", false, get_defined_vars ());
							}
					}
				/*
				Function processed by WP-Cron. This handles Auto-EOTs.
				
				If you have a HUGE userbase, increase the max EOTs per process.
					~ But NOTE, this runs $per_process ( per Blog ) on a Multisite Network.
				To increase, use: add_filter ("ws_plugin__s2member_auto_eot_system_per_process");
				
				s2Member v3.2 ( VERY IMPORTANT ).
					AND `meta_value` != ''
				Because update_user_option() may NOT always delete the key.
				
				This function makes an important Hook available: `ws_plugin__s2member_after_auto_eot_system`.
				This Hook is used by some of s2Member Pro's Gateway integrations; allowing CRON processing
				to run for important communications; which poll Payment Gateway APIs for possible EOTs.
				*/
				public static function auto_eot_system ($per_process = 3)
					{
						global $wpdb; /* Need global DB obj. */
						global $current_site, $current_blog; /* Multisite. */
						/**/
						include_once ABSPATH . "wp-admin/includes/admin.php";
						/**/
						@set_time_limit (0); /* Make time for processing larger userbases. */
						@ini_set ("memory_limit", "256M"); /* Acquire some additional RAM. */
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_auto_eot_system", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["auto_eot_system_enabled"]) /* Enabled? */
							{
								$per_process = apply_filters ("ws_plugin__s2member_auto_eot_system_per_process", $per_process, get_defined_vars ());
								/**/
								if (is_array ($eots = $wpdb->get_results ("SELECT `user_id` AS `ID` FROM `" . $wpdb->usermeta . "` WHERE `meta_key` = '" . $wpdb->prefix . "s2member_auto_eot_time' AND `meta_value` != '' AND `meta_value` <= '" . $wpdb->escape (strtotime ("now")) . "' LIMIT " . $per_process)))
									{
										foreach ($eots as $eot) /* Go through the array of EOTS. We need to (demote|delete) each of them. */
											{
												if (($user_id = $eot->ID) && is_object ($user = new WP_User ($user_id)) && $user->ID)
													{
														delete_user_option ($user_id, "s2member_auto_eot_time"); /* ALWAYS delete this. */
														/**/
														if (!$user->has_cap ("administrator")) /* Do NOT process Administrator accounts. */
															{
																if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_eot_behavior"] === "demote")
																	{
																		$custom = get_user_option ("s2member_custom", $user_id);
																		$subscr_id = get_user_option ("s2member_subscr_id", $user_id);
																		$fields = get_user_option ("s2member_custom_fields", $user_id);
																		/**/
																		eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																		do_action ("ws_plugin__s2member_during_auto_eot_system_during_before_demote", get_defined_vars ());
																		do_action ("ws_plugin__s2member_during_collective_eots", $user_id, get_defined_vars (), "auto-eot-cancellation-expiration-demotion", "cancellation-expiration");
																		unset ($__refs, $__v); /* Unset defined __refs, __v. */
																		/**/
																		$demotion_role = c_ws_plugin__s2member_option_forces::force_demotion_role ("subscriber");
																		$existing_role = c_ws_plugin__s2member_user_access::user_access_role ($user);
																		/**/
																		if ($existing_role !== $demotion_role) /* Only if NOT the existing Role. */
																			$user->set_role ($demotion_role); /* Give User the demotion Role. */
																		/**/
																		foreach ($user->allcaps as $cap => $cap_enabled)
																			if (preg_match ("/^access_s2member_ccap_/", $cap))
																				$user->remove_cap ($ccap = $cap);
																		/**/
																		delete_user_option ($user_id, "s2member_custom");
																		delete_user_option ($user_id, "s2member_subscr_id");
																		delete_user_option ($user_id, "s2member_subscr_gateway");
																		/**/
																		delete_user_option ($user_id, "s2member_ipn_signup_vars");
																		/**/
																		if (!apply_filters ("ws_plugin__s2member_preserve_paid_registration_times", true, get_defined_vars ()))
																			delete_user_option ($user_id, "s2member_paid_registration_times");
																		/**/
																		delete_user_option ($user_id, "s2member_last_status_scan");
																		delete_user_option ($user_id, "s2member_last_payment_time");
																		delete_user_option ($user_id, "s2member_auto_eot_time");
																		/**/
																		delete_user_option ($user_id, "s2member_file_download_access_arc");
																		delete_user_option ($user_id, "s2member_file_download_access_log");
																		/**/
																		c_ws_plugin__s2member_user_notes::append_user_notes ($user_id, "Demoted by s2Member: " . date ("D M j, Y g:i a T"));
																		/**/
																		if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["eot_del_notification_urls"] && is_array ($cv = preg_split ("/\|/", $custom)))
																			{
																				foreach (preg_split ("/[\r\n\t]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["eot_del_notification_urls"]) as $url) /* Handle EOT Notifications. */
																					/**/
																					if (($url = preg_replace ("/%%cv([0-9]+)%%/ei", 'urlencode(trim($cv[$1]))', $url)) && ($url = preg_replace ("/%%eot_del_type%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ("auto-eot-cancellation-expiration-demotion")), $url)) && ($url = preg_replace ("/%%subscr_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($subscr_id)), $url)))
																						if (($url = preg_replace ("/%%user_first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user->first_name)), $url)) && ($url = preg_replace ("/%%user_last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user->last_name)), $url)))
																							if (($url = preg_replace ("/%%user_full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode (trim ($user->first_name . " " . $user->last_name))), $url)))
																								if (($url = preg_replace ("/%%user_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user->user_email)), $url)))
																									if (($url = preg_replace ("/%%user_login%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user->user_login)), $url)))
																										if (($url = preg_replace ("/%%user_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user_id)), $url)))
																											{
																												if (is_array ($fields) && !empty ($fields))
																													foreach ($fields as $var => $val) /* Custom Registration Fields. */
																														if (! ($url = preg_replace ("/%%" . preg_quote ($var, "/") . "%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode (maybe_serialize ($val))), $url)))
																															break;
																												/**/
																												if (($url = trim (preg_replace ("/%%(.+?)%%/i", "", $url))))
																													c_ws_plugin__s2member_utils_urls::remote ($url);
																											}
																			}
																		/**/
																		if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["eot_del_notification_recipients"] && is_array ($cv = preg_split ("/\|/", $custom)))
																			{
																				c_ws_plugin__s2member_email_configs::email_config_release (); /* Release all Filters applied to wp_mail() From: headers. */
																				/**/
																				$msg = $sbj = "( s2Member / API Notification Email ) - EOT/Deletion";
																				$msg .= "\n\n"; /* Spacing in the message body. */
																				/**/
																				$msg .= "eot_del_type: %%eot_del_type%%\n";
																				$msg .= "subscr_id: %%subscr_id%%\n";
																				$msg .= "user_first_name: %%user_first_name%%\n";
																				$msg .= "user_last_name: %%user_last_name%%\n";
																				$msg .= "user_full_name: %%user_full_name%%\n";
																				$msg .= "user_email: %%user_email%%\n";
																				$msg .= "user_login: %%user_login%%\n";
																				$msg .= "user_id: %%user_id%%\n";
																				/**/
																				if (is_array ($fields) && !empty ($fields))
																					foreach ($fields as $var => $val)
																						$msg .= $var . ": %%" . $var . "%%\n";
																				/**/
																				$msg .= "cv0: %%cv0%%\n";
																				$msg .= "cv1: %%cv1%%\n";
																				$msg .= "cv2: %%cv2%%\n";
																				$msg .= "cv3: %%cv3%%\n";
																				$msg .= "cv4: %%cv4%%\n";
																				$msg .= "cv5: %%cv5%%\n";
																				$msg .= "cv6: %%cv6%%\n";
																				$msg .= "cv7: %%cv7%%\n";
																				$msg .= "cv8: %%cv8%%\n";
																				$msg .= "cv9: %%cv9%%";
																				/**/
																				if (($msg = preg_replace ("/%%cv([0-9]+)%%/ei", 'trim($cv[$1])', $msg)) && ($msg = preg_replace ("/%%eot_del_type%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ("auto-eot-cancellation-expiration-demotion"), $msg)) && ($msg = preg_replace ("/%%subscr_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($subscr_id), $msg)))
																					if (($msg = preg_replace ("/%%user_first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user->first_name), $msg)) && ($msg = preg_replace ("/%%user_last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user->last_name), $msg)))
																						if (($msg = preg_replace ("/%%user_full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (trim ($user->first_name . " " . $user->last_name)), $msg)))
																							if (($msg = preg_replace ("/%%user_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user->user_email), $msg)))
																								if (($msg = preg_replace ("/%%user_login%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user->user_login), $msg)))
																									if (($msg = preg_replace ("/%%user_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user_id), $msg)))
																										{
																											if (is_array ($fields) && !empty ($fields))
																												foreach ($fields as $var => $val) /* Custom Registration Fields. */
																													if (! ($msg = preg_replace ("/%%" . preg_quote ($var, "/") . "%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (maybe_serialize ($val)), $msg)))
																														break;
																											/**/
																											if (($msg = trim (preg_replace ("/%%(.+?)%%/i", "", $msg))))
																												foreach (c_ws_plugin__s2member_utils_strings::trim_deep (preg_split ("/;+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["eot_del_notification_recipients"])) as $recipient)
																													($recipient) ? wp_mail ($recipient, apply_filters ("ws_plugin__s2member_eot_del_notification_email_sbj", $sbj, get_defined_vars ()), apply_filters ("ws_plugin__s2member_eot_del_notification_email_msg", $msg, get_defined_vars ()), "From: \"" . preg_replace ('/"/', "'", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_name"]) . "\" <" . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_email"] . ">\r\nContent-Type: text/plain; charset=utf-8") : null;
																										}
																			}
																		/**/
																		eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																		do_action ("ws_plugin__s2member_during_auto_eot_system_during_demote", get_defined_vars ());
																		unset ($__refs, $__v); /* Unset defined __refs, __v. */
																	}
																else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_eot_behavior"] === "delete")
																	{
																		eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																		do_action ("ws_plugin__s2member_during_auto_eot_system_during_before_delete", get_defined_vars ());
																		do_action ("ws_plugin__s2member_during_collective_eots", $user_id, get_defined_vars (), "auto-eot-cancellation-expiration-deletion", "cancellation-expiration");
																		unset ($__refs, $__v); /* Unset defined __refs, __v. */
																		/**/
																		$GLOBALS["ws_plugin__s2member_eot_del_type"] = "auto-eot-cancellation-expiration-deletion";
																		$GLOBALS["ws_plugin__s2member_eot_del_type_spec"] = "cancellation-expiration";
																		/**/
																		if (is_multisite ()) /* Multisite does NOT actually delete; ONLY removes. */
																			{
																				remove_user_from_blog ($user_id, $current_blog->blog_id);
																				/* This will automatically trigger `eot_del_notification_urls` as well. */
																				c_ws_plugin__s2member_user_deletions::handle_ms_user_deletions ($user_id, $current_blog->blog_id, "s2says");
																			}
																		/**/
																		else /* Otherwise, we can actually delete them. */
																			/* This will automatically trigger `eot_del_notification_urls` as well. */
																			wp_delete_user ($user_id); /* `c_ws_plugin__s2member_user_deletions::handle_user_deletions()` */
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
							}
						/**/
						c_ws_plugin__s2member_utils_logs::cleanup_expired_s2m_transients (); /* Cleanup. */
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_after_auto_eot_system", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						return; /* Return for uniformity. */
					}
			}
	}
?>