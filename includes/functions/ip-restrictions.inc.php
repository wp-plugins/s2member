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
Function for handling IP Restrictions.
IP addresses are stored in a Transient field.
*/
if (!function_exists ("ws_plugin__s2member_ip_restrictions_ok"))
	{
		function ws_plugin__s2member_ip_restrictions_ok ($ip = FALSE, $restriction = FALSE)
			{
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_ip_restrictions_ok", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if ($restriction) /* There MUST be a restriction. However, the IP *can* be empty. */
					{
						if (is_array ($ips = get_transient ($transient = md5 ("s2member_ip_restrictions_" . $restriction))))
							{
								if (!in_array ($ip, $ips)) /* Already on record? */
									$ips[] = $ip;
								/**/
								$new_ips = $ips;
							}
						else /* Otherwise, create a new IPs array. */
							$new_ips[] = $ip;
						/*
						Now check to see if this is a security breach; with too many IP addresses.
						*/
						if (count ($new_ips) > $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["max_ip_restriction"])
							{
								ws_plugin__s2member_nocache_constants () . wp_clear_auth_cookie ();
								/**/
								do_action ("ws_plugin__s2member_during_ip_restrictions_ok_no", get_defined_vars ());
								/**/
								header ("HTTP/1.0 503 Service Temporarily Unavailable");
								/**/
								echo '<strong>503: Service Temporarily Unavailable</strong><br />' . "\n";
								echo 'Too many IP addresses accessing one account/link!<br />' . "\n";
								echo 'Please contact Support if you need assistance.';
								/**/
								exit; /* Exit now. */
							}
						else /* Looks legit. Continue updating the Transient array of IP addresses. */
							{
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_ip_restrictions_ok_yes", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								set_transient ($transient, $new_ips, $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["max_ip_restriction_time"]);
								/**/
								return apply_filters ("ws_plugin__s2member_ip_restrictions_ok", true, get_defined_vars ());
							}
					}
				/**/
				return apply_filters ("ws_plugin__s2member_ip_restrictions_ok", true, get_defined_vars ());
			}
	}
?>