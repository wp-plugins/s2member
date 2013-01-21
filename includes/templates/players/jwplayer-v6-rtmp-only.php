<?php
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit("Do not access this file directly.");
?>

<div id="%%player_id%%"></div>
<script type="text/javascript" src="%%player_path%%"></script>
<script type="text/javascript">
	jwplayer('%%player_id%%').setup({
	
			playlist:
				[{
					/* List all available sources. */ sources:
						[
							{file: '%%streamer%%/%%prefix%%%%file%%'}
						]
				}],
				
			image: '%%player_image%%',
			title: '%%player_title%%',
			
			controls: %%player_controls%%,
			height: %%player_height%%,
			skin: '%%player_skin%%',
			stretching: '%%player_stretching%%',
			width: %%player_width%%,
			
			autostart: %%player_autostart%%,
			fallback: %%player_fallback%%,
			mute: %%player_mute%%,
			primary: '%%player_primary%%',
			repeat: %%player_repeat%%,
			startparam: '%%player_startparam%%'
		});
</script>