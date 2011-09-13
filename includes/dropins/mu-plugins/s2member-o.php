<?php
/**
* WordPress® with s2Member only.
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
* @package s2Member\Only
* @since 110912
*/
if (!empty ($_GET["s2member_only"]) && /* Not in admin panels. */ !is_admin ())
	{
		if (!class_exists ("c_ws_plugin__s2member_only"))
			{
				/**
				* WordPress® with s2Member only.
				*
				* @package s2Member\Only
				* @since 110912
				*/
				class c_ws_plugin__s2member_only
					{
						/*
						* s2Member plugin only, filter.
						*
						* The `%s2member%` Replacement Code is filled before
						* this file is copied into the `/mu-plugins/` directory for WordPress®.
						*
						* @package s2Member\Only
						* @since 110912
						*
						* @return array Array with s2Member plugin only.
						*/
						function filter () /* s2Member plugin only. */
							{
								return array ("%%s2member%%");
							}
						/*
						* s2Member only, if active.
						*
						* The `%s2member%` Replacement Code is filled before
						* this file is copied into the `/mu-plugins/` directory for WordPress®.
						*
						* @package s2Member\Only
						* @since 110912
						*
						* @return null
						*/
						function if_active () /* s2Member only, if active. */
							{
								$active_plugins = is_multisite () ? wp_get_active_network_plugins () : array ();
								$active_plugins = array_merge ($active_plugins, wp_get_active_and_valid_plugins ());
								/**/
								if (in_array (WP_PLUGIN_DIR . "/%%s2member%%", $active_plugins) && !is_admin ())
									{
										add_filter ("pre_site_option_active_sitewide_plugins", "c_ws_plugin__s2member_only::filter", 100);
										add_filter ("pre_option_active_plugins", "c_ws_plugin__s2member_only::filter", 100);
									}
								/**/
								return; /* Return for uniformity. */
							}
					}
			}
		/**/
		c_ws_plugin__s2member_only::if_active (); /* s2Member only, if active. */
	}
?>