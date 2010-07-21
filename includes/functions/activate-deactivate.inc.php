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
	exit("Do not access this file directly.");
/*
Check existing installations that have not been re-activated.
Attach to: add_action("admin_init");
*/
if (!function_exists ("ws_plugin__s2member_check_activation"))
	{
		function ws_plugin__s2member_check_activation () /* Re-activated? */
			{
				$v = get_option ("ws_plugin__s2member_activated_version");
				if (!$v || !version_compare ($v, WS_PLUGIN__S2MEMBER_VERSION, ">="))
					ws_plugin__s2member_activate ();
				/**/
				return;
			}
	}
/*
Function for handling activation routines.
This function should match the array key for this plugin:
ws_plugin__$plugin_key_activate() is called by our themes.

We also initialize some option values here.
Initializing these options will force them to be
autoloaded into WordPress® instead of generating
extra queries before they are set.
*/
if (!function_exists ("ws_plugin__s2member_activate"))
	{
		function ws_plugin__s2member_activate ()
			{
				do_action ("ws_plugin__s2member_before_activation", get_defined_vars ());
				/**/
				$role = &get_role ("subscriber");
				$role->add_cap ("access_s2member_level0");
				/**/
				add_role ("s2member_level1", "s2Member Level 1");
				add_role ("s2member_level2", "s2Member Level 2");
				add_role ("s2member_level3", "s2Member Level 3");
				add_role ("s2member_level4", "s2Member Level 4");
				/**/
				$role = &get_role ("s2member_level1");
				$role->add_cap ("read");
				$role->add_cap ("level_0");
				$role->add_cap ("access_s2member_level0");
				$role->add_cap ("access_s2member_level1");
				/**/
				$role = &get_role ("s2member_level2");
				$role->add_cap ("read");
				$role->add_cap ("level_0");
				$role->add_cap ("access_s2member_level0");
				$role->add_cap ("access_s2member_level1");
				$role->add_cap ("access_s2member_level2");
				/**/
				$role = &get_role ("s2member_level3");
				$role->add_cap ("read");
				$role->add_cap ("level_0");
				$role->add_cap ("access_s2member_level0");
				$role->add_cap ("access_s2member_level1");
				$role->add_cap ("access_s2member_level2");
				$role->add_cap ("access_s2member_level3");
				/**/
				$role = &get_role ("s2member_level4");
				$role->add_cap ("read");
				$role->add_cap ("level_0");
				$role->add_cap ("access_s2member_level0");
				$role->add_cap ("access_s2member_level1");
				$role->add_cap ("access_s2member_level2");
				$role->add_cap ("access_s2member_level3");
				$role->add_cap ("access_s2member_level4");
				/**/
				$role = &get_role ("administrator");
				$role->add_cap ("access_s2member_level0");
				$role->add_cap ("access_s2member_level1");
				$role->add_cap ("access_s2member_level2");
				$role->add_cap ("access_s2member_level3");
				$role->add_cap ("access_s2member_level4");
				/**/
				$role = &get_role ("editor");
				$role->add_cap ("access_s2member_level0");
				$role->add_cap ("access_s2member_level1");
				$role->add_cap ("access_s2member_level2");
				$role->add_cap ("access_s2member_level3");
				$role->add_cap ("access_s2member_level4");
				/**/
				$role = &get_role ("author");
				$role->add_cap ("access_s2member_level0");
				$role->add_cap ("access_s2member_level1");
				$role->add_cap ("access_s2member_level2");
				$role->add_cap ("access_s2member_level3");
				$role->add_cap ("access_s2member_level4");
				/**/
				$role = &get_role ("contributor");
				$role->add_cap ("access_s2member_level0");
				$role->add_cap ("access_s2member_level1");
				$role->add_cap ("access_s2member_level2");
				$role->add_cap ("access_s2member_level3");
				$role->add_cap ("access_s2member_level4");
				/**/
				if (!is_dir ($files_dir = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"]))
					if (is_writable (dirname ($files_dir)))
						mkdir ($files_dir, 0777);
				/**/
				if (is_dir ($files_dir) && is_writable ($files_dir))
					if (!file_exists ($htaccess = $files_dir . "/.htaccess"))
						file_put_contents ($htaccess, "deny from all");
				/**/
				if (!is_dir ($logs_dir = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["logs_dir"]))
					if (is_writable (dirname ($logs_dir)))
						mkdir ($logs_dir, 0777);
				/**/
				if (is_dir ($logs_dir) && is_writable ($logs_dir))
					if (!file_exists ($htaccess = $logs_dir . "/.htaccess"))
						file_put_contents ($htaccess, "deny from all");
				/**/
				if (!is_numeric (get_option ("ws_plugin__s2member_configured")))
					update_option ("ws_plugin__s2member_configured", "0");
				/**/
				if (!is_array (get_option ("ws_plugin__s2member_cache")))
					update_option ("ws_plugin__s2member_cache", array ());
				/**/
				if (!is_array (get_option ("ws_plugin__s2member_notices")))
					update_option ("ws_plugin__s2member_notices", array ());
				/**/
				if (!is_array (get_option ("ws_plugin__s2member_options")))
					update_option ("ws_plugin__s2member_options", array ());
				/**/
				if ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["configured"]) /* If already configured, read the Changelog. */
					{
						$notice = '<strong>s2Member</strong> has been <strong>re-activated</strong>, with the latest version.<br />';
						$notice .= 'You now have version ' . WS_PLUGIN__S2MEMBER_VERSION . '. Your existing configuration remains.<br />';
						$notice .= 'Have fun, <a href="admin.php?page=ws-plugin--s2member-info">read the Changelog</a>, and make some money! :-)';
						ws_plugin__s2member_enqueue_admin_notice ($notice, array ("plugins.php", "ws-plugin--s2member-options"));
					}
				else /* Otherwise, we'll help the site owner out by giving them a link to the Quick Start Guide. */
					{
						$notice = '<strong>s2Member</strong> v' . WS_PLUGIN__S2MEMBER_VERSION . ' has been <strong>activated</strong>. Nice work!<br />';
						$notice .= 'Have fun, <a href="admin.php?page=ws-plugin--s2member-start">read the Quick Start Guide</a>, and make some money! :-)';
						ws_plugin__s2member_enqueue_admin_notice ($notice, array ("plugins.php", "ws-plugin--s2member-options"));
					}
				/**/
				update_option ("ws_plugin__s2member_activated_version", WS_PLUGIN__S2MEMBER_VERSION);
				/**/
				do_action ("ws_plugin__s2member_after_activation", get_defined_vars ());
				/**/
				return;
			}
	}
/*
Function for handling de-activation cleanup routines.
This function should match the array key for this plugin:
ws_plugin__$plugin_key_deactivate() is called by our themes.
*/
if (!function_exists ("ws_plugin__s2member_deactivate"))
	{
		function ws_plugin__s2member_deactivate ()
			{
				do_action ("ws_plugin__s2member_before_deactivation", get_defined_vars ());
				/**/
				if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["run_deactivation_routines"])
					{
						$role = &get_role ("subscriber");
						$role->remove_cap ("access_s2member_level0");
						/**/
						remove_role("s2member_level1");
						remove_role("s2member_level2");
						remove_role("s2member_level3");
						remove_role("s2member_level4");
						/**/
						$role = &get_role ("administrator");
						$role->remove_cap ("access_s2member_level0");
						$role->remove_cap ("access_s2member_level1");
						$role->remove_cap ("access_s2member_level2");
						$role->remove_cap ("access_s2member_level3");
						$role->remove_cap ("access_s2member_level4");
						/**/
						$role = &get_role ("editor");
						$role->remove_cap ("access_s2member_level0");
						$role->remove_cap ("access_s2member_level1");
						$role->remove_cap ("access_s2member_level2");
						$role->remove_cap ("access_s2member_level3");
						$role->remove_cap ("access_s2member_level4");
						/**/
						$role = &get_role ("author");
						$role->remove_cap ("access_s2member_level0");
						$role->remove_cap ("access_s2member_level1");
						$role->remove_cap ("access_s2member_level2");
						$role->remove_cap ("access_s2member_level3");
						$role->remove_cap ("access_s2member_level4");
						/**/
						$role = &get_role ("contributor");
						$role->remove_cap ("access_s2member_level0");
						$role->remove_cap ("access_s2member_level1");
						$role->remove_cap ("access_s2member_level2");
						$role->remove_cap ("access_s2member_level3");
						$role->remove_cap ("access_s2member_level4");
						/**/
						if (is_dir ($files_dir = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"]))
							{
								if (file_exists ($htaccess = $files_dir . "/.htaccess"))
									if (is_writable ($htaccess))
										unlink($htaccess);
								/**/
								@rmdir($files_dir);
							}
						/**/
						if (is_dir ($logs_dir = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["logs_dir"]))
							{
								if (file_exists ($htaccess = $logs_dir . "/.htaccess"))
									if (is_writable ($htaccess))
										unlink($htaccess);
								/**/
								if (file_exists ($log = $logs_dir . "/paypal-ipn.log"))
									if (is_writable ($log))
										unlink($log);
								/**/
								if (file_exists ($log = $logs_dir . "/paypal-rtn.log"))
									if (is_writable ($log))
										unlink($log);
								/**/
								@rmdir($logs_dir);
							}
						/**/
						delete_option("ws_plugin__s2member_activated_version");
						delete_option("ws_plugin__s2member_configured");
						delete_option("ws_plugin__s2member_cache");
						delete_option("ws_plugin__s2member_notices");
						delete_option("ws_plugin__s2member_options");
						/**/
						do_action ("ws_plugin__s2member_during_deactivation", get_defined_vars ());
					}
				/**/
				do_action ("ws_plugin__s2member_after_deactivation", get_defined_vars ());
				/**/
				return;
			}
	}
?>