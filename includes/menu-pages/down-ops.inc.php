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
Download Options page.
*/
echo '<div class="wrap ws-menu-page">' . "\n";
/**/
echo '<div id="icon-plugins" class="icon32"><br /></div>' . "\n";
echo '<h2><div>Developed by <a href="' . ws_plugin__s2member_parse_readme_value ("Plugin URI") . '"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-light.png" alt="." /></a></div>s2Member File Download Options</h2>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<table class="ws-menu-page-table">' . "\n";
echo '<tbody class="ws-menu-page-table-tbody">' . "\n";
echo '<tr class="ws-menu-page-table-tr">' . "\n";
echo '<td class="ws-menu-page-table-l">' . "\n";
/**/
echo '<form method="post" name="ws_plugin__s2member_options_form" id="ws-plugin--s2member-options-form">' . "\n";
echo '<input type="hidden" name="ws_plugin__s2member_options_save" id="ws-plugin--s2member-options-save" value="' . esc_attr (wp_create_nonce ("ws-plugin--s2member-options-save")) . '" />' . "\n";
echo '<input type="hidden" name="ws_plugin__s2member_configured" id="ws-plugin--s2member-configured" value="1" />' . "\n";
/**/
echo '<div class="ws-menu-page-group" title="Protected File Downloads">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-download-restrictions-section">' . "\n";
echo '<h3>File Download Restrictions ( required, if providing access to protected files )</h3>' . "\n";
echo '<p>If your membership offering allows access to restricted files, you\'ll need to configure these options.</p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<h3>Upload restricted files to this security-enabled directory:<br /> <code>' . preg_replace ("/^" . preg_quote ($_SERVER["DOCUMENT_ROOT"], "/") . "/", "", $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"]) . '</code></h3>' . "\n";
echo '<p>- Then, you can link to these restricted files using this special format:<br />&nbsp;&nbsp;<code>' . get_bloginfo ("url") . '/?<strong>s2member_file_download</strong>=example-file.zip</code><br />&nbsp;&nbsp;<small><em><strong>s2member_file_download</strong> = location of the file, relative to the /' . esc_html (basename ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"])) . '/ directory. In other words, just the file name.</em></small></p>' . "\n";
echo '<p>- If needed, you can make certain files available free, using an extra variable:<br />&nbsp;&nbsp;<code>' . get_bloginfo ("url") . '/?<strong>s2member_file_download</strong>=example-file.zip&<strong>s2member_free_file_download_key</strong>=&lt;?php echo s2member_xencrypt("example-file.zip"); ?&gt;</code><br />&nbsp;&nbsp;<small><em><strong>s2member_free_file_download_key</strong> = &lt;?php echo s2member_xencrypt("location of the file, relative to the /' . esc_html (basename ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"])) . '/ directory"); ?&gt;</em></small></p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p>s2Member will allow access to these protected files, based on the configuration you specify below. <em>* Note: repeated downloads of the same exact file are NOT tabulated against the totals below. Once a file has been downloaded, future downloads of the same exact file, by the same exact Member will not be counted against them. In other words, if a Member downloads the same file three times, the system only counts that as one unique download.</em></p>' . "\n";
echo '<p>s2Member will automatically detect links, anywhere in your content, and/or anywhere in your theme files, that contain <code>?s2member_file_download</code>. Whenever a logged-in Member clicks a link that contains <code>?s2member_file_download</code>, the system will politely ask the user to confirm the download using a very intuitive JavaScript confirmation prompt that contains specific details about download limitations. This way your Members will be aware of how many files they\'ve downloaded in the current period; and they\'ll be able to make a consious decision about whether to proceed with a specific download or not.</p>' . "\n";
echo '<p><em>* The above only applies to users who are logged in as members. For all other users in the general public, the <code>?s2member_file_download</code> links will redirect them your Membership Options Page, so that new users can signup, in order to gain access.</em></p>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<table class="form-table">' . "\n";
echo '<tbody>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-level1-file-downloads-allowed">' . "\n";
echo 'File Downloads ( Level #1 Or Higher ):' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="text" name="ws_plugin__s2member_level1_file_downloads_allowed" id="ws-plugin--s2member-level1-file-downloads-allowed" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_file_downloads_allowed"]) . '" style="width:200px;" maxlength="9" /> every <input type="text" name="ws_plugin__s2member_level1_file_downloads_allowed_days" id="ws-plugin--s2member-level1-file-downloads-allowed-days" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_file_downloads_allowed_days"]) . '" style="width:200px;" maxlength="3" onkeyup="if(this.value > 365){ alert(\'( 365 days is the maximum ).\\nThis keeps the logs optimized.\'); this.value = 365; }" /> days.<br />' . "\n";
echo 'Only this many unique downloads ( <code><em>999999999 = unlimited</em></code> ) will be permitted every X days.' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-level2-file-downloads-allowed">' . "\n";
echo 'File Downloads ( Level #2 Or Higher ):' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="text" name="ws_plugin__s2member_level2_file_downloads_allowed" id="ws-plugin--s2member-level2-file-downloads-allowed" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_file_downloads_allowed"]) . '" style="width:200px;" maxlength="9" /> every <input type="text" name="ws_plugin__s2member_level2_file_downloads_allowed_days" id="ws-plugin--s2member-level2-file-downloads-allowed-days" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_file_downloads_allowed_days"]) . '" style="width:200px;" maxlength="3" onkeyup="if(this.value > 365){ alert(\'( 365 days is the maximum ).\\nThis keeps the logs optimized.\'); this.value = 365; }" /> days.<br />' . "\n";
echo 'Only this many unique downloads ( <code><em>999999999 = unlimited</em></code> ) will be permitted every X days.' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-level3-file-downloads-allowed">' . "\n";
echo 'File Downloads ( Level #3 Or Higher ):' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="text" name="ws_plugin__s2member_level3_file_downloads_allowed" id="ws-plugin--s2member-level3-file-downloads-allowed" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_file_downloads_allowed"]) . '" style="width:200px;" maxlength="9" /> every <input type="text" name="ws_plugin__s2member_level3_file_downloads_allowed_days" id="ws-plugin--s2member-level3-file-downloads-allowed-days" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_file_downloads_allowed_days"]) . '" style="width:200px;" maxlength="3" onkeyup="if(this.value > 365){ alert(\'( 365 days is the maximum ).\\nThis keeps the logs optimized.\'); this.value = 365; }" /> days.<br />' . "\n";
echo 'Only this many unique downloads ( <code><em>999999999 = unlimited</em></code> ) will be permitted every X days.' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-level4-file-downloads-allowed">' . "\n";
echo 'File Downloads ( Highest Level #4 ):' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<input type="text" name="ws_plugin__s2member_level4_file_downloads_allowed" id="ws-plugin--s2member-level4-file-downloads-allowed" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_file_downloads_allowed"]) . '" style="width:200px;" maxlength="9" /> every <input type="text" name="ws_plugin__s2member_level4_file_downloads_allowed_days" id="ws-plugin--s2member-level4-file-downloads-allowed-days" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_file_downloads_allowed_days"]) . '" style="width:200px;" maxlength="3" onkeyup="if(this.value > 365){ alert(\'( 365 days is the maximum ).\\nThis keeps the logs optimized.\'); this.value = 365; }" /> days.<br />' . "\n";
echo 'Only this many unique downloads ( <code><em>999999999 = unlimited</em></code> ) will be permitted every X days.' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '</tbody>' . "\n";
echo '</table>' . "\n";
echo '</div>' . "\n";
/**/
echo '</div>' . "\n";
/**/
echo '<div class="ws-menu-page-group" title="Download Limit Exceeded">' . "\n";
/**/
echo '<div class="ws-menu-page-section ws-plugin--s2member-limit-exceeded-section">' . "\n";
echo '<h3>Download Limit Exceeded Page ( required, if providing access to protected files )</h3>' . "\n";
echo '<p>This Page will be shown if a user reaches their download limit, based on the configuration you\'ve specified in the fields above. This Page should be created by you, in WordPress®. This Page should provide an informative message to the User, describing your file access restrictions. Just tell them a little bit about your policy on file downloads, and why they might have reached this Page.</p>' . "\n";
/**/
echo '<table class="form-table">' . "\n";
echo '<tbody>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<th>' . "\n";
echo '<label for="ws-plugin--s2member-file-download-limit-exceeded-page">' . "\n";
echo 'Download Limit Exceeded Page:' . "\n";
echo '</label>' . "\n";
echo '</th>' . "\n";
/**/
echo '</tr>' . "\n";
echo '<tr>' . "\n";
/**/
echo '<td>' . "\n";
echo '<option value="">&mdash; Select &mdash;</option>' . "\n";
echo '<select name="ws_plugin__s2member_file_download_limit_exceeded_page" id="ws-plugin--s2member-file-download-limit-exceeded-page">' . "\n";
foreach (($ws_plugin__s2member_temp_a = array_merge ((array)get_pages ())) as $ws_plugin__s2member_temp_o)
	echo '<option value="' . esc_attr ($ws_plugin__s2member_temp_o->ID) . '"' . (($ws_plugin__s2member_temp_o->ID == $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"]) ? ' selected="selected"' : '') . '>' . esc_html ($ws_plugin__s2member_temp_o->post_title) . '</option>' . "\n";
echo '</select><br />' . "\n";
echo 'Please choose a Page that Users will see if they reach their file download limit. This Page should provide an informative message to the User, describing your file access restrictions. Just tell them a little bit about your policy on file downloads. We recommend the following title: <code>Download Limit Exceeded</code>.' . "\n";
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '</tbody>' . "\n";
echo '</table>' . "\n";
echo '</div>' . "\n";
/**/
echo '</div>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p class="submit"><input type="submit" class="button-primary" value="Save Changes" /></p>' . "\n";
/**/
echo '</form>' . "\n";
/**/
echo '</td>' . "\n";
/**/
echo '<td class="ws-menu-page-table-r">' . "\n";
/**/
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu-r"]["tools"]) ? '<div class="ws-menu-page-tools"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-tools.png" alt="." /></div>' . "\n" : '';
/**/
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu-r"]["tips"]) ? '<div class="ws-menu-page-tips"><a href="' . ws_plugin__s2member_parse_readme_value ("Customization URI") . '"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-tips.png" alt="." /></a></div>' . "\n" : '';
/**/
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu-r"]["donations"]) ? '<div class="ws-menu-page-donations"><a href="' . ws_plugin__s2member_parse_readme_value ("Donate link") . '"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-donations.jpg" alt="." /></a></div>' . "\n" : '';
/**/
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '</tbody>' . "\n";
echo '</table>' . "\n";
/**/
echo '</div>' . "\n";
?>