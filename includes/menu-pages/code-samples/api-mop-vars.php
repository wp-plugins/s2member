-----------------------------------------------------------------------------------------------------------
These example redirection links include all possible MOP Variable variations in the query string.
-----------------------------------------------------------------------------------------------------------

	.../membership-options-page/?s2member_seeking=page-587&s2member_level_req=1
	.../membership-options-page/?s2member_seeking=post-545&s2member_level_req=2
	.../membership-options-page/?s2member_seeking=catg-698&s2member_level_req=4
	.../membership-options-page/?s2member_seeking=ptag-447&s2member_level_req=3
	.../membership-options-page/?s2member_seeking=page-887&s2member_ccap_req=music
	.../membership-options-page/?s2member_seeking=post-871&s2member_ccap_req=videos
	.../membership-options-page/?s2member_seeking=post-369&s2member_sp_req=369
	.../membership-options-page/?s2member_seeking=bbpress&s2member_level_req=1
	.../membership-options-page/?s2member_seeking=ruri-aHR0cDovL3d3dy5leGFtcGxlLmNvbS8&s2member_level_req=1
	.../membership-options-page/?s2member_seeking=file-example.zip&s2member_level_req=1

-----------------------------------------------------------------------------------------------------------

Here is a breakdown on each of these Variables:

	* `s2member_seeking` = [post|page|catg|ptag]-[ID number] ( Post ID, Page ID, Category ID, Tag ID )
		Or: `s2member_seeking` = ruri-[base64 encoded URI] ( only applies w/ Membership URI Restrictions )
		Or: `s2member_seeking` = file-[protected file name] ( only applies w/ Download Restrictions )
		Or: `s2member_seeking` = bbpress ( only applies when the s2Member -> bbPress Bridge is installed )
	* `s2member_level_req` = a Membership Level # required for access ( only applies to Membership Level Access )
	* `s2member_ccap_req` = a Custom Capability required for access ( only applies to Custom Capability Restrictions )
	* `s2member_sp_req` = a Specific Post/Page ID required ( only applies to Specific Post/Page Access Restrictions )

	`s2member_seeking` is always passed in; it is never excluded.
	`s2member_level_req`, `s2member_ccap_req`, `s2member_sp_req` are mutually exclusive. 
	 Only ONE of these three Variables will be passed in combination with `s2member_seeking`.

-----------------------------------------------------------------------------------------------------------

Example PHP code ( and conditionals ) that could be implemented within your Membership Options Page.
	( TIP: these code samples are intended for "advanced" site owners and developers )

<?php /* Parse s2Member's MOP Vars into local variables. */
	list($seeking, $id) = preg_split("/-/", $_GET["s2member_seeking"], 2);
	list($seeking, $uri) = preg_split("/-/", $_GET["s2member_seeking"], 2);
	list($seeking, $file) = preg_split("/-/", $_GET["s2member_seeking"], 2);
	$level_req = $_GET["s2member_level_req"];
	$ccap_req = $_GET["s2member_ccap_req"];
	$sp_req = $_GET["s2member_sp_req"]; ?>

-----------------------------------------------------------------------------------------------------------
You probably will NOT use all of these conditionals; but this attempts to provide several examples for you.
-----------------------------------------------------------------------------------------------------------

<?php if(is_user_logged_in() && $level_req){ /* A Member is already logged-in. */ ?>

	The content you requested, requires an upgrade to Level# <?php echo $level_req; ?>.

<?php else if(is_user_logged_in() && $ccap_req){ /* A Member is already logged-in. */ ?>

	The content you requested, requires an upgrade; for access to: <?php echo $ccap_req; ?>.

<?php else if(is_user_logged_in() && $sp_req){ /* A Member is already logged-in. */ ?>

	The content you requested, requires a separate purchase of: <?php echo get_the_title($id); ?>.

<?php else if(preg_match("/^(post|page)$/", $seeking) && $id && $level_req){ /* A Post or Page ( i.e. post|page ). */ ?>

	The Post/Page you were looking for ( <?php echo get_the_title($id); ?> ) requires access @ Level #<?php echo $level_req; ?>.

<?php } else if($seeking === "catg" && $id && $level_req && !is_wp_error($catg_name = get_term_field("name", $id, "category"))){ ?>

	The Category you were looking for ( <?php echo $catg_name; ?> ) requires access @ Level #<?php echo $level_req; ?>.

<?php } else if($seeking === "ptag" && $id && $level_req && !is_wp_error($ptag_name = get_term_field("name", $id, "post_tag"))){ ?>

	The Tag you were looking for ( <?php echo $ptag_name; ?> ) requires access @ Level #<?php echo $level_req; ?>.

<?php } else if($seeking === "ruri" && $uri && $level_req && ($uri = base64_decode($uri))){ /* Decoding the URI value. */ ?>

	The URI you were looking for ( <?php echo $uri; ?> ) requires access @ Level #<?php echo $level_req; ?>.

<?php } else if($seeking && $id && $sp_req){ /* Specific Post/Page Access ( i.e. s2member_sp_req ) */ ?>

	Buy Now: The Post/Page you were looking for ( <?php echo get_the_title($id); ?> ) requires payment.

<?php } else { /* It's good to include a general default handler. */ ?>

	Buy Now ( general default ).

<?php } ?>
	
-----------------------------------------------------------------------------------------------------------
* All of the conditional examples above are 100% completely optional ( for advanced site owners ).
 By default, s2Member will simply display your Membership Options Page; in its entirety.

* If you DO implement PHP conditionals within a Post/Page, you'll need this plugin.
 See: http://wordpress.org/extend/plugins/php-execution-plugin/