<?php if (is_user_logged_in() && current_user_can("access_s2member_level1")){ ?>
	Some content for Members who are logged in with an s2Member Level >= 1.
<?php } else { ?>
	Some public content.
<?php } ?>