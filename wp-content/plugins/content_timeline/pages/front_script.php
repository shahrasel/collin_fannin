<?php
$frontHtml .= '

<script type="text/javascript">
(function($){
var test = false;
$(window).load(function() {
	if(!test)
		timeline_init_'.$id.'($(document));
});	
function timeline_init_'.$id.'($this) {
	$this.find(".scrollable-content").mCustomScrollbar();
	$this.find("a[rel^=\'prettyPhoto\']").prettyPhoto();
	
	$this.find("#tl'.$id.'").timeline({
		itemMargin : '. $settings['item-margin'].',
		scrollSpeed : '.$settings['scroll-speed'].',
		easing : "'.$settings['easing'].'",
		openTriggerClass : '.$read_more.',
		swipeOn : '.$swipeOn.',
		startItem : "'. (!empty($start_item) ? $start_item : 'last') . '",
		yearsOn : '.(($settings['hide-years'] || $settings['cat-type'] == 'categories') ? 'false' :  'true').',
		hideTimeline : '.($settings['hide-line'] ? 'true' : 'false').',
		hideControles : '.($settings['hide-nav'] ? 'true' : 'false').',
		closeText : "'.$settings['close-text'].'"'.
		$cats.',
		closeItemOnTransition: '.($settings['item-transition-close'] ? 'true' : 'false').'
	});
	
	$this.find("#tl'.$id.'").on("ajaxLoaded.timeline", function(e){
		var scrCnt = e.element.find(".scrollable-content");
		scrCnt.height(scrCnt.parent().height() - scrCnt.parent().children("h2").height() - parseInt(scrCnt.parent().children("h2").css("margin-bottom")));
		scrCnt.mCustomScrollbar({theme:"light-thin"});
		e.element.find("a[rel^=\'prettyPhoto\']").prettyPhoto();
		e.element.find(".timeline_rollover_bottom").timelineRollover("bottom");
	});
}
})(jQuery);
</script>';
?>