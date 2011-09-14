<?php
/**
* Menu page for the s2Member plugin ( File Download Options page ).
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
if (!class_exists ("c_ws_plugin__s2member_menu_page_down_ops"))
	{
		/**
		* Menu page for the s2Member plugin ( File Download Options page ).
		*
		* @package s2Member\Menu_Pages
		* @since 110531
		*/
		class c_ws_plugin__s2member_menu_page_down_ops
			{
				public function __construct ()
					{
						echo '<div class="wrap ws-menu-page">' . "\n";
						/**/
						echo '<div id="icon-plugins" class="icon32"><br /></div>' . "\n";
						echo '<h2>s2Member® File Download Options</h2>' . "\n";
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
						do_action ("ws_plugin__s2member_during_down_ops_page_before_left_sections", get_defined_vars ());
						/**/
						if (apply_filters ("ws_plugin__s2member_during_down_ops_page_during_left_sections_display_restrictions", true, get_defined_vars ()))
							{
								do_action ("ws_plugin__s2member_during_down_ops_page_during_left_sections_before_restrictions", get_defined_vars ());
								/**/
								echo '<div class="ws-menu-page-group" title="Basic Download Restrictions">' . "\n";
								/**/
								echo '<div class="ws-menu-page-section ws-plugin--s2member-restrictions-section">' . "\n";
								echo '<h3>File Download Restrictions ( required, if providing access to protected files )</h3>' . "\n";
								echo '<p>If your Membership offering allows access to restricted files, you\'ll want to configure these options.</p>' . "\n";
								do_action ("ws_plugin__s2member_during_down_ops_page_during_left_sections_during_restrictions", get_defined_vars ());
								/**/
								echo '<div class="ws-menu-page-hr"></div>' . "\n";
								/**/
								echo '<p><strong>Upload restricted files to this security-enabled directory:</strong><br /><code>' . esc_html (c_ws_plugin__s2member_utils_dirs::doc_root_path ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"])) . '</code></p>' . "\n";
								echo '<p>- Now, you can link to any protected file, using this special format:<br />&nbsp;&nbsp;<code>' . esc_html (site_url ("/?s2member_file_download=example-file.zip")) . '</code><br />&nbsp;&nbsp;<small><em><strong>s2member_file_download</strong> = file, relative to the /' . esc_html (c_ws_plugin__s2member_utils_dirs::basename_dir_app_data ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"])) . '/ directory. In other words, just the file name.</em></small></p>' . "\n";
								/**/
								echo '<div class="ws-menu-page-hr"></div>' . "\n";
								/**/
								echo '<p>s2Member will allow access to these protected files, based on the configuration you specify below. Repeated downloads of the same exact file are NOT tabulated against the totals below. Once a file has been downloaded, future downloads of the same exact file, by the same exact Member will not be counted against them. In other words, if a Member downloads the same file three times, the system only counts that as one unique download.</p>' . "\n";
								echo '<p>s2Member will automatically detect links, anywhere in your content, and/or anywhere in your theme files, that contain <code>?s2member_file_download</code>. Whenever a logged-in Member clicks a link that contains <code>?s2member_file_download</code>, the system will politely ask the user to confirm the download using a very intuitive JavaScript confirmation prompt that contains specific details about download limitations. This way your Members will be aware of how many files they\'ve downloaded in the current period; and they\'ll be able to make a conscious decision about whether to proceed with a specific download or not. If you want to suppress this JavaScript confirmation prompt, you can add this to the end of your links: <code>&amp;s2member_skip_confirmation</code>.</p>' . "\n";
								echo '<p><em>* The above only applies to Users who are logged in as Members. For all other visitors in the general public, the <code>?s2member_file_download</code> links will redirect them your Membership Options Page, so that new visitors can signup, in order to gain access, by becoming a Member. You may also want to have a look down below at s2Member\'s "Advanced Download Restrictions", which provides a greater degree of flexibility.</em></p>' . "\n";
								/**/
								echo '<div class="ws-menu-page-hr"></div>' . "\n";
								/**/
								echo '<table class="form-table" style="margin-top:0;">' . "\n";
								echo '<tbody>' . "\n";
								/**/
								for ($n = 0; $n <= $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["levels"]; $n++)
									{
										echo '<tr>' . "\n";
										/**/
										echo '<th style="padding-top:0;">' . "\n";
										echo '<label for="ws-plugin--s2member-level' . $n . '-file-downloads-allowed">' . "\n";
										echo ($n === $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["levels"]) ? 'File Downloads ( Highest Level #' . $n . ' ):' . "\n" : 'File Downloads ( Level #' . $n . ' Or Higher ):' . "\n";
										echo '</label>' . "\n";
										echo '</th>' . "\n";
										/**/
										echo '</tr>' . "\n";
										echo '<tr>' . "\n";
										/**/
										echo '<td>' . "\n";
										echo '<input type="text" name="ws_plugin__s2member_level' . $n . '_file_downloads_allowed" id="ws-plugin--s2member-level' . $n . '-file-downloads-allowed" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_file_downloads_allowed"]) . '" style="width:200px;" maxlength="9" /> every <input type="text" name="ws_plugin__s2member_level' . $n . '_file_downloads_allowed_days" id="ws-plugin--s2member-level' . $n . '-file-downloads-allowed-days" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $n . "_file_downloads_allowed_days"]) . '" style="width:200px;" maxlength="3" onkeyup="if(this.value > 365){ alert(\'( 365 days is the maximum ).\\nThis keeps the logs optimized.\'); this.value = 365; }" /> day(s).<br />' . "\n";
										echo 'Only this many unique downloads ( <code><em>999999999 = unlimited</em></code> ) will be permitted every X day(s).' . "\n";
										echo '</td>' . "\n";
										/**/
										echo '</tr>' . "\n";
										/**/
										echo ($n < $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["levels"]) ? '<tr><td><div class="ws-menu-page-hr"></div></td></tr>' : '';
									}
								/**/
								echo '</tbody>' . "\n";
								echo '</table>' . "\n";
								echo '</div>' . "\n";
								/**/
								echo '</div>' . "\n";
								/**/
								do_action ("ws_plugin__s2member_during_down_ops_page_during_left_sections_after_restrictions", get_defined_vars ());
							}
						/**/
						if (apply_filters ("ws_plugin__s2member_during_down_ops_page_during_left_sections_display_limit_exceeded_page", true, get_defined_vars ()))
							{
								do_action ("ws_plugin__s2member_during_down_ops_page_during_left_sections_before_limit_exceeded_page", get_defined_vars ());
								/**/
								echo '<div class="ws-menu-page-group" title="Download Limit Exceeded">' . "\n";
								/**/
								echo '<div class="ws-menu-page-section ws-plugin--s2member-limit-exceeded-page-section">' . "\n";
								echo '<h3>Download Limit Exceeded Page ( required, if providing access to protected files )</h3>' . "\n";
								echo '<p>This Page will be shown when/if a Member reaches their download limit, based on your configuration of <strong>Basic Download Restrictions</strong> above. This Page should be created by you, in WordPress®. This Page should provide an informative message to the Member, describing your file access restrictions. Just tell them a little bit about your policy on file downloads, and why they might have reached this Page.</p>' . "\n";
								do_action ("ws_plugin__s2member_during_down_ops_page_during_left_sections_during_limit_exceeded_page", get_defined_vars ());
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
								echo '<select name="ws_plugin__s2member_file_download_limit_exceeded_page" id="ws-plugin--s2member-file-download-limit-exceeded-page">' . "\n";
								echo '<option value="">&mdash; Select &mdash;</option>' . "\n";
								foreach (($ws_plugin__s2member_temp_a = array_merge ((array)get_pages ())) as $ws_plugin__s2member_temp_o)
									echo '<option value="' . esc_attr ($ws_plugin__s2member_temp_o->ID) . '"' . (($ws_plugin__s2member_temp_o->ID == $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"]) ? ' selected="selected"' : '') . '>' . esc_html ($ws_plugin__s2member_temp_o->post_title) . '</option>' . "\n";
								echo '</select><br />' . "\n";
								echo 'We recommend the following title: <code>Download Limit Exceeded</code>.' . "\n";
								echo '</td>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '</tbody>' . "\n";
								echo '</table>' . "\n";
								echo '</div>' . "\n";
								/**/
								echo '</div>' . "\n";
								/**/
								do_action ("ws_plugin__s2member_during_down_ops_page_during_left_sections_after_limit_exceeded_page", get_defined_vars ());
							}
						/**/
						if (apply_filters ("ws_plugin__s2member_during_down_ops_page_during_left_sections_display_advanced_restrictions", true, get_defined_vars ()))
							{
								do_action ("ws_plugin__s2member_during_down_ops_page_during_left_sections_before_advanced_restrictions", get_defined_vars ());
								/**/
								echo '<div class="ws-menu-page-group" title="Advanced Download Restrictions">' . "\n";
								/**/
								echo '<div class="ws-menu-page-section ws-plugin--s2member-restrictions-section">' . "\n";
								echo '<h3>Advanced Download Restrictions ( optional, for greater flexibility )</h3>' . "\n";
								echo '<p>By default, s2Member uses your Basic Download Restrictions, as configured above. However, you can force s2Member to allow File Downloads, using an extra query string parameter: <code>&amp;s2member_file_download_key=[Key]</code>. A File Download `Key` is passed through this parameter; it tells s2Member to allow the download of this particular file, regardless of Membership Level; and WITHOUT checking any Basic Restrictions, that you may or may not have configured above. The creation of a File Download `Key`, requires a small PHP code snippet. In order to use PHP scripting inside your Posts/Pages, you\'ll need to install this handy plugin ( <a href="http://wordpress.org/extend/plugins/php-execution-plugin/" target="_blank" rel="external">PHP Execution</a> ). There is also a Shortcode equivalent, which does NOT require PHP at all, as seen below.</p>' . "\n";
								do_action ("ws_plugin__s2member_during_down_ops_page_during_left_sections_during_advanced_restrictions", get_defined_vars ());
								/**/
								echo '<div class="ws-menu-page-hr"></div>' . "\n";
								/**/
								echo '<p>' . esc_html (site_url ("/?s2member_file_download=example-file.zip")) . '<code>&amp;s2member_file_download_key=&lt;?php echo s2member_file_download_key("example-file.zip"); ?&gt;</code><br />&nbsp;&nbsp;<small><em><strong>s2member_file_download_key</strong> = &lt;?php echo s2member_file_download_key("file, relative to the /' . esc_html (c_ws_plugin__s2member_utils_dirs::basename_dir_app_data ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"])) . '/ directory"); ?&gt;</em></small></p>' . "\n";
								/**/
								echo '<div class="ws-menu-page-hr"></div>' . "\n";
								/**/
								echo '<p>' . esc_html (site_url ("/?s2member_file_download=example-file.zip")) . '<code>&amp;s2member_file_download_key=[s2Key file_download="example-file.zip" /]</code><br />&nbsp;&nbsp;<small><em><strong>Shortcode equivalent:</strong> <code>[s2Key file_download="example-file.zip" /]</code></em></small></p>' . "\n";
								/**/
								echo '<div class="ws-menu-page-hr"></div>' . "\n";
								/**/
								echo '<p>The function <a href="http://www.primothemes.com/forums/viewtopic.php?f=40&t=12453#src_doc_s2member_file_download_key%28%29" target="_blank" rel="external">s2member_file_download_key()</a>, is part of the s2Member API. It produces a time-sensitive File Download Key that is unique to each and every visitor. Each Key it produces <em>( at the time it is produced )</em>, will be valid for the current day, and only for a specific IP address and User-Agent string; as detected by s2Member. This makes it possible for you to create links on your site, which provide access to protected file downloads; and without having to worry about one visitor sharing their link with another. So let\'s take a quick look at what <code>s2member_file_download_key()</code> actually produces.</p>' . "\n";
								echo '<p><code>s2member_file_download_key("example-file.zip")</code> = a site-specific hash of: <code>date("Y-m-d").$_SERVER["REMOTE_ADDR"].$_SERVER["HTTP_USER_AGENT"].$file</code></p>' . "\n";
								echo '<p>When <code>s2member_file_download_key = <em>a valid Key</em></code>, it works independently from Member Level Access. That is, a visitor does NOT have to be logged in to receive access; they just need a valid Key. Using this advanced technique, you could extend s2Member\'s file protection routines, or even combine them with Specific Post/Page Access, and more. The possibilities are limitless really.</p>' . "\n";
								/**/
								echo '</div>' . "\n";
								/**/
								echo '</div>' . "\n";
								/**/
								do_action ("ws_plugin__s2member_during_down_ops_page_during_left_sections_after_advanced_restrictions", get_defined_vars ());
							}
						/**/
						if (apply_filters ("ws_plugin__s2member_during_down_ops_page_during_left_sections_display_inline_extensions", true, get_defined_vars ()))
							{
								do_action ("ws_plugin__s2member_during_down_ops_page_during_left_sections_before_inline_extensions", get_defined_vars ());
								/**/
								echo '<div class="ws-menu-page-group" title="Inline File Extensions">' . "\n";
								/**/
								echo '<div class="ws-menu-page-section ws-plugin--s2member-inline-extensions-section">' . "\n";
								echo '<h3>Inline File Extensions ( optional, for content-disposition )</h3>' . "\n";
								echo '<p>There are two ways to serve files. Inline, or as an Attachment. By default, s2Member will serve all of your protected files, as downloadable attachments. Meaning, visitors will be given a file download prompt. Otherwise known as <code>Content-Disposition: attachment</code>. In some cases though, you may wish to serve files inline. For example, PDF files and images should usually be served inline. When you serve a file inline, it is displayed in your browser immediately, rather than your browser prompting you to download the file as an attachment.</p>' . "\n";
								echo '<p>Using the field below, you can list all of the extensions that you want s2Member to serve inline ( ex: <code>htm,html,pdf,jpg,jpeg,jpe,gif,png,mp3,mp4,flv</code> ). Please understand, some files just cannot be displayed inline. For instance, there is no way to display an <code>exe</code> file inline. So only specify extensions that can, and should be displayed inline by a web browser. Alternatively, if you would rather handle this on a case-by-case basis, you can simply add the following to the end of your download links: <code>&amp;s2member_file_inline=yes</code>.</p>' . "\n";
								do_action ("ws_plugin__s2member_during_down_ops_page_during_left_sections_during_inline_extensions", get_defined_vars ());
								/**/
								echo '<table class="form-table">' . "\n";
								echo '<tbody>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<th>' . "\n";
								echo '<label for="ws-plugin--s2member-file-download-inline-extensions">' . "\n";
								echo 'Default Inline File Extensions ( comma-delimited ):' . "\n";
								echo '</label>' . "\n";
								echo '</th>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<td>' . "\n";
								echo '<input type="text" name="ws_plugin__s2member_file_download_inline_extensions" id="ws-plugin--s2member-file-download-inline-extensions" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_inline_extensions"]) . '" /><br />' . "\n";
								echo 'Inline extensions in comma-delimited format. Example: <code>htm,html,pdf,jpg,jpeg,jpe,gif,png,mp3,mp4,flv</code>' . "\n";
								echo '</td>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '</tbody>' . "\n";
								echo '</table>' . "\n";
								echo '</div>' . "\n";
								/**/
								echo '</div>' . "\n";
								/**/
								do_action ("ws_plugin__s2member_during_down_ops_page_during_left_sections_after_inline_extensions", get_defined_vars ());
							}
						/**/
						if (apply_filters ("ws_plugin__s2member_during_down_ops_page_during_left_sections_display_remote_authorization", true, get_defined_vars ()))
							{
								do_action ("ws_plugin__s2member_during_down_ops_page_during_left_sections_before_remote_authorization", get_defined_vars ());
								/**/
								echo '<div class="ws-menu-page-group" title="Remote Auth / Podcasting">' . "\n";
								/**/
								echo '<div class="ws-menu-page-section ws-plugin--s2member-remote-authorization-section">' . "\n";
								echo '<h3>Remote Header Authorization ( optional )</h3>' . "\n";
								echo '<p>This can be enabled on a case-by-case basis. Just add this to the end of your download links: <code>&amp;s2member_file_remote=yes</code>.</p>' . "\n";
								echo '<p>Remote Header Authorization allows access to file downloads through an entirely different approach. Instead of asking the Member to log into your site through a browser, a Member will be prompted automatically, to log in through HTTP Header Authorization prompts; which is the same technique used in more traditional security systems via .htaccess files. In other words, Remote Header Authorization makes it possible for your Members to access files through remote applications that may NOT use a browser. This is often the case when a Member needs to access protected files through a software client like iTunes®; typical with podcasts. See <a href="http://www.primothemes.com/forums/viewtopic.php?f=4&t=837&p=28558#p28558" target="_blank" rel="external">tutorial here</a> for details about how to setup a Podcast for iTunes®.</p>' . "\n";
								do_action ("ws_plugin__s2member_during_down_ops_page_during_left_sections_during_remote_authorization", get_defined_vars ());
								echo '</div>' . "\n";
								/**/
								echo '</div>' . "\n";
								/**/
								do_action ("ws_plugin__s2member_during_down_ops_page_during_left_sections_after_remote_authorization", get_defined_vars ());
							}
						/**/
						if (apply_filters ("ws_plugin__s2member_during_down_ops_page_during_left_sections_display_amazon_s3", true, get_defined_vars ()))
							{
								do_action ("ws_plugin__s2member_during_down_ops_page_during_left_sections_before_amazon_s3", get_defined_vars ());
								/**/
								echo '<div class="ws-menu-page-group" title="Amazon® S3/CDN Storage Option">' . "\n";
								/**/
								echo '<div class="ws-menu-page-section ws-plugin--s2member-inline-extensions-section">' . "\n";
								echo '<h3>Amazon® S3/CDN Storage &amp; Delivery ( optional )</h3>' . "\n";
								echo '<a href="http://aws.amazon.com/s3/" target="_blank"><img src="' . esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"]) . '/images/amazon-logo.png" class="ws-menu-page-right" style="width:250px; height:100px; border:0;" alt="." /></a>' . "\n";
								echo '<p>Amazon® Simple Storage Service ( <a href="http://aws.amazon.com/s3/" target="_blank" rel="external">Amazon® S3</a> ). Amazon® S3 is storage for the Internet. It is designed to make web-scale computing easier for developers. Amazon® S3 provides a simple web services interface that can be used to store and retrieve any amount of data, at any time, from anywhere on the web. It gives developers access to the same highly scalable, reliable, secure, fast, inexpensive infrastructure that Amazon® uses to run its own global network of web sites. s2Member has been integrated with Amazon® S3, so that <em>( if you wish )</em>, instead of using the <code>/' . esc_html (c_ws_plugin__s2member_utils_dirs::basename_dir_app_data ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"])) . '/</code> directory, you can store all of your protected files inside an Amazon® S3 Bucket.</p>' . "\n";
								echo '<p>If you configure the options below, s2Member will assume all protected files are inside your Amazon® S3 Bucket; and the <code>/' . esc_html (c_ws_plugin__s2member_utils_dirs::basename_dir_app_data ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"])) . '/</code> directory is no longer used at all. That being said, all other aspects of s2Member\'s File Download protection remain the same. The only thing that changes, is the location of your protected Files. In other words, Basic Download Restrictions, Download Keys, Inline Extensions, Custom Capability and/or Membership Level Files will all continue to work just as before. The only difference is that s2Member will use your Amazon® S3 Bucket as a CDN <em>( i.e. Content Delivery Network )</em> instead of the local <code>/' . esc_html (c_ws_plugin__s2member_utils_dirs::basename_dir_app_data ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"])) . '/</code> directory.</p>' . "\n";
								echo '<p>s2Member assumes that you\'re creating a new Amazon® S3 Bucket, specifically for this installation; and that your Bucket is NOT available publicly. In other words, if you type this URL into your browser ( i.e. <code>http://s3.amazonaws.com/your-bucket-name/</code> ), you should get an error that says: <code>Access Denied</code>. That\'s good, that\'s exactly what you want. You can create your Amazon® S3 Bucket using the <a href="https://console.aws.amazon.com/s3/home" target="_blank" rel="external">Amazon® interface</a>. Or, some people prefer to use this popular Firefox® extension ( <a href="http://www.s3fox.net/" target="_blank" rel="external">S3 Fox Organizer</a> ).</p>' . "\n";
								do_action ("ws_plugin__s2member_during_down_ops_page_during_left_sections_during_amazon_s3", get_defined_vars ());
								/**/
								echo '<div class="ws-menu-page-hr"></div>' . "\n";
								/**/
								echo '<p><em><strong>*Dev Note*</strong> s2Member uses "Query String Authentication", provided by the Amazon® S3 API. Documented for developers <a href="http://docs.amazonwebservices.com/AmazonS3/latest/dev/index.html?RESTAuthentication.html" target="_blank" rel="external">here</a>. To put it simply, s2Member will generate S3 authenticated redirect URLs ( internally ); which allow Customers temporary access to specific files inside your S3 Bucket. s2Member\'s Query String Authentication through Amazon® S3 gives a Customer 30 seconds to connect to the file inside your S3 Bucket ( i.e. the automatic redirection URL ). This connection period of 30 seconds is largely irrelevant when used in combination with s2Member. It just needs to be a low value, to further prevent any possibility of S3 authenticated link sharing. If you need to change this connection timeout of <code>30 seconds</code> for some reason ( not likely ), you can use this WordPress® Filter: <code>ws_plugin__s2member_amazon_s3_file_expires_time</code>. If you need help, please check the s2Member Forums.</em></p>' . "\n";
								/**/
								echo '<div class="ws-menu-page-hr"></div>' . "\n";
								/**/
								echo '<table class="form-table" style="margin-top:0;">' . "\n";
								echo '<tbody>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<th style="padding-top:0;">' . "\n";
								echo '<label for="ws-plugin--s2member-amazon-s3-files-bucket">' . "\n";
								echo 'Amazon® S3 File Bucket: ( where protected files are )' . "\n";
								echo '</label>' . "\n";
								echo '</th>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<td>' . "\n";
								echo '<input type="text" name="ws_plugin__s2member_amazon_s3_files_bucket" id="ws-plugin--s2member-amazon-s3-files-bucket" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["amazon_s3_files_bucket"]) . '" /><br />' . "\n";
								echo 'Your Amazon® S3 Bucket will be used, instead of the <code>/' . esc_html (c_ws_plugin__s2member_utils_dirs::basename_dir_app_data ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"])) . '/</code> directory.' . "\n";
								echo '</td>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<th>' . "\n";
								echo '<label for="ws-plugin--s2member-amazon-s3-files-access-key">' . "\n";
								echo 'Amazon® Access Key: ( Access Key ID )' . "\n";
								echo '</label>' . "\n";
								echo '</th>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<td>' . "\n";
								echo '<input type="text" name="ws_plugin__s2member_amazon_s3_files_access_key" id="ws-plugin--s2member-amazon-s3-files-access-key" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["amazon_s3_files_access_key"]) . '" /><br />' . "\n";
								echo 'See: <code>Amazon® Web Services -> Account -> Security Credentials</code>.' . "\n";
								echo '</td>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<th>' . "\n";
								echo '<label for="ws-plugin--s2member-amazon-s3-files-secret-key">' . "\n";
								echo 'Amazon® Secret Key: ( Secret Access Key )' . "\n";
								echo '</label>' . "\n";
								echo '</th>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '<tr>' . "\n";
								/**/
								echo '<td>' . "\n";
								echo '<input type="password" name="ws_plugin__s2member_amazon_s3_files_secret_key" id="ws-plugin--s2member-amazon-s3-files-secret-key" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["amazon_s3_files_secret_key"]) . '" /><br />' . "\n";
								echo 'See: <code>Amazon® Web Services -> Account -> Security Credentials</code>.' . "\n";
								echo '</td>' . "\n";
								/**/
								echo '</tr>' . "\n";
								echo '</tbody>' . "\n";
								echo '</table>' . "\n";
								echo '</div>' . "\n";
								/**/
								echo '</div>' . "\n";
								/**/
								do_action ("ws_plugin__s2member_during_down_ops_page_during_left_sections_after_inline_extensions", get_defined_vars ());
							}
						/**/
						if (apply_filters ("ws_plugin__s2member_during_down_ops_page_during_left_sections_display_rewrite_linkage", true, get_defined_vars ()))
							{
								do_action ("ws_plugin__s2member_during_down_ops_page_during_left_sections_before_rewrite_linkage", get_defined_vars ());
								/**/
								echo '<div class="ws-menu-page-group" title="Advanced Mod-Rewrite Linkage">' . "\n";
								/**/
								echo '<div class="ws-menu-page-section ws-plugin--s2member-rewrite-linkage-section">' . "\n";
								echo '<h3>Advanced Mod-Rewrite Linkage</h3>' . "\n";
								echo '<p>s2Member automatically creates <code>mod_rewrite</code> rules inside your <code>/' . esc_html (c_ws_plugin__s2member_utils_dirs::basename_dir_app_data ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"])) . '/</code> directory, which provide additional flexibility in the way protected files can be served to your Customers. With s2Member\'s <code>mod_rewrite</code> rules, it is now possible to link directly to a protected file, avoiding the use of query string variables <em>( it\'s completely optional though, i.e. NOT required )</em>.</p>' . "\n";
								echo '<p>This new flexibility may come in handy for site owners serving files through media playback devices that have issues with query string variables. For instance, it is now possible to link to an s2Member-protected file directly, like this: <code>... /wp-content/plugins/' . esc_html (c_ws_plugin__s2member_utils_dirs::basename_dir_app_data ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"])) . '/example-file.zip</code> instead of <code>... /?s2member_file_download=example-file.zip</code>. Either way works, but the direct link might be easier for some.</p>' . "\n";
								echo '<p>It is also possible to pass query string parameters through a direct link:<br /><code>... /wp-content/plugins/' . esc_html (c_ws_plugin__s2member_utils_dirs::basename_dir_app_data ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"])) . '/example-file.zip?s2member_file_inline=yes&amp;s2member_file_download_key=[key]</code>.</p>' . "\n";
								echo '<p>That being said, s2Member\'s <code>mod_rewrite</code> rules allow for more advanced control over s2Member-specific parameters.</p>' . "\n";
								echo '<p>For example, you could just do this for inline files:<br /><code>... /wp-content/plugins/' . esc_html (c_ws_plugin__s2member_utils_dirs::basename_dir_app_data ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"])) . '<strong class="ws-menu-page-hilite">/s2member-file-inline</strong>/example-file.zip</code></p>' . "\n";
								echo '<p>Or, if you really want to get advanced, you could do something like this:<br /><code>... /wp-content/plugins/' . esc_html (c_ws_plugin__s2member_utils_dirs::basename_dir_app_data ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"])) . '<strong class="ws-menu-page-hilite">/s2member-file-inline-[yes|no]/s2member-file-download-key-[key]</strong>/example-file.zip</code></p>' . "\n";
								echo '<p>Or even this, if you\'re using Remote Header Authorization:<br /><code>... /wp-content/plugins/' . esc_html (c_ws_plugin__s2member_utils_dirs::basename_dir_app_data ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"])) . '<strong class="ws-menu-page-hilite">/s2member-file-remote</strong>/example-file.zip</code></p>' . "\n";
								echo '<p><em>* Note, the order of your s2Member-specific parameters with Advanced Mod-Rewrite Linkage is irrelevant. Feel free to add/remove, or even change the order. Everything discussed here is also Multisite compatible. Everything discussed here is also compatible when/if combined with Amazon® S3/CDN Storage. However, NONE of this will work on servers that do NOT support <code>mod_rewrite</code>. Almost all web servers do though.</em></p>' . "\n";
								do_action ("ws_plugin__s2member_during_down_ops_page_during_left_sections_during_rewrite_linkage", get_defined_vars ());
								echo '</div>' . "\n";
								/**/
								echo '</div>' . "\n";
								/**/
								do_action ("ws_plugin__s2member_during_down_ops_page_during_left_sections_after_rewrite_linkage", get_defined_vars ());
							}
						/**/
						do_action ("ws_plugin__s2member_during_down_ops_page_after_left_sections", get_defined_vars ());
						/**/
						echo '<div class="ws-menu-page-hr"></div>' . "\n";
						/**/
						echo '<p class="submit"><input type="submit" class="button-primary" value="Save All Changes" /></p>' . "\n";
						/**/
						echo '</form>' . "\n";
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
new c_ws_plugin__s2member_menu_page_down_ops ();
?>