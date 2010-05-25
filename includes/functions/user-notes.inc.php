<?php
/*
Copyright: © 2009 WebSharks, Inc. ( coded in the USA )
<mailto:support@websharks-inc.com> <http://www.websharks-inc.com/>

Released under the terms of the GNU General Public License.
You should have received a copy of the GNU General Public License,
along with this software. In the main directory, see: /licensing/
If not, see: <http://www.gnu.org/licenses/>.
*/
/*
Direct access denial.
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit;
/*
Append a note onto a specific User/Member's account.
*/
function ws_plugin__s2member_append_user_notes ($user_id = FALSE, $notes = FALSE)
	{
		do_action ("s2member_before_append_user_notes", get_defined_vars ());
		/**/
		if ($user_id && $notes && is_string ($notes)) /* Must have these. */
			{
				$notes = trim (get_usermeta ($user_id, "s2member_notes") . "\n" . $notes);
				$notes = apply_filters ("s2member_append_user_notes", $notes, get_defined_vars ());
				update_usermeta ($user_id, "s2member_notes", $notes);
			}
		/**/
		return $notes; /* Return full set of notes. */
	}
/*
Clear specific notes from a User/Member's account; based on line-by-line regex.
*/
function ws_plugin__s2member_clear_user_note_lines ($user_id = FALSE, $regex = FALSE)
	{
		do_action ("s2member_before_clear_user_note_lines", get_defined_vars ());
		/**/
		if ($user_id && $regex && is_string ($regex) && ($lines = array ()))
			{
				/* Careful here to preserve empty lines. */
				$notes = trim (get_usermeta ($user_id, "s2member_notes"));
				foreach (preg_split ("/\n/", $notes) as $line)
					if (!preg_match ($regex, $line))
						$lines[] = $line;
				/**/
				$notes = apply_filters ("s2member_clear_user_note_lines", trim (implode ("\n", $lines)), get_defined_vars ());
				update_usermeta ($user_id, "s2member_notes", $notes);
			}
		/**/
		return $notes; /* Return full set of notes. */
	}
?>