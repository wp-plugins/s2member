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
As of s2Member v3.5+, these two functions are deprecated ( i.e. do NOT use ).
The s2Clean theme; prior to s2Clean v1.2.5 looked for the existence of these functions.
In fact, all older PriMoThemes called upon the activate/deactivate functions.
*/
function ws_plugin__s2member_activate () /* Call with classes. */
	{
		return c_ws_plugin__s2member_installation::activate ();
	}
/**/
function ws_plugin__s2member_deactivate () /* Call class. */
	{
		return c_ws_plugin__s2member_installation::deactivate ();
	}
/*
These functions are needed by the s2Member Pro upgrader prior to v1.5.
*/
function ws_plugin__s2member_trim_deep ($data = FALSE)
	{
		return c_ws_plugin__s2member_utils_strings::trim_deep ($data);
	}
/**/
function ws_plugin__s2member_remote ($url = FALSE, $post_vars = FALSE, $args = array ())
	{
		return c_ws_plugin__s2member_utils_urls::remote ($url, $post_vars, $args);
	}
/**/
function ws_plugin__s2member_enqueue_admin_notice ($notice = FALSE, $on_pages = FALSE, $error = FALSE, $time = FALSE, $dismiss = FALSE)
	{
		return c_ws_plugin__s2member_admin_notices::enqueue_admin_notice ($notice, $on_pages, $error, $time, $dismiss);
	}
?>