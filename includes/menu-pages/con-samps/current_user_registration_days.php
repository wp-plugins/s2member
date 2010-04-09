<?php echo S2MEMBER_CURRENT_USER_REGISTRATION_DAYS; ?>
This may output something like: 120
( 120 days means they've been a Member for approx 4 months )

Here is a more practical example:

<?php if(S2MEMBER_CURRENT_USER_REGISTRATION_DAYS >= 90){ ?>
	Drip content to Members who are more than 90 days old.
<?php } else if(S2MEMBER_CURRENT_USER_REGISTRATION_DAYS >= 60){ ?>
	Drip content to Members who are more than 60 days old.
<?php } else if(S2MEMBER_CURRENT_USER_REGISTRATION_DAYS >= 30){ ?>
	Drip content to Members who are more than 30 days old.
<?php } else { ?>
	Initial content for newer Members.
<?php } ?>