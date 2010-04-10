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
Function determines the maximum period in days for download access.
Returns number of days, where 0 means no access to files has been allowed.
*/
function ws_plugin__s2member_maximum_download_period ()
	{
		if ($days = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_file_downloads_allowed_days"])
			{
				$maximum = ($maximum < $days) ? $days : $maximum;
			}
		/**/
		if ($days = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_file_downloads_allowed_days"])
			{
				$maximum = ($maximum < $days) ? $days : $maximum;
			}
		/**/
		if ($days = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_file_downloads_allowed_days"])
			{
				$maximum = ($maximum < $days) ? $days : $maximum;
			}
		/**/
		if ($days = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_file_downloads_allowed_days"])
			{
				$maximum = ($maximum < $days) ? $days : $maximum;
			}
		/**/
		return ($maximum > 365) ? 365 : (int)$maximum;
	}
?>