<?php
/**
* Encryption utilities.
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
* @package s2Member\Utilities
* @since 3.5
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit ("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_utils_encryption"))
	{
		/**
		* Encryption utilities.
		*
		* @package s2Member\Utilities
		* @since 3.5
		*/
		class c_ws_plugin__s2member_utils_encryption
			{
				/**
				* RIJNDAEL 256: two-way encryption/decryption, with a URL-safe base64 wrapper.
				*
				* Includes a built-in fallback on XOR encryption when mcrypt is not available.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @param str $string A string of data to encrypt.
				* @param str $key Optional. Key used for encryption.
				* 	Defaults to the one configured for s2Member.
				* 	Short of that, defaults to: ``wp_salt()``.
				* @return str Encrypted string.
				*/
				public static function encrypt ($string = FALSE, $key = FALSE)
					{
						$string = (is_string ($string)) ? $string : "";
						/**/
						$key = (!is_string ($key) || !strlen ($key)) ? $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sec_encryption_key"] : $key;
						$key = (!is_string ($key) || !strlen ($key)) ? wp_salt () : $key;
						/**/
						if (function_exists ("mcrypt_encrypt") && in_array ("rijndael-256", mcrypt_list_algorithms ()) && in_array ("cbc", mcrypt_list_modes ()))
							{
								$string = (strlen ($string)) ? "~r2|" . $string : "";
								$key = substr ($key, 0, mcrypt_get_key_size (MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC));
								$iv = c_ws_plugin__s2member_utils_strings::random_str_gen (mcrypt_get_iv_size (MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC), false);
								$encrypted = mcrypt_encrypt (MCRYPT_RIJNDAEL_256, $key, $string, MCRYPT_MODE_CBC, $iv);
								$encrypted = (strlen ($encrypted)) ? "~r2:" . $iv . "|" . $encrypted : "";
								/**/
								return ($base64 = str_replace (array ("+", "/", "="), array ("-", "_", "~"), base64_encode ($encrypted)));
							}
						else /* Fallback on XOR encryption. */
							return c_ws_plugin__s2member_utils_encryption::xencrypt ($string, $key);
					}
				/**
				* RIJNDAEL 256: two-way encryption/decryption, with a URL-safe base64 wrapper.
				*
				* Includes a built-in fallback on XOR encryption when mcrypt is not available.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @param str $base64 A string of data to decrypt. Should still be base64 encoded.
				* @param str $key Optional. Key used originally for encryption.
				* 	Defaults to the one configured for s2Member.
				* 	Short of that, defaults to: ``wp_salt()``.
				* @return str Decrypted string.
				*/
				public static function decrypt ($base64 = FALSE, $key = FALSE)
					{
						$base64 = (is_string ($base64)) ? $base64 : "";
						/**/
						$key = (!is_string ($key) || !strlen ($key)) ? $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sec_encryption_key"] : $key;
						$key = (!is_string ($key) || !strlen ($key)) ? wp_salt () : $key;
						/**/
						$encrypted = base64_decode (str_replace (array ("-", "_", "~", "."), array ("+", "/", "=", "="), $base64));
						/**/
						if (function_exists ("mcrypt_decrypt") && in_array ("rijndael-256", mcrypt_list_algorithms ()) && in_array ("cbc", mcrypt_list_modes ()) && preg_match ("/^~r2\:(.+?)\|/", $encrypted, $v1))
							{
								$encrypted = preg_replace ("/^~r2\:(.+?)\|/", "", $encrypted);
								$key = substr ($key, 0, mcrypt_get_key_size (MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC));
								$decrypted = mcrypt_decrypt (MCRYPT_RIJNDAEL_256, $key, $encrypted, MCRYPT_MODE_CBC, $v1[1]);
								$decrypted = preg_replace ("/^~r2\|/", "", $decrypted, 1, $v2);
								$decrypted = ($v2) ? $decrypted : ""; /* Check validity. */
								$decrypted = rtrim ($decrypted, "\0\4"); /* Nulls/EOTs. */
								/**/
								return ($string = $decrypted);
							}
						else /* Fallback on XOR decryption. */
							return c_ws_plugin__s2member_utils_encryption::xdecrypt ($base64, $key);
					}
				/**
				* XOR two-way encryption/decryption, with a base64 wrapper.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @param str $string A string of data to encrypt.
				* @param str $key Optional. Key used for encryption.
				* 	Defaults to the one configured for s2Member.
				* 	Short of that, defaults to: ``wp_salt()``.
				* @return str Encrypted string.
				*/
				public static function xencrypt ($string = FALSE, $key = FALSE)
					{
						$string = (is_string ($string)) ? $string : "";
						/**/
						$key = (!is_string ($key) || !strlen ($key)) ? $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sec_encryption_key"] : $key;
						$key = (!is_string ($key) || !strlen ($key)) ? wp_salt () : $key;
						/**/
						$string = (strlen ($string)) ? "~xe|" . $string : "";
						/**/
						for ($i = 1, $encrypted = ""; $i <= strlen ($string); $i++)
							{
								$char = substr ($string, $i - 1, 1);
								$keychar = substr ($key, ($i % strlen ($key)) - 1, 1);
								$encrypted .= chr (ord ($char) + ord ($keychar));
							}
						/**/
						$encrypted = (strlen ($encrypted)) ? "~xe|" . $encrypted : "";
						/**/
						return ($base64 = str_replace (array ("+", "/", "="), array ("-", "_", "~"), base64_encode ($encrypted)));
					}
				/**
				* XOR two-way encryption/decryption, with a base64 wrapper.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @param str $base64 A string of data to decrypt. Should still be base64 encoded.
				* @param str $key Optional. Key used originally for encryption.
				* 	Defaults to the one configured for s2Member.
				* 	Short of that, defaults to: ``wp_salt()``.
				* @return str Decrypted string.
				*/
				public static function xdecrypt ($base64 = FALSE, $key = FALSE)
					{
						$base64 = (is_string ($base64)) ? $base64 : "";
						/**/
						$key = (!is_string ($key) || !strlen ($key)) ? $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sec_encryption_key"] : $key;
						$key = (!is_string ($key) || !strlen ($key)) ? wp_salt () : $key;
						/**/
						$encrypted = base64_decode (str_replace (array ("-", "_", "~", "."), array ("+", "/", "=", "="), $base64));
						/**/
						$encrypted = preg_replace ("/^~xe\|/", "", $encrypted, 1, $v1);
						$encrypted = ($v1) ? $encrypted : ""; /* Check validity. */
						/**/
						for ($i = 1, $decrypted = ""; $i <= strlen ($encrypted); $i++)
							{
								$char = substr ($encrypted, $i - 1, 1);
								$keychar = substr ($key, ($i % strlen ($key)) - 1, 1);
								$decrypted .= chr (ord ($char) - ord ($keychar));
							}
						/**/
						$decrypted = preg_replace ("/^~xe\|/", "", $decrypted, 1, $v2);
						$decrypted = ($v2) ? $decrypted : ""; /* Check validity. */
						/**/
						return ($string = $decrypted);
					}
			}
	}
?>