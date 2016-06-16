# Map jQuery to $ locally
$ = window.jQuery

# jQuery additions
$.fn.vpSetAllToMaxHeight = ->
	@css 'height', 'auto'
	@css 'min-height': Math.max.apply(@, $.map(@children(), (e) ->
		$(e).height()
	))

# Make the app globally accessible, but also give it a local shortcut
app = window.velocityPageApp =
	Models: []
	Views: []
	Collections: []
	expectations:
		items: {}
		rows: {}
	events: _.extend {}, Backbone.Events
	namespace: 'wp.adlabs.vp'

	log: ->
		console.log.apply console, arguments

	cleanURL: ->
		if window.history and window.history.pushState
			window.history.replaceState {}, '', window.location.toString().replace( /[?&]vp-transition=[a-z0-9-_]+/, '' )
			window.history.replaceState {}, '', window.location.toString().replace( /[?&]vp-layout=[a-z0-9-_]+/, '' )

	start: ->
		$ =>
			page = $ "body"
			page.on "click.#{@namespace}", "li.vp-start-page, #wp-admin-bar-velocitypage-edit", (e) ->
				e.preventDefault()
				$("li.vp-start-page").hide()
				$("#wp-admin-bar-velocitypage-edit").hide()
				$("li.vp-save-page").show()
				$("#wp-admin-bar-velocitypage-save").removeClass 'vp-hidden'
				$("#velocity-page-wrapper").addClass 'vp-editing'
				app.edit()
				$(".vp-page-controls").hide() if app.page.get 'demo'
				app.cleanURL() if app.page.get 'transitioning'

			page.on "click.#{@namespace}", "li.vp-save-page, #wp-admin-bar-velocitypage-save", (e) =>
				$('.vp-transition-panel').remove()
				$('#wp-admin-bar-velocitypage-choose').remove()
				e.preventDefault()
				@page.setMessage 'Saving...'
				savedMessage = =>
					@page.setMessage 'Saved!'
					clearMessage = =>
						@page.clearMessage()
					_.delay clearMessage, 2000
				saving = @page.save()
				saving.done =>
					@initialPage = @page.toJSON()
					_.delay savedMessage, 500
				saving.fail (response) =>
					message = response.message or 'saving failed'
					@page.setMessage 'ERROR: ' + message

	getSelectionPos: (start) ->
		x = 0
		y = 0
		range = undefined
		if window.getSelection
			sel = window.getSelection()
			if sel.rangeCount
				range = sel.getRangeAt(sel.rangeCount - 1).cloneRange()
				rect = range.getBoundingClientRect()
				if start
					x = rect.left
					y = rect.top
				else
					x = rect.right
					y = rect.bottom
		else if document.selection and document.selection.type isnt "Control"
			range = document.selection.createRange()
			range.collapse start
			x = range.boundingLeft
			y = range.boundingTop
		x: x
		y: y

	isTransparentColor: (color) ->
    color is 'transparent' or color.substring(0, 4) is 'rgba'

	getBackgroundColor: (item) ->
		window.getComputedStyle( item, null ).backgroundColor

	equalizeColumns: ->
		$('.row-wrap').each ->
			$(@).find('.item-area-wrap').vpSetAllToMaxHeight()

	template: (name) ->
		# This is just here so I can debug stuff more easily
		# Eventually the app will just call wp.template()
		app.log "Templating #{name}"
		app.log "ERROR: #tmpl-#{name} does not exist!" unless $("#tmpl-#{name}").length > 0
		wp.template name
	# This loads the data from pageData into Backbone models

	loadData: ->
		@page.set id: @pageData.id
		@page.set theme: @pageData.theme
		@page.set demo: @pageData.demo
		@page.set transitioning: @pageData.transitioning
		for name, field of @pageData.fields
			@page.fields[name] = new app.Models.Field field.data, field.options
		for name, rowArea of @pageData.rowAreas
			@page.rowAreas[name] = new @Collections.RowArea null, _.extend( rowArea.options, data: rowArea.data )
		@initialPage = @page.toJSON()

	mceInit: (selector) ->
		tinymce.init
			selector: selector
			inline: yes
			browser_spellcheck: yes
			plugins: 'autolink lists link anchor'
			toolbar1: 'bold italic link | bullist numlist'
			toolbar2: 'alignleft aligncenter alignright | removeformat'
			#toolbar1: 'bold italic blockquote alignleft aligncenter alignright bullist numlist'
			#toolbar2: 'undo redo removeformat formatselect subscript superscript alignjustify outdent indent forecolor backcolor table'
			menubar: no
			fixed_toolbar_container: '#vp-tinymce-toolbar'
			skin: 'lightgray'
			object_resizing: no
			relative_urls: no
			convert_urls: no
			valid_elements: '*[*]'
			setup: (editor) ->
				$toolbar = $ '#vp-tinymce-toolbar'
				editor.on "keyup mouseup", ->
					start = app.getSelectionPos yes
					end = app.getSelectionPos no
					app.log 'selectionPos yes', start
					app.log 'selectionPos no', end
					leftMin = _.max [ start.x, end.x ]
					leftMax = _.min [ start.x, end.x ]

					# We do this first, because the first time, we can't get the width unless we do
					$toolbar.css 'position', 'absolute'
					$toolbar.css
						left: (leftMin + ((leftMax - leftMin) / 2) - ( $toolbar.width() / 2 )) + 'px'
						top: (_.max([ end.y, start.y]) + 5 + $(window).scrollTop()) + 'px'
					app.log 'left', (leftMin + ((leftMax - leftMin) / 2) - ( $toolbar.width() / 2 )) + 'px'
					selection = window.getSelection()
					if selection.isCollapsed
						$toolbar.removeClass("fee-active").hide()
					else
						#$(".fee-element.fee-active").removeClass "fee-active"
						$toolbar.addClass("fee-active").show()
					app.log selection
				editor.on "mousedown blur", ->
					$toolbar.removeClass("fee-active").hide()
				editor.on "focus", (e) ->
					$(".fee-element.fee-active").removeClass "fee-active"
					$toolbar.addClass("fee-active").show()

				editor.on "blur", (e) ->
					$toolbar.removeClass("fee-active").hide()

				# $(window).on "resize", (e) ->
				# 	app.log 'Resize: removing TinyMCE styles'
				# 	$(".mce-tinymce, .mce-tinymce .mce-abs-layout, .mce-tinymce .mce-abs-layout-item, .mce-tinymce .mce-stack-layout").removeAttr "style"

	edit: ->
		@events.trigger 'editMode:on'
		$ =>
			# Pull in Font Awesome CSS
			$('head').append '<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">'
			# Pull in TinyMCE 4
			$.getScript('//tinymce.cachefly.net/4.0/tinymce.min.js').done =>
				@mceInit '.vp-editable.vp-block'
				@events.trigger 'mce:ready'
			@pageView.render()
			$('#velocity-page-wrapper').parents().each ->
				$parent = $ @
				# If someone has set "hidden" explicitly, they might need a clearfix
				# See the Genesis "Prose" theme
				$parent.addClass 'vp-clearfix' if 'hidden' is $parent.css 'overflow'
				$parent.css overflow: 'visible'

			ec = _.throttle @equalizeColumns, 100
			ecSlow = _.throttle @equalizeColumns, 2000
			ec()
			$win = $ window
			$win.on 'resize click keyup', ec
			$win.on 'mousemove', ecSlow

			unless @devMode
				window.onbeforeunload = =>
					'You have unsaved changes!' unless @page.get('demo') or _.isEqual @page.toJSON(), @initialPage
		@ # Chainable

###==============================================================

88b           d88                      88            88
888b         d888                      88            88
88`8b       d8'88                      88            88
88 `8b     d8' 88  ,adPPYba,   ,adPPYb,88  ,adPPYba, 88 ,adPPYba,
88  `8b   d8'  88 a8"     "8a a8"    `Y88 a8P_____88 88 I8[    ""
88   `8b d8'   88 8b       d8 8b       88 8PP""""""" 88  `"Y8ba,
88    `888'    88 "8a,   ,a8" "8a,   ,d88 "8b,   ,aa 88 aa    ]8I
88     `8'     88  `"YbbdP"'   `"8bbdP"Y8  `"Ybbd8"' 88 `"YbbdP"'

==============================================================###

# The Page model
#
# The page is the "whole thing"
# It can contain:
# 	- Fields
# 	- ItemAreas
# 	- RowAreas
class app.Models.Page extends Backbone.Model
	initialize: ->
		@fields = {}
		@rowAreas = {}

	toJSON: ->
		result =
			fields: {}
			rowAreas: {}
		result.fields[name] = field.toJSON() for name, field of @fields
		result.rowAreas[name] = rowArea.toJSON() for name, rowArea of @rowAreas
		result.theme = @get 'theme'
		result

	save: ->
		options =
			context: @
			data:
				post_id: @id
				method: 'update'
				data: JSON.stringify @toJSON()
				_ajax_nonce: app.nonce
		app.log 'options.data', options.data
		wp.ajax.send "velocity-page", options

	parse: ->
		no

	setMessage: (message) ->
		app.log 'Setting message on model to', message
		@set message: message

	clearMessage: ->
		@unset 'message'

# The Row model
#
# Rows are chunks of layout that can be sorted (usually vertically) within their parent RowArea
# They can contain:
# 	- Fields
# 	- ItemAreas
class app.Models.Row extends Backbone.Model
	initialize: (data, options) ->
		@listenTo @, 'switchStyle', @switchStyle
		@fields = {}
		@itemAreas = {}
		if options?.fields
			for name, field of options.fields
				@fields[name] = new app.Models.Field field.data, field.options
		else if app.expectations.rows[data.slug]?.fields
			for name, field of app.expectations.rows[data.slug]?.fields
				@fields[name] = new app.Models.Field
					slug: field
					id: name
		if options?.itemAreas
			for name, itemArea of options.itemAreas
				itemArea.options.name = name
				@itemAreas[name] = new app.Collections.ItemArea null, itemArea.options
		else if app.expectations.rows[data.slug]?.item_areas
			for name, itemArea of app.expectations.rows[data.slug]?.item_areas
				@itemAreas[name] = new app.Collections.ItemArea null,
					slug: itemArea
					id: name
			# Now, we may have existing itemAreas
			# If we have too many, we have to combine them
			#console.log 'OLD ITEM AREAS', options?.oldModelItemAreas
			if options?.oldModelItemAreas?
				oldCount = _.size options?.oldModelItemAreas
				newCount = _.size app.expectations.rows[data.slug]?.item_areas
				if oldCount and newCount and oldCount > newCount
					columns = ['default', 'second', 'third']
					columns = _.first columns, oldCount
					hanging = _.last columns, oldCount - newCount
					keeping = _.difference columns, hanging
					last = _.last keeping
					for hang in hanging
						options.oldModelItemAreas[last].add options.oldModelItemAreas[hang].models
						delete options.oldModelItemAreas[hang]
				for name, itemArea of options.oldModelItemAreas
					@itemAreas[name] = itemArea

		@set id: @cid # not using IDs

	switchStyle: ->
		current = @get 'style'
		@set style: if 'alt' is current then null else 'alt'

	toJSON: ->
		result = super arguments...
		result.fields = {}
		result.itemAreas = {}
		result.fields[name] = field.toJSON() for name, field of @fields
		result.itemAreas[name] = itemArea.toJSON() for name, itemArea of @itemAreas
		result

# The Item model
#
# Items are small chunks of layout that can be sorted (usually horizontally) within their parent ItemArea
# They can contain Fields
class app.Models.Item extends Backbone.Model
	initialize: (data, options) ->
		delete data?.align unless data?.align
		@switching = not _.isEmpty options?.oldModelFields
		@fields = {}
		if options?.fields
			for name, field of options.fields
				@fields[name] = new app.Models.Field field.data, field.options
		else if app.expectations.items[data.slug]?.fields
			app.log 'second branch', options?
			for name, field of app.expectations.items[data.slug]?.fields
				newModel =
					slug: field
					id: name
				if options?.oldModelFields?[name]
					@fields[name] = new app.Models.Field _.extend(options.oldModelFields[name].toJSON(), newModel),
						autofocus: no
				else
					@fields[name] = new app.Models.Field newModel,
						autofocus: options?.autofocus or no
				options?.autofocus = no
		@set id: @cid # not using IDs
		@listenTo @, 'editMode', @editMode
		@listenTo @, 'editLink:show', @editLink
		@listenTo @, 'chooseImage', @chooseImage
		@listenTo @, 'add', @add
		for name, field of @fields
			@listenTo field, 'editMode', @editMode
			@listenTo field, 'itemHeightCheck', @heightCheck

	add: (model, collection, options) ->
		field.trigger 'add', model, collection, options for name, field of @fields

	heightCheck: ->
		@trigger 'heightCheck'

	editLink: ->
		field.trigger 'editLink:show' for name, field of @fields

	editMode: (mode, initiator) ->
		if initiator is @
			field.trigger 'editMode', mode, field for name, field of @fields

	chooseImage: ->
		field.trigger 'chooseImage' for name, field of @fields

	toJSON: ->
		result = super arguments...
		result.fields = {}
		result.fields[name] = field.toJSON() for name, field of @fields
		result

# The Field model
#
# Fields are editable data like text, an image, a loop, etc
class app.Models.Field extends Backbone.Model
	initialize: (data, options) ->
		app.log 'Field initialize options:', options
		unless @get 'value'
			defaultValue = switch data.slug
				when 'text', 'p' then '<p>Add text here</p>'
				when 'h1', 'h2', 'h3', 'h4' then 'Add text here'
				when 'spacer' then 100
				else ''
			@set value: defaultValue
		@set autofocus: options?.autofocus or off

# The RowArea collection model
#
# RowAreas are sortable containers with no data of their own
# They can contain Rows
class app.Collections.RowArea extends Backbone.Collection
	# Setting 'model' allows raw attributes to be passed to add()
	model: app.Models.Row

	initialize: (models, options) ->
		data = options.data
		app.log 'Collections.RowArea.initialize()', options
		@listenTo @, 'move', @move
		@listenTo @, 'removeFromCollection', @remove
		@listenTo @, 'chooseRowType', @replaceWithType
		@listenTo @, 'wantsNewType', @wantsNewType
		@slug = data.slug or 'default'
		for row in options.rows
			@add new app.Models.Row row.data, row.options

	replaceWithType: (model, slug) ->
		index = @indexOf model
		app.log 'position', index
		@remove model
		newModel = new app.Models.Row slug: slug,
			autofocus: yes
			oldModelItemAreas: model.get('oldModelItemAreas') or null
		model.set oldModelItemAreas: null
		@add newModel,
			at: index

	wantsNewType: (model) ->
		index = @indexOf model
		@remove model
		@addRow model,
			at: index

	move: (model, index) ->
		app.log 'Moving row', index, model
		# We do these silently because we don't want to re-render the view
		# (jQuery already reordered it)
		unless -1 is index or model is @at index
			@remove model, shh: yes
			@add model, at: index, shh: yes

	addRow: (model, options) ->
		app.log 'COLLECTION: adding a row',
			model: model
			options: options
		newModel = new app.Models.Row
			slug: 'chooser'
			oldModelItemAreas: model?.itemAreas or null
			oldModel: model
		newModel.autofocus = yes
		@add newModel, _.extend({}, options)

# The ItemArea collection model
#
# ItemAreas are sortable containers with no data of their own
# They can contain Items
class app.Collections.ItemArea extends Backbone.Collection
	# Setting 'model' allows raw attributes to be passed to add()
	model: app.Models.Item

	initialize: (data, options) ->
		app.log 'Collections.ItemArea.initialize()', data, options
		@listenTo @, 'move', @move
		@listenTo @, 'removeFromCollection', @remove
		@listenTo @, 'wantsNewType', @wantsNewType
		@listenTo @, 'chooseItemType', @replaceWithType

		if options?.items
			@name = options.name
			for item in options.items
				app.log 'ITEM', item.data, item.options
				@add new app.Models.Item item.data, item.options

	replaceWithType: (model, slug) ->
		index = @indexOf model
		app.log 'position', index
		@remove model
		newModel = new app.Models.Item slug: slug, align: model?.get?('oldModel')?.get?('align') or null,
			autofocus: yes
			oldModelFields: model.get('oldModelFields') or null
		newModel.chooseImageImmediately = yes
		@add newModel,
			at: index

	wantsNewType: (model) ->
		index = @indexOf model
		@remove model
		@addItem model,
			at: index

	move: (model, index) ->
		# Don't touch it if it's already here and in the right place
		unless -1 is index or model is @at index
			app.log 'Moving item', index, model
			@remove model, shh: yes
			@add model, at: index, shh: yes

	addItem: (model, options) ->
		app.log 'COLLECTION: adding an item',
			model: model
			options: options
		newModel = new app.Models.Item
			slug: 'chooser'
			oldModelFields: model?.fields or null
			oldModel: model
		newModel.autofocus = yes
		@add newModel, options or {}
		app.log 'Models', @models

###=======================================================

8b           d8 88
`8b         d8' ""
 `8b       d8'
	`8b     d8'   88  ,adPPYba, 8b      db      d8 ,adPPYba,
	 `8b   d8'    88 a8P_____88 `8b    d88b    d8' I8[    ""
		`8b d8'     88 8PP"""""""  `8b  d8'`8b  d8'   `"Y8ba,
		 `888'      88 "8b,   ,aa   `8bd8'  `8bd8'   aa    ]8I
			`8'       88  `"Ybbd8"'     YP      YP     `"YbbdP"'

=======================================================###

# The Base view, which allows for on-instantiation template setting
class app.Views.Base extends wp.Backbone.View
	constructor: (options) ->
		@template = options.template if options?.template
		super arguments...

# The Page view
class app.Views.Page extends wp.Backbone.View
	template: app.template 'velocity-page-wrapper'
	id: 'velocity-page-inner-wrapper'
	events:
		keydown: 'keydown'
		mousemove: 'mousemove'
	mousePosition = [0,0]

	initialize: ->
		@listenTo @model, 'change:message', @updateMessage
		@listenTo app.events, 'drag:start', @dragStart
		@listenTo app.events, 'drag:stop', @dragStop

	keydown: ->
		@$el.addClass 'typing'

	mousemove: (e) ->
		oldPosition = _.clone @mousePosition
		@mousePosition = [ e.pageX, e.pageY ]
		if not _.isEqual( oldPosition, @mousePosition )
			@$el.removeClass 'typing'

	setSubviews: ->
		for name, field of @model.fields
			app.log "adding the page '#{name}' field subview"
			@views.set ".page-field-wrap-#{name}",
				new app.Views.Field
					template: app.template "field-#{field.get 'slug'}"
					model: field
		for name, rowArea of @model.rowAreas
			app.log "adding the page '#{name}' rowArea subview", rowArea
			@views.set ".page-row-area-wrap-#{name}",
				new app.Views.RowArea
					template: app.template "row-area-#{rowArea.slug}"
					collection: rowArea
		@ # Chainable

	dragStart: (type) ->
		@$body.addClass "dragging dragging-#{type}"
		app.log 'drag:start'

	dragStop: (type) ->
		@$body.removeClass "dragging dragging-#{type}"
		app.log 'drag:stop'

	updateMessage: (model, value = '') ->
		app.log 'MESSAGE', value
		@$message.html value
		@$message.toggle not _.isEmpty value

	ready: ->
		@$message = $ '.vp-message'
		@$body = $ 'body'

	render: ->
		@setSubviews() unless @views.length
		super arguments...
		app.log 'rendered HTML'
		$('#velocity-page-wrapper').html @el
		app.log 'added page HTML to DOM'
		@views.ready()
		app.log 'announced ready'
		@ # Chainable

# The RowArea view
class app.Views.RowArea extends app.Views.Base
	tagName: 'div'
	className: 'row-area-wrap'

	initialize: ->
		@listenTo @collection, 'add', @addView
		@listenTo @collection, 'add remove change', @setClasses
		@listenTo @collection, 'setClasses', @setClasses
		@listenTo @collection, 'mouseOver', @mouseOver
		@listenTo @collection, 'mouseOut', @mouseOut
		@setViews()

	mouseOver: (hovered) ->
		@$el.addClass 'hovered' if hovered is @collection

	mouseOut: (hovered) ->
		@$el.removeClass 'hovered' if hovered is @collection

	addView: (row, rowArea, options) ->
		unless options?.shh
			newView = @newView row
			@views.add ".row-area-row-wrap", newView,
				at: options?.at

	newView: (row) ->
		new app.Views.Row
			template: app.template "row-#{row.get 'slug'}"
			model: row

	setViews: ->
		@views.set ".row-area-row-wrap", ( @newView row for row in @collection.models )
		@views.set ".row-area-controls-wrap", new app.Views.RowAreaControls
			template: app.template "controls-row-area"
			collection: @collection

	postRender: ->
		@setClasses()

	postRenderOnce: ->
		wrap = @$ '.row-area-row-wrap'
		@$el.hoverIntent
			over: =>
				@collection.trigger 'mouseOver', @collection
			out: =>
				@collection.trigger 'mouseOut', @collection
			timeout: 1000
			interval: 40
		wrap.sortable
			axis: 'y'
			cursor: 'move'
			handle: '.vp-sort-handle'
			items: '> .row-wrap'
			tolerance: 'pointer'
			placeholder: 'sortable-placeholder'
			start: (e, ui) ->
				bg = app.getBackgroundColor
				seeThru = app.isTransparentColor
				actualColor = ui.item.css 'background-color'
				ui.item.data 'originalCSS',
					'max-height': ui.item.css 'max-height'
					overflow: ui.item.css 'overflow'
				if seeThru actualColor
					ui.item.parents().each ->
						unless seeThru bg @
							actualColor = bg @
							no
				actualColor = '#fff' if seeThru actualColor # browser default is white
				ui.item.css
					'background-color': actualColor
					overflow: 'hidden'
					'max-height': '300px'
				ui.placeholder.css
					'height'				: ui.helper.css 'height'
					'max-height'    : '300px'
					'margin-top'    : ui.helper.css 'margin-top'
					'margin-bottom' : ui.helper.css 'margin-bottom'
					'padding-top'   : ui.helper.css 'padding-top'
					'padding-bottom': ui.helper.css 'padding-bottom'
				wrap.sortable 'refreshPositions'
				app.events.trigger 'drag:start', 'row'
			update: (e, ui) ->
				ui.item.trigger 'move', ui.item.index()
			stop: (e, ui) ->
				ui.item.css ui.item.data 'originalCSS' if ui.item.data 'originalCSS'
				ui.item.css 'background-color', '' # Unset this
				app.events.trigger 'drag:stop', 'row'
				ui.item.find('.field-wrap').trigger 'drag:stop'

	setClasses: ->
		app.log 'setClasses()', "#{@collection.length} rows"
		# Remove the existing row-count-X class
		$wrap = @$('.row-area-row-wrap')
		$wrap.attr 'class', $wrap.attr('class').replace /\s*row-count-[0-9]+/, ''
		# Add an updated one
		$wrap.addClass "row-count-#{@collection.length}"
		app.log 'setClasses()', @
		@$el.addClass "row-area-wrap-slug-#{@slug}" if @slug

	ready: ->
		app.log 'RowArea.ready'
		@postRenderOnce()
		@postRender()

# The RowAreaControls view
class app.Views.RowAreaControls extends app.Views.Base
	tagName: 'div'
	className: 'controls-wrap controls-wrap-row-area'
	events:
		'click .vp-add': 'addRow'

	initialize: ->
		@listenTo @collection, 'mouseOver', @mouseOver
		@listenTo @collection, 'mouseOut', @mouseOut
		@listenTo @collection, 'add', @add
		@listenTo @collection, 'remove', @remove

	mouseOver: (hovered) ->
		if hovered is @collection
			@$el.fadeIn 100 unless @$el.hasClass 'ui-sortable-helper'

	mouseOut: (hovered) ->
		if hovered is @collection
			@$el.fadeOut() unless @$el.hasClass('ui-sortable-helper') or ! @collection.length

	addRow: (e) ->
		app.log 'Adding a row'
		e.preventDefault()
		@collection.addRow()

	add: ->
		@alterAddButton 'add'

	remove: ->
		@alterAddButton 'remove'

	alterAddButton: (type) ->
		@$el.toggleClass 'vp-empty', @collection.length is 0
		if @collection.length is 1 and type is 'add'
			@$el.show()

	ready: ->
		app.log 'RowAreaControls.ready'
		@alterAddButton()

# The ItemArea view
class app.Views.ItemArea extends app.Views.Base
	tagName: 'div'
	className: 'item-area-wrap'

	initialize: (options) ->
		@itemArea = @collection
		@slug = options.slug
		@listenTo @itemArea, 'add', @addView
		@listenTo @itemArea, 'change add remove', @setClasses
		@listenTo @itemArea, 'mouseOver', @mouseOver
		@listenTo @itemArea, 'mouseOut', @mouseOut
		@setViews()

	mouseOver: (hovered) ->
		@$el.addClass 'hovered' if hovered is @itemArea

	mouseOut: (hovered) ->
		@$el.removeClass 'hovered' if hovered is @itemArea

	addView: (item, itemArea, options) ->
		unless options?.shh
			newView = @newView item
			app.log 'newView', newView
			@views.add ".item-area-item-wrap", newView,
				at: options?.at

	newView: (item) ->
		new app.Views.Item
			template: app.template "item-#{item.get 'slug'}"
			model: item
			slug: item.get 'slug'

	setViews: ->
		@views.set ".item-area-item-wrap", ( @newView item for item in @itemArea.models )
		@views.set ".item-area-controls-wrap", new app.Views.ItemAreaControls
			template: app.template "controls-item-area"
			collection: @itemArea

	postRender: ->
		@setClasses()

	postRenderOnce: ->
		wrap = @$ '.item-area-item-wrap'
		@$el.hoverIntent
			over: =>
				@itemArea.trigger 'mouseOver', @itemArea
			out: =>
				@itemArea.trigger 'mouseOut', @itemArea
			timeout: 1000
			interval: 40
		itemArea = @itemArea
		wrap.sortable
			cursor: 'move'
			handle: '.vp-sort-handle'
			items: '> .item-wrap'
			placeholder: 'sortable-placeholder'
			connectWith: '.item-area-item-wrap'
			tolerance: 'pointer'
			cursorAt:
				left: 5
				top: 5
			start: (e, ui) ->
				bg = app.getBackgroundColor
				seeThru = app.isTransparentColor
				actualColor = ui.item.css 'background-color'
				ui.item.data 'originalCSS',
					'max-height': ui.item.css 'max-height'
					overflow: ui.item.css 'overflow'
				if seeThru actualColor
					ui.item.parents().each ->
						unless seeThru bg @
							actualColor = bg @
							no
				actualColor = '#fff' if seeThru actualColor # browser default is white
				ui.item.css
					'background-color': actualColor
					'max-height': '150px'
					overflow: 'hidden'
				ui.placeholder.css
					'height'				: ui.helper.css 'height'
					'max-height'    : '150px'
					'margin-top'    : ui.helper.css 'margin-top'
					'margin-bottom' : ui.helper.css 'margin-bottom'
					'padding-top'   : ui.helper.css 'padding-top'
					'padding-bottom': ui.helper.css 'padding-bottom'
				wrap.sortable 'refreshPositions'
				app.events.trigger 'drag:start', 'item'
			stop: (e, ui) ->
				ui.item.css ui.item.data 'originalCSS' if ui.item.data 'originalCSS'
				ui.item.css 'background-color', '' # Unset this
				app.events.trigger 'drag:stop', 'item'
				ui.item.find('.field-wrap').trigger 'drag:stop'
			update: (e, ui) ->
				app.log 'UPDATE',
					text: ui.item.text().trim()
					index: ui.item.index()
					model: ui.item.data('backbone-model')
					name: itemArea.name
					inThisView: $.contains( @, ui.item.get 0 )
					isNew: -1 is itemArea.indexOf ui.item.data('backbone-model')
				if $.contains( @, ui.item.get 0 )
					item = ui.item.data 'backbone-model'
					itemArea.trigger 'move', item, ui.item.index()
			remove: (e, ui) ->
				app.log 'REMOVE',
					text: ui.item.text().trim()
					index: ui.item.index()
					model: ui.item.data('backbone-model')
					name: itemArea.name
					inThisView: $.contains( @, ui.item.get 0 )
					isNew: -1 is itemArea.indexOf ui.item.data('backbone-model')
				model = ui.item.data 'backbone-model'
				itemArea.remove model, shh: yes

	setClasses: ->
		app.log 'setClasses()', "#{@itemArea.length} items"
		# Remove the existing item-count-X class
		$wrap = @$('.item-area-item-wrap')
		$wrap.attr 'class', $wrap.attr('class').replace /\s*item-count-[0-9]+/, ''
		# Add an updated one
		$wrap.addClass "item-count-#{@itemArea.length}"
		app.log 'setClasses()', @
		@$el.addClass "item-area-wrap-slug-#{@slug}"

	ready: ->
		app.log 'ItemArea.ready'
		@postRenderOnce()
		@postRender()

# The ItemAreaControls view
class app.Views.ItemAreaControls extends app.Views.Base
	tagName: 'div'
	className: 'controls-wrap controls-wrap-item-area'
	events:
		'click .vp-add': 'addItem'

	initialize: ->
		@listenTo @collection, 'mouseOver', @mouseOver
		@listenTo @collection, 'mouseOut', @mouseOut
		@listenTo @collection, 'add', @alterAddButton
		@listenTo @collection, 'remove', @alterAddButton
		@listenTo @collection, 'hoveredHalf', @moveControls

	moveControls: (view, hoveredHalf) ->
		app.log "Hovered over #{hoveredHalf} of #{view.model.get 'id'}"
		top = view.$el.position().top
		bottom = top + view.$el.height()
		index = @collection.indexOf view.model
		if 'top' is hoveredHalf
			newTop = top - 12 + 5 + 1 # - half height + half margin + border
		else
			index++
			newTop = bottom + 12 - 5 - 1 # + half height - half margin - border
		@hoveredLocation = index
		@$el.css
			bottom: 'auto'
			top: "#{newTop}px"
		app.log view.$el.position().top

	mouseOver: (hovered) ->
		if hovered is @collection
			@$el.fadeIn 100 unless @$el.hasClass 'ui-sortable-helper'

	mouseOut: (hovered) ->
		if hovered is @collection
			@$el.fadeOut() unless @$el.hasClass 'ui-sortable-helper'

	addItem: (e) ->
		app.log 'Adding an item'
		e.preventDefault()
		@collection.addItem {}, at: @hoveredLocation or 0

	alterAddButton: ->
		@$el.toggleClass 'vp-empty', @collection.length is 0

	ready: ->
		app.log 'ItemAreaControls.ready'
		@alterAddButton()

# The Row view
class app.Views.Row extends app.Views.Base
	tagName: 'div'
	className: 'row-wrap'
	events:
		'move': 'move'
		'click .row > ul.vp-choose-type a': 'chooseRowType'
		'click .vp-sort-handle': 'preventDefault'

	initialize: ->
		for name, field of @model.fields
			@views.set ".row-field-wrap-#{name}", new app.Views.Field
				template: app.template "field-#{field.get 'slug'}"
				model: field
		for name, itemArea of @model.itemAreas
			itemAreaSlug = app.expectations.rows[@model.get 'slug']?.item_areas[name]
			@views.set ".row-item-area-wrap-#{name}", new app.Views.ItemArea
				template: app.template "item-area-#{itemAreaSlug}"
				collection: itemArea
				slug: itemAreaSlug
		@views.set ".row-controls-wrap", new app.Views.RowControls
			template: app.template "controls-row"
			model: @model
		@listenTo @model, 'userRemove', @userRemove
		@listenTo @model, 'remove', @maybeRemove
		@listenTo @model, 'mouseOver', @mouseOver
		@listenTo @model, 'mouseOut', @mouseOut
		@listenTo @model, 'change:style', @updateStyle
		@listenTo itemArea, 'add remove change', @equalizeColumns for name, itemArea of @model.itemAreas

	equalizeColumns: ->
		app.equalizeColumns()

	mouseOver: (hovered) ->
		@$el.addClass 'hovered' if hovered is @model

	mouseOut: (hovered) ->
		@$el.removeClass 'hovered' if hovered is @model

	maybeRemove: (item, collection, options) ->
		unless options?.shh
			@remove()

	updateStyle: (model, value, options) ->
		@$el.toggleClass 'vp-alt-style', value is 'alt'

	chooseRowType: (e) ->
		e.preventDefault()
		target = $ e.target
		slug = target.data 'slug'
		app.log 'clicked type:', slug
		@remove()
		@model.trigger 'chooseRowType', @model, slug

	preventDefault: (e) ->
		e.preventDefault()

	userRemove: (model) ->
		@$el.slideUp 400, ->
			model.trigger 'removeFromCollection', model

	move: (e, index) ->
		@model.trigger 'move', @model, index

	postRender: ->
		@setClasses()
		@$el.toggleClass 'vp-alt-style', @model.get('style') is 'alt'

	setClasses: ->
		@$el.addClass "row-wrap-slug-#{@model.get 'slug'}" if @model.get 'slug'

	ready: ->
		app.log '================================='
		app.log 'Row.ready'
		@postRender()
		if @model.autofocus
			delete @model.autofocus
			@$el.scrollintoview()
			app.log 'scrollintoview()'
		@$el.hoverIntent
			over: =>
				@model.trigger 'mouseOver', @model
			out: =>
				@model.trigger 'mouseOut', @model
			timeout: 500
			interval: 40

# The RowControls view
class app.Views.RowControls extends app.Views.Base
	tagName: 'div'
	className: 'controls-wrap controls-wrap-row'
	events:
		'click .vp-remove': 'userRemove'
		'click .vp-change': 'launchRowTypeChooser'
		'click .vp-switch-style': 'switchStyle'

	initialize: ->
		@listenTo @model, 'mouseOver', @mouseOver
		@listenTo @model, 'mouseOut', @mouseOut

	mouseOver: (hovered) ->
		if hovered is @model
			@$el.css 'display', 'block' unless @$el.hasClass 'ui-sortable-helper'

	mouseOut: (hovered) ->
		if hovered is @model
			@$el.css 'display', 'none' unless @$el.hasClass 'ui-sortable-helper'

	selfMouseOver: =>
		@more.show()

	selfMouseOut: =>
		@more.hide()

	userRemove: (e) ->
		e.preventDefault()
		@model.trigger 'userRemove', @model

	launchRowTypeChooser: (e) ->
		e.preventDefault()
		@model.trigger 'wantsNewType', @model

	switchStyle: (e) ->
		e.preventDefault()
		@model.trigger 'switchStyle', @model

	ready: ->
		app.log 'RowControls.ready'
		@more = @$ 'div.vp-more'
		@$el.hoverIntent
			over: @selfMouseOver
			out: @selfMouseOut
			timeout: 1000
			interval: 40

# The Item view
class app.Views.Item extends app.Views.Base
	tagName: 'div'
	className: 'item-wrap'
	events:
		'click > ul .vp-choose-type': 'chooseItemType'
		'click .vp-sort-handle': 'preventDefault'
		'mousemove': 'mousemove'

	initialize: (options) ->
		@slug = options.slug
		if @model.fields
			app.log 'FIELDS', @model.fields
			for name, field of @model.fields
				@views.set ".item-field-wrap-#{name}", new app.Views.Field
					template: app.template "field-#{field.get 'slug'}"
					model: field
		@views.set ".item-controls-wrap", new app.Views.ItemControls
			template: app.template "controls-item"
			model: @model
		@listenTo @model, 'userRemove', @userRemove
		@listenTo @model, 'remove', @maybeRemove
		@listenTo @model, 'mouseOver', @mouseOver
		@listenTo @model, 'mouseOut', @mouseOut
		@listenTo @model, 'heightCheck', @heightCheck
		@listenTo @model, 'change:align', @setAlignment
		@mousemove = _.throttle @mousemoveRaw, 100, trailing: no

	maybeRemove: (item, collection, options) ->
		unless options?.shh
			@remove()

	mousemoveRaw: (e) ->
		target = $ e.currentTarget
		offset = target.offset()
		height = target.height()
		middle = height / 2
		y = e.pageY - offset.top
		hoveredHalf = if y > middle then 'bottom' else 'top'
		@model.trigger 'hoveredHalf', @, hoveredHalf

	mouseOver: (hovered) ->
		@$el.addClass 'hovered' if hovered is @model
		@heightCheck()

	mouseOut: (hovered) ->
		@$el.removeClass 'hovered' if hovered is @model

	heightCheck: ->
		@model.trigger 'announceHeight', @$el.outerHeight()

	chooseItemType: (e) ->
		e.preventDefault()
		target = $ e.target
		slug = target.data 'slug'
		app.log 'clicked type:', slug
		@remove()
		@model.trigger 'chooseItemType', @model, slug

	userRemove: (model) ->
		@$el.fadeOut 400, ->
			model.trigger 'removeFromCollection', model

	setAlignment: (model, align) ->
		fieldWrap = @$ '.item-field-wrap'
		fieldWrap.removeClass 'vp-align-left vp-align-right vp-align-center'
		fieldWrap.addClass "vp-align-#{align}" if align

	preventDefault: (e) ->
		e.preventDefault()

	prepare: ->
		app.log 'ITEM PREPARE', _.extend @model.toJSON(), switching: @model.switching
		_.extend @model.toJSON(), switching: @model.switching

	ready: ->
		if @model.chooseImageImmediately and 'image' is @model.get 'slug'
			delete @model.chooseImageImmediately
			@model.trigger 'chooseImage'
		if @model.autofocus
			delete @model.autofocus
			@$el.scrollintoview()
			app.log 'scrollintoview()'
		@setAlignment @model, @model.get 'align'
		@$el.data 'backbone-model', @model
		@$el.addClass "item-wrap-slug-#{@slug}"
		@$el.hoverIntent
			over: =>
				@model.trigger 'mouseOver', @model
			out: =>
				@model.trigger 'mouseOut', @model
			timeout: 250
			interval: 40

# The ItemControls view
class app.Views.ItemControls extends app.Views.Base
	tagName: 'div'
	className: 'controls-wrap controls-wrap-item'
	events:
		'click .vp-remove': 'userRemove'
		'click .vp-change': 'launchItemTypeChooser'
		'click .vp-edit': 'edit'
		'click .vp-align': 'alignText'
		'click .vp-more a': 'selfMouseOut'
		'click .vp-link': 'link'
		'mouseover' : 'selfMouseOver'

	initialize: ->
		@listenTo @model, 'mouseOver', @mouseOver
		@listenTo @model, 'mouseOut', @mouseOut
		@listenTo @model, 'announceHeight', @adjustCorner
		@listenTo @, 'adjustCorner', @adjustCorner

	userRemove: (e) ->
		e.preventDefault()
		@model.trigger 'userRemove', @model

	edit: (e) ->
		e.preventDefault()
		switch @model.get 'slug'
			when 'shortcode', 'media', 'html', 'mailchimp', 'aweber' then @model.trigger 'editMode', yes, @model
			when 'image' then @model.trigger 'chooseImage'

	adjustCorner: (itemHeight = 0) ->
		@$el.toggleClass 'vp-round-corner', @height > itemHeight

	alignText: (e) ->
		e.preventDefault()
		target = $ e.currentTarget
		align = target.data 'align'
		if align is @model.get 'align'
			@model.unset 'align'
		else
			@model.set align: target.data 'align'

	launchItemTypeChooser: (e) ->
		e.preventDefault()
		@model.trigger 'wantsNewType', @model

	link: (e) ->
		e.preventDefault()
		@model.trigger 'editLink:show'
		# Next, it's passed to each field
		# Then each field's view watches its own model for it
		# Shows it
		# Field's view handles saving and re-rendering

	mouseOver: (hovered) ->
		if hovered is @model
			@height = @$el.outerHeight() unless @height
			@$el.css 'display', 'block' unless @$el.hasClass 'ui-sortable-helper'

	mouseOut: (hovered) ->
		if hovered is @model
			@$el.css 'display', 'none' unless @$el.hasClass 'ui-sortable-helper'

	selfMouseOver: =>
		@more.show()

	selfMouseOut: =>
		@more.hide()

	prepare: ->
		@model.toJSON()

	ready: ->
		app.log 'ItemControls.ready'
		@more = @$ 'div.vp-more'
		@$el.hoverIntent
			over: @selfMouseOver
			out: @selfMouseOut
			timeout: 1000
			interval: 40

# The Field view
class app.Views.Field extends app.Views.Base
	events:
		'click .vp-editable.vp-inline': 'focus'
		'click .vp-editable.vp-block': 'focusBlock'
		'click vp-image > .vp-choose-image' : 'imageClick'
		'keyup .vp-editable.vp-inline': 'keyup'
		'keypress .vp-editable.vp-inline': 'keypress'
		'blur textarea.vp-html': 'blurTextarea'
		'blur textarea.vp-media': 'blurMedia'
		'blur textarea.vp-shortcode': 'blurShortcode'
		'blur .vp-editable': 'blur'
		'blur vp-image-link': 'blurImageLink'
		'keypress vp-image-link': 'keypressImageLink'
		'keyup vp-image-link': 'keyupImageLink'
		'drag:stop': 'mediaReRender'
	tagName: 'div'
	className: 'field-wrap'

	initialize: ->
		app.log 'Field.initialize'
		@editing = @model.get('slug') in ['shortcode', 'media', 'html', 'mailchimp', 'aweber'] and @isEmptyishHTML @model.get 'value'
		@listenTo @model, 'editMode', @editMode
		@listenTo @model, 'editLink:show', @editLink
		@listenTo @model, 'chooseImage', @chooseImage
		@listenTo @model, 'add', @postRender

	isEmptyishHTML: (html) ->
		return no unless _.isString html
		_.isEmpty @stripScriptTags(html).trim()

	stripScriptTags: (html) ->
		return html unless _.isString html
		html.replace /<script[^>]*>.*?<\/script>/gi, ''

	prepare: ->
		out = _.extend @model.toJSON(), editing: @editing
		out.value = @stripScriptTags out.value if out.value and not @editing
		out

	editMode: (mode) ->
		app.log 'editMode', mode
		@editing = mode
		@render()
		@postRender()
		@textarea.focus() if @editing

	editLink: ->
		@imageLink.slideDown
			duration: 250
			start: => @imageLink.css display: 'block'
		@imageLink.find('input').focus().select()

	focus: ->
		app.log 'focus'
		@editable.focus()
		document.execCommand 'selectAll', no, null if @editable.html() is 'Add text here'

	focusBlock: ->
		app.log 'focusBlock'
		document.execCommand 'selectAll', no, null if @editable.html() is '<p>Add text here</p>'

	blur: ->
		@model.set value: @editable.html()

	blurTextarea: ->
		@model.set value: @textarea.val().trim()
		@model.trigger 'editMode', off, @model unless @isEmptyishHTML @model.get 'value'

	blurMedia: ->
		@blurTextarea()
		@fetchMedia()

	fetchMedia: ->
		return unless 'media' is @model.get 'slug'
		options =
			context: @
			data:
				method: 'oembed'
				url: @model.get 'value'
		app.log 'options.data', options.data
		oembed = wp.ajax.send "velocity-page", options
		oembed.done (result) ->
			if result?.html?
				@model.set html: result.html
			else
				@model.set html: @model.get 'value'
			@model.trigger 'editMode', off, @model

	blurShortcode: ->
		@blurTextarea()
		@fetchShortcode()

	fetchShortcode: ->
		return unless 'shortcode' is @model.get 'slug'
		options =
			context: @
			data:
				method: 'shortcode'
				shortcode: @model.get 'value'
		app.log 'options.data', options.data
		shortcode = wp.ajax.send "velocity-page", options
		shortcode.done (result) ->
			if result?.html?
				@model.set html: result.html
			else
				@model.set html: @model.get 'value'
			@model.trigger 'editMode', off, @model

	keyupImageLink: ->
		@checkImageLink()

	keypressImageLink: (e) ->
		if e.which is 13
			@blurImageLink()

	blurImageLink: ->
		@checkImageLink()
		@model.set url: @imageLinkInput.val()
		@imageLink.slideUp
			duration: 250
			complete: => @imageLink.hide()

	checkImageLink: ->
		input = @imageLink.find 'input'
		link = input.val()
		if link.length and 0 isnt link.indexOf '/'
			chops = [
				'http://'
				'https://'
				'mailto:'
				'ftp://'
				'feed:'
			]
			chops = (chop.substr 0, link.length for chop in chops)
			for chop in chops
				if 0 is link.indexOf chop
					return
			# Still here?
			input.val "http://#{input.val()}"

	keyup: (e) ->
		@model.trigger 'itemHeightCheck'

	keypress: (e) ->
		if e.which is 13 and not e.shiftKey
			@editable.blur()
			@model.set value: @editable.html()
			return no

	imageClick: (e) ->
		e.preventDefault()
		@chooseImage()

	chooseImage: ->
		@frame = wp.media.frames.vpframe = wp.media
			title: 'Media Uploader'
			button:
				text: 'Choose Image'
			multiple: no
			library:
				type: 'image'
		@frame.on 'select', =>
			attachment = @frame.state().get('selection').first().toJSON()
			url = attachment.sizes.large?.url or attachment.sizes.full.url
			app.log 'ATTACHMENT', attachment
			@model.set value: url
			@model.unset 'width'
			@model.unset 'height'
			@render()
			@postRender()
		@frame.open()

	imageResizable: ->
		@imageWrap = @$ 'vp-image'
		@image = @$ 'img', @imageWrap
		if @image.length
			if @model.get 'width' and @model.get 'height'
				@imageWrap.css
						width: "#{@model.get 'width'}px"
						height: "#{@model.get 'height'}px"
			model = @model
			unless @imageWrap.is '.ui-resizable'
				@imageWrap.resizable
					handles: 'se, sw'
					aspectRatio: @image.width() / @image.height()
					maxWidth: @imageWrap.parent().width()
					minWidth: 20
					minHeight: 20
					resize: (e,ui) ->
						img = $ @
						# Special case: 100% width means no dimensions saved
						if img.width() is img.resizable 'option', 'maxWidth'
							model.unset 'width'
							model.unset 'height'
						else
							model.set
								width: img.width()
								height: img.height()
						img.css
							left: 'auto'
							right: 'auto'
							top: 'auto'
							bottom: 'auto'
			# Enforce max width immediately
			if @imageWrap.width() > @imageWrap.parent().width()
				@imageWrap.resizable 'option', 'maxWidth', @imageWrap.parent().width()
				newWidth = @imageWrap.parent().width()
				newHeight = newWidth * (1 / @imageWrap.resizable 'option', 'aspectRatio')
				@imageWrap.css
					width: "#{newWidth}px"
					height: "#{newHeight}px"

	imgResize: ->
		imageWrap = @$ 'vp-image'
		image = @$ 'img', imageWrap
		imageWrap.css height: ''
		if image.height()
			imageWrap.css height: image.height() + "px"
		if @imageWrap.is '.ui-resizable'
			@imageWrap.resizable 'option', 'maxWidth', @imageWrap.parent().width()

	mediaReRender: (e) =>
		console.log 'mediaReRender'
		@model.trigger 'editMode', off, @model

	mediaRender: ->
		if 'media' is @model.get 'slug'
			# This is kind of nuts
			# I'm parsing the HTML through the dom then removing it to run any script tags within it
			mediaHTML = @model.get 'value'
			$($.parseHTML(mediaHTML, document, yes)).appendTo('body').remove()
			unless @editing
				$('<div class="vp-mask"></div>').appendTo(@$el).height("#{@$el.height()}px").width("#{@$el.width()}px")

	postRender: ->
		app.log 'postRender()'
		@mediaRender()
		@fitVids()
		@imageResizable()
		@imgResize()
		@editable = @$ '.vp-editable'
		@textarea = @$ 'textarea.vp-html, textarea.vp-media, textarea.vp-shortcode'
		@imageLink = @$ 'vp-image-link'
		@imageLinkInput = @imageLink.find 'input'
		if 'spacer' is @model.get 'slug'
			@spacer = @$ '.vp-spacer'
			@spacerValue = @$ '.vp-spacer-value'
			@spacerValue.change =>
				@slider.slider 'value', @spacerValue.val()
			@slider = @$ '.vp-spacer-slider'
			@sliderSlide = (e, ui) =>
				@$('.vp-spacer-value').val ui.value
				@model.set value: ui.value
				@spacer.css height: "#{ui.value}px"
			@slider.slider
				value: @model.get('value') or 40
				min: 40
				max: 300
				change: @sliderSlide
				start: ->
					app.events.trigger 'drag:start', 'spacer'
				stop: ->
					app.events.trigger 'drag:stop', 'spacer'
				slide: @sliderSlide


	fitVids: ->
		@$el.fitVids()

	ready: ->
		# This needs a better method of switching by type
		# Note to self: @model.slug has that info
		app.log 'Field.ready'
		$(window).on 'resize', =>
			@imgResize()
		@postRender()
		@fetchMedia()
		@fetchShortcode()
		@editable.val '' if @editable.length and @editable.val() is 'Add text here'
		@$el.attr 'id', @model.cid unless @$el.attr 'id'
		if @editable.length
			@editable.html '<p>Add text here</p>' if @editable.hasClass('vp-block') and @editable.html() is 'Add text here'
			@editable.prop 'contenteditable', on if @editable.hasClass 'vp-inline'
			app.mceInit "##{@$el.attr 'id'} .vp-editable.vp-block" if window.tinymce? and not @editable.hasClass 'vp-inline'
		if @model.get 'autofocus'
			app.log 'autofocus'
			@model.unset 'autofocus'
			if @editable.hasClass 'vp-block'
				@editable.focus()
				document.execCommand 'selectAll', no, null
			else
				@editable.click()
		else
			@model.unset 'autofocus'
		if @model.chooseImageImmediately and @$('vp-image > .vp-choose-image').length
			@chooseImage()

###~~~~~~~~~~~~~###
#  Instantiation  #
###~~~~~~~~~~~~~###

# Instantiate the page model
app.page = new app.Models.Page {}

# Instantiate the page view
app.pageView = new app.Views.Page
	model: app.page

# Start the app
app.start()
