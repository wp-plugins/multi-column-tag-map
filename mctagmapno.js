jQuery(document).ready(function() { 
  jQuery('ul.links li.hideli').hide();
  jQuery('ul.links li.morelink').show();
  jQuery('a.more').click(function() {
	jQuery(this).parent().siblings('li.hideli').slideToggle('fast');
	 jQuery(this).parent('li.morelink').remove();
  });
});