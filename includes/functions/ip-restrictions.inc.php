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
function ws_plugin__s2member_ip_restrictions_ok ($ip = FALSE, $restriction = FALSE)
	{
		do_action ("s2member_before_ip_restrictions_ok");
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
				/**/
				if (count ($new_ips) > $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["max_ip_restriction"])
					{
						ws_plugin__s2member_nocache_constants () . wp_clear_auth_cookie (); /* Clear cookies. */
						/**/
						do_action ("s2member_during_ip_restrictions_not_ok");
						/**/
						header ("HTTP/1.0 503 Service Temporarily Unavailable");
						echo '<strong>503: Service Temporarily Unavailable</strong><br />' . "\n";
						echo 'Too many IP addresses accessing one account/link!<br />' . "\n";
						echo 'Please contact Support if you need assistance.';
						/**/
						exit; /* Exit now. */
					}
				else /* Otherwise, update the Transient array of IP addresses. They're good for now. */
					{
						do_action ("s2member_during_ip_restrictions_ok");
						/**/
						set_transient ($transient, $new_ips, $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["max_ip_restriction_time"]);
						/**/
						return apply_filters ("s2member_ip_restrictions_ok", true);
					}
			}
		/**/
		return apply_filters ("s2member_ip_restrictions_ok", true);
	}
?>