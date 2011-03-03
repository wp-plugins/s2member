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
if (!class_exists ("c_ws_plugin__s2member_labels"))
	{
		class c_ws_plugin__s2member_labels
			{
				/*
				Function configures Label translations.
				Attach to: add_action("init");
				*/
				public static function config_label_translations ()
					{
						do_action ("ws_plugin__s2member_before_config_label_translations", get_defined_vars ());
						/**/
						if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["apply_label_translations"])
							add_filter ("gettext_with_context", "c_ws_plugin__s2member_labels::_label_translations", 10, 3);
						/**/
						do_action ("ws_plugin__s2member_after_config_label_translations", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
				/*
				A sort of callback function that deals with Label translations.
				Attach to: add_filter("gettext_with_context");
				*/
				public static function _label_translations ($translation = FALSE, $text = FALSE, $context = FALSE)
					{
						if ($text && $context && stripos ($context, "User role") === 0 && ($role = $text))
							{
								if (preg_match ("/^(Free )?Subscriber$/i", $role) && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_label"])
									$translation = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_label"];
								/**/
								else if (preg_match ("/^s2Member Level ([0-9]+)$/i", $role, $m) && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $m[1] . "_label"])
									$translation = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $m[1] . "_label"];
								/**/
								$translation = apply_filters ("_ws_plugin__s2member_label_translations", $translation, get_defined_vars ());
							}
						/**/
						return $translation; /* Return translation. */
					}
			}
	}
?>