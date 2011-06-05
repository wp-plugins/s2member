<?php
/**
* Tracking Codes.
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
* @package s2Member\Tracking
* @since 3.5
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_tracking_codes"))
	{
		/**
		* Tracking Codes.
		*
		* @package s2Member\Tracking
		* @since 3.5
		*/
		class c_ws_plugin__s2member_tracking_codes
			{
				/**
				* Displays Signup Tracking Codes.
				*
				* These are stored inside s2Member's Transient Queue by the IPN processor.
				*
				* Tracking Codes are only displayed/processed one time.
				* s2Member will display Tracking Codes in (1) of these 3 locations:
				*
				* o If possible, on the Registration Form, after returning from your Payment Gateway.
				* o Otherwise, if possible, on the Login Form *( in the footer )* after Registration is completed.
				* o Otherwise, in the footer of your WordPress® theme, as soon as possible; or after the Customer's very first login.
				*
				* @package s2Member\Tracking
				* @since 3.5
				*
				* @attaches-to: ``add_action("login_footer");``
				* @attaches-to: ``add_action("wp_footer");``
				*
				* @return null After displaying possible Tracking Code(s).
				*/
				public static function display_signup_tracking_codes ()
					{
						do_action ("ws_plugin__s2member_before_display_signup_tracking_codes", get_defined_vars ());
						/**/
						if ((!empty ($_COOKIE["s2member_subscr_id"]) && ($subscr_id = c_ws_plugin__s2member_utils_encryption::decrypt ($_COOKIE["s2member_subscr_id"]))) || (!empty ($_COOKIE["s2member_signup_tracking"]) && ($subscr_id = c_ws_plugin__s2member_utils_encryption::decrypt ($_COOKIE["s2member_signup_tracking"]))))
							{
								if (($code = get_transient ($transient = "s2m_" . md5 ("s2member_transient_signup_tracking_codes_" . $subscr_id))))
									{
										delete_transient($transient); /* Only display this ONE time. Delete transient immediately. */
										/**/
										echo '<img src="' . esc_attr (site_url ("/?s2member_delete_signup_tracking_cookie=1")) . '" alt="." style="width:1px; height:1px; border:0;" />' . "\n";
										/**/
										eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_display_signup_tracking_codes", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
										/**/
										if (is_multisite () && c_ws_plugin__s2member_utils_conds::is_multisite_farm () && !is_main_site ())
											{
												echo do_shortcode ($code) . "\n"; /* No PHP here. */
											}
										else /* Otherwise, safe to allow PHP code. */
											{
												echo do_shortcode (c_ws_plugin__s2member_utilities::evl ($code));
											}
									}
							}
						/**/
						do_action ("ws_plugin__s2member_after_display_signup_tracking_codes", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
				/**
				* Displays Specific Post/Page Tracking Codes.
				*
				* These are stored inside s2Member's Transient Queue, by BOTH the IPN & Return-Data processors.
				*
				* Specific Post/Page Tracking Codes are only displayed/processed one time.
				* s2Member will display Tracking Codes in the footer of your theme.
				*
				* @package s2Member\Tracking
				* @since 3.5
				*
				* @attaches-to: ``add_action("wp_footer");``
				*
				* @return null After displaying possible Tracking Code(s).
				*/
				public static function display_sp_tracking_codes ()
					{
						do_action ("ws_plugin__s2member_before_display_sp_tracking_codes", get_defined_vars ());
						/**/
						if (!empty ($_COOKIE["s2member_sp_tracking"]) && ($txn_id = c_ws_plugin__s2member_utils_encryption::decrypt ($_COOKIE["s2member_sp_tracking"])))
							{
								if (($code = get_transient ($transient = "s2m_" . md5 ("s2member_transient_sp_tracking_codes_" . $txn_id))))
									{
										delete_transient($transient); /* Only display this ONE time. Delete transient immediately. */
										/**/
										echo '<img src="' . esc_attr (site_url ("/?s2member_delete_sp_tracking_cookie=1")) . '" alt="." style="width:1px; height:1px; border:0;" />' . "\n";
										/**/
										eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_display_sp_tracking_codes", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
										/**/
										if (is_multisite () && c_ws_plugin__s2member_utils_conds::is_multisite_farm () && !is_main_site ())
											{
												echo $code . "\n"; /* No PHP here. */
											}
										else /* Otherwise, it's safe to allow PHP code. */
											{
												eval("?>" . $code);
											}
									}
							}
						/**/
						do_action ("ws_plugin__s2member_after_display_sp_tracking_codes", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
			}
	}
?>