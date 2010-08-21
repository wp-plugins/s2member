<?php if (current_user_can("access_s2member_level1")){ ?>
	
	Some premium content for all Level 1 Members.

	<?php if (current_user_can("access_s2member_ccap_music")){ ?>
		Display links for music as well.
	<?php } ?>
	
	<?php if (current_user_can("access_s2member_ccap_videos")){ ?>
		Display videos as well.
	<?php } ?>

<?php } else { ?>
	Some public content.
<?php } ?>

---- s2member Shortcode Equivalents ----

[s2All current_user_can="access_s2member_level1"]

	Some premium content for all Level 1 Members.

	[_s2All current_user_can="access_s2member_ccap_music"]
		Display links for music as well.
	[/_s2All]

	[_s2All current_user_can="access_s2member_ccap_videos"]
		Display videos as well.
	[/_s2All]

[/s2All]

[s2All current_user_cannot="access_s2member_level1"]
	Some public content.
[/s2All]