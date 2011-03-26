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
	exit ("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_utils_time"))
	{
		class c_ws_plugin__s2member_utils_time
			{
				/*
				Function that determines the difference between two timestamps. Returns the difference in a human readable format.
				Supports: minutes, hours, days, weeks, months, and years. This is an improvement on WordPress® human_time_diff().
				This returns an "approximate" time difference. Rounded to the nearest minute, hour, day, week, month, year.
				*/
				public static function approx_time_difference ($from = FALSE, $to = FALSE)
					{
						$from = (!$from) ? strtotime ("now") : (int)$from;
						$to = (!$to) ? strtotime ("now") : (int)$to;
						/**/
						if (($difference = abs ($to - $from)) < 3600)
							{
								$m = (int)round ($difference / 60);
								/**/
								$since = ($m < 1) ? "less than a minute" : $since;
								$since = ($m === 1) ? "1 minute" : $since;
								$since = ($m > 1) ? $m . " minutes" : $since;
								$since = ($m >= 60) ? "about 1 hour" : $since;
							}
						else if ($difference >= 3600 && $difference < 86400)
							{
								$h = (int)round ($difference / 3600);
								/**/
								$since = ($h === 1) ? "1 hour" : $since;
								$since = ($h > 1) ? $h . " hours" : $since;
								$since = ($h >= 24) ? "about 1 day" : $since;
							}
						else if ($difference >= 86400 && $difference < 604800)
							{
								$d = (int)round ($difference / 86400);
								/**/
								$since = ($d === 1) ? "1 day" : $since;
								$since = ($d > 1) ? $d . " days" : $since;
								$since = ($d >= 7) ? "about 1 week" : $since;
							}
						else if ($difference >= 604800 && $difference < 2592000)
							{
								$w = (int)round ($difference / 604800);
								/**/
								$since = ($w === 1) ? "1 week" : $since;
								$since = ($w > 1) ? $w . " weeks" : $since;
								$since = ($w >= 4) ? "about 1 month" : $since;
							}
						else if ($difference >= 2592000 && $difference < 31556926)
							{
								$m = (int)round ($difference / 2592000);
								/**/
								$since = ($m === 1) ? "1 month" : $since;
								$since = ($m > 1) ? $m . " months" : $since;
								$since = ($m >= 12) ? "about 1 year" : $since;
							}
						else if ($difference >= 31556926) /* Years. */
							{
								$y = (int)round ($difference / 31556926);
								/**/
								$since = ($y === 1) ? "1 year" : $since;
								$since = ($y > 1) ? $y . " years" : $since;
							}
						/**/
						return $since;
					}
				/*
				Calculate Auto-EOT Time, based on last_payment_time, period1, and period3.
				Used by s2Member's built-in Auto-EOT System, and also by its IPN routines.
					last_payment_time can be forced w/ $lpt ( i.e. for delayed eots )
				*/
				public static function auto_eot_time ($user_id = FALSE, $period1 = FALSE, $period3 = FALSE, $eotper = FALSE, $lpt = FALSE)
					{
						if ($user_id && ($user = new WP_User ($user_id)) && $user->ID) /* Valid user_id? */
							{
								$registration_time = strtotime ($user->user_registered);
								$last_payment_time = get_user_option ("s2member_last_payment_time", $user_id);
								$last_payment_time = ((int)$lpt) ? (int)$lpt : (int)$last_payment_time;
								/**/
								if (! ($p1_time = 0) && ($period1 = trim (strtoupper ($period1))))
									{
										list ($num, $span) = preg_split ("/ /", $period1, 2);
										/**/
										$days = 0; /* Days start at 0. */
										/**/
										if (is_numeric ($num) && !is_numeric ($span))
											{
												$days = ($span === "D") ? 1 : $days;
												$days = ($span === "W") ? 7 : $days;
												$days = ($span === "M") ? 30 : $days;
												$days = ($span === "Y") ? 365 : $days;
											}
										/**/
										$p1_days = (int)$num * (int)$days;
										$p1_time = $p1_days * 86400;
									}
								/**/
								if (! ($p3_time = 0) && ($period3 = trim (strtoupper ($period3))))
									{
										list ($num, $span) = preg_split ("/ /", $period3, 2);
										/**/
										$days = 0; /* Days start at 0. */
										/**/
										if (is_numeric ($num) && !is_numeric ($span))
											{
												$days = ($span === "D") ? 1 : $days;
												$days = ($span === "W") ? 7 : $days;
												$days = ($span === "M") ? 30 : $days;
												$days = ($span === "Y") ? 365 : $days;
											}
										/**/
										$p3_days = (int)$num * (int)$days;
										$p3_time = $p3_days * 86400;
									}
								/**/
								if (!$last_payment_time) /* If there's been no payment yet.
								After p1, if there was a p1. Otherwise, reg. time + 1 day grace. */
									$auto_eot_time = $registration_time + $p1_time + 86400;
								/**/
								/* Else if p1, and last payment within p1, last + p1 + 1 day grace. */
								else if ($p1_time && $last_payment_time <= $registration_time + $p1_time)
									$auto_eot_time = $last_payment_time + $p1_time + 86400;
								/**/
								else /* Otherwise, after last payment + p3 + 1 day grace. */
									$auto_eot_time = $last_payment_time + $p3_time + 86400;
							}
						/**/
						else if ($eotper) /* Otherwise, if we have a specific EOT period; calculate from today. */
							{
								if (! ($eot_time = 0) && ($eotper = trim (strtoupper ($eotper))))
									{
										list ($num, $span) = preg_split ("/ /", $eotper, 2);
										/**/
										$days = 0; /* Days start at 0. */
										/**/
										if (is_numeric ($num) && !is_numeric ($span))
											{
												$days = ($span === "D") ? 1 : $days;
												$days = ($span === "W") ? 7 : $days;
												$days = ($span === "M") ? 30 : $days;
												$days = ($span === "Y") ? 365 : $days;
											}
										/**/
										$eot_days = (int)$num * (int)$days;
										$eot_time = $eot_days * 86400;
									}
								/**/
								$auto_eot_time = strtotime ("now") + $eot_time + 86400;
							}
						/**/
						return ($auto_eot_time <= 0) ? strtotime ("now") : $auto_eot_time;
					}
				/*
				Function converts a term [D,W,M,Y,L,Day,Week,Month,Year,Lifetime] into Daily, Weekly, Monthly, Yearly, Lifetime.
				This function can also handle "Period Term" combinations. Where the Period will be stripped automatically before conversion.
				
				For example, "1 D", would become, just "Daily". Another example, "3 Y" would become "Yearly"; and "1 L", would become "Lifetime".
					Recurring examples: "2 W", becomes "Bi-Weekly", "3 M" becomes Quarterly, and "2 M" becomes "Bi-Monthly".
				*/
				public static function term_cycle ($term_or_period_term = FALSE, $directive = "recurring")
					{
						if ($directive === "recurring") /* recurring = Daily, Weekly, Bi-Weekly, Monthly, Bi-Monthly, Quarterly, Yearly, Lifetime. */
							{
								$paypal_term_cycles = array ("D" => "Daily", "W" => "Weekly", "M" => "Monthly", "Y" => "Yearly", "L" => "Lifetime", "DAY" => "Daily", "WEEK" => "Weekly", "MONTH" => "Monthly", "YEAR" => "Yearly", "Lifetime" => "Lifetime");
								$term_cycle = $paypal_term_cycles[strtoupper (preg_replace ("/^(.+?) /", "", $term_or_period_term))];
								$term_cycle = (strtoupper ($term_or_period_term) === "2 W") ? "Bi-Weekly" : $term_cycle;
								$term_cycle = (strtoupper ($term_or_period_term) === "2 M") ? "Bi-Monthly" : $term_cycle;
								$term_cycle = (strtoupper ($term_or_period_term) === "3 M") ? "Quarterly" : $term_cycle;
							}
						else if ($directive === "singular") /* singular = Day, Week, Month, Year, Lifetime. */
							{
								$paypal_term_cycles = array ("D" => "Day", "W" => "Week", "M" => "Month", "Y" => "Year", "L" => "Lifetime", "DAY" => "Day", "WEEK" => "Week", "MONTH" => "Month", "YEAR" => "Year", "Lifetime" => "Lifetime");
								$term_cycle = $paypal_term_cycles[strtoupper (preg_replace ("/^(.+?) /", "", $term_or_period_term))];
							}
						else if ($directive === "plural") /* plural = Days, Weeks, Months, Years, Lifetimes. */
							{
								$paypal_term_cycles = array ("D" => "Days", "W" => "Weeks", "M" => "Months", "Y" => "Years", "L" => "Lifetimes", "DAY" => "Days", "WEEK" => "Weeks", "MONTH" => "Months", "YEAR" => "Years", "Lifetime" => "Lifetimes");
								$term_cycle = $paypal_term_cycles[strtoupper (preg_replace ("/^(.+?) /", "", $term_or_period_term))];
							}
						/**/
						return$term_cycle; /* Return converted value. */
					}
				/*
				Function accepts a period, term, and recurring flag.
					Returns a full term explanation.
					Example: 2 months.
				*/
				public static function period_term ($period_term = FALSE, $recurring = FALSE)
					{
						list ($period, $term) = preg_split ("/ /", ($period_term = strtoupper ($period_term)), 2);
						$recurring = (strtoupper ($recurring) === "BN") ? (int)0 : (int)$recurring;
						/**/
						$cycle_recurring = c_ws_plugin__s2member_utils_time::term_cycle ($period_term, "recurring");
						$cycle_singular = c_ws_plugin__s2member_utils_time::term_cycle ($period_term, "singular");
						$cycle_plural = c_ws_plugin__s2member_utils_time::term_cycle ($period_term, "plural");
						/**/
						if ($recurring && in_array ($period_term, array ("1 D", "1 W", "2 W", "1 M", "2 M", "3 M", "1 Y")))
							$period_term = strtolower ($cycle_recurring); /* Results in an "ly" ending. */
						/**/
						else if ($recurring) /* Otherwise, it's recurring; but NOT an "ly" ending. */
							$period_term = strtolower ("every " . $period . " " . $cycle_plural);
						/**/
						else if (strtoupper ($term) === "L") /* One-payment for lifetime access. */
							$period_term = "lifetime"; /* Lifetime only. */
						/**/
						else /* Otherwise, this is NOT recurring. Results in X days/weeks/months/years/lifetime. */
							$period_term = strtolower ($period . " " . ( ($period <> 1) ? $cycle_plural : $cycle_singular));
						/**/
						return $period_term; /* Return converted value. */
					}
				/*
				Function accepts a billing amount, period, term, and recurring flag.
					Returns a full billing term explanation.
					Example: 1.00 for 2 months.
				*/
				public static function amount_period_term ($amount = FALSE, $period_term = FALSE, $recurring = FALSE)
					{
						list ($period, $term) = preg_split ("/ /", ($period_term = strtoupper ($period_term)), 2);
						$recurring = (strtoupper ($recurring) === "BN") ? (int)0 : (int)$recurring;
						/**/
						$cycle_recurring = c_ws_plugin__s2member_utils_time::term_cycle ($period_term, "recurring");
						$cycle_singular = c_ws_plugin__s2member_utils_time::term_cycle ($period_term, "singular");
						$cycle_plural = c_ws_plugin__s2member_utils_time::term_cycle ($period_term, "plural");
						/**/
						if ($recurring && in_array ($period_term, array ("1 D", "1 W", "2 W", "1 M", "2 M", "3 M", "1 Y")))
							$amount_period_term = number_format ($amount, 2, ".", "") . " / " . strtolower ($cycle_recurring);
						/**/
						else if ($recurring) /* Otherwise, it's recurring; but NOT an "ly" ending. */
							$amount_period_term = number_format ($amount, 2, ".", "") . " " . strtolower ("every " . $period . " " . $cycle_plural);
						/**/
						else if (strtoupper ($term) === "L") /* One-payment for lifetime access. */
							$amount_period_term = number_format ($amount, 2, ".", ""); /* Price only. */
						/**/
						else /* Otherwise, this is NOT recurring. Results in 0.00 for X days/weeks/months/years/lifetime. */
							$amount_period_term = number_format ($amount, 2, ".", "") . " for " . strtolower ($period . " " . ( ($period <> 1) ? $cycle_plural : $cycle_singular));
						/**/
						return $amount_period_term; /* Return converted value. */
					}
			}
	}
?>