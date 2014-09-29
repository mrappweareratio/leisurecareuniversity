(function() {
	tinymce.PluginManager.add('shortcodes_mce_button', function( editor, url ) {
		editor.addButton('shortcodes_mce_button', {
			title: 'Add Shortcode',
			text: '',
			icon: 'icon dashicons-editor-code',
			type: 'menubutton',
			classes: 'widget btn menubtn shortcodes-btn',
			menu: [
				{
					text: 'Elements',
					menu: [
						{
							text: 'Icon',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Icons - Font Awesome',
									buttons: [
										{
											text: 'Insert',
											classes: 'widget btn primary',
											onclick: 'submit'
										},
										{
											text: 'Close',
											onclick: 'close'
										}
									],
									body: [
										{
											type: 'container',
											html: '<p>All these options are related to the Font Awesome icon collection.<br>For Icon Type you need to use only the name of the icon without "fa-" prefix.</p><p>Example: for fa-desktop class, you will be using only desktop</p>'
										},
										{
											type: 'textbox',
											name: 'iconType',
											label: 'Icon Type',
											value: 'desktop'
										},
										{
											type: 'listbox',
											name: 'sizeList',
											label: 'Icon size',
											'values': [
												{text: 'normal', value: ''},
												{text: 'large', value: 'lg'},
												{text: '2x', value: '2x'},
												{text: '3x', value: '3x'},
												{text: '4x', value: '4x'},
												{text: '5x', value: '5x'}
											]
										},
										{
											type: 'listbox',
											name: 'rotateList',
											label: 'Icon rotate',
											'values': [
												{text: 'no rotate', value: ''},
												{text: '90 degrees', value: '90'},
												{text: '180 degrees', value: '180'},
												{text: '270 degrees', value: '270'}
											]
										},
										{
											type: 'listbox',
											name: 'flipList',
											label: 'Icon flip',
											'values': [
												{text: 'no flip', value: ''},
												{text: 'horizontal', value: 'horizontal'},
												{text: 'vertical', value: 'vertical'}
											]
										},
										{
											type: 'listbox',
											name: 'pullList',
											label: 'Icon pull',
											'values': [
												{text: 'no pull', value: ''},
												{text: 'right', value: 'right'},
												{text: 'left', value: 'left'}
											]
										},
										{
											type: 'listbox',
											name: 'spinList',
											label: 'Icon spin',
											'values': [
												{text: 'false', value: 'false'},
												{text: 'true', value: 'true'}
											]
										}
									],
									onsubmit: function( e ) {
										editor.insertContent( '[icon type="' + e.data.iconType + '" size="' + e.data.sizeList + '" rotate="' + e.data.rotateList + '" flip="' + e.data.flipList + '" pull="' + e.data.pullList + '" spin="' + e.data.spinList + '"]' );
									}
								});
							}
						},
						{
							text: 'Button',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Add Button',
									buttons: [
										{
											text: 'Insert',
											classes: 'widget btn primary',
											onclick: 'submit'
										},
										{
											text: 'Close',
											onclick: 'close'
										}
									],
									body: [
										{
											type: 'container',
											html: '<p style="margin-bottom:20px;">Use this dialog to insert buttons.</p>'
										},
										{
											type: 'textbox',
											name: 'buttonText',
											label: 'Label',
											value: 'Button'
										},
										{
											type: 'textbox',
											name: 'buttonHref',
											label: 'Link',
											value: ''
										},
										{
											type: 'listbox',
											name: 'buttonSize',
											label: 'Size',
											'values': [
												{text: 'small', value: 'small'},
												{text: 'big', value: 'big'}
											]
										},
										{
											type: 'listbox',
											name: 'buttonCorners',
											label: 'Corners',
											'values': [
												{text: 'round', value: 'round'},
												{text: 'square', value: 'square'}
											]
										},
										{
											type: 'listbox',
											name: 'buttonColor',
											label: 'Color',
											'values': [
												{text: 'red', value: 'red'},
												{text: 'blue', value: 'blue'},
												{text: 'green', value: 'green'},
												{text: 'white', value: 'white'}
											]
										}
									],
									onsubmit: function( e ) {
										editor.insertContent( '[button text="' + e.data.buttonText + '" href="' + e.data.buttonHref + '" size="' + e.data.buttonSize + '" corners="' + e.data.buttonCorners + '" color="' + e.data.buttonColor + '"]' );
									}
								});
							}
						},
						{
							text: 'Tabs',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Add Tabs',
									buttons: [
										{
											text: 'Insert',
											classes: 'widget btn primary',
											onclick: 'submit'
										},
										{
											text: 'Close',
											onclick: 'close'
										}
									],
									body: [
										{
											type: 'container',
											html: '<p style="margin-bottom:20px;">Please fill all fields accordingly.</p>'
										},
										{
											type: 'listbox',
											name: 'tabsType',
											label: 'Tabs type',
											'values': [
												{text: 'tabs', value: 'tabs'},
												{text: 'pills', value: 'pills'}
											]
										},
										{
											type: 'textbox',
											name: 'firstTabTitle',
											label: 'First tab title',
											value: 'Tab1'
										},
										{
											type: 'textbox',
											multiline: 'true',
											'minHeight': 100,
											'minWidth': 400,
											name: 'firstTabContent',
											label: 'First tab content',
											value: 'Here goes the content for the first tab.'
										},
										{
											type: 'textbox',
											name: 'secondTabTitle',
											label: 'Second tab title',
											value: 'Tab2'
										},
										{
											type: 'textbox',
											multiline: 'true',
											'minHeight': 100,
											'minWidth': 400,
											name: 'secondTabContent',
											label: 'Second tab content',
											value: 'Here goes the content for the second tab.'
										},
										{
											type: 'container',
											html: '<p style="margin-top:20px;">You can add as many tabs as you need later directly on shortcode just after insert.</p>'
										}
									],
									onsubmit: function( e ) {
										editor.insertContent( '[tabs type="' + e.data.tabsType + '"][tab title="' + e.data.firstTabTitle + '" active="true" fade="true"]'+ e.data.firstTabContent +'[/tab][tab title="' + e.data.secondTabTitle + '" fade="true"]'+ e.data.secondTabContent +'[/tab][/tabs]');
									}
								});
							}
						},
						{
							text: 'Accordion',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Add Accordion',
									width: 700,
									height: 400,
									autoScroll: true,
									classes: 'scrollable-content',
									buttons: [
										{
											text: 'Insert',
											classes: 'widget btn primary',
											onclick: 'submit'
										},
										{
											text: 'Close',
											onclick: 'close'
										}
									],
									body: [
										{
											type: 'container',
											html: '<p style="margin-bottom:20px;">Please fill all fields accordingly.</p>'
										},
										{
											type: 'textbox',
											name: 'firstItemTitle',
											label: 'First item title',
											value: 'Item 1'
										},
										{
											type: 'textbox',
											multiline: 'true',
											'minHeight': 70,
											'minWidth': 400,
											name: 'firstItemContent',
											label: 'First item content',
											value: 'Here goes the content for the first accordion item.'
										},
										{
											type: 'listbox',
											name: 'firstItemType',
											label: 'First item type',
											'values': [
												{text: 'default', value: 'default'},
												{text: 'primary', value: 'primary'},
												{text: 'success', value: 'success'},
												{text: 'info', value: 'info'},
												{text: 'warning', value: 'warning'},
												{text: 'danger', value: 'danger'},
												{text: 'link', value: 'link'}
											]
										},
										{
											type: 'spacer',
											classes: 'window-head'
										},
										{
											type: 'textbox',
											name: 'secondItemTitle',
											label: 'Second item title',
											value: 'Item 2'
										},
										{
											type: 'textbox',
											multiline: 'true',
											'minHeight': 70,
											'minWidth': 400,
											name: 'secondItemContent',
											label: 'Second item content',
											value: 'Here goes the content for the second accordion item.'
										},
										{
											type: 'listbox',
											name: 'secondItemType',
											label: 'Second item type',
											'values': [
												{text: 'default', value: 'default'},
												{text: 'primary', value: 'primary'},
												{text: 'success', value: 'success'},
												{text: 'info', value: 'info'},
												{text: 'warning', value: 'warning'},
												{text: 'danger', value: 'danger'},
												{text: 'link', value: 'link'}
											]
										},
										{
											type: 'spacer',
											classes: 'window-head'
										},
										{
											type: 'textbox',
											name: 'thirdItemTitle',
											label: 'Third item title',
											value: 'Item 3'
										},
										{
											type: 'textbox',
											multiline: 'true',
											'minHeight': 70,
											'minWidth': 400,
											name: 'thirdItemContent',
											label: 'Third item content',
											value: 'Here goes the content for the third accordion item.'
										},
										{
											type: 'listbox',
											name: 'thirdItemType',
											label: 'Third item type',
											'values': [
												{text: 'default', value: 'default'},
												{text: 'primary', value: 'primary'},
												{text: 'success', value: 'success'},
												{text: 'info', value: 'info'},
												{text: 'warning', value: 'warning'},
												{text: 'danger', value: 'danger'},
												{text: 'link', value: 'link'}
											]
										},
									],
									onsubmit: function( e ) {
										editor.insertContent( '[collapsibles][collapse title="' + e.data.firstItemTitle + '" type="' + e.data.firstItemType + '" active="true"]' + e.data.firstItemContent + '[/collapse][collapse title="' + e.data.secondItemTitle + '" type="' + e.data.secondItemType + '"]' + e.data.secondItemContent + '[/collapse][collapse title="' + e.data.thirdItemTitle + '" type="' + e.data.thirdItemType + '"]' + e.data.thirdItemContent + '[/collapse][/collapsibles]');
									}
								});
							}
						},
						{
							text: 'Google Map',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Add Google Map',
									width: 700,
									height: 400,
									autoScroll: true,
									classes: 'scrollable-content',
									buttons: [
										{
											text: 'Insert',
											classes: 'widget btn primary',
											onclick: 'submit'
										},
										{
											text: 'Close',
											onclick: 'close'
										}
									],
									body: [
										{
											type: 'textbox',
											name: 'mapID',
											label: 'Unique ID - no space, lowercase',
											value: 'mymap'
										},
										{
											type: 'listbox',
											name: 'mapType',
											label: 'Map type',
											'values': [
												{text: 'Roadmap', value: 'roadmap'},
												{text: 'Satellite', value: 'satellite'},
												{text: 'Terrain', value: 'terrain'},
												{text: 'Hybrid', value: 'hybrid'}
											]
										},
										{
											type: 'textbox',
											name: 'mapHeight',
											label: 'Map Height (width is 100%)',
											value: '400'
										},
										{
											type: 'textbox',
											name: 'mapZoom',
											label: 'Map Zoom (0-19)',
											value: '16'
										},
										{
											type: 'textbox',
											name: 'mapLatitude',
											label: 'Map Latitude',
											value: ''
										},
										{
											type: 'textbox',
											name: 'mapLongitude',
											label: 'Map Longitude',
											value: ''
										},
										{
											type: 'textbox',
											name: 'mapMessage',
											label: 'Pin Message',
											value: 'We are here!'
										},
										{
											type: 'textbox',
											name: 'mapHue',
											label: 'Map Hue (hex code)',
											value: '#579F6A'
										},
									],
									onsubmit: function( e ) {
										editor.insertContent( '[googlemap id="' + e.data.mapID + '" type="' + e.data.mapType + '" height="' + e.data.mapHeight + '" zoom="' + e.data.mapZoom + '" latitude="' + e.data.mapLatitude + '" longitude="' + e.data.mapLongitude + '" message="' + e.data.mapMessage + '" hue="' + e.data.mapHue + '" ]');
									}
								});
							}
						}
					]
				},
				{
					text: 'Columns',
					menu: [
						{
							text: 'Row',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Add Row',
									width: 600,
									height: 150,
									buttons: [
										{
											text: 'Insert',
											classes: 'widget btn primary',
											onclick: 'submit'
										},
										{
											text: 'Close',
											onclick: 'close'
										}
									],
									body: [
										{
											type: 'container',
											classes: 'modal-shortcode-info',
											name: 'rowInfo',
											html: '<p style="margin-bottom:20px;">To insert the row, please press the Insert button.</p><p>Please keep in mind that you need to place the caret between square brakets before inserting the columns.</p><p>The columns shortcode will not work without the row shortcode so in front of columns shortcodes you need to have [row] and [/row] to the finish.</p>'
										},
									],
									onsubmit: function( e ) {
										editor.insertContent( '[row][/row]' );
									}
								});
							}
						},
						{
							text: 'Column',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Add Column',
									buttons: [
										{
											text: 'Insert',
											classes: 'widget btn primary',
											onclick: 'submit'
										},
										{
											text: 'Close',
											onclick: 'close'
										}
									],
									body: [
										{
											type: 'container',
											html: '<p style="margin-bottom:20px;">Please fill all fields accordingly. Remember that you have to use the ROW shortcode first.</p>'
										},
										{
											type: 'listbox',
											name: 'columnsNumber',
											label: 'Columns Number (1 - 12)',
											'values': [
												{text: '1 column', value: '1'},
												{text: '2 columns', value: '2'},
												{text: '3 columns', value: '3'},
												{text: '4 columns', value: '4'},
												{text: '5 columns', value: '5'},
												{text: '6 columns', value: '6'},
												{text: '7 columns', value: '7'},
												{text: '8 columns', value: '8'},
												{text: '9 columns', value: '9'},
												{text: '10 columns', value: '10'},
												{text: '11 columns', value: '11'},
												{text: '12 columns', value: '12'}
											]
										},
										{
											type: 'listbox',
											name: 'columnOffset',
											label: 'Column Offset (1 - 12)',
											'values': [
												{text: 'no offset', value: ''},
												{text: '1 column', value: '1'},
												{text: '2 columns', value: '2'},
												{text: '3 columns', value: '3'},
												{text: '4 columns', value: '4'},
												{text: '5 columns', value: '5'},
												{text: '6 columns', value: '6'},
												{text: '7 columns', value: '7'},
												{text: '8 columns', value: '8'},
												{text: '9 columns', value: '9'},
												{text: '10 columns', value: '10'},
												{text: '11 columns', value: '11'},
												{text: '12 columns', value: '12'}
											]
										},
										{
											type: 'listbox',
											name: 'columnBreackpoint',
											label: 'Column Breackpoint',
											'values': [
												{text: 'small', value: 'sm'},
												{text: 'medium', value: 'md'},
												{text: 'large', value: 'lg'}
											]
										},
										{
											type: 'textbox',
											multiline: 'true',
											'minHeight': 100,
											'minWidth': 400,
											name: 'columnContent',
											label: 'Column Content',
											value: 'Here goes the content for your awesome column. You can edit the content after.'
										},
									],
									onsubmit: function( e ) {
										editor.insertContent( '[col columns="' + e.data.columnsNumber + '" offset="' + e.data.columnOffset + '" breakpoint="' + e.data.columnBreackpoint + '"]' + e.data.columnContent + '[/col]');
									}
								});
							}
						},
						{
							text: 'Pretty Column',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Add Pretty Column',
									buttons: [
										{
											text: 'Insert',
											classes: 'widget btn primary',
											onclick: 'submit'
										},
										{
											text: 'Close',
											onclick: 'close'
										}
									],
									body: [
										{
											type: 'container',
											html: '<p style="margin-bottom:20px;">Please fill all fields accordingly. Remember that you have to use the ROW shortcode first.</p>'
										},
										{
											type: 'textbox',
											name: 'prettyIcon',
											label: 'Icon - Font Awesome',
											value: 'star'
										},
										{
											type: 'textbox',
											name: 'prettyTitle',
											label: 'Title',
											value: 'Pretty Title'
										},
										{
											type: 'textbox',
											name: 'prettyAnchor',
											label: 'URL',
											value: '#'
										},
										{
											type: 'listbox',
											name: 'prettyColumnsNumber',
											label: 'Columns Number (1 - 12)',
											'values': [
												{text: '1 column', value: '1'},
												{text: '2 columns', value: '2'},
												{text: '3 columns', value: '3'},
												{text: '4 columns', value: '4'},
												{text: '5 columns', value: '5'},
												{text: '6 columns', value: '6'},
												{text: '7 columns', value: '7'},
												{text: '8 columns', value: '8'},
												{text: '9 columns', value: '9'},
												{text: '10 columns', value: '10'},
												{text: '11 columns', value: '11'},
												{text: '12 columns', value: '12'}
											]
										},
										{
											type: 'listbox',
											name: 'prettyColumnOffset',
											label: 'Column Offset (1 - 12)',
											'values': [
												{text: 'no offset', value: ''},
												{text: '1 column', value: '1'},
												{text: '2 columns', value: '2'},
												{text: '3 columns', value: '3'},
												{text: '4 columns', value: '4'},
												{text: '5 columns', value: '5'},
												{text: '6 columns', value: '6'},
												{text: '7 columns', value: '7'},
												{text: '8 columns', value: '8'},
												{text: '9 columns', value: '9'},
												{text: '10 columns', value: '10'},
												{text: '11 columns', value: '11'},
												{text: '12 columns', value: '12'}
											]
										},
										{
											type: 'listbox',
											name: 'prettyColumnBreackpoint',
											label: 'Column Breackpoint',
											'values': [
												{text: 'small', value: 'sm'},
												{text: 'medium', value: 'md'},
												{text: 'large', value: 'lg'}
											]
										},
										{
											type: 'textbox',
											multiline: 'true',
											'minHeight': 100,
											'minWidth': 400,
											name: 'prettyColumnContent',
											label: 'Column Content',
											value: 'Here goes the content for your pretty column. You can edit the content after.'
										},
									],
									onsubmit: function( e ) {
										editor.insertContent( '[prettycol icon="' + e.data.prettyIcon + '" title="' + e.data.prettyTitle + '" anchor="' + e.data.prettyAnchor + '" columns="' + e.data.prettyColumnsNumber + '" offset="' + e.data.prettyColumnOffset + '" breakpoint="' + e.data.prettyColumnBreackpoint + '"]' + e.data.prettyColumnContent + '[/prettycol]');
									}
								});
							}
						}
					]
				}
			]
		});
	});
})();