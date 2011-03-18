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
if (!class_exists ("c_ws_plugin__s2member_tracking_codes"))
	{
		class c_ws_plugin__s2member_tracking_codes
			{
				/*
				Displays Signup Tracking Codes.
				These are stored inside s2Member's Transient Queue by the IPN processor.
				
				Attach to: add_action("login_footer");
				Attach to: add_action("wp_footer");
				
				Tracking Codes are only displayed/processed one time.
				s2Member will display Tracking Codes in (1) of these 3 locations:
				1. If possible, on the Registration Form, after returning from your Payment Gateway.
				2. Otherwise, if possible, on the Login Form ( in the footer ) after Registration is completed.
				3. Otherwise, in the footer of your WordPress® theme, as soon as possible; or after the Customer's very first login.
				*/
				public static function display_signup_tracking_codes ()
					{
						do_action ("ws_plugin__s2member_before_display_signup_tracking_codes", get_defined_vars ());
						/**/
						if (($subscr_id = c_ws_plugin__s2member_utils_encryption::decrypt ($_COOKIE["s2member_subscr_id"])) || ($subscr_id = c_ws_plugin__s2member_utils_encryption::decrypt ($_COOKIE["s2member_signup_tracking"])))
							{
								if (($code = get_transient ($transient = "s2m_" . md5 ("s2member_transient_signup_tracking_codes_" . $subscr_id))))
									{
										delete_transient ($transient); /* Only display this ONE time. Delete transient immediately. */
										/**/
										echo '<img src="' . esc_attr (site_url ("/?s2member_delete_signup_tracking_cookie=1")) . '" alt="." style="width:1px; height:1px; border:0;" />' . "\n";
										/**/
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_display_signup_tracking_codes", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
										/**/
										if (is_multisite () && c_ws_plugin__s2member_utils_conds::is_multisite_farm () && !is_main_site ())
											{
												echo $code . "\n"; /* No PHP here. */
											}
										else /* Otherwise, safe to allow PHP code. */
											{
												eval ("?>" . $code);
											}
									}
							}
						/**/
						do_action ("ws_plugin__s2member_after_display_signup_tracking_codes", get_defined_vars ());
					}
				/*
				Displays Specific Post/Page Tracking Codes.
				These are stored inside s2Member's Transient Queue,
				by BOTH the IPN & Return-Data processors.
				
				Attach to: add_action("wp_footer");
				
				Specific Post/Page Tracking Codes are only displayed/processed one time.
				s2Member will display Tracking Codes in the footer of your theme.
				*/
				public static function display_sp_tracking_codes ()
					{
						do_action ("ws_plugin__s2member_before_display_sp_tracking_codes", get_defined_vars ());
						/**/
						if (($txn_id = c_ws_plugin__s2member_utils_encryption::decrypt ($_COOKIE["s2member_sp_tracking"])))
							{
								if (($code = get_transient ($transient = "s2m_" . md5 ("s2member_transient_sp_tracking_codes_" . $txn_id))))
									{
										delete_transient ($transient); /* Only display this ONE time. Delete transient immediately. */
										/**/
										echo '<img src="' . esc_attr (site_url ("/?s2member_delete_sp_tracking_cookie=1")) . '" alt="." style="width:1px; height:1px; border:0;" />' . "\n";
										/**/
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_display_sp_tracking_codes", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
										/**/
										if (is_multisite () && c_ws_plugin__s2member_utils_conds::is_multisite_farm () && !is_main_site ())
											{
												echo $code . "\n"; /* No PHP here. */
											}
										else /* Otherwise, it's safe to allow PHP code. */
											{
												eval ("?>" . $code);
											}
									}
							}
						/**/
						do_action ("ws_plugin__s2member_after_display_sp_tracking_codes", get_defined_vars ());
					}
			}
	}
?>