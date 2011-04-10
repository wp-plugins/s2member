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
if (!class_exists ("c_ws_plugin__s2member_utils_users"))
	{
		class c_ws_plugin__s2member_utils_users
			{
				/*
				Determines the total Users/Members in the database.
				*/
				public static function users_in_database ()
					{
						global $wpdb; /* Global database object reference. */
						/**/
						$q1 = mysql_query ("SELECT SQL_CALC_FOUND_ROWS `" . $wpdb->users . "`.`ID` FROM `" . $wpdb->users . "`, `" . $wpdb->usermeta . "` WHERE `" . $wpdb->users . "`.`ID` = `" . $wpdb->usermeta . "`.`user_id` AND `" . $wpdb->usermeta . "`.`meta_key` = '" . esc_sql ($wpdb->prefix . "capabilities") . "' LIMIT 1", $wpdb->dbh);
						$q2 = mysql_query ("SELECT FOUND_ROWS()", $wpdb->dbh);
						/**/
						$users = (int)mysql_result ($q2, 0);
						/**/
						mysql_free_result($q2);
						mysql_free_result($q1);
						/**/
						return $users;
					}
				/*
				Retrieves a field value. Also supports Custom Fields.
				*/
				public static function get_user_field ($field_id = FALSE, $user_id = FALSE)
					{
						if (is_object ($user = ($user_id) ? new WP_User ($user_id) : wp_get_current_user ()) && ($user_id = $user->ID))
							{
								if (preg_match ("/^(first_name|First Name)$/i", $field_id))
									return $user->first_name;
								/**/
								else if (preg_match ("/^(last_name|Last Name)$/i", $field_id))
									return $user->last_name;
								/**/
								else if (preg_match ("/^(full_name|Full Name)$/i", $field_id))
									return trim ($user->first_name . " " . $user->last_name);
								/**/
								else if (preg_match ("/^(email|E-mail|Email Address|E-mail Address)$/i", $field_id))
									return $user->user_email;
								/**/
								else if (isset ($user->$field_id))
									return $user->$field_id;
								/**/
								else if (is_array ($fields = get_user_option ("s2member_custom_fields", $user_id)))
									return$fields[preg_replace ("/[^a-z0-9]/i", "_", strtolower ($field_id))];
							}
						/**/
						return false; /* Otherwise, return false. */
					}
				/*
				Gets the custom value for an existing Member, referenced by a Subscr. ID.
					A second lookup parameter can be provided as well ( optional ).
				*/
				public static function get_user_custom_with ($subscr_id = FALSE, $os0 = FALSE)
					{
						global $wpdb; /* Need global DB obj. */
						/**/
						if ($subscr_id && $os0) /* This case includes some additional routines that can use the $os0 value. */
							{
								if (($q = $wpdb->get_row ("SELECT `user_id` FROM `" . $wpdb->usermeta . "` WHERE `meta_key` = '" . $wpdb->prefix . "s2member_subscr_id' AND (`meta_value` = '" . $wpdb->escape ($subscr_id) . "' OR `meta_value` = '" . $wpdb->escape ($os0) . "') LIMIT 1"))/**/
								|| ($q = $wpdb->get_row ("SELECT `ID` AS `user_id` FROM `" . $wpdb->users . "` WHERE `ID` = '" . $wpdb->escape ($os0) . "' LIMIT 1")))
									if (($custom = get_user_option ("s2member_custom", $q->user_id)))
										return $custom;
							}
						else if ($subscr_id) /* Otherwise, if all we have is a Subscr. ID value. */
							{
								if ($q = $wpdb->get_row ("SELECT `user_id` FROM `" . $wpdb->usermeta . "` WHERE `meta_key` = '" . $wpdb->prefix . "s2member_subscr_id' AND `meta_value` = '" . $wpdb->escape ($subscr_id) . "' LIMIT 1"))
									if (($custom = get_user_option ("s2member_custom", $q->user_id)))
										return $custom;
							}
						/**/
						return false; /* Otherwise, return false. */
					}
				/*
				Gets the user ID for an existing Member, referenced by a Subscr. ID.
					A second lookup parameter can be provided as well ( optional ).
				*/
				public static function get_user_id_with ($subscr_id = FALSE, $os0 = FALSE)
					{
						global $wpdb; /* Need global DB obj. */
						/**/
						if ($subscr_id && $os0) /* This case includes some additional routines that can use the $os0 value. */
							{
								if (($q = $wpdb->get_row ("SELECT `user_id` FROM `" . $wpdb->usermeta . "` WHERE `meta_key` = '" . $wpdb->prefix . "s2member_subscr_id' AND (`meta_value` = '" . $wpdb->escape ($subscr_id) . "' OR `meta_value` = '" . $wpdb->escape ($os0) . "') LIMIT 1"))/**/
								|| ($q = $wpdb->get_row ("SELECT `ID` AS `user_id` FROM `" . $wpdb->users . "` WHERE `ID` = '" . $wpdb->escape ($os0) . "' LIMIT 1")))
									return $q->user_id;
							}
						else if ($subscr_id) /* Otherwise, if all we have is a Subscr. ID value. */
							{
								if ($q = $wpdb->get_row ("SELECT `user_id` FROM `" . $wpdb->usermeta . "` WHERE `meta_key` = '" . $wpdb->prefix . "s2member_subscr_id' AND `meta_value` = '" . $wpdb->escape ($subscr_id) . "' LIMIT 1"))
									return $q->user_id;
							}
						/**/
						return false; /* Otherwise, return false. */
					}
				/*
				Gets the email value for an existing Member, referenced by a Subscr. ID.
					A second lookup parameter can be provided as well ( optional ).
				*/
				public static function get_user_email_with ($subscr_id = FALSE, $os0 = FALSE)
					{
						global $wpdb; /* Need global DB obj. */
						/**/
						if ($subscr_id && $os0) /* This case includes some additional routines that can use the $os0 value. */
							{
								if (($q = $wpdb->get_row ("SELECT `user_id` FROM `" . $wpdb->usermeta . "` WHERE `meta_key` = '" . $wpdb->prefix . "s2member_subscr_id' AND (`meta_value` = '" . $wpdb->escape ($subscr_id) . "' OR `meta_value` = '" . $wpdb->escape ($os0) . "') LIMIT 1"))/**/
								|| ($q = $wpdb->get_row ("SELECT `ID` AS `user_id` FROM `" . $wpdb->users . "` WHERE `ID` = '" . $wpdb->escape ($os0) . "' LIMIT 1")))
									if (is_object ($user = new WP_User ($q->user_id)) && $user->ID && ($email = $user->user_email))
										return $email;
							}
						else if ($subscr_id) /* Otherwise, if all we have is a Subscr. ID value. */
							{
								if ($q = $wpdb->get_row ("SELECT `user_id` FROM `" . $wpdb->usermeta . "` WHERE `meta_key` = '" . $wpdb->prefix . "s2member_subscr_id' AND `meta_value` = '" . $wpdb->escape ($subscr_id) . "' LIMIT 1"))
									if (is_object ($user = new WP_User ($q->user_id)) && $user->ID && ($email = $user->user_email))
										return $email;
							}
						/**/
						return false; /* Otherwise, return false. */
					}
				/*
				Retrieves IPN signup vars & validates their Subscription ID.
					- The $user_id can be passed in directly;
					or a lookup can be performed with $subscr_id.
				*/
				public static function get_user_ipn_signup_vars ($user_id = FALSE, $subscr_id = FALSE)
					{
						if ($user_id || ($subscr_id && ($user_id = c_ws_plugin__s2member_utils_users::get_user_id_with ($subscr_id))) || (!$user_id && !$subscr_id && is_object ($user = wp_get_current_user ()) && ($user_id = $user->ID)))
							{
								if (($_subscr_id = get_user_option ("s2member_subscr_id", $user_id)) && (!$subscr_id || $subscr_id === $_subscr_id) && ($subscr_id = $_subscr_id))
									if (is_array ($ipn_signup_vars = get_user_option ("s2member_ipn_signup_vars", $user_id)))
										if ($ipn_signup_vars["subscr_id"] === $subscr_id)
											return $ipn_signup_vars;
							}
						/**/
						return false; /* Otherwise, return false. */
					}
				/*
				Gets a User's Paid Subscr. ID ( if available ); otherwise their WP database ID.
					If $user IS passed in, this function will return data from a specific $user.
					If $user is NOT passed in, check the current User/Member.
				*/
				public static function get_user_subscr_or_wp_id ($user = FALSE)
					{
						if ((func_num_args () && (!is_object ($user) || !$user->ID)) || (!func_num_args () && !$user && (!is_object ($user = (is_user_logged_in ()) ? wp_get_current_user () : false) || !$user->ID)))
							{
								return false; /* The $user was passed in but is NOT an object; or nobody is logged in. */
							}
						else /* Else return Paid Subscr. ID ( if available ), otherwise return their WP database User ID. */
							return ($subscr_id = get_user_option ("s2member_subscr_id", $user->ID)) ? $subscr_id : $user->ID;
					}
				/*
				Determines whether or not a Username/Email is already in the database.
					Returns the WordPress® User ID if they exist.
				*/
				public static function user_login_email_exists ($user_login = FALSE, $user_email = FALSE)
					{
						global $wpdb; /* Global database object reference. */
						/**/
						if ($user_login && $user_email) /* Only if we have both of these. */
							if (($user_id = $wpdb->get_var ("SELECT `ID` FROM `" . $wpdb->users . "` WHERE `user_login` LIKE '" . esc_sql (like_escape ($user_login)) . "' AND `user_email` LIKE '" . esc_sql (like_escape ($user_email)) . "' LIMIT 1")))
								return $user_id; /* Return the associated WordPress® ID. */
						/**/
						return false; /* Else return false. */
					}
				/*
				Determines whether or not a Username/Email is already in the database for this Blog.
					Returns the WordPress® User ID if they exist.
				*/
				public static function ms_user_login_email_exists_but_not_on_blog ($user_login = FALSE, $user_email = FALSE, $blog_id = FALSE)
					{
						if ($user_login && $user_email) /* Only if we have both of these. */
							if (is_multisite () && ($user_id = c_ws_plugin__s2member_utils_users::user_login_email_exists ($user_login, $user_email)) && !is_user_member_of_blog ($user_id, $blog_id))
								return $user_id;
						/**/
						return false; /* Else return false. */
					}
				/*
				Determines whether or not a Username/Email is already in the database for this Blog.
					Returns the WordPress® User ID if they exist.
				This is an alias for: `c_ws_plugin__s2member_utils_users::ms_user_login_email_exists_but_not_on_blog()`.
				*/
				public static function ms_user_login_email_can_join_blog ($user_login = FALSE, $user_email = FALSE, $blog_id = FALSE)
					{
						return c_ws_plugin__s2member_utils_users::ms_user_login_email_exists_but_not_on_blog ($user_login, $user_email, $blog_id);
					}
			}
	}
?>