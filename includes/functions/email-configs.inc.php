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
		do_action ("s2member_before_email_config", get_defined_vars ());
		/**/
		add_filter ("wp_mail_from", "_ws_plugin__s2member_email_config_email");
		add_filter ("wp_mail_from_name", "_ws_plugin__s2member_email_config_name");
		/**/
		do_action ("s2member_after_email_config", get_defined_vars ());
		/**/
		return;
	}
/**/
function _ws_plugin__s2member_email_config_email ($email = FALSE)
	{
		do_action ("s2member_before_email_config_email", get_defined_vars ());
		/**/
		return apply_filters ("s2member_email_config_email", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_email"], get_defined_vars ());
	}
/**/
function _ws_plugin__s2member_email_config_name ($name = FALSE)
	{
		do_action ("s2member_before_email_config_name", get_defined_vars ());
		/**/
		return apply_filters ("s2member_email_config_name", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_name"], get_defined_vars ());
	}
?>