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
if (!class_exists ("c_ws_plugin__s2member_nocache"))
	{
		class c_ws_plugin__s2member_nocache
			{
				/*
				Handles no-cache headers and compatible constants for s2Member.
				This is compatible with Quick Cache and also with WP Super Cache.
				Attach to: add_action("init");
				*/
				public static function nocache ()
					{
						do_action ("ws_plugin__s2member_before_nocache", get_defined_vars ());
						/**/
						c_ws_plugin__s2member_nocache::nocache_constants (); /* This first. */
						c_ws_plugin__s2member_nocache::nocache_headers (); /* Now run headers. */
						/**/
						do_action ("ws_plugin__s2member_after_nocache", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
				/*
				Define compatible nocache constants for s2Member.
				This is compatible with Quick Cache and also with WP Super Cache.
				Quick Cache uses: QUICK_CACHE_ALLOWED, and Super Cache uses: DONOTCACHEPAGE.
				Actually, Quick Cache is compatible with either of these defined constants.
				
				Always disallow caching for logged in users and GET requests with /?s2member systematic use.
				For clarity on the systematic use with s2member in the request, see: /classes/systematics.inc.php.
				- Also disallow caching if the $nocache param is passed in as true by other routines.
				* BUT, always obey the qcAC param that specifically allows caching.
				
				This function is also called upon by other routines that protect members-only content areas.
				Members-only content areas should never be cached. In other words, there are some important supplemental
				routines that occur outside the scope of this single function. This function is called upon by those other
				targeted routines, to handle the nocache constants when they are required.
				
				These additional supplemental routines, include:
				- c_ws_plugin__s2member_ruris::check_ruri_level_access()
				- c_ws_plugin__s2member_catgs::check_catg_level_access()
				- c_ws_plugin__s2member_ptags::check_ptag_level_access()
				- c_ws_plugin__s2member_posts::check_post_level_access()
				- c_ws_plugin__s2member_pages::check_page_level_access()
				- c_ws_plugin__s2member_ip_restrictions::ip_restrictions_ok()
				- c_ws_plugin__s2member_files::file_download_key()
				- Button/Form/Shortcode Generators also call this.
				*/
				public static function nocache_constants ($nocache = FALSE)
					{
						static $once; /* We only need to set these Constants once. */
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_nocache_constants", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if (!$once && !$_GET["qcAC"] && ($nocache || is_user_logged_in () || (preg_match ("/^s2member/", $_SERVER["QUERY_STRING"]) && (parse_url ($_SERVER["REQUEST_URI"], PHP_URL_PATH) === "/" || parse_url (rtrim ($_SERVER["REQUEST_URI"], "/"), PHP_URL_PATH) === parse_url (rtrim (site_url (), "/"), PHP_URL_PATH)))))
							{
								define ("QUICK_CACHE_ALLOWED", false) . define ("DONOTCACHEPAGE", true);
								/**/
								$GLOBALS["ws_plugin__s2member_nocache_headers_selective"] = true;
								/**/
								$once = true; /* Only need to set these Constants one time. */
								/**/
								do_action ("ws_plugin__s2member_during_nocache_constants", get_defined_vars ());
							}
						/**/
						do_action ("ws_plugin__s2member_after_nocache_constants", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
				/*
				Sends Cache-Control ( no-cache ) headers.
				This uses the nocache_headers() function provided by WordPress®.
				This is compatible with the Quick Cache parameter ?qcABC=1 as well.
				* Always obey the qcABC param that specifically allows browser caching.
				*/
				public static function nocache_headers () /* Cache-Control header. */
					{
						static $once; /* We only need to set these headers one time. */
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_nocache_headers", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						$using_selective_behavior = apply_filters ("ws_plugin__s2member_nocache_headers_selective", false, get_defined_vars ());
						$selective = $GLOBALS["ws_plugin__s2member_nocache_headers_selective"]; /* Selective ( i.e. required ) ? */
						/**/
						if (!$once && !$_GET["qcABC"] && (!$using_selective_behavior || $selective) && !apply_filters ("ws_plugin__s2member_disable_nocache_headers", false, get_defined_vars ()))
							{
								if (is_array ($headers = headers_list ()))
									foreach ($headers as $header) /* Already? */
										if (stripos ($header, "no-cache") !== false)
											$no_cache_already_sent = true;
								/**/
								if (!$no_cache_already_sent)
									nocache_headers ();
								/**/
								$once = true; /* Only need to set these headers once. */
								/**/
								do_action ("ws_plugin__s2member_during_nocache_headers", get_defined_vars ());
							}
						/**/
						do_action ("ws_plugin__s2member_after_nocache_headers", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
			}
	}
?>