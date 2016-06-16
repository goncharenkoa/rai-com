do (window, $ = window.jQuery) ->
	page = $ document

	titleToSlug = (title) ->
		title = title.replace /[ -]+/g, ' '
		title = title.replace /[^A-Za-z0-9 ]/g, ''
		title = title.toLowerCase()
		title = title.replace /[ ]+/g, '-'
		title = title.replace /^-+|-+$/g, ''

	$ ->
		adminbar = $ '#wpadminbar'
		quickControls = $ 'ul.vp-quick-controls'
		vp = adminbar.find 'li#wp-admin-bar-velocitypage'
		panels = {}
		panels.transition = $ '.vp-transition-panel'
		panels.addnew = $ '.vp-addnew-panel'
		panelOpen = no
		addnewTitle = panels.addnew.find '.vp-addnew-title'
		addnewURL = panels.addnew.find '.vp-addnew-url span'
		addnewParent = panels.addnew.find '#vp-page-parent'
		pageControls = $ '.vp-page-controls'
		hovered = -> adminbar.find 'li.menupop.hover'

		updateNewURL = ->
			parent = addnewParent.find ':selected'
			parentSlug = if  parent.val() is '0' then '' else vpAllPageURLs[parent.val()]
			titleSlug = if titleToSlug(addnewTitle.val()).length then "#{titleToSlug addnewTitle.val()}/" else ''
			addnewURL.text "#{parentSlug}#{titleSlug}"
			addnewURL.parent().toggle( titleSlug isnt '' )

		openPanel = (panelName) ->
			closePanels()
			quickControls.hide()
			panels[panelName].show().addClass 'active'
			pageControls.trigger 'changePanel'
			panelOpen = yes
			hovered().removeClass 'hover'
			vp.addClass 'vp-hover'

		closePanels = ->
			panel.hide().removeClass 'active' for name,panel of panels
			panelOpen = no
			quickControls.show()
			vp.removeClass 'vp-hover'

		page.on "keyup", (e) ->
			closePanels() if panelOpen and 27 is e.which

		page.on "click", "#wp-admin-bar-velocitypage-choose", (e) ->
			e.preventDefault()
			openPanel 'transition'

		page.on "click", ".vp-panel-cancel a", (e) ->
			e.preventDefault()
			closePanels()

		page.on "click", "#wp-admin-bar-velocitypage-addnew", (e) ->
			e.preventDefault()
			openPanel 'addnew'
			panels.addnew.find '.vp-addnew-title'
			.focus()

		page.on "keyup", ".vp-addnew-panel .vp-addnew-title", updateNewURL
		page.on "change", addnewParent, updateNewURL

		if window.location.toString().indexOf('vp-instant-transition=1') isnt -1
			$('#wp-admin-bar-velocitypage-choose').click()
			if window.history and window.history.pushState
				window.history.replaceState {}, '', window.location.toString().replace( /[?&]vp-instant-transition=1/, '' )
