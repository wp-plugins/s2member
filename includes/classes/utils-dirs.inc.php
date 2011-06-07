<?php
/**
* Directory utilities.
*
* Copyright: © 2009-2011
* {@link http://www.websharks-inc.com/ WebSharks, Inc.}
* ( coded in the USA )
*
* Released under the terms of the GNU General Public License.
* You should have received a copy of the GNU General Public License,
* along with this software. In the main directory, see: /licensing/
* If not, see: {@link http://www.gnu.org/licenses/}.
*
* @package s2Member\Utilities
* @since 3.5
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit ("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_utils_dirs"))
	{
		/**
		* Directory utilities.
		*
		* @package s2Member\Utilities
		* @since 3.5
		*/
		class c_ws_plugin__s2member_utils_dirs
			{
				/**
				* Formulates basename dirs from a full directory path.
				*
				* This takes Windows® `\app_data\` sub-folders into consideration.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @param str $dir_path Directory path.
				* @return str Basename directory path; including a possible `\app_data\` directory.
				*/
				public static function basename_dirs ($dir_path = FALSE)
					{
						$dir_path = rtrim ($dir_path, DIRECTORY_SEPARATOR . "/");
						/**/
						$dir_path = preg_replace ("/(" . preg_quote (DIRECTORY_SEPARATOR, "/") . "|\/)app_data$/i", "", $dir_path, 1, $app_data);
						/**/
						return basename ($dir_path) . (($app_data) ? "/app_data" : "");
					}
				/**
				* Strips a trailing `\app_data\` sub-directory from the full path.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @param str $dir_path Directory path.
				* @return str Directory path without `\app_data\`.
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