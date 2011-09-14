<?php
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit("Do not access this file directly.");

global $base; /* A Multisite ``$base`` configuration? */
$ws_plugin__s2member_temp_s_base = (!empty ($base)) ? $base : parse_url (network_home_url ("/"), PHP_URL_PATH);
/* The function ``network_home_url ()`` defaults to ``home_url ()`` on standard WordPress® installs. */
/* Must use the `home` URL here, because that's what WordPress® uses in it's `mod_rewrite` file. */
?>

Options +FollowSymLinks -MultiViews

<IfModule mod_rewrite.c>
	RewriteEngine On
	RewriteBase <?php echo $ws_plugin__s2member_temp_s_base . "\n"; ?>

	RewriteCond %{ENV:s2member_file_ms_scan} !^complete$
	RewriteCond %{THE_REQUEST} ^(?:GET|HEAD)(?:[\ ]+)(?:<?php echo preg_quote ($ws_plugin__s2member_temp_s_base, " "); ?>)([_0-9a-zA-Z\-]+/)(?:wp-content/)
	RewriteRule ^(.*)$ - [E=s2member_file_ms_scan:complete,E=s2_blog:%1]

	RewriteCond %{ENV:s2member_file_download_scan} !^complete$
	RewriteRule ^(.*)$ - [E=s2member_file_download_scan:complete,E=s2member_file_download:$1]

	RewriteCond %{ENV:s2member_file_download} ^(.*?)(?:s2member-file-remote/)(.+)$
	RewriteRule ^(.*)$ - [N,E=s2member_file_download:%1%2,E=s2member_file_remote:&s2member_file_remote=yes]

	RewriteCond %{ENV:s2member_file_download} ^(.*?)(?:s2member-file-remote-(.+?)/)(.+)$
	RewriteRule ^(.*)$ - [N,E=s2member_file_download:%1%3,E=s2member_file_remote:&s2member_file_remote=%2]

	RewriteCond %{ENV:s2member_file_download} ^(.*?)(?:s2member-file-inline/)(.+)$
	RewriteRule ^(.*)$ - [N,E=s2member_file_download:%1%2,E=s2member_file_inline:&s2member_file_inline=yes]

	RewriteCond %{ENV:s2member_file_download} ^(.*?)(?:s2member-file-inline-(.+?)/)(.+)$
	RewriteRule ^(.*)$ - [N,E=s2member_file_download:%1%3,E=s2member_file_inline:&s2member_file_inline=%2]

	RewriteCond %{ENV:s2member_file_download} ^(.*?)(?:s2member-file-download-key-(.+?)/)(.+)$
	RewriteRule ^(.*)$ - [N,E=s2member_file_download:%1%3,E=s2member_file_download_key:&s2member_file_download_key=%2]

	RewriteRule ^(.*)$ %{ENV:s2_blog}?s2member_file_download=%{ENV:s2member_file_download}%{ENV:s2member_file_inline}%{ENV:s2member_file_download_key}%{ENV:s2member_file_remote} [QSA,L]
</IfModule>

<IfModule !mod_rewrite.c>
	deny from all
</IfModule>

<?php unset ($ws_plugin__s2member_temp_s_base); ?>