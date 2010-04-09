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
Functions that modify the email From: name/address.
*/
function ws_plugin__s2member_email_config ()
	{
		add_filter ("wp_mail_from", "_ws_plugin__s2member_email_config_email");
		add_filter ("wp_mail_from_name", "_ws_plugin__s2member_email_config_name");
		/**/
		return;
	}
/**/
function _ws_plugin__s2member_email_config_email ($email = FALSE)
	{
		return $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_email"];
	}
/**/
function _ws_plugin__s2member_email_config_name ($name = FALSE)
	{
		return $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_name"];
	}
?>