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
Function that determines whether we are on a systematic use page.
*/
function ws_plugin__s2member_is_systematic_use_page ()
	{
		static $is_systematic; /* For optimization. */
		/**/
		do_action ("s2member_before_is_systematic_use_page", get_defined_vars ());
		/**/
		if (isset ($is_systematic)) /* Already cached? This saves time. */
			{
				return apply_filters ("s2member_is_systematic_use_page", $is_systematic, get_defined_vars ());
			}
		else if (is_admin ()) /* In the admin area? */
			{
				return ($is_systematic = apply_filters ("s2member_is_systematic_use_page", true, get_defined_vars ()));
			}
		else if (preg_match ("/^cli$/i", PHP_SAPI))
			{
				return ($is_systematic = apply_filters ("s2member_is_systematic_use_page", true, get_defined_vars ()));
			}
		else if ($_SERVER["REMOTE_ADDR"] === $_SERVER["SERVER_ADDR"])
			{
				return ($is_systematic = apply_filters ("s2member_is_systematic_use_page", true, get_defined_vars ()));
			}
		else if (preg_match ("/\/wp-login\.php/", $_SERVER["REQUEST_URI"]))
			{
				return ($is_systematic = apply_filters ("s2member_is_systematic_use_page", true, get_defined_vars ()));
			}
		else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"] && is_page ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))
			{
				return ($is_systematic = apply_filters ("s2member_is_systematic_use_page", true, get_defined_vars ()));
			}
		else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"] && is_page ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"]))
			{
				return ($is_systematic = apply_filters ("s2member_is_systematic_use_page", true, get_defined_vars ()));
			}
		else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"] && is_page ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"]))
			{
				return ($is_systematic = apply_filters ("s2member_is_systematic_use_page", true, get_defined_vars ()));
			}
		else if (preg_match ("/^s2member/", $_SERVER["QUERY_STRING"]) && ($_SERVER["REQUEST_URI"] === "/" || strtolower (rtrim (get_bloginfo ("url"), "/")) === rtrim (strtolower ("http://" . $_SERVER["HTTP_HOST"]) . $_SERVER["REQUEST_URI"], "/")))
			{
				return ($is_systematic = apply_filters ("s2member_is_systematic_use_page", true, get_defined_vars ())); /* Only true when the request starts with /?s2member from the root URL of the domain, or from the root URL of the install. */
			}
		else /* Otherwise, we return false. */
			{
				return ($is_systematic = apply_filters ("s2member_is_systematic_use_page", false, get_defined_vars ()));
			}
	}
?>