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
/*
The __autoload function for s2Member classes.
This highly optimizes s2Member. Giving it a much smaller footprint.
See: http://www.php.net/manual/en/function.spl-autoload-register.php
*/
if (!function_exists ("ws_plugin__s2member_classes")) /* Already exists? */
	{
		function ws_plugin__s2member_classes ($class = FALSE) /* Build dynamic __autoload function. */
			{
				static $c; /* Holds the classes directory location ( location is optimized with a static var ). */
				static $class_dirs; /* All possible class directory locations ( optimized with a static var ). */
				/**/
				$c = (!isset ($c)) ? dirname (dirname (__FILE__)) . "/classes" : $c; /* Configures location of classes. */
				/**/
				$class_dirs = (!isset ($class_dirs)) ? array_merge (array ($c), _ws_plugin__s2member_classes_scan_dirs_r ($c)) : $class_dirs;
				/**/
				if (strpos ($class, "c_ws_plugin__s2member_") === 0 && strpos ($class, "c_ws_plugin__s2member_pro_") === false)
					{
						$class = str_replace ("_", "-", str_replace ("c_ws_plugin__s2member_", "", $class));
						/**/
						foreach ($class_dirs as $class_dir) /* Start looking for the class. */
							{
								if ($class_dir === $c || strpos ($class, basename ($class_dir)) === 0)
									if (file_exists ($class_dir . "/" . $class . ".inc.php"))
										{
											include_once $class_dir . "/" . $class . ".inc.php";
											/**/
											break; /* Now stop looking. */
										}
							}
					}
			}
		function _ws_plugin__s2member_classes_scan_dirs_r ($starting_dir = FALSE)
			{
				$dirs = array (); /* Initialize dirs array. */
				/**/
				foreach (scandir ($starting_dir) as $dir) /* Scan this directory. */
					if ($dir !== "." && $dir !== ".." && is_dir ($dir = $starting_dir . "/" . $dir))
						$dirs = array_merge ($dirs, array ($dir), _ws_plugin__s2member_classes_scan_dirs_r ($dir));
				/**/
				return $dirs; /* Return array of all directories. */
			}
		/**/
		spl_autoload_register ("ws_plugin__s2member_classes"); /* Register __autoload. */
	}
?>