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
if (!class_exists ("c_ws_plugin__s2member_meta_box_security"))
	{
		class c_ws_plugin__s2member_meta_box_security
			{
				/*
				Function adds meta boxes to Post/Page editing stations.
				*/
				public static function security_meta_box ($post = FALSE)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_security_meta_box", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if (is_object ($post) && ($post_id = $post->ID) && ( ($post->post_type === "page" && current_user_can ("edit_page", $post_id)) || current_user_can ("edit_post", $post_id)))
							{
								if ($post->post_type === "page" && ($page_id = $post_id)) /* OK. So we're dealing with a Page classification. */
									{
										if (!in_array ($page_id, array ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"], $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"], $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"])))
											{
												echo '<input type="hidden" name="ws_plugin__s2member_security_meta_box_save" id="ws-plugin--s2member-security-meta-box-save" value="' . esc_attr (wp_create_nonce ("ws-plugin--s2member-security-meta-box-save")) . '" />' . "\n";
												echo '<input type="hidden" name="ws_plugin__s2member_security_meta_box_save_id" id="ws-plugin--s2member-security-meta-box-save-id" value="' . esc_attr ($page_id) . '" />' . "\n";
												/**/
												$pages["0"] = preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_pages"]);
												$pages["1"] = preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_pages"]);
												$pages["2"] = preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_pages"]);
												$pages["3"] = preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_pages"]);
												$pages["4"] = preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_pages"]);
												/**/
												echo '<p style="margin-left:2px;"><strong>Page Level Restriction?</strong></p>' . "\n";
												echo '<label class="screen-reader-text" for="ws-plugin--s2member-security-meta-box-level">Add Level Restriction?</label>' . "\n";
												echo '<select name="ws_plugin__s2member_security_meta_box_level" id="ws-plugin--s2member-security-meta-box-level" style="width:99%;">' . "\n";
												echo '<option value=""></option>' . "\n"; /* By default, we allow public access to any Post/Page. */
												echo ($pages["0"] !== array ("all")) ? '<option value="0"' . ( (in_array ($page_id, $pages["0"])) ? ' selected="selected"' : '') . '>Require Level# 0 ( or higher )</option>' . "\n" : '<option value="" disabled="disabled">Level #0 ( already protects "all" Pages )</option>';
												echo ($pages["1"] !== array ("all")) ? '<option value="1"' . ( (in_array ($page_id, $pages["1"])) ? ' selected="selected"' : '') . '>Require Level# 1 ( or higher )</option>' . "\n" : '<option value="" disabled="disabled">Level #1 ( already protects "all" Pages )</option>';
												echo ($pages["2"] !== array ("all")) ? '<option value="2"' . ( (in_array ($page_id, $pages["2"])) ? ' selected="selected"' : '') . '>Require Level# 2 ( or higher )</option>' . "\n" : '<option value="" disabled="disabled">Level #2 ( already protects "all" Pages )</option>';
												echo ($pages["3"] !== array ("all")) ? '<option value="3"' . ( (in_array ($page_id, $pages["3"])) ? ' selected="selected"' : '') . '>Require Level# 3 ( or higher )</option>' . "\n" : '<option value="" disabled="disabled">Level #3 ( already protects "all" Pages )</option>';
												echo ($pages["4"] !== array ("all")) ? '<option value="4"' . ( (in_array ($page_id, $pages["4"])) ? ' selected="selected"' : '') . '>Require Level# 4 ( highest level )</option>' . "\n" : '<option value="" disabled="disabled">Level #4 ( already protects "all" Pages )</option>';
												echo '</select><br /><small>* see: <code>General Options -> Page Level Access</code></small>' . "\n";
												/**/
												if (!is_multisite () || !c_ws_plugin__s2member_utils_conds::is_multisite_farm () || is_main_site ())
													/* ^ Will change once Custom Capabilities are compatible with a Blog Farm. */
													{
														echo '<p style="margin-top:15px; margin-left:2px;"><strong>Require Custom Capabilities?</strong></p>' . "\n";
														echo '<label class="screen-reader-text" for="ws-plugin--s2member-security-meta-box-ccaps">Custom Capabilities?</label>' . "\n";
														echo '<input type="text" name="ws_plugin__s2member_security_meta_box_ccaps" id="ws-plugin--s2member-security-meta-box-ccaps" value="' . format_to_edit (implode (",", (array)get_post_meta ($page_id, "s2member_ccaps_req", true))) . '" onkeyup="if(this.value.match(/[^a-z_0-9,]/)) this.value = jQuery.trim (jQuery.trim (this.value).replace (/[ \-]/g, \'_\').replace (/[^A-Z_0-9,]/gi, \'\').toLowerCase ());" style="width:99%;" />' . "\n";
														echo '<br /><small>* see: <code>API Scripting -> Custom Capabilities</code></small>' . "\n";
													}
											}
										else if ($page_id == $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])
											echo 'This Page is your:<br /><strong>Membership Options Page</strong><br />( always publicly available )';
										/**/
										else if ($page_id == $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"])
											echo 'This Page is your:<br /><strong>Login Welcome Page</strong><br />( automatically guarded by s2Member )';
										/**/
										else if ($page_id == $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"])
											echo 'This Page is your:<br /><strong>Download Limit Exceeded Page</strong><br />( automatically guarded by s2Member )';
									}
								else /* Otherwise, we assume this is a Post, or possibly a Custom Post Type. It's NOT a Page. */
									{
										echo '<input type="hidden" name="ws_plugin__s2member_security_meta_box_save" id="ws-plugin--s2member-security-meta-box-save" value="' . esc_attr (wp_create_nonce ("ws-plugin--s2member-security-meta-box-save")) . '" />' . "\n";
										echo '<input type="hidden" name="ws_plugin__s2member_security_meta_box_save_id" id="ws-plugin--s2member-security-meta-box-save-id" value="' . esc_attr ($post_id) . '" />' . "\n";
										/**/
										$posts["0"] = preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_posts"]);
										$posts["1"] = preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_posts"]);
										$posts["2"] = preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_posts"]);
										$posts["3"] = preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_posts"]);
										$posts["4"] = preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_posts"]);
										/**/
										echo '<p style="margin-left:2px;"><strong>Post Level Restriction?</strong></p>' . "\n"; /* This allows a site owner to automatically add a Page/Post into their s2Member options. */
										echo '<label class="screen-reader-text" for="ws-plugin--s2member-security-meta-box-level">Add Level Restriction?</label>' . "\n";
										echo '<select name="ws_plugin__s2member_security_meta_box_level" id="ws-plugin--s2member-security-meta-box-level" style="width:99%;">' . "\n";
										echo '<option value=""></option>' . "\n"; /* By default, we allow public access to any Post/Page. */
										echo ($posts["0"] !== array ("all")) ? '<option value="0"' . ( (in_array ($post_id, $posts["0"])) ? ' selected="selected"' : '') . '>Require Level# 0 ( or higher )</option>' . "\n" : '<option value="" disabled="disabled">Level #0 ( already protects "all" Posts )</option>';
										echo ($posts["1"] !== array ("all")) ? '<option value="1"' . ( (in_array ($post_id, $posts["1"])) ? ' selected="selected"' : '') . '>Require Level# 1 ( or higher )</option>' . "\n" : '<option value="" disabled="disabled">Level #1 ( already protects "all" Posts )</option>';
										echo ($posts["2"] !== array ("all")) ? '<option value="2"' . ( (in_array ($post_id, $posts["2"])) ? ' selected="selected"' : '') . '>Require Level# 2 ( or higher )</option>' . "\n" : '<option value="" disabled="disabled">Level #2 ( already protects "all" Posts )</option>';
										echo ($posts["3"] !== array ("all")) ? '<option value="3"' . ( (in_array ($post_id, $posts["3"])) ? ' selected="selected"' : '') . '>Require Level# 3 ( or higher )</option>' . "\n" : '<option value="" disabled="disabled">Level #3 ( already protects "all" Posts )</option>';
										echo ($posts["4"] !== array ("all")) ? '<option value="4"' . ( (in_array ($post_id, $posts["4"])) ? ' selected="selected"' : '') . '>Require Level# 4 ( highest level )</option>' . "\n" : '<option value="" disabled="disabled">Level #4 ( already protects "all" Posts )</option>';
										echo '</select><br /><small>* see: <code>General Options -> Post Level Access</code></small>' . "\n";
										/**/
										if (!is_multisite () || !c_ws_plugin__s2member_utils_conds::is_multisite_farm () || is_main_site ())
											/* ^ Will change once Custom Capabilities are compatible with a Blog Farm. */
											{
												echo '<p style="margin-top:15px; margin-left:2px;"><strong>Require Custom Capabilities?</strong></p>' . "\n";
												echo '<label class="screen-reader-text" for="ws-plugin--s2member-security-meta-box-ccaps">Custom Capabilities?</label>' . "\n";
												echo '<input type="text" name="ws_plugin__s2member_security_meta_box_ccaps" id="ws-plugin--s2member-security-meta-box-ccaps" value="' . format_to_edit (implode (",", (array)get_post_meta ($post_id, "s2member_ccaps_req", true))) . '" onkeyup="if(this.value.match(/[^a-z_0-9,]/)) this.value = jQuery.trim (jQuery.trim (this.value).replace (/[ \-]/g, \'_\').replace (/[^A-Z_0-9,]/gi, \'\').toLowerCase ());" style="width:99%;" />' . "\n";
												echo '<br /><small>* see: <code>API Scripting -> Custom Capabilities</code></small>' . "\n";
											}
									}
							}
						/**/
						do_action ("ws_plugin__s2member_after_security_meta_box", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
			}
	}
?>