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
Function determines the minimum level required for file download access.
Returns 0-4, where 0 means no access to file downloads has been allowed.
*/
function ws_plugin__s2member_min_level_4_downloads ()
	{
		if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_file_downloads_allowed"] && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_file_downloads_allowed_days"])
			{
				$file_download_access_is_allowed = $minimum_level_required_to_download_files = 1;
			}
		else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_file_downloads_allowed"] && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_file_downloads_allowed_days"])
			{
				$file_download_access_is_allowed = $minimum_level_required_to_download_files = 2;
			}
		else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_file_downloads_allowed"] && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_file_downloads_allowed_days"])
			{
				$file_download_access_is_allowed = $minimum_level_required_to_download_files = 3;
			}
		else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_file_downloads_allowed"] && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_file_downloads_allowed_days"])
			{
				$file_download_access_is_allowed = $minimum_level_required_to_download_files = 4;
			}
		/**/
		return (int)$minimum_level_required_to_download_files;
	}
?>