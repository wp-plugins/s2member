<?php $fields = unserialize(S2MEMBER_CURRENT_USER_FIELDS); ?>
<?php echo $fields["first_name"]; ?> <?php echo $fields["last_name"]; ?>
This would output the first and last name for the current user.

Custom Fields are also included in the unserialized array.
<?php print_r(unserialize(S2MEMBER_CURRENT_USER_FIELDS)); ?>
( Displays a full list of all array elements. )