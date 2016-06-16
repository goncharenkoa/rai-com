# Map jQuery to $ locally
$ = window.jQuery
$ ->
	editor = $ '#postdivrich'
	editor.after '
		<div class="postbox vp-postbox">
			<h3 class="hndle">Using VelocityPage</h3>
			<div class="inside">
				<p>This item&#8217;s content is controlled by
				VelocityPage.<br />Please <a href="#">view it on the front of the site</a>
				and edit from there!</p>
			</div>
		</div>'
	viewPostButton = $ '#view-post-btn a'
	postboxLink = $ '.vp-postbox a'
	postboxLink.attr 'href', viewPostButton.attr 'href'
