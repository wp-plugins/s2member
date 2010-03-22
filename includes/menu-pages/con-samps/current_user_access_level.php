<?php if (S2MEMBER_CURRENT_USER_ACCESS_LEVEL === 4){ ?>
  Member has an access level of 4.
<?php } else if (S2MEMBER_CURRENT_USER_ACCESS_LEVEL === 3){ ?>
  Member has an access level of 3.
<?php } else if (S2MEMBER_CURRENT_USER_ACCESS_LEVEL === 2){ ?>
  Member has an access level of 2.
<?php } else if (S2MEMBER_CURRENT_USER_ACCESS_LEVEL === 1){ ?>
  Member has an access level of 1.
<?php } else if(S2MEMBER_CURRENT_USER_ACCESS_LEVEL === 0){ ?>
  User is logged in but is not a member.
<?php } else if(S2MEMBER_CURRENT_USER_ACCESS_LEVEL === -1){ ?>
  User is not logged in.
<?php } ?>