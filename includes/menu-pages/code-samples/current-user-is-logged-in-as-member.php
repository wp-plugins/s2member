<?php if (S2MEMBER_CURRENT_USER_IS_LOGGED_IN_AS_MEMBER){ ?>
  A Member is logged in, with an Access Level >= 1.
<?php } ?>

---- s2member Shortcode Equivalent ----

[s2All is_user_logged_in="yes" current_user_can="access_s2member_level1"]
	content goes here
[/s2All]