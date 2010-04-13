Example #1, Allow all levels greater than or equal to 1 full access.

<?php if (current_user_can("access_s2member_level1")){ ?>
  Show premium members-only content to all members.
<?php } else { ?>
  Show non-member public content.
<?php } ?>

Example #2, Specific content for each member level.

<?php if (current_user_can("access_s2member_level4")){ ?>
  Show level 4 member content.
<?php } else if (current_user_can("access_s2member_level3")){ ?>
  Show level 3 member content.
<?php } else if (current_user_can("access_s2member_level2")){ ?>
  Show level 2 member content.
<?php } else if (current_user_can("access_s2member_level1")){ ?>
  Show level 1 member content.
<?php } else { ?>
  Show non-member content.
<?php } ?>

* Tip ( levels allow incremental access to areas of your site ).
- A user with level 4 access will also be able to access levels 1, 2 & 3.
- A user with level 3 access will also be able to access levels 1 & 2.
- A user with level 2 access will also be able to access level 1.
- A user with level 1 access will only be able to access level 1.

* WordPress® Administrators, Editors, Authors, and Contributors have level 4 access.

* WordPress® Subscribers are not allowed membership access. They must be promoted to a member.
However, if you set `Allow Free Subscribers` to `Yes`, then Free Subscribers WILL be able to access
your Login Welcome Page, but that is all. See `s2Member->General Options->Login Welcome Page`.