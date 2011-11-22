jQuery(document).ready(function() { 
  jQuery('a.less').hide();
  jQuery('ul.links li.hideli').hide();
  jQuery('ul.links li.morelink').show();
  jQuery('a.more').click(function() {
	jQuery(this).parent().siblings('li.hideli').slideToggle('fast');
	 jQuery(this).parent('li.morelink').children('a.less').show();
	 jQuery(this).hide();
  });
    jQuery('a.less').click(function() {
	jQuery(this).parent().siblings('li.hideli').slideToggle('fast');
	 jQuery(this).parent('li.morelink').children('a.more').show();
	 jQuery(this).hide();
  });
});