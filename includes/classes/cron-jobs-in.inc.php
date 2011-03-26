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
if (!class_exists ("c_ws_plugin__s2member_cron_jobs_in"))
	{
		class c_ws_plugin__s2member_cron_jobs_in
			{
				/*
				Extends the WP-Cron schedules to support 10 minute intervals.
				Attach to: add_filter("cron_schedules");
				*/
				public static function extend_cron_schedules ($schedules = array ())
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_extend_cron_schedules", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						$array = array ("every10m" => array ("interval" => 600, "display" => "Every 10 Minutes"));
						/**/
						return apply_filters ("ws_plugin__s2member_extend_cron_schedules", array_merge ($array, $schedules), get_defined_vars ());
					}
				/*
				This function allows the Auto-EOT Sytem to be processed through a server-side Cron Job.
				Attach to: add_action("init");
				*/
				public static function auto_eot_system_via_cron ()
					{
						do_action ("ws_plugin__s2member_before_auto_eot_system_via_cron", get_defined_vars ());
						/**/
						if ($_GET["s2member_auto_eot_system_via_cron"]) /* Being called through HTTP? */
							{
								if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["auto_eot_system_enabled"])
									{
										c_ws_plugin__s2member_auto_eots::auto_eot_system (); /* Process Auto EOTs now. */
										/**/
										do_action ("ws_plugin__s2member_during_auto_eot_system_via_cron", get_defined_vars ());
									}
								/**/
								exit (); /* Clean exit. */
							}
						/**/
						do_action ("ws_plugin__s2member_after_auto_eot_system_via_cron", get_defined_vars ());
					}
			}
	}
?>