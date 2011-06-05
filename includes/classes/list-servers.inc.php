<?php
/**
* List Server integrations.
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
* @package s2Member\List_Servers
* @since 3.5
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_list_servers"))
	{
		/**
		* List Server integrations.
		*
		* @package s2Member\List_Servers
		* @since 3.5
		*/
		class c_ws_plugin__s2member_list_servers
			{
				/**
				* Determines whether or not any List Servers have been integrated.
				*
				* @package s2Member\List_Servers
				* @since 3.5
				*
				* @return bool True if List Servers have been integrated, else false.
				*/
				public static function list_servers_integrated ()
					{
						do_action ("ws_plugin__s2member_before_list_servers_integrated", get_defined_vars ());
						/**/
						for ($n = 0; $n <= $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["levels"]; $n++) /* Go through each Level; looking for a configured list. */
							if (!empty ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_mailchimp_list_ids"]) || !empty ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_aweber_list_ids"]))
								return apply_filters ("ws_plugin__s2member_list_servers_integrated", true, get_defined_vars ());
						/**/
						return apply_filters ("ws_plugin__s2member_list_servers_integrated", false, get_defined_vars ());
					}
				/**
				* Processes List Server integrations for s2Member.
				*
				* @package s2Member\List_Servers
				* @since 3.5
				*
				* @param str $role A WordPress Role ID/Name, such as `subscriber`, or `s2member_level1`.
				* @param int|str $level A numeric s2Member Access Level number.
				* @param str $login Username for the User.
				* @param str $pass Plain Text Password for the User.
				* @param str $email Email Address for the User.
				* @param str $fname First Name for the User.
				* @param str $lname Last Name for the User.
				* @param str $ip IP Address for the User.
				* @param bool $opt_in Defaults to false; must be set to true. Indicates the User IS opting in.
				* @param bool $double_opt_in Defaults to true. If false, no email confirmation is required. Use at your own risk.
				* @param int|str $user_id A WordPress User ID, numeric string or integer.
				* @return bool True if at least one List Server is processed successfully, else false.
				*
				* @todo Integrate {@link https://labs.aweber.com/docs/php-library-walkthrough AWeber's API}.
				* @todo Add a separate option for mail debugging; or consolidate?
				* @todo Integrate AWeber® API ( much like the MailChimp® API ).
				*/
				public static function process_list_servers ($role = FALSE, $level = FALSE, $login = FALSE, $pass = FALSE, $email = FALSE, $fname = FALSE, $lname = FALSE, $ip = FALSE, $opt_in = FALSE, $double_opt_in = TRUE, $user_id = FALSE)
					{
						global $current_site, $current_blog; /* For Multisite support. */
						/**/
						eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_process_list_servers", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if (($args = func_get_args ()) && $role && strlen ($level) && $login && is_email ($email) && $opt_in && $user_id && is_object ($user = new WP_User ($user_id)) && ($user_id = $user->ID))
							{
								$ccaps = implode (",", c_ws_plugin__s2member_user_access::user_access_ccaps ($user)); /* Get Custom Capabilities ( comma-delimited ). */
								/**/
								$email_configs_were_on = c_ws_plugin__s2member_email_configs::email_config_status (false); /* s2Member Filters enabled? */
								c_ws_plugin__s2member_email_configs::email_config_release (true); /* Release all mail Filters before we begin this routine. */
								/**/
								if (!empty ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["mailchimp_api_key"]) && !empty ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $level . "_mailchimp_list_ids"]))
									{
										if (!class_exists ("NC_MCAPI")) /* Include the MailChimp® API Class here. */
											include_once dirname (dirname (__FILE__)) . "/_xtnls/mailchimp/nc-mcapi.inc.php"; /* MailChimp® API ( no-conflict version ). */
										/**/
										$mcapi = new NC_MCAPI ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["mailchimp_api_key"]); /* MailChimp® API ( no-conflict ). */
										/**/
										foreach (preg_split ("/[\r\n\t;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $level . "_mailchimp_list_ids"]) as $mailchimp_list)
											{
												$mailchimp = array ("function" => __FUNCTION__, "func_get_args" => $args, "api_method" => "listSubscribe");
												/**/
												if (($mailchimp["list"] = trim ($mailchimp_list))) /* Trim this up. NO trailing white space. */
													{
														if (strpos ($mailchimp["list"], "::") !== false) /* Also contains Interest Groups? */
															{
																list ($mailchimp["list_id"], $mailchimp["interest_groups_title"], $mailchimp["interest_groups"]) = preg_split ("/\:\:/", $mailchimp["list"], 3);
																/**/
																if (($mailchimp["interest_groups_title"] = trim ($mailchimp["interest_groups_title"]))) /* This is a title configured by the list master. */
																	if (($mailchimp["interest_groups"] = (trim ($mailchimp["interest_groups"])) ? preg_split ("/\|/", trim ($mailchimp["interest_groups"])) : false))
																		$mailchimp["interest_groups"] = array ("GROUPINGS" => array (array ("name" => $mailchimp["interest_groups_title"], "groups" => implode (",", $mailchimp["interest_groups"]))));
																/**/
																if (empty ($mailchimp["list_id"])) /* Need to double-check this. If empty, skip over this entry. */
																	continue; /* Continue to next List, if there is one. */
															}
														else /* Else, it's just a List ID. */
															$mailchimp["list_id"] = $mailchimp["list"];
														/**/
														$mailchimp["merge_array"] = array ("MERGE1" => $fname, "MERGE2" => $lname, "OPTIN_IP" => $ip, "OPTIN_TIME" => date ("Y-m-d H:i:s"));
														$mailchimp["merge_array"] = ($mailchimp["interest_groups"]) ? array_merge ($mailchimp["merge_array"], $mailchimp["interest_groups"]) : $mailchimp["merge_array"];
														$mailchimp["merge_array"] = apply_filters ( /* Deprecated. */"ws_plugin__s2member_mailchimp_array", $mailchimp["merge_array"], get_defined_vars ());
														/* Filter: `ws_plugin__s2member_mailchimp_array` deprecated in v110523. Please use Filter: `ws_plugin__s2member_mailchimp_merge_array`. */
														/**/
														if ($mailchimp["api_response"] = $mcapi->{$mailchimp["api_method"]}($mailchimp["list_id"], $email, /* See: `http://apidocs.mailchimp.com/` for full details. */
														($mailchimp["api_merge_array"] = apply_filters ("ws_plugin__s2member_mailchimp_merge_array", $mailchimp["merge_array"], get_defined_vars ())), /* Configured merge array above. */
														($mailchimp["api_email_type"] = apply_filters ("ws_plugin__s2member_mailchimp_email_type", "html", get_defined_vars ())), /* Type of email to receive ( i.e. html,text,mobile ).*/
														($mailchimp["api_double_optin"] = apply_filters ("ws_plugin__s2member_mailchimp_double_optin", $double_opt_in, get_defined_vars ())), /* Abuse of this may cause account suspension. */
														($mailchimp["api_update_existing"] = apply_filters ("ws_plugin__s2member_mailchimp_update_existing", false, get_defined_vars ())), /* Existing subscribers should be updated with this? */
														($mailchimp["api_replace_interests"] = apply_filters ("ws_plugin__s2member_mailchimp_replace_interests", true, get_defined_vars ())), /* Replace interest groups? ( only if provided ) */
														($mailchimp["api_send_welcome"] = apply_filters ("ws_plugin__s2member_mailchimp_send_welcome", false, get_defined_vars ())))) /* See documentation. This is a weird option. */
															$mailchimp["api_success"] = $success = true; /* Flag indicating that we DO have a successful processing of a new List; affects the function's overall return value. */
														$mailchimp["api_properties"] = $mcapi; /* Include API instance too; as it contains some additional information after each method is processed ( need this in the logs ). */
														/**/
														$logv = c_ws_plugin__s2member_utilities::ver_details ();
														$log4 = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] . "\nUser-Agent: " . $_SERVER["HTTP_USER_AGENT"];
														$log4 = (is_multisite () && !is_main_site ()) ? ($_log4 = $current_blog->domain . $current_blog->path) . "\n" . $log4 : $log4;
														$log2 = (is_multisite () && !is_main_site ()) ? "mailchimp-api-4-" . trim (preg_replace ("/[^a-z0-9]/i", "-", $_log4), "-") . ".log" : "mailchimp-api.log";
														/**/
														if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["gateway_debug_logs"])
															if (is_dir ($logs_dir = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["logs_dir"]))
																if (is_writable ($logs_dir) && c_ws_plugin__s2member_utils_logs::archive_oversize_log_files ())
																	file_put_contents ($logs_dir . "/" . $log2, $logv . "\n" . $log4 . "\n" . var_export ($mailchimp, true) . "\n\n", FILE_APPEND);
													}
											}
									}
								/**/
								if (!empty ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $level . "_aweber_list_ids"]))
									{
										foreach (preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $level . "_aweber_list_ids"]) as $aweber_list)
											{
												$aweber = array ("function" => __FUNCTION__, "func_get_args" => $args, "wp_mail_method" => "listSubscribe");
												/**/
												if (($aweber["list_id"] = trim ($aweber_list))) /* Trim this up. NO trailing white space. */
													{
														$aweber["bcc"] = apply_filters ("ws_plugin__s2member_aweber_bcc", false, get_defined_vars ());
														$aweber["pass_inclusion"] = (apply_filters ("ws_plugin__s2member_aweber_pass_inclusion", false, get_defined_vars ()) && $pass) ? "\nPass: " . $pass : false;
														/**/
														if ($aweber["wp_mail_response"] = wp_mail ($aweber["list_id"] . "@aweber.com", /* AWeber® List ID converts to email address @aweber.com. */
														($aweber["wp_mail_sbj"] = apply_filters ("ws_plugin__s2member_aweber_sbj", "s2Member Subscription Request", get_defined_vars ())), /* These Filters make it possible to customize these emails. */
														($aweber["wp_mail_msg"] = apply_filters ("ws_plugin__s2member_aweber_msg", "s2Member Subscription Request\ns2Member w/ PayPal Email ID\nAd Tracking: s2Member-" . ((is_multisite () && !is_main_site ()) ? $current_blog->domain . $current_blog->path : $_SERVER["HTTP_HOST"]) . "\nEMail Address: " . $email . "\nBuyer: " . $fname . " " . $lname . "\nFull Name: " . $fname . " " . $lname . "\nFirst Name: " . $fname . "\nLast Name: " . $lname . "\nIP Address: " . $ip . "\nUser ID: " . $user_id . "\nLogin: " . $login . $aweber["pass_inclusion"] . "\nRole: " . $role . "\nLevel: " . $level . "\nCCaps: " . $ccaps . "\n - end.", get_defined_vars ())),/**/
														($aweber["wp_mail_headers"] = "From: \"" . preg_replace ("/\"/", "", $fname . " " . $lname) . "\" <" . $email . ">" . (($aweber["bcc"]) ? "\r\nBcc: " . $aweber["bcc"] : "") . "\r\nContent-Type: text/plain; charset=utf-8")))
															$aweber["wp_mail_success"] = $success = true; /* Flag indicating that we DO have a successful processing of a new List; affects the function's overall return value. */
														/**/
														$logv = c_ws_plugin__s2member_utilities::ver_details ();
														$log4 = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] . "\nUser-Agent: " . $_SERVER["HTTP_USER_AGENT"];
														$log4 = (is_multisite () && !is_main_site ()) ? ($_log4 = $current_blog->domain . $current_blog->path) . "\n" . $log4 : $log4;
														$log2 = (is_multisite () && !is_main_site ()) ? "aweber-api-4-" . trim (preg_replace ("/[^a-z0-9]/i", "-", $_log4), "-") . ".log" : "aweber-api.log";
														/**/
														if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["gateway_debug_logs"])
															if (is_dir ($logs_dir = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["logs_dir"]))
																if (is_writable ($logs_dir) && c_ws_plugin__s2member_utils_logs::archive_oversize_log_files ())
																	file_put_contents ($logs_dir . "/" . $log2, $logv . "\n" . $log4 . "\n" . var_export ($aweber, true) . "\n\n", FILE_APPEND);
													}
											}
									}
								/**/
								eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_process_list_servers", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								if ($email_configs_were_on) /* Back on? */
									c_ws_plugin__s2member_email_configs::email_config ();
							}
						/**/
						eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_after_process_list_servers", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						return apply_filters ("ws_plugin__s2member_process_list_servers", (isset ($success) && $success), get_defined_vars ());
					}
				/**
				* Processes List Server removals for s2Member.
				*
				* @package s2Member\List_Servers
				* @since 3.5
				*
				* @param str $role A WordPress Role ID/Name, such as `subscriber`, or `s2member_level1`.
				* @param int|str $level A numeric s2Member Access Level number.
				* @param str $login Username for the User.
				* @param str $pass Plain Text Password for the User.
				* @param str $email Email address for the User.
				* @param str $fname First Name for the User.
				* @param str $lname Last Name for the User.
				* @param str $ip IP Address for the User.
				* @param bool $opt_out Defaults to false; must be set to true. Indicates the User IS opting out.
				* @param int|str $user_id A WordPress User ID, numeric string or integer.
				* @return bool True if at least one List Server is processed successfully, else false.
				*
				* @todo Integrate {@link https://labs.aweber.com/docs/php-library-walkthrough AWeber's API}.
				* @todo Add a separate option for mail debugging; or consolidate?
				* @todo Integrate AWeber® API ( much like the MailChimp® API ).
				*/
				public static function process_list_server_removals ($role = FALSE, $level = FALSE, $login = FALSE, $pass = FALSE, $email = FALSE, $fname = FALSE, $lname = FALSE, $ip = FALSE, $opt_out = FALSE, $user_id = FALSE)
					{
						global $current_site, $current_blog; /* For Multisite support. */
						/**/
						eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_process_list_server_removals", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if (($args = func_get_args ()) && $role && strlen ($level) && $login && is_email ($email) && $opt_out && $user_id && is_object ($user = new WP_User ($user_id)) && ($user_id = $user->ID))
							{
								$email_configs_were_on = c_ws_plugin__s2member_email_configs::email_config_status (false); /* s2Member Filters enabled? */
								c_ws_plugin__s2member_email_configs::email_config_release (true); /* Release all mail Filters before we begin this routine. */
								/**/
								if (!empty ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["mailchimp_api_key"]) && !empty ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $level . "_mailchimp_list_ids"]))
									{
										if (!class_exists ("NC_MCAPI")) /* Include the MailChimp® API Class here. */
											include_once dirname (dirname (__FILE__)) . "/_xtnls/mailchimp/nc-mcapi.inc.php"; /* MailChimp® API ( no-conflict version ). */
										/**/
										$mcapi = new NC_MCAPI ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["mailchimp_api_key"]); /* MailChimp® API ( no-conflict ). */
										/**/
										foreach (preg_split ("/[\r\n\t;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $level . "_mailchimp_list_ids"]) as $mailchimp_list)
											{
												$mailchimp = array ("function" => __FUNCTION__, "func_get_args" => $args, "api_removal_method" => "listUnsubscribe");
												/**/
												if (($mailchimp["list_id"] = trim (preg_replace ("/\:\:.*$/", "", $mailchimp_list)))) /* Trim & strip groups. */
													{
														if ($mailchimp["api_removal_response"] = $mcapi->{$mailchimp["api_removal_method"]}($mailchimp["list_id"], $email, /* See: `http://apidocs.mailchimp.com/` for full details. */
														($mailchimp["api_removal_delete_member"] = apply_filters ("ws_plugin__s2member_mailchimp_removal_delete_member", false, get_defined_vars ())), /* Completely delete? */
														($mailchimp["api_removal_send_goodbye"] = apply_filters ("ws_plugin__s2member_mailchimp_removal_send_goodbye", false, get_defined_vars ())), /* Send goodbye letter? */
														($mailchimp["api_removal_send_notify"] = apply_filters ("ws_plugin__s2member_mailchimp_removal_send_notify", false, get_defined_vars ())))) /* Send notification? */
															$mailchimp["api_removal_success"] = $removal_success = true; /* Flag indicating that we DO have a successful removal; affects the function's overall return value. */
														$mailchimp["api_removal_properties"] = $mcapi; /* Include API instance too; as it contains some additional information after each method is processed ( need this in the logs ). */
														/**/
														$logv = c_ws_plugin__s2member_utilities::ver_details ();
														$log4 = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] . "\nUser-Agent: " . $_SERVER["HTTP_USER_AGENT"];
														$log4 = (is_multisite () && !is_main_site ()) ? ($_log4 = $current_blog->domain . $current_blog->path) . "\n" . $log4 : $log4;
														$log2 = (is_multisite () && !is_main_site ()) ? "mailchimp-api-4-" . trim (preg_replace ("/[^a-z0-9]/i", "-", $_log4), "-") . ".log" : "mailchimp-api.log";
														/**/
														if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["gateway_debug_logs"])
															if (is_dir ($logs_dir = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["logs_dir"]))
																if (is_writable ($logs_dir) && c_ws_plugin__s2member_utils_logs::archive_oversize_log_files ())
																	file_put_contents ($logs_dir . "/" . $log2, $logv . "\n" . $log4 . "\n" . var_export ($mailchimp, true) . "\n\n", FILE_APPEND);
													}
											}
									}
								/**/
								if (!empty ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $level . "_aweber_list_ids"]))
									{
										foreach (preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $level . "_aweber_list_ids"]) as $aweber_list)
											{
												$aweber = array ("function" => __FUNCTION__, "func_get_args" => $args, "wp_mail_removal_method" => "listUnsubscribe");
												/**/
												if (($aweber["list_id"] = trim ($aweber_list))) /* Trim this up. NO trailing white space. */
													{
														$aweber["removal_bcc"] = apply_filters ("ws_plugin__s2member_aweber_removal_bcc", false, get_defined_vars ());
														/**/
														if ($aweber["wp_mail_removal_response"] = wp_mail ($aweber["list_id"] . "@aweber.com", /* AWeber® List ID converts to email address @aweber.com. */
														($aweber["wp_mail_removal_sbj"] = apply_filters ("ws_plugin__s2member_aweber_removal_sbj", "REMOVE#" . $email . "#s2Member#" . $aweber["list_id"], get_defined_vars ())), /* Bug fix. AWeber® does not like dots ( possibly other chars ) in the Ad Tracking field. Now using just: `s2Member`. */
														($aweber["wp_mail_removal_msg"] = "REMOVE"), ($aweber["wp_mail_removal_headers"] = "From: \"" . preg_replace ('/"/', "'", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_name"]) . "\" <" . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_email"] . ">" . (($aweber["removal_bcc"]) ? "\r\nBcc: " . $aweber["removal_bcc"] : "") . "\r\nContent-Type: text/plain; charset=utf-8")))
															$aweber["wp_mail_removal_success"] = $removal_success = true; /* Flag indicating that we DO have a successful removal; affects the function's overall return value. */
														/**/
														$logv = c_ws_plugin__s2member_utilities::ver_details ();
														$log4 = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] . "\nUser-Agent: " . $_SERVER["HTTP_USER_AGENT"];
														$log4 = (is_multisite () && !is_main_site ()) ? ($_log4 = $current_blog->domain . $current_blog->path) . "\n" . $log4 : $log4;
														$log2 = (is_multisite () && !is_main_site ()) ? "aweber-api-4-" . trim (preg_replace ("/[^a-z0-9]/i", "-", $_log4), "-") . ".log" : "aweber-api.log";
														/**/
														if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["gateway_debug_logs"])
															if (is_dir ($logs_dir = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["logs_dir"]))
																if (is_writable ($logs_dir) && c_ws_plugin__s2member_utils_logs::archive_oversize_log_files ())
																	file_put_contents ($logs_dir . "/" . $log2, $logv . "\n" . $log4 . "\n" . var_export ($aweber, true) . "\n\n", FILE_APPEND);
													}
											}
									}
								/**/
								eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_process_list_server_removals", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								if ($email_configs_were_on) /* Back on? */
									c_ws_plugin__s2member_email_configs::email_config ();
							}
						/**/
						eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_after_process_list_server_removals", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						return apply_filters ("ws_plugin__s2member_process_list_server_removals", (isset ($removal_success) && $removal_success), get_defined_vars ());
					}
				/**
				* Listens to Collective EOT/MOD Events processed internally by s2Member.
				*
				* This is only applicable when ``["custom_reg_auto_opt_outs"]`` contains related Event(s).
				*
				* @package s2Member\List_Servers
				* @since 3.5
				*
				* @attaches-to: ``add_action("ws_plugin__s2member_during_collective_mods");``
				* @attaches-to: ``add_action("ws_plugin__s2member_during_collective_eots");``
				*
				* @param int|str $user_id A WordPress® User ID, numeric string or integer.
				* @param array $vars An array of defined variables from the calling Action Hook.
				* @param str $event A specific event that triggered this call from the Action Hook.
				* @param str $event_spec A specific event specification *( a broader classification )*.
				* @param str $mod_new_role If it's a modification, the new Role they are being modified to.
				* @param str $mod_old_role If it's a modification, the old Role they had previously.
				* @param obj $user Optional. A WP_User object that can reduce database queries for this routine.
				* @return null
				*
				* @todo Make it possible to transition Users, even if they were not currently on a list?
				* 	One suggestion was to send a double-opt-in email in that case; or to provide an option for this?
				* @todo Tighten up the call to ``c_ws_plugin__s2member_utils_strings::wrap_deep()`` by using `^$`?
				*/
				public static function auto_process_list_server_removals ($user_id = FALSE, $vars = FALSE, $event = FALSE, $event_spec = FALSE, $mod_new_role = FALSE, $mod_old_role = FALSE, $user = FALSE)
					{
						global $current_site, $current_blog; /* For Multisite support. */
						static $auto_processed = array (); /* Only process ONE time for each User ID. */
						/**/
						eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_auto_process_list_server_removals", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						$custom_reg_auto_op_outs = c_ws_plugin__s2member_utils_strings::wrap_deep ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_auto_opt_outs"], "/", "/i");
						/**/
						if ($user_id && !in_array ($user_id, $auto_processed) && (c_ws_plugin__s2member_utils_arrays::in_regex_array ($event, $custom_reg_auto_op_outs) || c_ws_plugin__s2member_utils_arrays::in_regex_array ($event_spec, $custom_reg_auto_op_outs)) && c_ws_plugin__s2member_list_servers::list_servers_integrated () && (is_object ($user) || is_object ($user = new WP_User ($user_id))) && ($user_id = $user->ID))
							{
								$role = ($event_spec === "modification" && $mod_new_role && $mod_old_role) ? $mod_old_role : c_ws_plugin__s2member_user_access::user_access_role ($user);
								$level = ($event_spec === "modification" && $mod_new_role && $mod_old_role) ? c_ws_plugin__s2member_user_access::user_access_role_to_level ($mod_old_role) : c_ws_plugin__s2member_user_access::user_access_level ($user);
								/**/
								if (($event_spec !== "modification" || ($event_spec === "modification" && $mod_new_role && $mod_new_role !== $role && strtotime ($user->user_registered) < strtotime ("-10 seconds") && ($event !== "user-role-change" || ($event === "user-role-change" && !empty ($_POST["ws_plugin__s2member_custom_reg_auto_opt_out_transitions"]))))) && ($auto_processed[$user_id] = true))
									{
										$removal_success = c_ws_plugin__s2member_list_servers::process_list_server_removals ($role, $level, $user->user_login, false, $user->user_email, $user->first_name, $user->last_name, false, true, $user_id);
										if ( /* Only if removed successfully. */$removal_success && $event_spec === "modification" && $mod_new_role && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_auto_opt_out_transitions"]) /* Transition? */
											c_ws_plugin__s2member_list_servers::process_list_servers ($mod_new_role, ($mod_new_level = c_ws_plugin__s2member_user_access::user_access_role_to_level ($mod_new_role)), $user->user_login, false, $user->user_email, $user->first_name, $user->last_name, false, true, false, $user_id);
									}
							}
						/**/
						eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_after_auto_process_list_server_removals", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						return; /* Return for uniformity. */
					}
			}
	}
?>