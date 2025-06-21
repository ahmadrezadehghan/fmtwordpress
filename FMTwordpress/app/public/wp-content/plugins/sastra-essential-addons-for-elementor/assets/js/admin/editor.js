( function( $ ) {//TODO: manage comments

	"use strict";

	var panelMutationObserver = new MutationObserver(function(mutations) {
		// Prevent Bubble up on Section Click
		$('.elementor-control-type-section').on( 'click', function( event ) {
			var current = $(this),
			attrClass = current.attr( 'class' ),
			firstIndex = attrClass.indexOf( 'elementor-control-section_' ),
			lastIndex = attrClass.indexOf( 'elementor-control-type-section' ) - 1,
			sectionClass = attrClass.substring( firstIndex, lastIndex );

			setTimeout( function() {
                if ( $('.'+ sectionClass).length != 0 ){
				    $( '#elementor-panel-content-wrapper' ).scrollTop( $('.'+ sectionClass).offset().top - 100 );
                }
			}, 10 );
		});

		// Elementor Search Input
		if ( $('#elementor-panel-elements-search-input').length ) {
			var searchTimeout = null;  
			
			$('#elementor-panel-elements-search-input').on( 'keyup', function(e) {
				if ( e.which === 13 ) {
					return false;
				}

				if (searchTimeout != null) {
					clearTimeout(searchTimeout);
				}

				if (tmpcoder_config.is_key_expire){

				    var titlesToHide = ['Custom Field', 'Product Filters', 'Category Grid', 'Woo Category Grid', 'Compare Table', 'Mini Compare', 'Compare Button', 'Wishlist Table', 'Mini Wishlist', 'Wishlist Button', 'Product Breadcrumbs', 'My Account', 'Cart Page', 'Checkout Page'];

				    $('.elementor-element-wrapper').each(function() {
				        var widgetTitle = $(this).find('.title').text().trim();
				        if (titlesToHide.indexOf(widgetTitle) !== -1 && !$(this).hasClass('elementor-element--promotion')) {
				            $(this).remove();
				        }
				    });
				}

				searchTimeout = setTimeout(function() {
					searchTimeout = null;

					var searchVal = $('#elementor-panel-elements-search-input').val();

					if ( searchVal.includes('par') && $('.tmpcoder-elementor-search-notice').length < 1 ) {
						$('#elementor-panel-elements-wrapper').prepend('\
							<div class="tmpcoder-elementor-search-notice">\
							<strong>Parallax Background</strong> is only available for the Section elements. <strong>Edit any section</strong> > <strong>"Styles"</strong> tab > <strong>"Parallax - Spexo Addons for Elementor"</strong>.\
							</div>\
						');
					}
				}, 1000);
			});
		}
		if (tmpcoder_config.is_key_expire){
			$('#elementor-panel-category-tmpcoder-premium-widgets').remove();
		}	

		// Promote Premium Widgets
		// if ( $('#elementor-panel-category-tmpcoder-widgets').length ) {
			$('.elementor-element--promotion').on('click', function() {
				var dialogButton  = $('.dialog-button');
				var dialogMessage = $('.dialog-message');

				if ( $(this).find('.tmpcoder-icon').length ) {

					dialogButton.hide();
					$('.tmpcoder-see-it-in-action').remove();
					$('.tmpcoder-see-it-in-action-upgrade').remove();
					$('.tmpcoder-upgrade-dynamic-content').remove();

					var url = '',
					upgradeURL = tmpcoder_config.TMPCODER_PURCHASE_PRO_URL,
					demoURL = tmpcoder_config.TMPCODER_DEMO_IMPORT_API,
					upgradeText = 'Upgrade to Pro',
					title = $(this).find('.title').text();

					if ( title === 'My Account') {
						url += demoURL+'fashion-v1/my-account-fashion-v1/?ref=tmpcoder-plugin-panel-pro-widgets-myacc-seeitinaction';
						upgradeURL = upgradeURL+'?ref=tmpcoder-plugin-panel-pro-widgets-myacc-upgrade-pro#purchasepro';
					} else if ( title === 'Woo Category Grid') {
						url += demoURL+'fashion-v1/?ref=tmpcoder-plugin-panel-pro-widgets-catgrid-seeitinaction#catgridprev';
						upgradeURL = upgradeURL+'?ref=tmpcoder-plugin-panel-pro-widgets-catgrid-upgrade-pro#purchasepro';
					} else if ( title === 'Product Filters') {
						url += demoURL+'fashion-v1/shop-fashion-v1/?ref=tmpcoder-plugin-panel-pro-widgets-prodfilters-seeitinaction';
						upgradeURL = upgradeURL+'?ref=tmpcoder-plugin-panel-pro-widgets-prodfilters-upgrade-pro#purchasepro';
					} else if ( title === 'Product Breadcrumbs') {
						url += demoURL+'fashion-v1/product/mans-bluish-hoodie/?ref=tmpcoder-plugin-panel-pro-widgets-breadcru-seeitinaction';
						upgradeURL = upgradeURL+'?ref=tmpcoder-plugin-panel-pro-widgets-breadcru-upgrade-pro#purchasepro';
					} else if ( title === 'Wishlist Button') {
						url += demoURL+'fashion-v2/shop-fashion-v2/?ref=tmpcoder-plugin-panel-pro-widgets-wishbutt-seeitinaction';
						upgradeURL = upgradeURL+'?ref=tmpcoder-plugin-panel-pro-widgets-wishbutt-upgrade-pro#purchasepro';
					} else if ( title === 'Mini Wishlist') {
						url += demoURL+'fashion-v2/shop-fashion-v2/?ref=tmpcoder-plugin-panel-pro-widgets-miniwish-seeitinaction';
						upgradeURL = upgradeURL+'?ref=tmpcoder-plugin-panel-pro-widgets-miniwish-upgrade-pro#purchasepro';
					} else if ( title === 'Wishlist Table') {
						url += demoURL+'fashion-v2/shop-fashion-v2/?ref=tmpcoder-plugin-panel-pro-widgets-wishtable-seeitinaction';
						upgradeURL = upgradeURL+'?ref=tmpcoder-plugin-panel-pro-widgets-wishtable-upgrade-pro#purchasepro';
					} else if ( title === 'Compare Button') {
						url += demoURL+'fashion-v2/shop-fashion-v2/?ref=tmpcoder-plugin-panel-pro-widgets-compbutt-seeitinaction';
						upgradeURL = upgradeURL+'?ref=tmpcoder-plugin-panel-pro-widgets-compbutt-upgrade-pro#purchasepro';
					} else if ( title === 'Mini Compare') {
						url += demoURL+'fashion-v2/shop-fashion-v2/?ref=tmpcoder-plugin-panel-pro-widgets-minicomp-seeitinaction';
						upgradeURL = upgradeURL+'?ref=tmpcoder-plugin-panel-pro-widgets-minicomp-upgrade-pro#purchasepro';
					} else if ( title === 'Compare Table') {
						url += demoURL+'fashion-v2/shop-fashion-v2/?ref=tmpcoder-plugin-panel-pro-widgets-comptable-seeitinaction';
						upgradeURL = upgradeURL+'?ref=tmpcoder-plugin-panel-pro-widgets-comptable-upgrade-pro#purchasepro';
					} else if ( title == 'Post Breadcrumbs') {
						url += demoURL+'construction-v3/2023/04/01/experience-quality-craftsmanship-with-our-construction-team/?ref=tmpcoder-plugin-panel-pro-widgets-postbreadcru-seeitinaction';
						upgradeURL = upgradeURL+'?ref=tmpcoder-plugin-panel-pro-widgets-postbreadcru-upgrade-pro#purchasepro';
					} else if ( title  == 'Category Grid' ) {
						url += demoURL+'fashion-v1/?ref=tmpcoder-plugin-panel-pro-widgets-catgrid-seeitinaction#catgridprev';
						upgradeURL = upgradeURL+'?ref=tmpcoder-plugin-panel-pro-widgets-catgrid-upgrade-pro#purchasepro';
					} else if ( title  == 'Custom Field' ) {
						url += demoURL+'job-listing-v1/tmpcoder_job_listing/mail-convertor/?ref=tmpcoder-plugin-panel-pro-widgets-catgrid-seeitinaction';
						upgradeURL = upgradeURL+'?ref=tmpcoder-plugin-panel-pro-widgets-catgrid-upgrade-pro#purchasepro';
					}

					if (tmpcoder_config.is_key_expire){
						dialogMessage.text(tmpcoder_config.expire_notice);
						upgradeText = tmpcoder_config.renew_button_text;
						upgradeURL  = tmpcoder_config.TMPCODER_PURCHASE_PRO_URL+'?ref=spexo-addons-pro-renewal';
					}

					if ( !dialogButton.next('a').length ) {
						dialogButton.after('<a href="'+ upgradeURL +'" target="_blank" class="tmpcoder-see-it-in-action-upgrade e-accent dialog-button elementor-button">'+ upgradeText +'</a>');
					} else {
						$('.tmpcoder-see-it-in-action').attr('href', url);
					}

					$('.tmpcoder-see-it-in-action').css({
						'display' : 'block',
						'margin-bottom' : '12px'
					});
				} else {
					dialogButton.show();
					dialogButton.next('a').hide();
					$('.dialog-buttons-wrapper').find('a').hide();
				}
			});
		// }

		// Promote Dynamic Tags
		$('.elementor-control-dynamic-switcher').on('click', function() {
			$('.tmpcoder-see-it-in-action').remove();
			$('.tmpcoder-see-it-in-action-upgrade').remove();
			$('.tmpcoder-upgrade-dynamic-content').remove();

			let defaultText = 'Create more personalized and dynamic sites by populating data from various sources with dozens of dynamic tags to choose from.';
			let customText = '<br><br> Dynamic Content functionality is available for <strong>Spexo Addons for Elementor</strong> plugin as well as for <strong>Elementor Pro</strong> plugin.';

			$('.dialog-buttons-widget .dialog-message').html('');
			$('.dialog-buttons-widget .dialog-message').html(defaultText + customText);

			let dialogButton = $('.dialog-buttons-widget .dialog-button'),
				url = tmpcoder_config.TMPCODER_PURCHASE_PRO_URL+'?ref=tmpcoder-plugin-panel-dynamic-content-banner-upgrade-pro#purchasepro';

			dialogButton.text('Upgrade Elementor');
			dialogButton.after('<div class="tmpcoder-upgrade-dynamic-content"><div style="margin:8px 0 20px;">OR</div><a href="'+ url +'" target="_blank" style="display:block; margin-bottom: 10px; padding:9px 22px;background: #046bd2;" class="dialog-button elementor-button elementor-button-success">Upgrade Spexo Addons for Elementor Pro</a></div>');
			dialogButton.next('a').css('display', 'block');
		});
	});

	// Listen to Elementor Panel Changes
	panelMutationObserver.observe($('#elementor-panel')[0], {
	  childList: true,
	  subtree: true,
	});

	// Make our custom css visible in the panel's front-end
	elementor.hooks.addFilter( 'editor/style/styleText', function( css, context ) {
		if ( ! context ) {
			return;
		}

		var model = context.model,
			customCSS = model.get('settings').get('tmpcoder_custom_css');
		var selector = '.elementor-element.elementor-element-' + model.get('id');
		
		if ( 'document' === model.get('elType') ) {
			selector = elementor.config.document.settings.cssWrapperSelector;
		}

		if ( customCSS ) {
			css += customCSS.replace(/selector/g, selector);
		}

		return css;
	});
	
	// Shortcode Widget: Select Template
	function selectShortcodeTemplate( model, e, select, textarea ) {
			var shortcode = model.attributes.settings.attributes.shortcode,
				shortcode = shortcode.replace ( /[^\d.]/g, '' );

			if ( shortcode === select.val() ) {
				return;
			}

			// Update Settings
			model.attributes.settings.attributes.shortcode = '[tmpcoder-template id="'+ select.val() +'"]';

			// Update Textarea
			textarea.val('[tmpcoder-template id="'+ select.val() +'"]');

			// Refresh Preview
			model.renderRemoteServer();
	}

 
	// TMPCODER Grid Widget: Select Element (Filter Taxonomies)
	function filterGridTaxonomies( data, value ) {
		var options = [];

		for ( var key in data ) {
			if ( key !== value ) {
				for ( var i = 0; i < data[key].length; i++ ) {
					options.push( '.elementor-control-element_select select option[value="'+ data[key][i] +'"]' );
				}
			}
		}

		// Reset
		$( 'head' ).find( '#element_select_filter_style' ).remove();

		if ( 'related' === value || 'current' === value ) {
			return;
		}

		// Append Styles
		$( 'head' ).append('<style id="element_select_filter_style">'+ options.join(',') +' { display: none !important; }</style>');	
	}

	// TMPCODER Grid Widget: Post Meta Keys (Filter by Query)
	function filterGridMetaKeys( data, value ) {
		var options = [];

		for ( var key in data ) {
			if ( key !== value ) {
				for ( var i = 0; i < data[key].length; i++ ) {
					options.push( '.select2-results__options li[data-select2-id*="-'+ data[key][i] +'"]' );
				}
			}
		}

		// Reset
		$( 'head' ).find( '#post_meta_keys_filter_style' ).remove();

		// Append Styles
		$( 'head' ).append('<style id="post_meta_keys_filter_style">'+ options.join(',') +' { display: none !important; }</style>');	
	}

	// TMPCODER Grid Widget / List style: Element Location
	function disableListLocation( value ) {
		// Reset
		$( 'head' ).find( '#list_element_location_style' ).remove();

		if ( 'list' !== value ) {
			return;
		}

		// Append Styles
		$( 'head' ).append('<style id="list_element_location_style">.elementor-control-element_location option[value="above"] { display: none !important; }</style>');	
	}

	// Grid
	elementor.hooks.addAction( 'panel/open_editor/widget/tmpcoder-grid', function( panel, model, view ) {
		var $querySource = panel.$el.find('.elementor-control-query_source').find( 'select' ),
			taxonomies = JSON.parse( panel.$el.find('.elementor-control-element_select_filter').find('input').val() ),
			metaKeys = JSON.parse( panel.$el.find('.elementor-control-post_meta_keys_filter').find('input').val() );

		// Open
		filterGridTaxonomies( taxonomies, $querySource.val() );
		filterGridMetaKeys( metaKeys, $querySource.val() );

		// Change
		$querySource.on( 'change', function() {
			filterGridTaxonomies( taxonomies, $(this).val() );
			filterGridMetaKeys( metaKeys, $(this).val() );
		});

		// Render Query Source
		panel.$el.find('#elementor-controls').on( 'DOMNodeInserted ', '.elementor-control-query_source', function(){
			$(this).find( 'select' ).on( 'change', function() {
				filterGridTaxonomies( taxonomies, $(this).val() );
				filterGridMetaKeys( metaKeys, $(this).val() );
			} );
		});

		// GOGA - Render Layout Select (Remove If extra)
		panel.$el.find('#elementor-controls').on( 'DOMNodeInserted ', '.elementor-control-layout_select', function(){
			disableListLocation( $(this).find( 'select' ).val() );

			$(this).find( 'select' ).on( 'change', function() {
				disableListLocation( $(this).val() );
			} );
		});

		// Render Grid Elements
		panel.$el.find('#elementor-controls').on( 'DOMNodeInserted ', '.elementor-control-grid_elements', function() {

			// Render Layout Select
			panel.$el.find('#elementor-controls').on( 'DOMNodeInserted ', '.elementor-control-layout_select', function(){
				disableListLocation( $(this).find( 'select' ).val() );
	
				$(this).find( 'select' ).on( 'change', function() {
					disableListLocation( $(this).val() );
				} );
			});

			$(this).find( '.elementor-control-element_select select' ).on( 'change', function() {
				var wrapper = $(this).closest( '.elementor-repeater-row-controls' );

				if ( 'lightbox' === $(this).val() ) {
					wrapper.find('.elementor-control-element_location').find( 'select' ).val( 'over' ).trigger( 'change' );
					wrapper.find('.elementor-control-element_animation').find( 'select' ).val( 'fade-in' ).trigger( 'change' );
					wrapper.find('.elementor-control-element_align_hr').find( 'input' ).eq(1).prop('checked',true).trigger( 'change' );
					wrapper.find('.elementor-control-element_lightbox_overlay').find( 'input' ).prop('checked',true).trigger( 'change' );
					wrapper.find('.elementor-control-element_extra_icon_pos').find( 'select' ).val( 'before' ).trigger( 'change' );
					setTimeout(function() {
						wrapper.find('.elementor-control-element_extra_icon_pos').addClass( 'elementor-hidden-control' );
					}, 100 );
				} else {
					wrapper.find('.elementor-control-element_extra_text_pos').find( 'select' ).val( 'none' ).trigger( 'change' );
					wrapper.find('.elementor-control-element_extra_icon_pos').find( 'select' ).val( 'none' ).trigger( 'change' );
					wrapper.find('.elementor-control-element_extra_icon_pos').removeClass( 'elementor-hidden-control' );
				}
			} );
		});

	} );

	// Image Grid
	elementor.hooks.addAction( 'panel/open_editor/widget/tmpcoder-media-grid', function( panel, model, view ) {

		// Render Grid Elements
		panel.$el.find('#elementor-controls').on( 'DOMNodeInserted ', '.elementor-control-grid_elements', function() {
			$(this).find( '.elementor-control-element_select select' ).on( 'change', function() {
				var wrapper = $(this).closest( '.elementor-repeater-row-controls' );

				if ( 'lightbox' === $(this).val() ) {
					wrapper.find('.elementor-control-element_location').find( 'select' ).val( 'over' ).trigger( 'change' );
					wrapper.find('.elementor-control-element_animation').find( 'select' ).val( 'fade-in' ).trigger( 'change' );
					wrapper.find('.elementor-control-element_align_hr').find( 'input' ).eq(1).prop('checked',true).trigger( 'change' );
					wrapper.find('.elementor-control-element_lightbox_overlay').find( 'input' ).prop('checked',true).trigger( 'change' );
					wrapper.find('.elementor-control-element_extra_icon_pos').find( 'select' ).val( 'before' ).trigger( 'change' );
					setTimeout(function() {
						wrapper.find('.elementor-control-element_extra_icon_pos').addClass( 'elementor-hidden-control' );
					}, 100 );
				} else {
					wrapper.find('.elementor-control-element_extra_text_pos').find( 'select' ).val( 'none' ).trigger( 'change' );
					wrapper.find('.elementor-control-element_extra_icon_pos').find( 'select' ).val( 'none' ).trigger( 'change' );
					wrapper.find('.elementor-control-element_extra_icon_pos').removeClass( 'elementor-hidden-control' );
				}
			} );
		});
	} );

	// Woo Grid
	elementor.hooks.addAction( 'panel/open_editor/widget/tmpcoder-woo-grid', function( panel, model, view ) {
		// Render Grid Elements
		panel.$el.find('#elementor-controls').on( 'DOMNodeInserted ', '.elementor-control-grid_elements', function() {
			$(this).find( '.elementor-control-element_select select' ).on( 'change', function() {
				var wrapper = $(this).closest( '.elementor-repeater-row-controls' );

				if ( 'lightbox' === $(this).val() ) {
					wrapper.find('.elementor-control-element_location').find( 'select' ).val( 'over' ).trigger( 'change' );
					wrapper.find('.elementor-control-element_animation').find( 'select' ).val( 'fade-in' ).trigger( 'change' );
					wrapper.find('.elementor-control-element_align_hr').find( 'input' ).eq(1).prop('checked',true).trigger( 'change' );
					wrapper.find('.elementor-control-element_lightbox_overlay').find( 'input' ).prop('checked',true).trigger( 'change' );
					wrapper.find('.elementor-control-element_extra_icon_pos').find( 'select' ).val( 'before' ).trigger( 'change' );
					setTimeout(function() {
						wrapper.find('.elementor-control-element_extra_icon_pos').addClass( 'elementor-hidden-control' );
					}, 100 );
				} else {
					wrapper.find('.elementor-control-element_extra_text_pos').find( 'select' ).val( 'none' ).trigger( 'change' );
					wrapper.find('.elementor-control-element_extra_icon_pos').find( 'select' ).val( 'none' ).trigger( 'change' );
					wrapper.find('.elementor-control-element_extra_icon_pos').removeClass( 'elementor-hidden-control' );
				}
			} );
		});

	} );

	// Refresh Mega Menu
	elementor.hooks.addAction( 'panel/open_editor/widget/tmpcoder-mega-menu', function( panel, model, view ) {
		model.renderRemoteServer();
	});

	// Get Referrer Link
	var referrer = document.referrer;

	// Return to Plugin Page
	if ( '' !== referrer && referrer.indexOf( 'page=tmpcoder-addons' ) > -1 ) {
		$(window).on( 'load', function() {

			$('#elementor-panel-header-menu-button').on( 'click', function() {

				setTimeout(function() {
					$('.elementor-panel-menu-item-exit-to-dashboard').on( 'click', function() {
						referrer = TmpcodersanitizeURL(referrer)
						window.location.href = referrer;
					});
				}, 300);
			});
		});
	}

	/*--------------------------------------------------------------
	== Widget Preview and Library buttons
	--------------------------------------------------------------*/

	for (const [key, value] of Object.entries(tmpcoder_config.tmpcoder_registered_modules)) {
		elementor.hooks.addAction( 'panel/open_editor/widget/tmpcoder-'+ value[0], function( panel, model, view ) {
			openPedefinedStyles( panel.$el, view.$el, value[0], value[1], value[2] );
		} );
	}

	function openPedefinedStyles( panel, preview, widget, url, filter ) {
		panel.on( 'click', '.elementor-control-tmpcoder_library_buttons .elementor-control-raw-html div a:first-child', function() {
			var theme = $(this).data('theme');
			$(this).attr('href', url +'?ref=tmpcoder-plugin-panel-'+ widget +'-utmtr'+ theme.slice(0,3) +'nkbs'+ theme.slice(3,theme.length) +'-preview'+ filter);
		});

		panel.on( 'click', '.elementor-control-tmpcoder_library_buttons .elementor-control-raw-html div a:last-child', function() {
			preview.closest('body').find('#tmpcoder-library-btn').attr('data-filter', widget);
			preview.closest('body').find('#tmpcoder-library-btn').trigger('click');
		});
	}

    $( window ).on( 'elementor:init', function(){
        $('.elementor-control-cf7_templates_label').hide();
        $('.elementor-control-cf7_templates_label [data-setting="cf7_templates_label"]').val( $('.elementor-control-cf7_templates [data-setting="cf7_templates"]').find(":selected").text() );
    });
    
    $(document).on('change focus', '.elementor-control-cf7_templates [data-setting="cf7_templates"]', function(){
        $('.elementor-control-cf7_templates_label [data-setting="cf7_templates_label"]').val( $(this).find(":selected").text() );
    });

 	$(document).on('change focus', '.elementor-control-query_tax_selection [data-setting="query_tax_selection"]', function(){
        $('.elementor-control-query_exclude_cats .elementor-control-type-tmpcoder-ajaxselect2').attr('data-query-slug', $('.elementor-control-query_tax_selection [data-setting="query_tax_selection"]').val());
    });

	$('.elementor-control-query_exclude_cats .elementor-control-type-tmpcoder-ajaxselect2').attr('data-query-slug', $(this).val());

}( jQuery ) );

( function( $ ) {
	'use strict';
	var TmpcoderMegaMenuEditor = {
		activeSection: false,
		currentElement: false,
		currentSection: false,
		prevSection: false,
		init: function() {
			elementor.channels.editor.on( 'section:activated', TmpcoderMegaMenuEditor.sectionActivated );
		},
		sectionActivated: function( sectionName, editor ) {
			let currentElement = TmpcoderMegaMenuEditor.currentElement = editor.getOption( 'editedElementView' ) || false;
			if ( ! currentElement ) {
				return;
			}
			if ( 'tmpcoder-mega-menu' == currentElement.model.get( 'widgetType' ) ) {
				// if ( 'section_general' === sectionName ) {}
				// currentElement.model.renderRemoteServer();
			}
		}
	};

	$( window ).on( 'elementor:init', TmpcoderMegaMenuEditor.init );
	window.TmpcoderMegaMenuEditor = TmpcoderMegaMenuEditor;
}( jQuery ) );

jQuery(document).ready(function($) {
    const iframe = $('iframe');
    if (iframe.length) {
        iframe.on('load', function() {
            const header = iframe.contents().find('.tmpcoder-before-header-content-editor [data-elementor-type="wp-post"]');
            const footer = iframe.contents().find('.tmpcoder-before-footer-content-editor [data-elementor-type="wp-post"]');
            
            if (header.length) {
				const headerId = header.data('elementor-id');
				header.css('border', '1px solid transparent');
                const editHeaderButton = $('<button class="tmpcoder-edit-header-layout-btn" title="'+tmpcoder_config.header_editor_btn_text_title+'"><i class="fas fa-pencil-alt"></i> '+tmpcoder_config.header_editor_btn_text+'</button>');
                editHeaderButton.css({
                	position: 'absolute',
                    top: '0',
                    fontSize:'12px',
                    fontFamily:'Roboto, Arial, Helvetica, Verdana, sans-serif',
                    left: '50%',
                    transform:'translateX(-50%)',
                    padding: '3px 8px',
                    border: 'none',
                    background:'#fcb92c', 
                    color:'#fff',
                    borderRadius: '0px 0px 3px 3px',
                    cursor: 'pointer',
                    zIndex: '99999',
                    display: 'none',
                });
                header.on('mouseenter', function() {
                    editHeaderButton.show();
					header.css('border', '1px solid #fcb92c');
                }).on('mouseleave', function() {
					editHeaderButton.hide();
					header.css('border', '1px solid transparent');
                });

                editHeaderButton.on('click', function() {
                    window.open('post.php?post='+headerId+'&action=elementor', '_blank');
                });

                header.css('position', 'relative').append(editHeaderButton);
            }

			if (footer.length) {
				footer.css('border', '1px solid transparent');
        	 	const footerId = footer.data('elementor-id');
                const editFooterButton = $('<button class="tmpcoder-edit-header-layout-btn" title="'+tmpcoder_config.footer_editor_btn_text_title+'"><i class="fas fa-pencil-alt"></i> '+tmpcoder_config.footer_editor_btn_text+'</button>').css({
                    position: 'absolute',
                    top: '0',
                    fontSize:'12px',
                    fontFamily:'Roboto, Arial, Helvetica, Verdana, sans-serif',
                    left: '50%',
                    transform:'translateX(-50%)',
                    padding: '3px 8px',
                    border: 'none',
                    background:'#fcb92c', 
                    color:'#fff',
                    borderRadius: '0px 0px 3px 3px',
                    cursor: 'pointer',
                    zIndex: '99999',
                    display: 'none',
                });

                footer.on('mouseenter', function() {
					editFooterButton.show();
					footer.css('border', '1px solid #fcb92c');
				}).on('mouseleave', function () {
					footer.css('border', '1px solid transparent');
                    editFooterButton.hide();
                });

                editFooterButton.on('click', function() {
                    window.open('post.php?post='+footerId+'&action=elementor', '_blank');
                });

                footer.css('position', 'relative').append(editFooterButton);
            }

            const single_layout = iframe.contents().find('.tmpcoder-before-single-post-content-editor [data-elementor-type="wp-post"]:first');

            if (single_layout.length) {
				single_layout.css('border', '1px solid transparent');
        	 	const single_layout_id = single_layout.data('elementor-id');
        	 	if (single_layout.hasClass('product')) {
        	 		tmpcoder_config.single_editor_btn_text = tmpcoder_config.single_product_editor_btn_text;
        	 		tmpcoder_config.single_editor_btn_text_title = tmpcoder_config.single_product_editor_btn_text_title;
        	 	}

                const editSingleButton = $('<button class="tmpcoder-edit-single-layout-btn" title="'+tmpcoder_config.single_editor_btn_text_title+'"><i class="fas fa-pencil-alt"></i> '+tmpcoder_config.single_editor_btn_text+'</button>').css({
                    position: 'absolute',
                    top: '0',
                    fontSize:'12px',
                    fontFamily:'Roboto, Arial, Helvetica, Verdana, sans-serif',
                    left: '50%',
                    transform:'translateX(-50%)',
                    padding: '3px 8px',
                    border: 'none',
                    background:'#fcb92c', 
                    color:'#fff',
                    borderRadius: '0px 0px 3px 3px',
                    cursor: 'pointer',
                    zIndex: '99999',
                    display: 'none',
                });
                single_layout.on('mouseenter', function() {
					single_layout.find('.tmpcoder-edit-single-layout-btn').show();
					single_layout.css('border', '1px solid #fcb92c');
                }).on('mouseleave', function() {
					single_layout.find('.tmpcoder-edit-single-layout-btn').hide();
					single_layout.css('border', '1px solid transparent');
                });

                editSingleButton.on('click', function() {
                    window.open('post.php?post='+single_layout_id+'&action=elementor', '_blank');
                });

                single_layout.css('position', 'relative').append(editSingleButton);
            }
        });
    }
});