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
	exit("Do not access this file directly.");
/*
Function for handling IP Restrictions.
IP addresses are stored in a Transient field.
*/
if (!function_exists ("ws_plugin__s2member_ip_restrictions_ok"))
	{
		function ws_plugin__s2member_ip_restrictions_ok ($ip = FALSE, $restriction = FALSE)
			{
				eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_ip_restrictions_ok", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if ($restriction) /* There MUST be a restriction. However, the IP *could* be empty. */
					{
						$ip = ($ip) ? $ip : "empty"; /* Allow empty IPs; we need to track them too. */
						/**/
						$entries = (array)get_transient ($transient = md5 ("s2member_ip_restrictions_" . $restriction));
						/**/
						$conc_filter = "ws_plugin__s2member_ip_restrictions__concurrency_time_per_ip";
						$concurrency = apply_filters ($conc_filter, "30 days");
						/**/
						foreach ($entries as $_entry => $_time) /* Auto-expire entries. */
							if ($_time < strtotime ("-" . $concurrency))
								unset($entries[$_entry]);
						/**/
						$entries[$ip] = strtotime ("now"); /* Log this entry. */
						set_transient ($transient, $entries, 2 * (strtotime ("+" . $concurrency) - strtotime ("now")));
						/*
						Now check to see if this is a security breach; or if it has too many IP addresses.
						*/
						if (get_transient (md5 ("s2member_ip_restrictions_" . $restriction . "_breached")))
							{
								ws_plugin__s2member_nocache_constants(true) . wp_clear_auth_cookie ();
								/**/
								do_action ("ws_plugin__s2member_during_ip_restrictions_ok_no", get_defined_vars ());
								/**/
								header("HTTP/1.0 503 Service Temporarily Unavailable"); /* Sends a status header. */
								/**/
								echo '<strong>503: Service Temporarily Unavailable</strong><br />' . "\n";
								echo 'Too many IP addresses accessing one secure area<em>!</em><br />' . "\n";
								echo 'Please contact Support if you require assistance.';
								/**/
								exit ();
							}
						else if (count ($entries) > $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["max_ip_restriction"])
							{
								ws_plugin__s2member_nocache_constants(true) . wp_clear_auth_cookie ();
								/**/
								$p = $punish = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["max_ip_restriction_time"];
								set_transient (md5 ("s2member_ip_restrictions_" . $restriction . "_breached"), "1", $p);
								/**/
								do_action ("ws_plugin__s2member_during_ip_restrictions_ok_no", get_defined_vars ());
								/**/
								header("HTTP/1.0 503 Service Temporarily Unavailable"); /* Sends a status header. */
								/**/
								echo '<strong>503: Service Temporarily Unavailable</strong><br />' . "\n";
								echo 'Too many IP addresses accessing one secure area<em>!</em><br />' . "\n";
								echo 'Please contact Support if you require assistance.';
								/**/
								exit ();
							}
						else /* OK, this looks legitimate. Continue updating the Transient array of IP addresses. */
							{
								eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_ip_restrictions_ok_yes", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								return apply_filters ("ws_plugin__s2member_ip_restrictions_ok", true, get_defined_vars ());
							}
					}
				/**/
				return apply_filters ("ws_plugin__s2member_ip_restrictions_ok", true, get_defined_vars ());
			}
	}
?>