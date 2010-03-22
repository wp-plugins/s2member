/*
Copyright: © 2009 WebSharks, Inc. ( coded in the USA )
<mailto:support@websharks-inc.com> <http://www.websharks-inc.com/>

Released under the terms of the GNU General Public License.
You should have received a copy of the GNU General Public License,
along with this software. In the main directory, see: /licensing/
If not, see: <http://www.gnu.org/licenses/>.
*/
/*
Global variables, duplicated from PHP Contants.
These are inserted dynamically.
*/
'%%globals%%';
/*
Other scripting routines handled on document ready state.
*/
jQuery(document).ready (function($)
	{
		/*
		Attach onclick handlers to download links.
		Members will need to confirm download processing.
		*/
		s2member_unique_files_downloaded = []; /* Maintains real-time counts. */
		/* This is used in case a user downloads multiple files from a single page. */
		/**/
		if (S2MEMBER_CURRENT_USER_IS_LOGGED_IN && S2MEMBER_CURRENT_USER_DOWNLOADS_CURRENTLY < S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED)
			{
				$('a[href*=s2member_file_download]:not(pre a, code a)').click (function()
					{
						if (!this.href.match (/s2member_free_file_download_key\=(.+)/))
							{
								var c = '** Please Confirm This File Download **\n\n';
								c += 'You\'ve downloaded ' + S2MEMBER_CURRENT_USER_DOWNLOADS_CURRENTLY + ' file' + ((S2MEMBER_CURRENT_USER_DOWNLOADS_CURRENTLY < 1 || S2MEMBER_CURRENT_USER_DOWNLOADS_CURRENTLY > 1) ? 's' : '') + ' in the last ' + S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED_DAYS + ' days.\n\n';
								c += 'You\'re entitled to ' + ((S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED_IS_UNLIMITED) ? 'unlimited' : S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED + ' unique') + ' downloads every ' + S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED_DAYS + ' day period.\n\n';
								/**/
								if (confirm(c)) /* Force the user to confirm before we allow processing. */
									{
										if ($.inArray (this.href, s2member_unique_files_downloaded) === -1) /* Real-time counting. */
											s2member_unique_files_downloaded.push (this.href), S2MEMBER_CURRENT_USER_DOWNLOADS_CURRENTLY++;
										return true; /* Allow processing. */
									}
								else /* Do not process. */
									return false;
							}
						else /* Else relax the user, this is free. */
							{
								var c = 'This is a FREE download for members.\n';
								c += 'It does not count against your membership entitlement.\n\n';
								c += '~Enjoy~';
								/**/
								if (confirm(c))
									return true;
								else /* ? */
									return false;
							}
					});
			}
		/*
		Disable s2member_file_download links inside of pre/code tags.
		*/
		$('pre a[href*=s2member_file_download], code a[href*=s2member_file_download]').click (function()
			{
				alert('This link within a Comment has been disabled intentionally by the s2Member software.');
				return false; /* Disable s2member_file_download links inside of pre/code tags. */
			});
	});