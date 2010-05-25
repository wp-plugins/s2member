<?php if (S2MEMBER_CURRENT_USER_ACCESS_LEVEL === 4){ ?>
	A Member has an Access Level of 4.
<?php } else if (S2MEMBER_CURRENT_USER_ACCESS_LEVEL === 3){ ?>
	A Member has an Access Level of 3.
<?php } else if (S2MEMBER_CURRENT_USER_ACCESS_LEVEL === 2){ ?>
	A Member has an Access Level of 2.
<?php } else if (S2MEMBER_CURRENT_USER_ACCESS_LEVEL === 1){ ?>
	A Member has an Access Level of 1.
<?php } else if(S2MEMBER_CURRENT_USER_ACCESS_LEVEL === 0){ ?>
	A User is logged in as a Free Subscriber.
<?php } else if(S2MEMBER_CURRENT_USER_ACCESS_LEVEL === -1){ ?>
	A User is not logged in at all.
<?php } ?>