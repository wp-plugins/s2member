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
if (!class_exists ("c_ws_plugin__s2member_utils_dirs"))
	{
		class c_ws_plugin__s2member_utils_dirs
			{
				/*
				Formulates basename dirs from a full directory path.
				- This takes Windows® \app_data sub-folders into consideration.
				*/
				public static function basename_dirs ($dir_path = FALSE)
					{
						$dir_path = rtrim ($dir_path, DIRECTORY_SEPARATOR . "/");
						/**/
						$dir_path = preg_replace ("/(" . preg_quote (DIRECTORY_SEPARATOR, "/") . "|\/)app_data$/i", "", $dir_path, 1, $app_data);
						/**/
						return basename ($dir_path) . (($app_data) ? "/app_data" : "");
					}
				/*
				Strips a trailing \app_data sub-directory from the full path.
				*/
				public static function strip_dir_app_data ($dir_path = FALSE)
					{
						$dir_path = rtrim ($dir_path, DIRECTORY_SEPARATOR . "/");
						/**/
						return preg_replace ("/(" . preg_quote (DIRECTORY_SEPARATOR, "/") . "|\/)app_data$/i", "", $dir_path, 1);
					}
			}
	}
?>