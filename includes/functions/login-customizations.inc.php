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
Function for filtering the login logo url.
Attach to: add_filter("login_headerurl");
*/
if (!function_exists ("ws_plugin__s2member_login_header_url"))
	{
		function ws_plugin__s2member_login_header_url ($url = FALSE)
			{
				do_action ("ws_plugin__s2member_before_login_header_url", get_defined_vars ());
				/**/
				$url = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_logo_url"];
				/**/
				return apply_filters ("ws_plugin__s2member_login_header_url", $url, get_defined_vars ());
			}
	}
/*
Function for filtering the login logo title.
Attach to: add_filter("login_headertitle");
*/
if (!function_exists ("ws_plugin__s2member_login_header_title"))
	{
		function ws_plugin__s2member_login_header_title ($title = FALSE)
			{
				do_action ("ws_plugin__s2member_before_login_header_title", get_defined_vars ());
				/**/
				$title = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_logo_title"];
				/**/
				return apply_filters ("ws_plugin__s2member_login_header_title", $title, get_defined_vars ());
			}
	}
/*
Function for creating the styles for the login panel.
Attach to: add_action("login_head");
*/
if (!function_exists ("ws_plugin__s2member_login_header_styles"))
	{
		function ws_plugin__s2member_login_header_styles ()
			{
				$s = ""; /* Initialize here to give hooks a chance. */
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_login_header_styles", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				$s .= "\n" . '<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"></script>' . "\n";
				$s .= '<script type="text/javascript" src="' . get_bloginfo ("url") . '/?ws_plugin__s2member_js_w_globals=1&amp;no-cache=' . urlencode (md5 (mt_rand ())) . '"></script>' . "\n";
				/**/
				$s .= "\n" . '<style type="text/css">' . "\n";
				/**/
				$s .= 'html, body { border: 0 !important; background: none !important; }' . "\n"; /* Clear borders & existing background. */
				$s .= 'html { background-color: #' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_color"] . ' !important; }' . "\n";
				$s .= 'html { background-image: url(' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_image"] . ') !important; }' . "\n";
				/**/
				$s .= 'p#backtoblog a, p#backtoblog a:hover, p#backtoblog a:active, p#backtoblog a:focus { color: #' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_text_color"] . ' !important; text-shadow: 1px 1px 3px #' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_text_shadow_color"] . ' !important; top: 15px !important; left: 15px !important; padding: 10px !important; border:1px solid #' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_box_shadow_color"] . ' !important; background-color: #' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_color"] . ' !important; -moz-border-radius:3px !important; -webkit-border-radius:3px !important; border-radius:3px !important; }' . "\n";
				/**/
				$s .= 'div#login { width: ' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_logo_src_width"] . 'px !important; }' . "\n";
				$s .= 'div#login h1 a { background: url(' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_logo_src"] . ') no-repeat top center !important; }' . "\n";
				$s .= 'div#login h1 a { display: block !important; width: 100% !important; height: ' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_logo_src_height"] . 'px !important; }' . "\n";
				$s .= 'div#login p#nav, div#login p#nav a, div#login p#nav a:hover, div#login p#nav a:active, div#login p#nav a:focus { color: #' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_text_color"] . ' !important; text-shadow: 1px 1px 3px #' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_text_shadow_color"] . ' !important; }' . "\n";
				$s .= 'div#login form { -moz-box-shadow: 1px 1px 5px #' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_box_shadow_color"] . ', -1px -1px 5px #' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_box_shadow_color"] . ' !important; -webkit-box-shadow: 1px 1px 5px #' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_box_shadow_color"] . ', -1px -1px 5px #' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_box_shadow_color"] . ' !important; -khtml-box-shadow: 1px 1px 5px #' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_box_shadow_color"] . ', -1px -1px 5px #' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_box_shadow_color"] . ' !important; box-shadow: 1px 1px 5px #' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_box_shadow_color"] . ', -1px -1px 5px #' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_box_shadow_color"] . ' !important; }' . "\n";
				$s .= 'div#login form input[type="submit"], div#login form input[type="submit"]:hover, div#login form input[type="submit"]:active, div#login form input[type="submit"]:focus { color: #333333 !important; border: 1px solid #666666 !important; background: #CCCCCC !important; padding: 5px !important; -moz-border-radius: 3px !important; -webkit-border-radius: 3px !important; -khtml-border-radius: 3px !important; border-radius: 3px !important; }' . "\n";
				$s .= 'div#login form input[type="submit"]:hover, div#login form input[type="submit"]:active, div#login form input[type="submit"]:focus { color: #000000 !important; border: 1px solid #000000 !important; }' . "\n";
				/**/
				$s .= 'div#login form input.ws-plugin--s2member-custom-reg-field { background:none repeat scroll 0 0 #FBFBFB; border:1px solid #E5E5E5; font-size:24px; margin-bottom:16px; margin-right:6px; margin-top:2px; padding:3px; width:97%; }' . "\n";
				/**/
				if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_password"])
					$s .= 'p#reg_passmail { display: none; }' . "\n";
				/**/
				$s .= '</style>' . "\n\n";
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_during_login_header_styles", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				echo apply_filters ("ws_plugin__s2member_login_header_styles", $s, get_defined_vars ());
				/**/
				do_action ("ws_plugin__s2member_after_login_header_styles", get_defined_vars ());
				/**/
				return;
			}
	}
?>