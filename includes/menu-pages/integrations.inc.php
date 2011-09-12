<?php
/**
* Menu page for the s2Member plugin ( Integrations page ).
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
* @package s2Member\Menu_Pages
* @since 3.0
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_menu_page_integrations"))
	{
		/**
		* Menu page for the s2Member plugin ( Integrations page ).
		*
		* @package s2Member\Menu_Pages
		* @since 110531
		*/
		class c_ws_plugin__s2member_menu_page_integrations
			{
				public function __construct ()
					{
						echo '<div class="wrap ws-menu-page">' . "\n";
						/**/
						echo '<div id="icon-plugins" class="icon32"><br /></div>' . "\n";
						echo '<h2>Other s2Member® Integrations</h2>' . "\n";
						/**/
						echo '<table class="ws-menu-page-table">' . "\n";
						echo '<tbody class="ws-menu-page-table-tbody">' . "\n";
						echo '<tr class="ws-menu-page-table-tr">' . "\n";
						echo '<td class="ws-menu-page-table-l">' . "\n";
						/**/
						do_action ("ws_plugin__s2member_during_integrations_page_before_left_sections", get_defined_vars ());
						/**/
						if (apply_filters ("ws_plugin__s2member_during_integrations_page_during_left_sections_display_bbpress", true, get_defined_vars ()))
							{
								do_action ("ws_plugin__s2member_during_integrations_page_during_left_sections_before_bbpress", get_defined_vars ());
								/**/
								echo '<div class="ws-menu-page-group" title="bbPress® Plugin Integration ( 2.0+ plugin version )">' . "\n";
								/**/
								echo '<div class="ws-menu-page-section ws-plugin--s2member-bbpress-section">' . "\n";
								echo '<h3>bbPress® Plugin Integration ( easy peasy )</h3>' . "\n";
								echo '<input type="button" id="ws-plugin--s2member-update-roles-for-bbp-button" value="Update Roles/Capabilities" class="ws-menu-page-right ws-plugin--s2member-update-roles-button" style="min-width:175px;" />' . "\n";
								echo '<p>The plugin version of <a href="http://bbpress.org/" target="_blank" rel="external">bbPress® 2.0+</a> integrates seamlessly with WordPress®. If bbPress® was already installed when you activated s2Member, your s2Member Roles/Capabilities are already configured to work in harmony with bbPress®. If you didn\'t, you can simply click the "Update Roles/Capabilities" button here. That\'s all it takes. Once your Roles/Capbilities are updated, s2Member and bbPress® are fully integrated with each other.</p>' . "\n";
								echo '<h3>bbPress® Forums and s2Member Roles/Capabilities</h3>' . "\n";
								echo '<p>s2Member configures your Membership Roles ( by default, these include: <em>s2Member Level 1</em>, <em>s2Member Level 2</em>, <em>s2Member Level 3</em>, <em>s2Member Level 4</em> ), with a default set of permissions that allow all Members to access and particpate in your forums, just as if they were a WordPress® Subscriber Role. This is how bbPress® expects s2Member to behave. bbPress® also adds a new Role to your WordPress® installation: <em>Forum Moderator</em>. s2Member allows Forum Moderators full access to all content protected by s2Member, just like <em>Administrators</em>, <em>Editors</em>, <em>Authors</em>, and <em>Contributors</em>.</p>' . "\n";
								echo '<p><strong>Membership Levels provide incremental access:</strong></p>' . "\n";
								echo '<p>* A Member with Level 4 access, will also be able to access Levels 0, 1, 2 &amp; 3.<br />* A Member with Level 3 access, will also be able to access Levels 0, 1 &amp; 2.<br />* A Member with Level 2 access, will also be able to access Levels 0 &amp; 1.<br />* A Member with Level 1 access, will also be able to access Level 0.<br />* A Subscriber with Level 0 access, will ONLY be able to access Level 0.<br />* A public Visitor will have NO access to protected content.</p>' . "\n";
								echo '<p><em>* WordPress® Subscribers are at Membership Level 0. If you\'re allowing Open Registration, Subscribers will be at Level 0 ( a Free Subscriber ). WordPress® Administrators, Editors, Authors, Contributors, <strong class="ws-menu-page-hilite">and bbPress® Forum Moderators</strong> have Level 4 access, with respect to s2Member. All of their other Roles/Capabilities are left untouched.</em></p>' . "\n";
								echo '<p>Now, you can protect individual Forum Topics/Posts/Replies at different Levels with s2Member, or even with Custom Capabilities. Forum Topics/Posts/Replies are integrated by bbPress® internally as "Custom Post Types", which can be protected by s2Member either through Post Level Access Restrictions, or through URI Level Access Restrictions. s2Member will provide you with drop-down menus whenever you add or edit Forum Topics/Posts/Replies. You can also take a look at: <code>s2Member -> Restriction Options</code>. * Note, it is currently NOT possible to protect a Forum, and have all Topics inside that Forum protected automatically. In order to accomplish that, you\'ll need to use s2Member\'s URI Access Restrictions. We\'re working to improve this functionality in the mean time. Also, s2Member is currently NOT capable of protecting Topic Tags; but you can use URI Restrictions for these in the mean time.</p>' . "\n";
								do_action ("ws_plugin__s2member_during_integrations_page_during_left_sections_during_api_easy_way", get_defined_vars ());
								echo '</div>' . "\n";
								/**/
								echo '</div>' . "\n";
								/**/
								do_action ("ws_plugin__s2member_during_integrations_page_during_left_sections_after_bbpress", get_defined_vars ());
							}
						/* This remains for backward compatibility with bbPress® v1.0.3 and prior. */
						if (apply_filters ("ws_plugin__s2member_during_integrations_page_during_left_sections_display_bbpress", true, get_defined_vars ()))
							{
								do_action ("ws_plugin__s2member_during_integrations_page_during_left_sections_before_bbpress", get_defined_vars ());
								/**/
								echo '<div class="ws-menu-page-group" title="bbPress® Bridge Integration ( 1.0.3- legacy )">' . "\n";
								/**/
								echo '<div class="ws-menu-page-section ws-plugin--s2member-bbpress-section">' . "\n";
								echo '<h3>bbPress® Bridge Integration ( install/uninstall )</h3>' . "\n";
								echo '<p>If you\'re running <a href="http://bbpress.org/" target="_blank" rel="external">bbPress® forums</a> v1.0.3 or prior, you can protect them with the s2Member plugin. BUT, you will need to install this Bridge/plugin first. This bbPress® Bridge/plugin will block all non-Member access to your forums. Only the bbPress® login-page will be available. Forum registration will be redirected to your Membership Options Page for s2Member <em>( on your main WordPress® installation )</em>. This way, a visitor can signup on your site, and gain Membership Access to your forums.</p>' . "\n";
								echo '<p><em>* This Bridge/plugin will NOT work, until you\'ve successfully integrated WordPress® into bbPress®. For more information, log into your bbPress® Dashboard, and go to: <code>bbPress® -> Settings -> WordPress® Integration</code>. Once you have WordPress® integrated ( <a href="http://wordpress.org/extend/plugins/bbpress-integration/" target="_blank" rel="external">install this plugin</a> ) and follow the instructions regarding your <code>/wp-config.php</code> file. Then, come back here, and install the s2Member Bridge/plugin. * This Bridge Integration could also be installed manually. You\'ll find the bbPress® Bridge/plugin inside <code>/s2member/includes/dropins/bridges/_s2member-bbpress-bridge.php</code>. Pop that file into the `my-plugins/` directory for bbPress®, or just click the Install button below; s2Member will do this part for you automatically.</em></p>' . "\n";
								echo '<p><em>* This Bridge/plugin will also add a PHP Conditional Tag to your installation of bbPress®. This is 100% optional. Once installed, you could do something like this inside your bbPress® theme files with PHP code: ' . c_ws_plugin__s2member_utils_strings::highlight_php ('<?php if(current_wp_user_is("s2member_level2")){ /* Content. */ } ?>') . ' ... you can test for any WordPress® Role. The most common Roles associated with s2Member are: <code>subscriber</code>, <code>s2member_level1</code>, <code>s2member_level2</code>, <code>s2member_level3</code>, <code>s2member_level4</code>. This may come in handy for a developer integrating bbPress® in creative ways.</em></p>' . "\n";
								do_action ("ws_plugin__s2member_during_integrations_page_during_left_sections_during_api_easy_way", get_defined_vars ());
								/**/
								echo '<form method="post" name="ws_plugin__s2member_bridge_bbpress_form" id="ws-plugin--s2member-bridge-bbpress-form">' . "\n";
								echo '<input type="hidden" name="ws_plugin__s2member_bridge_bbpress" id="ws-plugin--s2member-bridge-bbpress" value="' . esc_attr (wp_create_nonce ("ws-plugin--s2member-bridge-bbpress")) . '" />' . "\n";
								/**/
								echo '<table class="form-table">' . "\n";
								echo '<tbody>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<th>' . "\n";
								echo '<label for="ws_plugin--s2member-bridge-bbpress-plugins-dir">' . "\n";
								echo 'Server path to your bbPress® plugins directory:' . "\n";
								echo '</label>' . "\n";
								echo '</th>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<td>' . "\n";
								echo '<input type="text" name="ws_plugin__s2member_bridge_bbpress_plugins_dir" id="ws_plugin--s2member-bridge-bbpress-plugins-dir" value="' . format_to_edit ($_POST["ws_plugin__s2member_bridge_bbpress_plugins_dir"]) . '" /><br />' . "\n";
								echo 'Something like: <code>' . esc_html (rtrim ($_SERVER["DOCUMENT_ROOT"], DIRECTORY_SEPARATOR . "/") . "/bbpress/my-plugins") . '</code>' . "\n";
								echo '</td>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<th>' . "\n";
								echo '<label for="ws_plugin--s2member-bridge-bbpress-ovg">' . "\n";
								echo 'Allow Open Viewing? ( can public visitors read forum posts? )' . "\n";
								echo '</label>' . "\n";
								echo '</th>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<td>' . "\n";
								echo '<select name="ws_plugin__s2member_bridge_bbpress_ovg" id="ws-plugin--s2member-bbpress-ovg">' . "\n";
								echo '<option value="0"' . ((!$_POST["ws_plugin__s2member_bridge_bbpress_min_level"]) ? ' selected="selected"' : '') . '>No ( my bbPress® forums are off-limits to the public )</option>' . "\n";
								echo '<option value="1"' . (($_POST["ws_plugin__s2member_bridge_bbpress_min_level"]) ? ' selected="selected"' : '') . '>Yes ( enable Open Viewing for public visitors ) read-only</option>' . "\n";
								echo '</select><span id="ws-plugin--s2member-bbpress-ovg-off-note" style="display:none;"><br />When this is <code>No</code>, the next setting below will include both read-access &amp; participation together ( as one concept ).</span>' . "\n";
								echo '</td>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<th>' . "\n";
								echo '<label for="ws_plugin--s2member-bridge-bbpress-min-level">' . "\n";
								echo 'Minimum Level to participate in your bbPress® forums.' . "\n";
								echo '</label>' . "\n";
								echo '</th>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<td>' . "\n";
								echo '<select name="ws_plugin__s2member_bridge_bbpress_min_level" id="ws-plugin--s2member-bbpress-min-level">' . "\n";
								echo '<option value="0"' . (($_POST["ws_plugin__s2member_bridge_bbpress_min_level"] === "0") ? ' selected="selected"' : '') . '>Require s2Member Level #0 ( to participate )</option>' . "\n";
								echo '<option value="1"' . (($_POST["ws_plugin__s2member_bridge_bbpress_min_level"] === "1") ? ' selected="selected"' : '') . '>Require s2Member Level #1 ( to participate )</option>' . "\n";
								echo '<option value="2"' . (($_POST["ws_plugin__s2member_bridge_bbpress_min_level"] === "2") ? ' selected="selected"' : '') . '>Require s2Member Level #2 ( to participate )</option>' . "\n";
								echo '<option value="3"' . (($_POST["ws_plugin__s2member_bridge_bbpress_min_level"] === "3") ? ' selected="selected"' : '') . '>Require s2Member Level #3 ( to participate )</option>' . "\n";
								echo '<option value="4"' . (($_POST["ws_plugin__s2member_bridge_bbpress_min_level"] === "4") ? ' selected="selected"' : '') . '>Require s2Member Level #4 ( to participate )</option>' . "\n";
								echo '</select>' . "\n";
								echo '</td>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '</tbody>' . "\n";
								echo '</table>' . "\n";
								/**/
								echo '<br />' . "\n";
								/**/
								echo '<p class="submit"><input type="submit" name="ws_plugin__s2member_bridge_bbpress_action" class="button-primary" value="Install / Re-Install" /> &nbsp;&nbsp; <input type="submit" name="ws_plugin__s2member_bridge_bbpress_action" class="button-primary" value="Un-Install" /></p>' . "\n";
								/**/
								echo '</form>' . "\n";
								echo '</div>' . "\n";
								/**/
								echo '</div>' . "\n";
								/**/
								do_action ("ws_plugin__s2member_during_integrations_page_during_left_sections_after_bbpress", get_defined_vars ());
							}
						/**/
						do_action ("ws_plugin__s2member_during_integrations_page_after_left_sections", get_defined_vars ());
						/**/
						echo '</td>' . "\n";
						/**/
						echo '<td class="ws-menu-page-table-r">' . "\n";
						c_ws_plugin__s2member_menu_pages_rs::display ();
						echo '</td>' . "\n";
						/**/
						echo '</tr>' . "\n";
						echo '</tbody>' . "\n";
						echo '</table>' . "\n";
						/**/
						echo '</div>' . "\n";
					}
			}
	}
/**/
new c_ws_plugin__s2member_menu_page_integrations ();
?>