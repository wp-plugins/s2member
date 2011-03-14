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
if (!class_exists ("c_ws_plugin__s2member_cron_jobs"))
	{
		class c_ws_plugin__s2member_cron_jobs
			{
				/*
				Extends the WP-Cron schedules to support 10 minute intervals.
				Attach to: add_filter("cron_schedules");
				*/
				public static function extend_cron_schedules ($schedules = array ()) /* Call inner function? */
					{
						return c_ws_plugin__s2member_cron_jobs_in::extend_cron_schedules ($schedules);
					}
				/*
				This function allows the Auto-EOT Sytem to be processed through a server-side Cron Job.
				Attach to: add_action("init");
				*/
				public static function auto_eot_system_via_cron ()
					{
						if ($_GET["s2member_auto_eot_system_via_cron"]) /* Call inner function? */
							{
								return c_ws_plugin__s2member_cron_jobs_in::auto_eot_system_via_cron ();
							}
					}
			}
	}
?>