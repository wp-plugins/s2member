[s2All current_user_is="s2member_level1"]
	Content for Members at exactly Level# 1, on this Blog.
[/s2All]

[s2Any current_user_is="s2member_level2" current_user_is_for_blog="24,s2member_level2"]

	They are either a Level #2 Member on this Blog,
	OR ... they're at Level# 2 on Blog ID# 24 ( i.e. Multisite Networking )

		* Note the use of `s2Any` here. True if ANY/either condition is met.

[/s2Any]

[s2Any current_user_is="s2member_level3" current_user_is="s2member_level4"]

	Content for Level #3 - and/or - Level #4 Members. Either/or.

	Hi there [s2Get constant="S2MEMBER_CURRENT_USER_DISPLAY_NAME" /].
	You have a [s2Get constant="S2MEMBER_CURRENT_USER_ACCESS_LABEL" /] Membership.

		^ This uses the s2Get Shortcode to retrive the value of s2Member API Constants.
			These are also documented under: `s2Member -> API Scripting`.

		So, this might come out to something like:
			`Hi there John.
			You have a Gold Membership.`

[/s2Any]