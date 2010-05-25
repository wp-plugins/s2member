<?php $fields = json_decode(S2MEMBER_CURRENT_USER_FIELDS, true); ?>
<?php echo $fields["first_name"]; ?> <?php echo $fields["last_name"]; ?>
This would output the first and last name for the current user.

Custom Fields are also included in the JSON decoded array.
<?php print_r(json_decode(S2MEMBER_CURRENT_USER_FIELDS, true)); ?>
( Displays a full list of all associative array elements. )