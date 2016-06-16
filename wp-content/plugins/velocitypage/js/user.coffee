# Map jQuery to $ locally
$ = window.jQuery
$ ->
	panelBody = null
	setActivePanel = ->
		panelBody = $ '.vp-panel.active .vp-panel-body'

	$window = $ window
	fields = $ '#velocity-page-wrapper'
	setActivePanel()

	pageControls = $ '.vp-page-controls'
	pageControls.on 'changePanel', ->
		setActivePanel()
		sizePanel()

	sizePanel = ->
		if panelBody.length
			panelBody.css
				height: "#{$window.height() - panelBody.position().top}px"

	debouncedSizePanel = _.debounce sizePanel, 50
	sizePanel()
	$window.resize debouncedSizePanel

	fields.fitVids()
