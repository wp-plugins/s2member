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
if (!class_exists ("c_ws_plugin__s2member_list_servers"))
	{
		class c_ws_plugin__s2member_list_servers
			{
				/*
				Function that determines whether or not any list
				servers have been integrated into the s2Member options.
				*/
				public static function list_servers_integrated ()
					{
						do_action ("ws_plugin__s2member_before_list_servers_integrated", get_defined_vars ());
						/**/
						for ($i = 0; $i <= 4; $i++)
							if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_mailchimp_list_ids"] || $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_aweber_list_ids"])
								return apply_filters ("ws_plugin__s2member_list_servers_integrated", true, get_defined_vars ());
						/**/
						return apply_filters ("ws_plugin__s2member_list_servers_integrated", false, get_defined_vars ());
					}
				/*
				Function that processes List Server integrations for s2Member.
				*/
				public static function process_list_servers ($role = FALSE, $level = FALSE, $email = FALSE, $fname = FALSE, $lname = FALSE, $ip = FALSE, $opt_in = FALSE, $user_id = FALSE)
					{
						global $current_site, $current_blog; /* For Multisite support. */
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_process_list_servers", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if (strlen ($level) && is_email ($email) && $opt_in) /* Must have these. */
							{
								$email_configs_were_on = c_ws_plugin__s2member_email_configs::email_config_status (0);
								c_ws_plugin__s2member_email_configs::email_config_release (); /* Release Filters. */
								/**/
								if (($mailchimp_api_key = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["mailchimp_api_key"]))
									if (($mailchimp_list_ids = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $level . "_mailchimp_list_ids"]))
										{
											if (!class_exists ("NC_MCAPI"))
												include_once dirname (dirname (__FILE__)) . "/mailchimp/nc-mcapi.inc.php";
											/**/
											$MCAPI = new NC_MCAPI ($mailchimp_api_key); /* MailChimp® API class. */
											/**/
											foreach (preg_split ("/[\r\n\t\s;,]+/", $mailchimp_list_ids) as $mailchimp_list_id)
												$MCAPI->listSubscribe ($mailchimp_list_id, $email, apply_filters ("ws_plugin__s2member_mailchimp_array", array ("FNAME" => $fname, "LNAME" => $lname, "OPTINIP" => $ip), get_defined_vars ()));
										}
								/**/
								if (($aweber_list_ids = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $level . "_aweber_list_ids"]))
									{
										foreach (preg_split ("/[\r\n\t\s;,]+/", $aweber_list_ids) as $aweber_list_id)
											wp_mail ($aweber_list_id . "@aweber.com", apply_filters ("ws_plugin__s2member_aweber_sbj", "s2Member Subscription Request", get_defined_vars ()), apply_filters ("ws_plugin__s2member_aweber_msg", "s2Member Subscription Request\ns2Member w/ PayPal Email ID\nEMail Address: " . $email . "\nBuyer: " . $fname . " " . $lname . "\nFull Name: " . $fname . " " . $lname . "\nFirst Name: " . $fname . "\nLast Name: " . $lname . "\nIP Address: " . $ip . "\nUser ID: " . $user_id . "\nRole: " . $role . "\nLevel: " . $level . "\n - end.", get_defined_vars ()), "From: \"" . preg_replace ("/\"/", "", $fname . " " . $lname) . "\" <" . $email . ">\r\nContent-Type: text/plain; charset=utf-8");
									}
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_process_list_servers", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								if ($email_configs_were_on) /* Back on? */
									c_ws_plugin__s2member_email_configs::email_config ();
							}
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_after_process_list_servers", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						return; /* Return for uniformity. */
					}
				/*
				Function that processes list server removals for s2Member.
				*/
				public static function process_list_server_removals ($role = FALSE, $level = FALSE, $email = FALSE, $fname = FALSE, $lname = FALSE, $ip = FALSE, $opt_out = FALSE, $user_id = FALSE)
					{
						global $current_site, $current_blog; /* For Multisite support. */
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_process_list_server_removals", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if (strlen ($level) && is_email ($email) && $opt_out) /* Must have these. */
							{
								$email_configs_were_on = c_ws_plugin__s2member_email_configs::email_config_status (0);
								c_ws_plugin__s2member_email_configs::email_config_release (); /* Release Filters. */
								/**/
								if (($mailchimp_api_key = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["mailchimp_api_key"]))
									if (($mailchimp_list_ids = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $level . "_mailchimp_list_ids"]))
										{
											if (!class_exists ("NC_MCAPI"))
												include_once dirname (dirname (__FILE__)) . "/mailchimp/nc-mcapi.inc.php";
											/**/
											$MCAPI = new NC_MCAPI ($mailchimp_api_key); /* MailChimp® API class. */
											/**/
											foreach (preg_split ("/[\r\n\t\s;,]+/", $mailchimp_list_ids) as $mailchimp_list_id)
												$MCAPI->listUnsubscribe ($mailchimp_list_id, $email, apply_filters ("ws_plugin__s2member_mailchimp_removal_delete_member", false, get_defined_vars ()), apply_filters ("ws_plugin__s2member_mailchimp_removal_send_goodbye", false, get_defined_vars ()), apply_filters ("ws_plugin__s2member_mailchimp_removal_send_notify", false, get_defined_vars ()));
										}
								/**/
								if (($aweber_list_ids = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $level . "_aweber_list_ids"]))
									{
										foreach (preg_split ("/[\r\n\t\s;,]+/", $aweber_list_ids) as $aweber_list_id)
											wp_mail ($aweber_list_id . "@aweber.com", apply_filters ("ws_plugin__s2member_aweber_removal_sbj", "REMOVE#" . $email . "#s2Member-" . ( (is_multisite () && !is_main_site ()) ? $current_blog->domain . $current_blog->path : $_SERVER["HTTP_HOST"]) . "#" . $aweber_list_id, get_defined_vars ()), "", "From: \"" . preg_replace ('/"/', "'", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_name"]) . "\" <" . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_email"] . ">\r\nContent-Type: text/plain; charset=utf-8");
									}
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_process_list_server_removals", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								if ($email_configs_were_on) /* Back on? */
									c_ws_plugin__s2member_email_configs::email_config ();
							}
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_after_process_list_server_removals", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						return; /* Return for uniformity. */
					}
				/*
				This function listens to Collective EOT/MOD Events processed internally by s2Member.
				This is only applicable when ["custom_reg_auto_opt_outs"] contains related Event(s).
				Attach to: add_action("ws_plugin__s2member_during_collective_eots");
				Attach to: add_action("ws_plugin__s2member_during_collective_mods");
				*/
				public static function auto_process_list_server_removals ($user_id = FALSE, $vars = FALSE, $event = FALSE, $new_level = FALSE)
					{
						global $current_site, $current_blog; /* For Multisite support. */
						static $auto_processed = array (); /* Only process ONE time for each User ID. */
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_auto_process_list_server_removals", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if ($user_id && !in_array ($user_id, $auto_processed) && in_array ($event, $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_auto_opt_outs"]) && c_ws_plugin__s2member_list_servers::list_servers_integrated () && is_object ($user = new WP_User ($user_id)) && $user->ID)
							{
								if ((!strlen ($new_level) || (int)$new_level !== c_ws_plugin__s2member_user_access::user_access_level ($user)) && ($auto_processed[$user_id] = true))
									{
										c_ws_plugin__s2member_list_servers::process_list_server_removals (c_ws_plugin__s2member_user_access::user_access_role ($user), c_ws_plugin__s2member_user_access::user_access_level ($user), $user->user_email, $user->first_name, $user->last_name, false, true, $user_id);
										/**/
										if (strlen ($new_level) && apply_filters ("ws_plugin__s2member_auto_process_new_list_servers", true, get_defined_vars ())) /* Subscribe to new List(s)? */
											c_ws_plugin__s2member_list_servers::process_list_servers ("s2member_level" . $new_level, $new_level, $user->user_email, $user->first_name, $user->last_name, false, true, $user_id);
									}
							}
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_after_auto_process_list_server_removals", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						return; /* Return for uniformity. */
					}
			}
	}
?>