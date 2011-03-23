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
if (!class_exists ("c_ws_plugin__s2member_check_activation"))
	{
		class c_ws_plugin__s2member_check_activation
			{
				/*
				Checks existing installs that are NOT yet re-activated.
				Attach to: add_action("admin_init");
				*/
				public static function check () /* Up-to-date? */
					{
						$v = get_option ("ws_plugin__s2member_activated_version");
						/**/
						if (!$v || !version_compare ($v, WS_PLUGIN__S2MEMBER_VERSION, ">="))
							{
								c_ws_plugin__s2member_installation::activate ();
							}
						/**/
						else if (is_multisite () && is_main_site ())
							{
								$mms_v = get_option ("ws_plugin__s2member_activated_mms_version");
								/**/
								if (!$mms_v || !version_compare ($mms_v, WS_PLUGIN__S2MEMBER_VERSION, ">="))
									{
										c_ws_plugin__s2member_installation::activate ();
									}
							}
						/**/
						return; /* Return for uniformity. */
					}
			}
	}
?>