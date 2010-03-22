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
Get post vars from paypal, verify and return array.
*/
function ws_plugin__s2member_paypal_postvars ()
	{
		if ($_GET["tx"]) /* PDT with Auto-Return. */
			{
				if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_identity_token"])
					{
						$postback = "cmd=_notify-synch";
						/**/
						$postback .= "&tx=" . urlencode ($_GET["tx"]);
						$postback .= "&at=" . urlencode ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_identity_token"]);
						/**/
						$endpoint = ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_sandbox"]) ? "www.sandbox.paypal.com" : "www.paypal.com";
						/**/
						if (preg_match ("/^SUCCESS/i", ($response = trim (ws_plugin__s2member_curlpsr ("https://" . $endpoint . "/cgi-bin/webscr", $postback)))))
							{
								foreach (preg_split ("/[\r\n]+/", preg_replace ("/^SUCCESS/i", "", $response)) as $varline)
									{
										list ($key, $value) = preg_split ("/\=/", $varline, 2);
										if (strlen ($key = trim ($key)) && strlen ($value = trim ($value)))
											$postvars[$key] = trim (stripslashes (urldecode ($value)));
									}
								/**/
								return $postvars;
							}
					}
				/**/
				return false;
			}
		else if (is_array ($postvars = stripslashes_deep ($_POST)))
			{
				$postback = "cmd=_notify-validate";
				/**/
				foreach ($postvars as $key => $value)
					$postback .= "&" . $key . "=" . urlencode ($value);
				/**/
				foreach ($postvars as $key => $value)
					$postvars[$key] = trim ($value);
				/**/
				$endpoint = ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_sandbox"]) ? "www.sandbox.paypal.com" : "www.paypal.com";
				/**/
				if (strtolower (trim (ws_plugin__s2member_curlpsr ("https://" . $endpoint . "/cgi-bin/webscr", $postback))) === "verified")
					{
						return $postvars;
					}
				/**/
				return false;
			}
		else /* Unable to obtain. */
			{
				return false;
			}
	}
?>