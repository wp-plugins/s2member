<a href="#" onclick="if(!window.open('<?php echo S2MEMBER_CURRENT_USER_PROFILE_MODIFICATION_PAGE_URL; ?>',
'_popup', 'height=350,width=400,left=100,screenX=100,top=100,screenY=100,
location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1'))
alert('Please disable popup blockers and try again!'); 
return false;">Modify Profile</a>

This could also be embedded into a Post/Page using an IFRAME tag. So if you don't like using pop-ups, try this:
<iframe src="<?php echo S2MEMBER_CURRENT_USER_PROFILE_MODIFICATION_PAGE_URL; ?>" scrolling="auto" style="width:100%; height:325px; border:1px solid #666666;"></iframe>