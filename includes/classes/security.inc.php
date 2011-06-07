<?php
/**
* s2Member's Security Gate.
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
* @package s2Member\Security
* @since 3.5
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_security"))
	{
		/**
		* s2Member's Security Gate.
		*
		* @package s2Member\Security
		* @since 3.5
		*/
		class c_ws_plugin__s2member_security
			{
				/**
				* s2Member's Security Gate ( protects WordPress® queries ).
				*
				* @package s2Member\Security
				* @since 3.5
				*
				* @attaches-to: ``add_action("pre_get_posts");``
				*
				* @param obj $wp_query Global instance of ``$wp_query``, by reference.
				* @return null
				*/
				public static function security_gate_query (&$wp_query = FALSE)
					{
						do_action ("ws_plugin__s2member_before_security_gate_query", get_defined_vars ());
						/**/
						c_ws_plugin__s2member_querys::query_level_access ($wp_query); /* By reference. */
						/**/
						do_action ("ws_plugin__s2member_after_security_gate_query", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
				/**
				* s2Member's Security Gate ( protects WordPress® content ).
				*
				* @package s2Member\Security
				* @since 3.5
				*
				* @attaches-to: ``add_action("template_redirect");``
				*
				* @return null
				*/
				public static function security_gate () /* s2Member's Security Gate. */
					{
						do_action ("ws_plugin__s2member_before_security_gate", get_defined_vars ());
						/*
						Category Level Restrictions ( inclusively ).
						- Including URI protections too.
						*/
						if (is_category ()) /* Categories. */
							c_ws_plugin__s2member_catgs::check_catg_level_access ();
						/*
						Tag Level Restrictions ( inclusively ).
						- Including URI protections too.
						*/
						else if (is_tag ()) /* Tags. */
							c_ws_plugin__s2member_ptags::check_ptag_level_access ();
						/*
						Post Level Restrictions ( inclusively, even Custom Post Types ).
						- Including Category, Tag, URI, Capability, and Specifics too.
						*/
						else if (is_single ()) /* Posts & Custom Types. */
							c_ws_plugin__s2member_posts::check_post_level_access ();
						/*
						Page Level Restrictions ( inclusively ).
						- Including Category, Tag, URI, Capability, and Specifics too.
						*/
						else if (is_page ()) /* Pages. */
							c_ws_plugin__s2member_pages::check_page_level_access ();
						/*
						Else just apply URI Level Restrictions ( only URIs ).
						*/
						else /* This optimizes things nicely. */
							c_ws_plugin__s2member_ruris::check_ruri_level_access ();
						/*
						Hook after Security Gate.
						*/
						do_action ("ws_plugin__s2member_after_security_gate", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
			}
	}
?>