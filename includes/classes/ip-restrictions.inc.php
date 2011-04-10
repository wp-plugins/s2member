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
if (!class_exists ("c_ws_plugin__s2member_ip_restrictions"))
	{
		class c_ws_plugin__s2member_ip_restrictions
			{
				/*
				Function for handling IP Restrictions.
				IP address details are stored in Transient fields.
				*/
				public static function ip_restrictions_ok ($ip = FALSE, $restriction = FALSE)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_ip_restrictions_ok", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["max_ip_restriction"] && $restriction)
							{
								$prefix = "s2m_ipr_"; /* s2Member Transient prefix for all IP Restrictions. */
								$transient_entries = $prefix . md5 ("s2member_ip_restrictions_" . $restriction . "_entries");
								$transient_security_breach = $prefix . md5 ("s2member_ip_restrictions_" . $restriction . "_security_breach");
								/**/
								/* If you add Filters, use a string compatible with PHP's strtotime() function. */
								$conc_filter = "ws_plugin__s2member_ip_restrictions__concurrency_time_per_ip";
								$concurrency = apply_filters ($conc_filter, "30 days");
								/**/
								$entries = (is_array ($entries = get_transient ($transient_entries))) ? $entries : array ();
								/**/
								foreach ($entries as $_entry => $_time) /* Auto-expire entries. */
									if ($_time < strtotime ("-" . $concurrency))
										unset ($entries[$_entry]);
								/**/
								$ip = ($ip) ? $ip : "empty"; /* Allow empty IPs. */
								$entries[$ip] = strtotime ("now"); /* Log this entry. */
								set_transient ($transient_entries, $entries, 2 * (strtotime ("+" . $concurrency) - strtotime ("now")));
								/**/
								if (get_transient ($transient_security_breach)) /* Has this restriction already been breached? */
									{
										c_ws_plugin__s2member_nocache::nocache_constants (true) . wp_clear_auth_cookie ();
										/**/
										do_action ("ws_plugin__s2member_during_ip_restrictions_ok_no", get_defined_vars ());
										/**/
										header ("HTTP/1.0 503 Service Temporarily Unavailable"); /* Sends a status header. */
										/**/
										echo '<strong>503: Service Temporarily Unavailable</strong><br />' . "\n";
										echo 'Too many IP addresses accessing one secure area<em>!</em><br />' . "\n";
										echo 'Please contact Support if you require assistance.';
										/**/
										exit ();
									}
								else if (count ($entries) > $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["max_ip_restriction"])
									{
										c_ws_plugin__s2member_nocache::nocache_constants (true) . wp_clear_auth_cookie ();
										/**/
										set_transient ($transient_security_breach, 1, /* Lock down. */
										$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["max_ip_restriction_time"]);
										/**/
										do_action ("ws_plugin__s2member_during_ip_restrictions_ok_no", get_defined_vars ());
										/**/
										header ("HTTP/1.0 503 Service Temporarily Unavailable"); /* Sends a status header. */
										/**/
										echo '<strong>503: Service Temporarily Unavailable</strong><br />' . "\n";
										echo 'Too many IP addresses accessing one secure area<em>!</em><br />' . "\n";
										echo 'Please contact Support if you require assistance.';
										/**/
										exit ();
									}
								else /* OK, this looks legitimate. Apply Filters here and return true. */
									{
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_ip_restrictions_ok_yes", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
										/**/
										return apply_filters ("ws_plugin__s2member_ip_restrictions_ok", true, get_defined_vars ());
									}
							}
						/**/
						return apply_filters ("ws_plugin__s2member_ip_restrictions_ok", true, get_defined_vars ());
					}
				/*
				This queries Transients for specific IP Restrictions that have resulted in a security breach.
				*/
				public static function specific_ip_restriction_breached_security ($restriction = FALSE)
					{
						do_action ("ws_plugin__s2member_before_specific_ip_restriction_breached_security", get_defined_vars ());
						/**/
						$prefix = "s2m_ipr_"; /* s2Member Transient prefix for all IP Restrictions. */
						$transient_security_breach = $prefix . md5 ("s2member_ip_restrictions_" . $restriction . "_security_breach");
						/**/
						return apply_filters ("ws_plugin__s2member_before_specific_ip_restriction_breached_security", get_transient ($transient_security_breach), get_defined_vars ());
					}
				/*
				Function resets/deletes specific IP Restrictions.
				*/
				public static function delete_reset_specific_ip_restrictions ($restriction = FALSE)
					{
						global $wpdb; /* Need global database object. */
						/**/
						do_action ("ws_plugin__s2member_before_delete_reset_specific_ip_restrictions", get_defined_vars ());
						/**/
						$prefix = "s2m_ipr_"; /* s2Member Transient prefix for all IP Restrictions. */
						$transient_entries = $prefix . md5 ("s2member_ip_restrictions_" . $restriction . "_entries");
						$transient_security_breach = $prefix . md5 ("s2member_ip_restrictions_" . $restriction . "_security_breach");
						/**/
						$wpdb->query ("DELETE FROM `" . $wpdb->options . "` WHERE `option_name` LIKE '%" . esc_sql (like_escape ($transient_entries)) . "'");
						$wpdb->query ("DELETE FROM `" . $wpdb->options . "` WHERE `option_name` LIKE '%" . esc_sql (like_escape ($transient_security_breach)) . "'");
						/**/
						do_action ("ws_plugin__s2member_after_delete_reset_specific_ip_restrictions", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
				/*
				Function resets/deletes specific IP Restrictions.
				Attach to: add_action("wp_ajax_ws_plugin__s2member_delete_reset_specific_ip_restrictions_via_ajax");
				*/
				public static function delete_reset_specific_ip_restrictions_via_ajax ()
					{
						do_action ("ws_plugin__s2member_before_delete_reset_specific_ip_restrictions_via_ajax", get_defined_vars ());
						/**/
						if (current_user_can ("create_users")) /* Check priveledges as well. */
							if (($nonce = $_POST["ws_plugin__s2member_delete_reset_specific_ip_restrictions_via_ajax"]) && wp_verify_nonce ($nonce, "ws-plugin--s2member-delete-reset-specific-ip-restrictions-via-ajax"))
								if (($restriction = trim (stripslashes ($_POST["ws_plugin__s2member_delete_reset_specific_ip_restriction"])))) /* Do we have the restriction specification? */
									if (c_ws_plugin__s2member_ip_restrictions::delete_reset_specific_ip_restrictions ($restriction) !== "nill") /* Delete/reset IP Restrictions. */
										echo apply_filters ("ws_plugin__s2member_delete_reset_specific_ip_restrictions_via_ajax", 1, get_defined_vars ());
						/**/
						exit (); /* Clean exit. */
					}
				/*
				Function resets/deletes all IP Restrictions.
				*/
				public static function delete_reset_all_ip_restrictions ()
					{
						global $wpdb; /* Need global database object. */
						/**/
						do_action ("ws_plugin__s2member_before_delete_reset_all_ip_restrictions", get_defined_vars ());
						/**/
						$wpdb->query ("DELETE FROM `" . $wpdb->options . "` WHERE `option_name` LIKE '" . esc_sql (like_escape ("_transient_s2m_ipr_")) . "%'");
						$wpdb->query ("DELETE FROM `" . $wpdb->options . "` WHERE `option_name` LIKE '" . esc_sql (like_escape ("_transient_timeout_s2m_ipr_")) . "%'");
						/**/
						do_action ("ws_plugin__s2member_after_delete_reset_all_ip_restrictions", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
				/*
				Function resets/deletes all IP Restrictions.
				Attach to: add_action("wp_ajax_ws_plugin__s2member_delete_reset_all_ip_restrictions_via_ajax");
				*/
				public static function delete_reset_all_ip_restrictions_via_ajax ()
					{
						do_action ("ws_plugin__s2member_before_delete_reset_all_ip_restrictions_via_ajax", get_defined_vars ());
						/**/
						if (current_user_can ("create_users")) /* Check priveledges as well. */
							if (($nonce = $_POST["ws_plugin__s2member_delete_reset_all_ip_restrictions_via_ajax"]) && wp_verify_nonce ($nonce, "ws-plugin--s2member-delete-reset-all-ip-restrictions-via-ajax"))
								if (c_ws_plugin__s2member_ip_restrictions::delete_reset_all_ip_restrictions () !== "nill") /* Delete/reset IP Restrictions. */
									echo apply_filters ("ws_plugin__s2member_delete_reset_all_ip_restrictions_via_ajax", 1, get_defined_vars ());
						/**/
						exit (); /* Clean exit. */
					}
			}
	}
?>