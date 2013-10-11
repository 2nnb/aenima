/* SORTING */ 

jQuery(function(){
  var $container = $('.portfolio_block');

  $container.isotope({
	itemSelector : '.element'
  });
    
  var $optionSets = $('#options .optionset'),
	  $optionLinks = $optionSets.find('a');

  $optionLinks.click(function(){
	var $this = $(this);
	// don't proceed if already selected
	if ( $this.parent('li').hasClass('selected') ) {
	  return false;
	}
	var $optionSet = $this.parents('.optionset');
	$optionSet.find('.selected').removeClass('selected');
	$optionSet.find('.fltr_before').removeClass('fltr_before');
	$optionSet.find('.fltr_after').removeClass('fltr_after');
	$this.parent('li').addClass('selected');
	$this.parent('li').next('li').addClass('fltr_after');
	$this.parent('li').prev('li').addClass('fltr_before');

	// make option object dynamically, i.e. { filter: '.my-filter-class' }
	var options = {},
		key = $optionSet.attr('data-option-key'),
		value = $this.attr('data-option-value');
	// parse 'false' as false boolean
	value = value === 'false' ? false : value;
	options[ key ] = value;
	if ( key === 'layoutMode' && typeof changeLayoutMode === 'function' ) {
	  // changes in layout modes need extra logic
	  changeLayoutMode( $this, options )
	} else {
	  // otherwise, apply new options
	  $container.isotope(options);	  
	}	
	return false;	
  });
	$('.masonry').find('img').load(function(){
		$container.isotope('reLayout');
	}); 	
});

jQuery.fn.portfolio_addon = function(addon_options) {
	//Set Variables
	var addon_el = jQuery(this),
		addon_base = this,
		img_count = addon_options.items.length,
		img_per_load = addon_options.load_count,
		$newEls = '',
		loaded_object = '',
		$container = jQuery('.image-grid');
	
	jQuery('.btn_load_more').click(function(){
		$newEls = '';
		loaded_object = '';									   
		loaded_images = $container.find('.added').size();
		if ((img_count - loaded_images) > img_per_load) {
			now_load = img_per_load;
		} else {
			now_load = img_count - loaded_images;
		}
		
		if ((loaded_images + now_load) == img_count) jQuery(this).fadeOut();

		if (loaded_images < 1) {
			i_start = 1;
		} else {
			i_start = loaded_images+1;
		}

		if (now_load > 0) {
			if (addon_options.type == 0) {
				//1 Column Portfolio Type
				for (i = i_start-1; i < i_start+now_load-1; i++) {
					loaded_object = loaded_object + '<div data-category="'+ addon_options.items[i].category +'" class="'+ addon_options.items[i].category +' element row-fluid added"><div class="filter_img span6"><div class="wrapped_img"><a href="'+ addon_options.items[i].post_zoom +'" class="prettyPhoto" rel="prettyPhoto[portfolio1]"><img src="'+ addon_options.items[i].src +'" alt="" width="570" height="340"></a></div></div><div class="portfolio_dscr span6"><div class="bg_title"><h4><a href="'+ addon_options.items[i].url +'">'+ addon_options.items[i].title +'</a></h4></div>'+ addon_options.items[i].description +'</div></div>';
				}
			} else if (addon_options.type == 2) {
				//2-4 Columns Portfolio Shaped
				for (i = i_start-1; i < i_start+now_load-1; i++) {
					loaded_object = loaded_object + '<div data-category="'+ addon_options.items[i].category +'" class="'+ addon_options.items[i].category +' element added">                                                    	<div class="filter_img"><div class="wrapped_img  portfolio_item"><img src="'+ addon_options.items[i].src +'" alt="" width="570" height="570"><div class="portf_shape"></div><div class="portfolio_descr"><div class="portfolio_title"><h6><a href="'+ addon_options.items[i].url +'">'+ addon_options.items[i].title +'</a></h6></div><div class="portfolio_text">'+ addon_options.items[i].description +'</div><div class="portfolio_btns"><a href="'+ addon_options.items[i].post_zoom +'" class="prettyPhoto zoom_ico" rel="prettyPhoto[portfolio1]">zoom</a><a href="'+ addon_options.items[i].url +'" class="link_ico">link</a></div></div></div></div></div>';

				}
			} else {
				//2-4 Columns Simple Portfolio Type
				for (i = i_start-1; i < i_start+now_load-1; i++) {
					loaded_object = loaded_object + '<div data-category="'+ addon_options.items[i].category +'" class="'+ addon_options.items[i].category +' element added">                                                    	<div class="filter_img"><div class="wrapped_img  portfolio_item"><img src="'+ addon_options.items[i].src +'" alt="" width="570" height="340"><div class="portfolio_descr"><div class="portfolio_title"><h6><a href="'+ addon_options.items[i].url +'">'+ addon_options.items[i].title +'</a></h6></div><div class="portfolio_text">'+ addon_options.items[i].description +'</div><div class="portfolio_btns"><a href="'+ addon_options.items[i].post_zoom +'" class="prettyPhoto zoom_ico" rel="prettyPhoto[portfolio1]">zoom</a><a href="'+ addon_options.items[i].url +'" class="link_ico">link</a></div></div></div></div></div>';

				}
			}
			$newEls = jQuery(loaded_object);
			$container.isotope('insert', $newEls, function() {
				$container.isotope('reLayout');
				
				jQuery('.prettyPhoto').prettyPhoto();
				jQuery('.portfolio_item').each(function(){
					jQuery(this).find('.portfolio_descr').css('top', (jQuery(this).find('img').height()-jQuery(this).find('.portfolio_descr').height())/2);										
				});					
			});			
		}
	});
}
