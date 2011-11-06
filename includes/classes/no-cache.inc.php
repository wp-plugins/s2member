<?php
/**
* No-cache routines.
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
* @package s2Member\No_Cache
* @since 3.5
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_no_cache"))
	{
		/**
		* No-cache routines.
		*
		* @package s2Member\No_Cache
		* @since 3.5
		*/
		class c_ws_plugin__s2member_no_cache
			{
				/**
				* Handles no-cache headers and compatible constants for s2Member.
				*
				* This is compatible with Quick Cache and also with WP Super Cache.
				*
				* @package s2Member\No_Cache
				* @since 3.5
				*
				* @attaches-to: ``add_action("init");``
				*
				* @return null
				*/
				public static function no_cache ()
					{
						do_action ("ws_plugin__s2member_before_no_cache", get_defined_vars ());
						/**/
						c_ws_plugin__s2member_no_cache::no_cache_constants (); /* This first. */
						c_ws_plugin__s2member_no_cache::no_cache_headers (); /* Now run headers. */
						/**/
						do_action ("ws_plugin__s2member_after_no_cache", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
				/**
				* Defines compatible cache constants for s2Member.
				*
				* This is compatible with Quick Cache and also with WP Super Cache.
				* Quick Cache uses: ``QUICK_CACHE_ALLOWED``, and Super Cache uses: ``DONOTCACHEPAGE``.
				* Actually, Quick Cache is compatible with either of these defined constants.
				*
				* Always disallow caching for logged in users and GET requests with `/?s2member` systematic use.
				* For clarity on the systematic use with s2member in the request, see: `/classes/systematics.inc.php`.
				* Also disallow caching if the ``$no_cache`` param is passed in as true by other routines.
				* BUT, always obey the `qcAC` param that specifically allows caching.
				*
				* This function is also called upon by other routines that protect members-only content areas.
				* Members-only content areas should never be cached. In other words, there are some important supplemental
				* routines that occur outside the scope of this single function. This function is called upon by those other
				* targeted routines, to handle the cache constants when they are required.
				*
				* @package s2Member\No_Cache
				* @since 3.5
				*
				* @param bool $no_cache Optional. Defaults to false. If true, force no-cache headers if at all possible.
				* @return bool This function will always return `true`.
				*
				* @see s2Member\URIs\c_ws_plugin__s2member_ruris::check_ruri_level_access()
				* @see s2Member\Categories\c_ws_plugin__s2member_catgs::check_catg_level_access()
				* @see s2Member\Tags\c_ws_plugin__s2member_ptags::check_ptag_level_access()
				* @see s2Member\Posts\c_ws_plugin__s2member_posts::check_post_level_access()
				* @see s2Member\Pages\c_ws_plugin__s2member_pages::check_page_level_access()
				* @see s2Member\IP_Restrictions\c_ws_plugin__s2member_ip_restrictions::ip_restrictions_ok()
				* @see s2Member\Files\c_ws_plugin__s2member_files::file_download_key()
				* @see Button/Form/Shortcode Generators.
				*/
				public static function no_cache_constants ($no_cache = FALSE)
					{
						static $once; /* We only need to set these Constants once. */
						/**/
						eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_no_cache_constants", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if (!$once && empty ($_GET["qcAC"]) && ($no_cache || is_user_logged_in () || (!empty ($_SERVER["QUERY_STRING"]) && strpos ($_SERVER["QUERY_STRING"], "s2member") === 0 && c_ws_plugin__s2member_utils_conds::is_site_root ($_SERVER["REQUEST_URI"]))))
							{
								/**
								* No-cache Constant for Quick Cache.
								*
								* @package s2Member\No_Cache
								* @since 3.5
								*
								* @var bool
								*/
								if (!defined ("QUICK_CACHE_ALLOWED"))
									define ("QUICK_CACHE_ALLOWED", false);
								/**
								* No-cache for other cache plugins.
								*
								* @package s2Member\No_Cache
								* @since 3.5
								*
								* @var bool
								*/
								if (!defined ("DONOTCACHEPAGE"))
									define ("DONOTCACHEPAGE", true);
								/**/
								$GLOBALS["ws_plugin__s2member_no_cache_headers_selective"] = true;
								/**/
								$once = true; /* Only need to set these Constants one time. */
								/**/
								do_action ("ws_plugin__s2member_during_no_cache_constants", get_defined_vars ());
							}
						/**/
						do_action ("ws_plugin__s2member_after_no_cache_constants", get_defined_vars ());
						/**/
						return true; /* Always return true. */
					}
				/**
				* Sends Cache-Control ( no-cache ) headers.
				*
				* This uses the ``nocache_headers()`` function provided by WordPress®.
				* This is compatible with the Quick Cache parameter `?qcABC=1` as well.
				* Always obey the `qcABC` param that specifically allows browser caching.
				*
				* @package s2Member\No_Cache
				* @since 3.5
				*
				* @return bool This function will always return `true`.
				*/
				public static function no_cache_headers ()
					{
						static $once; /* We only need to set these headers one time. */
						/**/
						eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_no_cache_headers", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						$using_selective_behavior = apply_filters ("ws_plugin__s2member_no_cache_headers_selective", false, get_defined_vars ());
						$selective = @$GLOBALS["ws_plugin__s2member_no_cache_headers_selective"]; /* Selective ( i.e. required )? */
						/**/
						if (!$once && empty ($_GET["qcABC"]) && (!$using_selective_behavior || $selective) && !apply_filters ("ws_plugin__s2member_disable_no_cache_headers", false, get_defined_vars ()))
							{
								$no_cache_headers_already_sent = false; /* Only if NOT already sent. Initialize this to a false value. */
								/**/
								foreach (headers_list () as $header) /* No-cache headers already sent? We need to check here. */
									if (stripos ($header, "no-cache") !== false) /* No-cache headers already sent? */
										{
											$no_cache_headers_already_sent = true; /* Yep, sent. */
											break; /* Break now, no need to continue any further. */
										}
								if (!$no_cache_headers_already_sent) /* Check here. */
									nocache_headers (); /* Only if NOT already sent. */
								/**/
								$once = true; /* Only set these headers once. */
								/**/
								do_action ("ws_plugin__s2member_during_no_cache_headers", get_defined_vars ());
							}
						/**/
						do_action ("ws_plugin__s2member_after_no_cache_headers", get_defined_vars ());
						/**/
						return true; /* Always return true. */
					}
			}
	}
?>