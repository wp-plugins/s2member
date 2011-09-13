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
	exit("Do not access this file directly.");
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
				* @since 110815
				*
				* @param str $dir_path Directory path.
				* @return str Basename directory path; including a possible `\app_data\` directory.
				*/
				public static function basename_dir_app_data ($dir_path = FALSE)
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
				/**
				* Finds the relative path, from one location to another.
				*
				* @package s2Member\Utilities
				* @since 110815
				*
				* @param str $from The directory to calculate a relative path from.
				* @param str $to The directory or file to build a relative path to.
				* @return str String with the relative path to ``$to``.
				*/
				public static function rel_path ($from = FALSE, $to = FALSE)
					{
						if (!($rel_path = array ()) && is_string ($from) && strlen ($from) && is_string ($to) && strlen ($to))
							{
								$to = str_replace (DIRECTORY_SEPARATOR, "/", $to);
								$to = (strpos (basename ($to), ".") === false) ? rtrim ($to, "/") . "/" : $to;
								$to = $rel_path = preg_split ("/\//", $to);
								/**/
								$from = str_replace (DIRECTORY_SEPARATOR, "/", $from);
								$from = (strpos (basename ($from), ".") !== false) ? dirname ($from) : $from;
								$from = preg_split ("/\//", rtrim ($from, "/") . "/");
								/**/
								foreach ($from as $depth => $dir) /* Each ``$from`` directory. */
									{
										if (isset ($to[$depth]) && $dir === $to[$depth])
											array_shift($rel_path);
										/**/
										else if (($remaining = count ($from) - $depth) > 1)
											{
												$rel_path = array_pad ($rel_path, ((count ($rel_path) + $remaining - 1) * -1), "..");
												break; /* Stop now, no need to go any further. */
											}
										else
											$rel_path[0] = "./" . $rel_path[0];
									}
							}
						/**/
						return implode ("/", $rel_path);
					}
				/**
				* Shortens to a path from document root.
				*
				* @package s2Member\Utilities
				* @since 110815
				*
				* @param str $path Directory or file path.
				* @return str Shorther path, from document root.
				*/
				public static function doc_root_path ($path = FALSE)
					{
						return preg_replace ("/^" . preg_quote (rtrim ($_SERVER["DOCUMENT_ROOT"], DIRECTORY_SEPARATOR . "/"), "/") . "/", "", (string)$path);
					}
			}
	}
?>