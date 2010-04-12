<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
	<input type="hidden" name="business" value="paypal@example.com">
	<input type="hidden" name="cmd" value="_xclick-subscriptions">
	<!-- Instant Payment Notification / Return Details -->
	<input type="hidden" name="notify_url" value="http://www.example.com/?s2member_paypal_notify=1">
	<input type="hidden" name="cancel_return" value="http://www.example.com">
	<input type="hidden" name="return" value="http://www.example.com/?s2member_paypal_return=1">
	<input type="hidden" name="rm" value="2">
	<!-- Identify / Customize The Checkout Fields. -->
	<input type="hidden" name="no_shipping" value="1">
	<input type="hidden" name="no_note" value="1">
	<input type="hidden" name="custom" value="www.example.com">
	<input type="hidden" name="currency_code" value="USD">
	<input type="hidden" name="page_style" value="paypal">
	<input type="hidden" name="item_name" value="Paid Membership ( $25/mo )">
	<input type="hidden" name="item_number" value="1">
	<!-- Identify / Update An Existing Free Subscriber After Checkout. -->
	<input type="hidden" name="on0" value="Update Subscriber ID">
	<input type="hidden" name="os0" value="<?php echo S2MEMBER_CURRENT_USER_SUBSCR_ID; ?>">
	<!-- Set The Terms Of The New Subscription. -->
	<input type="hidden" name="modify" value="0">
	<input type="hidden" name="src" value="1">
	<input type="hidden" name="sra" value="1">
	<input type="hidden" name="a3" value="25">
	<input type="hidden" name="p3" value="1">
	<input type="hidden" name="t3" value="M">
	<!-- Display The Subscription Button. -->
	<input type="image" alt="PayPal®" style="border:0;" src="https://www.paypal.com/en_GB/i/btn/btn_xpressCheckout.gif">
</form>
-------------------------------------------------------------------------------------------------
SO THE RELEVANT SECTION IN THE EXAMPLE GIVEN ABOVE IS:
	<input type="hidden" name="on0" value="Update Subscriber ID">
	<input type="hidden" name="os0" value="<?php echo S2MEMBER_CURRENT_USER_SUBSCR_ID; ?>">