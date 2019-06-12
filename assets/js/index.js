jQuery(document).on('hover', '#twitter_feeds .twitter_feeds_inner .feed', function(e){
	jQuery('.feed_details').css({
		opacity: 0,
		width: 0,
		height: 0,
	});	
	
	var details = jQuery(this).find('.feed_details');
	var twitter_feed = jQuery('#twitter_feeds');
	var twitter_offset = twitter_feed.offset();
	var twitter_height = twitter_feed.height();
	var twitter_width = twitter_feed.width();
	
	var twitter_pX = twitter_offset.left + twitter_width;
	var twitter_pY = twitter_offset.top + twitter_height;
	
	details.css({
		width: 'auto',
		height: 'auto'
	});
	
	var details_offset = details.offset();
	var autoWidth = details.width();
	var autoHeight = details.height();								
			
	var details_pX = details_offset.left + autoWidth;
	var details_pY = details_offset.top + autoHeight;	

	
	if(twitter_pY < details_pY){
		details.css({
			bottom: 40,
		});
	}
	
	if(twitter_pX < details_pX){
		details.css({
			right: 20,
		});
	}
	
	details.css({
		width: 'auto',
		height: 'auto'
	});	
	
	autoWidth = details.width();
	autoHeight = details.height();								
					
	details.css({
		width: 0,
		height: 0,
	});	
	
	if(e.type == 'mouseenter'){
		details.css({
			opacity: 1,
		}).animate({
			height: autoHeight,
			width: autoWidth,
		}, 'slow');					
	}
});