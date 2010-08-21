[s2All current_user_cannot="access_s2member_level4" current_user_can="access_s2member_level2"]

	This Member CANNOT access Level #4,
	but... they CAN access Level #2.

	[_s2All current_user_can="access_s2member_ccap_free_gift"]
		
		Display free gift here. This is a Custom Capability check, using a nested Conditional.
		Notice that NESTED Conditionals require a preceding underscore ( i.e. _s2All ).
			You can go up to three levels deep ( ___s2All ).
				
					Nested PayPal Form/Button Shortcodes ARE fine too.
					However, you do NOT need a preceding underscore on Form/Button codes. Or any other Shortcode for that matter.
					You ONLY need the preceding underscore on _s2All _s2Any Conditionals that are being nested into each other.
					
					( Hi [s2Get constant="S2MEMBER_CURRENT_USER_DISPLAY_NAME" /], upgrade now to Level #4! )
					[s2Member-PayPal-Button level="4" ra="49.95" ... /]
						~ see, this will work just fine.
				
	[/_s2All]

[/s2All]

[s2All current_user_cannot="access_s2member_level4" current_user_cannot="access_s2member_level3" current_user_cannot="access_s2member_level2" current_user_can="access_s2member_level1"]
	Content for Members who can ONLY access Level #1 on this Blog.
[/s2All]

[s2All current_user_is="s2member_level1"]
	Content for Members who can ONLY access Level #1 on this Blog.
		~ Same thing, only this is MUCH simpler, less typing.
[/s2All]