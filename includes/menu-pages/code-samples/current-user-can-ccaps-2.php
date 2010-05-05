<?php if (is_user_logged_in() && current_user_can("access_s2member_level1")){ ?>

	Some premium content for all Level 1 Members.

	<?php if (current_user_can("access_s2member_ccap_ebooks")){ ?>
		Display links for downloading your eBooks.
	<?php } else { ?>
		Insert a PayPal® Modification Button that includes the Custom Capability: ebooks
		This might read, "Upgrade Your Membership for access to my eBooks!".
	<? } ?>
	
	<?php if (current_user_can("access_s2member_ccap_reports")){ ?>
		Display links for accessing your reports.
	<?php } else { ?>
		Insert a PayPal® Modification Button that includes the Custom Capability: reports
		This might read, "Upgrade Your Membership for access to my reports!".
	<? } ?>

	<?php if (current_user_can("access_s2member_ccap_tips")){ ?>
		Display tips.
	<?php } else { ?>
		Insert a PayPal® Modification Button that includes the Custom Capability: tips
		This might read, "Upgrade Your Membership for access to my tips!".
	<? } ?>

<?php } else { ?>
	Some public content.
<?php } ?>