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
if (realpath(__FILE__) === realpath($_SERVER["SCRIPT_FILENAME"]))
	exit;
/*
Function that hides some of the systematic use pages.
Attach to: add_filter("posts_where");
*/
function ws_plugin__s2member_hide_some_systematics ($where = FALSE)
	{
		global $wpdb; /* Need this to get the table name. */
		/**/
		if (is_search()) /* Here we exclude a few systematic use pages from the search query. */
			{
				$where .= " AND " . $wpdb->posts . ".ID NOT IN ('" . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"] . "', '" . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"] . "', '" . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"] . "')";
			}
		/**/
		return $where;
	}
?>